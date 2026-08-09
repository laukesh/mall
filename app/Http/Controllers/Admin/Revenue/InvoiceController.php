<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\InvoiceRepository;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    protected $repo;

    public function __construct(InvoiceRepository $repo)
    {
        $this->repo = $repo;

        $this->middleware('can:viewAny,App\\Models\\Invoice')->only(['index', 'show']);
        $this->middleware('can:create,App\\Models\\Invoice')->only(['create', 'store']);
        $this->middleware('can:update,App\\Models\\Invoice')->only(['edit', 'update']);
        $this->middleware('can:delete,App\\Models\\Invoice')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $filters = $request->only(['lease_agreement_id', 'tenant_id', 'invoice_status']);
        $invoices = $this->repo->paginate($perPage, $filters);

        return view('admin.revenue.invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('admin.revenue.invoices.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'uuid' => 'nullable|string',
            'invoice_no' => 'nullable|string',
            'lease_agreement_id' => 'nullable|integer',
            'tenant_id' => 'nullable|integer',
            'invoice_type' => 'nullable|string',
            'invoice_date' => 'nullable|date',
            'billing_period_from' => 'nullable|date',
            'billing_period_to' => 'nullable|date',
            'due_date' => 'nullable|date',
            'subtotal' => 'nullable|numeric',
            'discount_amount' => 'nullable|numeric',
            'taxable_amount' => 'nullable|numeric',
            'tax_amount' => 'nullable|numeric',
            'total_amount' => 'nullable|numeric',
            'paid_amount' => 'nullable|numeric',
            'balance_amount' => 'nullable|numeric',
            'invoice_status' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $data['created_by'] = auth()->id();

        $this->repo->create($data);

        return redirect()->route('admin.revenue.invoices.index')->with('success', 'Invoice created.');
    }

    public function show($id)
    {
        $invoice = $this->repo->find($id);

        return view('admin.revenue.invoices.show', compact('invoice'));
    }

    public function edit($id)
    {
        $invoice = $this->repo->find($id);

        return view('admin.revenue.invoices.edit', compact('invoice'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'uuid' => 'nullable|string',
            'invoice_no' => 'nullable|string',
            'lease_agreement_id' => 'nullable|integer',
            'tenant_id' => 'nullable|integer',
            'invoice_type' => 'nullable|string',
            'invoice_date' => 'nullable|date',
            'billing_period_from' => 'nullable|date',
            'billing_period_to' => 'nullable|date',
            'due_date' => 'nullable|date',
            'subtotal' => 'nullable|numeric',
            'discount_amount' => 'nullable|numeric',
            'taxable_amount' => 'nullable|numeric',
            'tax_amount' => 'nullable|numeric',
            'total_amount' => 'nullable|numeric',
            'paid_amount' => 'nullable|numeric',
            'balance_amount' => 'nullable|numeric',
            'invoice_status' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $data['updated_by'] = auth()->id();

        $this->repo->update($id, $data);

        return redirect()->route('admin.revenue.invoices.index')->with('success', 'Invoice updated.');
    }

    public function destroy($id)
    {
        $this->repo->delete($id);

        return redirect()->route('admin.revenue.invoices.index')->with('success', 'Invoice deleted.');
    }
}
