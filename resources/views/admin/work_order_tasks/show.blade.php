@extends('layouts.app')

@section('title', 'Work Order Task Details')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1"><i class="fas fa-layer-group me-2"></i>Work Order Task Details</h4>
            <div class="text-muted">View work order task information.</div>
        </div>
        <div>
            @can('work_order_tasks.edit')
                <a href="{{ route('admin.maintenance.work-order-tasks.edit', $item->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            @endcan
            <a href="{{ route('admin.maintenance.work-order-tasks.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Work Order Task Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">Work Order ID</dt>
                        <dd class="col-sm-7">{{ $item->work_order_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Task Number</dt>
                        <dd class="col-sm-7">{{ $item->task_number ?? '-' }}</dd>

                        <dt class="col-sm-5">Task Title</dt>
                        <dd class="col-sm-7">{{ $item->task_title ?? '-' }}</dd>

                        <dt class="col-sm-5">Task Description</dt>
                        <dd class="col-sm-7">{{ $item->task_description ?? '-' }}</dd>

                        <dt class="col-sm-5">Assigned To</dt>
                        <dd class="col-sm-7">{{ $item->assigned_to ?? '-' }}</dd>

                        <dt class="col-sm-5">Priority</dt>
                        <dd class="col-sm-7">{{ $item->priority ?? '-' }}</dd>

                        <dt class="col-sm-5">Sequence No</dt>
                        <dd class="col-sm-7">{{ $item->sequence_no ?? '-' }}</dd>

                        <dt class="col-sm-5">Estimated Hours</dt>
                        <dd class="col-sm-7">{{ $item->estimated_hours ?? '-' }}</dd>

                        </dl></div>
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">Actual Hours</dt>
                        <dd class="col-sm-7">{{ $item->actual_hours ?? '-' }}</dd>

                        <dt class="col-sm-5">Completion Percentage</dt>
                        <dd class="col-sm-7">{{ $item->completion_percentage ?? '-' }}</dd>

                        <dt class="col-sm-5">Scheduled Start</dt>
                        <dd class="col-sm-7">{{ $item->scheduled_start?->format('d M Y H:i') ?? '-' }}</dd>

                        <dt class="col-sm-5">Scheduled End</dt>
                        <dd class="col-sm-7">{{ $item->scheduled_end?->format('d M Y H:i') ?? '-' }}</dd>

                        <dt class="col-sm-5">Actual Start</dt>
                        <dd class="col-sm-7">{{ $item->actual_start?->format('d M Y H:i') ?? '-' }}</dd>

                        <dt class="col-sm-5">Actual End</dt>
                        <dd class="col-sm-7">{{ $item->actual_end?->format('d M Y H:i') ?? '-' }}</dd>

                        <dt class="col-sm-5">Status</dt>
                        <dd class="col-sm-7">{{ $item->status ?? '-' }}</dd>

                        <dt class="col-sm-5">Completion Notes</dt>
                        <dd class="col-sm-7">{{ $item->completion_notes ?? '-' }}</dd>

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
