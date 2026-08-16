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
            <strong>{{ auth()->user()->name }}</strong>
            ({{ auth()->user()->getRoleNames()->implode(', ') }})
        </span>
    <span class="app-date-tag" id="datechip"></span>
  </div>	
	
	</div>
</header>

<nav class="app-navigation">
    <div class="container">
        <ul class="app-nav-wrapper">

            @auth

                {{-- =====================================================
                    DASHBOARD / OVERVIEW
                ====================================================== --}}
                @can('dashboard.view')
                    <li class="app-nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="app-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            Overview
                        </a>
                    </li>
                @endcan


                {{-- =====================================================
                    ASSET OPERATIONS
                ====================================================== --}}
                @if(
                    auth()->user()->can('malls.view') ||
                    auth()->user()->can('buildings.view') ||
                    auth()->user()->can('floors.view') ||
                    auth()->user()->can('zones.view') ||
                    auth()->user()->can('unit_types.view') ||
                    auth()->user()->can('units.view')
                )

                    <li class="app-nav-item has-dropdown">

                        <a href="#"
                           class="app-nav-link {{ request()->routeIs('admin.assets.*') ? 'active' : '' }}">
                            Asset 
                            <i class="ri-arrow-down-s-line"></i>
                        </a>

                        <ul class="dropdown-menu level-2">

                            {{-- Malls --}}
                            @can('malls.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.assets.malls.index') }}"
                                       class="dropdown-link {{ request()->routeIs('admin.assets.malls.*') ? 'active' : '' }}">
                                        Malls
                                    </a>
                                </li>
                            @endcan


                            {{-- Buildings --}}
                            @can('buildings.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.assets.buildings.index') }}"
                                       class="dropdown-link {{ request()->routeIs('admin.assets.buildings.*') ? 'active' : '' }}">
                                        Buildings
                                    </a>
                                </li>
                            @endcan


                            {{-- Floors --}}
                            @can('floors.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.assets.floors.index') }}"
                                       class="dropdown-link {{ request()->routeIs('admin.assets.floors.*') ? 'active' : '' }}">
                                        Floors
                                    </a>
                                </li>
                            @endcan


                            {{-- Zones --}}
                            @can('zones.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.assets.zones.index') }}"
                                       class="dropdown-link {{ request()->routeIs('admin.assets.zones.*') ? 'active' : '' }}">
                                        Zones
                                    </a>
                                </li>
                            @endcan


                            {{-- Unit Types --}}
                            @can('unit_types.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.assets.unit-types.index') }}"
                                       class="dropdown-link {{ request()->routeIs('admin.assets.unit-types.*') ? 'active' : '' }}">
                                        Unit Types
                                    </a>
                                </li>
                            @endcan


                            {{-- Units + Floor Submenu --}}
                            @can('units.view')

                                <li class="dropdown-item has-dropdown">

                                    <a href="{{ route('admin.assets.units.index') }}"
                                       class="dropdown-link {{ request()->routeIs('admin.assets.units.*') ? 'active' : '' }}">
                                        Units
                                        <i class="ri-arrow-right-s-line"></i>
                                    </a>

                                    <ul class="dropdown-menu level-3">

                                        @can('floors.view')

                                            <li class="dropdown-item">
                                                <a href="{{ route('admin.assets.floors.index') }}"
                                                   class="dropdown-link">
                                                    All Floors
                                                </a>
                                            </li>

                                        @endcan

                                    </ul>

                                </li>

                            @endcan

                        </ul>
                    </li>

                @endif


                {{-- =====================================================
                    LEASING
                ====================================================== --}}
                <!-- <li class="app-nav-item has-dropdown">

                    <a href="{{ route('admin.leasing.dashboard') }}"
                       class="app-nav-link {{ request()->routeIs('admin.leasing.*') ? 'active' : '' }}">
                        Leasing
                        <i class="ri-arrow-down-s-line"></i>
                    </a>

                    <ul class="dropdown-menu level-2">

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.dashboard') }}"
                               class="dropdown-link">
                                Leasing Dashboard
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.proposals.index') }}"
                               class="dropdown-link">
                                Lease Proposals
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.agreements.index') }}"
                               class="dropdown-link">
                                Lease Agreements
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.terms.index') }}"
                               class="dropdown-link">
                                Lease Terms
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.documents.index') }}"
                               class="dropdown-link">
                                Lease Documents
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.renewals.index') }}"
                               class="dropdown-link">
                                Renewals
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.escalations.index') }}"
                               class="dropdown-link">
                                Escalations
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.history.index') }}"
                               class="dropdown-link">
                                Lease History
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.terminations.index') }}"
                               class="dropdown-link">
                                Terminations
                            </a>
                        </li>

                    </ul>
                </li> -->

                <li class="app-nav-item has-dropdown">

                    <a href="#"
                       class="app-nav-link">

                        Leasing

                        <i class="ri-arrow-down-s-line"></i>

                    </a>


                    <ul class="dropdown-menu level-2">


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


                    </ul>

                </li>


                {{-- =====================================================
                    TENANTS
                ====================================================== --}}
                <li class="app-nav-item has-dropdown">

                    <a href="#" class="app-nav-link">
                        Tenants
                        <i class="ri-arrow-down-s-line"></i>
                    </a>

                    <ul class="dropdown-menu level-2">

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


                {{-- =====================================================
                    PERFORMANCE MANAGEMENT
                ====================================================== --}}
                <li class="app-nav-item has-dropdown">

                    <a href="#"
                       class="app-nav-link">
                        Performance Management
                        <i class="ri-arrow-down-s-line"></i>
                    </a>

                    <ul class="dropdown-menu level-2">

                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link">
                                Performance Dashboard
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link">
                                KPI
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link">
                                Occupancy Performance
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link">
                                Revenue Performance
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link">
                                Reports
                            </a>
                        </li>

                    </ul>
                </li>


                {{-- =====================================================
                    ADMINISTRATION
                ====================================================== --}}
                @if(
                    auth()->user()->can('users.view') ||
                    auth()->user()->can('roles.view') ||
                    auth()->user()->can('audit.view')
                )

                    <li class="app-nav-item has-dropdown">

                        <a href="#"
                           class="app-nav-link {{ request()->routeIs('admin.users.*', 'admin.roles.*') ? 'active' : '' }}">
                            Administration
                            <i class="ri-arrow-down-s-line"></i>
                        </a>

                        <ul class="dropdown-menu level-2">

                            @can('users.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.users.index') }}"
                                       class="dropdown-link">
                                        Manage Users
                                    </a>
                                </li>
                            @endcan

                            @can('roles.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.roles.index') }}"
                                       class="dropdown-link">
                                        Roles &amp; Permissions
                                    </a>
                                </li>
                            @endcan

                            @can('audit.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.users.audits', auth()->id()) }}"
                                       class="dropdown-link">
                                        Audit Trail
                                    </a>
                                </li>
                            @endcan

                        </ul>

                    </li>

                @endif


                {{-- =====================================================
                    PROFILE
                ====================================================== --}}
                <li class="app-nav-item">

                    <a href="{{ route('profile.show') }}"
                       class="app-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        Profile
                    </a>

                </li>


                {{-- =====================================================
                    LOGOUT
                ====================================================== --}}
                <li class="app-nav-item">

                    <form action="{{ route('logout') }}"
                          method="POST">

                        @csrf

                        <button type="submit"
                                class="app-nav-link"
                                style="border:0;background:none;cursor:pointer;">
                            Logout
                        </button>

                    </form>

                </li>


            @else

                {{-- =====================================================
                    GUEST
                ====================================================== --}}

                <li class="app-nav-item">
                    <a href="{{ route('login.form') }}"
                       class="app-nav-link {{ request()->routeIs('login.form') ? 'active' : '' }}">
                        Login
                    </a>
                </li>

                <li class="app-nav-item">
                    <a href="{{ route('register.form') }}"
                       class="app-nav-link {{ request()->routeIs('register.form') ? 'active' : '' }}">
                        Register
                    </a>
                </li>

            @endauth

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