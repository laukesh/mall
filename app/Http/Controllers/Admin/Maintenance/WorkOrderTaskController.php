<?php

namespace App\Http\Controllers\Admin\Maintenance;

use App\Http\Controllers\Controller;
use App\Repositories\WorkOrderTaskRepositoryInterface;
use Illuminate\Http\Request;

class WorkOrderTaskController extends Controller
{
    public function __construct(
        private readonly WorkOrderTaskRepositoryInterface $repository
    ) {}

    public function index(Request $request)
    {
        $items = $this->repository->all($request->only(['search', 'status', 'per_page']));

        return view('admin.work_order_tasks.index', compact('items'));
    }

    public function create()
    {
        return view('admin.work_order_tasks.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $item = $this->repository->create($data);

        return redirect()
            ->route('admin.work_order_tasks.show', $item->id)
            ->with('success', 'Work Order Task created successfully.');
    }

    public function show(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.work_order_tasks.show', compact('item'));
    }

    public function edit(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.work_order_tasks.edit', compact('item'));
    }

    public function update(Request $request, int $id)
    {
        $data = $this->validated($request, $id);
        $data['updated_by'] = auth()->id();

        $item = $this->repository->update($id, $data);

        return redirect()
            ->route('admin.work_order_tasks.show', $item->id)
            ->with('success', 'Work Order Task updated successfully.');
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);

        return redirect()
            ->route('admin.work_order_tasks.index')
            ->with('success', 'Work Order Task deleted successfully.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        $rules = [
            'work_order_id' => 'required|numeric',
            'task_number' => 'required|string|unique:work_order_tasks,task_number,{id}|max:30',
            'task_title' => 'required|string|max:200',
            'task_description' => 'nullable|string',
            'assigned_to' => 'nullable|numeric',
            'priority' => 'required|in:Low,Medium,High,Critical',
            'sequence_no' => 'nullable|numeric',
            'estimated_hours' => 'nullable|numeric',
            'actual_hours' => 'nullable|numeric',
            'completion_percentage' => 'nullable|numeric',
            'scheduled_start' => 'nullable|date',
            'scheduled_end' => 'nullable|date',
            'actual_start' => 'nullable|date',
            'actual_end' => 'nullable|date',
            'status' => 'required|in:Pending,Assigned,In Progress,On Hold,Completed,Cancelled',
            'completion_notes' => 'nullable|string',
        ];

        if ($id) {
            $rules = array_map(
                fn ($rule) => str_replace('{id}', (string) $id, $rule),
                $rules
            );
        } else {
            $rules = array_map(
                fn ($rule) => str_replace(',{id}', '', $rule),
                $rules
            );
        }

        return $request->validate($rules);
    }
}
