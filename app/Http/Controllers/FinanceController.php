<?php

namespace App\Http\Controllers;

use App\Models\ExpenseEntry;
use App\Models\Payment;
use App\Models\PmStatusHistory;
use App\Models\Project;
use App\Models\ProjectBudget;
use App\Services\PmStatusHistoryService;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        return view('admin.finance.index', [
            'payments' => Payment::orderByDesc('payment_date')->limit(50)->get(),
            'expenses' => ExpenseEntry::orderByDesc('expense_date')->limit(50)->get(),
            'budgets' => ProjectBudget::orderBy('project_id')->get(),
        ]);
    }

    public function payments()
    {
        return view('admin.finance.payments', [
            'payments' => Payment::orderByDesc('payment_date')->get(),
        ]);
    }

    public function storePayment(Request $request)
    {
        $validated = $request->validate([
            'payment_type' => 'required|in:Contractor,Vendor,Client Refund,Miscellaneous',
            'payment_date' => 'required|date',
            'payment_mode' => 'required|in:Bank Transfer,Cheque,Cash,NEFT,RTGS,UPI',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:Pending,Completed,Failed',
        ]);

        $payment = Payment::create(array_merge($validated, [
            'reference_type' => $request->input('reference_type'),
            'reference_id' => $request->input('reference_id') ?: null,
            'transaction_reference' => $request->input('transaction_reference'),
        ]));

        PmStatusHistoryService::log(
            PmStatusHistory::ENTITY_PAYMENT,
            $payment->id,
            null,
            $payment->status,
            'status',
            'Payment recorded'
        );

        return back()->with('success', 'Payment recorded.');
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $payment = Payment::find($id);
        if (! $payment) {
            return back()->with('error', 'Payment not found.');
        }

        $validated = $request->validate([
            'status' => 'required|in:Pending,Completed,Failed',
            'remarks' => 'nullable|string|max:500',
        ]);

        $oldStatus = $payment->status;
        if ($oldStatus === $validated['status']) {
            return back()->with('info', 'Status is already set to ' . $validated['status'] . '.');
        }

        Payment::where('id', $id)->update(['status' => $validated['status']]);

        PmStatusHistoryService::log(
            PmStatusHistory::ENTITY_PAYMENT,
            (int) $id,
            $oldStatus,
            $validated['status'],
            'status',
            $validated['remarks'] ?? null
        );

        return back()->with('success', 'Payment status updated.');
    }

    public function expenses()
    {
        return view('admin.finance.expenses', [
            'expenses' => ExpenseEntry::orderByDesc('expense_date')->get(),
            'projects' => Project::orderBy('project_name')->get(),
        ]);
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'expense_date' => 'required|date',
            'expense_category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
        ]);

        ExpenseEntry::create(array_merge($validated, [
            'cost_center_id' => $request->input('cost_center_id') ?: null,
            'description' => $request->input('description'),
            'approved_by' => $request->input('approved_by') ?: null,
        ]));

        return back()->with('success', 'Expense recorded.');
    }

    public function budgets()
    {
        return view('admin.finance.budgets', [
            'budgets' => ProjectBudget::orderBy('project_id')->get(),
            'projects' => Project::orderBy('project_name')->get(),
        ]);
    }

    public function storeBudget(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'budget_category' => 'required|string|max:100',
        ]);

        ProjectBudget::create(array_merge($validated, [
            'estimated_amount' => $request->input('estimated_amount'),
            'approved_amount' => $request->input('approved_amount'),
            'utilized_amount' => $request->input('utilized_amount', 0),
            'remaining_amount' => $request->input('remaining_amount'),
            'remarks' => $request->input('remarks'),
        ]));

        return back()->with('success', 'Budget line added.');
    }
}
