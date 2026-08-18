@extends('layouts.app')

@section('title', 'Work Order Details')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1"><i class="fas fa-layer-group me-2"></i>Work Order Details</h4>
            <div class="text-muted">View work order information.</div>
        </div>
        <div>
            @can('work_orders.edit')
                <a href="{{ route('admin.maintenance.work-orders.edit', $item->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            @endcan
            <a href="{{ route('admin.maintenance.work-orders.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Work Order Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">Work Order Number</dt>
                        <dd class="col-sm-7">{{ $item->work_order_number ?? '-' }}</dd>

                        <dt class="col-sm-5">Maintenance Request ID</dt>
                        <dd class="col-sm-7">{{ $item->maintenance_request_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Unit ID</dt>
                        <dd class="col-sm-7">{{ $item->unit_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Department ID</dt>
                        <dd class="col-sm-7">{{ $item->department_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Assigned To</dt>
                        <dd class="col-sm-7">{{ $item->assigned_to ?? '-' }}</dd>

                        <dt class="col-sm-5">Vendor ID</dt>
                        <dd class="col-sm-7">{{ $item->vendor_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Work Title</dt>
                        <dd class="col-sm-7">{{ $item->work_title ?? '-' }}</dd>

                        <dt class="col-sm-5">Work Description</dt>
                        <dd class="col-sm-7">{{ $item->work_description ?? '-' }}</dd>

                        <dt class="col-sm-5">Priority</dt>
                        <dd class="col-sm-7">{{ $item->priority ?? '-' }}</dd>

                        <dt class="col-sm-5">Scheduled Start</dt>
                        <dd class="col-sm-7">{{ $item->scheduled_start?->format('d M Y H:i') ?? '-' }}</dd>

                        </dl></div>
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">Scheduled End</dt>
                        <dd class="col-sm-7">{{ $item->scheduled_end?->format('d M Y H:i') ?? '-' }}</dd>

                        <dt class="col-sm-5">Actual Start</dt>
                        <dd class="col-sm-7">{{ $item->actual_start?->format('d M Y H:i') ?? '-' }}</dd>

                        <dt class="col-sm-5">Actual End</dt>
                        <dd class="col-sm-7">{{ $item->actual_end?->format('d M Y H:i') ?? '-' }}</dd>

                        <dt class="col-sm-5">Estimated Cost</dt>
                        <dd class="col-sm-7">{{ $item->estimated_cost ?? '-' }}</dd>

                        <dt class="col-sm-5">Actual Cost</dt>
                        <dd class="col-sm-7">{{ $item->actual_cost ?? '-' }}</dd>

                        <dt class="col-sm-5">Completion Percentage</dt>
                        <dd class="col-sm-7">{{ $item->completion_percentage ?? '-' }}</dd>

                        <dt class="col-sm-5">Status</dt>
                        <dd class="col-sm-7">{{ $item->status ?? '-' }}</dd>

                        <dt class="col-sm-5">Completion Notes</dt>
                        <dd class="col-sm-7">{{ $item->completion_notes ?? '-' }}</dd>

                        <dt class="col-sm-5">Verification Notes</dt>
                        <dd class="col-sm-7">{{ $item->verification_notes ?? '-' }}</dd>

                        <dt class="col-sm-5">Verified By</dt>
                        <dd class="col-sm-7">{{ $item->verified_by ?? '-' }}</dd>

                        <dt class="col-sm-5">Verified At</dt>
                        <dd class="col-sm-7">{{ $item->verified_at?->format('d M Y H:i') ?? '-' }}</dd>

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
