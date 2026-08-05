@extends('layouts.app')

@section('title','Edit Role')

@section('content')
    <h1>Edit Role: {{ $role->name }}</h1>
    <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
        @csrf
        @method('PUT')
        <label>Name <input name="name" value="{{ old('name', $role->name) }}"></label><br>
        <h3>Permissions</h3>
        @foreach($permissions as $p)
            <label>
                <input type="checkbox" name="permissions[]" value="{{ $p->name }}" {{ $role->hasPermissionTo($p->name) ? 'checked' : '' }}>
                {{ $p->name }}
            </label><br>
        @endforeach
        <button type="submit">Update</button>
    </form>
@endsection
