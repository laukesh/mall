@extends('layouts.admin')

@section('title', 'Edit Role')

@section('content')
<section class="section">
  <div class="section-header"><h1>Edit Role</h1></div>
  <div class="card"><div class="card-body">
    <form action="{{ route('admin.role.update', $role->id) }}" method="POST">@csrf
      <div class="form-group"><label>Role Name *</label><input type="text" name="role_name" class="form-control" value="{{ old('role_name', $role->role_name) }}" required></div>
      <div class="form-group"><label>Description</label><textarea name="role_description" class="form-control" rows="3">{{ old('role_description', $role->role_description) }}</textarea></div>
      <div class="form-group"><label>Status *</label>
        <select name="status" class="form-control" required>
          <option value="1" @selected(old('status', $role->status)==1)>Active</option>
          <option value="0" @selected(old('status', $role->status)==0)>Inactive</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Update Role</button>
      <a href="{{ route('admin.role.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div></div>
</section>
@endsection
