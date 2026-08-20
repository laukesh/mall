@extends('layouts.admin')

@section('title', 'Document Details')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>{{ $document->document_title }} <small class="text-muted">({{ $document->document_number }})</small></h1>
    <div>
      <a href="{{ route('admin.document.edit', $document->id) }}" class="btn btn-secondary">Edit</a>
      <a href="{{ route('admin.document.index') }}" class="btn btn-light">Back</a>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><h4>Document Details</h4></div>
    <div class="card-body">
      <p><strong>Type:</strong> {{ $document->document_type ?? '-' }}</p>
      <p><strong>Version:</strong> {{ $document->current_version ?? '-' }}</p>
      <p><strong>Approval Status:</strong> <span class="badge bg-info">{{ $document->approval_status }}</span></p>
      <p><strong>Work Progress:</strong> {{ number_format((float) ($document->progress_percentage ?? 0), 1) }}%</p>
      <p><strong>Visibility:</strong> {{ $document->visibility }}</p>
      <p><strong>Upload Date:</strong> {{ $document->upload_date }}</p>
      @if($document->remarks)<p><strong>Remarks:</strong> {{ $document->remarks }}</p>@endif
    </div>
  </div>

  <x-pm-tracking-panel
    :statusAction="route('admin.document.status.update', $document->id)"
    :progressAction="route('admin.document.progress.update', $document->id)"
    :currentStatus="$document->approval_status"
    :statuses="['Draft','Pending','Approved','Rejected']"
    :currentProgress="$document->progress_percentage ?? 0"
    :histories="$statusHistories ?? collect()"
    statusTitle="Change Approval Status"
    historyTitle="Document History"
  />
</section>
@endsection
