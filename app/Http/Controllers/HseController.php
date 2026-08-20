<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\PmStatusHistory;
use App\Models\PpeInventory;
use App\Models\Project;
use App\Models\SafetyInspection;
use App\Services\PmStatusHistoryService;
use App\Traits\TracksPmHistory;
use Illuminate\Http\Request;

class HseController extends Controller
{
    use TracksPmHistory;

    private const INCIDENT_STATUSES = ['Open', 'Under Investigation', 'Closed'];
    private const INSPECTION_STATUSES = ['Safe', 'Unsafe'];

    public function incidents()
    {
        return view('admin.hse.incidents', [
            'incidents' => Incident::orderByDesc('incident_date')->get(),
            'projects' => Project::orderBy('project_name')->get(),
        ]);
    }

    public function showIncident($id)
    {
        $incident = Incident::with('project')->find($id);
        if (! $incident) {
            return redirect()->route('admin.hse.incidents')->with('error', 'Incident not found.');
        }

        return view('admin.hse.incident_show', [
            'incident' => $incident,
            'statusHistories' => PmStatusHistoryService::historiesFor(PmStatusHistory::ENTITY_INCIDENT, (int) $id),
        ]);
    }

    public function storeIncident(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'incident_number' => 'required|string|max:30|unique:incidents,incident_number',
            'incident_type' => 'required|in:Near Miss,Minor Injury,Major Injury,Property Damage,Fatality',
            'incident_date' => 'required|date',
            'description' => 'required|string',
            'status' => 'required|in:' . implode(',', self::INCIDENT_STATUSES),
        ]);

        $incident = Incident::create(array_merge($validated, [
            'reported_by' => id() ?: 1,
            'location' => $request->input('location'),
            'immediate_action' => $request->input('immediate_action'),
        ]));

        $this->pmLogStatus(PmStatusHistory::ENTITY_INCIDENT, $incident->id, null, $incident->status, 'status', 'Incident reported');

        return redirect()->route('admin.hse.incident.show', $incident->id)->with('success', 'Incident reported.');
    }

    public function updateIncidentStatus(Request $request, $id)
    {
        $incident = Incident::find($id);
        if (! $incident) {
            return back()->with('error', 'Incident not found.');
        }

        return $this->pmUpdateStatus($request, $incident, PmStatusHistory::ENTITY_INCIDENT, 'status', self::INCIDENT_STATUSES);
    }

    public function updateIncidentProgress(Request $request, $id)
    {
        $incident = Incident::find($id);
        if (! $incident) {
            return back()->with('error', 'Incident not found.');
        }

        return $this->pmUpdateProgress($request, $incident, PmStatusHistory::ENTITY_INCIDENT);
    }

    public function inspections()
    {
        return view('admin.hse.inspections', [
            'inspections' => SafetyInspection::orderByDesc('inspection_date')->get(),
            'projects' => Project::orderBy('project_name')->get(),
        ]);
    }

    public function showInspection($id)
    {
        $inspection = SafetyInspection::find($id);
        if (! $inspection) {
            return redirect()->route('admin.hse.inspections')->with('error', 'Inspection not found.');
        }

        return view('admin.hse.inspection_show', [
            'inspection' => $inspection,
            'statusHistories' => PmStatusHistoryService::historiesFor(PmStatusHistory::ENTITY_SAFETY_INSPECTION, (int) $id),
        ]);
    }

    public function storeInspection(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'inspection_date' => 'required|date',
            'inspection_type' => 'required|in:Daily,Weekly,Monthly,Special',
            'overall_status' => 'required|in:' . implode(',', self::INSPECTION_STATUSES),
        ]);

        $inspection = SafetyInspection::create(array_merge($validated, [
            'inspector_id' => id() ?: 1,
            'remarks' => $request->input('remarks'),
        ]));

        $this->pmLogStatus(PmStatusHistory::ENTITY_SAFETY_INSPECTION, $inspection->id, null, $inspection->overall_status, 'overall_status', 'Inspection recorded');

        return redirect()->route('admin.hse.inspection.show', $inspection->id)->with('success', 'Safety inspection recorded.');
    }

    public function updateInspectionStatus(Request $request, $id)
    {
        $inspection = SafetyInspection::find($id);
        if (! $inspection) {
            return back()->with('error', 'Inspection not found.');
        }

        return $this->pmUpdateStatus($request, $inspection, PmStatusHistory::ENTITY_SAFETY_INSPECTION, 'overall_status', self::INSPECTION_STATUSES, 'overall_status');
    }

    public function ppe()
    {
        return view('admin.hse.ppe', [
            'ppeItems' => PpeInventory::orderBy('ppe_name')->get(),
        ]);
    }

    public function storePpe(Request $request)
    {
        $validated = $request->validate([
            'ppe_name' => 'required|string|max:100',
            'available_quantity' => 'required|integer|min:0',
            'status' => 'required|in:Available,Out of Stock',
        ]);

        PpeInventory::create(array_merge($validated, [
            'category' => $request->input('category'),
            'minimum_quantity' => $request->input('minimum_quantity', 0),
            'warehouse_id' => $request->input('warehouse_id') ?: null,
        ]));

        return back()->with('success', 'PPE inventory item added.');
    }
}
