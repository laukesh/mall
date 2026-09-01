<?php

namespace App\Http\Controllers\Admin\Land;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LandOpportunity;

class LandOpportunityController extends Controller
{
    /**
     * Display all land opportunities.
     */
    public function index(Request $request)
    {
        $query = LandOpportunity::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'opportunity_no',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'opportunity_name',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'location_text',
                    'like',
                    "%{$search}%"
                );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $opportunities = $query
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view(
            'land-acquisition.opportunities.index',
            compact('opportunities')
        );
    }


    /**
     * Show create form.
     */
    public function create()
    {
        return view(
            'land-acquisition.opportunities.create'
        );
    }


    /**
     * Store new opportunity.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'opportunity_no' => [
                'required',
                'string',
                'max:50',
                'unique:land_opportunities,opportunity_no'
            ],

            'opportunity_name' => [
                'required',
                'string',
                'max:255'
            ],

            'description' => [
                'nullable',
                'string'
            ],

            'source' => [
                'nullable',
                'string',
                'max:100'
            ],

            'identified_date' => [
                'nullable',
                'date'
            ],

            'estimated_area' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'area_unit' => [
                'nullable',
                'string',
                'max:20'
            ],

            'estimated_acquisition_cost' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'currency' => [
                'nullable',
                'string',
                'max:10'
            ],

            'location_text' => [
                'nullable',
                'string',
                'max:500'
            ],

            'status' => [
                'required',
                'string',
                'max:50'
            ],

            'remarks' => [
                'nullable',
                'string'
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Audit
        |--------------------------------------------------------------------------
        */

        $validated['created_by'] = auth()->id();

        /*
        |--------------------------------------------------------------------------
        | Create
        |--------------------------------------------------------------------------
        */

        $opportunity = LandOpportunity::create(
            $validated
        );

        return redirect()
            ->route(
                'admin.land.opportunities.show',
                $opportunity
            )
            ->with(
                'success',
                'Land opportunity created successfully.'
            );
    }


    /**
     * Display opportunity.
     */
    public function show(
        LandOpportunity $opportunity
    ) {
        $opportunity->load('lands');

        return view(
            'land-acquisition.opportunities.show',
            compact('opportunity')
        );
    }


    /**
     * Show edit form.
     */
    public function edit(
        LandOpportunity $opportunity
    ) {
        return view(
            'land-acquisition.opportunities.edit',
            compact('opportunity')
        );
    }


    /**
     * Update opportunity.
     */
    public function update(
        Request $request,
        LandOpportunity $opportunity
    ) {
        $validated = $request->validate([

            'opportunity_no' => [
                'required',
                'string',
                'max:50',
                'unique:land_opportunities,opportunity_no,'
                . $opportunity->id
            ],

            'opportunity_name' => [
                'required',
                'string',
                'max:255'
            ],

            'description' => [
                'nullable',
                'string'
            ],

            'source' => [
                'nullable',
                'string',
                'max:100'
            ],

            'identified_date' => [
                'nullable',
                'date'
            ],

            'estimated_area' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'area_unit' => [
                'nullable',
                'string',
                'max:20'
            ],

            'estimated_acquisition_cost' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'currency' => [
                'nullable',
                'string',
                'max:10'
            ],

            'location_text' => [
                'nullable',
                'string',
                'max:500'
            ],

            'status' => [
                'required',
                'string',
                'max:50'
            ],

            'remarks' => [
                'nullable',
                'string'
            ],

        ]);

        $validated['updated_by'] = auth()->id();

        $opportunity->update(
            $validated
        );

        return redirect()
            ->route(
                'admin.land.opportunities.show',
                $opportunity
            )
            ->with(
                'success',
                'Land opportunity updated successfully.'
            );
    }


    /**
     * Delete opportunity.
     */
    public function destroy(
        LandOpportunity $opportunity
    ) {
        /*
        |--------------------------------------------------------------------------
        | Prevent deleting opportunity if linked to land
        |--------------------------------------------------------------------------
        */

        if ($opportunity->lands()->exists()) {

            return redirect()
                ->route('admin.land.opportunities.index')
                ->with(
                    'error',
                    'This opportunity is already linked to a land record and cannot be deleted.'
                );
        }

        $opportunity->delete();

        return redirect()
            ->route('admin.land.opportunities.index')
            ->with(
                'success',
                'Land opportunity deleted successfully.'
            );
    }
}