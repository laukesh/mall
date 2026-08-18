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
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Mall Management System'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/assets/css/app.min.css') }}">
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
            <strong>{{ auth()->user()->name ?? 'Guest' }}</strong>
        </span>
    <span class="app-date-tag" id="datechip"></span>
  </div>	
	
	</div>
</header>

<nav class="app-navigation">
    <div class="container">
        <ul class="app-nav-wrapper">

            @auth

                {{-- =========================================================
                    OVERVIEW
                ========================================================== --}}
                @can('dashboard.view')
                    <li class="app-nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="app-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="ri-dashboard-line"></i>
                            Overview
                        </a>
                    </li>
                @endcan


                    {{-- =========================================================
    ASSETS
========================================================= --}}
@if(
    auth()->user()->can('malls.view') ||
    auth()->user()->can('buildings.view') ||
    auth()->user()->can('floors.view') ||
    auth()->user()->can('zones.view') ||
    auth()->user()->can('unit_types.view') ||
    auth()->user()->can('units.view') ||
    auth()->user()->can('unit_statuses.view') ||
    auth()->user()->can('unit_documents.view') ||
    auth()->user()->can('departments.view') ||
    auth()->user()->can('assets.categories.view') ||
    auth()->user()->can('assets.view')
)

    <li class="app-nav-item has-dropdown">

        <a href="#"
           class="app-nav-link {{ request()->routeIs('admin.assets.*') ? 'active' : '' }}">

            <i class="ri-building-2-line"></i>
            Assets
            <i class="ri-arrow-down-s-line"></i>

        </a>


        <ul class="dropdown-menu level-2">

            {{-- =================================================
                PROPERTY STRUCTURE
            ================================================== --}}
            @if(
                auth()->user()->can('malls.view') ||
                auth()->user()->can('buildings.view') ||
                auth()->user()->can('floors.view') ||
                auth()->user()->can('zones.view')
            )

                <li class="dropdown-item has-dropdown">

                    <a href="#"
                       class="dropdown-link">

                        <i class="ri-building-line"></i>
                        Property Structure

                        <i class="ri-arrow-right-s-line"></i>

                    </a>


                    <ul class="dropdown-menu level-3">

                        {{-- Malls --}}
                        @can('malls.view')

                            <li class="dropdown-item">

                                <a href="{{ route('admin.assets.malls.index') }}"
                                   class="dropdown-link {{ request()->routeIs('admin.assets.malls.*') ? 'active' : '' }}">

                                    <i class="ri-store-2-line"></i>
                                    Malls

                                </a>

                            </li>

                        @endcan


                        {{-- Buildings --}}
                        @can('buildings.view')

                            <li class="dropdown-item">

                                <a href="{{ route('admin.assets.buildings.index') }}"
                                   class="dropdown-link {{ request()->routeIs('admin.assets.buildings.*') ? 'active' : '' }}">

                                    <i class="ri-building-line"></i>
                                    Buildings

                                </a>

                            </li>

                        @endcan


                        {{-- Floors --}}
                        @can('floors.view')

                            <li class="dropdown-item">

                                <a href="{{ route('admin.assets.floors.index') }}"
                                   class="dropdown-link {{ request()->routeIs('admin.assets.floors.*') ? 'active' : '' }}">

                                    <i class="ri-layout-4-line"></i>
                                    Floors

                                </a>

                            </li>

                        @endcan


                        {{-- Zones --}}
                        @can('zones.view')

                            <li class="dropdown-item">

                                <a href="{{ route('admin.assets.zones.index') }}"
                                   class="dropdown-link {{ request()->routeIs('admin.assets.zones.*') ? 'active' : '' }}">

                                    <i class="ri-map-pin-line"></i>
                                    Zones

                                </a>

                            </li>

                        @endcan

                    </ul>

                </li>

            @endif


            {{-- =================================================
                UNITS & DOCUMENTS
            ================================================== --}}
            @if(
                auth()->user()->can('unit_types.view') ||
                auth()->user()->can('units.view') ||
                auth()->user()->can('unit_statuses.view') ||
                auth()->user()->can('unit_documents.view')
            )

                <li class="dropdown-item has-dropdown">

                    <a href="#"
                       class="dropdown-link">

                        <i class="ri-home-office-line"></i>
                        Units & Tenants

                        <i class="ri-arrow-right-s-line"></i>

                    </a>


                    <ul class="dropdown-menu level-3">

                        {{-- Unit Types --}}
                        @can('unit_types.view')

                            <li class="dropdown-item">

                                <a href="{{ route('admin.assets.unit_types.index') }}"
                                   class="dropdown-link {{ request()->routeIs('admin.assets.unit_types.*') ? 'active' : '' }}">

                                    <i class="ri-grid-line"></i>
                                    Unit Types

                                </a>

                            </li>

                        @endcan


                        {{-- Units --}}
                        @can('units.view')

                            <li class="dropdown-item">

                                <a href="{{ route('admin.assets.units.index') }}"
                                   class="dropdown-link {{ request()->routeIs('admin.assets.units.*') ? 'active' : '' }}">

                                    <i class="ri-home-office-line"></i>
                                    All Units

                                </a>

                            </li>

                        @endcan


                        {{-- Unit Statuses --}}
                        @can('unit_statuses.view')

                            <li class="dropdown-item">

                                <a href="{{ route('admin.assets.unit-statuses.index') }}"
                                   class="dropdown-link {{ request()->routeIs('admin.assets.unit-statuses.*') ? 'active' : '' }}">

                                    <i class="ri-checkbox-circle-line"></i>
                                    Unit Statuses

                                </a>

                            </li>

                        @endcan


                        {{-- Unit Documents --}}
                        @can('unit_documents.view')

                            <li class="dropdown-item">

                                <a href="{{ route('admin.assets.unit-documents.index') }}"
                                   class="dropdown-link {{ request()->routeIs('admin.assets.unit-documents.*') ? 'active' : '' }}">

                                    <i class="ri-file-text-line"></i>
                                    Unit Documents

                                </a>

                            </li>

                        @endcan

                    </ul>

                </li>

            @endif


            {{-- =================================================
                ORGANIZATION
            ================================================== --}}
            @can('departments.view')

                <li class="dropdown-item">

                    <a href="{{ route('admin.assets.departments.index') }}"
                       class="dropdown-link {{ request()->routeIs('admin.assets.departments.*') ? 'active' : '' }}">

                        <i class="ri-organization-chart"></i>
                        Departments

                    </a>

                </li>

            @endcan


            {{-- =================================================
                ASSET MANAGEMENT
            ================================================== --}}
            @if(
                auth()->user()->can('asset_categories.view') ||
                auth()->user()->can('assets.view')
            )

                <li class="dropdown-item has-dropdown">

                    <a href="#"
                       class="dropdown-link">

                        <i class="ri-tools-line"></i>
                        Asset Management

                        <i class="ri-arrow-right-s-line"></i>

                    </a>


                    <ul class="dropdown-menu level-3">

                        {{-- Asset Categories --}}
                        @can('asset_categories.view')

                            <li class="dropdown-item">

                                <a href="{{ route('admin.assets.asset-categories.index') }}"
                                   class="dropdown-link {{ request()->routeIs('admin.assets.asset-categories.*') ? 'active' : '' }}">

                                    <i class="ri-price-tag-3-line"></i>
                                    Asset Categories

                                </a>

                            </li>

                        @endcan


                        {{-- Assets --}}
                        @can('assets.view')

                            <li class="dropdown-item">

                                <a href="{{ route('admin.assets.assets.index') }}"
                                   class="dropdown-link {{ request()->routeIs('admin.assets.assets.*') ? 'active' : '' }}">

                                    <i class="ri-tools-line"></i>
                                    Assets

                                </a>

                            </li>

                        @endcan

                    </ul>

                </li>

            @endif

        </ul>

    </li>

@endif


                {{-- =========================================================
                    LEASING
                ========================================================== --}}
                <li class="app-nav-item has-dropdown">
                ====================================================== --}}
                <!-- <li class="app-nav-item has-dropdown">

                    <a href="{{ route('admin.leasing.dashboard') }}"
                       class="app-nav-link {{ request()->routeIs('admin.leasing.*') ? 'active' : '' }}">

                        <i class="ri-file-text-line"></i>
                        Leasing
                        <i class="ri-arrow-down-s-line"></i>

                    </a>

                    <ul class="dropdown-menu level-2">

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.dashboard') }}"
                               class="dropdown-link {{ request()->routeIs('admin.leasing.dashboard') ? 'active' : '' }}">
                                <i class="ri-dashboard-line"></i>
                                Leasing Dashboard
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.proposals.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.leasing.proposals.*') ? 'active' : '' }}">
                                <i class="ri-file-edit-line"></i>
                                Lease Proposals
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.agreements.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.leasing.agreements.*') ? 'active' : '' }}">
                                <i class="ri-contract-line"></i>
                                Lease Agreements
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.terms.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.leasing.terms.*') ? 'active' : '' }}">
                                <i class="ri-file-list-3-line"></i>
                                Lease Terms
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.documents.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.leasing.documents.*') ? 'active' : '' }}">
                                <i class="ri-folder-open-line"></i>
                                Lease Documents
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.renewals.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.leasing.renewals.*') ? 'active' : '' }}">
                                <i class="ri-refresh-line"></i>
                                Renewals
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.escalations.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.leasing.escalations.*') ? 'active' : '' }}">
                                <i class="ri-arrow-up-circle-line"></i>
                                Escalations
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.history.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.leasing.history.*') ? 'active' : '' }}">
                                <i class="ri-history-line"></i>
                                Lease History
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.terminations.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.leasing.terminations.*') ? 'active' : '' }}">
                                <i class="ri-close-circle-line"></i>
                                Terminations
                            </a>
                        </li>

                    </ul>
                </li>


            {{-- =========================================================
    TENANTS
<li class="app-nav-item has-dropdown">

    <a href="{{ route('admin.tenants.dashboard') }}"
       class="app-nav-link {{ request()->routeIs('admin.tenants.*') ? 'active' : '' }}">

        <i class="ri-user-3-line"></i>
        Tenants

        <i class="ri-arrow-down-s-line"></i>
    </a>

    <ul class="dropdown-menu level-2">

        {{-- Dashboard --}}
        <li class="dropdown-item">
            <a href="{{ route('admin.tenants.dashboard') }}"
               class="dropdown-link {{ request()->routeIs('admin.tenants.dashboard') ? 'active' : '' }}">

                <i class="ri-dashboard-line"></i>
                Tenant Dashboard
            </a>
        </li>

        {{-- All Tenants --}}
        <li class="dropdown-item">
            <a href="{{ route('admin.tenants.index') }}"
               class="dropdown-link {{ request()->routeIs('admin.tenants.index') ? 'active' : '' }}">

                <i class="ri-team-line"></i>
                All Tenants
            </a>
        </li>

        {{-- Add Tenant --}}
        <li class="dropdown-item">
            <a href="{{ route('admin.tenants.create') }}"
               class="dropdown-link {{ request()->routeIs('admin.tenants.create') ? 'active' : '' }}">

                <i class="ri-user-add-line"></i>
                Add Tenant
            </a>
        </li>

    </ul>

</li>
{{-- =========================================================
    FIT-OUT
<li class="app-nav-item has-dropdown">

    <a href="{{ route('admin.fitout.dashboard') }}"
       class="app-nav-link {{ request()->routeIs('admin.fitout.*') ? 'active' : '' }}">

        <i class="ri-tools-line"></i>
        Fit-out

        <i class="ri-arrow-down-s-line"></i>
    </a>

    <ul class="dropdown-menu level-2">

        {{-- Dashboard --}}
        <li class="dropdown-item">

            <a href="{{ route('admin.fitout.dashboard') }}"
               class="dropdown-link {{ request()->routeIs('admin.fitout.dashboard') ? 'active' : '' }}">

                <i class="ri-dashboard-line"></i>
                Fit-out Dashboard

            </a>

        </li>


        {{-- =====================================================
            REQUESTS
        ====================================================== --}}
        <li class="dropdown-item">

            <a href="{{ route('admin.fitout.requests.index') }}"
               class="dropdown-link {{ request()->routeIs('admin.fitout.requests.*') ? 'active' : '' }}">

                <i class="ri-file-edit-line"></i>
                Fit-out Requests

            </a>

        </li>


        {{-- =====================================================
            STAGES
        ====================================================== --}}
        <li class="dropdown-item">

            <a href="{{ route('admin.fitout.stages.show', ['id' => 0]) }}"
               class="dropdown-link">

                <i class="ri-list-check-3"></i>
                Fit-out Stages

            </a>

        </li>


        {{-- =====================================================
            APPROVALS
        ====================================================== --}}
        <li class="dropdown-item has-dropdown">

            <a href="{{ route('admin.fitout.approvals.index') }}"
               class="dropdown-link {{ request()->routeIs('admin.fitout.approvals.*') ? 'active' : '' }}">

                <i class="ri-checkbox-circle-line"></i>
                Approvals

                <i class="ri-arrow-right-s-line"></i>

            </a>

            <ul class="dropdown-menu level-3">

                <li class="dropdown-item">

                    <a href="{{ route('admin.fitout.approvals.index') }}"
                       class="dropdown-link">

                        <i class="ri-file-list-3-line"></i>
                        All Approvals

                    </a>

                </li>

                <li class="dropdown-item">

                    <a href="{{ route('admin.fitout.approvals.pending') }}"
                       class="dropdown-link">

                        <i class="ri-time-line"></i>
                        Pending Approvals

                    </a>

                </li>

            </ul>

        </li>


        {{-- =====================================================
            INSPECTIONS
        ====================================================== --}}
        <li class="dropdown-item">

            <a href="{{ route('admin.fitout.inspections.index') }}"
               class="dropdown-link {{ request()->routeIs('admin.fitout.inspections.*') ? 'active' : '' }}">

                <i class="ri-search-eye-line"></i>
                Inspections

            </a>

        </li>


        {{-- =====================================================
            DOCUMENTS
        ====================================================== --}}
        <li class="dropdown-item">

            <a href="{{ route('admin.fitout.documents.index') }}"
               class="dropdown-link {{ request()->routeIs('admin.fitout.documents.*') ? 'active' : '' }}">

                <i class="ri-folder-open-line"></i>
                Documents

            </a>

        </li>


        {{-- =====================================================
            CONTRACTORS
        ====================================================== --}}
        <li class="dropdown-item">

            <a href="{{ route('admin.fitout.contractors.index') }}"
               class="dropdown-link {{ request()->routeIs('admin.fitout.contractors.*') ? 'active' : '' }}">

                <i class="ri-team-line"></i>
                Contractors

            </a>

        </li>


        {{-- =====================================================
            HANDOVERS
        ====================================================== --}}
        <li class="dropdown-item">

            <a href="{{ route('admin.fitout.handovers.index') }}"
               class="dropdown-link {{ request()->routeIs('admin.fitout.handovers.*') ? 'active' : '' }}">

                <i class="ri-hand-coin-line"></i>
                Handovers

            </a>

        </li>


        {{-- =====================================================
            SNAGS
        ====================================================== --}}
        <li class="dropdown-item">

            <a href="{{ route('admin.fitout.snags.index') }}"
               class="dropdown-link {{ request()->routeIs('admin.fitout.snags.*') ? 'active' : '' }}">

                <i class="ri-error-warning-line"></i>
                Snags

            </a>

        </li>

    </ul>

</li>


                {{-- =========================================================
                    REVENUE
                ========================================================== --}}
                <li class="app-nav-item has-dropdown">

                    <a href="{{ route('admin.revenue.dashboard') }}"
                       class="app-nav-link {{ request()->routeIs('admin.revenue.*') ? 'active' : '' }}">

                        <i class="ri-money-dollar-circle-line"></i>
                        Revenue
                </li> -->

                <li class="app-nav-item has-dropdown">

                    <a href="#"
                       class="app-nav-link">

                        Leasing

                        <i class="ri-arrow-down-s-line"></i>

                    </a>


                    <ul class="dropdown-menu level-2">

                        {{-- Dashboard --}}
                        <li class="dropdown-item">
                            <a href="{{ route('admin.revenue.dashboard') }}"
                               class="dropdown-link {{ request()->routeIs('admin.revenue.dashboard') ? 'active' : '' }}">
                                <i class="ri-dashboard-line"></i>
                                Revenue Dashboard

                        {{-- =====================================================
                             DASHBOARD
                        ====================================================== --}}

                        <li class="dropdown-item">

                            <a
                                href="{{ route('admin.leasing.dashboard') }}"
                                class="dropdown-link"
                            >

                                <i class="ri-dashboard-line me-2"></i>

                                Leasing Dashboard

                            </a>

                        </li>

                        {{-- Rent Schedules --}}
                        <li class="dropdown-item">
                            <a href="{{ route('admin.revenue.rent-schedules.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.revenue.rent-schedules.*') ? 'active' : '' }}">
                                <i class="ri-calendar-schedule-line"></i>
                                Rent Schedules
                            </a>
                        </li>

                        {{-- Invoices --}}
                        <li class="dropdown-item">
                            <a href="{{ route('admin.revenue.invoices.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.revenue.invoices.*') ? 'active' : '' }}">
                                <i class="ri-file-text-line"></i>
                                Invoices

                        {{-- =====================================================
                             LEASE MANAGEMENT
                        ====================================================== --}}

                        <li class="dropdown-item has-dropdown">

                            <a
                                href="#"
                                class="dropdown-link"
                            >

                                <span>
                                    <i class="ri-file-list-3-line me-2"></i>
                                    Lease Management
                                </span>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>


                            <ul class="dropdown-menu level-3">


                                {{-- ALL LEASING --}}

                                <li class="dropdown-item">

                                    <a
                                        href="{{ route('admin.leasing.index') }}"
                                        class="dropdown-link"
                                    >

                                        All Leasing

                                    </a>

                                </li>


                                {{-- PROPOSALS --}}

                                <li class="dropdown-item">

                                    <a
                                        href="{{ route(
                                            'admin.leasing.proposals.index'
                                        ) }}"
                                        class="dropdown-link"
                                    >

                                        Lease Proposals

                                    </a>

                                </li>


                                {{-- AGREEMENTS --}}

                                <li class="dropdown-item">

                                    <a
                                        href="{{ route(
                                            'admin.leasing.agreements.index'
                                        ) }}"
                                        class="dropdown-link"
                                    >

                                        Lease Agreements

                                    </a>

                                </li>

                            </ul>

                        </li>

                        {{-- Payments --}}
                        <li class="dropdown-item">
                            <a href="{{ route('admin.revenue.payments.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.revenue.payments.*') ? 'active' : '' }}">
                                <i class="ri-bank-card-line"></i>
                                Payments

                        {{-- =====================================================
                             LEASE DETAILS
                        ====================================================== --}}

                        <li class="dropdown-item has-dropdown">

                            <a
                                href="#"
                                class="dropdown-link"
                            >

                                <span>
                                    <i class="ri-file-info-line me-2"></i>
                                    Lease Details
                                </span>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>


                            <ul class="dropdown-menu level-3">


                                {{-- TERMS --}}

                                <li class="dropdown-item">

                                    <a
                                        href="{{ route(
                                            'admin.leasing.terms.index'
                                        ) }}"
                                        class="dropdown-link"
                                    >

                                        Lease Terms

                                    </a>

                                </li>


                                {{-- DOCUMENTS --}}

                                <li class="dropdown-item">

                                    <a
                                        href="{{ route(
                                            'admin.leasing.documents.index'
                                        ) }}"
                                        class="dropdown-link"
                                    >

                                        Lease Documents

                                    </a>

                                </li>

                            </ul>

                        </li>

                        {{-- Receipts --}}
                        <li class="dropdown-item">
                            <a href="{{ route('admin.revenue.deposit-receipts.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.revenue.deposit-receipts.*') ? 'active' : '' }}">
                                <i class="ri-receipt-line"></i>
                                Receipts

                        {{-- =====================================================
                             LEASE CHANGES
                        ====================================================== --}}

                        <li class="dropdown-item has-dropdown">

                            <a
                                href="#"
                                class="dropdown-link"
                            >

                                <span>
                                    <i class="ri-line-chart-line me-2"></i>
                                    Lease Changes
                                </span>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>


                            <ul class="dropdown-menu level-3">


                                {{-- ESCALATIONS --}}

                                <li class="dropdown-item">

                                    <a
                                        href="{{ route(
                                            'admin.leasing.escalations.index'
                                        ) }}"
                                        class="dropdown-link"
                                    >

                                        Rent Escalations

                                    </a>

                                </li>


                                {{-- RENEWALS --}}

                                <li class="dropdown-item">

                                    <a
                                        href="{{ route(
                                            'admin.leasing.renewals.index'
                                        ) }}"
                                        class="dropdown-link"
                                    >

                                        Lease Renewals

                                    </a>

                                </li>

                            </ul>

                        </li>


                        {{-- =====================================================
                             EXIT MANAGEMENT
                        ====================================================== --}}

                        <li class="dropdown-item has-dropdown">

                            <a
                                href="#"
                                class="dropdown-link"
                            >

                                <span>
                                    <i class="ri-logout-box-line me-2"></i>
                                    Exit Management
                                </span>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>


                            <ul class="dropdown-menu level-3">


                                {{-- TERMINATIONS --}}

                                <li class="dropdown-item">

                                    <a
                                        href="{{ route(
                                            'admin.leasing.terminations.index'
                                        ) }}"
                                        class="dropdown-link"
                                    >

                                        Lease Terminations

                                    </a>

                                </li>


                                {{-- HISTORY --}}

                                <li class="dropdown-item">

                                    <a
                                        href="{{ route(
                                            'admin.leasing.history.index'
                                        ) }}"
                                        class="dropdown-link"
                                    >

                                        Lease History

                                    </a>

                                </li>

                            </ul>

                        </li>

                        {{-- Deposits --}}
                        <li class="dropdown-item">
                            <a href="{{ route('admin.revenue.deposits.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.revenue.deposits.*') ? 'active' : '' }}">
                                <i class="ri-wallet-3-line"></i>
                                Deposits
                            </a>
                        </li>

                        {{-- Deposit Refunds --}}
                        <li class="dropdown-item">
                            <a href="{{ route('admin.revenue.deposit-refunds.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.revenue.deposit-refunds.*') ? 'active' : '' }}">
                                <i class="ri-refund-2-line"></i>
                                Deposit Refunds
                            </a>
                        </li>

                    </ul>

                </li>

                        {{-- Outstanding --}}
                        <li class="dropdown-item has-dropdown">

                            <a href="{{ route('admin.revenue.outstanding.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.revenue.outstanding.*') ? 'active' : '' }}">

                                <i class="ri-alert-line"></i>
                                Outstanding
                {{-- =====================================================
                    TENANTS
                ====================================================== --}}
                <li class="app-nav-item has-dropdown">

                    <a href="#" class="app-nav-link">
                        Tenants
                        <i class="ri-arrow-down-s-line"></i>
                    </a>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>

                            <ul class="dropdown-menu level-3">

                                <li class="dropdown-item">
                                    <a href="{{ route('admin.revenue.outstanding.index') }}"
                                       class="dropdown-link">
                                        All Outstanding
                                    </a>
                                </li>

                                <li class="dropdown-item">
                                    <a href="{{ route('admin.revenue.outstanding.overdue') }}"
                                       class="dropdown-link">
                                        Overdue
                                    </a>
                                </li>

                                <li class="dropdown-item">
                                    <a href="{{ route('admin.revenue.outstanding.tenants') }}"
                                       class="dropdown-link">
                                        Tenant Outstanding
                                    </a>
                                </li>

                            </ul>

                        </li>


                        {{-- Reports --}}
                        <li class="dropdown-item has-dropdown">

                            <a href="{{ route('admin.revenue.reports.revenue') }}"
                               class="dropdown-link {{ request()->routeIs('admin.revenue.reports.*') ? 'active' : '' }}">

                                <i class="ri-bar-chart-2-line"></i>
                                Revenue Reports

                                <i class="ri-arrow-right-s-line"></i>

                            </a>

                            <ul class="dropdown-menu level-3">

                                <li class="dropdown-item">
                                    <a href="{{ route('admin.revenue.reports.revenue') }}"
                                       class="dropdown-link">
                                        Revenue Report
                                    </a>
                                </li>

                                <li class="dropdown-item">
                                    <a href="{{ route('admin.revenue.reports.collections') }}"
                                       class="dropdown-link">
                                        Collection Report
                                    </a>
                                </li>

                                <li class="dropdown-item">
                                    <a href="{{ route('admin.revenue.reports.charge-wise') }}"
                                       class="dropdown-link">
                                        Charge-wise Report
                                    </a>
                                </li>

                                <li class="dropdown-item">
                                    <a href="{{ route('admin.revenue.reports.tenant-wise') }}"
                                       class="dropdown-link">
                                        Tenant-wise Report
                                    </a>
                                </li>

                                <li class="dropdown-item">
                                    <a href="{{ route('admin.revenue.reports.aging') }}"
                                       class="dropdown-link">
                                        Aging Report
                                    </a>
                                </li>

                            </ul>

                        </li>


                        {{-- Reconciliation --}}
                        <li class="dropdown-item">
                            <a href="{{ route('admin.revenue.reconciliation.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.revenue.reconciliation.*') ? 'active' : '' }}">
                                <i class="ri-check-double-line"></i>
                                Reconciliation
                        {{-- =====================================================
                             DASHBOARD
                        ====================================================== --}}

                        <li class="dropdown-item">

                            <a href="{{ url('/admin/tenants/dashboard') }}"
                               class="dropdown-link">

                                <i class="ri-dashboard-line me-1"></i>
                                Dashboard

                            </a>

                        </li>


                        {{-- Charge Types --}}
                        <li class="dropdown-item">
                            <a href="{{ route('admin.revenue.settings.charge-types.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.revenue.settings.charge-types.*') ? 'active' : '' }}">
                                <i class="ri-price-tag-3-line"></i>
                                Charge Types
                        {{-- =====================================================
                             TENANT MANAGEMENT
                        ====================================================== --}}

                        <li class="dropdown-item has-dropdown">

                            <a href="#"
                               class="dropdown-link">

                                <span>
                                    <i class="ri-group-line me-1"></i>
                                    Tenant Management
                                </span>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>


                            <ul class="dropdown-menu level-3">

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/tenants') }}"
                                       class="dropdown-link">

                                        All Tenants

                                    </a>

                                </li>


                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/tenants?status=Active') }}"
                                       class="dropdown-link">

                                        Active Tenants

                                    </a>

                                </li>


                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/tenants?status=Inactive') }}"
                                       class="dropdown-link">

                                        Inactive Tenants

                                    </a>

                                </li>

                            </ul>

                        </li>


                        {{-- Audit Log --}}
                        <li class="dropdown-item">
                            <a href="{{ route('admin.revenue.audit.index') }}"
                               class="dropdown-link {{ request()->routeIs('admin.revenue.audit.*') ? 'active' : '' }}">
                                <i class="ri-shield-check-line"></i>
                                Revenue Audit Log
                        {{-- =====================================================
                             UNITS & LEASES
                        ====================================================== --}}

                        <li class="dropdown-item has-dropdown">

                            <a href="#"
                               class="dropdown-link">

                                <span>
                                    <i class="ri-building-line me-1"></i>
                                    Units & Leases
                                </span>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>


                            <ul class="dropdown-menu level-3">

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/tenants/leases') }}"
                                       class="dropdown-link">

                                        Tenant Leases

                                    </a>

                                </li>


                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/tenants/leases/expiry') }}"
                                       class="dropdown-link">

                                        Lease Expiry

                                    </a>

                                </li>

                            </ul>

                        </li>


                        {{-- =====================================================
                             REVENUE
                        ====================================================== --}}

                        <li class="dropdown-item has-dropdown">

                            <a href="#"
                               class="dropdown-link">

                                <span>
                                    <i class="ri-money-rupee-circle-line me-1"></i>
                                    Revenue
                                </span>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>


                            <ul class="dropdown-menu level-3">

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/revenue/outstanding/tenants') }}"
                                       class="dropdown-link">

                                        Tenant Revenue

                                    </a>

                                </li>


                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/revenue/outstanding/tenants') }}"
                                       class="dropdown-link">

                                        Tenant Outstanding

                                    </a>

                                </li>

                            </ul>

                        </li>


                        {{-- =====================================================
                             DOCUMENTS
                        ====================================================== --}}

                        <li class="dropdown-item has-dropdown">

                            <a href="#"
                               class="dropdown-link">

                                <span>
                                    <i class="ri-file-text-line me-1"></i>
                                    Documents
                                </span>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>


                            <ul class="dropdown-menu level-3">

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/tenants/documents') }}"
                                       class="dropdown-link">

                                        Tenant Documents

                                    </a>

                                </li>

                            </ul>

                        </li>


                        {{-- =====================================================
                             CONTACTS
                        ====================================================== --}}

                        <li class="dropdown-item has-dropdown">

                            <a href="#"
                               class="dropdown-link">

                                <span>
                                    <i class="ri-contacts-line me-1"></i>
                                    Contacts
                                </span>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>


                            <ul class="dropdown-menu level-3">

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/tenants/contacts') }}"
                                       class="dropdown-link">

                                        Tenant Contacts

                                    </a>

                                </li>


                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/tenants/emergency-contacts') }}"
                                       class="dropdown-link">

                                        Emergency Contacts

                                    </a>

                                </li>

                            </ul>

                        </li>


                        {{-- =====================================================
                             SETTINGS
                        ====================================================== --}}

                        <li class="dropdown-item has-dropdown">

                            <a href="#"
                               class="dropdown-link">

                                <span>
                                    <i class="ri-settings-3-line me-1"></i>
                                    Settings
                                </span>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>


                            <ul class="dropdown-menu level-3">

                                <li class="dropdown-item">

                                    <a
                                        href="{{ url('/admin/tenants/settings/business-categories') }}"
                                        class="dropdown-link"
                                    >

                                        Business Categories

                                    </a>

                                </li>

                            </ul>

                        </li>

                    </ul>

                </li>


                {{-- =====================================================
                    REVENUE
                ====================================================== --}}
                <li class="app-nav-item has-dropdown">

                    <a href="#" class="app-nav-link">
                        Revenue
                        <i class="ri-arrow-down-s-line"></i>
                    </a>

                    <ul class="dropdown-menu level-2">

                        {{-- =====================================================
                             DASHBOARD
                        ====================================================== --}}

                        <li class="dropdown-item">
                            <a href="{{ url('/admin/revenue/dashboard') }}"
                               class="dropdown-link">

                                <i class="ri-dashboard-line me-1"></i>
                                Dashboard

                            </a>
                        </li>


                        {{-- =====================================================
                             BILLING
                        ====================================================== --}}

                        <li class="dropdown-item has-dropdown">

                            <a href="#"
                               class="dropdown-link">

                                <span>
                                    <i class="ri-file-list-3-line me-1"></i>
                                    Billing
                                </span>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>

                            <ul class="dropdown-menu level-3">

                                {{-- Rent Schedules --}}

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/revenue/rent-schedules') }}"
                                       class="dropdown-link">

                                        Rent Schedules

                                    </a>

                                </li>


                                {{-- Invoices --}}

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/revenue/invoices') }}"
                                       class="dropdown-link">

                                        Invoices

                                    </a>

                                </li>

                            </ul>

                        </li>


                        {{-- =====================================================
                             COLLECTIONS
                        ====================================================== --}}

                        <li class="dropdown-item has-dropdown">

                            <a href="#"
                               class="dropdown-link">

                                <span>
                                    <i class="ri-bank-card-line me-1"></i>
                                    Collections
                                </span>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>

                            <ul class="dropdown-menu level-3">

                                {{-- Payments --}}

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/revenue/payments') }}"
                                       class="dropdown-link">

                                        Payments

                                    </a>

                                </li>


                                {{-- Reconciliation --}}

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/revenue/reconciliation') }}"
                                       class="dropdown-link">

                                        Reconciliation

                                    </a>

                                </li>

                            </ul>

                        </li>


                        {{-- =====================================================
                             OUTSTANDING
                        ====================================================== --}}

                        <li class="dropdown-item has-dropdown">

                            <a href="#"
                               class="dropdown-link">

                                <span>
                                    <i class="ri-error-warning-line me-1"></i>
                                    Outstanding
                                </span>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>

                            <ul class="dropdown-menu level-3">

                                {{-- Outstanding --}}

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/revenue/outstanding') }}"
                                       class="dropdown-link">

                                        Outstanding

                                    </a>

                                </li>


                                {{-- Overdue --}}

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/revenue/outstanding/overdue') }}"
                                       class="dropdown-link">

                                        Overdue

                                    </a>

                                </li>


                                {{-- Tenant Outstanding --}}

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/revenue/outstanding/tenants') }}"
                                       class="dropdown-link">

                                        Tenant Outstanding

                                    </a>

                                </li>

                            </ul>

                        </li>


                        {{-- =====================================================
                             REPORTS
                        ====================================================== --}}

                        <li class="dropdown-item has-dropdown">

                            <a href="#"
                               class="dropdown-link">

                                <span>
                                    <i class="ri-bar-chart-line me-1"></i>
                                    Reports
                                </span>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>

                            <ul class="dropdown-menu level-3">

                                {{-- Revenue Report --}}

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/revenue/reports/revenue') }}"
                                       class="dropdown-link">

                                        Revenue Report

                                    </a>

                                </li>


                                {{-- Collection Report --}}

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/revenue/reports/collections') }}"
                                       class="dropdown-link">

                                        Collection Report

                                    </a>

                                </li>


                                {{-- Charge-wise Revenue --}}

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/revenue/reports/charge-wise') }}"
                                       class="dropdown-link">

                                        Charge-wise Revenue

                                    </a>

                                </li>


                                {{-- Tenant-wise Revenue --}}

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/revenue/reports/tenant-wise') }}"
                                       class="dropdown-link">

                                        Tenant-wise Revenue

                                    </a>

                                </li>


                                {{-- Aging Report --}}

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/revenue/reports/aging') }}"
                                       class="dropdown-link">

                                        Aging Report

                                    </a>

                                </li>

                            </ul>

                        </li>


                        {{-- =====================================================
                             SETTINGS
                        ====================================================== --}}

                        <li class="dropdown-item has-dropdown">

                            <a href="#"
                               class="dropdown-link">

                                <span>
                                    <i class="ri-settings-3-line me-1"></i>
                                    Settings
                                </span>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>

                            <ul class="dropdown-menu level-3">

                                {{-- Charge Types --}}

                                <li class="dropdown-item">

                                    <a href="{{ url('/admin/revenue/settings/charge-types') }}"
                                       class="dropdown-link">

                                        Charge Types

                                    </a>

                                </li>

                            </ul>

                        </li>

                    </ul>

                </li>


                {{-- =====================================================
                    MAINTENANCE
                ====================================================== --}}
                <!-- <li class="app-nav-item has-dropdown">

                    <a href="#"
                       class="app-nav-link">
                        Maintenance
                        <i class="ri-arrow-down-s-line"></i>
                    </a>

                    <ul class="dropdown-menu level-2">

                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link">
                                Maintenance Dashboard
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link">
                                Work Orders
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link">
                                Service Requests
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link">
                                Preventive Maintenance
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link">
                                Maintenance Reports
                            </a>
                        </li>

                    </ul>
                </li> -->

                <li class="app-nav-item has-dropdown">

                    <a href="#"
                       class="app-nav-link">

                        Fit-Out

                        <i class="ri-arrow-down-s-line"></i>

                    </a>


                    <ul class="dropdown-menu level-2">


                        {{-- =====================================================
                             DASHBOARD
                        ====================================================== --}}

                        <li class="dropdown-item">

                            <a
                                href="{{ route('admin.fitout.dashboard') }}"
                                class="dropdown-link"
                            >

                                <span>
                                    <i class="ri-dashboard-line me-2"></i>
                                    Fit-Out Dashboard
                                </span>

                            </a>

                        </li>


                        {{-- =====================================================
                             FIT-OUT MANAGEMENT
                        ====================================================== --}}

                        <li class="dropdown-item has-dropdown">

                            <a
                                href="#"
                                class="dropdown-link"
                            >

                                <span>

                                    <i class="ri-file-list-3-line me-2"></i>

                                    Fit-Out Management

                                </span>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>


                            <ul class="dropdown-menu level-3">


                                {{-- REQUESTS --}}

                                <li class="dropdown-item">

                                    <a
                                        href="{{ route(
                                            'admin.fitout.requests.index'
                                        ) }}"
                                        class="dropdown-link"
                                    >

                                        Fit-Out Requests

                                    </a>

                                </li>


                                {{-- APPROVALS --}}

                                <li class="dropdown-item has-dropdown">

                                    <a
                                        href="#"
                                        class="dropdown-link"
                                    >

                                        <span>
                                            Approvals
                                        </span>

                                        <i class="ri-arrow-right-s-line"></i>

                                    </a>


                                    <ul class="dropdown-menu level-4">

                                        <li class="dropdown-item">

                                            <a
                                                href="{{ route(
                                                    'admin.fitout.approvals.index'
                                                ) }}"
                                                class="dropdown-link"
                                            >

                                                All Approvals

                                            </a>

                                        </li>


                                        <li class="dropdown-item">

                                            <a
                                                href="{{ route(
                                                    'admin.fitout.approvals.pending'
                                                ) }}"
                                                class="dropdown-link"
                                            >

                                                Pending Approvals

                                            </a>

                                        </li>

                                    </ul>

                                </li>


                                {{-- STAGES --}}

                                <li class="dropdown-item">

                                    <a
                                        href="{{ route(
                                            'admin.fitout.requests.index'
                                        ) }}"
                                        class="dropdown-link"
                                    >

                                        Fit-Out Stages

                                    </a>

                                </li>

                            </ul>

                        </li>


                        {{-- =====================================================
                             CONTRACTORS
                        ====================================================== --}}

                        <li class="dropdown-item">

                            <a
                                href="{{ route(
                                    'admin.fitout.contractors.index'
                                ) }}"
                                class="dropdown-link"
                            >

                                <span>

                                    <i class="ri-team-line me-2"></i>

                                    Contractors

                                </span>

                            </a>

                        </li>


                        {{-- =====================================================
                             QUALITY & INSPECTION
                        ====================================================== --}}

                        <li class="dropdown-item has-dropdown">

                            <a
                                href="#"
                                class="dropdown-link"
                            >

                                <span>

                                    <i class="ri-search-eye-line me-2"></i>

                                    Quality & Inspection

                                </span>

                                <i class="ri-arrow-right-s-line"></i>

                            </a>


                            <ul class="dropdown-menu level-3">


                                {{-- INSPECTIONS --}}

                                <li class="dropdown-item">

                                    <a
                                        href="{{ route(
                                            'admin.fitout.inspections.index'
                                        ) }}"
                                        class="dropdown-link"
                                    >

                                        Inspections

                                    </a>

                                </li>


                                {{-- SNAGS --}}

                                <li class="dropdown-item">

                                    <a
                                        href="{{ route(
                                            'admin.fitout.snags.index'
                                        ) }}"
                                        class="dropdown-link"
                                    >

                                        Snags

                                    </a>

                                </li>

                            </ul>

                        </li>


                        {{-- =====================================================
                             DOCUMENTS
                        ====================================================== --}}

                        <li class="dropdown-item">

                            <a
                                href="{{ route(
                                    'admin.fitout.documents.index'
                                ) }}"
                                class="dropdown-link"
                            >

                                <span>

                                    <i class="ri-folder-line me-2"></i>

                                    Fit-Out Documents

                                </span>

                            </a>

                        </li>


                        {{-- =====================================================
                             HANDOVER
                        ====================================================== --}}

                        <li class="dropdown-item">

                            <a
                                href="{{ route(
                                    'admin.fitout.handovers.index'
                                ) }}"
                                class="dropdown-link"
                            >

                                <span>

                                    <i class="ri-key-2-line me-2"></i>

                                    Handovers

                                </span>

                            </a>

                        </li>


                    </ul>

                </li>


                {{-- =========================================================
                    MAINTENANCE
                ========================================================== --}}
         <li class="app-nav-item has-dropdown">

    <a href="#"
       class="app-nav-link">
        <i class="ri-tools-line"></i>
        Maintenance
        <i class="ri-arrow-down-s-line"></i>
    </a>

    <ul class="dropdown-menu level-2">

        {{-- Maintenance Dashboard --}}
        @can('maintenance_history.view')
            <li class="dropdown-item">
                <a href="{{ route('admin.maintenance-history.index') }}"
                   class="dropdown-link">
                    <i class="ri-dashboard-line"></i>
                    Maintenance Dashboard
                </a>
            </li>
        @endcan
      {{-- maintenance requests --}}
        @can('maintenance_requests.view')
            <li class="dropdown-item">
                <a href="{{ route('admin.maintenance-requests.index') }}"
                   class="dropdown-link">
                    <i class="ri-file-list-3-line"></i>
                    Maintenance requests
                </a>
            </li>
        @endcan
         {{-- maintenance performance --}}
        @can('preventive_maintenance.view')
            <li class="dropdown-item">
                <a href="{{ route('admin.preventive-maintenance.index') }}"
                   class="dropdown-link">
                    <i class="ri-file-list-3-line"></i>
                   Preventive maintenance
                </a>
            </li>
        @endcan

        {{-- Work Orders --}}
        @can('work_orders.view')
            <li class="dropdown-item">
                <a href="{{ route('admin.maintenance.work-orders.index') }}"
                   class="dropdown-link">
                    <i class="ri-file-list-3-line"></i>
                    Work Orders
                </a>
            </li>
        @endcan


        {{-- Service Requests --}}
        @can('service_requests.view')
            <li class="dropdown-item">
                <a href="{{ route('admin.maintenance.service-requests.index') }}"
                   class="dropdown-link">
                    <i class="ri-customer-service-2-line"></i>
                    Service Requests
                </a>
            </li>
        @endcan


        {{-- Preventive Maintenance --}}
        @can('preventive_maintenance.view')
            <li class="dropdown-item">
                <a href="{{ route('admin.preventive-maintenance.index') }}"
                   class="dropdown-link">
                    <i class="ri-calendar-check-line"></i>
                    Preventive Maintenance
                </a>
            </li>
        @endcan


        {{-- Maintenance Reports --}}
        @can('maintenance_reports.view')
            <li class="dropdown-item">
                <a href="{{ route('admin.maintenance.reports.index') }}"
                   class="dropdown-link">
                    <i class="ri-bar-chart-line"></i>
                    Maintenance Reports
                </a>
            </li>
        @endcan

    </ul>

</li>


                {{-- =========================================================
                    PERFORMANCE
                ========================================================== --}}
                <li class="app-nav-item has-dropdown">

                    <a href="#"
                       class="app-nav-link">
                        <i class="ri-line-chart-line"></i>
                        Performance
                        <i class="ri-arrow-down-s-line"></i>
                    </a>

                    <ul class="dropdown-menu level-2">

                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link">
                                <i class="ri-dashboard-line"></i>
                                Performance Dashboard
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link">
                                <i class="ri-target-line"></i>
                                KPI
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link">
                                <i class="ri-building-4-line"></i>
                                Occupancy Performance
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link">
                                <i class="ri-money-dollar-box-line"></i>
                                Revenue Performance
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link">
                                <i class="ri-file-chart-line"></i>
                                Reports
                            </a>
                        </li>

                    </ul>

                </li>


                {{-- =========================================================
                    ADMINISTRATION
                ========================================================== --}}
                @if(
                    auth()->user()->can('users.view') ||
                    auth()->user()->can('roles.view') ||
                    auth()->user()->can('audit.view')
                )

                    <li class="app-nav-item has-dropdown">

                        <a href="#"
                           class="app-nav-link {{ request()->routeIs('admin.users.*', 'admin.roles.*') ? 'active' : '' }}">

                            <i class="ri-admin-line"></i>
                            Administration
                            <i class="ri-arrow-down-s-line"></i>

                        </a>

                        <ul class="dropdown-menu level-2">

                            @can('users.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.users.index') }}"
                                       class="dropdown-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                        <i class="ri-user-settings-line"></i>
                                        Manage Users
                                    </a>
                                </li>
                            @endcan

                            @can('roles.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.roles.index') }}"
                                       class="dropdown-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                                        <i class="ri-shield-user-line"></i>
                                        Roles & Permissions
                                    </a>
                                </li>
                            @endcan

                            @can('audit.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.users.audits', auth()->id()) }}"
                                       class="dropdown-link">
                                        <i class="ri-history-line"></i>
                                        Audit Trail
                                    </a>
                                </li>
                            @endcan

                        </ul>

                    </li>

                @endif


                {{-- =========================================================
                    PROFILE
                ========================================================== --}}
                <li class="app-nav-item has-dropdown">

                        <a href="#"
                           class="app-nav-link {{ request()->routeIs('admin.users.*', 'admin.roles.*') ? 'active' : '' }}">
                             <i class="ri-user-line"></i>

                        </a>

                        <ul class="dropdown-menu level-2">

                          <li  class="dropdown-item">>

                                <a href="{{ route('profile.show') }}"
                                class="dropdown-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">

                                    <i class="ri-user-line"></i>
                                    Profile

                                </a>

                            </li>


                            {{-- =========================================================
                                LOGOUT
                            ========================================================== --}}
                            <li class="dropdown-item">

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf

                                    <button type="submit"
                                            class="dropdown-link"
                                            style="border:0;background:none;cursor:pointer;">

                                        <i class="ri-logout-box-r-line"></i>
                                        Logout

                                    </button>
                                </form>

                            </li>


                        @else

                            {{-- =========================================================
                                GUEST
                            ========================================================== --}}

                            <li class="dropdown-item">
                                <a href="{{ route('login.form') }}"
                                class="dropdown-link {{ request()->routeIs('login.form') ? 'active' : '' }}">
                                    <i class="ri-login-box-line"></i>
                                    Login
                                </a>
                            </li>

                            <li class="dropdown-item">
                                <a href="{{ route('register.form') }}"
                                class="dropdown-link {{ request()->routeIs('register.form') ? 'active' : '' }}">
                                    <i class="ri-user-add-line"></i>
                                    Register
                                </a>
                            </li>

                        @endauth

                        </ul>

                    </li>
                

        </ul>
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