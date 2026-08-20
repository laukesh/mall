<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\ContractorBill;
use App\Models\ContractorContract;
use App\Models\PmStatusHistory;
use App\Models\Project;
use App\Services\PmStatusHistoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContractorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Contractor::orderBy('company_name');

        if ($user && $user->isPmMainContractor()) {
            $contractorId = $user->pmContractor->id;
            $query->where(function ($q) use ($contractorId) {
                $q->where('id', $contractorId)
                    ->orWhere('parent_contractor_id', $contractorId);
            });
        }

        return view('admin.contractor.index', [
            'contractors' => $query->get(),
            'canAddMainContractor' => $user && $user->isSuperAdmin(),
            'canAddSubContractor' => $user && $user->canManageSubContractors(),
        ]);
    }

    public function create()
    {
        $user = Auth::user();

        if (! $user || (! $user->isSuperAdmin() && ! $user->canManageSubContractors())) {
            return redirect()->route('admin.contractor.index')
                ->with('error', 'You are not authorized to add contractors.');
        }

        return view('admin.contractor.create', $this->contractorFormData($user));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $contractorType = $request->input('contractor_type');

        if ($contractorType === 'Sub Contractor') {
            if (! $user || ! $user->canManageSubContractors()) {
                return back()->with('error', 'Only Super Admin and Main Contractors can add sub-contractors.');
            }
        } elseif (! $user || ! $user->isSuperAdmin()) {
            return back()->with('error', 'Only Super Admin can add main contractors.');
        }

        $rules = [
            'contractor_code' => 'required|string|max:30|unique:contractors,contractor_code',
            'contractor_type' => 'required|in:Main Contractor,Sub Contractor',
            'company_name' => 'required|string|max:200',
            'status' => 'required|in:Active,Inactive,Blacklisted',
        ];

        if ($contractorType === 'Sub Contractor') {
            $rules['parent_contractor_id'] = 'required|exists:contractors,id';
        }

        $validated = $request->validate($rules);

        if ($contractorType === 'Sub Contractor') {
            $parent = Contractor::find($validated['parent_contractor_id']);
            if (! $parent || ! $parent->isMainContractor()) {
                return back()->withInput()->with('error', 'Sub-contractor must belong to a main contractor.');
            }

            if ($user->isPmMainContractor() && (int) $validated['parent_contractor_id'] !== (int) $user->pmContractor->id) {
                return back()->withInput()->with('error', 'You can only add sub-contractors under your own company.');
            }
        }

        try {
            $contractor = Contractor::create(array_merge($validated, [
                'parent_contractor_id' => $contractorType === 'Sub Contractor' ? $validated['parent_contractor_id'] : null,
                'contact_person' => $request->input('contact_person'),
                'mobile' => $request->input('mobile'),
                'email' => $request->input('email'),
                'gst_number' => $request->input('gst_number'),
                'pan_number' => $request->input('pan_number'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'pincode' => $request->input('pincode'),
                'registration_date' => $request->input('registration_date'),
                'remarks' => $request->input('remarks'),
            ]));

            PmStatusHistoryService::log(
                PmStatusHistory::ENTITY_CONTRACTOR,
                $contractor->id,
                null,
                $contractor->status,
                'status',
                'Contractor created'
            );

            return redirect()->route('admin.contractor.index')->with('success', 'Contractor created.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error creating contractor.');
        }
    }

    public function show($id)
    {
        $contractor = Contractor::getDataById($id);
        if (! $contractor || ! $this->canAccessContractor($contractor)) {
            return redirect()->route('admin.contractor.index')->with('error', 'Contractor not found.');
        }

        return view('admin.contractor.show', [
            'contractor' => $contractor,
            'contracts' => ContractorContract::where('contractor_id', $id)->get(),
            'bills' => ContractorBill::where('contractor_id', $id)->orderByDesc('bill_date')->get(),
            'projects' => Project::orderBy('project_name')->get(),
            'subContractors' => Contractor::where('parent_contractor_id', $id)->get(),
            'parentContractor' => $contractor->parent_contractor_id
                ? Contractor::find($contractor->parent_contractor_id)
                : null,
            'statusHistories' => PmStatusHistoryService::historiesFor(PmStatusHistory::ENTITY_CONTRACTOR, (int) $id),
        ]);
    }

    public function edit($id)
    {
        $contractor = Contractor::getDataById($id);
        if (! $contractor || ! $this->canAccessContractor($contractor)) {
            return redirect()->route('admin.contractor.index')->with('error', 'Contractor not found.');
        }

        return view('admin.contractor.edit', array_merge(
            ['contractor' => $contractor],
            $this->contractorFormData(Auth::user())
        ));
    }

    public function update(Request $request, $id)
    {
        $contractor = Contractor::getDataById($id);
        if (! $contractor || ! $this->canAccessContractor($contractor)) {
            return redirect()->route('admin.contractor.index')->with('error', 'Contractor not found.');
        }

        $user = Auth::user();
        $contractorType = $request->input('contractor_type');

        if ($contractorType === 'Sub Contractor' && ! $user->canManageSubContractors() && ! $user->isSuperAdmin()) {
            return back()->with('error', 'You are not authorized to update this contractor.');
        }

        $rules = [
            'contractor_code' => 'required|string|max:30|unique:contractors,contractor_code,' . $id,
            'contractor_type' => 'required|in:Main Contractor,Sub Contractor',
            'company_name' => 'required|string|max:200',
            'status' => 'required|in:Active,Inactive,Blacklisted',
        ];

        if ($contractorType === 'Sub Contractor') {
            $rules['parent_contractor_id'] = 'required|exists:contractors,id';
        }

        $validated = $request->validate($rules);
        $oldStatus = $contractor->status;

        if ($contractorType === 'Sub Contractor') {
            $parent = Contractor::find($validated['parent_contractor_id']);
            if (! $parent || ! $parent->isMainContractor()) {
                return back()->withInput()->with('error', 'Sub-contractor must belong to a main contractor.');
            }
        }

        try {
            Contractor::where('id', $id)->update(array_merge($validated, [
                'parent_contractor_id' => $contractorType === 'Sub Contractor' ? $validated['parent_contractor_id'] : null,
                'contact_person' => $request->input('contact_person'),
                'mobile' => $request->input('mobile'),
                'email' => $request->input('email'),
                'gst_number' => $request->input('gst_number'),
                'pan_number' => $request->input('pan_number'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'pincode' => $request->input('pincode'),
                'registration_date' => $request->input('registration_date'),
                'remarks' => $request->input('remarks'),
            ]));

            if ($oldStatus !== $validated['status']) {
                PmStatusHistoryService::log(
                    PmStatusHistory::ENTITY_CONTRACTOR,
                    (int) $id,
                    $oldStatus,
                    $validated['status'],
                    'status',
                    'Updated via edit form'
                );
            }

            return redirect()->route('admin.contractor.index')->with('success', 'Contractor updated.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error updating contractor.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $contractor = Contractor::getDataById($id);
        if (! $contractor || ! $this->canAccessContractor($contractor)) {
            return back()->with('error', 'Contractor not found.');
        }

        $validated = $request->validate([
            'status' => 'required|in:Active,Inactive,Blacklisted',
            'remarks' => 'nullable|string|max:500',
        ]);

        $oldStatus = $contractor->status;
        if ($oldStatus === $validated['status']) {
            return back()->with('info', 'Status is already set to ' . $validated['status'] . '.');
        }

        Contractor::where('id', $id)->update(['status' => $validated['status']]);

        PmStatusHistoryService::log(
            PmStatusHistory::ENTITY_CONTRACTOR,
            (int) $id,
            $oldStatus,
            $validated['status'],
            'status',
            $validated['remarks'] ?? null
        );

        return back()->with('success', 'Contractor status updated.');
    }

    public function destroy($id)
    {
        $contractor = Contractor::getDataById($id);
        if (! $contractor || ! Auth::user()?->isSuperAdmin()) {
            return redirect()->route('admin.contractor.index')->with('error', 'Not authorized to delete contractors.');
        }

        try {
            Contractor::where('id', $id)->delete();
            return redirect()->route('admin.contractor.index')->with('success', 'Contractor deleted.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error deleting contractor.', false);
        }
    }

    public function storeContract(Request $request)
    {
        $validated = $request->validate([
            'contractor_id' => 'required|exists:contractors,id',
            'project_id' => 'required|exists:projects,id',
            'contract_number' => 'required|string|max:50|unique:contractor_contracts,contract_number',
            'contract_title' => 'required|string|max:200',
            'contract_type' => 'required|in:Labour,Material,Turnkey,EPC',
            'status' => 'required|in:Active,Expired,Closed',
        ]);

        ContractorContract::create(array_merge($validated, [
            'contract_value' => $request->input('contract_value'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'retention_percentage' => $request->input('retention_percentage'),
            'performance_security' => $request->input('performance_security'),
        ]));

        return back()->with('success', 'Contract added.');
    }

    public function storeBill(Request $request)
    {
        $validated = $request->validate([
            'contractor_id' => 'required|exists:contractors,id',
            'project_id' => 'required|exists:projects,id',
            'bill_number' => 'required|string|max:50|unique:contractor_bills,bill_number',
            'bill_date' => 'required|date',
            'bill_type' => 'required|in:RA Bill,Final Bill,Advance Bill',
            'status' => 'required|in:Submitted,Verified,Approved,Paid,Rejected',
        ]);

        $bill = ContractorBill::create(array_merge($validated, [
            'work_package_id' => $request->input('work_package_id') ?: null,
            'gross_amount' => $request->input('gross_amount'),
            'bill_amount' => $request->input('bill_amount'),
            'approved_amount' => $request->input('approved_amount'),
            'gst_amount' => $request->input('gst_amount'),
            'tds_amount' => $request->input('tds_amount'),
            'retention_amount' => $request->input('retention_amount'),
            'net_payable' => $request->input('net_payable'),
            'remarks' => $request->input('remarks'),
        ]));

        PmStatusHistoryService::log(
            PmStatusHistory::ENTITY_CONTRACTOR_BILL,
            $bill->id,
            null,
            $bill->status,
            'status',
            'Bill created'
        );

        return back()->with('success', 'Bill recorded.');
    }

    public function updateBillStatus(Request $request, $billId)
    {
        $bill = ContractorBill::find($billId);
        if (! $bill) {
            return back()->with('error', 'Bill not found.');
        }

        $validated = $request->validate([
            'status' => 'required|in:Submitted,Verified,Approved,Paid,Rejected',
            'remarks' => 'nullable|string|max:500',
        ]);

        $oldStatus = $bill->status;
        if ($oldStatus === $validated['status']) {
            return back()->with('info', 'Status is already set to ' . $validated['status'] . '.');
        }

        ContractorBill::where('id', $billId)->update(['status' => $validated['status']]);

        PmStatusHistoryService::log(
            PmStatusHistory::ENTITY_CONTRACTOR_BILL,
            (int) $billId,
            $oldStatus,
            $validated['status'],
            'status',
            $validated['remarks'] ?? null
        );

        return back()->with('success', 'Bill status updated.');
    }

    private function contractorFormData($user): array
    {
        $mainContractors = Contractor::where('contractor_type', 'Main Contractor')
            ->where('status', 'Active')
            ->orderBy('company_name')
            ->get();

        return [
            'mainContractors' => $mainContractors,
            'isSuperAdmin' => $user && $user->isSuperAdmin(),
            'forceSubContractor' => $user && $user->isPmMainContractor() && ! $user->isSuperAdmin(),
            'defaultParentId' => $user && $user->isPmMainContractor() ? $user->pmContractor->id : null,
        ];
    }

    private function canAccessContractor($contractor): bool
    {
        $user = Auth::user();
        if (! $user) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isPmMainContractor()) {
            $ownId = $user->pmContractor->id;

            return (int) $contractor->id === $ownId
                || (int) $contractor->parent_contractor_id === $ownId;
        }

        return ! $user->isPmContractor();
    }
}
