@extends('layouts.app')

@section('title','Roles')

@section('content')
<div class="mall-filter-bar">
  <div class="mall-filter-row">
    <h1>Roles</h1>
    <a href="{{ route('admin.roles.create') }}">Create Role</a>

    
</div>
</div>
	<div class="mall-table-wrapper">
		<div class="mall-table-scroll">
    <table class="mall-table">
        <thead>
            <tr><th>ID</th><th>Name</th><th>Permissions</th><th>Actions</th></tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            <tr>
                <td><span class="mall-unit-ref">{{ $role->id }}</span></td>
                <td><span class="mall-unit-ref">{{ $role->name }}</span></td>
                <td><span class="mall-unit-ref">{{ $role->permissions->pluck('name')->join(', ') }}</span></td>
                <td><span class="mall-unit-ref">
                    <a href="{{ route('admin.roles.edit', $role->id) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.roles.destroy', $role->id) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete role?')">Delete</button>
                    </form></span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $roles->links() }}
    
    
</div>
</div>
@endsection
