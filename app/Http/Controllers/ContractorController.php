<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\ContractorBill;
use App\Models\ContractorContract;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractorController extends Controller
{
    public function index()
    {
        return view('admin.contractor.index', [
            'contractors' => Contractor::orderBy('company_name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.contractor.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contractor_code' => 'required|string|max:30|unique:contractors,contractor_code',
            'contractor_type' => 'required|in:Main Contractor,Sub Contractor',
            'company_name' => 'required|string|max:200',
            'status' => 'required|in:Active,Inactive,Blacklisted',
        ]);

        try {
            Contractor::create(array_merge($validated, [
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

            return redirect()->route('admin.contractor.index')->with('success', 'Contractor created.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error creating contractor.');
        }
    }

    public function show($id)
    {
        $contractor = Contractor::getDataById($id);
        if (!$contractor) {
            return redirect()->route('admin.contractor.index')->with('error', 'Contractor not found.');
        }

        return view('admin.contractor.show', [
            'contractor' => $contractor,
            'contracts' => ContractorContract::where('contractor_id', $id)->get(),
            'bills' => ContractorBill::where('contractor_id', $id)->orderByDesc('bill_date')->get(),
            'projects' => Project::orderBy('project_name')->get(),
        ]);
    }

    public function edit($id)
    {
        $contractor = Contractor::getDataById($id);
        if (!$contractor) {
            return redirect()->route('admin.contractor.index')->with('error', 'Contractor not found.');
        }

        return view('admin.contractor.edit', ['contractor' => $contractor]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'contractor_code' => 'required|string|max:30|unique:contractors,contractor_code,' . $id,
            'contractor_type' => 'required|in:Main Contractor,Sub Contractor',
            'company_name' => 'required|string|max:200',
            'status' => 'required|in:Active,Inactive,Blacklisted',
        ]);

        try {
            Contractor::where('id', $id)->update(array_merge($validated, [
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

            return redirect()->route('admin.contractor.index')->with('success', 'Contractor updated.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error updating contractor.');
        }
    }

    public function destroy($id)
    {
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

        ContractorBill::create(array_merge($validated, [
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

        return back()->with('success', 'Bill recorded.');
    }
}
