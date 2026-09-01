@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}

    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>

            <div class="text-muted small">
                Contract:
                {{ $contract->contract_number }}
            </div>

            <h4 class="mb-1">
                Contract Invoices
            </h4>

            <div class="text-muted">
                Invoice Register
            </div>

        </div>


        <a
            href="{{ route(
                'admin.procurement.tenders.contracts.show',
                [
                    'procurementTender' => $procurementTender,
                    'contract' => $contract,
                ]
            ) }}"
            class="btn btn-outline-secondary"
        >
            Contract
        </a>

    </div>


    {{-- FLASH --}}

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    {{-- SUMMARY --}}

    @php

        $totalInvoices =
            $invoices->count();

        $draftInvoices =
            $invoices
                ->where('status', 'Draft')
                ->count();

        $submittedInvoices =
            $invoices
                ->where('status', 'Submitted')
                ->count();

        $approvedInvoices =
            $invoices
                ->where('status', 'Approved')
                ->count();

        $rejectedInvoices =
            $invoices
                ->where('status', 'Rejected')
                ->count();

    @endphp


    <div class="row g-3 mb-4">

        <div class="col-md">

            <div class="card h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Total
                    </small>

                    <h4 class="mt-2 mb-0">
                        {{ $totalInvoices }}
                    </h4>

                </div>

            </div>

        </div>


        <div class="col-md">

            <div class="card h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Draft
                    </small>

                    <h4 class="mt-2 mb-0">
                        {{ $draftInvoices }}
                    </h4>

                </div>

            </div>

        </div>


        <div class="col-md">

            <div class="card h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Submitted
                    </small>

                    <h4 class="mt-2 mb-0 text-warning">
                        {{ $submittedInvoices }}
                    </h4>

                </div>

            </div>

        </div>


        <div class="col-md">

            <div class="card h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Approved
                    </small>

                    <h4 class="mt-2 mb-0 text-success">
                        {{ $approvedInvoices }}
                    </h4>

                </div>

            </div>

        </div>


        <div class="col-md">

            <div class="card h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Rejected
                    </small>

                    <h4 class="mt-2 mb-0 text-danger">
                        {{ $rejectedInvoices }}
                    </h4>

                </div>

            </div>

        </div>

    </div>


    {{-- INVOICE TABLE --}}

    <div class="card">

        <div class="card-header">

            <strong>
                Invoice Register
            </strong>

        </div>


        <div class="card-body p-0">

            @if($invoices->isNotEmpty())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Invoice
                            </th>

                            <th>
                                Milestone
                            </th>

                            <th>
                                Invoice Date
                            </th>

                            <th>
                                Amount
                            </th>

                            <th>
                                Net Amount
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

                        @foreach($invoices as $invoice)

                            @php

                                $statusClass = match(
                                    $invoice->status
                                ) {

                                    'Approved' =>
                                        'bg-success',

                                    'Rejected' =>
                                        'bg-danger',

                                    'Submitted' =>
                                        'bg-warning text-dark',

                                    'Paid' =>
                                        'bg-success',

                                    default =>
                                        'bg-secondary',

                                };

                            @endphp


                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    <div class="fw-semibold">

                                        {{ $invoice->invoice_number }}

                                    </div>

                                    <div class="small text-muted">

                                        {{ $invoice->invoice_type }}

                                    </div>

                                </td>


                                <td>

                                    @if($invoice->milestone)

                                        <div class="fw-semibold">

                                            {{
                                                $invoice->milestone
                                                    ->milestone_number
                                            }}

                                        </div>

                                        <div class="small text-muted">

                                            {{
                                                $invoice->milestone
                                                    ->milestone_title
                                            }}

                                        </div>

                                    @else

                                        —
                                        
                                    @endif

                                </td>


                                <td>

                                    {{
                                        $invoice->invoice_date
                                            ?->format('d-m-Y')
                                        ?? '—'
                                    }}

                                </td>


                                <td>

                                    {{
                                        number_format(
                                            (float) $invoice->amount,
                                            2
                                        )
                                    }}

                                    {{ $invoice->currency }}

                                </td>


                                <td>

                                    <strong>

                                        {{
                                            number_format(
                                                (float)
                                                $invoice->net_amount,
                                                2
                                            )
                                        }}

                                    </strong>

                                    {{ $invoice->currency }}

                                </td>


                                <td>

                                    <span
                                        class="badge {{ $statusClass }}"
                                    >
                                        {{ $invoice->status }}
                                    </span>

                                </td>


                                <td class="text-end">

                                    <a
                                        href="{{ route(
                                            'admin.procurement.tenders.contracts.invoices.show',
                                            [
                                                'procurementTender' =>
                                                    $procurementTender,

                                                'contract' =>
                                                    $contract,

                                                'invoice' =>
                                                    $invoice,
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

                    <div class="text-muted">

                        No invoices created for this contract.

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection