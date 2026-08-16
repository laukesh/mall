<?php

namespace App\Http\Controllers\Admin\Vendors;

use App\Http\Controllers\Controller;
use App\Repositories\VendorPerformanceRepositoryInterface;
use Illuminate\Http\Request;

class VendorPerformanceController extends Controller
{
    public function __construct(
        private readonly VendorPerformanceRepositoryInterface $repository
    ) {}

    public function index(Request $request)
    {
        $items = $this->repository->all($request->only(['search', 'status', 'per_page']));

        return view('admin.vendor_performance.index', compact('items'));
    }

    public function create()
    {
        return view('admin.vendor_performance.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $item = $this->repository->create($data);

        return redirect()
            ->route('admin.vendor_performance.show', $item->id)
            ->with('success', 'Vendor Performance created successfully.');
    }

    public function show(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.vendor_performance.show', compact('item'));
    }

    public function edit(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.vendor_performance.edit', compact('item'));
    }

    public function update(Request $request, int $id)
    {
        $data = $this->validated($request, $id);
        $data['updated_by'] = auth()->id();

        $item = $this->repository->update($id, $data);

        return redirect()
            ->route('admin.vendor_performance.show', $item->id)
            ->with('success', 'Vendor Performance updated successfully.');
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);

        return redirect()
            ->route('admin.vendor_performance.index')
            ->with('success', 'Vendor Performance deleted successfully.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        $rules = [
            'vendor_user_id' => 'required|numeric',
            'contract_id' => 'nullable|numeric',
            'evaluation_period_start' => 'required|date',
            'evaluation_period_end' => 'required|date',
            'quality_rating' => 'nullable|numeric',
            'response_rating' => 'nullable|numeric',
            'timeliness_rating' => 'nullable|numeric',
            'safety_rating' => 'nullable|numeric',
            'communication_rating' => 'nullable|numeric',
            'overall_rating' => 'nullable|numeric',
            'jobs_assigned' => 'nullable|numeric',
            'jobs_completed' => 'nullable|numeric',
            'jobs_delayed' => 'nullable|numeric',
            'sla_compliance_percentage' => 'nullable|numeric',
            'strengths' => 'nullable|string',
            'issues' => 'nullable|string',
            'improvement_plan' => 'nullable|string',
            'reviewer_id' => 'nullable|numeric',
            'review_date' => 'required|date',
            'status' => 'required|in:Draft,Completed,Approved,Cancelled',
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
