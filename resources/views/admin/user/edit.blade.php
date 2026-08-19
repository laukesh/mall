@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<section class="section">
  <div class="section-header"><h1>Edit User</h1></div>
  <div class="card"><div class="card-body">
    <form action="{{ route('admin.user.update', $user->id) }}" method="POST">@csrf
      <div class="row">
        <div class="col-md-4 form-group"><label>Employee Code *</label><input type="text" name="employee_code" class="form-control" value="{{ old('employee_code', $user->employee_code) }}" required></div>
        <div class="col-md-8 form-group"><label>Full Name *</label><input type="text" name="full_name" class="form-control" value="{{ old('full_name', $user->full_name) }}" required></div>
        <div class="col-md-4 form-group"><label>Email *</label><input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required></div>
        <div class="col-md-4 form-group"><label>Mobile</label><input type="text" name="mobile" class="form-control" value="{{ old('mobile', $user->mobile) }}"></div>
        <div class="col-md-4 form-group"><label>New Password</label><input type="password" name="password" class="form-control" placeholder="Leave blank to keep"></div>
        <div class="col-md-4 form-group"><label>Role *</label>
          <select name="role_id" class="form-control" required>
            @foreach($roles as $role)<option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) == $role->id)>{{ $role->role_name }}</option>@endforeach
          </select>
        </div>
        <div class="col-md-4 form-group"><label>Designation</label><input type="text" name="designation" class="form-control" value="{{ old('designation', $user->designation) }}"></div>
        <div class="col-md-4 form-group"><label>Department</label><input type="text" name="department" class="form-control" value="{{ old('department', $user->department) }}"></div>
        <div class="col-md-4 form-group"><label>Status *</label>
          <select name="status" class="form-control" required>
            @foreach(['Active','Inactive','Blocked'] as $s)<option value="{{ $s }}" @selected(old('status', $user->status)==$s)>{{ $s }}</option>@endforeach
          </select>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Update User</button>
      <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div></div>
</section>
@endsection
