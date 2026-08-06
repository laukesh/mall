@extends('layouts.app')

@section('content')
    <h1>Manage User: {{ $user->name }}</h1>

    @if(session('success'))<div>{{ session('success') }}</div>@endif
    @if($errors->any())
        <ul>
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    @endif

    <p>Email: {{ $user->email }}</p>
    <p>Active: {{ $user->is_active ? 'Yes' : 'No' }}</p>
    <p>Roles: {{ $user->roles->pluck('name')->join(', ') }}</p>

    <h2>Assign Role</h2>
    <form method="POST" action="{{ route('admin.users.assign-role', $user->id) }}">
        @csrf
        <select name="role">
            @foreach($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
        </select>
        <button type="submit">Assign</button>
    </form>

    <h2>Revoke Role</h2>
    <form method="POST" action="{{ route('admin.users.revoke-role', $user->id) }}">
        @csrf
        <select name="role">
            @foreach($user->roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
        </select>
        <button type="submit">Revoke</button>
    </form>

    <h2>Activate / Deactivate</h2>
    @if(! $user->is_active)
        <form method="POST" action="{{ route('admin.users.activate', $user->id) }}" style="display:inline">
            @csrf
            <button type="submit">Activate</button>
        </form>
    @else
        <form method="POST" action="{{ route('admin.users.deactivate', $user->id) }}" style="display:inline">
            @csrf
            <button type="submit">Deactivate</button>
        </form>
    @endif

    <h2>Audit Logs</h2>
    <a href="{{ route('admin.users.audits', $user->id) }}">View audits</a>

    <p><a href="{{ route('admin.users.index') }}">Back to list</a></p>
@endsection
