@extends('layouts.app')

@section('title', 'Fit-Out Dashboard')

@section('content')

<style>

    .fitout-dashboard {
        padding-bottom: 40px;
    }

    .dashboard-section {
        margin-bottom: 32px;
    }

    .section-heading {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 14px;
    }

    .section-heading span {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: #d94a0b;
        white-space: nowrap;
    }

    .section-heading::after {
        content: "";
        height: 1px;
        background: #e7ddd6;
        flex: 1;
    }


    /* =========================================================
       KPI CARDS
       ========================================================= */

    .glance-card {
        position: relative;
        background: #fbf9f7;
        border: 1px solid #e7ddd6;
        border-radius: 14px;
        padding: 18px 18px 16px 20px;
        height: 100%;
        overflow: hidden;
        transition: all .15s ease;
    }
    .glance-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 16px rgba(45, 30, 20, .08);
    }

    .glance-card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: #d94a0b;

    }

    .glance-card.green::before {
        background: #087f68;
    }

    .glance-card.orange::before {
        background: #f59e0b;
    }

    .glance-card.dark::before {
        background: #3d2b25;
    }

    .glance-label {
        font-size: 12px;
        color: #786d67;
        margin-bottom: 8px;
    }

    .glance-value {
        font-size: 29px;
        font-weight: 700;
        line-height: 1;
        color: #17120f;
    }

    .glance-subtitle {
        margin-top: 8px;
        font-size: 11px;
        color: #8b817b;
    }


    /* =========================================================
       PIPELINE
       ========================================================= */

    .pipeline-wrapper {
        background: #fbf9f7;
        border: 1px solid #e7ddd6;
        border-radius: 15px;
        padding: 6px;
    }

    .pipeline-card {
        background: #fff;
        border: 1px solid #e5ddd7;
        border-radius: 12px;
        padding: 14px 14px 12px;
        height: 100%;
        cursor: pointer;
        transition: all .15s ease;
    }

    .pipeline-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 16px rgba(45, 30, 20, .08);
    }

    .pipeline-number {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 12px;
    }

    .pipeline-index {
        width: 23px;
        height: 23px;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        background: #9c918b;
    }

    .pipeline-index.orange {
        background: #d94a0b;
    }

    .pipeline-index.amber {
        background: #e77715;
    }

    .pipeline-index.yellow {
        background: #f2a900;
    }

    .pipeline-index.green {
        background: #07876f;
    }

    .pipeline-label {
        font-size: 11px;
        font-weight: 700;
        color: #8c817a;
        text-transform: uppercase;
    }

    .pipeline-count {
        font-size: 27px;
        font-weight: 700;
        line-height: 1;
        color: #191411;
    }

    .pipeline-title {
        font-size: 12px;
        margin-top: 7px;
        color: #544a45;
    }

    .pipeline-meta {
        font-size: 10px;
        margin-top: 3px;
        color: #9a908a;
    }

    .pipeline-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #b6aaa2;
        font-size: 17px;
    }


    /* =========================================================
       WHITE DATA CARDS
       ========================================================= */

    .data-card {
        background: #fbf9f7;
        border: 1px solid #e7ddd6;
        border-radius: 15px;
        padding: 18px;
        height: 100%;
    }

    .data-card-title {
        font-size: 14px;
        font-weight: 700;
        color: #241b17;
        margin-bottom: 5px;
    }

    .data-card-subtitle {
        font-size: 11px;
        color: #8c817a;
        margin-bottom: 18px;
    }


    /* =========================================================
       PROGRESS
       ========================================================= */

    .progress-row {
        margin-bottom: 15px;
    }

    .progress-row:last-child {
        margin-bottom: 0;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        margin-bottom: 6px;
        color: #675d57;
    }

    .fitout-progress {
        height: 8px;
        background: #eee8e3;
        border-radius: 20px;
        overflow: hidden;
    }

    .fitout-progress-bar {
        height: 100%;
        background: #07876f;
        border-radius: 20px;
    }


    /* =========================================================
       FLOOR
       ========================================================= */

    .floor-row {
        padding: 12px 0;
        border-bottom: 1px solid #e5ddd7;
    }

    .floor-row:last-child {
        border-bottom: none;
    }

    .floor-name {
        font-size: 12px;
        font-weight: 700;
        color: #302621;
    }

    .floor-code {
        font-size: 10px;
        color: #9a908a;
        margin-top: 2px;
    }

    .floor-count {
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
        color: #564c46;
    }

    .floor-bar {
        height: 8px;
        background: #eee8e3;
        border-radius: 20px;
        overflow: hidden;
        flex: 1;
    }

    .floor-bar-fill {
        height: 100%;
        background: #ed8700;
    }


    /* =========================================================
       ATTENTION
       ========================================================= */

    .attention-item {
        padding: 13px 0;
        border-bottom: 1px solid #e5ddd7;
    }

    .attention-item:last-child {
        border-bottom: none;
    }

    .attention-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-top: 5px;
        flex-shrink: 0;
    }

    .attention-critical {
        background: #c73b2e;
    }

    .attention-high {
        background: #e77715;
    }

    .attention-title {
        font-size: 12px;
        font-weight: 700;
        color: #302621;
    }

    .attention-meta {
        font-size: 10px;
        color: #8c817a;
        margin-top: 2px;
    }


    /* =========================================================
       TABLE
       ========================================================= */

    .dashboard-table {
        background: #fbf9f7;
        border: 1px solid #e7ddd6;
        border-radius: 15px;
        overflow: hidden;
    }

    .dashboard-table .table {
        margin-bottom: 0;
    }

    .dashboard-table th {
        background: #f5f0ec;
        border-bottom: 1px solid #e2d8d1;
        font-size: 10px;
        letter-spacing: .4px;
        text-transform: uppercase;
        color: #756a63;
        white-space: nowrap;
    }

    .dashboard-table td {
        font-size: 12px;
        vertical-align: middle;
        color: #3f3732;
        border-color: #eee7e2;
    }

    .status-pill {
        display: inline-block;
        padding: 4px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
    }

    .status-success {
        background: #dff4ed;
        color: #08755f;
    }

    .status-warning {
        background: #fff0cc;
        color: #9a6100;
    }

    .status-danger {
        background: #fde2de;
        color: #a93227;
    }

    .status-info {
        background: #e0f0f5;
        color: #12637a;
    }

    .status-muted {
        background: #eeeae7;
        color: #716760;
    }

</style>


<div class="container-fluid fitout-dashboard">


    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">
                Fit-Out Management
            </h4>

            <div class="text-muted small">
                Live overview of fit-out progress, inspections,
                snags and handovers.
            </div>

        </div>


        <div class="d-flex gap-2">

            <a
                href="{{ route('admin.fitout.requests.create') }}"
                class="btn btn-primary btn-sm"
            >
                <i class="bi bi-plus-lg me-1"></i>
                New Fit-Out
            </a>

            <a
                href="{{ route('admin.fitout.requests.index') }}"
                class="btn btn-outline-secondary btn-sm"
            >
                All Requests
            </a>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- FILTERS --}}
    {{-- ========================================================= --}}

    <div class="dashboard-section">

        <div class="section-heading">

            <span>
                Filters
            </span>

        </div>


        <form
            method="GET"
            action="{{ route('admin.fitout.dashboard') }}"
            class="data-card"
        >

            <div class="row g-3">


                {{-- Floor --}}
                <div class="col-xl-2 col-md-4">

                    <label class="form-label small fw-semibold">
                        Floor
                    </label>

                    <select
                        name="floor_id"
                        class="form-select form-select-sm"
                    >

                        <option value="">
                            All Floors
                        </option>

                        @foreach($floors as $floor)

                            <option
                                value="{{ $floor->id }}"
                                @selected(
                                    $filters['floor_id']
                                    == $floor->id
                                )
                            >

                                {{ $floor->floor_name }}

                                @if($floor->floor_code)
                                    ({{ $floor->floor_code }})
                                @endif

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Unit --}}
                <div class="col-xl-2 col-md-4">

                    <label class="form-label small fw-semibold">
                        Unit
                    </label>

                    <select
                        name="unit_id"
                        class="form-select form-select-sm"
                    >

                        <option value="">
                            All Units
                        </option>

                        @foreach($units as $unit)

                            <option
                                value="{{ $unit->id }}"
                                @selected(
                                    $filters['unit_id']
                                    == $unit->id
                                )
                            >

                                {{ $unit->unit_no }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Contractor --}}
                <div class="col-xl-2 col-md-4">

                    <label class="form-label small fw-semibold">
                        Contractor
                    </label>

                    <select
                        name="contractor_id"
                        class="form-select form-select-sm"
                    >

                        <option value="">
                            All Contractors
                        </option>

                        @foreach($contractors as $contractor)

                            <option
                                value="{{ $contractor->id }}"
                                @selected(
                                    $filters['contractor_id']
                                    == $contractor->id
                                )
                            >

                                {{ $contractor->contractor_name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Status --}}
                <div class="col-xl-2 col-md-4">

                    <label class="form-label small fw-semibold">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select form-select-sm"
                    >

                        <option value="">
                            All Statuses
                        </option>

                        @foreach([
                            'Draft',
                            'Submitted',
                            'Under Review',
                            'Approved',
                            'Rejected',
                            'In Progress',
                            'Completed',
                            'Closed',
                        ] as $status)

                            <option
                                value="{{ $status }}"
                                @selected(
                                    $filters['status'] === $status
                                )
                            >

                                {{ $status }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- From --}}
                <div class="col-xl-2 col-md-4">

                    <label class="form-label small fw-semibold">
                        From
                    </label>

                    <input
                        type="date"
                        name="date_from"
                        value="{{ $filters['date_from'] }}"
                        class="form-control form-control-sm"
                    >

                </div>


                {{-- To --}}
                <div class="col-xl-2 col-md-4">

                    <label class="form-label small fw-semibold">
                        To
                    </label>

                    <input
                        type="date"
                        name="date_to"
                        value="{{ $filters['date_to'] }}"
                        class="form-control form-control-sm"
                    >

                </div>

            </div>


            <div class="d-flex justify-content-end gap-2 mt-3">

                <a
                    href="{{ route('admin.fitout.dashboard') }}"
                    class="btn btn-sm btn-outline-secondary"
                >
                    Reset
                </a>

                <button
                    type="submit"
                    class="btn btn-sm btn-primary"
                >
                    <i class="bi bi-funnel me-1"></i>
                    Apply Filters
                </button>

            </div>

        </form>

        @if(
            request()->filled('pipeline')
            || request()->filled('status')
            || request()->filled('floor_id')
            || request()->filled('unit_id')
            || request()->filled('contractor_id')
            || request()->filled('date_from')
            || request()->filled('date_to')
        )

            <div class="alert alert-light border mt-3 mb-0">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <i class="bi bi-funnel me-1"></i>

                        <strong>
                            Active filters
                        </strong>

                        @if(request('pipeline'))
                            <span class="badge bg-primary ms-2">
                                {{ ucfirst(request('pipeline')) }}
                            </span>
                        @endif

                        @if(request('status'))
                            <span class="badge bg-secondary ms-1">
                                {{ request('status') }}
                            </span>
                        @endif

                        @if(request('floor_id'))
                            <span class="badge bg-secondary ms-1">
                                Floor selected
                            </span>
                        @endif

                        @if(request('unit_id'))
                            <span class="badge bg-secondary ms-1">
                                Unit selected
                            </span>
                        @endif

                        @if(request('contractor_id'))
                            <span class="badge bg-secondary ms-1">
                                Contractor selected
                            </span>
                        @endif

                    </div>


                    <a
                        href="{{ route('admin.fitout.dashboard') }}"
                        class="btn btn-sm btn-link text-danger"
                    >
                        Clear all
                    </a>

                </div>

            </div>

        @endif

    </div>


    {{-- ========================================================= --}}
    {{-- FIT-OUT AT A GLANCE --}}
    {{-- ========================================================= --}}

    <div class="dashboard-section">

        <div class="section-heading">

            <span>
                Fit-Out at a Glance
            </span>

        </div>


        <div class="row g-3">


            {{-- ===================================================== --}}
            {{-- TOTAL FIT-OUTS --}}
            {{-- ===================================================== --}}

            <div class="col-xl-2 col-md-4 col-6">

                <a
                    href="{{ route(
                        'admin.fitout.dashboard',
                        array_merge(
                            request()->query(),
                            [
                                'pipeline' => null,
                                'status' => null,
                            ]
                        )
                    ) }}"
                    class="glance-card text-decoration-none d-block"
                >

                    <div class="glance-label">
                        Total fit-outs
                    </div>

                    <div class="glance-value">
                        {{ $totalFitouts }}
                    </div>

                    <div class="glance-subtitle">
                        registered requests
                    </div>

                </a>

            </div>


            {{-- ===================================================== --}}
            {{-- APPROVED --}}
            {{-- ===================================================== --}}

            <div class="col-xl-2 col-md-4 col-6">

                <a
                    href="{{ route(
                        'admin.fitout.dashboard',
                        array_merge(
                            request()->query(),
                            [
                                'pipeline' => null,
                                'status' => 'Approved',
                            ]
                        )
                    ) }}"
                    class="glance-card green text-decoration-none d-block"
                >

                    <div class="glance-label">
                        Approved
                    </div>

                    <div class="glance-value">
                        {{ $approvedFitouts }}
                    </div>

                    <div class="glance-subtitle">
                        ready for fit-out
                    </div>

                </a>

            </div>


            {{-- ===================================================== --}}
            {{-- IN FIT-OUT --}}
            {{-- ===================================================== --}}

            <div class="col-xl-2 col-md-4 col-6">

                <a
                    href="{{ route(
                        'admin.fitout.dashboard',
                        array_merge(
                            request()->query(),
                            [
                                'pipeline' => null,
                                'status' => 'In Progress',
                            ]
                        )
                    ) }}"
                    class="glance-card orange text-decoration-none d-block"
                >

                    <div class="glance-label">
                        In fit-out now
                    </div>

                    <div class="glance-value">
                        {{ $inFitout }}
                    </div>

                    <div class="glance-subtitle">
                        works underway
                    </div>

                </a>

            </div>


            {{-- ===================================================== --}}
            {{-- INSPECTIONS DUE --}}
            {{-- ===================================================== --}}

            <div class="col-xl-2 col-md-4 col-6">

                <a
                    href="{{ route(
                        'admin.fitout.inspections.index'
                    ) }}"
                    class="glance-card green text-decoration-none d-block"
                >

                    <div class="glance-label">
                        Inspections due
                    </div>

                    <div class="glance-value">
                        {{ $inspectionsDue }}
                    </div>

                    <div class="glance-subtitle">
                        scheduled / in progress
                    </div>

                </a>

            </div>


            {{-- ===================================================== --}}
            {{-- OPEN SNAGS --}}
            {{-- ===================================================== --}}

            <div class="col-xl-2 col-md-4 col-6">

                <a
                    href="{{ route(
                        'admin.fitout.snags.index'
                    ) }}"
                    class="glance-card orange text-decoration-none d-block"
                >

                    <div class="glance-label">
                        Open snags
                    </div>

                    <div class="glance-value">
                        {{ $openSnags }}
                    </div>

                    <div class="glance-subtitle">
                        {{ $criticalSnags }} critical
                    </div>

                </a>

            </div>


            {{-- ===================================================== --}}
            {{-- HANDOVER COMPLETE --}}
            {{-- ===================================================== --}}

            <div class="col-xl-2 col-md-4 col-6">

                <a
                    href="{{ route(
                        'admin.fitout.handovers.index'
                    ) }}"
                    class="glance-card dark text-decoration-none d-block"
                >

                    <div class="glance-label">
                        Handover complete
                    </div>

                    <div class="glance-value">
                        {{ $completedHandovers }}
                    </div>

                    <div class="glance-subtitle">
                        units handed over
                    </div>

                </a>

            </div>


        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- FIT-OUT PIPELINE --}}
    {{-- ========================================================= --}}

    <div class="dashboard-section">

        <div class="section-heading">

            <span>
                Fit-Out Pipeline
            </span>

        </div>


        <div class="pipeline-wrapper">

            <div class="row g-1 align-items-stretch">


                {{-- ===================================================== --}}
                {{-- START --}}
                {{-- ===================================================== --}}

                <div class="col">

                    <a
                        href="{{ route(
                            'admin.fitout.dashboard',
                            array_merge(
                                request()->query(),
                                ['pipeline' => 'start']
                            )
                        ) }}"
                        class="pipeline-card text-decoration-none d-block"
                    >

                        <div class="pipeline-number">

                            <span class="pipeline-index">
                                —
                            </span>

                            <span class="pipeline-label">
                                Start
                            </span>

                        </div>

                        <div class="pipeline-count">
                            {{ $pipelineStart }}
                        </div>

                        <div class="pipeline-title">
                            Awaiting action
                        </div>

                        <div class="pipeline-meta">
                            Draft / Submitted
                        </div>

                    </a>

                </div>


                <div class="col-auto pipeline-arrow">
                    →
                </div>


                {{-- ===================================================== --}}
                {{-- APPROVAL --}}
                {{-- ===================================================== --}}

                <div class="col">

                    <a
                        href="{{ route(
                            'admin.fitout.dashboard',
                            array_merge(
                                request()->query(),
                                ['pipeline' => 'approval']
                            )
                        ) }}"
                        class="pipeline-card text-decoration-none d-block"
                    >

                        <div class="pipeline-number">

                            <span class="pipeline-index orange">
                                1
                            </span>

                            <span class="pipeline-label">
                                Approval
                            </span>

                        </div>

                        <div class="pipeline-count">
                            {{ $pipelineApproval }}
                        </div>

                        <div class="pipeline-title">
                            Under review
                        </div>

                        <div class="pipeline-meta">
                            Approval pending
                        </div>

                    </a>

                </div>


                <div class="col-auto pipeline-arrow">
                    →
                </div>


                {{-- ===================================================== --}}
                {{-- FIT-OUT --}}
                {{-- ===================================================== --}}

                <div class="col">

                    <a
                        href="{{ route(
                            'admin.fitout.dashboard',
                            array_merge(
                                request()->query(),
                                ['pipeline' => 'fitout']
                            )
                        ) }}"
                        class="pipeline-card text-decoration-none d-block"
                    >

                        <div class="pipeline-number">

                            <span class="pipeline-index amber">
                                2
                            </span>

                            <span class="pipeline-label">
                                Fit-Out
                            </span>

                        </div>

                        <div class="pipeline-count">
                            {{ $pipelineFitout }}
                        </div>

                        <div class="pipeline-title">
                            Works underway
                        </div>

                        <div class="pipeline-meta">
                            Active stages
                        </div>

                    </a>

                </div>


                <div class="col-auto pipeline-arrow">
                    →
                </div>


                {{-- ===================================================== --}}
                {{-- INSPECTION --}}
                {{-- ===================================================== --}}

                <div class="col">

                    <a
                        href="{{ route(
                            'admin.fitout.dashboard',
                            array_merge(
                                request()->query(),
                                ['pipeline' => 'inspection']
                            )
                        ) }}"
                        class="pipeline-card text-decoration-none d-block"
                    >

                        <div class="pipeline-number">

                            <span class="pipeline-index yellow">
                                3
                            </span>

                            <span class="pipeline-label">
                                Inspection
                            </span>

                        </div>

                        <div class="pipeline-count">
                            {{ $pipelineInspection }}
                        </div>

                        <div class="pipeline-title">
                            Inspection stage
                        </div>

                        <div class="pipeline-meta">
                            Scheduled / completed
                        </div>

                    </a>

                </div>


                <div class="col-auto pipeline-arrow">
                    →
                </div>


                {{-- ===================================================== --}}
                {{-- SNAGS --}}
                {{-- ===================================================== --}}

                <div class="col">

                    <a
                        href="{{ route(
                            'admin.fitout.dashboard',
                            array_merge(
                                request()->query(),
                                ['pipeline' => 'snag']
                            )
                        ) }}"
                        class="pipeline-card text-decoration-none d-block"
                    >

                        <div class="pipeline-number">

                            <span class="pipeline-index orange">
                                4
                            </span>

                            <span class="pipeline-label">
                                Snags
                            </span>

                        </div>

                        <div class="pipeline-count">
                            {{ $pipelineSnag }}
                        </div>

                        <div class="pipeline-title">
                            Snag clearance
                        </div>

                        <div class="pipeline-meta">
                            Open issues
                        </div>

                    </a>

                </div>


                <div class="col-auto pipeline-arrow">
                    →
                </div>


                {{-- ===================================================== --}}
                {{-- HANDOVER --}}
                {{-- ===================================================== --}}

                <div class="col">

                    <a
                        href="{{ route(
                            'admin.fitout.dashboard',
                            array_merge(
                                request()->query(),
                                ['pipeline' => 'handover']
                            )
                        ) }}"
                        class="pipeline-card text-decoration-none d-block"
                    >

                        <div class="pipeline-number">

                            <span class="pipeline-index green">
                                5
                            </span>

                            <span class="pipeline-label">
                                Handover
                            </span>

                        </div>

                        <div class="pipeline-count">
                            {{ $pipelineHandover }}
                        </div>

                        <div class="pipeline-title">
                            Handover
                        </div>

                        <div class="pipeline-meta">
                            Pending / completed
                        </div>

                    </a>

                </div>


            </div>

        </div>


        <div class="small text-muted mt-2 px-1">

            Each fit-out moves from request through approval,
            construction, inspection, snag clearance and handover.

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- PROGRESS & FLOOR --}}
    {{-- ========================================================= --}}

    <div class="dashboard-section">

        <div class="section-heading">

            <span>
                Progress & Floors
            </span>

        </div>


        <div class="row g-4">


            {{-- ================================================= --}}
            {{-- PROGRESS --}}
            {{-- ================================================= --}}

            <div class="col-xl-7">

                <div class="data-card">

                    <div class="data-card-title">
                        Fit-Out progress
                    </div>

                    <div class="data-card-subtitle">
                        Average completion across active fit-out stages.
                    </div>


                    {{-- Overall --}}
                    <div class="progress-row">

                        <div class="progress-label">

                            <span>
                                Overall completion
                            </span>

                            <strong>
                                {{ $overallProgress }}%
                            </strong>

                        </div>

                        <div class="fitout-progress">

                            <div
                                class="fitout-progress-bar"
                                style="width: {{ $overallProgress }}%"
                            ></div>

                        </div>

                    </div>


                    {{-- Individual stages --}}
                    @forelse($stageProgress as $stage)

                        <div class="progress-row">

                            <div class="progress-label">

                                <span>
                                    {{ $stage->stage_name }}
                                </span>

                                <strong>
                                    {{ $stage->progress }}%
                                </strong>

                            </div>

                            <div class="fitout-progress">

                                <div
                                    class="fitout-progress-bar"
                                    style="width: {{ min(100, max(0, $stage->progress)) }}%"
                                ></div>

                            </div>

                        </div>

                    @empty

                        <div class="text-muted small">
                            No stage progress available.
                        </div>

                    @endforelse


                    <hr class="my-3">


                    <div class="row text-center">

                        <div class="col">

                            <div class="small text-muted">
                                Pending
                            </div>

                            <strong>
                                {{ $stageStatus['Pending'] ?? 0 }}
                            </strong>

                        </div>


                        <div class="col">

                            <div class="small text-muted">
                                In Progress
                            </div>

                            <strong>
                                {{ $stageStatus['In Progress'] ?? 0 }}
                            </strong>

                        </div>


                        <div class="col">

                            <div class="small text-muted">
                                Completed
                            </div>

                            <strong class="text-success">
                                {{ $stageStatus['Completed'] ?? 0 }}
                            </strong>

                        </div>


                        <div class="col">

                            <div class="small text-muted">
                                On Hold
                            </div>

                            <strong class="text-warning">
                                {{ $stageStatus['On Hold'] ?? 0 }}
                            </strong>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- FLOOR --}}
            {{-- ================================================= --}}

            <div class="col-xl-5">

                <div class="data-card">

                    <div class="data-card-title">
                        Units by floor
                    </div>

                    <div class="data-card-subtitle">
                        Active fit-outs versus total units on each level.
                    </div>


                    @forelse($unitsByFloor as $floor)

                        @php

                            $totalUnits =
                                (int) $floor->total_units;

                            $activeUnits =
                                (int) (
                                    $activeUnitsByFloor[
                                        $floor->id
                                    ] ?? 0
                                );

                            $percentage =
                                $totalUnits > 0
                                    ? round(
                                        (
                                            $activeUnits /
                                            $totalUnits
                                        ) * 100
                                    )
                                    : 0;

                        @endphp


                        <div class="floor-row">

                            <div class="d-flex align-items-center gap-3">

                                <div style="width: 90px">

                                    <div class="floor-name">
                                        {{ $floor->floor_name }}
                                    </div>

                                </div>


                                <div class="floor-bar">

                                    <div
                                        class="floor-bar-fill"
                                        style="width: {{ $percentage }}%"
                                    ></div>

                                </div>


                                <div class="floor-count">

                                    {{ $activeUnits }}
                                    /
                                    {{ $totalUnits }}

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="text-muted small">
                            No floor data available.
                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ATTENTION REQUIRED --}}
    {{-- ========================================================= --}}

    <div class="dashboard-section">

        <div class="section-heading">

            <span>
                Attention Required
            </span>

        </div>


        <div class="row g-4">


            {{-- Critical / High Snags --}}
            <div class="col-xl-4">

                <div class="data-card">

                    <div class="data-card-title">
                        Critical & High Snags
                    </div>

                    <div class="data-card-subtitle">
                        Issues requiring immediate attention.
                    </div>


                    @forelse($attentionSnags as $snag)

                        <div class="attention-item">

                            <div class="d-flex gap-2">

                                <span
                                    class="attention-dot {{
                                        $snag->priority === 'Critical'
                                            ? 'attention-critical'
                                            : 'attention-high'
                                    }}"
                                ></span>

                                <div>

                                    <div class="attention-title">

                                        {{ $snag->snag_number }}

                                        -
                                        {{ $snag->title }}

                                    </div>

                                    <div class="attention-meta">

                                        Request:
                                        {{ $snag->request_no }}

                                        &nbsp;|&nbsp;

                                        {{ $snag->priority }}

                                        &nbsp;|&nbsp;

                                        {{ $snag->status }}

                                    </div>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="text-muted small">
                            No critical or high priority snags.
                        </div>

                    @endforelse

                </div>

            </div>


            {{-- Delayed --}}
            <div class="col-xl-4">

                <div class="data-card">

                    <div class="data-card-title">
                        Delayed Fit-Outs
                    </div>

                    <div class="data-card-subtitle">
                        Proposed completion date has passed.
                    </div>


                    @forelse($delayedFitouts as $fitout)

                        <div class="attention-item">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <div class="attention-title">

                                        {{ $fitout->request_no }}

                                    </div>

                                    <div class="attention-meta">

                                        Planned end:
                                        {{
                                            \Carbon\Carbon::parse(
                                                $fitout->proposed_end_date
                                            )->format('d M Y')
                                        }}

                                    </div>

                                </div>


                                <span class="status-pill status-danger">

                                    Delayed

                                </span>

                            </div>

                        </div>

                    @empty

                        <div class="text-muted small">
                            No delayed fit-outs.
                        </div>

                    @endforelse

                </div>

            </div>


            {{-- Inspections --}}
            <div class="col-xl-4">

                <div class="data-card">

                    <div class="data-card-title">
                        Upcoming Inspections
                    </div>

                    <div class="data-card-subtitle">
                        Next inspections requiring attention.
                    </div>


                    @forelse($upcomingInspections as $inspection)

                        <div class="attention-item">

                            <div class="attention-title">

                                {{ $inspection->inspection_number }}

                            </div>

                            <div class="attention-meta">

                                {{ $inspection->request_no }}

                                &nbsp;|&nbsp;

                                {{ $inspection->inspection_type }}

                                <br>

                                {{
                                    \Carbon\Carbon::parse(
                                        $inspection->scheduled_date
                                    )->format('d M Y')
                                }}

                            </div>

                        </div>

                    @empty

                        <div class="text-muted small">
                            No upcoming inspections.
                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

    <div class="dashboard-section">

        <div class="section-heading">

            <span>
                Fit-Out Tracking
            </span>

        </div>


        <div class="dashboard-table">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>
                                Request
                            </th>

                            <th>
                                Unit
                            </th>

                            <th>
                                Tenant
                            </th>

                            <th>
                                Type
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Start
                            </th>

                            <th>
                                End
                            </th>

                            <th>
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($fitouts as $fitout)

                            <tr>

                                <td>

                                    <strong>
                                        {{ $fitout->request_no }}
                                    </strong>

                                </td>


                                <td>
                                    {{ $fitout->unit_id ?? '-' }}
                                </td>


                                <td>
                                    {{ $fitout->tenant_id ?? '-' }}
                                </td>


                                <td>
                                    {{ $fitout->fitout_type ?? '-' }}
                                </td>


                                <td>

                                    @php

                                        $statusClass = match(
                                            $fitout->fitout_status
                                        ) {

                                            'Completed' =>
                                                'status-success',

                                            'Approved',
                                            'In Progress' =>
                                                'status-info',

                                            'Under Review',
                                            'Submitted' =>
                                                'status-warning',

                                            'Rejected' =>
                                                'status-danger',

                                            default =>
                                                'status-muted',

                                        };

                                    @endphp


                                    <span
                                        class="status-pill {{ $statusClass }}"
                                    >
                                        {{ $fitout->fitout_status }}
                                    </span>

                                </td>


                                <td>

                                    {{
                                        $fitout->proposed_start_date
                                        ? \Carbon\Carbon::parse(
                                            $fitout->proposed_start_date
                                        )->format('d M Y')
                                        : '-'
                                    }}

                                </td>


                                <td>

                                    {{
                                        $fitout->proposed_end_date
                                        ? \Carbon\Carbon::parse(
                                            $fitout->proposed_end_date
                                        )->format('d M Y')
                                        : '-'
                                    }}

                                </td>


                                <td>

                                    <a
                                        href="{{
                                            route(
                                                'admin.fitout.requests.show',
                                                $fitout->id
                                            )
                                        }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >

                                        <i class="fas fa-arrow-right"></i>

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="8"
                                    class="text-center py-5 text-muted"
                                >

                                    <i class="bi bi-search fs-3 d-block mb-2"></i>

                                    No fit-out requests match the
                                    selected filters.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if($fitouts->hasPages())

                <div class="p-3 border-top">

                    {{ $fitouts->links() }}

                </div>

            @endif

        </div>

    </div>


</div>

@endsection