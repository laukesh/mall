@extends('layouts.app')

@section('title', 'Complaint Details')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1"><i class="fas fa-layer-group me-2"></i>Complaint Details</h4>
            <div class="text-muted">View complaint information.</div>
        </div>
        <div>
            @can('complaints.edit')
                <a href="{{ route('admin.complaints.edit', $item->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            @endcan
            <a href="{{ route('admin.complaints.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Complaint Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">Complaint Number</dt>
                        <dd class="col-sm-7">{{ $item->complaint_number ?? '-' }}</dd>

                        <dt class="col-sm-5">Tenant ID</dt>
                        <dd class="col-sm-7">{{ $item->tenant_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Raised By</dt>
                        <dd class="col-sm-7">{{ $item->raised_by ?? '-' }}</dd>

                        <dt class="col-sm-5">Unit ID</dt>
                        <dd class="col-sm-7">{{ $item->unit_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Department ID</dt>
                        <dd class="col-sm-7">{{ $item->department_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Complaint Category</dt>
                        <dd class="col-sm-7">{{ $item->complaint_category ?? '-' }}</dd>

                        <dt class="col-sm-5">Subject</dt>
                        <dd class="col-sm-7">{{ $item->subject ?? '-' }}</dd>

                        </dl></div>
                <div class="col-md-6"><dl class="row"><dt class="col-sm-5">Description</dt>
                        <dd class="col-sm-7">{{ $item->description ?? '-' }}</dd>

                        <dt class="col-sm-5">Priority</dt>
                        <dd class="col-sm-7">{{ $item->priority ?? '-' }}</dd>

                        <dt class="col-sm-5">Assigned To</dt>
                        <dd class="col-sm-7">{{ $item->assigned_to ?? '-' }}</dd>

                        <dt class="col-sm-5">Service Request ID</dt>
                        <dd class="col-sm-7">{{ $item->service_request_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Resolution Notes</dt>
                        <dd class="col-sm-7">{{ $item->resolution_notes ?? '-' }}</dd>

                        <dt class="col-sm-5">Resolved At</dt>
                        <dd class="col-sm-7">{{ $item->resolved_at?->format('d M Y H:i') ?? '-' }}</dd>

                        <dt class="col-sm-5">Status</dt>
                        <dd class="col-sm-7">{{ $item->status ?? '-' }}</dd>

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
