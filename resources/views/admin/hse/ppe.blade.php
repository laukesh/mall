@extends('layouts.admin')

@section('title', 'PPE Inventory')

@section('content')
<section class="section">
  @include('components.hse-nav')
  <div class="section-header"><h1>PPE Inventory</h1></div>

  <div class="card mb-3"><div class="card-header"><h4>Add PPE Item</h4></div>
    <div class="card-body">
      <form action="{{ route('admin.hse.ppe.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-4 form-group"><label>PPE Name *</label><input type="text" name="ppe_name" class="form-control" required></div>
          <div class="col-md-3 form-group"><label>Category</label><input type="text" name="category" class="form-control"></div>
          <div class="col-md-3 form-group"><label>Available Quantity *</label><input type="number" name="available_quantity" class="form-control" required min="0"></div>
          <div class="col-md-2 form-group"><label>Min Quantity</label><input type="number" name="minimum_quantity" class="form-control" value="0" min="0"></div>
          <div class="col-md-4 form-group">
            <label>Status *</label>
            <select name="status" class="form-control" required>
              @foreach(['Available','Out of Stock'] as $status)
                <option value="{{ $status }}">{{ $status }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Add PPE Item</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>PPE Name</th>
              <th>Category</th>
              <th>Available</th>
              <th>Minimum</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($ppeItems as $item)
            <tr>
              <td>{{ $item->ppe_name }}</td>
              <td>{{ $item->category ?? '-' }}</td>
              <td>{{ $item->available_quantity }}</td>
              <td>{{ $item->minimum_quantity ?? 0 }}</td>
              <td><span class="badge bg-{{ $item->status === 'Available' ? 'success' : 'danger' }}">{{ $item->status }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No PPE items found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
