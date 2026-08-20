@extends('layouts.admin')

@section('title', 'Add Contractor')

@section('content')
<section class="section">
  <div class="section-header"><h1>Add Contractor</h1></div>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.contractor.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-4 form-group"><label>Contractor Code *</label><input type="text" name="contractor_code" class="form-control" value="{{ old('contractor_code') }}" required></div>
          <div class="col-md-8 form-group"><label>Company Name *</label><input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}" required></div>
          <div class="col-md-4 form-group">
            <label>Contractor Type *</label>
            <select name="contractor_type" id="contractor_type" class="form-control" required>
              @if($isSuperAdmin)
                @foreach(['Main Contractor','Sub Contractor'] as $type)
                  <option value="{{ $type }}" @selected(old('contractor_type', $forceSubContractor ? 'Sub Contractor' : '') == $type)>{{ $type }}</option>
                @endforeach
              @else
                <option value="Sub Contractor" selected>Sub Contractor</option>
              @endif
            </select>
          </div>
          <div class="col-md-8 form-group" id="parent_contractor_group" style="{{ ($forceSubContractor || old('contractor_type') === 'Sub Contractor') ? '' : 'display:none;' }}">
            <label>Parent Main Contractor *</label>
            <select name="parent_contractor_id" class="form-control">
              <option value="">-- Select Main Contractor --</option>
              @foreach($mainContractors as $main)
                <option value="{{ $main->id }}" @selected(old('parent_contractor_id', $defaultParentId) == $main->id)>{{ $main->company_name }} ({{ $main->contractor_code }})</option>
              @endforeach
            </select>
            @if($forceSubContractor)
              <small class="text-muted">Sub-contractors are added under your company.</small>
            @endif
          </div>
          <div class="col-md-4 form-group"><label>Contact Person</label><input type="text" name="contact_person" class="form-control" value="{{ old('contact_person') }}"></div>
          <div class="col-md-4 form-group"><label>Mobile</label><input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}"></div>
          <div class="col-md-4 form-group"><label>Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}"></div>
          <div class="col-md-4 form-group"><label>GST Number</label><input type="text" name="gst_number" class="form-control" value="{{ old('gst_number') }}"></div>
          <div class="col-md-4 form-group"><label>PAN Number</label><input type="text" name="pan_number" class="form-control" value="{{ old('pan_number') }}"></div>
          <div class="col-md-4 form-group"><label>Registration Date</label><input type="date" name="registration_date" class="form-control" value="{{ old('registration_date') }}"></div>
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
          <div class="col-12 form-group"><label>Remarks</label><textarea name="remarks" class="form-control" rows="2">{{ old('remarks') }}</textarea></div>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">Save Contractor</button>
          <a href="{{ route('admin.contractor.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
document.getElementById('contractor_type')?.addEventListener('change', function () {
  const group = document.getElementById('parent_contractor_group');
  if (!group) return;
  group.style.display = this.value === 'Sub Contractor' ? '' : 'none';
});
</script>
@endpush
