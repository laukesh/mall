@extends('layouts.admin')

@section('title', 'Design Package Details')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>{{ $package->package_name }} <small class="text-muted">({{ $package->package_code }})</small></h1>
    <a href="{{ route('admin.design.packages.index') }}" class="btn btn-light">Back</a>
  </div>

  <div class="card">
    <div class="card-header"><h4>Package Details</h4></div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <p><strong>Project:</strong> {{ $package->project?->project_name ?? '—' }}</p>
          <p><strong>Type:</strong> {{ $package->package_type }}</p>
          <p><strong>Status:</strong> <span class="badge bg-info">{{ $package->status }}</span></p>
          <p><strong>Work Progress:</strong> {{ number_format((float) ($package->progress_percentage ?? 0), 1) }}%</p>
        </div>
        <div class="col-md-6">
          <p><strong>Consultant ID:</strong> {{ $package->consultant_id }}</p>
          <p><strong>Start Date:</strong> {{ $package->start_date }}</p>
          <p><strong>Target Date:</strong> {{ $package->target_date }}</p>
          @if($package->description)<p><strong>Description:</strong> {{ $package->description }}</p>@endif
        </div>
      </div>
    </div>
  </div>

  <x-pm-tracking-panel
    :statusAction="route('admin.design.packages.status.update', $package->id)"
    :progressAction="route('admin.design.packages.progress.update', $package->id)"
    :currentStatus="$package->status"
    :statuses="['Draft','In Review','Approved','Issued','Completed']"
    :currentProgress="$package->progress_percentage ?? 0"
    :histories="$statusHistories ?? collect()"
    statusTitle="Change Package Status"
    historyTitle="Design Package History"
  />

  <div class="card mt-3">
    <div class="card-header"><h4>Drawings</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Number</th><th>Title</th><th>Type</th><th>Status</th><th>Progress</th></tr></thead>
        <tbody>
          @forelse($drawings as $drawing)
          <tr>
            <td><a href="{{ route('admin.design.drawings.show', $drawing->id) }}">{{ $drawing->drawing_number }}</a></td>
            <td>{{ $drawing->drawing_title }}</td>
            <td>{{ $drawing->drawing_type }}</td>
            <td><span class="badge bg-info">{{ $drawing->drawing_status }}</span></td>
            <td>{{ number_format((float) ($drawing->progress_percentage ?? 0), 1) }}%</td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center text-muted">No drawings in this package.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
