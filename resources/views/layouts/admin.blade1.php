<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ config('app.name', PROJECT_TITLE) }} - @yield('title', 'Dashboard')</title>

    <!-- Theme CSS Assets -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    @stack('styles')
</head>

<body>

  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>

      <!-- Top Navigation Bar -->
      <nav class="navbar navbar-expand-lg main-navbar">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li class="humb-wrap">
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn">
                    <img src="{{ asset('assets/img/humb.svg') }}" alt="Toggle Menu">
                </a>
            </li>
            <li class="user-date-wrap">
                <div class="user-date-pdiv">
                    <span class="nv-user">Hello {{ session('user_name', Auth::user()->name ?? 'User') }}</span>
                    <div class="dd-arrow">
                        <img src="{{ asset('assets/img/right-double-arrow.svg') }}" alt="arrow">
                        <span class="nv-date">{{ date('M d, Y') }}</span>
                    </div>
                </div>
            </li>
          </ul>
        </div>

        <div class="navbar-nav navbar-right">
            <!-- Search Form -->
            <form action="{{ url('/admin/booking/search') }}" method="GET" class="search-group m-0 p-0">
              <input type="text" name="search" class="search-control" placeholder="Search by Booking ID..." value="{{ request('search') }}" aria-label="search">
              <button type="submit" class="nav-link nav-link-lg border-0 bg-transparent p-0" id="search">
                  <img src="{{ asset('assets/img/search.svg') }}" alt="search">
              </button>
            </form>

            <div class="noti-bell-wrap">
                  <!-- Notifications Dropdown -->
                  <div class="dropdown dropdown-list-toggle bkg-circle">
                        <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep">
                            <img src="{{ asset('assets/img/notification.svg') }}" alt="notifications">
                        </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                          <div class="dropdown-header">Notifications
                            <div class="float-right">
                              <a href="#">Mark All As Read</a>
                            </div>
                          </div>
                          <div class="dropdown-list-content dropdown-list-icons">
                            <a href="#" class="dropdown-item dropdown-item-unread">
                              <span class="dropdown-item-icon bg-primary text-white">
                                <i class="fas fa-shopping-cart"></i>
                              </span>
                              <span class="dropdown-item-desc">
                                New Booking Created
                                <span class="time">Just Now</span>
                              </span>
                            </a>
                          </div>
                          <div class="dropdown-footer text-center">
                            <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                          </div>
                        </div>
                  </div>            
            
                  <!-- Message / Bell Dropdown -->
                  <div class="dropdown dropdown-list-toggle bkg-circle">
                    <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg">
                        <img src="{{ asset('assets/img/bell.svg') }}" alt="alerts">
                        <span class="noti-number">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                      <div class="dropdown-header">Alerts</div>
                      <div class="dropdown-list-content dropdown-list-message">
                        <a href="#" class="dropdown-item">
                          <span class="dropdown-item-avatar text-white">
                            <img alt="image" src="{{ asset('assets/img/users/user-1.png') }}" class="image-square">
                          </span>
                          <span class="dropdown-item-desc">
                            <span class="message-user">System Alert</span>
                            <span class="time messege-text">New updates available</span>
                          </span>
                        </a>
                      </div>
                    </div>
                  </div>            
            </div>

            <!-- Profile Dropdown -->
            <div class="dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <img alt="image" src="{{ asset('assets/img/user-profile.png') }}" class="user-img-radious-style">
                    <div class="punameid">
                        <span class="puname">{{ session('user_name', Auth::user()->name ?? 'Admin User') }}</span>
                        <span class="pid">{{ Auth::user()->email ?? 'admin@hargeisa.com' }}</span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                  <div class="dropdown-title">Logged in</div>
                  <a href="#" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                  </a>
                  <a href="#" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                  </a>
                </div>              
            </div>
        </div>
      </nav>

      <!-- Sidebar Wrapper -->
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{ url('/') }}">
              <img alt="logo" class="logo-big header-logo" src="{{ asset('assets/img/logo.png') }}" />
              <img alt="logo" class="logo-small header-logo" src="{{ asset('assets/img/small-logo.png') }}" />
            </a>
          </div>

          @include('components.sidebar')

        </aside>
      </div>

      <!-- Main Content Container -->
      <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                    <ul class="mb-0 pl-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
      </div>

    </div>
  </div>

  <!-- Core JavaScript Scripts -->
  <script src="{{ asset('assets/js/app.min.js') }}"></script>
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>

  @stack('scripts')
</body>
</html>