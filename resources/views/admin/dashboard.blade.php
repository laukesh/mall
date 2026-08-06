@extends('layouts.app')

@section('title','Admin Dashboard')

@section('content')
    <h1>Admin Dashboard</h1>
    <ul>
        <li><a href="{{ route('admin.users.index') }}">Manage Users</a></li>
        <li><a href="{{ route('admin.roles.index') }}">Manage Roles & Permissions</a></li>
        <li><a href="{{ route('admin.malls.index') }}">Manage Malls</a></li>
    </ul>
@endsection
