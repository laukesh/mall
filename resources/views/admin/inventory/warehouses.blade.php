@extends('layouts.admin')

@section('title', 'Warehouses')

@section('content')
<section class="section">
  @include('components.inventory-nav')
  <div class="section-header"><h1>Warehouses</h1></div>

  <div class="card mb-3"><div class="card-header"><h4>Add Warehouse</h4></div>
    <div class="card-body">
      <form action="{{ route('admin.inventory.warehouse.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-3 form-group"><label>Warehouse Code *</label><input type="text" name="warehouse_code" class="form-control" required></div>
          <div class="col-md-5 form-group"><label>Warehouse Name *</label><input type="text" name="warehouse_name" class="form-control" required></div>
          <div class="col-md-4 form-group">
            <label>Type *</label>
            <select name="warehouse_type" class="form-control" required>
              @foreach(['Central Store','Site Store'] as $type)
                <option value="{{ $type }}">{{ $type }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group"><label>City</label><input type="text" name="city" class="form-control"></div>
          <div class="col-md-4 form-group"><label>State</label><input type="text" name="state" class="form-control"></div>
          <div class="col-md-4 form-group">
            <label>Status *</label>
            <select name="status" class="form-control" required>
              @foreach(['Active','Inactive'] as $status)
                <option value="{{ $status }}">{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12 form-group"><label>Address</label><textarea name="address" class="form-control" rows="2"></textarea></div>
        </div>
        <button type="submit" class="btn btn-primary">Add Warehouse</button>
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
              <th>Type</th>
              <th>City</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($warehouses as $warehouse)
            <tr>
              <td>{{ $warehouse->warehouse_code }}</td>
              <td>{{ $warehouse->warehouse_name }}</td>
              <td>{{ $warehouse->warehouse_type }}</td>
              <td>{{ $warehouse->city ?? '-' }}</td>
              <td><span class="badge bg-{{ $warehouse->status === 'Active' ? 'success' : 'secondary' }}">{{ $warehouse->status }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No warehouses found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
