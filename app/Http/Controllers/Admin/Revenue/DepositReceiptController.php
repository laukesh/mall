<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DepositReceiptRepository;
use App\Models\DepositReceipt;

class DepositReceiptController extends Controller
{
    protected $repo;

    public function __construct(DepositReceiptRepository $repo)
    {
        $this->repo = $repo;

        $this->middleware('can:viewAny,App\\Models\\DepositReceipt')->only(['index', 'show']);
        $this->middleware('can:create,App\\Models\\DepositReceipt')->only(['create', 'store']);
        $this->middleware('can:update,App\\Models\\DepositReceipt')->only(['edit', 'update']);
        $this->middleware('can:delete,App\\Models\\DepositReceipt')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $filters = $request->only(['deposit_id']);
        $receipts = $this->repo->paginate($perPage, $filters);

        return view('admin.revenue.deposit_receipts.index', compact('receipts'));
    }

    public function create()
    {
        return view('admin.revenue.deposit_receipts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'uuid' => 'nullable|string',
            'deposit_id' => 'nullable|integer',
            'receipt_no' => 'nullable|string',
            'receipt_date' => 'nullable|date',
            'payment_amount' => 'nullable|numeric',
            'payment_mode' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'transaction_reference' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'received_by' => 'nullable|integer',
            'remarks' => 'nullable|string',
        ]);

        $data['created_by'] = auth()->id();

        $this->repo->create($data);

        return redirect()->route('admin.revenue.deposit_receipts.index')->with('success', 'Deposit receipt created.');
    }

    public function show($id)
    {
        $receipt = $this->repo->find($id);
        return view('admin.revenue.deposit_receipts.show', compact('receipt'));
    }

    public function edit($id)
    {
        $receipt = $this->repo->find($id);
        return view('admin.revenue.deposit_receipts.edit', compact('receipt'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'uuid' => 'nullable|string',
            'deposit_id' => 'nullable|integer',
            'receipt_no' => 'nullable|string',
            'receipt_date' => 'nullable|date',
            'payment_amount' => 'nullable|numeric',
            'payment_mode' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'transaction_reference' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'received_by' => 'nullable|integer',
            'remarks' => 'nullable|string',
        ]);

        $data['updated_by'] = auth()->id();

        $this->repo->update($id, $data);

        return redirect()->route('admin.revenue.deposit_receipts.index')->with('success', 'Deposit receipt updated.');
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return redirect()->route('admin.revenue.deposit_receipts.index')->with('success', 'Deposit receipt deleted.');
    }
}
