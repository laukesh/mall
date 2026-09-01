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
                Negotiations
            </h4>

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
                    'admin.procurement.tenders.negotiations.create',
                    $procurementTender
                ) }}"
                class="btn btn-primary"
            >
                + Create Negotiation
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
                Negotiation Register
            </strong>

        </div>


        <div class="card-body p-0">

            @if($negotiations->isNotEmpty())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>
                                Negotiation No.
                            </th>

                            <th>
                                Bidder
                            </th>

                            <th>
                                Original Amount
                            </th>

                            <th>
                                Final Amount
                            </th>

                            <th>
                                Outcome
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
                            $negotiations as $negotiation
                        )

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    <a
                                        href="{{ route(
                                            'admin.procurement.tenders.negotiations.show',
                                            [
                                                'procurementTender' =>
                                                    $procurementTender,

                                                'negotiation' =>
                                                    $negotiation,
                                            ]
                                        ) }}"
                                        class="fw-semibold"
                                    >
                                        {{
                                            $negotiation
                                                ->negotiation_number
                                        }}
                                    </a>

                                </td>


                                <td>

                                    {{
                                        $negotiation->bidder_name
                                    }}

                                </td>


                                <td>

                                    {{
                                        number_format(
                                            (float)
                                            $negotiation
                                                ->original_amount,
                                            2
                                        )
                                    }}

                                    {{ $negotiation->currency }}

                                </td>


                                <td>

                                    <strong>

                                        {{
                                            number_format(
                                                (float)
                                                $negotiation
                                                    ->final_amount,
                                                2
                                            )
                                        }}

                                    </strong>

                                    {{ $negotiation->currency }}

                                </td>


                                <td>
                                    {{ $negotiation->outcome }}
                                </td>


                                <td>

                                    <span class="badge bg-secondary">
                                        {{ $negotiation->status }}
                                    </span>

                                </td>


                                <td class="text-end">

                                    <a
                                        href="{{ route(
                                            'admin.procurement.tenders.negotiations.show',
                                            [
                                                'procurementTender' =>
                                                    $procurementTender,

                                                'negotiation' =>
                                                    $negotiation,
                                            ]
                                        ) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
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

                    <div class="text-muted mb-3">
                        No Negotiations found.
                    </div>

                    <a
                        href="{{ route(
                            'admin.procurement.tenders.negotiations.create',
                            $procurementTender
                        ) }}"
                        class="btn btn-primary"
                    >
                        + Create Negotiation
                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection