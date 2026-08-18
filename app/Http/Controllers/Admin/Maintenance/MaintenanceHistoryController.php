<?php

namespace App\Http\Controllers\Admin\Maintenance;

use App\Http\Controllers\Controller;
use App\Repositories\MaintenanceHistoryRepositoryInterface;
use Illuminate\Http\Request;

class MaintenanceHistoryController extends Controller
{
    public function __construct(
        private readonly MaintenanceHistoryRepositoryInterface $repository
    ) {}

    public function index(Request $request)
    {
        $items = $this->repository->all($request->only(['search', 'status', 'per_page']));

        return view('admin.maintenance_history.index', compact('items'));
    }

    public function create()
    {
        return view('admin.maintenance_history.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $item = $this->repository->create($data);

        return redirect()
            ->route('admin.maintenance_history.show', $item->id)
            ->with('success', 'Maintenance History created successfully.');
    }

    public function show(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.maintenance_history.show', compact('item'));
    }

    public function edit(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.maintenance_history.edit', compact('item'));
    }

    public function update(Request $request, int $id)
    {
        $data = $this->validated($request, $id);
        $data['updated_by'] = auth()->id();

        $item = $this->repository->update($id, $data);

        return redirect()
            ->route('admin.maintenance_history.show', $item->id)
            ->with('success', 'Maintenance History updated successfully.');
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);

        return redirect()
            ->route('admin.maintenance_history.index')
            ->with('success', 'Maintenance History deleted successfully.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        $rules = [
            'history_number' => 'required|string|unique:maintenance_history,history_number,{id}|max:30',
            'asset_id' => 'required|numeric',
            'work_order_id' => 'nullable|numeric',
            'preventive_maintenance_id' => 'nullable|numeric',
            'maintenance_type' => 'required|string|max:200',
            'maintenance_date' => 'required|date',
            'description' => 'nullable|string',
            'problem_reported' => 'nullable|string',
            'work_performed' => 'required|string',
            'findings' => 'nullable|string',
            'parts_replaced' => 'nullable|string',
            'technician_id' => 'nullable|numeric',
            'vendor_id' => 'nullable|numeric',
            'downtime_hours' => 'nullable|numeric',
            'labour_cost' => 'nullable|numeric',
            'material_cost' => 'nullable|numeric',
            'total_cost' => 'nullable|numeric',
            'condition_before' => 'nullable|in:Excellent,Good,Fair,Poor,Critical',
            'condition_after' => 'nullable|in:Excellent,Good,Fair,Poor,Critical',
            'warranty_claim' => 'nullable|in:0,1',
            'next_maintenance_date' => 'nullable|date',
            'status' => 'required|in:Completed,Cancelled,Failed',
            'remarks' => 'nullable|string',
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
