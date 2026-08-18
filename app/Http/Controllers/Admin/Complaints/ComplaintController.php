<?php

namespace App\Http\Controllers\Admin\Complaints;

use App\Http\Controllers\Controller;
use App\Repositories\ComplaintRepositoryInterface;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function __construct(
        private readonly ComplaintRepositoryInterface $repository
    ) {}

    public function index(Request $request)
    {
        $items = $this->repository->all($request->only(['search', 'status', 'per_page']));

        return view('admin.complaints.index', compact('items'));
    }

    public function create()
    {
        return view('admin.complaints.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $item = $this->repository->create($data);

        return redirect()
            ->route('admin.complaints.show', $item->id)
            ->with('success', 'Complaint created successfully.');
    }

    public function show(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.complaints.show', compact('item'));
    }

    public function edit(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.complaints.edit', compact('item'));
    }

    public function update(Request $request, int $id)
    {
        $data = $this->validated($request, $id);
        $data['updated_by'] = auth()->id();

        $item = $this->repository->update($id, $data);

        return redirect()
            ->route('admin.complaints.show', $item->id)
            ->with('success', 'Complaint updated successfully.');
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);

        return redirect()
            ->route('admin.complaints.index')
            ->with('success', 'Complaint deleted successfully.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        $rules = [
            'complaint_number' => 'required|string|unique:complaints,complaint_number,{id}|max:30',
            'tenant_id' => 'nullable|numeric',
            'raised_by' => 'nullable|numeric',
            'unit_id' => 'nullable|numeric',
            'department_id' => 'nullable|numeric',
            'complaint_category' => 'required|string|max:200',
            'subject' => 'required|string|max:200',
            'description' => 'required|string',
            'priority' => 'required|in:Low,Medium,High,Critical',
            'assigned_to' => 'nullable|numeric',
            'service_request_id' => 'nullable|numeric',
            'resolution_notes' => 'nullable|string',
            'resolved_at' => 'nullable|date',
            'status' => 'required|in:Open,Assigned,Under Investigation,In Progress,Resolved,Closed,Rejected,Cancelled',
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
