<?php

namespace App\Http\Controllers;

use App\Models\MobilizationChecklist;
use App\Models\MobilizationPlan;
use App\Models\MobilizationResource;
use App\Models\Project;
use Illuminate\Http\Request;

class MobilizationController extends Controller
{
    public function index()
    {
        return view('admin.mobilization.index', [
            'plans' => MobilizationPlan::orderByDesc('id')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.mobilization.create', [
            'projects' => Project::orderBy('project_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'plan_number' => 'required|string|max:30|unique:mobilization_plans,plan_number',
            'mobilization_name' => 'required|string|max:200',
            'mobilization_type' => 'required|in:Initial,Additional,Emergency',
            'status' => 'required|in:Draft,Approved,In Progress,Completed',
        ]);

        MobilizationPlan::create(array_merge($validated, [
            'planned_start_date' => $request->input('planned_start_date'),
            'planned_end_date' => $request->input('planned_end_date'),
            'approved_by' => $request->input('approved_by') ?: null,
            'approval_date' => $request->input('approval_date'),
            'remarks' => $request->input('remarks'),
        ]));

        return redirect()->route('admin.mobilization.index')->with('success', 'Mobilization plan created.');
    }

    public function show($id)
    {
        $plan = MobilizationPlan::getDataById($id);
        if (!$plan) {
            return redirect()->route('admin.mobilization.index')->with('error', 'Plan not found.');
        }

        return view('admin.mobilization.show', [
            'plan' => $plan,
            'resources' => MobilizationResource::where('mobilization_plan_id', $id)->get(),
            'checklists' => MobilizationChecklist::where('mobilization_plan_id', $id)->get(),
        ]);
    }

    public function edit($id)
    {
        $plan = MobilizationPlan::getDataById($id);
        if (!$plan) {
            return redirect()->route('admin.mobilization.index')->with('error', 'Plan not found.');
        }

        return view('admin.mobilization.edit', [
            'plan' => $plan,
            'projects' => Project::orderBy('project_name')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'plan_number' => 'required|string|max:30|unique:mobilization_plans,plan_number,' . $id,
            'mobilization_name' => 'required|string|max:200',
            'mobilization_type' => 'required|in:Initial,Additional,Emergency',
            'status' => 'required|in:Draft,Approved,In Progress,Completed',
        ]);

        MobilizationPlan::where('id', $id)->update(array_merge($validated, [
            'planned_start_date' => $request->input('planned_start_date'),
            'planned_end_date' => $request->input('planned_end_date'),
            'approved_by' => $request->input('approved_by') ?: null,
            'approval_date' => $request->input('approval_date'),
            'remarks' => $request->input('remarks'),
        ]));

        return redirect()->route('admin.mobilization.index')->with('success', 'Mobilization plan updated.');
    }

    public function destroy($id)
    {
        MobilizationPlan::where('id', $id)->delete();
        return redirect()->route('admin.mobilization.index')->with('success', 'Mobilization plan deleted.');
    }

    public function storeResource(Request $request)
    {
        $validated = $request->validate([
            'mobilization_plan_id' => 'required|exists:mobilization_plans,id',
            'resource_type' => 'required|in:Labour,Equipment,Vehicle,Material,Tool',
            'resource_name' => 'required|string|max:150',
            'required_quantity' => 'required|numeric|min:0',
        ]);

        MobilizationResource::create(array_merge($validated, [
            'unit' => $request->input('unit'),
            'required_date' => $request->input('required_date'),
            'remarks' => $request->input('remarks'),
        ]));

        return back()->with('success', 'Resource added.');
    }

    public function storeChecklist(Request $request)
    {
        $validated = $request->validate([
            'mobilization_plan_id' => 'required|exists:mobilization_plans,id',
            'checklist_item' => 'required|string|max:200',
        ]);

        MobilizationChecklist::create(array_merge($validated, [
            'completed' => $request->boolean('completed'),
            'verified_by' => $request->input('verified_by') ?: null,
            'verified_date' => $request->input('verified_date'),
            'remarks' => $request->input('remarks'),
        ]));

        return back()->with('success', 'Checklist item added.');
    }
}
