@extends('layouts.app')

@section('title','Create Role')

@section('content')
    <h1>Create Role</h1>
    <form method="POST" action="{{ route('admin.roles.store') }}">
        @csrf
        <label>Name <input name="name" value="{{ old('name') }}"></label><br>
        <h3>Permissions</h3>
        @foreach($permissions as $p)
            <label><input type="checkbox" name="permissions[]" value="{{ $p->name }}"> {{ $p->name }}</label><br>
        @endforeach
        <button type="submit">Create</button>
    </form>
@endsection
