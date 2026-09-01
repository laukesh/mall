@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">
                Tender Bidders
            </h4>

            <div class="text-muted">

                {{ $procurementTender->tender_number }}

                @if($procurementTender->tender_title)
                    - {{ $procurementTender->tender_title }}
                @endif

            </div>
        </div>

        <a href="{{ url()->previous() }}"
           class="btn btn-outline-secondary">
            Back
        </a>

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


    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Please correct the following:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="row g-4">

        {{-- Tender Information --}}
        <div class="col-12">

            <div class="card">

                <div class="card-header">
                    <strong>Tender Information</strong>
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-3">

                            <div class="text-muted small">
                                Tender Number
                            </div>

                            <div class="fw-semibold">
                                {{ $procurementTender->tender_number }}
                            </div>

                        </div>


                        <div class="col-md-5">

                            <div class="text-muted small">
                                Tender Title
                            </div>

                            <div class="fw-semibold">
                                {{ $procurementTender->tender_title }}
                            </div>

                        </div>


                        <div class="col-md-2">

                            <div class="text-muted small">
                                Tender Type
                            </div>

                            <div>
                                {{ $procurementTender->tender_type ?? '—' }}
                            </div>

                        </div>


                        <div class="col-md-2">

                            <div class="text-muted small">
                                Status
                            </div>

                            <div>
                                <span class="badge bg-secondary">
                                    {{ $procurementTender->status ?? '—' }}
                                </span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Add Bidder --}}
        <div class="col-lg-4">

            <div class="card">

                <div class="card-header">

                    <strong>
                        Add Bidder
                    </strong>

                </div>

                <div class="card-body">

                    @if($availableBidders->count())

                        <form method="POST"
                              action="{{ route(
                                  'admin.procurement.tenders.bidders.store',
                                  $procurementTender
                              ) }}">

                            @csrf


                            {{-- Bidder --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Bidder
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="procurement_bidder_id"
                                        class="form-select"
                                        required>

                                    <option value="">
                                        -- Select Bidder --
                                    </option>

                                    @foreach(
                                        $availableBidders
                                        as $bidder
                                    )

                                        <option value="{{ $bidder->id }}"
                                            @selected(
                                                old(
                                                    'procurement_bidder_id'
                                                ) == $bidder->id
                                            )>

                                            {{ $bidder->company_name }}

                                            -
                                            {{ $bidder->bidder_code }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- Reference --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Bidder Reference No.
                                </label>

                                <input type="text"
                                       name="bidder_reference_no"
                                       class="form-control"
                                       value="{{ old(
                                           'bidder_reference_no'
                                       ) }}"
                                       placeholder="Optional">

                            </div>


                            {{-- Invitation Date --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Invitation Date
                                </label>

                                <input type="date"
                                       name="invitation_date"
                                       class="form-control"
                                       value="{{ old(
                                           'invitation_date'
                                       ) }}">

                            </div>


                            {{-- Registration Date --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Registration Date
                                </label>

                                <input type="date"
                                       name="registration_date"
                                       class="form-control"
                                       value="{{ old(
                                           'registration_date'
                                       ) }}">

                            </div>


                            {{-- Participation Status --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Participation Status
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="participation_status"
                                        class="form-select"
                                        required>

                                    @foreach([
                                        'Invited',
                                        'Registered',
                                        'Participating',
                                        'Withdrawn',
                                        'Disqualified',
                                        'Awarded',
                                    ] as $status)

                                        <option
                                            value="{{ $status }}"
                                            @selected(
                                                old(
                                                    'participation_status',
                                                    'Invited'
                                                ) === $status
                                            )
                                        >
                                            {{ $status }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- Prequalification --}}
                            <div class="mb-3">

                                <div class="form-check">

                                    <input
                                        type="checkbox"
                                        name="prequalification_required"
                                        value="1"
                                        class="form-check-input"
                                        id="prequalification_required"
                                        @checked(
                                            old(
                                                'prequalification_required'
                                            )
                                        )
                                    >

                                    <label
                                        class="form-check-label"
                                        for="prequalification_required"
                                    >
                                        Prequalification Required
                                    </label>

                                </div>

                            </div>


                            {{-- Remarks --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Remarks
                                </label>

                                <textarea
                                    name="remarks"
                                    rows="3"
                                    class="form-control"
                                >{{ old('remarks') }}</textarea>

                            </div>


                            <button type="submit"
                                    class="btn btn-primary w-100">

                                Add Bidder

                            </button>

                        </form>

                    @else

                        <div class="text-center py-4">

                            <div class="text-muted mb-3">
                                No active bidders are available.
                            </div>

                            <a href="{{ route(
                                'admin.procurement.bidders.create'
                            ) }}"
                               class="btn btn-outline-primary">

                                + Create Bidder

                            </a>

                        </div>

                    @endif

                </div>

            </div>

        </div>


        {{-- Assigned Bidders --}}
        <div class="col-lg-8">

            <div class="card">

                <div class="card-header d-flex justify-content-between">

                    <strong>
                        Assigned Bidders
                    </strong>

                    <span class="badge bg-primary">
                        {{ $procurementTender->tenderBidders->count() }}
                    </span>

                </div>


                <div class="card-body p-0">

                    @if(
                        $procurementTender
                            ->tenderBidders
                            ->count()
                    )

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">

                                <tr>

                                    <th>#</th>

                                    <th>Bidder</th>

                                    <th>Reference No.</th>

                                    <th>Participation</th>

                                    <th>Prequalification</th>

                                    <th>Registration</th>

                                    <th class="text-end">
                                        Action
                                    </th>

                                </tr>

                                </thead>


                                <tbody>

                                @foreach(
                                    $procurementTender->tenderBidders
                                    as $tenderBidder
                                )

                                    <tr>

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>


                                        <td>

                                            <div class="fw-semibold">

                                                {{
                                                    $tenderBidder
                                                        ->bidder
                                                        ->company_name
                                                }}

                                            </div>

                                            <div class="small text-muted">

                                                {{
                                                    $tenderBidder
                                                        ->bidder
                                                        ->bidder_code
                                                }}

                                            </div>

                                        </td>


                                        <td>

                                            {{
                                                $tenderBidder
                                                    ->bidder_reference_no
                                                    ?: '—'
                                            }}

                                        </td>


                                        <td>

                                            @php

                                                $participationClass =
                                                    match(
                                                        $tenderBidder
                                                            ->participation_status
                                                    ) {

                                                        'Awarded'
                                                            => 'bg-success',

                                                        'Disqualified'
                                                            => 'bg-danger',

                                                        'Withdrawn'
                                                            => 'bg-secondary',

                                                        'Participating'
                                                            => 'bg-primary',

                                                        'Registered'
                                                            => 'bg-info',

                                                        default
                                                            => 'bg-warning text-dark',

                                                    };

                                            @endphp


                                            <span class="badge {{ $participationClass }}">

                                                {{
                                                    $tenderBidder
                                                        ->participation_status
                                                }}

                                            </span>

                                        </td>


                                        <td>

                                            @if(
                                                $tenderBidder
                                                    ->prequalification_required
                                            )

                                                <span class="badge bg-warning text-dark">
                                                    Required
                                                </span>

                                            @else

                                                <span class="badge bg-secondary">
                                                    Not Required
                                                </span>

                                            @endif

                                        </td>


                                        <td>

                                            {{
                                                $tenderBidder
                                                    ->registration_date
                                                    ? $tenderBidder
                                                        ->registration_date
                                                        ->format('d-m-Y')
                                                    : '—'
                                            }}

                                        </td>


                                        <td class="text-end">

                                            <form method="POST"
                                                  action="{{ route(
                                                      'admin.procurement.tenders.bidders.destroy',
                                                      [
                                                          'procurementTender'
                                                              => $procurementTender,
                                                          'tenderBidder'
                                                              => $tenderBidder,
                                                      ]
                                                  ) }}">

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Remove this bidder from the Tender?')"
                                                >

                                                    Remove

                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="text-center py-5">

                            <div class="text-muted">

                                No bidders have been assigned
                                to this Tender yet.

                            </div>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection