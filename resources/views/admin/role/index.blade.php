@extends('layouts.admin')

@section('title', 'Roles')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Role Management</h1>
    <a href="{{ route('admin.role.create') }}" class="btn btn-primary">Add Role</a>
  </div>
  <div class="card"><div class="card-body p-0">
    <table class="table table-striped mb-0">
      <thead><tr><th>Role Name</th><th>Description</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
      <tbody>
        @forelse($roles as $role)
        <tr>
          <td>{{ $role->role_name }}</td>
          <td>{{ $role->role_description ?? '-' }}</td>
          <td>{{ $role->status ? 'Active' : 'Inactive' }}</td>
          <td class="text-end">
            <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
            <form action="{{ route('admin.role.destroy', $role->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete role?')">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="4" class="text-center text-muted py-4">No roles found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div></div>
</section>
@endsection
