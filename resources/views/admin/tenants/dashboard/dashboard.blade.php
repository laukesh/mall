@extends('layouts.app')

@section('title', 'Tenant Dashboard')

@section('content')

<div class="container-fluid py-3">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1 fw-bold">
                Tenant Dashboard
            </h4>

            <p class="text-muted mb-0">
                Overview of tenants, documents and lease activity
            </p>

        </div>


        <div class="d-flex gap-2">

            <a href="{{ route('admin.tenants.create') }}"
               class="btn btn-primary">

                <i class="fas fa-plus me-1"></i>

                New Tenant

            </a>

        </div>

    </div>


    {{-- =========================================================
         MAIN STATISTICS
    ========================================================== --}}

    <div class="row g-3 mb-4">


        {{-- TOTAL TENANTS --}}

        <div class="col-xl-3 col-md-6">

            <a href="{{ route('admin.tenants.index') }}"
               class="text-decoration-none">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <div class="text-muted small mb-1">
                                    Total Tenants
                                </div>

                                <div class="fs-2 fw-bold text-dark">
                                    {{ $tenantTotal }}
                                </div>

                            </div>


                            <div class="rounded-circle
                                        bg-primary
                                        bg-opacity-10
                                        text-primary
                                        p-3"
                                 style="height:55px;width:55px;">

                                <i class="fas fa-users fa-lg"></i>

                            </div>

                        </div>


                        <div class="mt-3 small">

                            <span class="text-success">
                                Active:
                            </span>

                            <strong>
                                {{ $tenantActive }}
                            </strong>

                            <span class="mx-2 text-muted">
                                |
                            </span>

                            <span class="text-secondary">
                                Inactive:
                            </span>

                            <strong>
                                {{ $tenantInactive }}
                            </strong>

                        </div>

                    </div>

                </div>

            </a>

        </div>


        {{-- ACTIVE TENANTS --}}

        <div class="col-xl-3 col-md-6">

            <a href="{{ route('admin.tenants.index') }}"
               class="text-decoration-none">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <div class="text-muted small mb-1">
                                    Active Tenants
                                </div>

                                <div class="fs-2 fw-bold text-success">
                                    {{ $tenantActive }}
                                </div>

                            </div>


                            <div class="rounded-circle
                                        bg-success
                                        bg-opacity-10
                                        text-success
                                        p-3"
                                 style="height:55px;width:55px;">

                                <i class="fas fa-user-check fa-lg"></i>

                            </div>

                        </div>


                        <div class="mt-3 small text-muted">

                            Currently active tenant accounts

                        </div>

                    </div>

                </div>

            </a>

        </div>


        {{-- ACTIVE AGREEMENTS --}}

        <div class="col-xl-3 col-md-6">

            <a href="{{ route(
                'admin.leasing.agreements.index'
            ) }}"
               class="text-decoration-none">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <div class="text-muted small mb-1">
                                    Active Leases
                                </div>

                                <div class="fs-2 fw-bold text-primary">
                                    {{ $agreementActive }}
                                </div>

                            </div>


                            <div class="rounded-circle
                                        bg-primary
                                        bg-opacity-10
                                        text-primary
                                        p-3"
                                 style="height:55px;width:55px;">

                                <i class="fas fa-file-signature fa-lg"></i>

                            </div>

                        </div>


                        <div class="mt-3 small text-muted">

                            Total Agreements:
                            <strong>
                                {{ $agreementTotal }}
                            </strong>

                        </div>

                    </div>

                </div>

            </a>

        </div>


        {{-- DOCUMENTS --}}

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <div class="text-muted small mb-1">
                                Tenant Documents
                            </div>

                            <div class="fs-2 fw-bold text-warning">
                                {{ $documentTotal }}
                            </div>

                        </div>


                        <div class="rounded-circle
                                    bg-warning
                                    bg-opacity-10
                                    text-warning
                                    p-3"
                             style="height:55px;width:55px;">

                            <i class="fas fa-folder-open fa-lg"></i>

                        </div>

                    </div>


                    <div class="mt-3 small">

                        <span class="text-warning">
                            Pending:
                        </span>

                        <strong>
                            {{ $documentPending }}
                        </strong>

                        <span class="mx-2 text-muted">
                            |
                        </span>

                        <span class="text-success">
                            Verified:
                        </span>

                        <strong>
                            {{ $documentVerified }}
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         DOCUMENT STATUS
    ========================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white py-3">

            <div class="d-flex justify-content-between
                        align-items-center">

                <div>

                    <h5 class="mb-1">
                        Document Verification
                    </h5>

                    <small class="text-muted">
                        Tenant document verification status
                    </small>

                </div>

            </div>

        </div>


        <div class="card-body">

            <div class="row g-3">


                {{-- PENDING --}}

                <div class="col-md-4">

                    <div class="border rounded-3 p-3">

                        <div class="d-flex justify-content-between">

                            <span class="text-muted">
                                Pending
                            </span>

                            <span class="badge bg-warning text-dark">
                                {{ $documentPending }}
                            </span>

                        </div>

                    </div>

                </div>


                {{-- VERIFIED --}}

                <div class="col-md-4">

                    <div class="border rounded-3 p-3">

                        <div class="d-flex justify-content-between">

                            <span class="text-muted">
                                Verified
                            </span>

                            <span class="badge bg-success">
                                {{ $documentVerified }}
                            </span>

                        </div>

                    </div>

                </div>


                {{-- REJECTED --}}

                <div class="col-md-4">

                    <div class="border rounded-3 p-3">

                        <div class="d-flex justify-content-between">

                            <span class="text-muted">
                                Rejected
                            </span>

                            <span class="badge bg-danger">
                                {{ $documentRejected }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         EXPIRING AGREEMENTS + HISTORY
    ========================================================== --}}

    <div class="row g-4 mb-4">


        {{-- EXPIRING AGREEMENTS --}}

        <div class="col-lg-7">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white py-3">

                    <div class="d-flex justify-content-between
                                align-items-center">

                        <div>

                            <h5 class="mb-1">
                                Upcoming Lease Expiry
                            </h5>

                            <small class="text-muted">
                                Active leases expiring within 90 days
                            </small>

                        </div>

                        <span class="badge bg-warning text-dark">

                            {{ $expiringAgreements->count() }}

                        </span>

                    </div>

                </div>


                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover
                                      align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th>
                                        Agreement
                                    </th>

                                    <th>
                                        Tenant
                                    </th>

                                    <th>
                                        Expiry
                                    </th>

                                    <th>
                                        Remaining
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                            @forelse(
                                $expiringAgreements
                                as $agreement
                            )

                                @php

                                    $daysRemaining =
                                        now()
                                            ->startOfDay()
                                            ->diffInDays(
                                                $agreement->lease_end_date,
                                                false
                                            );

                                @endphp


                                <tr>

                                    <td>

                                        <a href="{{ route(
                                            'admin.leasing.agreements.show',
                                            $agreement->id
                                        ) }}"
                                           class="fw-semibold
                                                  text-decoration-none">

                                            {{ $agreement->agreement_no }}

                                        </a>

                                    </td>


                                    <td>

                                        {{ $agreement->tenant?->company_name
                                            ?? '-' }}

                                    </td>


                                    <td>

                                        {{ $agreement->lease_end_date
                                            ? $agreement->lease_end_date
                                                ->format('d M Y')
                                            : '-' }}

                                    </td>


                                    <td>

                                        @if($daysRemaining <= 30)

                                            <span class="badge bg-danger">

                                                {{ $daysRemaining }} days

                                            </span>

                                        @elseif($daysRemaining <= 60)

                                            <span class="badge
                                                         bg-warning
                                                         text-dark">

                                                {{ $daysRemaining }} days

                                            </span>

                                        @else

                                            <span class="badge bg-info">

                                                {{ $daysRemaining }} days

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4"
                                        class="text-center
                                               text-muted
                                               py-5">

                                        <i class="fas fa-calendar-check
                                                  fa-2x mb-2 d-block"></i>

                                        No leases expiring
                                        within 90 days.

                                    </td>

                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>


        {{-- RECENT HISTORY --}}

        <div class="col-lg-5">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-1">
                        Recent Tenant Activities
                    </h5>

                    <small class="text-muted">
                        Latest tenant activity
                    </small>

                </div>


                <div class="card-body">

                    @forelse(
                        $recentHistory
                        as $history
                    )

                        <div class="d-flex
                                    border-bottom
                                    pb-3
                                    mb-3">

                            <div class="me-3">

                                <div class="rounded-circle
                                            bg-primary
                                            bg-opacity-10
                                            text-primary
                                            d-flex
                                            align-items-center
                                            justify-content-center"
                                     style="width:40px;height:40px;">

                                    <i class="fas fa-history"></i>

                                </div>

                            </div>


                            <div class="flex-grow-1">

                                <div class="fw-semibold">

                                    {{ $history->activity_title }}

                                </div>


                                <div class="small text-muted mt-1">

                                    {{ $history->tenant?->company_name
                                        ?? '-' }}

                                </div>


                                <div class="small text-muted mt-1">

                                    {{ $history->created_at
                                        ? $history->created_at
                                            ->format('d M Y H:i')
                                        : '-' }}

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="text-center text-muted py-5">

                            <i class="fas fa-history
                                      fa-2x mb-2 d-block"></i>

                            No recent tenant activities.

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         QUICK ACTIONS
    ========================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white py-3">

            <h5 class="mb-0">
                Quick Actions
            </h5>

        </div>


        <div class="card-body">

            <div class="d-flex flex-wrap gap-2">

                <a href="{{ route(
                    'admin.tenants.create'
                ) }}"
                   class="btn btn-primary">

                    <i class="fas fa-user-plus me-1"></i>

                    New Tenant

                </a>


                <a href="{{ route(
                    'admin.tenants.index'
                ) }}"
                   class="btn btn-outline-primary">

                    <i class="fas fa-users me-1"></i>

                    Manage Tenants

                </a>


                <a href="{{ route(
                    'admin.leasing.agreements.index'
                ) }}"
                   class="btn btn-outline-success">

                    <i class="fas fa-file-signature me-1"></i>

                    Lease Agreements

                </a>

            </div>

        </div>

    </div>

</div>

@endsection