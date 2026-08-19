<?php

namespace App\Http\Controllers\Admin\Maintenance;

use App\Http\Controllers\Controller;
use App\Repositories\MaintenanceRequestRepositoryInterface;
use Illuminate\Http\Request;

class MaintenanceRequestController extends Controller
{
    public function __construct(
        private readonly MaintenanceRequestRepositoryInterface $repository
    ) {}

    public function index(Request $request)
    {
        $items = $this->repository->all($request->only(['search', 'status', 'per_page']));

        return view('admin.maintenance_requests.index', compact('items'));
    }

    public function create()
    {
        return view('admin.maintenance_requests.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $item = $this->repository->create($data);

        return redirect()
            ->route('admin.maintenance_requests.show', $item->id)
            ->with('success', 'Maintenance Request created successfully.');
    }

    public function show(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.maintenance_requests.show', compact('item'));
    }

    public function edit(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.maintenance_requests.edit', compact('item'));
    }

    public function update(Request $request, int $id)
    {
        $data = $this->validated($request, $id);
        $data['updated_by'] = auth()->id();

        $item = $this->repository->update($id, $data);

        return redirect()
            ->route('admin.maintenance_requests.show', $item->id)
            ->with('success', 'Maintenance Request updated successfully.');
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);

        return redirect()
            ->route('admin.maintenance_requests.index')
            ->with('success', 'Maintenance Request deleted successfully.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        $rules = [
            'maintenance_number' => 'required|string|unique:maintenance_requests,maintenance_number,{id}|max:30',
            'service_request_id' => 'required|numeric',
            'unit_id' => 'nullable|numeric',
            'category' => 'required|string|max:200',
            'sub_category' => 'nullable|string|max:200',
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'assessment' => 'nullable|string',
            'priority' => 'required|in:Low,Medium,High,Critical',
            'department_id' => 'nullable|numeric',
            'assigned_to' => 'nullable|numeric',
            'vendor_id' => 'nullable|numeric',
            'planned_start_date' => 'nullable|date',
            'planned_end_date' => 'nullable|date',
            'estimated_cost' => 'nullable|numeric',
            'actual_cost' => 'nullable|numeric',
            'status' => 'required|in:Open,Under Assessment,Assigned,Scheduled,In Progress,On Hold,Resolved,Closed,Cancelled',
            'resolution_notes' => 'nullable|string',
            'resolved_at' => 'nullable|date',
            'closed_at' => 'nullable|date',
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
