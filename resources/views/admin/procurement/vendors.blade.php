@extends('layouts.admin')

@section('title', 'Vendors')

@section('content')
<section class="section">
  @include('components.procurement-nav')
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Vendors</h1>
    <a href="{{ route('admin.procurement.vendor.create') }}" class="btn btn-primary">Add Vendor</a>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Code</th>
              <th>Vendor Name</th>
              <th>Contact</th>
              <th>Category</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($vendors as $vendor)
            <tr>
              <td>{{ $vendor->vendor_code }}</td>
              <td>{{ $vendor->vendor_name }}</td>
              <td>{{ $vendor->contact_person ?? $vendor->mobile ?? '-' }}</td>
              <td>{{ $vendor->vendor_category ?? '-' }}</td>
              <td><span class="badge bg-{{ $vendor->status === 'Active' ? 'success' : 'secondary' }}">{{ $vendor->status }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No vendors found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
