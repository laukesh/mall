@extends('layouts.admin')

@section('title', 'Projects')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Projects</h1>
    <a href="{{ route('admin.project.create') }}" class="btn btn-primary">Add Project</a>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Code</th>
              <th>Project Name</th>
              <th>Type</th>
              <th>Status</th>
              <th>Client</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($projects as $project)
            <tr>
              <td>{{ $project->project_code }}</td>
              <td>{{ $project->project_name }}</td>
              <td>{{ $project->project_type ?? '-' }}</td>
              <td><span class="badge bg-info">{{ $project->status }}</span></td>
              <td>{{ $project->client_id ?? '-' }}</td>
              <td class="text-end">
                <a href="{{ route('admin.project.show', $project->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                <a href="{{ route('admin.project.edit', $project->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                <form action="{{ route('admin.project.destroy', $project->id) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this project?')">Delete</button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No projects found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
