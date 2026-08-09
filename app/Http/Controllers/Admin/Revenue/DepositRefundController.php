<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DepositRefundRepository;
use App\Models\DepositRefund;

class DepositRefundController extends Controller
{
    protected $repo;

    public function __construct(DepositRefundRepository $repo)
    {
        $this->repo = $repo;

        $this->middleware('can:viewAny,App\\Models\\DepositRefund')->only(['index', 'show']);
        $this->middleware('can:create,App\\Models\\DepositRefund')->only(['create', 'store']);
        $this->middleware('can:update,App\\Models\\DepositRefund')->only(['edit', 'update']);
        $this->middleware('can:delete,App\\Models\\DepositRefund')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $filters = $request->only(['deposit_id']);
        $refunds = $this->repo->paginate($perPage, $filters);

        return view('admin.revenue.deposit_refunds.index', compact('refunds'));
    }

    public function create()
    {
        return view('admin.revenue.deposit_refunds.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'uuid' => 'nullable|string',
            'deposit_id' => 'nullable|integer',
            'refund_no' => 'nullable|string',
            'refund_date' => 'nullable|date',
            'original_deposit' => 'nullable|numeric',
            'outstanding_rent' => 'nullable|numeric',
            'cam_deduction' => 'nullable|numeric',
            'utility_deduction' => 'nullable|numeric',
            'damage_deduction' => 'nullable|numeric',
            'penalty_deduction' => 'nullable|numeric',
            'other_deduction' => 'nullable|numeric',
            'total_deduction' => 'nullable|numeric',
            'refund_amount' => 'nullable|numeric',
            'payment_mode' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'transaction_reference' => 'nullable|string',
            'refund_status' => 'nullable|string',
            'approved_by' => 'nullable|integer',
            'approved_at' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        $data['created_by'] = auth()->id();

        $this->repo->create($data);

        return redirect()->route('admin.revenue.deposit_refunds.index')->with('success', 'Deposit refund created.');
    }

    public function show($id)
    {
        $refund = $this->repo->find($id);
        return view('admin.revenue.deposit_refunds.show', compact('refund'));
    }

    public function edit($id)
    {
        $refund = $this->repo->find($id);
        return view('admin.revenue.deposit_refunds.edit', compact('refund'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'uuid' => 'nullable|string',
            'deposit_id' => 'nullable|integer',
            'refund_no' => 'nullable|string',
            'refund_date' => 'nullable|date',
            'original_deposit' => 'nullable|numeric',
            'outstanding_rent' => 'nullable|numeric',
            'cam_deduction' => 'nullable|numeric',
            'utility_deduction' => 'nullable|numeric',
            'damage_deduction' => 'nullable|numeric',
            'penalty_deduction' => 'nullable|numeric',
            'other_deduction' => 'nullable|numeric',
            'total_deduction' => 'nullable|numeric',
            'refund_amount' => 'nullable|numeric',
            'payment_mode' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'transaction_reference' => 'nullable|string',
            'refund_status' => 'nullable|string',
            'approved_by' => 'nullable|integer',
            'approved_at' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        $data['updated_by'] = auth()->id();

        $this->repo->update($id, $data);

        return redirect()->route('admin.revenue.deposit_refunds.index')->with('success', 'Deposit refund updated.');
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return redirect()->route('admin.revenue.deposit_refunds.index')->with('success', 'Deposit refund deleted.');
    }
}
