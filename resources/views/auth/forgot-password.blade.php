@extends('layouts.app')

@section('title','Forgot Password')

@section('content')
    <h1>Forgot Password</h1>
    @if(session('status'))<div>{{ session('status') }}</div>@endif
    @if($errors->any())
        <ul>
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label>Email <input type="email" name="email" required></label><br>
        <button type="submit">Send Reset Link</button>
    </form>
@endsection
