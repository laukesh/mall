@extends('layouts.admin')

@section('title', 'Contractors')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Contractors</h1>
    <a href="{{ route('admin.contractor.create') }}" class="btn btn-primary">Add Contractor</a>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Code</th>
              <th>Company Name</th>
              <th>Type</th>
              <th>Contact</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($contractors as $contractor)
            <tr>
              <td>{{ $contractor->contractor_code }}</td>
              <td>{{ $contractor->company_name }}</td>
              <td>{{ $contractor->contractor_type }}</td>
              <td>{{ $contractor->contact_person ?? $contractor->mobile ?? '-' }}</td>
              <td><span class="badge bg-{{ $contractor->status === 'Active' ? 'success' : 'secondary' }}">{{ $contractor->status }}</span></td>
              <td class="text-end">
                <a href="{{ route('admin.contractor.show', $contractor->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                <a href="{{ route('admin.contractor.edit', $contractor->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                <form action="{{ route('admin.contractor.destroy', $contractor->id) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this contractor?')">Delete</button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No contractors found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
