<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    @if($errors->any())
        <ul>
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    @endif
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label>Name <input type="text" name="name" required value="{{ old('name') }}"></label><br>
        <label>Email <input type="email" name="email" required value="{{ old('email') }}"></label><br>
        <label>Password <input type="password" name="password" required></label><br>
        <label>Confirm Password <input type="password" name="password_confirmation" required></label><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
