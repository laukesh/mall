@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>

            <div class="text-muted small">
                Tender:
                {{ $procurementTender->tender_number }}
            </div>

            <h4 class="mb-1">
                Bid Comparisons
            </h4>

            <div class="text-muted">
                {{ $procurementTender->tender_title }}
            </div>

        </div>


        <div class="d-flex gap-2">

            <a
                href="{{ route(
                    'admin.procurement.tenders.show',
                    $procurementTender
                ) }}"
                class="btn btn-outline-secondary"
            >
                Tender
            </a>


            <a
                href="{{ route(
                    'admin.procurement.tenders.bid-comparisons.create',
                    $procurementTender
                ) }}"
                class="btn btn-primary"
            >
                + Create Comparison
            </a>

        </div>

    </div>


    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    <div class="card">

        <div class="card-header">

            <strong>
                Bid Comparison Register
            </strong>

        </div>


        <div class="card-body p-0">

            @if($comparisons->isNotEmpty())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>
                                Comparison No.
                            </th>

                            <th>
                                Title
                            </th>

                            <th>
                                Bidders
                            </th>

                            <th>
                                Lowest Evaluated Amount
                            </th>

                            <th>
                                Recommended Bidder
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end">
                                Action
                            </th>

                        </tr>

                        </thead>


                        <tbody>

                        @foreach(
                            $comparisons as $comparison
                        )

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    <a
                                        href="{{ route(
                                            'admin.procurement.tenders.bid-comparisons.show',
                                            [
                                                'procurementTender' =>
                                                    $procurementTender,

                                                'comparison' =>
                                                    $comparison,
                                            ]
                                        ) }}"
                                        class="fw-semibold"
                                    >
                                        {{
                                            $comparison
                                                ->comparison_number
                                        }}
                                    </a>

                                </td>


                                <td>
                                    {{ $comparison->comparison_title }}
                                </td>


                                <td>

                                    <span class="badge bg-info">
                                        {{ $comparison->qualified_bidders }}
                                    </span>

                                </td>


                                <td>

                                    <strong>

                                        {{
                                            number_format(
                                                (float)
                                                $comparison
                                                    ->lowest_evaluated_amount,
                                                2
                                            )
                                        }}

                                    </strong>

                                    {{ $comparison->currency }}

                                </td>


                                <td>

                                    {{
                                        $comparison
                                            ->recommendedSubmission
                                            ?->tenderBidder
                                            ?->bidder
                                            ?->company_name
                                        ?? '—'
                                    }}

                                </td>


                                <td>

                                    @php

                                        $statusClass = match(
                                            $comparison->status
                                        ) {

                                            'Approved' =>
                                                'bg-success',

                                            'Completed' =>
                                                'bg-primary',

                                            'Under Review' =>
                                                'bg-warning text-dark',

                                            'Rejected' =>
                                                'bg-danger',

                                            default =>
                                                'bg-secondary',
                                        };

                                    @endphp

                                    <span
                                        class="badge {{ $statusClass }}"
                                    >
                                        {{ $comparison->status }}
                                    </span>

                                </td>


                                <td class="text-end">

                                    <a
                                        href="{{ route(
                                            'admin.procurement.tenders.bid-comparisons.show',
                                            [
                                                'procurementTender' =>
                                                    $procurementTender,

                                                'comparison' =>
                                                    $comparison,
                                            ]
                                        ) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        View
                                    </a>


                                    <a
                                        href="{{ route(
                                            'admin.procurement.tenders.bid-comparisons.edit',
                                            [
                                                'procurementTender' =>
                                                    $procurementTender,

                                                'comparison' =>
                                                    $comparison,
                                            ]
                                        ) }}"
                                        class="btn btn-sm btn-outline-secondary"
                                    >
                                        Edit
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <div class="text-muted mb-3">
                        No Bid Comparisons found.
                    </div>

                    <a
                        href="{{ route(
                            'admin.procurement.tenders.bid-comparisons.create',
                            $procurementTender
                        ) }}"
                        class="btn btn-primary"
                    >
                        + Create First Comparison
                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection