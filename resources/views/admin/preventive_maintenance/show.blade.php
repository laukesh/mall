@extends('layouts.app')

@section('title', 'Preventive Maintenance Details')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1"><i class="fas fa-layer-group me-2"></i>Preventive Maintenance Details</h4>
            <div class="text-muted">View preventive maintenance information.</div>
        </div>
        <div>
            @can('preventive_maintenance.edit')
                <a href="{{ route('admin.preventive_maintenance.edit', $item->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            @endcan
            <a href="{{ route('admin.preventive_maintenance.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Preventive Maintenance Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">Asset ID</dt>
                        <dd class="col-sm-7">{{ $item->asset_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Maintenance Code</dt>
                        <dd class="col-sm-7">{{ $item->maintenance_code ?? '-' }}</dd>

                        <dt class="col-sm-5">Maintenance Title</dt>
                        <dd class="col-sm-7">{{ $item->maintenance_title ?? '-' }}</dd>

                        <dt class="col-sm-5">Description</dt>
                        <dd class="col-sm-7">{{ $item->description ?? '-' }}</dd>

                        <dt class="col-sm-5">Maintenance Type</dt>
                        <dd class="col-sm-7">{{ $item->maintenance_type ?? '-' }}</dd>

                        <dt class="col-sm-5">Frequency</dt>
                        <dd class="col-sm-7">{{ $item->frequency ?? '-' }}</dd>

                        <dt class="col-sm-5">Frequency Value</dt>
                        <dd class="col-sm-7">{{ $item->frequency_value ?? '-' }}</dd>

                        <dt class="col-sm-5">Last Maintenance Date</dt>
                        <dd class="col-sm-7">{{ $item->last_maintenance_date?->format('d M Y') ?? '-' }}</dd>

                        <dt class="col-sm-5">Next Due Date</dt>
                        <dd class="col-sm-7">{{ $item->next_due_date?->format('d M Y') ?? '-' }}</dd>

                        </dl></div>
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">Estimated Hours</dt>
                        <dd class="col-sm-7">{{ $item->estimated_hours ?? '-' }}</dd>

                        <dt class="col-sm-5">Estimated Cost</dt>
                        <dd class="col-sm-7">{{ $item->estimated_cost ?? '-' }}</dd>

                        <dt class="col-sm-5">Assigned Department ID</dt>
                        <dd class="col-sm-7">{{ $item->assigned_department_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Assigned To</dt>
                        <dd class="col-sm-7">{{ $item->assigned_to ?? '-' }}</dd>

                        <dt class="col-sm-5">Vendor ID</dt>
                        <dd class="col-sm-7">{{ $item->vendor_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Checklist</dt>
                        <dd class="col-sm-7">{{ $item->checklist ?? '-' }}</dd>

                        <dt class="col-sm-5">Reminder Days</dt>
                        <dd class="col-sm-7">{{ $item->reminder_days ?? '-' }}</dd>

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
