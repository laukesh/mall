<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Mall Management System'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/components.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('public/assets/img/favicon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">  
    <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css') }}">
</head>
<body>
    
<body>


<header class="app-topbar">

    {{-- LEFT --}}
    <div class="topbar-left">

        <button
            type="button"
            class="sidebar-toggle"
            id="sidebarToggle"
        >
            <i class="ri-menu-line"></i>
        </button>


        <div class="page-heading">

            <h5>
                @yield('page_title', 'Dashboard')
            </h5>

            <span>
                Hargeisa Mall Management System
            </span>

        </div>

    </div>


    {{-- RIGHT --}}
    <div class="topbar-right">


        {{-- DATE --}}
        <div class="topbar-date">

            <i class="ri-calendar-line"></i>

            <span id="datechip"></span>

        </div>


        {{-- NOTIFICATION --}}
        <button
            type="button"
            class="topbar-icon"
        >

            <i class="ri-notification-3-line"></i>

            <span class="notification-dot"></span>

        </button>


        {{-- USER --}}
        @php
            $user = auth()->user();
        @endphp

        <div class="topbar-user">

            <div class="topbar-user-avatar">
                {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
            </div>

            <div class="topbar-user-info">

                <strong>
                    {{ $user?->name ?? 'User' }}
                </strong>

                <small>
                    {{ $user ? $user->getRoleNames()->implode(', ') : 'User' }}
                </small>

            </div>

            <i class="ri-arrow-down-s-line user-arrow"></i>

        </div>

    </div>

</header>

{{-- ============================================================
     LEFT SIDEBAR
============================================================ --}}

<aside class="app-sidebar">

    {{-- BRAND --}}
    <div class="sidebar-brand">

        <div class="sidebar-logo">

            <i class="ri-building-4-line"></i>

        </div>

        <div class="sidebar-brand-text">

            <strong>Hargeisa Mall</strong>

            <small>Mall Management</small>

        </div>

    </div>


    {{-- SIDEBAR MENU --}}
    <div class="sidebar-menu">
        @include('components.sidebar')
    </div>


    {{-- SIDEBAR FOOTER --}}

    <div class="sidebar-footer">

        <small>
            Hargeisa Mall Tracker
        </small>

    </div>

</aside>

<main class="app-main">

    <div class="app-content">

        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-danger">
                {{ session('error') }}
            </div>

        @endif


        @if ($errors->any())

            <div class="alert alert-warning">

                <strong>
                    Please fix the following errors:
                </strong>

                <ul class="mb-0">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        @yield('content')

    </div>

</main>

<footer id="footer">Hargeisa Mall Tracker built by Thewebtechi.</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById("datechip").textContent = new Date().toLocaleDateString("en-GB", {
    day: "numeric",
    month: "long",
    year: "numeric"
  });
</script>
<script>

document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.querySelector('.app-sidebar');

    const toggle = document.getElementById('sidebarToggle');


    if (toggle && sidebar) {

        toggle.addEventListener('click', function () {

            sidebar.classList.toggle('show');

        });

    }


    const dateChip = document.getElementById('datechip');

    if (dateChip) {

        dateChip.textContent =
            new Date().toLocaleDateString('en-GB', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });

    }

});

</script>

</body>
</html>