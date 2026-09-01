@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>

            <div class="text-muted small">
                Tender:
                {{ $procurementTender->tender_number }}
            </div>

            <h4>
                {{ $award->award_number }}
            </h4>

            <div class="text-muted">
                {{ $award->award_title }}
            </div>

        </div>


        <div class="d-flex flex-wrap gap-2">

            {{-- BACK --}}
            <a
                href="{{ route(
                    'admin.procurement.tenders.awards.index',
                    $procurementTender
                ) }}"
                class="btn btn-outline-secondary"
            >
                Back
            </a>

            <a
                href="{{ route(
                    'admin.procurement.tenders.purchase-orders.index',
                    [
                        'procurementTender' => $procurementTender,
                    ]
                ) }}"
                class="btn btn-outline-primary"
            >
                Purchase Orders
            </a>

            @if($award->status === 'LOA Issued')

                <a
                    href="{{ route(
                        'admin.procurement.tenders.purchase-orders.create',
                        [
                            'procurementTender' => $procurementTender,
                            'procurementAward' => $award,
                        ]
                    ) }}"
                    class="btn btn-primary"
                >
                    + Create Purchase Order
                </a>

            @endif


            {{-- ==================================================
                SUBMIT AWARD
            =================================================== --}}
            @if($award->status === 'Draft')

                <form
                    method="POST"
                    action="{{ route(
                        'admin.procurement.tenders.awards.submit',
                        [
                            'procurementTender' =>
                                $procurementTender,

                            'award' =>
                                $award,
                        ]
                    ) }}"
                    onsubmit="return confirm(
                        'Submit this Award for approval?'
                    );"
                >

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Submit for Approval
                    </button>

                </form>

            @endif


            {{-- ==================================================
                APPROVE AWARD
            =================================================== --}}
            @if($award->status === 'Under Review')

                <button
                    type="button"
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#approveAwardModal"
                >
                    Approve Award
                </button>

            @endif


            {{-- ==================================================
                ISSUE LOA
            =================================================== --}}
            @if($award->status === 'Approved')

                <button
                    type="button"
                    class="btn btn-warning"
                    data-bs-toggle="modal"
                    data-bs-target="#issueLoaModal"
                >
                    Issue LOA
                </button>

            @endif

        </div>

    </div>


    <div class="row g-3 mb-4">

        <div class="col-md-3">

            <div class="card h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Awarded Bidder
                    </small>

                    <h6 class="mt-2">
                        {{ $award->bidder_name }}
                    </h6>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Award Amount
                    </small>

                    <h5 class="mt-2">

                        {{
                            number_format(
                                (float)
                                $award->awarded_amount,
                                2
                            )
                        }}

                        {{ $award->currency }}

                    </h5>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Award Date
                    </small>

                    <h6 class="mt-2">

                        {{
                            $award->award_date
                                ?->format('d-m-Y')
                            ?? '—'
                        }}

                    </h6>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Status
                    </small>

                    <div class="mt-2">

                        <span class="badge bg-secondary">
                            {{ $award->status }}
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="card mb-4">

        <div class="card-header">
            <strong>Award Information</strong>
        </div>

        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Award Number
                    </small>

                    <strong>
                        {{ $award->award_number }}
                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Award Type
                    </small>

                    <strong>
                        {{ $award->award_type }}
                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        LOA Number
                    </small>

                    <strong>
                        {{ $award->loa_number ?? '—' }}
                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        LOA Date
                    </small>

                    <strong>

                        {{
                            $award->loa_date
                                ?->format('d-m-Y')
                            ?? '—'
                        }}

                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Acceptance Deadline
                    </small>

                    <strong>

                        {{
                            $award->acceptance_deadline
                                ?->format('d-m-Y')
                            ?? '—'
                        }}

                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Contract Required
                    </small>

                    <strong>

                        {{
                            $award->contract_required
                                ? 'Yes'
                                : 'No'
                        }}

                    </strong>

                </div>

            </div>

        </div>

    </div>
    <div class="card mb-4">

        <div class="card-header">

            <strong>
                Approval & LOA
            </strong>

        </div>


        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-3">

                    <small class="text-muted d-block">
                        Status
                    </small>

                    @php

                        $awardStatusClass = match(
                            $award->status
                        ) {

                            'Approved' =>
                                'bg-success',

                            'LOA Issued' =>
                                'bg-warning text-dark',

                            'Under Review' =>
                                'bg-primary',

                            default =>
                                'bg-secondary',
                        };

                    @endphp


                    <span
                        class="badge {{ $awardStatusClass }}"
                    >
                        {{ $award->status }}
                    </span>

                </div>


                <div class="col-md-3">

                    <small class="text-muted d-block">
                        Submitted At
                    </small>

                    <strong>

                        {{
                            $award->submitted_at
                                ?->format('d-m-Y H:i')
                            ?? '—'
                        }}

                    </strong>

                </div>


                <div class="col-md-3">

                    <small class="text-muted d-block">
                        Approval Date
                    </small>

                    <strong>

                        {{
                            $award->approval_date
                                ?->format('d-m-Y')
                            ?? '—'
                        }}

                    </strong>

                </div>


                <div class="col-md-3">

                    <small class="text-muted d-block">
                        LOA Number
                    </small>

                    <strong>
                        {{ $award->loa_number ?? '—' }}
                    </strong>

                </div>


                <div class="col-md-3">

                    <small class="text-muted d-block">
                        LOA Date
                    </small>

                    <strong>

                        {{
                            $award->loa_date
                                ?->format('d-m-Y')
                            ?? '—'
                        }}

                    </strong>

                </div>


                <div class="col-md-3">

                    <small class="text-muted d-block">
                        Acceptance Deadline
                    </small>

                    <strong>

                        {{
                            $award->acceptance_deadline
                                ?->format('d-m-Y')
                            ?? '—'
                        }}

                    </strong>

                </div>


                <div class="col-md-6">

                    <small class="text-muted d-block">
                        Approval Remarks
                    </small>

                    <div>
                        {{ $award->approval_remarks ?? '—' }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="card mb-4">

        <div class="card-header">
            <strong>Description</strong>
        </div>

        <div class="card-body">

            {!! nl2br(
                e(
                    $award->description
                    ?? 'No description provided.'
                )
            ) !!}

        </div>

    </div>


    <div class="card mb-4">

        <div class="card-header">
            <strong>Terms & Conditions</strong>
        </div>

        <div class="card-body">

            {!! nl2br(
                e(
                    $award->terms_and_conditions
                    ?? 'No terms and conditions provided.'
                )
            ) !!}

        </div>

    </div>


    <div class="card">

        <div class="card-header">
            <strong>Remarks</strong>
        </div>

        <div class="card-body">

            {!! nl2br(
                e(
                    $award->remarks
                    ?? 'No remarks provided.'
                )
            ) !!}

        </div>

    </div>



    @if($award->status === 'Under Review')

        <div
            class="modal fade"
            id="approveAwardModal"
            tabindex="-1"
        >

            <div class="modal-dialog">

                <form
                    method="POST"
                    action="{{ route(
                        'admin.procurement.tenders.awards.approve',
                        [
                            'procurementTender' =>
                                $procurementTender,

                            'award' =>
                                $award,
                        ]
                    ) }}"
                    class="modal-content"
                >

                    @csrf


                    <div class="modal-header">

                        <h5 class="modal-title">
                            Approve Award
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                        ></button>

                    </div>


                    <div class="modal-body">

                        <div class="alert alert-info">

                            Award Amount:

                            <strong>

                                {{
                                    number_format(
                                        (float)
                                        $award->awarded_amount,
                                        2
                                    )
                                }}

                                {{ $award->currency }}

                            </strong>

                        </div>


                        <label class="form-label">
                            Approval Remarks
                        </label>

                        <textarea
                            name="approval_remarks"
                            rows="4"
                            class="form-control"
                        ></textarea>

                    </div>


                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="btn btn-success"
                        >
                            Approve Award
                        </button>

                    </div>

                </form>

            </div>

        </div>

        @endif

        @if($award->status === 'Approved')

        <div
            class="modal fade"
            id="issueLoaModal"
            tabindex="-1"
        >

            <div class="modal-dialog">

                <form
                    method="POST"
                    action="{{ route(
                        'admin.procurement.tenders.awards.issue-loa',
                        [
                            'procurementTender' =>
                                $procurementTender,

                            'award' =>
                                $award,
                        ]
                    ) }}"
                    class="modal-content"
                >

                    @csrf


                    <div class="modal-header">

                        <h5 class="modal-title">
                            Issue Letter of Award
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                        ></button>

                    </div>


                    <div class="modal-body">

                        <div class="alert alert-success">

                            Award approved for:

                            <strong>

                                {{ $award->bidder_name }}

                            </strong>

                            <br>

                            Amount:

                            <strong>

                                {{
                                    number_format(
                                        (float)
                                        $award->awarded_amount,
                                        2
                                    )
                                }}

                                {{ $award->currency }}

                            </strong>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                LOA Number
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="loa_number"
                                class="form-control"
                                placeholder="LOA-2026-001"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                LOA Date
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="date"
                                name="loa_date"
                                class="form-control"
                                value="{{ now()->format('Y-m-d') }}"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Acceptance Deadline
                            </label>

                            <input
                                type="date"
                                name="acceptance_deadline"
                                class="form-control"
                            >

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="btn btn-warning"
                        >
                            Issue LOA
                        </button>

                    </div>

                </form>

            </div>

        </div>

        @endif

</div>

@endsection