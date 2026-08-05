<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Forgot Password</title>
</head>
<body>
    <h1>Forgot Password</h1>
    <form method="POST" action="{{ url('/auth/forgot-password') }}">
        @csrf
        <label>Email <input type="email" name="email" required></label><br>
        <button type="submit">Send Reset Link</button>
    </form>
</body>
</html>
