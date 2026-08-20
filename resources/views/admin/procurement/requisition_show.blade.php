@extends('layouts.admin')

@section('title', 'Purchase Requisition')

@section('content')
<section class="section">
  @include('components.procurement-nav')
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Requisition {{ $requisition->requisition_no }}</h1>
    <a href="{{ route('admin.procurement.requisitions') }}" class="btn btn-light">Back</a>
  </div>

  <div class="card">
    <div class="card-body">
      <p><strong>Project ID:</strong> {{ $requisition->project_id }}</p>
      <p><strong>Request Date:</strong> {{ $requisition->request_date }}</p>
      <p><strong>Required Date:</strong> {{ $requisition->required_date ?? '-' }}</p>
      <p><strong>Priority:</strong> {{ $requisition->priority ?? '-' }}</p>
      <p><strong>Approval Status:</strong> <span class="badge bg-info">{{ $requisition->approval_status }}</span></p>
      <p><strong>Work Progress:</strong> {{ number_format((float) ($requisition->progress_percentage ?? 0), 1) }}%</p>
      @if($requisition->remarks)<p><strong>Remarks:</strong> {{ $requisition->remarks }}</p>@endif
    </div>
  </div>

  <x-pm-tracking-panel
    :statusAction="route('admin.procurement.requisition.status.update', $requisition->id)"
    :progressAction="route('admin.procurement.requisition.progress.update', $requisition->id)"
    :currentStatus="$requisition->approval_status"
    :statuses="['Pending','Approved','Rejected']"
    :currentProgress="$requisition->progress_percentage ?? 0"
    :histories="$statusHistories ?? collect()"
    statusTitle="Change Approval Status"
    historyTitle="Requisition History"
  />
</section>
@endsection
