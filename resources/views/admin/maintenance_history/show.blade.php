@extends('layouts.app')

@section('title', 'Maintenance History Details')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1"><i class="fas fa-layer-group me-2"></i>Maintenance History Details</h4>
            <div class="text-muted">View maintenance history information.</div>
        </div>
        <div>
            @can('maintenance_history.edit')
                <a href="{{ route('admin.maintenance-history.edit', $item->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            @endcan
            <a href="{{ route('admin.maintenance-history.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Maintenance History Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">History Number</dt>
                        <dd class="col-sm-7">{{ $item->history_number ?? '-' }}</dd>

                        <dt class="col-sm-5">Asset ID</dt>
                        <dd class="col-sm-7">{{ $item->asset_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Work Order ID</dt>
                        <dd class="col-sm-7">{{ $item->work_order_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Preventive Maintenance ID</dt>
                        <dd class="col-sm-7">{{ $item->preventive_maintenance_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Maintenance Type</dt>
                        <dd class="col-sm-7">{{ $item->maintenance_type ?? '-' }}</dd>

                        <dt class="col-sm-5">Maintenance Date</dt>
                        <dd class="col-sm-7">{{ $item->maintenance_date?->format('d M Y') ?? '-' }}</dd>

                        <dt class="col-sm-5">Description</dt>
                        <dd class="col-sm-7">{{ $item->description ?? '-' }}</dd>

                        <dt class="col-sm-5">Problem Reported</dt>
                        <dd class="col-sm-7">{{ $item->problem_reported ?? '-' }}</dd>

                        <dt class="col-sm-5">Work Performed</dt>
                        <dd class="col-sm-7">{{ $item->work_performed ?? '-' }}</dd>

                        <dt class="col-sm-5">Findings</dt>
                        <dd class="col-sm-7">{{ $item->findings ?? '-' }}</dd>

                        <dt class="col-sm-5">Parts Replaced</dt>
                        <dd class="col-sm-7">{{ $item->parts_replaced ?? '-' }}</dd>

                        </dl></div>
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">Technician ID</dt>
                        <dd class="col-sm-7">{{ $item->technician_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Vendor ID</dt>
                        <dd class="col-sm-7">{{ $item->vendor_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Downtime Hours</dt>
                        <dd class="col-sm-7">{{ $item->downtime_hours ?? '-' }}</dd>

                        <dt class="col-sm-5">Labour Cost</dt>
                        <dd class="col-sm-7">{{ $item->labour_cost ?? '-' }}</dd>

                        <dt class="col-sm-5">Material Cost</dt>
                        <dd class="col-sm-7">{{ $item->material_cost ?? '-' }}</dd>

                        <dt class="col-sm-5">Total Cost</dt>
                        <dd class="col-sm-7">{{ $item->total_cost ?? '-' }}</dd>

                        <dt class="col-sm-5">Condition Before</dt>
                        <dd class="col-sm-7">{{ $item->condition_before ?? '-' }}</dd>

                        <dt class="col-sm-5">Condition After</dt>
                        <dd class="col-sm-7">{{ $item->condition_after ?? '-' }}</dd>

                        <dt class="col-sm-5">Warranty Claim</dt>
                        <dd class="col-sm-7">{{ $item->warranty_claim ?? '-' }}</dd>

                        <dt class="col-sm-5">Next Maintenance Date</dt>
                        <dd class="col-sm-7">{{ $item->next_maintenance_date?->format('d M Y') ?? '-' }}</dd>

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
