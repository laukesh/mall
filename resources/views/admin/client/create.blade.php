@extends('layouts.admin')

@section('title', 'Add Client')

@section('content')
<section class="section">
  <div class="section-header"><h1>Add Client</h1></div>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.client.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-4 form-group"><label>Client Code *</label><input type="text" name="client_code" class="form-control" value="{{ old('client_code') }}" required></div>
          <div class="col-md-8 form-group"><label>Client Name *</label><input type="text" name="client_name" class="form-control" value="{{ old('client_name') }}" required></div>
          <div class="col-md-4 form-group">
            <label>Client Type *</label>
            <select name="client_type" class="form-control" required>
              @foreach(['Individual','Company','Government'] as $type)
                <option value="{{ $type }}" @selected(old('client_type') == $type)>{{ $type }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group"><label>Contact Person</label><input type="text" name="contact_person" class="form-control" value="{{ old('contact_person') }}"></div>
          <div class="col-md-4 form-group"><label>Mobile</label><input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}"></div>
          <div class="col-md-4 form-group"><label>Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}"></div>
          <div class="col-md-4 form-group"><label>GST Number</label><input type="text" name="gst_number" class="form-control" value="{{ old('gst_number') }}"></div>
          <div class="col-md-4 form-group">
            <label>Status *</label>
            <select name="status" class="form-control" required>
              @foreach(['Active','Inactive'] as $status)
                <option value="{{ $status }}" @selected(old('status', 'Active') == $status)>{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12 form-group"><label>Address</label><textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea></div>
          <div class="col-md-4 form-group"><label>City</label><input type="text" name="city" class="form-control" value="{{ old('city') }}"></div>
          <div class="col-md-4 form-group"><label>State</label><input type="text" name="state" class="form-control" value="{{ old('state') }}"></div>
          <div class="col-md-4 form-group"><label>Pincode</label><input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}"></div>
          <div class="col-12 form-group"><label>Remarks</label><textarea name="remarks" class="form-control" rows="2">{{ old('remarks') }}</textarea></div>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">Save Client</button>
          <a href="{{ route('admin.client.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
