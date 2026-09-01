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
                Create Milestone Invoice
            </h4>

            <div class="text-muted">

                {{ $milestone->milestone_number }}
                -
                {{ $milestone->milestone_title }}

            </div>

        </div>


        <a
            href="{{ route(
                'admin.procurement.tenders.contracts.milestones.show',
                [
                    'procurementTender' => $procurementTender,
                    'contract' => $contract,
                    'milestone' => $milestone,
                ]
            ) }}"
            class="btn btn-outline-secondary"
        >
            Back to Milestone
        </a>

    </div>


    {{-- ERRORS --}}

    @if($errors->any())

        <div class="alert alert-danger">

            <strong>
                Please correct the following:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- MILESTONE SUMMARY --}}

    <div class="card mb-4">

        <div class="card-header">

            <strong>
                Completed Milestone
            </strong>

        </div>


        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-3">

                    <small class="text-muted d-block">
                        Milestone
                    </small>

                    <strong>
                        {{ $milestone->milestone_number }}
                    </strong>

                </div>


                <div class="col-md-3">

                    <small class="text-muted d-block">
                        Title
                    </small>

                    <strong>
                        {{ $milestone->milestone_title }}
                    </strong>

                </div>


                <div class="col-md-3">

                    <small class="text-muted d-block">
                        Progress
                    </small>

                    <strong class="text-success">
                        {{ number_format(
                            (float) $milestone->progress_percentage,
                            2
                        ) }}%
                    </strong>

                </div>


                <div class="col-md-3">

                    <small class="text-muted d-block">
                        Status
                    </small>

                    <span class="badge bg-success">
                        {{ $milestone->status }}
                    </span>

                </div>

            </div>

        </div>

    </div>


    {{-- INVOICE FORM --}}

    <form
        method="POST"
        action="{{ route(
            'admin.procurement.tenders.contracts.milestones.invoice.store',
            [
                'procurementTender' => $procurementTender,
                'contract' => $contract,
                'milestone' => $milestone,
            ]
        ) }}"
        id="invoiceForm"
    >

        @csrf


        <div class="card">

            <div class="card-header">

                <strong>
                    Invoice Details
                </strong>

            </div>


            <div class="card-body">

                <div class="row g-3">


                    {{-- INVOICE NUMBER --}}

                    <div class="col-md-4">

                        <label class="form-label">

                            Invoice Number
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="invoice_number"
                            class="form-control"
                            value="{{ old('invoice_number') }}"
                            placeholder="INV-2026-001"
                            required
                        >

                    </div>


                    {{-- INVOICE DATE --}}

                    <div class="col-md-4">

                        <label class="form-label">

                            Invoice Date
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="date"
                            name="invoice_date"
                            class="form-control"
                            value="{{ old(
                                'invoice_date',
                                now()->format('Y-m-d')
                            ) }}"
                            required
                        >

                    </div>


                    {{-- CURRENCY --}}

                    <div class="col-md-4">

                        <label class="form-label">

                            Currency
                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="currency"
                            class="form-select"
                            required
                        >

                            <option
                                value="INR"
                                @selected(
                                    old('currency', 'INR') === 'INR'
                                )
                            >
                                INR - Indian Rupee
                            </option>

                            <option
                                value="USD"
                                @selected(
                                    old('currency') === 'USD'
                                )
                            >
                                USD - US Dollar
                            </option>

                            <option
                                value="EUR"
                                @selected(
                                    old('currency') === 'EUR'
                                )
                            >
                                EUR - Euro
                            </option>

                        </select>

                    </div>


                    {{-- AMOUNT --}}

                    <div class="col-md-4">

                        <label class="form-label">

                            Base Amount
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="number"
                            name="amount"
                            id="amount"
                            class="form-control amount-field"
                            value="{{ old('amount') }}"
                            min="0"
                            step="0.01"
                            required
                        >

                    </div>


                    {{-- TAX --}}

                    <div class="col-md-4">

                        <label class="form-label">
                            Tax Amount
                        </label>

                        <input
                            type="number"
                            name="tax_amount"
                            id="tax_amount"
                            class="form-control amount-field"
                            value="{{ old('tax_amount', 0) }}"
                            min="0"
                            step="0.01"
                        >

                    </div>


                    {{-- DISCOUNT --}}

                    <div class="col-md-4">

                        <label class="form-label">
                            Discount Amount
                        </label>

                        <input
                            type="number"
                            name="discount_amount"
                            id="discount_amount"
                            class="form-control amount-field"
                            value="{{ old('discount_amount', 0) }}"
                            min="0"
                            step="0.01"
                        >

                    </div>


                    {{-- NET AMOUNT --}}

                    <div class="col-md-4">

                        <label class="form-label">
                            Net Amount
                        </label>

                        <input
                            type="text"
                            id="net_amount_display"
                            class="form-control fw-bold"
                            value="0.00"
                            readonly
                        >

                        <div class="form-text">
                            Base + Tax - Discount
                        </div>

                    </div>


                    {{-- DESCRIPTION --}}

                    <div class="col-12">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="4"
                            placeholder="Invoice description..."
                        >{{ old('description') }}</textarea>

                    </div>


                    {{-- REMARKS --}}

                    <div class="col-12">

                        <label class="form-label">
                            Remarks
                        </label>

                        <textarea
                            name="remarks"
                            class="form-control"
                            rows="4"
                            placeholder="Additional remarks..."
                        >{{ old('remarks') }}</textarea>

                    </div>

                </div>

            </div>

        </div>


        {{-- ACTIONS --}}

        <div class="d-flex justify-content-end gap-2 mt-4">

            <a
                href="{{ route(
                    'admin.procurement.tenders.contracts.milestones.show',
                    [
                        'procurementTender' => $procurementTender,
                        'contract' => $contract,
                        'milestone' => $milestone,
                    ]
                ) }}"
                class="btn btn-outline-secondary"
            >
                Cancel
            </a>


            <button
                type="submit"
                class="btn btn-primary"
            >
                Create Invoice
            </button>

        </div>

    </form>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const amount =
        document.getElementById('amount');

    const tax =
        document.getElementById('tax_amount');

    const discount =
        document.getElementById('discount_amount');

    const netAmount =
        document.getElementById('net_amount_display');


    function calculateNetAmount() {

        const base =
            parseFloat(amount.value) || 0;

        const taxValue =
            parseFloat(tax.value) || 0;

        const discountValue =
            parseFloat(discount.value) || 0;


        const result =
            base
            + taxValue
            - discountValue;


        netAmount.value =
            result.toFixed(2);
    }


    document
        .querySelectorAll('.amount-field')
        .forEach(function (field) {

            field.addEventListener(
                'input',
                calculateNetAmount
            );

        });


    calculateNetAmount();

});

</script>

@endsection