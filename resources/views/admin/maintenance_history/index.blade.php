@extends('layouts.app')

@section('title', 'Maintenance History')

@section('content')

<div class="container-fluid">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">
                <i class="fas fa-history me-2"></i>
                Maintenance History
            </h4>

            <div class="text-muted">
                Manage maintenance history records.
            </div>
        </div>

        @can('maintenance_history.create')

            <a
                href="{{ route('admin.maintenance-history.create') }}"
                class="btn btn-primary"
            >
                <i class="fas fa-plus me-1"></i>
                Add Maintenance History
            </a>

        @endcan

    </div>


    {{-- =========================================================
        SUCCESS MESSAGE
    ========================================================== --}}
    @if(session('success'))

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>

        </div>

    @endif


    {{-- =========================================================
        VALIDATION ERRORS
    ========================================================== --}}
    @if($errors->any())

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >

            <div class="fw-semibold mb-2">
                <i class="fas fa-exclamation-triangle me-1"></i>
                Please correct the following errors:
            </div>

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>

        </div>

    @endif


    {{-- =========================================================
        SEARCH & FILTER
    ========================================================== --}}
    <div class="card mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                <i class="fas fa-filter me-1"></i>
                Search & Filter
            </h5>

        </div>

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('admin.maintenance-history.index') }}"
            >

                <div class="row g-3">

                    {{-- Search --}}
                    <div class="col-md-7">

                        <label
                            for="search"
                            class="form-label"
                        >
                            Search
                        </label>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            class="form-control"
                            placeholder="Search history number, asset, work order..."
                            value="{{ request('search') }}"
                        >

                    </div>


                    {{-- Status --}}
                    <div class="col-md-3">

                        <label
                            for="status"
                            class="form-label"
                        >
                            Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="form-select"
                        >

                            <option value="">
                                All Status
                            </option>

                            @foreach(($statuses ?? []) as $status)

                                <option
                                    value="{{ $status }}"
                                    {{ (string) request('status') === (string) $status ? 'selected' : '' }}
                                >
                                    {{ $status }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Buttons --}}
                    <div class="col-md-2 d-flex align-items-end gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="fas fa-search me-1"></i>
                            Search
                        </button>

                        <a
                            href="{{ route('admin.maintenance-history.index') }}"
                            class="btn btn-secondary"
                        >
                            Clear
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
        MAINTENANCE HISTORY LIST
    ========================================================== --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header d-flex">

            <h5 class="mb-0">
                <i class="fas fa-list me-1"></i>
                Maintenance History List
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
                                History Number
                            </th>

                            <th>
                                Asset ID
                            </th>

                            <th>
                                Work Order ID
                            </th>

                            <th>
                                Preventive Maintenance ID
                            </th>

                            <th>
                                Maintenance Type
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


                            {{-- History Number --}}
                            <td>

                                <strong>
                                    {{ \Illuminate\Support\Str::limit(
                                        (string) $item->history_number,
                                        60
                                    ) ?: '-' }}
                                </strong>

                            </td>


                            {{-- Asset --}}
                            <td>
                                {{ $item->asset_id ?: '-' }}
                            </td>


                            {{-- Work Order --}}
                            <td>
                                {{ $item->work_order_id ?: '-' }}
                            </td>


                            {{-- Preventive Maintenance --}}
                            <td>
                                {{ $item->preventive_maintenance_id ?: '-' }}
                            </td>


                            {{-- Maintenance Type --}}
                            <td>

                                {{ \Illuminate\Support\Str::limit(
                                    (string) $item->maintenance_type,
                                    60
                                ) ?: '-' }}

                            </td>


                            {{-- Status --}}
                            <td>

                                @php
                                    $status = (string) $item->status;

                                    $successStatuses = [
                                        'Active',
                                        'Completed',
                                        'Paid',
                                        'Resolved',
                                    ];

                                    $warningStatuses = [
                                        'Pending',
                                        'In Progress',
                                        'Scheduled',
                                    ];

                                    $dangerStatuses = [
                                        'Cancelled',
                                        'Rejected',
                                        'Failed',
                                    ];
                                @endphp


                                @if(in_array($status, $successStatuses, true))

                                    <span class="badge bg-success">

                                        <i class="fas fa-check-circle me-1"></i>

                                        {{ $status ?: 'Active' }}

                                    </span>

                                @elseif(in_array($status, $warningStatuses, true))

                                    <span class="badge bg-warning text-dark">

                                        <i class="fas fa-clock me-1"></i>

                                        {{ $status }}

                                    </span>

                                @elseif(in_array($status, $dangerStatuses, true))

                                    <span class="badge bg-danger">

                                        <i class="fas fa-times-circle me-1"></i>

                                        {{ $status }}

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        {{ $status ?: '-' }}

                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td>

                                {{-- View --}}
                                <a
                                    href="{{ route(
                                        'admin.maintenance-history.show',
                                        $item->id
                                    ) }}"
                                    class="btn btn-sm btn-info"
                                    title="View"
                                >
                                    <i class="fas fa-eye"></i>
                                    View
                                </a>


                                {{-- Edit --}}
                                @can('maintenance_history.edit')

                                    <a
                                        href="{{ route(
                                            'admin.maintenance-history.edit',
                                            $item->id
                                        ) }}"
                                        class="btn btn-sm btn-primary"
                                        title="Edit"
                                    >
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>

                                @endcan


                                {{-- Delete --}}
                                @can('maintenance_history.delete')

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.maintenance-history.destroy',
                                            $item->id
                                        ) }}"
                                        class="d-inline"
                                        onsubmit="return confirm(
                                            'Are you sure you want to delete this maintenance history record?'
                                        )"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                            title="Delete"
                                        >
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </button>

                                    </form>

                                @endcan

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="text-center py-5"
                            >

                                <div class="text-muted">

                                    <i class="fas fa-history fa-2x mb-2"></i>

                                    <div>
                                        No maintenance history found.
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