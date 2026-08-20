@extends('layouts.admin')

@section('title', 'Drawing Details')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>{{ $drawing->drawing_title }} <small class="text-muted">({{ $drawing->drawing_number }})</small></h1>
    <a href="{{ route('admin.design.drawings.index') }}" class="btn btn-light">Back</a>
  </div>

  <div class="card">
    <div class="card-header"><h4>Drawing Details</h4></div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <p><strong>Type:</strong> {{ $drawing->drawing_type }}</p>
          <p><strong>Discipline:</strong> {{ $drawing->discipline }}</p>
          <p><strong>Current Revision:</strong> {{ $drawing->current_revision }}</p>
        </div>
        <div class="col-md-6">
          <p><strong>Status:</strong> <span class="badge bg-info">{{ $drawing->drawing_status }}</span></p>
          <p><strong>Work Progress:</strong> {{ number_format((float) ($drawing->progress_percentage ?? 0), 1) }}%</p>
          <p><strong>Upload Date:</strong> {{ $drawing->upload_date }}</p>
          <p><strong>Package:</strong> {{ $drawing->designPackage?->package_name ?? '—' }}</p>
          <p><strong>Project:</strong> {{ $drawing->designPackage?->project?->project_name ?? '—' }}</p>
        </div>
      </div>
    </div>
  </div>

  <x-pm-tracking-panel
    :statusAction="route('admin.design.drawings.status.update', $drawing->id)"
    :progressAction="route('admin.design.drawings.progress.update', $drawing->id)"
    :currentStatus="$drawing->drawing_status"
    :statuses="['Draft','Under Review','Approved','Issued','Superseded']"
    :currentProgress="$drawing->progress_percentage ?? 0"
    :histories="$statusHistories ?? collect()"
    statusTitle="Change Drawing Status"
    historyTitle="Drawing History"
  />
</section>
@endsection
