@extends('layouts.admin')

@section('title', 'Land Acquisition')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Land Acquisition</h1>
    <a href="{{ route('admin.land.create') }}" class="btn btn-primary">Add Land</a>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Code</th>
              <th>Land Name</th>
              <th>Survey No.</th>
              <th>Location</th>
              <th>Area</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($lands as $land)
            <tr>
              <td>{{ $land->land_code }}</td>
              <td>{{ $land->land_name }}</td>
              <td>{{ $land->survey_number }}</td>
              <td>{{ $land->village }}, {{ $land->district }}</td>
              <td>{{ number_format($land->total_area, 2) }} {{ $land->area_unit }}</td>
              <td><span class="badge bg-info">{{ $land->acquisition_status }}</span></td>
              <td class="text-end">
                <a href="{{ route('admin.land.show', $land->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                <a href="{{ route('admin.land.edit', $land->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                <form action="{{ route('admin.land.destroy', $land->id) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this land record?')">Delete</button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">No land records found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
