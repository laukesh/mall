@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">
                {{ $procurementBidder->company_name }}
            </h4>

            <div class="text-muted">
                {{ $procurementBidder->bidder_code }}
            </div>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route(
                'admin.procurement.bidders.edit',
                $procurementBidder
            ) }}"
               class="btn btn-primary">
                Edit
            </a>

            <a href="{{ route(
                'admin.procurement.bidders.index'
            ) }}"
               class="btn btn-outline-secondary">
                Back
            </a>

        </div>

    </div>


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


    <div class="row g-4">

        <div class="col-lg-8">

            <div class="card mb-4">

                <div class="card-header">
                    <strong>Company Information</strong>
                </div>

                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-6">

                            <div class="text-muted small">
                                Bidder Code
                            </div>

                            <div class="fw-semibold">
                                {{ $procurementBidder->bidder_code }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted small">
                                Company Name
                            </div>

                            <div class="fw-semibold">
                                {{ $procurementBidder->company_name }}
                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="text-muted small">
                                Registration No.
                            </div>

                            <div>
                                {{
                                    $procurementBidder
                                        ->company_registration_no
                                    ?: '—'
                                }}
                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="text-muted small">
                                GST Number
                            </div>

                            <div>
                                {{
                                    $procurementBidder->gst_number
                                    ?: '—'
                                }}
                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="text-muted small">
                                PAN Number
                            </div>

                            <div>
                                {{
                                    $procurementBidder->pan_number
                                    ?: '—'
                                }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted small">
                                Contact Person
                            </div>

                            <div>
                                {{
                                    $procurementBidder->contact_person
                                    ?: '—'
                                }}
                            </div>

                        </div>


                        <div class="col-md-3">

                            <div class="text-muted small">
                                Email
                            </div>

                            <div>
                                {{
                                    $procurementBidder->email
                                    ?: '—'
                                }}
                            </div>

                        </div>


                        <div class="col-md-3">

                            <div class="text-muted small">
                                Phone
                            </div>

                            <div>
                                {{
                                    $procurementBidder->phone
                                    ?: '—'
                                }}
                            </div>

                        </div>


                        <div class="col-12">

                            <div class="text-muted small">
                                Address
                            </div>

                            <div>
                                {!! nl2br(
                                    e(
                                        $procurementBidder->address
                                        ?: '—'
                                    )
                                ) !!}
                            </div>

                        </div>


                        <div class="col-md-3">

                            <div class="text-muted small">
                                City
                            </div>

                            <div>
                                {{
                                    $procurementBidder->city
                                    ?: '—'
                                }}
                            </div>

                        </div>


                        <div class="col-md-3">

                            <div class="text-muted small">
                                State
                            </div>

                            <div>
                                {{
                                    $procurementBidder->state
                                    ?: '—'
                                }}
                            </div>

                        </div>


                        <div class="col-md-3">

                            <div class="text-muted small">
                                Country
                            </div>

                            <div>
                                {{
                                    $procurementBidder->country
                                    ?: '—'
                                }}
                            </div>

                        </div>


                        <div class="col-md-3">

                            <div class="text-muted small">
                                Postal Code
                            </div>

                            <div>
                                {{
                                    $procurementBidder->postal_code
                                    ?: '—'
                                }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="card">

                <div class="card-header">
                    <strong>Tender Participation</strong>
                </div>

                <div class="card-body p-0">

                    @if(
                        $procurementBidder
                            ->tenderBidders
                            ->count()
                    )

                        <div class="table-responsive">

                            <table class="table table-hover mb-0">

                                <thead class="table-light">

                                <tr>
                                    <th>Tender</th>
                                    <th>Package</th>
                                    <th>Participation</th>
                                    <th>Registration Date</th>
                                </tr>

                                </thead>

                                <tbody>

                                @foreach(
                                    $procurementBidder
                                        ->tenderBidders
                                    as $tenderBidder
                                )

                                    <tr>

                                        <td>

                                            <a href="{{ route(
                                                'admin.procurement.tenders.show',
                                                $tenderBidder->tender
                                            ) }}"
                                               class="text-decoration-none">

                                                {{
                                                    $tenderBidder
                                                        ->tender
                                                        ->tender_number
                                                }}

                                            </a>

                                        </td>

                                        <td>
                                            {{
                                                $tenderBidder
                                                    ->tender
                                                    ->procurementPackage
                                                    ->package_number
                                            }}
                                        </td>

                                        <td>
                                            {{
                                                $tenderBidder
                                                    ->participation_status
                                            }}
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

                                    </tr>

                                @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="text-center text-muted py-5">
                            This bidder has not participated in any Tender yet.
                        </div>

                    @endif

                </div>

            </div>

        </div>


        <div class="col-lg-4">

            <div class="card mb-4">

                <div class="card-header">
                    <strong>Status</strong>
                </div>

                <div class="card-body">

                    @php
                        $statusClass = match(
                            $procurementBidder->status
                        ) {
                            'Active' => 'bg-success',
                            'Inactive' => 'bg-secondary',
                            'Blacklisted' => 'bg-danger',
                            default => 'bg-secondary',
                        };
                    @endphp

                    <span class="badge {{ $statusClass }} fs-6">
                        {{ $procurementBidder->status }}
                    </span>

                </div>

            </div>


            <div class="card">

                <div class="card-header">
                    <strong>Remarks</strong>
                </div>

                <div class="card-body">

                    {!! nl2br(
                        e(
                            $procurementBidder->remarks
                            ?: '—'
                        )
                    ) !!}

                </div>

            </div>

        </div>

    </div>

</div>

@endsection