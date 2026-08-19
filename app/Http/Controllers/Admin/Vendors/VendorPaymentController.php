<?php

namespace App\Http\Controllers\Admin\Vendors;

use App\Http\Controllers\Controller;
use App\Repositories\VendorPaymentRepositoryInterface;
use Illuminate\Http\Request;

class VendorPaymentController extends Controller
{
    public function __construct(
        private readonly VendorPaymentRepositoryInterface $repository
    ) {}

    public function index(Request $request)
    {
        $items = $this->repository->all($request->only(['search', 'status', 'per_page']));

        return view('admin.vendor_payments.index', compact('items'));
    }

    public function create()
    {
        return view('admin.vendor_payments.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $item = $this->repository->create($data);

        return redirect()
            ->route('admin.vendor_payments.show', $item->id)
            ->with('success', 'Vendor Payment created successfully.');
    }

    public function show(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.vendor_payments.show', compact('item'));
    }

    public function edit(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.vendor_payments.edit', compact('item'));
    }

    public function update(Request $request, int $id)
    {
        $data = $this->validated($request, $id);
        $data['updated_by'] = auth()->id();

        $item = $this->repository->update($id, $data);

        return redirect()
            ->route('admin.vendor_payments.show', $item->id)
            ->with('success', 'Vendor Payment updated successfully.');
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);

        return redirect()
            ->route('admin.vendor_payments.index')
            ->with('success', 'Vendor Payment deleted successfully.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        $rules = [
            'payment_number' => 'required|string|unique:vendor_payments,payment_number,{id}|max:30',
            'vendor_user_id' => 'required|numeric',
            'contract_id' => 'nullable|numeric',
            'invoice_number' => 'nullable|string|max:200',
            'invoice_date' => 'nullable|date',
            'invoice_amount' => 'nullable|numeric',
            'tax_amount' => 'nullable|numeric',
            'tds_amount' => 'nullable|numeric',
            'other_deduction' => 'nullable|numeric',
            'net_amount' => 'nullable|numeric',
            'payment_date' => 'nullable|date',
            'payment_method' => 'nullable|in:Bank Transfer,Cheque,Cash,UPI,Other',
            'transaction_reference' => 'nullable|string|max:200',
            'status' => 'required|in:Pending,Approved,Processing,Paid,Rejected,Cancelled',
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
