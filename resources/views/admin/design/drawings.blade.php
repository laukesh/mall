@extends('layouts.admin')

@section('title', 'Drawings')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Drawings</h1>
    <div>
      <a href="{{ route('admin.design.drawings.create') }}" class="btn btn-primary">New Drawing</a>
      <a href="{{ route('admin.design.index') }}" class="btn btn-light">Dashboard</a>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Drawing No.</th>
              <th>Title</th>
              <th>Type</th>
              <th>Discipline</th>
              <th>Revision</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($drawings as $drawing)
            <tr>
              <td>{{ $drawing->drawing_number }}</td>
              <td>{{ $drawing->drawing_title }}</td>
              <td>{{ $drawing->drawing_type }}</td>
              <td>{{ $drawing->discipline }}</td>
              <td>{{ $drawing->current_revision }}</td>
              <td><span class="badge bg-info">{{ $drawing->drawing_status }}</span></td>
              <td class="text-end">
                <a href="{{ route('admin.design.drawings.show', $drawing->id) }}" class="btn btn-sm btn-outline-primary">View</a>
              </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">No drawings found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
