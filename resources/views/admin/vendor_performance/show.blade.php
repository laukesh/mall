@extends('layouts.app')

@section('title', 'Vendor Performance Details')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1"><i class="fas fa-layer-group me-2"></i>Vendor Performance Details</h4>
            <div class="text-muted">View vendor performance information.</div>
        </div>
        <div>
            @can('vendor_performance.edit')
                <a href="{{ route('admin.maintenance.vendor-performance.edit', $item->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            @endcan
            <a href="{{ route('admin.maintenance.vendor-performance.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Vendor Performance Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">Vendor User ID</dt>
                        <dd class="col-sm-7">{{ $item->vendor_user_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Contract ID</dt>
                        <dd class="col-sm-7">{{ $item->contract_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Evaluation Period Start</dt>
                        <dd class="col-sm-7">{{ $item->evaluation_period_start?->format('d M Y') ?? '-' }}</dd>

                        <dt class="col-sm-5">Evaluation Period End</dt>
                        <dd class="col-sm-7">{{ $item->evaluation_period_end?->format('d M Y') ?? '-' }}</dd>

                        <dt class="col-sm-5">Quality Rating</dt>
                        <dd class="col-sm-7">{{ $item->quality_rating ?? '-' }}</dd>

                        <dt class="col-sm-5">Response Rating</dt>
                        <dd class="col-sm-7">{{ $item->response_rating ?? '-' }}</dd>

                        <dt class="col-sm-5">Timeliness Rating</dt>
                        <dd class="col-sm-7">{{ $item->timeliness_rating ?? '-' }}</dd>

                        <dt class="col-sm-5">Safety Rating</dt>
                        <dd class="col-sm-7">{{ $item->safety_rating ?? '-' }}</dd>

                        <dt class="col-sm-5">Communication Rating</dt>
                        <dd class="col-sm-7">{{ $item->communication_rating ?? '-' }}</dd>

                        <dt class="col-sm-5">Overall Rating</dt>
                        <dd class="col-sm-7">{{ $item->overall_rating ?? '-' }}</dd>

                        </dl></div>
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">Jobs Assigned</dt>
                        <dd class="col-sm-7">{{ $item->jobs_assigned ?? '-' }}</dd>

                        <dt class="col-sm-5">Jobs Completed</dt>
                        <dd class="col-sm-7">{{ $item->jobs_completed ?? '-' }}</dd>

                        <dt class="col-sm-5">Jobs Delayed</dt>
                        <dd class="col-sm-7">{{ $item->jobs_delayed ?? '-' }}</dd>

                        <dt class="col-sm-5">SLA Compliance %</dt>
                        <dd class="col-sm-7">{{ $item->sla_compliance_percentage ?? '-' }}</dd>

                        <dt class="col-sm-5">Strengths</dt>
                        <dd class="col-sm-7">{{ $item->strengths ?? '-' }}</dd>

                        <dt class="col-sm-5">Issues</dt>
                        <dd class="col-sm-7">{{ $item->issues ?? '-' }}</dd>

                        <dt class="col-sm-5">Improvement Plan</dt>
                        <dd class="col-sm-7">{{ $item->improvement_plan ?? '-' }}</dd>

                        <dt class="col-sm-5">Reviewer ID</dt>
                        <dd class="col-sm-7">{{ $item->reviewer_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Review Date</dt>
                        <dd class="col-sm-7">{{ $item->review_date?->format('d M Y') ?? '-' }}</dd>

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
