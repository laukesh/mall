<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\Project;
use App\Models\WorkPackage;
use App\Models\WorkPackageTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkPackageController extends Controller
{
    public function index()
    {
        return view('admin.workpackage.index', [
            'packages' => WorkPackage::orderByDesc('id')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.workpackage.create', [
            'projects' => Project::orderBy('project_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_code' => 'required|string|max:30|unique:work_packages,package_code',
            'project_id' => 'required|exists:projects,id',
            'package_name' => 'required|string|max:200',
            'discipline' => 'required|in:Civil,Electrical,Plumbing,HVAC,ELV,Fire Fighting,Mechanical,Interior,Landscaping',
            'status' => 'required|in:Planned,In Progress,On Hold,Completed',
        ]);

        try {
            WorkPackage::create(array_merge($validated, [
                'description' => $request->input('description'),
                'planned_start_date' => $request->input('planned_start_date'),
                'planned_end_date' => $request->input('planned_end_date'),
                'estimated_cost' => $request->input('estimated_cost'),
                'created_by' => id() ?: 1,
            ]));

            return redirect()->route('admin.workpackage.index')->with('success', 'Work package created.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error creating work package.');
        }
    }

    public function show($id)
    {
        $package = WorkPackage::getDataById($id);
        if (!$package) {
            return redirect()->route('admin.workpackage.index')->with('error', 'Work package not found.');
        }

        return view('admin.workpackage.show', [
            'package' => $package,
            'tasks' => WorkPackageTask::where('work_package_id', $id)->get(),
            'contractors' => Contractor::where('status', 'Active')->get(),
        ]);
    }

    public function edit($id)
    {
        $package = WorkPackage::getDataById($id);
        if (!$package) {
            return redirect()->route('admin.workpackage.index')->with('error', 'Work package not found.');
        }

        return view('admin.workpackage.edit', [
            'package' => $package,
            'projects' => Project::orderBy('project_name')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'package_code' => 'required|string|max:30|unique:work_packages,package_code,' . $id,
            'project_id' => 'required|exists:projects,id',
            'package_name' => 'required|string|max:200',
            'discipline' => 'required|in:Civil,Electrical,Plumbing,HVAC,ELV,Fire Fighting,Mechanical,Interior,Landscaping',
            'status' => 'required|in:Planned,In Progress,On Hold,Completed',
        ]);

        try {
            WorkPackage::where('id', $id)->update(array_merge($validated, [
                'description' => $request->input('description'),
                'planned_start_date' => $request->input('planned_start_date'),
                'planned_end_date' => $request->input('planned_end_date'),
                'actual_start_date' => $request->input('actual_start_date'),
                'actual_end_date' => $request->input('actual_end_date'),
                'estimated_cost' => $request->input('estimated_cost'),
                'progress_percentage' => $request->input('progress_percentage'),
            ]));

            return redirect()->route('admin.workpackage.index')->with('success', 'Work package updated.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error updating work package.');
        }
    }

    public function destroy($id)
    {
        try {
            WorkPackage::where('id', $id)->delete();
            return redirect()->route('admin.workpackage.index')->with('success', 'Work package deleted.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error deleting work package.', false);
        }
    }

    public function storeTask(Request $request)
    {
        $validated = $request->validate([
            'work_package_id' => 'required|exists:work_packages,id',
            'task_code' => 'required|string|max:30',
            'task_name' => 'required|string|max:200',
            'status' => 'required|in:Pending,Running,Completed,Delayed',
        ]);

        WorkPackageTask::create(array_merge($validated, [
            'description' => $request->input('description'),
            'priority' => $request->input('priority', 'Medium'),
            'planned_start_date' => $request->input('planned_start_date'),
            'planned_end_date' => $request->input('planned_end_date'),
            'estimated_quantity' => $request->input('estimated_quantity'),
            'unit' => $request->input('unit'),
        ]));

        return back()->with('success', 'Task added to work package.');
    }
}
