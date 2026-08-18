@extends('layouts.admin')

@section('title', 'Add Consultant')

@section('content')
<section class="section">
  <div class="section-header"><h1>Add Consultant</h1></div>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.consultant.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-4 form-group">
            <label>Consultant Name *</label>
            <input type="text" name="consultant_name" class="form-control" value="{{ old('consultant_name') }}" required>
          </div>
          <div class="col-md-4 form-group">
            <label>Consultant Type *</label>
            <select name="consultant_type" class="form-control" required>
              @foreach(['Architect','Structural','MEP','Landscape','Interior','PMC'] as $type)
                <option value="{{ $type }}" @selected(old('consultant_type') == $type)>{{ $type }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group">
            <label>Company Name *</label>
            <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}" required>
          </div>
          <div class="col-md-4 form-group">
            <label>Contact Person *</label>
            <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person') }}" required>
          </div>
          <div class="col-md-4 form-group">
            <label>Mobile *</label>
            <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}" required>
          </div>
          <div class="col-md-4 form-group">
            <label>Email *</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
          </div>
          <div class="col-md-4 form-group">
            <label>GST Number</label>
            <input type="text" name="gst_number" class="form-control" value="{{ old('gst_number') }}">
          </div>
          <div class="col-md-4 form-group">
            <label>Status *</label>
            <select name="status" class="form-control" required>
              @foreach(['Active','Inactive'] as $status)
                <option value="{{ $status }}" @selected(old('status', 'Active') == $status)>{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12 form-group">
            <label>Address</label>
            <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
          </div>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">Save Consultant</button>
          <a href="{{ route('admin.consultant.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
