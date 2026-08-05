@extends('layouts.app')

@section('title','Roles')

@section('content')
    <h1>Roles</h1>
    <a href="{{ route('admin.roles.create') }}">Create Role</a>

    <table border="1">
        <thead>
            <tr><th>ID</th><th>Name</th><th>Permissions</th><th>Actions</th></tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->permissions->pluck('name')->join(', ') }}</td>
                <td>
                    <a href="{{ route('admin.roles.edit', $role->id) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.roles.destroy', $role->id) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete role?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $roles->links() }}
@endsection
