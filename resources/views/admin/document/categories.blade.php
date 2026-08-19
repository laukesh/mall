@extends('layouts.admin')

@section('title', 'Document Categories')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Document Categories</h1>
    <a href="{{ route('admin.document.index') }}" class="btn btn-light">Back to Documents</a>
  </div>

  <div class="row">
    <div class="col-md-5">
      <div class="card"><div class="card-header"><h4>Add Category</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.document.category.store') }}" method="POST">
            @csrf
            <div class="form-group"><label>Category Name *</label><input type="text" name="category_name" class="form-control" required></div>
            <div class="form-group">
              <label>Status *</label>
              <select name="status" class="form-control" required>
                @foreach(['Active','Inactive'] as $status)
                  <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group"><label>Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
            <button type="submit" class="btn btn-primary">Add Category</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="card"><div class="card-header"><h4>Categories</h4></div>
        <div class="card-body p-0">
          <table class="table mb-0">
            <thead><tr><th>Name</th><th>Description</th><th>Status</th></tr></thead>
            <tbody>
              @forelse($categories as $category)
              <tr>
                <td>{{ $category->category_name }}</td>
                <td>{{ $category->description ?? '-' }}</td>
                <td><span class="badge bg-{{ $category->status === 'Active' ? 'success' : 'secondary' }}">{{ $category->status }}</span></td>
              </tr>
              @empty
              <tr><td colspan="3" class="text-center text-muted">No categories found.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
