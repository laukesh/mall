<!--  <div class="sidebar-menu"> -->

    @auth


        {{-- =================================================
             DASHBOARD
        ================================================== --}}

        @can('dashboard.view')

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link
               {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

                <i class="ri-dashboard-line"></i>

                <span>Dashboard</span>

            </a>

        @endcan



        {{-- =================================================
             ASSET OPERATIONS
        ================================================== --}}

        @if(
            auth()->user()->can('malls.view') ||
            auth()->user()->can('buildings.view') ||
            auth()->user()->can('floors.view') ||
            auth()->user()->can('zones.view') ||
            auth()->user()->can('unit_types.view') ||
            auth()->user()->can('units.view')
        )

            <details class="sidebar-group"
                {{ request()->routeIs('admin.assets.*') ? 'open' : '' }}>

                <summary class="sidebar-link">

                    <i class="ri-building-line"></i>

                    <span>Assets</span>

                    <i class="ri-arrow-right-s-line sidebar-arrow"></i>

                </summary>


                <div class="sidebar-submenu">

                    @can('malls.view')

                        <a href="{{ route('admin.assets.malls.index') }}"
                           class="sidebar-sublink">

                            Malls

                        </a>

                    @endcan


                    @can('buildings.view')

                        <a href="{{ route('admin.assets.buildings.index') }}"
                           class="sidebar-sublink">

                            Buildings

                        </a>

                    @endcan


                    @can('floors.view')

                        <a href="{{ route('admin.assets.floors.index') }}"
                           class="sidebar-sublink">

                            Floors

                        </a>

                    @endcan


                    @can('zones.view')

                        <a href="{{ route('admin.assets.zones.index') }}"
                           class="sidebar-sublink">

                            Zones

                        </a>

                    @endcan


                    @can('unit_types.view')

                        <a href="{{ route('admin.assets.unit_types.index') }}"
                           class="sidebar-sublink">

                            Unit Types

                        </a>

                    @endcan


                    @can('units.view')

                        <a href="{{ route('admin.assets.units.index') }}"
                           class="sidebar-sublink">

                            Units

                        </a>

                    @endcan

                </div>

            </details>

        @endif



        {{-- =================================================
             LEASING
        ================================================== --}}

        <details class="sidebar-group"
            {{ request()->routeIs('admin.leasing.*') ? 'open' : '' }}>

            <summary class="sidebar-link">

                <i class="ri-file-text-line"></i>

                <span>Leasing</span>

                <i class="ri-arrow-right-s-line sidebar-arrow"></i>

            </summary>


            <div class="sidebar-submenu">


                <a href="{{ route('admin.leasing.dashboard') }}"
                   class="sidebar-sublink">

                    Dashboard

                </a>


                <a href="{{ route('admin.leasing.index') }}"
                   class="sidebar-sublink">

                    All Leasing

                </a>


                <a href="{{ route('admin.leasing.proposals.index') }}"
                   class="sidebar-sublink">

                    Lease Proposals

                </a>


                <a href="{{ route('admin.leasing.agreements.index') }}"
                   class="sidebar-sublink">

                    Lease Agreements

                </a>


                <a href="{{ route('admin.leasing.terms.index') }}"
                   class="sidebar-sublink">

                    Lease Terms

                </a>


                <a href="{{ route('admin.leasing.documents.index') }}"
                   class="sidebar-sublink">

                    Documents

                </a>


                <a href="{{ route('admin.leasing.escalations.index') }}"
                   class="sidebar-sublink">

                    Escalations

                </a>


                <a href="{{ route('admin.leasing.renewals.index') }}"
                   class="sidebar-sublink">

                    Renewals

                </a>


                <a href="{{ route('admin.leasing.terminations.index') }}"
                   class="sidebar-sublink">

                    Terminations

                </a>


                <a href="{{ route('admin.leasing.history.index') }}"
                   class="sidebar-sublink">

                    History

                </a>

            </div>

        </details>



        {{-- =================================================
             TENANTS
        ================================================== --}}

        <details class="sidebar-group"
            {{ request()->is('admin/tenants*') ? 'open' : '' }}>

            <summary class="sidebar-link">

                <i class="ri-group-line"></i>

                <span>Tenants</span>

                <i class="ri-arrow-right-s-line sidebar-arrow"></i>

            </summary>


            <div class="sidebar-submenu">

                <a href="{{ url('/admin/tenants/dashboard') }}"
                   class="sidebar-sublink">

                    Dashboard

                </a>


                <a href="{{ url('/admin/tenants') }}"
                   class="sidebar-sublink">

                    All Tenants

                </a>


                <a href="{{ url('/admin/tenants?status=Active') }}"
                   class="sidebar-sublink">

                    Active Tenants

                </a>


                <a href="{{ url('/admin/tenants?status=Inactive') }}"
                   class="sidebar-sublink">

                    Inactive Tenants

                </a>


                <a href="{{ url('/admin/tenants/leases') }}"
                   class="sidebar-sublink">

                    Tenant Leases

                </a>


                <a href="{{ url('/admin/tenants/leases/expiry') }}"
                   class="sidebar-sublink">

                    Lease Expiry

                </a>


                <a href="{{ url('/admin/tenants/contacts') }}"
                   class="sidebar-sublink">

                    Contacts

                </a>


                <a href="{{ url('/admin/tenants/emergency-contacts') }}"
                   class="sidebar-sublink">

                    Emergency Contacts

                </a>


                <a href="{{ url('/admin/tenants/documents') }}"
                   class="sidebar-sublink">

                    Documents

                </a>

            </div>

        </details>



        {{-- =================================================
             REVENUE
        ================================================== --}}

        <details class="sidebar-group"
            {{ request()->is('admin/revenue*') ? 'open' : '' }}>

            <summary class="sidebar-link">

                <i class="ri-money-rupee-circle-line"></i>

                <span>Revenue</span>

                <i class="ri-arrow-right-s-line sidebar-arrow"></i>

            </summary>


            <div class="sidebar-submenu">


                <a href="{{ url('/admin/revenue/dashboard') }}"
                   class="sidebar-sublink">

                    Dashboard

                </a>


                <div class="sidebar-section-label">
                    Billing
                </div>


                <a href="{{ url('/admin/revenue/rent-schedules') }}"
                   class="sidebar-sublink">

                    Rent Schedules

                </a>


                <a href="{{ url('/admin/revenue/invoices') }}"
                   class="sidebar-sublink">

                    Invoices

                </a>


                <div class="sidebar-section-label">
                    Collections
                </div>


                <a href="{{ url('/admin/revenue/payments') }}"
                   class="sidebar-sublink">

                    Payments

                </a>


                <a href="{{ url('/admin/revenue/reconciliation') }}"
                   class="sidebar-sublink">

                    Reconciliation

                </a>


                <div class="sidebar-section-label">
                    Outstanding
                </div>


                <a href="{{ url('/admin/revenue/outstanding') }}"
                   class="sidebar-sublink">

                    Outstanding

                </a>


                <a href="{{ url('/admin/revenue/outstanding/overdue') }}"
                   class="sidebar-sublink">

                    Overdue

                </a>


                <a href="{{ url('/admin/revenue/outstanding/tenants') }}"
                   class="sidebar-sublink">

                    Tenant Outstanding

                </a>


                <div class="sidebar-section-label">
                    Reports
                </div>


                <a href="{{ url('/admin/revenue/reports/revenue') }}"
                   class="sidebar-sublink">

                    Revenue Report

                </a>


                <a href="{{ url('/admin/revenue/reports/collections') }}"
                   class="sidebar-sublink">

                    Collection Report

                </a>


                <a href="{{ url('/admin/revenue/reports/tenant-wise') }}"
                   class="sidebar-sublink">

                    Tenant-wise Revenue

                </a>


                <a href="{{ url('/admin/revenue/reports/aging') }}"
                   class="sidebar-sublink">

                    Aging Report

                </a>

            </div>

        </details>



        {{-- =================================================
             FIT-OUT
        ================================================== --}}

        <details class="sidebar-group"
            {{ request()->routeIs('admin.fitout.*') ? 'open' : '' }}>

            <summary class="sidebar-link">

                <i class="ri-hammer-line"></i>

                <span>Fit-Out</span>

                <i class="ri-arrow-right-s-line sidebar-arrow"></i>

            </summary>


            <div class="sidebar-submenu">


                <a href="{{ route('admin.fitout.dashboard') }}"
                   class="sidebar-sublink">

                    Dashboard

                </a>


                <a href="{{ route('admin.fitout.requests.index') }}"
                   class="sidebar-sublink">

                    Fit-Out Requests

                </a>


                <a href="{{ route('admin.fitout.approvals.index') }}"
                   class="sidebar-sublink">

                    Approvals

                </a>


                <a href="{{ route('admin.fitout.contractors.index') }}"
                   class="sidebar-sublink">

                    Contractors

                </a>


                <a href="{{ route('admin.fitout.inspections.index') }}"
                   class="sidebar-sublink">

                    Inspections

                </a>


                <a href="{{ route('admin.fitout.snags.index') }}"
                   class="sidebar-sublink">

                    Snags

                </a>


                <a href="{{ route('admin.fitout.documents.index') }}"
                   class="sidebar-sublink">

                    Documents

                </a>


                <a href="{{ route('admin.fitout.handovers.index') }}"
                   class="sidebar-sublink">

                    Handovers

                </a>

            </div>

        </details>


        <!-- sudhir projects -->

        {{-- =========================================================
             PROJECT MANAGEMENT
        ========================================================= --}}

        <details
            class="sidebar-group"
            {{ request()->routeIs(
                'admin.land.*',
                'admin.feasibility.*',
                'admin.design.*',
                'admin.project.*',
                'admin.workpackage.*',
                'admin.contractor.*',
                'admin.client.*',
                'admin.mobilization.*',
                'admin.procurement.*',
                'admin.inventory.*',
                'admin.document.*',
                'admin.hse.*',
                'admin.finance.*',
                'admin.audit.*',
                'admin.report.*',
                'admin.pm.*'
            ) ? 'open' : '' }}
        >

            <summary class="sidebar-link">

                <i class="ri-building-2-line"></i>

                <span>Project Management</span>

                <i class="ri-arrow-right-s-line sidebar-arrow"></i>

            </summary>


            <div class="sidebar-submenu">


                {{-- =====================================================
                     PRE-CONSTRUCTION
                ====================================================== --}}

                <div class="sidebar-section-label">
                    Pre-Construction
                </div>


                {{-- LAND ACQUISITION --}}

                <a
                    href="{{ route('admin.land.index') }}"
                    class="sidebar-sublink
                        {{ request()->routeIs('admin.land.*') ? 'active' : '' }}"
                >

                    <i class="ri-map-pin-line"></i>

                    <span>Land Acquisition</span>

                </a>


                {{-- FEASIBILITY --}}

                <a
                    href="{{ route('admin.feasibility.index') }}"
                    class="sidebar-sublink
                        {{ request()->routeIs('admin.feasibility.*') ? 'active' : '' }}"
                >

                    <i class="ri-line-chart-line"></i>

                    <span>Feasibility Studies</span>

                </a>


                {{-- DESIGN --}}

                <a
                    href="{{ route('admin.design.index') }}"
                    class="sidebar-sublink
                        {{ request()->routeIs('admin.design.*') ? 'active' : '' }}"
                >

                    <i class="ri-pencil-ruler-2-line"></i>

                    <span>Design Management</span>

                </a>


                {{-- =====================================================
                     PROJECT EXECUTION
                ====================================================== --}}

                <div class="sidebar-section-label">
                    Project Execution
                </div>


                {{-- PROJECTS --}}

                <a
                    href="{{ route('admin.project.index') }}"
                    class="sidebar-sublink
                        {{ request()->routeIs('admin.project.*') ? 'active' : '' }}"
                >

                    <i class="ri-building-line"></i>

                    <span>Projects</span>

                </a>


                {{-- WORK PACKAGES --}}

                <a
                    href="{{ route('admin.workpackage.index') }}"
                    class="sidebar-sublink
                        {{ request()->routeIs('admin.workpackage.*') ? 'active' : '' }}"
                >

                    <i class="ri-box-3-line"></i>

                    <span>Work Packages</span>

                </a>


                {{-- CONTRACTORS --}}

                <a
                    href="{{ route('admin.contractor.index') }}"
                    class="sidebar-sublink
                        {{ request()->routeIs('admin.contractor.*') ? 'active' : '' }}"
                >

                    <i class="ri-hard-hat-line"></i>

                    <span>Contractors</span>

                </a>


                <!-- {{-- CLIENTS --}}

                <a
                    href="{{ route('admin.client.index') }}"
                    class="sidebar-sublink
                        {{ request()->routeIs('admin.client.*') ? 'active' : '' }}"
                >

                    <i class="ri-handshake-line"></i>

                    <span>Clients</span>

                </a> -->


                {{-- MOBILIZATION --}}

                <a
                    href="{{ route('admin.mobilization.index') }}"
                    class="sidebar-sublink
                        {{ request()->routeIs('admin.mobilization.*') ? 'active' : '' }}"
                >

                    <i class="ri-truck-line"></i>

                    <span>Mobilization</span>

                </a>


                {{-- =====================================================
                     SUPPLY CHAIN
                ====================================================== --}}

                <div class="sidebar-section-label">
                    Supply Chain
                </div>


                {{-- PROCUREMENT --}}

                <a
                    href="{{ route('admin.procurement.vendors') }}"
                    class="sidebar-sublink
                        {{ request()->routeIs('admin.procurement.*') ? 'active' : '' }}"
                >

                    <i class="ri-shopping-cart-2-line"></i>

                    <span>Procurement</span>

                </a>


                {{-- INVENTORY --}}

                <a
                    href="{{ route('admin.inventory.materials') }}"
                    class="sidebar-sublink
                        {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}"
                >

                    <i class="ri-archive-line"></i>

                    <span>Inventory</span>

                </a>


                {{-- =====================================================
                     OPERATIONS
                ====================================================== --}}

                <div class="sidebar-section-label">
                    Operations
                </div>


                {{-- DOCUMENTS --}}

                <a
                    href="{{ route('admin.document.index') }}"
                    class="sidebar-sublink
                        {{ request()->routeIs('admin.document.*') ? 'active' : '' }}"
                >

                    <i class="ri-folder-open-line"></i>

                    <span>Documents</span>

                </a>


                {{-- HEALTH & SAFETY --}}

                <a
                    href="{{ route('admin.hse.incidents') }}"
                    class="sidebar-sublink
                        {{ request()->routeIs('admin.hse.*') ? 'active' : '' }}"
                >

                    <i class="ri-shield-check-line"></i>

                    <span>Health & Safety</span>

                </a>


                {{-- FINANCE --}}

                <a
                    href="{{ route('admin.finance.index') }}"
                    class="sidebar-sublink
                        {{ request()->routeIs('admin.finance.*') ? 'active' : '' }}"
                >

                    <i class="ri-money-rupee-circle-line"></i>

                    <span>Finance</span>

                </a>


                {{-- =====================================================
                     REPORTS & CONTROL
                ====================================================== --}}

                <div class="sidebar-section-label">
                    Reports & Control
                </div>


                {{-- REPORTS --}}

                <a
                    href="{{ route('admin.report.index') }}"
                    class="sidebar-sublink
                        {{ request()->routeIs('admin.report.*') ? 'active' : '' }}"
                >

                    <i class="ri-bar-chart-box-line"></i>

                    <span>Reports</span>

                </a>


                {{-- STATUS HISTORY --}}

                <a
                    href="{{ route('admin.pm.status-history.index') }}"
                    class="sidebar-sublink
                        {{ request()->routeIs('admin.pm.status-history.*') ? 'active' : '' }}"
                >

                    <i class="ri-exchange-line"></i>

                    <span>Status History</span>

                </a>


                {{-- AUDIT LOGS --}}

                <a
                    href="{{ route('admin.audit.index') }}"
                    class="sidebar-sublink
                        {{ request()->routeIs('admin.audit.*') ? 'active' : '' }}"
                >

                    <i class="ri-history-line"></i>

                    <span>Audit Logs</span>

                </a>


            </div>

        </details>
        <!-- sudhir projects -->



        {{-- =================================================
             PERFORMANCE
        ================================================== --}}

        <a href="#"
           class="sidebar-link">

            <i class="ri-bar-chart-box-line"></i>

            <span>Performance</span>

        </a>



        {{-- =================================================
             ADMINISTRATION
        ================================================== --}}

        @if(
            auth()->user()->can('users.view') ||
            auth()->user()->can('roles.view') ||
            auth()->user()->can('audit.view')
        )

            <details class="sidebar-group">

                <summary class="sidebar-link">

                    <i class="ri-settings-3-line"></i>

                    <span>Administration</span>

                    <i class="ri-arrow-right-s-line sidebar-arrow"></i>

                </summary>


                <div class="sidebar-submenu">


                    @can('users.view')

                        <a href="{{ route('admin.users.index') }}"
                           class="sidebar-sublink">

                            Users

                        </a>

                    @endcan


                    @can('roles.view')

                        <a href="{{ route('admin.roles.index') }}"
                           class="sidebar-sublink">

                            Roles & Permissions

                        </a>

                    @endcan


                    @can('audit.view')

                        <a href="{{ route(
                            'admin.users.audits',
                            auth()->id()
                        ) }}"
                           class="sidebar-sublink">

                            Audit Trail

                        </a>

                    @endcan

                </div>

            </details>

        @endif



        {{-- =================================================
             PROFILE
        ================================================== --}}

        <a href="{{ route('profile.show') }}"
           class="sidebar-link">

            <i class="ri-user-line"></i>

            <span>Profile</span>

        </a>


        {{-- =================================================
             LOGOUT
        ================================================== --}}

        <form action="{{ route('logout') }}"
              method="POST">

            @csrf

            <button type="submit"
                    class="sidebar-link sidebar-logout">

                <i class="ri-logout-box-line"></i>

                <span>Logout</span>

            </button>

        </form>


    @endauth

<!-- </div> -->