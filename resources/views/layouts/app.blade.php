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
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">  
	<link rel="stylesheet" href="{{ asset('public/assets/css/custom.css') }}">

</head>
<body>
    
<body>

<header class="app-topbar">
 <div class="container">
  <div class="app-topbar-wrapper">
	
    <div class="app-branding">
      <svg width="30" height="30" viewBox="0 0 48 48" fill="none" aria-hidden="true">
        <circle cx="24" cy="9" r="4.4" fill="#F5A300"/>
        <path d="M5 38 C12 20 17 24 23 30 C29 22 34 14 43 38 Z" fill="url(#g1)"/>
        <path d="M5 38 C14 34 20 33 24 35 C30 33 36 33 43 38 Z" fill="#39160A" opacity="0.32"/>
        <defs>
          <linearGradient id="g1" x1="5" y1="38" x2="43" y2="14" gradientUnits="userSpaceOnUse">
            <stop stop-color="#D84D08"/>
            <stop offset="1" stop-color="#F5A300"/>
          </linearGradient>
        </defs>
      </svg>
      <div class="app-title-group">
        <span class="app-title-main">Hargeisa Mall</span>
        <span class="app-title-sub">Mall Tracker</span>
        
      </div>
    </div>
    <div class="app-flex-spacer"></div>
        <span class="app-date-tag">
            Welcome,
            <strong>{{ auth()->user()->name }}</strong>
            ({{ auth()->user()->getRoleNames()->implode(', ') }})
        </span>
    <span class="app-date-tag" id="datechip"></span>
  </div>	
	
	</div>
</header>

<nav class="app-navigation">
	<div class="container">
		<div class="app-nav-wrapper">
			 <a class="app-nav-link" href="{{ url('/') }}">Home</a>

                @auth

                  @can('dashboard.view')
                `     <a class="app-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                            href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    @endcan

                    @can('malls.view')
                        <a class="app-nav-link {{ request()->routeIs('admin.malls.*') ? 'active' : '' }}"
                            href="{{ route('admin.malls.index') }}">
                            Malls
                        </a>
                    @endcan

                    @can('buildings.view')
                        <a class="app-nav-link {{ request()->routeIs('admin.buildings.*') ? 'active' : '' }}"
                            href="{{ route('admin.buildings.index') }}">
                            Buildings
                        </a>
                    @endcan
                    

                    @can('users.view')
                        <a class="app-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                            href="{{ route('admin.users.index') }}">
                            Manage Users
                        </a>
                    @endcan

                    @can('roles.view')
                        <a class="app-nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}"
                            href="{{ route('admin.roles.index') }}">
                            Roles & Permissions
                        </a>
                    @endcan

                    @can('audit.view')
                        <a class="app-nav-link {{ request()->routeIs('admin.users.audits') ? 'active' : '' }}"
                            href="{{ route('admin.users.audits', auth()->id()) }}">
                            Audit Trail
                        </a>
                    @endcan`

                   

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" style="float: right;"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border border-red-500 text-red-600 hover:bg-red-600 hover:text-white rounded-sm text-sm leading-normal">
                        Logout
                    </button>
                </form>   

                @else

                    <a class="app-nav-link" href="{{ route('login.form') }}">Login</a>
                    <a class="app-nav-link" href="{{ route('register.form') }}">Register</a>

                @endauth

		</div>	
        
	</div>
   
</nav>

<section class="sect-cover">
	<div class="container">
	  <div class="main-content">
		<div class="section">
			<div class="mall-page-content">
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
      </div>
      </div>
	  </div>
	</div>
</section> 

<footer id="footer">Hargeisa Mall Tracker built by Thewebtechi.</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById("datechip").textContent = new Date().toLocaleDateString("en-GB", {
    day: "numeric",
    month: "long",
    year: "numeric"
  });
</script>


</body>
</html>