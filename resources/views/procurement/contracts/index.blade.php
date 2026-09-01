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
                Contracts
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
                    'admin.procurement.tenders.contracts.create',
                    $procurementTender
                ) }}"
                class="btn btn-primary"
            >
                + Create Contract
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
                Contract Register
            </strong>

        </div>


        <div class="card-body p-0">

            @if($contracts->isNotEmpty())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Contract
                            </th>

                            <th>
                                Bidder
                            </th>

                            <th>
                                Amount
                            </th>

                            <th>
                                Start
                            </th>

                            <th>
                                End
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

                        @foreach($contracts as $contract)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    <a
                                        href="{{ route(
                                            'admin.procurement.tenders.contracts.show',
                                            [
                                                'procurementTender' =>
                                                    $procurementTender,

                                                'contract' =>
                                                    $contract,
                                            ]
                                        ) }}"
                                        class="fw-semibold"
                                    >
                                        {{ $contract->contract_number }}
                                    </a>

                                    <div class="small text-muted">
                                        {{ $contract->contract_title }}
                                    </div>

                                </td>


                                <td>
                                    {{ $contract->bidder_name }}
                                </td>


                                <td>

                                    {{
                                        number_format(
                                            (float)
                                            $contract->contract_amount,
                                            2
                                        )
                                    }}

                                    {{ $contract->currency }}

                                </td>


                                <td>

                                    {{
                                        $contract->contract_start_date
                                            ?->format('d-m-Y')
                                        ?? '—'
                                    }}

                                </td>


                                <td>

                                    {{
                                        $contract->contract_end_date
                                            ?->format('d-m-Y')
                                        ?? '—'
                                    }}

                                </td>


                                <td>

                                    <span class="badge bg-secondary">
                                        {{ $contract->status }}
                                    </span>

                                </td>


                                <td class="text-end">

                                    <a
                                        href="{{ route(
                                            'admin.procurement.tenders.contracts.show',
                                            [
                                                'procurementTender' =>
                                                    $procurementTender,

                                                'contract' =>
                                                    $contract,
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
                        No Contracts found.
                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection