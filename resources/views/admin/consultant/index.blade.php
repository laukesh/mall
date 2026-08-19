@extends('layouts.admin')

@section('title', 'Consultants')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Consultants</h1>
    <a href="{{ route('admin.consultant.create') }}" class="btn btn-primary">Add Consultant</a>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Name</th>
              <th>Type</th>
              <th>Company</th>
              <th>Contact</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($consultants as $consultant)
            <tr>
              <td>{{ $consultant->consultant_name }}</td>
              <td>{{ $consultant->consultant_type }}</td>
              <td>{{ $consultant->company_name }}</td>
              <td>{{ $consultant->contact_person }}<br><small class="text-muted">{{ $consultant->mobile }}</small></td>
              <td><span class="badge bg-{{ $consultant->status === 'Active' ? 'success' : 'secondary' }}">{{ $consultant->status }}</span></td>
              <td class="text-end">
                <a href="{{ route('admin.consultant.edit', $consultant->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                <form action="{{ route('admin.consultant.destroy', $consultant->id) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this consultant?')">Delete</button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No consultants found. <a href="{{ route('admin.consultant.create') }}">Add one</a> to create design packages.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
