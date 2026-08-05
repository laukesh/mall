@extends('layouts.app')

@section('title','Login')

@section('content')
    <h1>Login</h1>
    @if($errors->any())
        <ul>
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label>Email <input type="email" name="email" required value="{{ old('email') }}"></label><br>
        <label>Password <input type="password" name="password" required></label><br>
        <label>Remember <input type="checkbox" name="remember"></label><br>
        <button type="submit">Login</button>
    </form>
@endsection
