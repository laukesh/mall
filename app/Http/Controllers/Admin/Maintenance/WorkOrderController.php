<?php

namespace App\Http\Controllers\Admin\Maintenance;

use App\Http\Controllers\Controller;
use App\Repositories\WorkOrderRepositoryInterface;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    public function __construct(
        private readonly WorkOrderRepositoryInterface $repository
    ) {}

    public function index(Request $request)
    {
        $items = $this->repository->all($request->only(['search', 'status', 'per_page']));

        return view('admin.work_orders.index', compact('items'));
    }

    public function create()
    {
        return view('admin.work_orders.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $item = $this->repository->create($data);

        return redirect()
            ->route('admin.work_orders.show', $item->id)
            ->with('success', 'Work Order created successfully.');
    }

    public function show(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.work_orders.show', compact('item'));
    }

    public function edit(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.work_orders.edit', compact('item'));
    }

    public function update(Request $request, int $id)
    {
        $data = $this->validated($request, $id);
        $data['updated_by'] = auth()->id();

        $item = $this->repository->update($id, $data);

        return redirect()
            ->route('admin.work_orders.show', $item->id)
            ->with('success', 'Work Order updated successfully.');
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);

        return redirect()
            ->route('admin.work_orders.index')
            ->with('success', 'Work Order deleted successfully.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        $rules = [
            'work_order_number' => 'required|string|unique:work_orders,work_order_number,{id}|max:30',
            'maintenance_request_id' => 'required|numeric',
            'unit_id' => 'nullable|numeric',
            'department_id' => 'nullable|numeric',
            'assigned_to' => 'nullable|numeric',
            'vendor_id' => 'nullable|numeric',
            'work_title' => 'required|string|max:200',
            'work_description' => 'required|string',
            'priority' => 'required|in:Low,Medium,High,Critical',
            'scheduled_start' => 'nullable|date',
            'scheduled_end' => 'nullable|date',
            'actual_start' => 'nullable|date',
            'actual_end' => 'nullable|date',
            'estimated_cost' => 'nullable|numeric',
            'actual_cost' => 'nullable|numeric',
            'completion_percentage' => 'nullable|numeric',
            'status' => 'required|in:Draft,Assigned,Scheduled,In Progress,On Hold,Completed,Verified,Cancelled',
            'completion_notes' => 'nullable|string',
            'verification_notes' => 'nullable|string',
            'verified_by' => 'nullable|numeric',
            'verified_at' => 'nullable|date',
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
