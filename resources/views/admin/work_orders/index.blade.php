@extends('layouts.app')

@section('title', 'Work Orders')

@section('content')

<div class="container-fluid">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">
                <i class="fas fa-tools me-2"></i>
                Work Orders
            </h4>

            <div class="text-muted">
                Manage maintenance work orders.
            </div>
        </div>

        @can('work_orders.create')

            <a href="{{ route('admin.maintenance.work-orders.create') }}"
               class="btn btn-primary">

                <i class="fas fa-plus me-1"></i>
                Add Work Order

            </a>

        @endcan

    </div>


    {{-- =========================================================
        SUCCESS MESSAGE
    ========================================================== --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show"
             role="alert">

            <i class="fas fa-check-circle me-1"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>

        </div>

    @endif


    {{-- =========================================================
        VALIDATION ERRORS
    ========================================================== --}}
    @if($errors->any())

        <div class="alert alert-danger alert-dismissible fade show"
             role="alert">

            <div class="fw-semibold mb-2">
                <i class="fas fa-exclamation-triangle me-1"></i>
                Please correct the following errors:
            </div>

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>

        </div>

    @endif


    {{-- =========================================================
        SEARCH & FILTER
    ========================================================== --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white">

            <h5 class="mb-0">
                <i class="fas fa-filter me-2"></i>
                Search & Filter
            </h5>

        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.maintenance.work-orders.index') }}">

                <div class="row g-3">

                    {{-- Search --}}
                    <div class="col-lg-7 col-md-6">

                        <label for="search"
                               class="form-label fw-semibold">

                            Search

                        </label>

                        <input type="text"
                               id="search"
                               name="search"
                               class="form-control"
                               placeholder="Search work order..."
                               value="{{ request('search') }}">

                    </div>


                    {{-- Status --}}
                    <div class="col-lg-3 col-md-4">

                        <label for="status"
                               class="form-label fw-semibold">

                            Status

                        </label>

                        <select id="status"
                                name="status"
                                class="form-select">

                            <option value="">
                                All Status
                            </option>

                            @if(isset($statuses))

                                @foreach($statuses as $status)

                                    <option value="{{ $status }}"
                                        {{ request('status') === (string) $status
                                            ? 'selected'
                                            : '' }}>

                                        {{ $status }}

                                    </option>

                                @endforeach

                            @endif

                        </select>

                    </div>


                    {{-- Buttons --}}
                    <div class="col-lg-2 col-md-2 d-flex align-items-end gap-2">

                        <button type="submit"
                                class="btn btn-primary">

                            <i class="fas fa-search me-1"></i>
                            Search

                        </button>

                        <a href="{{ route('admin.maintenance.work-orders.index') }}"
                           class="btn btn-secondary">

                            Clear

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
        WORK ORDER LIST
    ========================================================== --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                <i class="fas fa-list me-2"></i>
                Work Order List

            </h5>

            <span class="text-muted">

                Total: {{ $items->total() }}

            </span>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th width="70">
                                ID
                            </th>

                            <th>
                                Work Order Number
                            </th>

                            <th>
                                Maintenance Request
                            </th>

                            <th>
                                Unit
                            </th>

                            <th>
                                Department
                            </th>

                            <th>
                                Assigned To
                            </th>

                            <th width="110">
                                Status
                            </th>

                            <th width="220">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($items as $item)

                        <tr>

                            {{-- ID --}}
                            <td>
                                {{ $item->id }}
                            </td>


                            {{-- Work Order Number --}}
                            <td>

                                <strong>
                                    {{ $item->work_order_number ?: '-' }}
                                </strong>

                            </td>


                            {{-- Maintenance Request --}}
                            <td>
                                {{ $item->maintenance_request_id ?: '-' }}
                            </td>


                            {{-- Unit --}}
                            <td>
                                {{ $item->unit_id ?: '-' }}
                            </td>


                            {{-- Department --}}
                            <td>
                                {{ $item->department_id ?: '-' }}
                            </td>


                            {{-- Assigned To --}}
                            <td>
                                {{ $item->assigned_to ?: '-' }}
                            </td>


                            {{-- Status --}}
                            <td>

                                @php
                                    $status = (string) $item->status;

                                    $successStatuses = [
                                        'Active',
                                        'Completed',
                                        'Resolved',
                                        'Closed',
                                    ];

                                    $warningStatuses = [
                                        'Pending',
                                        'In Progress',
                                        'Open',
                                    ];
                                @endphp

                                @if(in_array($status, $successStatuses, true))

                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>
                                        {{ $status }}
                                    </span>

                                @elseif(in_array($status, $warningStatuses, true))

                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $status }}
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        {{ $status ?: 'N/A' }}
                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td>

                                {{-- View --}}
                                <a href="{{ route(
                                    'admin.maintenance.work-orders.show',
                                    $item->id
                                ) }}"
                                   class="btn btn-sm btn-info"
                                   title="View">

                                    <i class="fas fa-eye"></i>
                                    View

                                </a>


                                {{-- Edit --}}
                                @can('work_orders.edit')

                                    <a href="{{ route(
                                        'admin.maintenance.work-orders.edit',
                                        $item->id
                                    ) }}"
                                       class="btn btn-sm btn-primary"
                                       title="Edit">

                                        <i class="fas fa-edit"></i>
                                        Edit

                                    </a>

                                @endcan


                                {{-- Delete --}}
                                @can('work_orders.delete')

                                    <form method="POST"
                                          action="{{ route(
                                              'admin.maintenance.work-orders.destroy',
                                              $item->id
                                          ) }}"
                                          class="d-inline"
                                          onsubmit="return confirm(
                                              'Are you sure you want to delete this work order?'
                                          )">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Delete">

                                            <i class="fas fa-trash"></i>
                                            Delete

                                        </button>

                                    </form>

                                @endcan

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="8"
                                class="text-center py-5">

                                <div class="text-muted">

                                    <i class="fas fa-tools fa-2x mb-2"></i>

                                    <div>
                                        No work orders found.
                                    </div>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =====================================================
            PAGINATION
        ====================================================== --}}
        @if($items->hasPages())

            <div class="card-footer">

                {{ $items->withQueryString()->links() }}

            </div>

        @endif

    </div>

</div>

@endsection