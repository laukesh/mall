@extends('layouts.admin')

@section('title', 'HSE Incident')

@section('content')
<section class="section">
  @include('components.hse-nav')
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Incident {{ $incident->incident_number }}</h1>
    <a href="{{ route('admin.hse.incidents') }}" class="btn btn-light">Back</a>
  </div>

  <div class="card">
    <div class="card-body">
      <p><strong>Project:</strong> {{ $incident->project?->project_name ?? $incident->project_id }}</p>
      <p><strong>Type:</strong> {{ $incident->incident_type }}</p>
      <p><strong>Date:</strong> {{ $incident->incident_date }}</p>
      <p><strong>Location:</strong> {{ $incident->location ?? '-' }}</p>
      <p><strong>Status:</strong> <span class="badge bg-info">{{ $incident->status }}</span></p>
      <p><strong>Investigation Progress:</strong> {{ number_format((float) ($incident->progress_percentage ?? 0), 1) }}%</p>
      <p><strong>Description:</strong> {{ $incident->description }}</p>
      @if($incident->immediate_action)<p><strong>Immediate Action:</strong> {{ $incident->immediate_action }}</p>@endif
    </div>
  </div>

  <x-pm-tracking-panel
    :statusAction="route('admin.hse.incident.status.update', $incident->id)"
    :progressAction="route('admin.hse.incident.progress.update', $incident->id)"
    :currentStatus="$incident->status"
    :statuses="['Open','Under Investigation','Closed']"
    :currentProgress="$incident->progress_percentage ?? 0"
    :histories="$statusHistories ?? collect()"
    statusTitle="Change Incident Status"
    progressTitle="Update Investigation Progress"
    historyTitle="Incident History"
  />
</section>
@endsection
