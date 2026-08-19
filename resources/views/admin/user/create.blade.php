@extends('layouts.admin')

@section('title', 'Add User')

@section('content')
<section class="section">
  <div class="section-header"><h1>Add User</h1></div>
  <div class="card"><div class="card-body">
    <form action="{{ route('admin.user.store') }}" method="POST">@csrf
      <div class="row">
        <div class="col-md-4 form-group"><label>Employee Code *</label><input type="text" name="employee_code" class="form-control" value="{{ old('employee_code') }}" required></div>
        <div class="col-md-8 form-group"><label>Full Name *</label><input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required></div>
        <div class="col-md-4 form-group"><label>Email *</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required></div>
        <div class="col-md-4 form-group"><label>Mobile</label><input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}"></div>
        <div class="col-md-4 form-group"><label>Password *</label><input type="password" name="password" class="form-control" required></div>
        <div class="col-md-4 form-group"><label>Role *</label>
          <select name="role_id" class="form-control" required>
            <option value="">-- Select --</option>
            @foreach($roles as $role)<option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>{{ $role->role_name }}</option>@endforeach
          </select>
        </div>
        <div class="col-md-4 form-group"><label>Designation</label><input type="text" name="designation" class="form-control" value="{{ old('designation') }}"></div>
        <div class="col-md-4 form-group"><label>Department</label><input type="text" name="department" class="form-control" value="{{ old('department') }}"></div>
        <div class="col-md-4 form-group"><label>Reporting Manager</label>
          <select name="reporting_manager_id" class="form-control">
            <option value="">-- None --</option>
            @foreach($managers as $m)<option value="{{ $m->id }}" @selected(old('reporting_manager_id') == $m->id)>{{ $m->full_name }}</option>@endforeach
          </select>
        </div>
        <div class="col-md-4 form-group"><label>Status *</label>
          <select name="status" class="form-control" required>
            @foreach(['Active','Inactive','Blocked'] as $s)<option value="{{ $s }}" @selected(old('status','Active')==$s)>{{ $s }}</option>@endforeach
          </select>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Save User</button>
      <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div></div>
</section>
@endsection
