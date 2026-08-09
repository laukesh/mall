<?php

namespace App\Http\Controllers\Admin\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\LeaseAgreement;
use App\Models\TenantDocument;
use App\Models\TenantHistory;
use Carbon\Carbon;

class TenantDashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Tenant Statistics
        |--------------------------------------------------------------------------
        */

        $tenantTotal = Tenant::count();

        $tenantActive = Tenant::where(
            'status',
            'Active'
        )->count();

        $tenantInactive = Tenant::where(
            'status',
            'Inactive'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Agreement Statistics
        |--------------------------------------------------------------------------
        */

        $agreementTotal = LeaseAgreement::count();

        $agreementActive = LeaseAgreement::where(
            'agreement_status',
            'Active'
        )->count();

        $agreementExpired = LeaseAgreement::where(
            'agreement_status',
            'Expired'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Tenant Documents
        |--------------------------------------------------------------------------
        */

        $documentTotal = TenantDocument::count();

        $documentPending = TenantDocument::where(
            'verification_status',
            'Pending'
        )->count();

        $documentVerified = TenantDocument::where(
            'verification_status',
            'Verified'
        )->count();

        $documentRejected = TenantDocument::where(
            'verification_status',
            'Rejected'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Agreements Expiring Within 90 Days
        |--------------------------------------------------------------------------
        */

        $today = Carbon::today();

        $expiryDate = Carbon::today()->addDays(90);

        $expiringAgreements = LeaseAgreement::with('tenant')
            ->where(
                'agreement_status',
                'Active'
            )
            ->whereDate(
                'lease_end_date',
                '>=',
                $today
            )
            ->whereDate(
                'lease_end_date',
                '<=',
                $expiryDate
            )
            ->orderBy(
                'lease_end_date',
                'asc'
            )
            ->limit(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Tenant History
        |--------------------------------------------------------------------------
        */

        $recentHistory = TenantHistory::with('tenant')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Return Dashboard
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.tenants.dashboard.dashboard',
            compact(

                // Tenants
                'tenantTotal',
                'tenantActive',
                'tenantInactive',

                // Agreements
                'agreementTotal',
                'agreementActive',
                'agreementExpired',

                // Documents
                'documentTotal',
                'documentPending',
                'documentVerified',
                'documentRejected',

                // Expiry
                'expiringAgreements',

                // History
                'recentHistory'
            )
        );
    }
}