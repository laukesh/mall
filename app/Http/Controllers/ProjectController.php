<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Land;
use App\Models\PmStatusHistory;
use App\Models\Project;
use App\Models\ProjectMilestone;
use App\Models\ProjectPhase;
use App\Models\ProjectTeam;
use App\Models\User;
use App\Services\PmStatusHistoryService;
use App\Traits\TracksPmHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    use TracksPmHistory;

    public function index()
    {
        return view('admin.project.index', ['projects' => Project::orderByDesc('id')->get()]);
    }

    public function create()
    {
        return view('admin.project.create', [
            'clients' => Client::orderBy('client_name')->get(),
            'managers' => User::getAll(),
            'lands' => Land::whereNull('project_id')->orderBy('land_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_code' => 'required|string|max:30|unique:projects,project_code',
            'project_name' => 'required|string|max:200',
            'client_id' => 'required|exists:clients,id',
            'project_type' => 'required|in:Residential,Commercial,Industrial,Infrastructure',
            'status' => 'required|in:Planning,Active,On Hold,Completed,Cancelled',
            'land_ids' => 'nullable|array',
            'land_ids.*' => 'exists:lands,id',
        ]);

        try {
            $project = DB::transaction(function () use ($validated, $request) {
                $project = Project::create(array_merge($validated, [
                    'location' => $request->input('location'),
                    'city' => $request->input('city'),
                    'state' => $request->input('state'),
                    'country' => $request->input('country', 'India'),
                    'project_manager_id' => $request->input('project_manager_id') ?: null,
                    'planned_start_date' => $request->input('planned_start_date'),
                    'planned_end_date' => $request->input('planned_end_date'),
                    'estimated_cost' => $request->input('estimated_cost'),
                    'approved_budget' => $request->input('approved_budget'),
                    'remarks' => $request->input('remarks'),
                    'created_by' => id() ?: 1,
                ]));

                $this->syncProjectLands($project->id, $request->input('land_ids', []));

                PmStatusHistoryService::log(
                    PmStatusHistory::ENTITY_PROJECT,
                    $project->id,
                    null,
                    $project->status,
                    'status',
                    'Project created'
                );

                return $project;
            });

            return redirect()->route('admin.project.index')->with('success', 'Project created successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error creating project.');
        }
    }

    public function show($id)
    {
        $project = Project::getDataById($id);
        if (!$project) {
            return redirect()->route('admin.project.index')->with('error', 'Project not found.');
        }

        return view('admin.project.show', [
            'project' => $project,
            'phases' => ProjectPhase::where('project_id', $id)->orderBy('sequence_no')->get(),
            'milestones' => ProjectMilestone::where('project_id', $id)->get(),
            'team' => ProjectTeam::where('project_id', $id)->get(),
            'users' => User::getAll(),
            'lands' => Land::where('project_id', $id)->get(),
            'statusHistories' => PmStatusHistoryService::historiesFor(PmStatusHistory::ENTITY_PROJECT, (int) $id),
        ]);
    }

    public function edit($id)
    {
        $project = Project::getDataById($id);
        if (!$project) {
            return redirect()->route('admin.project.index')->with('error', 'Project not found.');
        }

        $assignedLandIds = Land::where('project_id', $id)->pluck('id')->all();

        return view('admin.project.edit', [
            'project' => $project,
            'clients' => Client::orderBy('client_name')->get(),
            'managers' => User::getAll(),
            'lands' => Land::where(function ($q) use ($id) {
                $q->whereNull('project_id')->orWhere('project_id', $id);
            })->orderBy('land_name')->get(),
            'selectedLandIds' => $assignedLandIds,
        ]);
    }

    public function update(Request $request, $id)
    {
        $project = Project::getDataById($id);
        if (!$project) {
            return redirect()->route('admin.project.index')->with('error', 'Project not found.');
        }

        $validated = $request->validate([
            'project_code' => 'required|string|max:30|unique:projects,project_code,' . $id,
            'project_name' => 'required|string|max:200',
            'client_id' => 'required|exists:clients,id',
            'project_type' => 'required|in:Residential,Commercial,Industrial,Infrastructure',
            'status' => 'required|in:Planning,Active,On Hold,Completed,Cancelled',
            'land_ids' => 'nullable|array',
            'land_ids.*' => 'exists:lands,id',
        ]);

        $oldStatus = $project->status;
        $oldProgress = $project->progress_percentage ?? 0;

        try {
            DB::transaction(function () use ($id, $validated, $request, $oldStatus, $oldProgress) {
                Project::where('id', $id)->update(array_merge($validated, [
                    'location' => $request->input('location'),
                    'city' => $request->input('city'),
                    'state' => $request->input('state'),
                    'country' => $request->input('country', 'India'),
                    'project_manager_id' => $request->input('project_manager_id') ?: null,
                    'planned_start_date' => $request->input('planned_start_date'),
                    'planned_end_date' => $request->input('planned_end_date'),
                    'actual_start_date' => $request->input('actual_start_date'),
                    'actual_end_date' => $request->input('actual_end_date'),
                    'estimated_cost' => $request->input('estimated_cost'),
                    'approved_budget' => $request->input('approved_budget'),
                    'progress_percentage' => $request->input('progress_percentage'),
                    'remarks' => $request->input('remarks'),
                ]));

                $this->syncProjectLands((int) $id, $request->input('land_ids', []));

                if ($oldStatus !== $validated['status']) {
                    PmStatusHistoryService::log(
                        PmStatusHistory::ENTITY_PROJECT,
                        (int) $id,
                        $oldStatus,
                        $validated['status'],
                        'status',
                        'Updated via edit form'
                    );
                }

                $newProgress = $request->input('progress_percentage', $oldProgress);
                if ((float) $oldProgress !== (float) $newProgress) {
                    PmStatusHistoryService::log(
                        PmStatusHistory::ENTITY_PROJECT,
                        (int) $id,
                        (string) $oldProgress,
                        (string) $newProgress,
                        'progress_percentage',
                        'Updated via edit form'
                    );
                }
            });

            return redirect()->route('admin.project.index')->with('success', 'Project updated successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error updating project.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $project = Project::getDataById($id);
        if (!$project) {
            return back()->with('error', 'Project not found.');
        }

        $validated = $request->validate([
            'status' => 'required|in:Planning,Active,On Hold,Completed,Cancelled',
            'remarks' => 'nullable|string|max:500',
        ]);

        $oldStatus = $project->status;
        if ($oldStatus === $validated['status']) {
            return back()->with('info', 'Status is already set to ' . $validated['status'] . '.');
        }

        Project::where('id', $id)->update(['status' => $validated['status']]);

        PmStatusHistoryService::log(
            PmStatusHistory::ENTITY_PROJECT,
            (int) $id,
            $oldStatus,
            $validated['status'],
            'status',
            $validated['remarks'] ?? null
        );

        return back()->with('success', 'Project status updated.');
    }

    public function updateProgress(Request $request, $id)
    {
        $project = Project::find($id);
        if (! $project) {
            return back()->with('error', 'Project not found.');
        }

        return $this->pmUpdateProgress($request, $project, PmStatusHistory::ENTITY_PROJECT);
    }

    public function destroy($id)
    {
        try {
            Land::where('project_id', $id)->update(['project_id' => null]);
            Project::where('id', $id)->delete();
            return redirect()->route('admin.project.index')->with('success', 'Project deleted successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error deleting project.', false);
        }
    }

    public function storePhase(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'phase_name' => 'required|string|max:150',
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        ProjectPhase::create(array_merge($validated, [
            'sequence_no' => $request->input('sequence_no'),
            'planned_start_date' => $request->input('planned_start_date'),
            'planned_end_date' => $request->input('planned_end_date'),
            'remarks' => $request->input('remarks'),
        ]));

        return back()->with('success', 'Project phase added.');
    }

    public function storeTeam(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'designation' => 'nullable|string|max:100',
            'status' => 'required|in:Active,Inactive',
        ]);

        ProjectTeam::create(array_merge($validated, [
            'assigned_date' => $request->input('assigned_date') ?: now()->toDateString(),
        ]));

        return back()->with('success', 'Team member assigned.');
    }

    private function syncProjectLands(int $projectId, array $landIds): void
    {
        Land::where('project_id', $projectId)
            ->whereNotIn('id', $landIds)
            ->update(['project_id' => null]);

        if (! empty($landIds)) {
            Land::whereIn('id', $landIds)->update(['project_id' => $projectId]);
        }
    }
}
