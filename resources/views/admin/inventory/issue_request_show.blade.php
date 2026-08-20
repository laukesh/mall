@extends('layouts.admin')

@section('title', 'Material Issue Request')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Issue Request {{ $issueRequest->request_number }}</h1>
    <a href="{{ route('admin.inventory.issue-requests') }}" class="btn btn-light">Back</a>
  </div>

  <div class="card">
    <div class="card-body">
      <p><strong>Project ID:</strong> {{ $issueRequest->project_id }}</p>
      <p><strong>Work Package ID:</strong> {{ $issueRequest->work_package_id ?? '-' }}</p>
      <p><strong>Request Date:</strong> {{ $issueRequest->request_date }}</p>
      <p><strong>Required Date:</strong> {{ $issueRequest->required_date ?? '-' }}</p>
      <p><strong>Priority:</strong> {{ $issueRequest->priority ?? '-' }}</p>
      <p><strong>Approval Status:</strong> <span class="badge bg-info">{{ $issueRequest->approval_status }}</span></p>
      <p><strong>Work Progress:</strong> {{ number_format((float) ($issueRequest->progress_percentage ?? 0), 1) }}%</p>
      @if($issueRequest->remarks)<p><strong>Remarks:</strong> {{ $issueRequest->remarks }}</p>@endif
    </div>
  </div>

  <x-pm-tracking-panel
    :statusAction="route('admin.inventory.issue-request.status.update', $issueRequest->id)"
    :progressAction="route('admin.inventory.issue-request.progress.update', $issueRequest->id)"
    :currentStatus="$issueRequest->approval_status"
    :statuses="['Pending','Approved','Rejected']"
    :currentProgress="$issueRequest->progress_percentage ?? 0"
    :histories="$statusHistories ?? collect()"
    statusTitle="Change Approval Status"
    historyTitle="Issue Request History"
  />
</section>
@endsection
