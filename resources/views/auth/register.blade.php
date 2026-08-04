<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form method="POST" action="/api/auth/register">
        @csrf
        <label>Name <input type="text" name="name" required></label><br>
        <label>Email <input type="email" name="email" required></label><br>
        <label>Password <input type="password" name="password" required></label><br>
        <label>Confirm Password <input type="password" name="password_confirmation" required></label><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
