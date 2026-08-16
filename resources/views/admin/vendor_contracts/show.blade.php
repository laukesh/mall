@extends('layouts.app')

@section('title', 'Vendor Contract Details')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1"><i class="fas fa-layer-group me-2"></i>Vendor Contract Details</h4>
            <div class="text-muted">View vendor contract information.</div>
        </div>
        <div>
            @can('vendor_contracts.edit')
                <a href="{{ route('admin.maintenance.vendor_contracts.edit', $item->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            @endcan
            <a href="{{ route('admin.maintenance.vendor_contracts.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Vendor Contract Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">Contract Number</dt>
                        <dd class="col-sm-7">{{ $item->contract_number ?? '-' }}</dd>

                        <dt class="col-sm-5">Vendor User ID</dt>
                        <dd class="col-sm-7">{{ $item->vendor_user_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Contract Title</dt>
                        <dd class="col-sm-7">{{ $item->contract_title ?? '-' }}</dd>

                        <dt class="col-sm-5">Contract Type</dt>
                        <dd class="col-sm-7">{{ $item->contract_type ?? '-' }}</dd>

                        <dt class="col-sm-5">Description</dt>
                        <dd class="col-sm-7">{{ $item->description ?? '-' }}</dd>

                        <dt class="col-sm-5">Start Date</dt>
                        <dd class="col-sm-7">{{ $item->start_date?->format('d M Y') ?? '-' }}</dd>

                        <dt class="col-sm-5">End Date</dt>
                        <dd class="col-sm-7">{{ $item->end_date?->format('d M Y') ?? '-' }}</dd>

                        </dl></div>
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">Contract Value</dt>
                        <dd class="col-sm-7">{{ $item->contract_value ?? '-' }}</dd>

                        <dt class="col-sm-5">Payment Terms</dt>
                        <dd class="col-sm-7">{{ $item->payment_terms ?? '-' }}</dd>

                        <dt class="col-sm-5">Renewal Type</dt>
                        <dd class="col-sm-7">{{ $item->renewal_type ?? '-' }}</dd>

                        <dt class="col-sm-5">Renewal Date</dt>
                        <dd class="col-sm-7">{{ $item->renewal_date?->format('d M Y') ?? '-' }}</dd>

                        <dt class="col-sm-5">Notice Period Days</dt>
                        <dd class="col-sm-7">{{ $item->notice_period_days ?? '-' }}</dd>

                        <dt class="col-sm-5">Document Path</dt>
                        <dd class="col-sm-7">{{ $item->document_path ?? '-' }}</dd>

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
