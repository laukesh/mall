<?php

namespace App\Http\Controllers\Admin\Leasing;

use App\Http\Controllers\Controller;
use App\Models\LeaseAgreement;
use App\Models\LeaseProposal;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Services\LeaseHistoryService;

class LeaseAgreementController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = LeaseAgreement::with([
            'tenant',
            'proposal'
        ]);

        // Search
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'agreement_no',
                    'LIKE',
                    '%' . $search . '%'
                );

                $q->orWhereHas(
                    'tenant',
                    function ($tenantQuery) use ($search) {

                        $tenantQuery
                            ->where(
                                'company_name',
                                'LIKE',
                                '%' . $search . '%'
                            )
                            ->orWhere(
                                'brand_name',
                                'LIKE',
                                '%' . $search . '%'
                            );
                    }
                );

                $q->orWhereHas(
                    'proposal',
                    function ($proposalQuery) use ($search) {

                        $proposalQuery->where(
                            'proposal_no',
                            'LIKE',
                            '%' . $search . '%'
                        );
                    }
                );
            });
        }


        // Status filter
        if ($request->filled('status')) {

            $query->where(
                'agreement_status',
                $request->status
            );
        }


        $agreements = $query
            ->latest('id')
            ->paginate(20)
            ->withQueryString();


        return view(
            'admin.leasing.agreements.index',
            compact('agreements')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        /*
         * Only approved proposals should be available
         * for creating an agreement.
         */

        $proposals = LeaseProposal::where(
                'proposal_status',
                'Approved'
            )
            ->with([
                'tenant',
                'proposalUnits.unit'
            ])
            ->orderBy('id', 'desc')
            ->get();


        $tenants = Tenant::orderBy(
            'company_name'
        )->get();


        return view(
            'admin.leasing.agreements.create',
            compact(
                'proposals',
                'tenants'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'proposal_id' => [
                'required',
                'exists:lease_proposals,id'
            ],

            'tenant_id' => [
                'required',
                'exists:tenants,id'
            ],

            'agreement_date' => [
                'required',
                'date'
            ],

            'lease_start_date' => [
                'required',
                'date'
            ],

            'lease_end_date' => [
                'required',
                'date',
                'after_or_equal:lease_start_date'
            ],

            'rent_start_date' => [
                'nullable',
                'date'
            ],

            'handover_date' => [
                'nullable',
                'date'
            ],

            'fitout_start_date' => [
                'nullable',
                'date'
            ],

            'fitout_end_date' => [
                'nullable',
                'date'
            ],

            'rent_free_days' => [
                'nullable',
                'integer',
                'min:0'
            ],

            'security_deposit' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'monthly_rent' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'cam_amount' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'utility_deposit' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'billing_frequency' => [
                'nullable',
                'in:Monthly,Quarterly,Half-Yearly,Yearly'
            ],

            'payment_due_day' => [
                'nullable',
                'integer',
                'min:1',
                'max:31'
            ],

            'agreement_status' => [
                'required',
                'in:Draft,Active,Expired,Terminated,Renewed,Cancelled'
            ],

            'remarks' => [
                'nullable',
                'string'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Lease Period
        |--------------------------------------------------------------------------
        */

        $start = Carbon::parse(
            $validated['lease_start_date']
        );

        $end = Carbon::parse(
            $validated['lease_end_date']
        );

        $leasePeriodMonths =
            $start->diffInMonths($end);

        if ($end->day >= $start->day) {
            $leasePeriodMonths++;
        }


        /*
        |--------------------------------------------------------------------------
        | Agreement Number
        |--------------------------------------------------------------------------
        */

        $lastAgreement = LeaseAgreement::withTrashed()
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastAgreement
            ? $lastAgreement->id + 1
            : 1;

        $agreementNo =
            'LA-' .
            date('Y') .
            '-' .
            str_pad(
                $nextNumber,
                5,
                '0',
                STR_PAD_LEFT
            );


        /*
        |--------------------------------------------------------------------------
        | Create Agreement
        |--------------------------------------------------------------------------
        */

        $agreement = LeaseAgreement::create([

            'uuid' => (string) Str::uuid(),

            'agreement_no' =>
                $agreementNo,

            'proposal_id' =>
                $validated['proposal_id'],

            'tenant_id' =>
                $validated['tenant_id'],

            'agreement_date' =>
                $validated['agreement_date'],

            'lease_start_date' =>
                $validated['lease_start_date'],

            'lease_end_date' =>
                $validated['lease_end_date'],

            'lease_period_months' =>
                $leasePeriodMonths,

            'rent_start_date' =>
                $validated['rent_start_date'] ?? null,

            'handover_date' =>
                $validated['handover_date'] ?? null,

            'fitout_start_date' =>
                $validated['fitout_start_date'] ?? null,

            'fitout_end_date' =>
                $validated['fitout_end_date'] ?? null,

            'rent_free_days' =>
                $validated['rent_free_days'] ?? 0,

            'security_deposit' =>
                $validated['security_deposit'] ?? 0,

            'monthly_rent' =>
                $validated['monthly_rent'] ?? 0,

            'cam_amount' =>
                $validated['cam_amount'] ?? 0,

            'utility_deposit' =>
                $validated['utility_deposit'] ?? 0,

            'billing_frequency' =>
                $validated['billing_frequency'] ?? 'Monthly',

            'payment_due_day' =>
                $validated['payment_due_day'] ?? 5,

            'agreement_status' =>
                $validated['agreement_status'],

            'remarks' =>
                $validated['remarks'] ?? null,

            'created_by' =>
                auth()->id(),

            'updated_by' =>
                auth()->id(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Convert Proposal
        |--------------------------------------------------------------------------
        */

        $proposal = LeaseProposal::find(
            $validated['proposal_id']
        );

        if ($proposal) {

            $proposal->update([

                'proposal_status' => 'Converted',

                'updated_by' =>
                    auth()->id(),
            ]);
        }


        return redirect()
            ->route(
                'admin.leasing.agreements.show',
                $agreement->id
            )
            ->with(
                'success',
                'Lease agreement created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    /*public function show($id)
    {
        $agreement = LeaseAgreement::with([
            'tenant',
            'proposal',
            'proposal.proposalUnits.unit'
        ])->findOrFail($id);


        return view(
            'admin.leasing.agreements.show',
            compact('agreement')
        );
    }*/

    /*public function show(LeaseAgreement $agreement)
	{
	    $agreement->load([
	        'tenant',
	        'proposal',
	        'terms',
	        'units.unit',
	        'documents.documentType',
	        'documents.verifiedBy',
	    ]);

	    return view(
	        'admin.leasing.agreements.show',
	        compact('agreement')
	    );
	}*/

	/*public function show(LeaseAgreement $agreement)
	{
	    $agreement->load([
	        'tenant',
	        'proposal',
	        'terms',
	        'documents.documentType',
	        'documents.verifiedBy',
	    ]);

	    return view(
	        'admin.leasing.agreements.show',
	        compact('agreement')
	    );
	}*/

    public function show($id)
    {
        $agreement = LeaseAgreement::with([
            'tenant',
            'proposal',
            'terms',
            'documents.documentType',
            'renewals',
            'escalations',
            'terminations',
            'history.performer',
        ])->findOrFail($id);

        return view(
            'admin.leasing.agreements.show',
            compact('agreement')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $agreement = LeaseAgreement::with([
            'tenant',
            'proposal'
        ])->findOrFail($id);


        $tenants = Tenant::orderBy(
            'company_name'
        )->get();


        return view(
            'admin.leasing.agreements.edit',
            compact(
                'agreement',
                'tenants'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    ) {

        $agreement =
            LeaseAgreement::findOrFail($id);


        $validated = $request->validate([

            'tenant_id' => [
                'required',
                'exists:tenants,id'
            ],

            'agreement_date' => [
                'required',
                'date'
            ],

            'lease_start_date' => [
                'required',
                'date'
            ],

            'lease_end_date' => [
                'required',
                'date',
                'after_or_equal:lease_start_date'
            ],

            'rent_start_date' => [
                'nullable',
                'date'
            ],

            'handover_date' => [
                'nullable',
                'date'
            ],

            'fitout_start_date' => [
                'nullable',
                'date'
            ],

            'fitout_end_date' => [
                'nullable',
                'date'
            ],

            'rent_free_days' => [
                'nullable',
                'integer',
                'min:0'
            ],

            'security_deposit' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'monthly_rent' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'cam_amount' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'utility_deposit' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'billing_frequency' => [
                'nullable',
                'in:Monthly,Quarterly,Half-Yearly,Yearly'
            ],

            'payment_due_day' => [
                'nullable',
                'integer',
                'min:1',
                'max:31'
            ],

            'agreement_status' => [
                'required',
                'in:Draft,Active,Expired,Terminated,Renewed,Cancelled'
            ],

            'remarks' => [
                'nullable',
                'string'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Lease Period
        |--------------------------------------------------------------------------
        */

        $start = Carbon::parse(
            $validated['lease_start_date']
        );

        $end = Carbon::parse(
            $validated['lease_end_date']
        );

        $leasePeriodMonths =
            $start->diffInMonths($end);

        if ($end->day >= $start->day) {
            $leasePeriodMonths++;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Agreement
        |--------------------------------------------------------------------------
        */

        $agreement->update([

            'tenant_id' =>
                $validated['tenant_id'],

            'agreement_date' =>
                $validated['agreement_date'],

            'lease_start_date' =>
                $validated['lease_start_date'],

            'lease_end_date' =>
                $validated['lease_end_date'],

            'lease_period_months' =>
                $leasePeriodMonths,

            'rent_start_date' =>
                $validated['rent_start_date'] ?? null,

            'handover_date' =>
                $validated['handover_date'] ?? null,

            'fitout_start_date' =>
                $validated['fitout_start_date'] ?? null,

            'fitout_end_date' =>
                $validated['fitout_end_date'] ?? null,

            'rent_free_days' =>
                $validated['rent_free_days'] ?? 0,

            'security_deposit' =>
                $validated['security_deposit'] ?? 0,

            'monthly_rent' =>
                $validated['monthly_rent'] ?? 0,

            'cam_amount' =>
                $validated['cam_amount'] ?? 0,

            'utility_deposit' =>
                $validated['utility_deposit'] ?? 0,

            'billing_frequency' =>
                $validated['billing_frequency'] ?? 'Monthly',

            'payment_due_day' =>
                $validated['payment_due_day'] ?? 5,

            'agreement_status' =>
                $validated['agreement_status'],

            'remarks' =>
                $validated['remarks'] ?? null,

            'updated_by' =>
                auth()->id(),
        ]);


        return redirect()
            ->route(
                'admin.leasing.agreements.show',
                $agreement->id
            )
            ->with(
                'success',
                'Lease agreement updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $agreement =
            LeaseAgreement::findOrFail($id);

        $agreement->delete();

        return redirect()
            ->route(
                'admin.leasing.agreements.index'
            )
            ->with(
                'success',
                'Lease agreement deleted successfully.'
            );
    }

    public function activate($id)
	{
	    $agreement = LeaseAgreement::findOrFail($id);

	    if ($agreement->agreement_status !== 'Draft') {
	        return redirect()
	            ->back()
	            ->with('error', 'Only draft agreements can be activated.');
	    }

	    $agreement->update([
	        'agreement_status' => 'Active',
	        'updated_by' => auth()->id(),
	    ]);

        LeaseHistoryService::log(

            $agreement->id,

            'Agreement',

            'Lease Agreement Activated',

            'Lease agreement was activated.',

            [
                'agreement_status' => 'Draft'
            ],

            [
                'agreement_status' => 'Active'
            ],

            'LeaseAgreement',

            $agreement->id
        );

	    // Mark proposal as converted
	    if ($agreement->proposal) {
	        $agreement->proposal->update([
	            'proposal_status' => 'Converted',
	            'updated_by' => auth()->id(),
	        ]);
	    }

	    return redirect()
	        ->route(
	            'admin.leasing.agreements.show',
	            $agreement->id
	        )
	        ->with(
	            'success',
	            'Lease agreement activated successfully.'
	        );
	}

	public function renew(LeaseAgreement $agreement)
	{
	    $agreement->load([
	        'tenant',
	        'proposal',
	        'terms',
	        'documents.documentType',
	    ]);

	    return view(
	        'admin.leasing.agreements.renew',
	        compact('agreement')
	    );
	}

	public function processRenewal(Request $request, LeaseAgreement $agreement)
	{
	    $validated = $request->validate([
	        'lease_start_date' => 'required|date',
	        'lease_end_date' => 'required|date|after:lease_start_date',
	        'lease_period_months' => 'nullable|integer|min:1',
	        'rent_start_date' => 'nullable|date',
	        'monthly_rent' => 'required|numeric|min:0',
	        'cam_amount' => 'nullable|numeric|min:0',
	        'security_deposit' => 'nullable|numeric|min:0',
	        'remarks' => 'nullable|string',
	    ]);

	    $agreement->update([
	        'lease_start_date' => $validated['lease_start_date'],
	        'lease_end_date' => $validated['lease_end_date'],
	        'lease_period_months' => $validated['lease_period_months'] ?? null,
	        'rent_start_date' => $validated['rent_start_date'] ?? null,
	        'monthly_rent' => $validated['monthly_rent'],
	        'cam_amount' => $validated['cam_amount'] ?? 0,
	        'security_deposit' => $validated['security_deposit'] ?? 0,
	        'agreement_status' => 'Renewed',
	        'remarks' => $validated['remarks'] ?? $agreement->remarks,
	        'updated_by' => auth()->id(),
	    ]);

	    return redirect()
	        ->route(
	            'admin.leasing.agreements.show',
	            $agreement->id
	        )
	        ->with(
	            'success',
	            'Lease agreement renewed successfully.'
	        );
	}

}