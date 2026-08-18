@extends('layouts.app')

@section('title', 'Vendor Service Details')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1"><i class="fas fa-layer-group me-2"></i>Vendor Service Details</h4>
            <div class="text-muted">View vendor service information.</div>
        </div>
        <div>
            @can('vendor_services.edit')
                <a href="{{ route('admin.maintenance.vendor-services.edit', $item->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            @endcan
            <a href="{{ route('admin.maintenance.vendor-services.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Vendor Service Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">Vendor User ID</dt>
                        <dd class="col-sm-7">{{ $item->vendor_user_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Service Name</dt>
                        <dd class="col-sm-7">{{ $item->service_name ?? '-' }}</dd>

                        <dt class="col-sm-5">Service Category</dt>
                        <dd class="col-sm-7">{{ $item->service_category ?? '-' }}</dd>

                        <dt class="col-sm-5">Description</dt>
                        <dd class="col-sm-7">{{ $item->description ?? '-' }}</dd>

                        </dl></div>
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">Service Rate</dt>
                        <dd class="col-sm-7">{{ $item->service_rate ?? '-' }}</dd>

                        <dt class="col-sm-5">Rate Unit</dt>
                        <dd class="col-sm-7">{{ $item->rate_unit ?? '-' }}</dd>

                        <dt class="col-sm-5">Emergency Available</dt>
                        <dd class="col-sm-7">{{ $item->emergency_available ?? '-' }}</dd>

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
