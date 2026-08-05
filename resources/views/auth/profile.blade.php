@extends('layouts.app')

@section('title','Profile')

@section('content')
    <h1>Profile</h1>

    @if(session('success'))<div>{{ session('success') }}</div>@endif
    @if($errors->any())
        <ul>
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        <label>Name <input type="text" name="name" value="{{ auth()->user()->name ?? '' }}"></label><br>
        <label>Email <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}"></label><br>
        <button type="submit">Update Profile</button>
    </form>

    <h2>Change Password</h2>
    <form method="POST" action="{{ route('change.password') }}">
        @csrf
        <label>Current Password <input type="password" name="current_password" required></label><br>
        <label>New Password <input type="password" name="password" required></label><br>
        <label>Confirm <input type="password" name="password_confirmation" required></label><br>
        <button type="submit">Change</button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endsection
