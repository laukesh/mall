<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\PpeInventory;
use App\Models\Project;
use App\Models\SafetyInspection;
use Illuminate\Http\Request;

class HseController extends Controller
{
    public function incidents()
    {
        return view('admin.hse.incidents', [
            'incidents' => Incident::orderByDesc('incident_date')->get(),
            'projects' => Project::orderBy('project_name')->get(),
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
            'status' => 'required|in:Open,Under Investigation,Closed',
        ]);

        Incident::create(array_merge($validated, [
            'reported_by' => id() ?: 1,
            'location' => $request->input('location'),
            'immediate_action' => $request->input('immediate_action'),
        ]));

        return back()->with('success', 'Incident reported.');
    }

    public function inspections()
    {
        return view('admin.hse.inspections', [
            'inspections' => SafetyInspection::orderByDesc('inspection_date')->get(),
            'projects' => Project::orderBy('project_name')->get(),
        ]);
    }

    public function storeInspection(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'inspection_date' => 'required|date',
            'inspection_type' => 'required|in:Daily,Weekly,Monthly,Special',
            'overall_status' => 'required|in:Safe,Unsafe',
        ]);

        SafetyInspection::create(array_merge($validated, [
            'inspector_id' => id() ?: 1,
            'remarks' => $request->input('remarks'),
        ]));

        return back()->with('success', 'Safety inspection recorded.');
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
