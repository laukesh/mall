<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    @if ($errors->any())
    <div style="background:#f8d7da;color:#721c24;padding:10px;border:1px solid #f5c6cb;margin-bottom:15px;">
        <strong>Please fix the following errors:</strong>

        <ul style="margin-top:10px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
  <form action="{{ url('/auth/register') }}" method="POST">
    @csrf
        <label>Name <input type="text" name="name" required></label><br>
        <label>Email <input type="email" name="email" required></label><br>
        <label>Password <input type="password" name="password" required></label><br>
        <label>Confirm Password <input type="password" name="password_confirmation" required></label><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
