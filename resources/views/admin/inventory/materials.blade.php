@extends('layouts.admin')

@section('title', 'Materials')

@section('content')
<section class="section">
  @include('components.inventory-nav')
  <div class="section-header"><h1>Materials</h1></div>

  <div class="card mb-3"><div class="card-header"><h4>Add Material</h4></div>
    <div class="card-body">
      <form action="{{ route('admin.inventory.material.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-3 form-group"><label>Material Code *</label><input type="text" name="material_code" class="form-control" required></div>
          <div class="col-md-5 form-group"><label>Material Name *</label><input type="text" name="material_name" class="form-control" required></div>
          <div class="col-md-4 form-group">
            <label>Category *</label>
            <select name="category_id" class="form-control" required>
              <option value="">-- Select --</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group"><label>Unit *</label><input type="text" name="unit" class="form-control" required></div>
          <div class="col-md-3 form-group"><label>Min Stock</label><input type="number" step="0.01" name="minimum_stock" class="form-control"></div>
          <div class="col-md-3 form-group"><label>Max Stock</label><input type="number" step="0.01" name="maximum_stock" class="form-control"></div>
          <div class="col-md-3 form-group">
            <label>Status *</label>
            <select name="status" class="form-control" required>
              @foreach(['Active','Inactive'] as $status)
                <option value="{{ $status }}">{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12 form-group"><label>Specification</label><input type="text" name="specification" class="form-control"></div>
        </div>
        <button type="submit" class="btn btn-primary">Add Material</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Code</th>
              <th>Name</th>
              <th>Category</th>
              <th>Unit</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($materials as $material)
            <tr>
              <td>{{ $material->material_code }}</td>
              <td>{{ $material->material_name }}</td>
              <td>{{ $material->category_id }}</td>
              <td>{{ $material->unit }}</td>
              <td><span class="badge bg-{{ $material->status === 'Active' ? 'success' : 'secondary' }}">{{ $material->status }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No materials found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
