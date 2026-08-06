<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title', config('app.name', 'Mall'))</title>
</head>
<body>
<header>
    <nav>
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ route('admin.malls.index') }}">Malls</a>
        @auth
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('admin.users.index') }}">Manage Users</a>
                <a href="{{ route('admin.roles.index') }}">Roles</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            <a href="{{ route('login.form') }}">Login</a>
            <a href="{{ route('register.form') }}">Register</a>
        @endauth
    </nav>
</header>
<main>
    @if(session('success'))<div style="color:green">{{ session('success') }}</div>@endif
    @yield('content')
</main>
</body>
</html>
