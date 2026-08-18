@extends('layouts.admin')

@section('title', 'Design Management')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Design Management</h1>
  </div>

  <div class="row">
    <div class="col-md-3">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary"><i class="fas fa-box"></i></div>
        <div class="card-wrap">
          <div class="card-header"><h4>Packages</h4></div>
          <div class="card-body">{{ $packages->count() }}</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card card-statistic-1">
        <div class="card-icon bg-success"><i class="fas fa-drafting-compass"></i></div>
        <div class="card-wrap">
          <div class="card-header"><h4>Drawings</h4></div>
          <div class="card-body">{{ $drawings->count() }}</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card card-statistic-1">
        <div class="card-icon bg-warning"><i class="fas fa-list-ol"></i></div>
        <div class="card-wrap">
          <div class="card-header"><h4>BOQ Items</h4></div>
          <div class="card-body">{{ $boqItems->count() }}</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card card-statistic-1">
        <div class="card-icon bg-danger"><i class="fas fa-question-circle"></i></div>
        <div class="card-wrap">
          <div class="card-header"><h4>Open RFIs</h4></div>
          <div class="card-body">{{ $rfis->where('status', 'Open')->count() }}</div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-md-3 mb-3">
      <a href="{{ route('admin.design.packages.index') }}" class="btn btn-primary btn-block">Manage Packages</a>
    </div>
    <div class="col-md-3 mb-3">
      <a href="{{ route('admin.design.drawings.index') }}" class="btn btn-success btn-block">Manage Drawings</a>
    </div>
    <div class="col-md-3 mb-3">
      <a href="{{ route('admin.design.boq.index') }}" class="btn btn-warning btn-block">Manage BOQ</a>
    </div>
    <div class="col-md-3 mb-3">
      <a href="{{ route('admin.design.rfi.index') }}" class="btn btn-danger btn-block">Manage RFIs</a>
    </div>
    <div class="col-md-3 mb-3">
      <a href="{{ route('admin.consultant.index') }}" class="btn btn-info btn-block">Manage Consultants</a>
    </div>
  </div>

  <div class="card mt-3">
    <div class="card-header"><h4>Recent Design Packages</h4></div>
    <div class="card-body p-0">
      <table class="table table-striped mb-0">
        <thead>
          <tr>
            <th>Code</th>
            <th>Project</th>
            <th>Package Name</th>
            <th>Type</th>
            <th>Status</th>
            <th>Target Date</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($packages->take(5) as $package)
          <tr>
            <td>{{ $package->package_code }}</td>
            <td>{{ $package->project?->project_name ?? '—' }}</td>
            <td>{{ $package->package_name }}</td>
            <td>{{ $package->package_type }}</td>
            <td><span class="badge bg-info">{{ $package->status }}</span></td>
            <td>{{ $package->target_date }}</td>
            <td class="text-end">
              <a href="{{ route('admin.design.packages.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" class="text-center text-muted py-4">No design packages yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
