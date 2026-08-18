@extends('layouts.admin')

@section('title', 'Documents')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Documents</h1>
    <div>
      <a href="{{ route('admin.document.categories') }}" class="btn btn-secondary">Categories</a>
      <a href="{{ route('admin.document.create') }}" class="btn btn-primary">Add Document</a>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Number</th>
              <th>Title</th>
              <th>Type</th>
              <th>Version</th>
              <th>Approval</th>
              <th>Upload Date</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($documents as $document)
            <tr>
              <td>{{ $document->document_number }}</td>
              <td>{{ $document->document_title }}</td>
              <td>{{ $document->document_type ?? '-' }}</td>
              <td>{{ $document->current_version ?? '-' }}</td>
              <td><span class="badge bg-info">{{ $document->approval_status }}</span></td>
              <td>{{ $document->upload_date }}</td>
              <td class="text-end">
                <a href="{{ route('admin.document.show', $document->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                <a href="{{ route('admin.document.edit', $document->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                <form action="{{ route('admin.document.destroy', $document->id) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this document?')">Delete</button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">No documents found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
