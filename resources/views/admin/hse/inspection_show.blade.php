@extends('layouts.admin')

@section('title', 'Safety Inspection')

@section('content')
<section class="section">
  @include('components.hse-nav')
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Safety Inspection #{{ $inspection->id }}</h1>
    <a href="{{ route('admin.hse.inspections') }}" class="btn btn-light">Back</a>
  </div>

  <div class="card">
    <div class="card-body">
      <p><strong>Project ID:</strong> {{ $inspection->project_id }}</p>
      <p><strong>Inspection Date:</strong> {{ $inspection->inspection_date }}</p>
      <p><strong>Type:</strong> {{ $inspection->inspection_type }}</p>
      <p><strong>Overall Status:</strong> <span class="badge bg-info">{{ $inspection->overall_status }}</span></p>
      @if($inspection->remarks)<p><strong>Remarks:</strong> {{ $inspection->remarks }}</p>@endif
    </div>
  </div>

  <x-pm-tracking-panel
    :statusAction="route('admin.hse.inspection.status.update', $inspection->id)"
    :currentStatus="$inspection->overall_status"
    :statuses="['Safe','Unsafe']"
    :histories="$statusHistories ?? collect()"
    statusTitle="Change Inspection Status"
    historyTitle="Inspection History"
  />
</section>
@endsection
