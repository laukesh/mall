<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DepositRepository;
use App\Models\Deposit;

class DepositController extends Controller
{
    protected $repo;

    public function __construct(DepositRepository $repo)
    {
        $this->repo = $repo;

        $this->middleware('can:viewAny,App\\Models\\Deposit')->only(['index', 'show']);
        $this->middleware('can:create,App\\Models\\Deposit')->only(['create', 'store']);
        $this->middleware('can:update,App\\Models\\Deposit')->only(['edit', 'update']);
        $this->middleware('can:delete,App\\Models\\Deposit')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $filters = $request->only(['lease_agreement_id']);
        $deposits = $this->repo->paginate($perPage, $filters);

        return view('admin.revenue.deposits.index', compact('deposits'));
    }

    public function create()
    {
        return view('admin.revenue.deposits.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'uuid' => 'nullable|string',
            'lease_agreement_id' => 'nullable|integer',
            'deposit_type' => 'nullable|string',
            'deposit_amount' => 'nullable|numeric',
            'received_amount' => 'nullable|numeric',
            'balance_amount' => 'nullable|numeric',
            'due_date' => 'nullable|date',
            'payment_status' => 'nullable|string',
            'refundable_amount' => 'nullable|numeric',
            'remarks' => 'nullable|string',
        ]);

        $data['created_by'] = auth()->id();

        $this->repo->create($data);

        return redirect()->route('admin.revenue.deposits.index')->with('success', 'Deposit created.');
    }

    public function show($id)
    {
        $deposit = $this->repo->find($id);
        return view('admin.revenue.deposits.show', compact('deposit'));
    }

    public function edit($id)
    {
        $deposit = $this->repo->find($id);
        return view('admin.revenue.deposits.edit', compact('deposit'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'uuid' => 'nullable|string',
            'lease_agreement_id' => 'nullable|integer',
            'deposit_type' => 'nullable|string',
            'deposit_amount' => 'nullable|numeric',
            'received_amount' => 'nullable|numeric',
            'balance_amount' => 'nullable|numeric',
            'due_date' => 'nullable|date',
            'payment_status' => 'nullable|string',
            'refundable_amount' => 'nullable|numeric',
            'remarks' => 'nullable|string',
        ]);

        $data['updated_by'] = auth()->id();

        $this->repo->update($id, $data);

        return redirect()->route('admin.revenue.deposits.index')->with('success', 'Deposit updated.');
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return redirect()->route('admin.revenue.deposits.index')->with('success', 'Deposit deleted.');
    }
}
