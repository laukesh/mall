<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectMilestone;
use App\Models\ProjectPhase;
use App\Models\ProjectTeam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        return view('admin.project.index', ['projects' => Project::orderByDesc('id')->get()]);
    }

    public function create()
    {
        return view('admin.project.create', [
            'clients' => Client::orderBy('client_name')->get(),
            'managers' => User::getAll(),
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
        ]);

        try {
            DB::transaction(function () use ($validated, $request) {
                Project::create(array_merge($validated, [
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
        ]);
    }

    public function edit($id)
    {
        $project = Project::getDataById($id);
        if (!$project) {
            return redirect()->route('admin.project.index')->with('error', 'Project not found.');
        }

        return view('admin.project.edit', [
            'project' => $project,
            'clients' => Client::orderBy('client_name')->get(),
            'managers' => User::getAll(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'project_code' => 'required|string|max:30|unique:projects,project_code,' . $id,
            'project_name' => 'required|string|max:200',
            'client_id' => 'required|exists:clients,id',
            'project_type' => 'required|in:Residential,Commercial,Industrial,Infrastructure',
            'status' => 'required|in:Planning,Active,On Hold,Completed,Cancelled',
        ]);

        try {
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

            return redirect()->route('admin.project.index')->with('success', 'Project updated successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error updating project.');
        }
    }

    public function destroy($id)
    {
        try {
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
}
