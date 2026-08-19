@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>User Management</h1>
    <a href="{{ route('admin.user.create') }}" class="btn btn-primary">Add User</a>
  </div>
  <div class="card"><div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped table-hover mb-0">
        <thead><tr><th>Code</th><th>Name</th><th>Email</th><th>Role</th><th>Department</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
          @forelse($users as $user)
          <tr>
            <td>{{ $user->employee_code }}</td>
            <td>{{ $user->full_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role->role_name ?? '-' }}</td>
            <td>{{ $user->department ?? '-' }}</td>
            <td><span class="badge bg-{{ $user->status === 'Active' ? 'success' : 'secondary' }}">{{ $user->status }}</span></td>
            <td class="text-end">
              <a href="{{ route('admin.user.show', $user->id) }}" class="btn btn-sm btn-outline-primary">View</a>
              <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
              <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete user?')">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" class="text-center text-muted py-4">No users found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div></div>
</section>
@endsection
