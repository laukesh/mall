<?php

namespace App\Http\Controllers\Admin\Maintenance;

use App\Http\Controllers\Controller;
use App\Repositories\PreventiveMaintenanceRepositoryInterface;
use Illuminate\Http\Request;

class PreventiveMaintenanceController extends Controller
{
    public function __construct(
        private readonly PreventiveMaintenanceRepositoryInterface $repository
    ) {}

    public function index(Request $request)
    {
        $items = $this->repository->all($request->only(['search', 'status', 'per_page']));

        return view('admin.preventive_maintenance.index', compact('items'));
    }

    public function create()
    {
        return view('admin.preventive_maintenance.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $item = $this->repository->create($data);

        return redirect()
            ->route('admin.preventive_maintenance.show', $item->id)
            ->with('success', 'Preventive Maintenance created successfully.');
    }

    public function show(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.preventive_maintenance.show', compact('item'));
    }

    public function edit(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.preventive_maintenance.edit', compact('item'));
    }

    public function update(Request $request, int $id)
    {
        $data = $this->validated($request, $id);
        $data['updated_by'] = auth()->id();

        $item = $this->repository->update($id, $data);

        return redirect()
            ->route('admin.preventive_maintenance.show', $item->id)
            ->with('success', 'Preventive Maintenance updated successfully.');
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);

        return redirect()
            ->route('admin.preventive_maintenance.index')
            ->with('success', 'Preventive Maintenance deleted successfully.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        $rules = [
            'asset_id' => 'required|numeric',
            'maintenance_code' => 'required|string|unique:preventive_maintenance,maintenance_code,{id}|max:30',
            'maintenance_title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'maintenance_type' => 'required|string|max:200',
            'frequency' => 'required|in:Daily,Weekly,Monthly,Quarterly,Half-Yearly,Yearly,Custom',
            'frequency_value' => 'required|numeric',
            'last_maintenance_date' => 'nullable|date',
            'next_due_date' => 'nullable|date',
            'estimated_hours' => 'nullable|numeric',
            'estimated_cost' => 'nullable|numeric',
            'assigned_department_id' => 'nullable|numeric',
            'assigned_to' => 'nullable|numeric',
            'vendor_id' => 'nullable|numeric',
            'checklist' => 'nullable|string',
            'reminder_days' => 'nullable|numeric',
            'status' => 'required|in:Active,Inactive,Completed,Cancelled',
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
