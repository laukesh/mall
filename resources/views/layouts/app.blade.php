<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Mall Management System'))</title>
</head>
<body>

<header>
    <nav>

        <a href="{{ url('/') }}">Home</a>

        @auth

            @can('malls.view')
                <a href="{{ route('admin.malls.index') }}">Malls</a>
            @endcan

            @can('dashboard.view')
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            @endcan

            @can('users.view')
                <a href="{{ route('admin.users.index') }}">Manage Users</a>
            @endcan

            @can('roles.view')
                <a href="{{ route('admin.roles.index') }}">Roles & Permissions</a>
            @endcan

            @can('audit.view')
                <a href="{{ route('admin.users.audits', auth()->id()) }}">Audit Trail</a>
            @endcan

            <span style="margin-left:20px;">
                Welcome,
                <strong>{{ auth()->user()->name }}</strong>
                ({{ auth()->user()->getRoleNames()->implode(', ') }})
            </span>

          

        @else

            <a href="{{ route('login.form') }}">Login</a>
            <a href="{{ route('register.form') }}">Register</a>

        @endauth

    </nav>
</header>

<hr>

<main>

    @if(session('success'))
        <div style="padding:10px;background:#d4edda;color:#155724;border:1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="padding:10px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="padding:10px;background:#fff3cd;color:#856404;border:1px solid #ffeeba;">
            <strong>Please fix the following errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')

</main>

</body>
</html>