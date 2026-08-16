@extends('layouts.app')

@section('title', 'Vendor Payment Details')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1"><i class="fas fa-layer-group me-2"></i>Vendor Payment Details</h4>
            <div class="text-muted">View vendor payment information.</div>
        </div>
        <div>
            @can('vendor_payments.edit')
                <a href="{{ route('admin.maintenance.vendor_payments.edit', $item->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            @endcan
            <a href="{{ route('admin.maintenance.vendor_payments.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Vendor Payment Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">Payment Number</dt>
                        <dd class="col-sm-7">{{ $item->payment_number ?? '-' }}</dd>

                        <dt class="col-sm-5">Vendor User ID</dt>
                        <dd class="col-sm-7">{{ $item->vendor_user_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Contract ID</dt>
                        <dd class="col-sm-7">{{ $item->contract_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Invoice Number</dt>
                        <dd class="col-sm-7">{{ $item->invoice_number ?? '-' }}</dd>

                        <dt class="col-sm-5">Invoice Date</dt>
                        <dd class="col-sm-7">{{ $item->invoice_date?->format('d M Y') ?? '-' }}</dd>

                        <dt class="col-sm-5">Invoice Amount</dt>
                        <dd class="col-sm-7">{{ $item->invoice_amount ?? '-' }}</dd>

                        <dt class="col-sm-5">Tax Amount</dt>
                        <dd class="col-sm-7">{{ $item->tax_amount ?? '-' }}</dd>

                        </dl></div>
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">TDS Amount</dt>
                        <dd class="col-sm-7">{{ $item->tds_amount ?? '-' }}</dd>

                        <dt class="col-sm-5">Other Deduction</dt>
                        <dd class="col-sm-7">{{ $item->other_deduction ?? '-' }}</dd>

                        <dt class="col-sm-5">Net Amount</dt>
                        <dd class="col-sm-7">{{ $item->net_amount ?? '-' }}</dd>

                        <dt class="col-sm-5">Payment Date</dt>
                        <dd class="col-sm-7">{{ $item->payment_date?->format('d M Y') ?? '-' }}</dd>

                        <dt class="col-sm-5">Payment Method</dt>
                        <dd class="col-sm-7">{{ $item->payment_method ?? '-' }}</dd>

                        <dt class="col-sm-5">Transaction Reference</dt>
                        <dd class="col-sm-7">{{ $item->transaction_reference ?? '-' }}</dd>

                        <dt class="col-sm-5">Status</dt>
                        <dd class="col-sm-7">{{ $item->status ?? '-' }}</dd>

                        <dt class="col-sm-5">Remarks</dt>
                        <dd class="col-sm-7">{{ $item->remarks ?? '-' }}</dd>

                        </dl></div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white"><h5 class="mb-0"><i class="fas fa-history me-2"></i>Audit Information</h5></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3"><strong>Created By</strong><div>{{ $item->created_by ?? '-' }}</div></div>
                <div class="col-md-3"><strong>Updated By</strong><div>{{ $item->updated_by ?? '-' }}</div></div>
                <div class="col-md-3"><strong>Created At</strong><div>{{ $item->created_at?->format('d M Y H:i') ?? '-' }}</div></div>
                <div class="col-md-3"><strong>Updated At</strong><div>{{ $item->updated_at?->format('d M Y H:i') ?? '-' }}</div></div>
            </div>
        </div>
    </div>
</div>
@endsection
