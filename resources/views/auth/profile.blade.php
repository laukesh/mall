<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Profile</title>
</head>
<body>
    <h1>Profile</h1>
    <form method="POST" action="/api/auth/profile">
        @csrf
        <label>Name <input type="text" name="name" value="{{ auth()->user()->name ?? '' }}"></label><br>
        <label>Email <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}"></label><br>
        <button type="submit">Update Profile</button>
    </form>

    <h2>Change Password</h2>
    <form method="POST" action="/api/auth/change-password">
        @csrf
        <label>Current Password <input type="password" name="current_password" required></label><br>
        <label>New Password <input type="password" name="password" required></label><br>
        <label>Confirm <input type="password" name="password_confirmation" required></label><br>
        <button type="submit">Change</button>
    </form>
</body>
</html>
