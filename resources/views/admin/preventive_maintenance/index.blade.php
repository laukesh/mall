@extends('layouts.app')

@section('title', 'Preventive Maintenance')

@section('content')

<div class="container-fluid">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">
                <i class="fas fa-tools me-2"></i>
                Preventive Maintenance
            </h4>

            <div class="text-muted">
                Manage preventive maintenance schedules and records.
            </div>

        </div>

        @can('preventive_maintenance.create')

            <a
                href="{{ route('admin.preventive-maintenance.create') }}"
                class="btn btn-primary"
            >
                <i class="fas fa-plus me-1"></i>
                Add Preventive Maintenance
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

        <div class="alert alert-danger alert-dismissible fade show">

            <div class="fw-semibold mb-2">

                <i class="fas fa-exclamation-triangle me-1"></i>
                Please correct the following errors:

            </div>

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

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
                action="{{ route('admin.preventive-maintenance.index') }}"
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
                            name="search"
                            id="search"
                            class="form-control"
                            placeholder="Search maintenance code, title or description..."
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
                            name="status"
                            id="status"
                            class="form-select"
                        >

                            <option value="">
                                All Status
                            </option>

                            @foreach($statuses ?? [] as $status)

                                <option
                                    value="{{ $status }}"
                                    {{ request('status') === $status ? 'selected' : '' }}
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
                            href="{{ route('admin.preventive-maintenance.index') }}"
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
        PREVENTIVE MAINTENANCE LIST
    ========================================================== --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header d-flex">

            <h5 class="mb-0">

                <i class="fas fa-list me-1"></i>
                Preventive Maintenance List

            </h5>

            <span class="text-muted">

                Total: {{ $items->total() }}

            </span>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table
                    class="table table-bordered table-hover align-middle mb-0"
                >

                    <thead class="table-light">

                        <tr>

                            <th width="70">
                                ID
                            </th>

                            <th>
                                Asset ID
                            </th>

                            <th>
                                Maintenance Code
                            </th>

                            <th>
                                Maintenance Title
                            </th>

                            <th>
                                Description
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


                            {{-- Asset --}}
                            <td>

                                {{ \Illuminate\Support\Str::limit(
                                    (string) $item->asset_id,
                                    60
                                ) ?: '-' }}

                            </td>


                            {{-- Maintenance Code --}}
                            <td>

                                <strong>
                                    {{ \Illuminate\Support\Str::limit(
                                        (string) $item->maintenance_code,
                                        60
                                    ) ?: '-' }}
                                </strong>

                            </td>


                            {{-- Maintenance Title --}}
                            <td>

                                {{ \Illuminate\Support\Str::limit(
                                    (string) $item->maintenance_title,
                                    60
                                ) ?: '-' }}

                            </td>


                            {{-- Description --}}
                            <td>

                                {{ \Illuminate\Support\Str::limit(
                                    (string) $item->description,
                                    60
                                ) ?: '-' }}

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
                                @endphp

                                @if(in_array($status, $successStatuses, true))

                                    <span class="badge bg-success">

                                        <i class="fas fa-check-circle me-1"></i>

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
                                <a
                                    href="{{ route(
                                        'admin.preventive-maintenance.show',
                                        $item->id
                                    ) }}"
                                    class="btn btn-sm btn-info"
                                    title="View"
                                >

                                    <i class="fas fa-eye"></i>
                                    View

                                </a>


                                {{-- Edit --}}
                                @can('preventive_maintenance.edit')

                                    <a
                                        href="{{ route(
                                            'admin.preventive-maintenance.edit',
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
                                @can('preventive_maintenance.delete')

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.preventive-maintenance.destroy',
                                            $item->id
                                        ) }}"
                                        class="d-inline"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                            title="Delete"
                                            onclick="return confirm(
                                                'Are you sure you want to delete this preventive maintenance record?'
                                            )"
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

                                    <i class="fas fa-tools fa-2x mb-2"></i>

                                    <div>
                                        No preventive maintenance records found.
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