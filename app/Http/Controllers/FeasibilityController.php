<?php

namespace App\Http\Controllers;

use App\Models\FeasibilityStudy;
use App\Models\Land;
use App\Models\PmStatusHistory;
use App\Models\Project;
use App\Models\RiskAssessment;
use App\Models\SoilInvestigation;
use App\Services\PmStatusHistoryService;
use App\Traits\TracksPmHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeasibilityController extends Controller
{
    use TracksPmHistory;

    private const STATUSES = ['Draft', 'Submitted', 'Approved', 'Rejected'];

    public function index()
    {
        return view('admin.feasibility.index', [
            'studies' => FeasibilityStudy::with('project')->orderByDesc('id')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.feasibility.create', [
            'lands' => Land::getAllData(),
            'projects' => Project::orderBy('project_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'feasibility_code' => 'required|string|max:30|unique:feasibility_studies,feasibility_code',
            'project_id' => 'required|exists:projects,id',
            'land_id' => 'required|exists:lands,id',
            'study_title' => 'required|string|max:255',
            'study_date' => 'required|date',
            'estimated_project_cost' => 'required|numeric|min:0',
            'estimated_duration_months' => 'required|integer|min:1',
            'expected_roi' => 'required|numeric',
            'recommendation' => 'required|in:Proceed,Revise,Reject',
        ]);

        try {
            $study = DB::transaction(function () use ($validated, $request) {
                $study = FeasibilityStudy::create(array_merge($validated, [
                    'prepared_by' => id() ?: 1,
                    'status' => $request->input('status', 'Draft'),
                    'remarks' => $request->input('remarks'),
                ]));

                $this->pmLogStatus(
                    PmStatusHistory::ENTITY_FEASIBILITY,
                    $study->id,
                    null,
                    $study->status,
                    'status',
                    'Feasibility study created'
                );

                return $study;
            });

            return redirect()->route('admin.feasibility.show', $study->id)->with('success', 'Feasibility study created successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error creating feasibility study.');
        }
    }

    public function show($id)
    {
        $study = FeasibilityStudy::with('project')->find($id);
        if (! $study) {
            return redirect()->route('admin.feasibility.index')->with('error', 'Feasibility study not found.');
        }

        return view('admin.feasibility.show', [
            'study' => $study,
            'soilTests' => SoilInvestigation::where('feasibility_id', $id)->get(),
            'risks' => RiskAssessment::where('feasibility_id', $id)->get(),
            'statusHistories' => PmStatusHistoryService::historiesFor(PmStatusHistory::ENTITY_FEASIBILITY, (int) $id),
        ]);
    }

    public function edit($id)
    {
        $study = FeasibilityStudy::with('project')->find($id);
        if (! $study) {
            return redirect()->route('admin.feasibility.index')->with('error', 'Feasibility study not found.');
        }

        return view('admin.feasibility.edit', [
            'study' => $study,
            'lands' => Land::getAllData(),
            'projects' => Project::orderBy('project_name')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $study = FeasibilityStudy::getDataById($id);
        if (! $study) {
            return redirect()->route('admin.feasibility.index')->with('error', 'Feasibility study not found.');
        }

        $validated = $request->validate([
            'feasibility_code' => 'required|string|max:30|unique:feasibility_studies,feasibility_code,' . $id,
            'project_id' => 'required|exists:projects,id',
            'land_id' => 'required|exists:lands,id',
            'study_title' => 'required|string|max:255',
            'study_date' => 'required|date',
            'estimated_project_cost' => 'required|numeric|min:0',
            'estimated_duration_months' => 'required|integer|min:1',
            'expected_roi' => 'required|numeric',
            'recommendation' => 'required|in:Proceed,Revise,Reject',
            'status' => 'required|in:' . implode(',', self::STATUSES),
        ]);

        $oldStatus = $study->status;
        $oldProgress = $study->progress_percentage ?? 0;

        try {
            DB::transaction(function () use ($study, $validated, $request, $oldStatus, $oldProgress, $id) {
                $study->update(array_merge($validated, [
                    'remarks' => $request->input('remarks'),
                    'progress_percentage' => $request->input('progress_percentage', $oldProgress),
                ]));

                if ($oldStatus !== $validated['status']) {
                    $this->pmLogStatus(PmStatusHistory::ENTITY_FEASIBILITY, (int) $id, $oldStatus, $validated['status'], 'status', 'Updated via edit form');
                }

                $newProgress = $request->input('progress_percentage', $oldProgress);
                if ((float) $oldProgress !== (float) $newProgress) {
                    $this->pmLogStatus(PmStatusHistory::ENTITY_FEASIBILITY, (int) $id, (string) $oldProgress, (string) $newProgress, 'progress_percentage', 'Updated via edit form');
                }
            });

            return redirect()->route('admin.feasibility.show', $id)->with('success', 'Feasibility study updated successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error updating feasibility study.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $study = FeasibilityStudy::find($id);
        if (! $study) {
            return back()->with('error', 'Feasibility study not found.');
        }

        return $this->pmUpdateStatus($request, $study, PmStatusHistory::ENTITY_FEASIBILITY, 'status', self::STATUSES);
    }

    public function updateProgress(Request $request, $id)
    {
        $study = FeasibilityStudy::find($id);
        if (! $study) {
            return back()->with('error', 'Feasibility study not found.');
        }

        return $this->pmUpdateProgress($request, $study, PmStatusHistory::ENTITY_FEASIBILITY);
    }

    public function destroy($id)
    {
        try {
            $study = FeasibilityStudy::getDataById($id);
            if ($study) {
                $study->delete();
            }

            return redirect()->route('admin.feasibility.index')->with('success', 'Feasibility study deleted successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error deleting feasibility study.', false);
        }
    }

    public function storeSoilTest(Request $request)
    {
        $validated = $request->validate([
            'feasibility_id' => 'required|exists:feasibility_studies,id',
            'test_number' => 'required|string|max:50',
            'test_date' => 'required|date',
            'testing_agency' => 'required|string|max:200',
            'soil_type' => 'required|string|max:100',
            'bearing_capacity' => 'required|numeric',
            'water_table_depth' => 'required|numeric',
        ]);

        try {
            SoilInvestigation::create(array_merge($validated, [
                'remarks' => $request->input('remarks'),
            ]));

            return redirect()->route('admin.feasibility.show', $validated['feasibility_id'])->with('success', 'Soil test added successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error adding soil test.', false);
        }
    }

    public function storeRisk(Request $request)
    {
        $validated = $request->validate([
            'feasibility_id' => 'required|exists:feasibility_studies,id',
            'risk_category' => 'required|in:Technical,Financial,Legal,Environmental,Operational',
            'risk_description' => 'required|string',
            'probability' => 'required|in:Low,Medium,High',
            'impact' => 'required|in:Low,Medium,High',
        ]);

        try {
            RiskAssessment::create(array_merge($validated, [
                'mitigation_strategy' => $request->input('mitigation_strategy'),
                'risk_owner' => id() ?: 1,
                'status' => 'Open',
            ]));

            return redirect()->route('admin.feasibility.show', $validated['feasibility_id'])->with('success', 'Risk assessment added successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error adding risk assessment.', false);
        }
    }
}
