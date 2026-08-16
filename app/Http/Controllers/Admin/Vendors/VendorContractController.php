<?php

namespace App\Http\Controllers\Admin\Vendors;

use App\Http\Controllers\Controller;
use App\Repositories\VendorContractRepositoryInterface;
use Illuminate\Http\Request;

class VendorContractController extends Controller
{
    public function __construct(
        private readonly VendorContractRepositoryInterface $repository
    ) {}

    public function index(Request $request)
    {
        $items = $this->repository->all($request->only(['search', 'status', 'per_page']));

        return view('admin.vendor_contracts.index', compact('items'));
    }

    public function create()
    {
        return view('admin.vendor_contracts.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $item = $this->repository->create($data);

        return redirect()
            ->route('admin.vendor_contracts.show', $item->id)
            ->with('success', 'Vendor Contract created successfully.');
    }

    public function show(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.vendor_contracts.show', compact('item'));
    }

    public function edit(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.vendor_contracts.edit', compact('item'));
    }

    public function update(Request $request, int $id)
    {
        $data = $this->validated($request, $id);
        $data['updated_by'] = auth()->id();

        $item = $this->repository->update($id, $data);

        return redirect()
            ->route('admin.vendor_contracts.show', $item->id)
            ->with('success', 'Vendor Contract updated successfully.');
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);

        return redirect()
            ->route('admin.vendor_contracts.index')
            ->with('success', 'Vendor Contract deleted successfully.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        $rules = [
            'contract_number' => 'required|string|unique:vendor_contracts,contract_number,{id}|max:30',
            'vendor_user_id' => 'required|numeric',
            'contract_title' => 'required|string|max:200',
            'contract_type' => 'required|string|max:200',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'contract_value' => 'nullable|numeric',
            'payment_terms' => 'nullable|string',
            'renewal_type' => 'required|in:Manual,Automatic',
            'renewal_date' => 'nullable|date',
            'notice_period_days' => 'nullable|numeric',
            'document_path' => 'nullable|string|max:200',
            'status' => 'required|in:Draft,Active,Expired,Terminated,Renewed,Cancelled',
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
