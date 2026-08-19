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
                Welcome, <strong>{{ auth()->user()->name ?? 'Guest' }}</strong>
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
                ========================================================== --}}
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
                    auth()->user()->can('asset_categories.view') ||
                    auth()->user()->can('assets.view')
                )
                    <li class="app-nav-item has-dropdown">
                        <a href="#" class="app-nav-link {{ request()->routeIs('admin.assets.*') ? 'active' : '' }}">
                            <i class="ri-building-2-line"></i>
                            Assets
                            <i class="ri-arrow-down-s-line"></i>
                        </a>

                        <ul class="dropdown-menu level-2">

                            {{-- PROPERTY STRUCTURE --}}
                            @if(
                                auth()->user()->can('malls.view') ||
                                auth()->user()->can('buildings.view') ||
                                auth()->user()->can('floors.view') ||
                                auth()->user()->can('zones.view')
                            )
                                <li class="dropdown-item has-dropdown">
                                    <a href="#" class="dropdown-link">
                                        <i class="ri-building-line"></i>
                                        Property Structure
                                        <i class="ri-arrow-right-s-line"></i>
                                    </a>
                                    <ul class="dropdown-menu level-3">
                                        @can('malls.view')
                                            <li class="dropdown-item">
                                                <a href="{{ route('admin.assets.malls.index') }}"
                                                   class="dropdown-link {{ request()->routeIs('admin.assets.malls.*') ? 'active' : '' }}">
                                                    <i class="ri-store-2-line"></i> Malls
                                                </a>
                                            </li>
                                        @endcan
                                        @can('buildings.view')
                                            <li class="dropdown-item">
                                                <a href="{{ route('admin.assets.buildings.index') }}"
                                                   class="dropdown-link {{ request()->routeIs('admin.assets.buildings.*') ? 'active' : '' }}">
                                                    <i class="ri-building-line"></i> Buildings
                                                </a>
                                            </li>
                                        @endcan
                                        @can('floors.view')
                                            <li class="dropdown-item">
                                                <a href="{{ route('admin.assets.floors.index') }}"
                                                   class="dropdown-link {{ request()->routeIs('admin.assets.floors.*') ? 'active' : '' }}">
                                                    <i class="ri-layout-4-line"></i> Floors
                                                </a>
                                            </li>
                                        @endcan
                                        @can('zones.view')
                                            <li class="dropdown-item">
                                                <a href="{{ route('admin.assets.zones.index') }}"
                                                   class="dropdown-link {{ request()->routeIs('admin.assets.zones.*') ? 'active' : '' }}">
                                                    <i class="ri-map-pin-line"></i> Zones
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endif

                            {{-- UNITS & DOCUMENTS --}}
                            @if(
                                auth()->user()->can('unit_types.view') ||
                                auth()->user()->can('units.view') ||
                                auth()->user()->can('unit_statuses.view') ||
                                auth()->user()->can('unit_documents.view')
                            )
                                <li class="dropdown-item has-dropdown">
                                    <a href="#" class="dropdown-link">
                                        <i class="ri-home-office-line"></i>
                                        Units & Tenants
                                        <i class="ri-arrow-right-s-line"></i>
                                    </a>
                                    <ul class="dropdown-menu level-3">
                                        @can('unit_types.view')
                                            <li class="dropdown-item">
                                                <a href="{{ route('admin.assets.unit_types.index') }}"
                                                   class="dropdown-link {{ request()->routeIs('admin.assets.unit_types.*') ? 'active' : '' }}">
                                                    <i class="ri-grid-line"></i> Unit Types
                                                </a>
                                            </li>
                                        @endcan
                                        @can('units.view')
                                            <li class="dropdown-item">
                                                <a href="{{ route('admin.assets.units.index') }}"
                                                   class="dropdown-link {{ request()->routeIs('admin.assets.units.*') ? 'active' : '' }}">
                                                    <i class="ri-home-office-line"></i> All Units
                                                </a>
                                            </li>
                                        @endcan
                                        @can('unit_statuses.view')
                                            <li class="dropdown-item">
                                                <a href="{{ route('admin.assets.unit-statuses.index') }}"
                                                   class="dropdown-link {{ request()->routeIs('admin.assets.unit-statuses.*') ? 'active' : '' }}">
                                                    <i class="ri-checkbox-circle-line"></i> Unit Statuses
                                                </a>
                                            </li>
                                        @endcan
                                        @can('unit_documents.view')
                                            <li class="dropdown-item">
                                                <a href="{{ route('admin.assets.unit-documents.index') }}"
                                                   class="dropdown-link {{ request()->routeIs('admin.assets.unit-documents.*') ? 'active' : '' }}">
                                                    <i class="ri-file-text-line"></i> Unit Documents
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endif

                            {{-- ORGANIZATION --}}
                            @can('departments.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.assets.departments.index') }}"
                                       class="dropdown-link {{ request()->routeIs('admin.assets.departments.*') ? 'active' : '' }}">
                                        <i class="ri-organization-chart"></i> Departments
                                    </a>
                                </li>
                            @endcan

                            {{-- ASSET MANAGEMENT --}}
                            @if(
                                auth()->user()->can('asset_categories.view') ||
                                auth()->user()->can('assets.view')
                            )
                                <li class="dropdown-item has-dropdown">
                                    <a href="#" class="dropdown-link">
                                        <i class="ri-tools-line"></i>
                                        Asset Management
                                        <i class="ri-arrow-right-s-line"></i>
                                    </a>
                                    <ul class="dropdown-menu level-3">
                                        @can('asset_categories.view')
                                            <li class="dropdown-item">
                                                <a href="{{ route('admin.assets.asset-categories.index') }}"
                                                   class="dropdown-link {{ request()->routeIs('admin.assets.asset-categories.*') ? 'active' : '' }}">
                                                    <i class="ri-price-tag-3-line"></i> Asset Categories
                                                </a>
                                            </li>
                                        @endcan
                                        @can('assets.view')
                                            <li class="dropdown-item">
                                                <a href="{{ route('admin.assets.assets.index') }}"
                                                   class="dropdown-link {{ request()->routeIs('admin.assets.assets.*') ? 'active' : '' }}">
                                                    <i class="ri-tools-line"></i> Assets
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
                    TENANTS
                ========================================================== --}}
                <li class="app-nav-item has-dropdown">
                    <a href="#" class="app-nav-link {{ request()->routeIs('admin.tenants.*') ? 'active' : '' }}">
                        <i class="ri-user-3-line"></i>
                        Tenants
                        <i class="ri-arrow-down-s-line"></i>
                    </a>

                    <ul class="dropdown-menu level-2">

                        <li class="dropdown-item">
                            <a href="{{ url('/admin/tenants/dashboard') }}" class="dropdown-link">
                                <i class="ri-dashboard-line"></i> Dashboard
                            </a>
                        </li>

                        <li class="dropdown-item has-dropdown">
                            <a href="#" class="dropdown-link">
                                <i class="ri-group-line"></i> Tenant Management
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="dropdown-menu level-3">
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/tenants') }}" class="dropdown-link">All Tenants</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/tenants?status=Active') }}" class="dropdown-link">Active Tenants</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/tenants?status=Inactive') }}" class="dropdown-link">Inactive Tenants</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-item has-dropdown">
                            <a href="#" class="dropdown-link">
                                <i class="ri-building-line"></i> Units & Leases
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="dropdown-menu level-3">
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/tenants/leases') }}" class="dropdown-link">Tenant Leases</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/tenants/leases/expiry') }}" class="dropdown-link">Lease Expiry</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-item has-dropdown">
                            <a href="#" class="dropdown-link">
                                <i class="ri-money-rupee-circle-line"></i> Revenue
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="dropdown-menu level-3">
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/revenue/outstanding/tenants') }}" class="dropdown-link">Tenant Revenue</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/revenue/outstanding/tenants') }}" class="dropdown-link">Tenant Outstanding</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-item has-dropdown">
                            <a href="#" class="dropdown-link">
                                <i class="ri-file-text-line"></i> Documents
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="dropdown-menu level-3">
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/tenants/documents') }}" class="dropdown-link">Tenant Documents</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-item has-dropdown">
                            <a href="#" class="dropdown-link">
                                <i class="ri-contacts-line"></i> Contacts
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="dropdown-menu level-3">
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/tenants/contacts') }}" class="dropdown-link">Tenant Contacts</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/tenants/emergency-contacts') }}" class="dropdown-link">Emergency Contacts</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-item has-dropdown">
                            <a href="#" class="dropdown-link">
                                <i class="ri-settings-3-line"></i> Settings
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="dropdown-menu level-3">
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/tenants/settings/business-categories') }}" class="dropdown-link">Business Categories</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li>
                 {{-- =========================================================
                    LEASING
                ========================================================== --}}
                <li class="app-nav-item has-dropdown">
                    <a href="#" class="app-nav-link {{ request()->routeIs('admin.leasing.*') ? 'active' : '' }}">
                        <i class="ri-file-text-line"></i>
                        Leasing
                        <i class="ri-arrow-down-s-line"></i>
                    </a>

                    <ul class="dropdown-menu level-2">

                        <li class="dropdown-item">
                            <a href="{{ route('admin.leasing.dashboard') }}"
                               class="dropdown-link {{ request()->routeIs('admin.leasing.dashboard') ? 'active' : '' }}">
                                <i class="ri-dashboard-line"></i> Leasing Dashboard
                            </a>
                        </li>

                        <li class="dropdown-item has-dropdown">
                            <a href="#" class="dropdown-link">
                                <i class="ri-file-list-3-line"></i> Lease Management
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="dropdown-menu level-3">
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.leasing.index') }}" class="dropdown-link">All Leasing</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.leasing.proposals.index') }}" class="dropdown-link">Lease Proposals</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.leasing.agreements.index') }}" class="dropdown-link">Lease Agreements</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-item has-dropdown">
                            <a href="#" class="dropdown-link">
                                <i class="ri-file-info-line"></i> Lease Details
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="dropdown-menu level-3">
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.leasing.terms.index') }}" class="dropdown-link">Lease Terms</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.leasing.documents.index') }}" class="dropdown-link">Lease Documents</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-item has-dropdown">
                            <a href="#" class="dropdown-link">
                                <i class="ri-line-chart-line"></i> Lease Changes
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="dropdown-menu level-3">
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.leasing.escalations.index') }}" class="dropdown-link">Rent Escalations</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.leasing.renewals.index') }}" class="dropdown-link">Lease Renewals</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-item has-dropdown">
                            <a href="#" class="dropdown-link">
                                <i class="ri-logout-box-line"></i> Exit Management
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="dropdown-menu level-3">
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.leasing.terminations.index') }}" class="dropdown-link">Lease Terminations</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.leasing.history.index') }}" class="dropdown-link">Lease History</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li>

                {{-- =========================================================
                    REVENUE
                ========================================================== --}}
                <li class="app-nav-item has-dropdown">
                    <a href="#" class="app-nav-link {{ request()->routeIs('admin.revenue.*') ? 'active' : '' }}">
                        <i class="ri-money-dollar-circle-line"></i>
                        Revenue
                        <i class="ri-arrow-down-s-line"></i>
                    </a>

                    <ul class="dropdown-menu level-2">

                        <li class="dropdown-item">
                            <a href="{{ url('/admin/revenue/dashboard') }}" class="dropdown-link">
                                <i class="ri-dashboard-line"></i> Dashboard
                            </a>
                        </li>

                        <li class="dropdown-item has-dropdown">
                            <a href="#" class="dropdown-link">
                                <i class="ri-file-list-3-line"></i> Billing
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="dropdown-menu level-3">
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/revenue/rent-schedules') }}" class="dropdown-link">Rent Schedules</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/revenue/invoices') }}" class="dropdown-link">Invoices</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-item has-dropdown">
                            <a href="#" class="dropdown-link">
                                <i class="ri-bank-card-line"></i> Collections
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="dropdown-menu level-3">
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/revenue/payments') }}" class="dropdown-link">Payments</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/revenue/reconciliation') }}" class="dropdown-link">Reconciliation</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-item has-dropdown">
                            <a href="#" class="dropdown-link">
                                <i class="ri-error-warning-line"></i> Outstanding
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="dropdown-menu level-3">
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/revenue/outstanding') }}" class="dropdown-link">Outstanding</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/revenue/outstanding/overdue') }}" class="dropdown-link">Overdue</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/revenue/outstanding/tenants') }}" class="dropdown-link">Tenant Outstanding</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-item has-dropdown">
                            <a href="#" class="dropdown-link">
                                <i class="ri-bar-chart-line"></i> Reports
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="dropdown-menu level-3">
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/revenue/reports/revenue') }}" class="dropdown-link">Revenue Report</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/revenue/reports/collections') }}" class="dropdown-link">Collection Report</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/revenue/reports/charge-wise') }}" class="dropdown-link">Charge-wise Revenue</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/revenue/reports/tenant-wise') }}" class="dropdown-link">Tenant-wise Revenue</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/revenue/reports/aging') }}" class="dropdown-link">Aging Report</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-item has-dropdown">
                            <a href="#" class="dropdown-link">
                                <i class="ri-settings-3-line"></i> Settings
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="dropdown-menu level-3">
                                <li class="dropdown-item">
                                    <a href="{{ url('/admin/revenue/settings/charge-types') }}" class="dropdown-link">Charge Types</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li>

                {{-- =========================================================
                    FIT-OUT
                ========================================================== --}}
                <li class="app-nav-item has-dropdown">
                    <a href="#" class="app-nav-link {{ request()->routeIs('admin.fitout.*') ? 'active' : '' }}">
                       <i class="ri-dashboard-line"></i> Fit-Out
                        <i class="ri-arrow-down-s-line"></i>
                    </a>

                    <ul class="dropdown-menu level-2">

                        <li class="dropdown-item">
                            <a href="{{ route('admin.fitout.dashboard') }}" class="dropdown-link">
                                <i class="ri-dashboard-line"></i> Fit-Out Dashboard
                            </a>
                        </li>

                        <li class="dropdown-item has-dropdown">
                            <a href="#" class="dropdown-link">
                                <i class="ri-file-list-3-line"></i> Fit-Out Management
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="dropdown-menu level-3">
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.fitout.requests.index') }}" class="dropdown-link">Fit-Out Requests</a>
                                </li>
                                <li class="dropdown-item has-dropdown">
                                    <a href="#" class="dropdown-link">
                                        Approvals
                                        <i class="ri-arrow-right-s-line"></i>
                                    </a>
                                    <ul class="dropdown-menu level-4">
                                        <li class="dropdown-item">
                                            <a href="{{ route('admin.fitout.approvals.index') }}" class="dropdown-link">All Approvals</a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a href="{{ route('admin.fitout.approvals.pending') }}" class="dropdown-link">Pending Approvals</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.fitout.stages.show', ['id' => 0]) }}" class="dropdown-link">Fit-Out Stages</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.fitout.contractors.index') }}" class="dropdown-link">
                                <i class="ri-team-line"></i> Contractors
                            </a>
                        </li>

                        <li class="dropdown-item has-dropdown">
                            <a href="#" class="dropdown-link">
                                <i class="ri-search-eye-line"></i> Quality & Inspection
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="dropdown-menu level-3">
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.fitout.inspections.index') }}" class="dropdown-link">Inspections</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.fitout.snags.index') }}" class="dropdown-link">Snags</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.fitout.documents.index') }}" class="dropdown-link">
                                <i class="ri-folder-line"></i> Fit-Out Documents
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <a href="{{ route('admin.fitout.handovers.index') }}" class="dropdown-link">
                                <i class="ri-key-2-line"></i> Handovers
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- {{-- =========================================================
                    MAINTENANCE
                ========================================================== --}}
                @if(
                    auth()->user()->can('maintenance_history.view') ||
                    auth()->user()->can('maintenance_requests.view') ||
                    auth()->user()->can('work_orders.view') ||
                    auth()->user()->can('service_requests.view') ||
                    auth()->user()->can('preventive_maintenance.view') ||
                    auth()->user()->can('maintenance_reports.view')
                )
                    <li class="app-nav-item has-dropdown">
                        <a href="#" class="app-nav-link">
                            <i class="ri-tools-line"></i>
                            Maintenance
                            <i class="ri-arrow-down-s-line"></i>
                        </a>

                        <ul class="dropdown-menu level-2">

                            @can('maintenance_history.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.maintenance-history.index') }}" class="dropdown-link">
                                        <i class="ri-dashboard-line"></i> Maintenance Dashboard
                                    </a>
                                </li>
                            @endcan

                            @can('maintenance_requests.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.maintenance-requests.index') }}" class="dropdown-link">
                                        <i class="ri-file-list-3-line"></i> Maintenance Requests
                                    </a>
                                </li>
                            @endcan

                            @can('work_orders.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.maintenance.work-orders.index') }}" class="dropdown-link">
                                        <i class="ri-file-list-3-line"></i> Work Orders
                                    </a>
                                </li>
                            @endcan

                            @can('service_requests.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.maintenance.service-requests.index') }}" class="dropdown-link">
                                        <i class="ri-customer-service-2-line"></i> Service Requests
                                    </a>
                                </li>
                            @endcan

                            @can('preventive_maintenance.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.preventive-maintenance.index') }}" class="dropdown-link">
                                        <i class="ri-calendar-check-line"></i> Preventive Maintenance
                                    </a>
                                </li>
                            @endcan

                            @can('maintenance_reports.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.maintenance.reports.index') }}" class="dropdown-link">
                                        <i class="ri-bar-chart-line"></i> Maintenance Reports
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endif -->

                <!-- {{-- =========================================================
                    PERFORMANCE
                ========================================================== --}}
                <li class="app-nav-item has-dropdown">
                    <a href="#" class="app-nav-link">
                        <i class="ri-line-chart-line"></i>
                        Performance
                        <i class="ri-arrow-down-s-line"></i>
                    </a>

                    <ul class="dropdown-menu level-2">
                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link"><i class="ri-dashboard-line"></i> Performance Dashboard</a>
                        </li>
                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link"><i class="ri-target-line"></i> KPI</a>
                        </li>
                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link"><i class="ri-building-4-line"></i> Occupancy Performance</a>
                        </li>
                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link"><i class="ri-money-dollar-box-line"></i> Revenue Performance</a>
                        </li>
                        <li class="dropdown-item">
                            <a href="#" class="dropdown-link"><i class="ri-file-chart-line"></i> Reports</a>
                        </li>
                    </ul>
                </li> -->

                {{-- =========================================================
                    ADMINISTRATION
                ========================================================== --}}
                @if(
                    auth()->user()->can('users.view') ||
                    auth()->user()->can('roles.view') ||
                    auth()->user()->can('audit.view')
                )
                    <li class="app-nav-item has-dropdown">
                        <a href="#" class="app-nav-link {{ request()->routeIs('admin.users.*', 'admin.roles.*') ? 'active' : '' }}">
                            <i class="ri-admin-line"></i>
                            Administration
                            <i class="ri-arrow-down-s-line"></i>
                        </a>

                        <ul class="dropdown-menu level-2">
                            @can('users.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.users.index') }}"
                                       class="dropdown-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                        <i class="ri-user-settings-line"></i> Manage Users
                                    </a>
                                </li>
                            @endcan
                            @can('roles.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.roles.index') }}"
                                       class="dropdown-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                                        <i class="ri-shield-user-line"></i> Roles & Permissions
                                    </a>
                                </li>
                            @endcan
                            @can('audit.view')
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.users.audits', auth()->id()) }}" class="dropdown-link">
                                        <i class="ri-history-line"></i> Audit Trail
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                {{-- =========================================================
                    PROFILE / LOGOUT
                ========================================================== --}}
                <li class="app-nav-item has-dropdown">
                    <a href="#" class="app-nav-link">
                        <i class="ri-user-line"></i>
                    </a>

                    <ul class="dropdown-menu level-2">
                        <li class="dropdown-item">
                            <a href="{{ route('profile.show') }}"
                               class="dropdown-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                <i class="ri-user-line"></i> Profile
                            </a>
                        </li>
                        <li class="dropdown-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-link" style="border:0;background:none;cursor:pointer;">
                                    <i class="ri-logout-box-r-line"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>

            @else

                {{-- =========================================================
                    GUEST
                ========================================================== --}}
                <li class="app-nav-item">
                    <a href="{{ route('login.form') }}"
                       class="app-nav-link {{ request()->routeIs('login.form') ? 'active' : '' }}">
                        <i class="ri-login-box-line"></i> Login
                    </a>
                </li>
                <li class="app-nav-item">
                    <a href="{{ route('register.form') }}"
                       class="app-nav-link {{ request()->routeIs('register.form') ? 'active' : '' }}">
                        <i class="ri-user-add-line"></i> Register
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