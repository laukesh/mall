@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">
                {{ $procurementPlan->plan_title }}
            </h4>

            <div class="text-muted">
                {{ $procurementPlan->plan_number }}
            </div>
        </div>

        <div class="d-flex gap-2">
            <a
                href="{{ route(
                    'admin.procurement.packages.index'
                ) }}"
                class="btn btn-outline-primary"
            >
                <i class="ri-archive-line me-1"></i>
                Packages
            </a>

            {{-- Tenders --}}

            <a
                href="{{ route(
                    'admin.procurement.plans.tenders.index',
                    $procurementPlan
                ) }}"
                class="btn btn-success"
            >
                <i class="ri-auction-line me-1"></i>
                Tenders

                @if($procurementPlan->tenders->count())
                    <span class="badge bg-light text-success ms-1">
                        {{ $procurementPlan->tenders->count() }}
                    </span>
                @endif
            </a>


            {{-- Edit --}}

            <a
                href="{{ route(
                    'admin.procurement.plans.edit',
                    $procurementPlan
                ) }}"
                class="btn btn-primary"
            >
                <i class="ri-edit-line me-1"></i>
                Edit
            </a>


            {{-- Back --}}

            <a
                href="{{ route(
                    'admin.procurement.plans.index'
                ) }}"
                class="btn btn-outline-secondary"
            >
                <i class="ri-arrow-left-line me-1"></i>
                Back
            </a>

        </div>

    </div>


    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    {{-- Plan Information --}}
    <div class="card mb-4">

        <div class="card-header">
            <strong>Procurement Plan Information</strong>
        </div>

        <div class="card-body">

            <div class="row g-4">

                <div class="col-md-3">

                    <div class="text-muted small">
                        Plan Number
                    </div>

                    <div class="fw-semibold">
                        {{ $procurementPlan->plan_number }}
                    </div>

                </div>


                <div class="col-md-5">

                    <div class="text-muted small">
                        Plan Title
                    </div>

                    <div class="fw-semibold">
                        {{ $procurementPlan->plan_title }}
                    </div>

                </div>


                <div class="col-md-2">

                    <div class="text-muted small">
                        Procurement Year
                    </div>

                    <div>
                        {{ $procurementPlan->procurement_year ?: '—' }}
                    </div>

                </div>


                <div class="col-md-2">

                    <div class="text-muted small">
                        Status
                    </div>

                    <span class="badge bg-secondary">
                        {{ $procurementPlan->status }}
                    </span>

                </div>


                <div class="col-md-6">

                    <div class="text-muted small">
                        Planned Start Date
                    </div>

                    <div>
                        {{
                            $procurementPlan->planned_start_date
                                ? $procurementPlan->planned_start_date
                                    ->format('d-m-Y')
                                : '—'
                        }}
                    </div>

                </div>


                <div class="col-md-6">

                    <div class="text-muted small">
                        Planned Completion Date
                    </div>

                    <div>
                        {{
                            $procurementPlan->planned_completion_date
                                ? $procurementPlan->planned_completion_date
                                    ->format('d-m-Y')
                                : '—'
                        }}
                    </div>

                </div>


                <div class="col-md-12">

                    <div class="text-muted small">
                        Description
                    </div>

                    <div>
                        {!! nl2br(
                            e(
                                $procurementPlan->description
                                ?: '—'
                            )
                        ) !!}
                    </div>

                </div>


                <div class="col-md-12">

                    <div class="text-muted small">
                        Procurement Objective
                    </div>

                    <div>
                        {!! nl2br(
                            e(
                                $procurementPlan->procurement_objective
                                ?: '—'
                            )
                        ) !!}
                    </div>

                </div>


                <div class="col-md-4">

                    <div class="text-muted small">
                        Total Estimated Value
                    </div>

                    <div class="fw-semibold">
                        {{ $procurementPlan->currency }}
                        {{ number_format(
                            $procurementPlan->total_estimated_value,
                            2
                        ) }}
                    </div>

                </div>


                <div class="col-md-8">

                    <div class="text-muted small">
                        Remarks
                    </div>

                    <div>
                        {!! nl2br(
                            e(
                                $procurementPlan->remarks
                                ?: '—'
                            )
                        ) !!}
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Packages --}}
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <div>
                <strong>Procurement Packages</strong>

                <span class="badge bg-primary ms-2">
                    {{ $procurementPlan->packages->count() }}
                </span>
            </div>

        </div>


        <div class="card-body p-0">

            @if($procurementPlan->packages->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>Package Number</th>
                            <th>Package Title</th>
                            <th>Type</th>
                            <th>Estimated Value</th>
                            <th>Status</th>
                            <th class="text-end">
                                Action
                            </th>
                        </tr>

                        </thead>

                        <tbody>

                        @foreach(
                            $procurementPlan->packages
                            as $package
                        )

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <a href="{{ route(
                                        'admin.procurement.packages.show',
                                        $package
                                    ) }}"
                                       class="fw-semibold text-decoration-none">

                                        {{ $package->package_number }}

                                    </a>
                                </td>

                                <td>
                                    {{ $package->package_title }}
                                </td>

                                <td>
                                    {{ $package->package_type ?: '—' }}
                                </td>

                                <td>
                                    {{ $package->currency }}
                                    {{ number_format(
                                        $package->estimated_value,
                                        2
                                    ) }}
                                </td>

                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $package->status }}
                                    </span>
                                </td>

                                <td class="text-end">

                                    <a href="{{ route(
                                        'admin.procurement.packages.show',
                                        $package
                                    ) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <div class="text-muted">
                        No procurement packages have been created
                        for this plan yet.
                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection