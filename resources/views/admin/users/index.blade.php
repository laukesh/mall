@extends('layouts.app')

@section('content')
    <h1>Users</h1>

    <form method="GET" action="{{ route('admin.users.index') }}">
        <input type="text" name="q" placeholder="Search" value="{{ $q ?? '' }}">
        <button type="submit">Search</button>
    </form>

    @if(session('success'))<div>{{ session('success') }}</div>@endif
    @if($errors->any())
        <ul>
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    @endif
    <div class="mall-results-count">Showing {{ $users->total() }} Users</div>
	<div class="mall-table-wrapper">
		<div class="mall-table-scroll">
    <table class="mall-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Active</th>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td><a href="{{ route('admin.users.show', $user->id) }}">{{ $user->name }}</a></td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->is_active ? 'Yes' : 'No' }}</td>
                <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                <td>
                    <a href="{{ route('admin.users.show', $user->id) }}">Manage</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
</div>
@endsection
