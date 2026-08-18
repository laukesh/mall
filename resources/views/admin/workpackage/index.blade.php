@extends('layouts.admin')

@section('title', 'Work Packages')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Work Packages</h1>
    <a href="{{ route('admin.workpackage.create') }}" class="btn btn-primary">Add Work Package</a>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Code</th>
              <th>Package Name</th>
              <th>Project</th>
              <th>Discipline</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($packages as $package)
            <tr>
              <td>{{ $package->package_code }}</td>
              <td>{{ $package->package_name }}</td>
              <td>{{ $package->project_id }}</td>
              <td>{{ $package->discipline }}</td>
              <td><span class="badge bg-info">{{ $package->status }}</span></td>
              <td class="text-end">
                <a href="{{ route('admin.workpackage.show', $package->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                <a href="{{ route('admin.workpackage.edit', $package->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                <form action="{{ route('admin.workpackage.destroy', $package->id) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this work package?')">Delete</button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No work packages found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
