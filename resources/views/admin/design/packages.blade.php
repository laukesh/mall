@extends('layouts.admin')

@section('title', 'Design Packages')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Design Packages</h1>
    <div>
      <a href="{{ route('admin.design.packages.create') }}" class="btn btn-primary">New Package</a>
      <a href="{{ route('admin.design.index') }}" class="btn btn-light">Dashboard</a>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Code</th>
              <th>Project</th>
              <th>Package Name</th>
              <th>Type</th>
              <th>Start Date</th>
              <th>Target Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($packages as $package)
            <tr>
              <td><a href="{{ route('admin.design.packages.show', $package->id) }}">{{ $package->package_code }}</a></td>
              <td>{{ $package->project?->project_name ?? '—' }}</td>
              <td>{{ $package->package_name }}</td>
              <td>{{ $package->package_type }}</td>
              <td>{{ $package->start_date }}</td>
              <td>{{ $package->target_date }}</td>
              <td><span class="badge bg-info">{{ $package->status }}</span></td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">No design packages found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
