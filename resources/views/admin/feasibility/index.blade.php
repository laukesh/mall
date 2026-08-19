@extends('layouts.admin')

@section('title', 'Feasibility Studies')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Feasibility Studies</h1>
    <a href="{{ route('admin.feasibility.create') }}" class="btn btn-primary">New Study</a>
  </div>
  <div class="card"><div class="card-body p-0">
    <table class="table table-striped mb-0">
      <thead><tr><th>Code</th><th>Project</th><th>Study Title</th><th>Date</th><th>Recommendation</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
      <tbody>
        @forelse($studies as $study)
        <tr>
          <td>{{ $study->feasibility_code }}</td>
          <td>{{ $study->project?->project_name ?? '—' }}</td>
          <td>{{ $study->study_title }}</td>
          <td>{{ $study->study_date }}</td>
          <td><span class="badge bg-{{ $study->recommendation === 'Proceed' ? 'success' : ($study->recommendation === 'Reject' ? 'danger' : 'warning') }}">{{ $study->recommendation }}</span></td>
          <td>{{ $study->status }}</td>
          <td class="text-end">
            <a href="{{ route('admin.feasibility.show', $study->id) }}" class="btn btn-sm btn-outline-primary">View</a>
            <a href="{{ route('admin.feasibility.edit', $study->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
            <form action="{{ route('admin.feasibility.destroy', $study->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</button></form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted py-4">No feasibility studies found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div></div>
</section>
@endsection
