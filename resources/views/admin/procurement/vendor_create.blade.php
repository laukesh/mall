@extends('layouts.admin')

@section('title', 'Add Vendor')

@section('content')
<section class="section">
  @include('components.procurement-nav')
  <div class="section-header"><h1>Add Vendor</h1></div>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.procurement.vendor.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-4 form-group"><label>Vendor Code *</label><input type="text" name="vendor_code" class="form-control" value="{{ old('vendor_code') }}" required></div>
          <div class="col-md-8 form-group"><label>Vendor Name *</label><input type="text" name="vendor_name" class="form-control" value="{{ old('vendor_name') }}" required></div>
          <div class="col-md-4 form-group"><label>Contact Person</label><input type="text" name="contact_person" class="form-control" value="{{ old('contact_person') }}"></div>
          <div class="col-md-4 form-group"><label>Mobile</label><input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}"></div>
          <div class="col-md-4 form-group"><label>Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}"></div>
          <div class="col-md-4 form-group"><label>GST Number</label><input type="text" name="gst_number" class="form-control" value="{{ old('gst_number') }}"></div>
          <div class="col-md-4 form-group"><label>PAN Number</label><input type="text" name="pan_number" class="form-control" value="{{ old('pan_number') }}"></div>
          <div class="col-md-4 form-group"><label>Category</label><input type="text" name="vendor_category" class="form-control" value="{{ old('vendor_category') }}"></div>
          <div class="col-md-4 form-group">
            <label>Status *</label>
            <select name="status" class="form-control" required>
              @foreach(['Active','Inactive','Blacklisted'] as $status)
                <option value="{{ $status }}" @selected(old('status', 'Active') == $status)>{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12 form-group"><label>Address</label><textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea></div>
          <div class="col-md-4 form-group"><label>City</label><input type="text" name="city" class="form-control" value="{{ old('city') }}"></div>
          <div class="col-md-4 form-group"><label>State</label><input type="text" name="state" class="form-control" value="{{ old('state') }}"></div>
          <div class="col-md-4 form-group"><label>Pincode</label><input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}"></div>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">Save Vendor</button>
          <a href="{{ route('admin.procurement.vendors') }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
