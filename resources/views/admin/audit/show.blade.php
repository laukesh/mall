@extends('layouts.admin')

@section('title', 'Audit Log Details')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Audit Log #{{ $log->id }}</h1>
    <a href="{{ route('admin.audit.index') }}" class="btn btn-light">Back</a>
  </div>

  <div class="card">
    <div class="card-header"><h4>Log Details</h4></div>
    <div class="card-body">
      <p><strong>Module:</strong> {{ $log->module }}</p>
      <p><strong>Action:</strong> {{ $log->action }}</p>
      <p><strong>User ID:</strong> {{ $log->user_id ?? '-' }}</p>
      <p><strong>IP Address:</strong> {{ $log->ip_address ?? '-' }}</p>
      <p><strong>Date:</strong> {{ $log->created_at }}</p>
      @if($log->record_id)<p><strong>Record ID:</strong> {{ $log->record_id }}</p>@endif
      @if($log->old_values)<p><strong>Old Values:</strong> <pre class="mb-0">{{ $log->old_values }}</pre></p>@endif
      @if($log->new_values)<p><strong>New Values:</strong> <pre class="mb-0">{{ $log->new_values }}</pre></p>@endif
      @if($log->description)<p><strong>Description:</strong> {{ $log->description }}</p>@endif
    </div>
  </div>
</section>
@endsection
