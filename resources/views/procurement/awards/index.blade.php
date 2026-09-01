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
                Awards
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
                    'admin.procurement.tenders.awards.create',
                    $procurementTender
                ) }}"
                class="btn btn-primary"
            >
                + Create Award
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


    <div class="card">

        <div class="card-header">

            <strong>
                Award Register
            </strong>

        </div>


        <div class="card-body p-0">

            @if($awards->isNotEmpty())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Award Number
                            </th>

                            <th>
                                Bidder
                            </th>

                            <th>
                                Amount
                            </th>

                            <th>
                                Award Date
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

                        @foreach($awards as $award)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    <a
                                        href="{{ route(
                                            'admin.procurement.tenders.awards.show',
                                            [
                                                'procurementTender' =>
                                                    $procurementTender,

                                                'award' =>
                                                    $award,
                                            ]
                                        ) }}"
                                        class="fw-semibold"
                                    >
                                        {{ $award->award_number }}
                                    </a>

                                </td>


                                <td>
                                    {{ $award->bidder_name }}
                                </td>


                                <td>

                                    {{
                                        number_format(
                                            (float)
                                            $award->awarded_amount,
                                            2
                                        )
                                    }}

                                    {{ $award->currency }}

                                </td>


                                <td>

                                    {{
                                        $award->award_date
                                            ?->format('d-m-Y')
                                        ?? '—'
                                    }}

                                </td>


                                <td>

                                    <span class="badge bg-secondary">
                                        {{ $award->status }}
                                    </span>

                                </td>


                                <td class="text-end">

                                    <a
                                        href="{{ route(
                                            'admin.procurement.tenders.awards.show',
                                            [
                                                'procurementTender' =>
                                                    $procurementTender,

                                                'award' =>
                                                    $award,
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
                        No Awards found.
                    </div>

                    <a
                        href="{{ route(
                            'admin.procurement.tenders.awards.create',
                            $procurementTender
                        ) }}"
                        class="btn btn-primary"
                    >
                        + Create Award
                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection