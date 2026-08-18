@extends('layouts.app')

@section('title', 'Maintenance Requests')

@section('content')

<div class="container-fluid">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">
                <i class="fas fa-tools me-2"></i>
                Maintenance Requests
            </h4>

            <div class="text-muted">
                Manage maintenance requests.
            </div>
        </div>

        @can('maintenance_requests.create')
            <a href="{{ route('admin.maintenance-requests.create') }}"
               class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Add Maintenance Request
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
                    data-bs-dismiss="alert">
            </button>

        </div>
    @endif


    {{-- =========================================================
        VALIDATION ERRORS
    ========================================================== --}}
    @if($errors->any())
        <div class="alert alert-danger">

            <div class="fw-semibold mb-1">
                <i class="fas fa-exclamation-triangle me-1"></i>
                Please correct the following errors:
            </div>

            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

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

            <form method="GET"
                  action="{{ route('admin.maintenance-requests.index') }}">

                <div class="row g-3">

                    {{-- Search --}}
                    <div class="col-md-7">

                        <label for="search"
                               class="form-label">
                            Search
                        </label>

                        <input type="text"
                               id="search"
                               name="search"
                               class="form-control"
                               placeholder="Search maintenance number, category..."
                               value="{{ request('search') }}">

                    </div>


                    {{-- Status --}}
                    <div class="col-md-3">

                        <label for="status"
                               class="form-label">
                            Status
                        </label>

                        <select id="status"
                                name="status"
                                class="form-select">

                            <option value="">
                                All Status
                            </option>

                            @php
                                $statuses = [
                                    'Pending',
                                    'Assigned',
                                    'In Progress',
                                    'On Hold',
                                    'Completed',
                                    'Cancelled',
                                    'Closed',
                                ];
                            @endphp

                            @foreach($statuses as $status)

                                <option value="{{ $status }}"
                                    {{ request('status') === $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Buttons --}}
                    <div class="col-md-2 d-flex align-items-end gap-2">

                        <button type="submit"
                                class="btn btn-primary">

                            <i class="fas fa-search me-1"></i>
                            Search

                        </button>

                        <a href="{{ route('admin.maintenance-requests.index') }}"
                           class="btn btn-secondary">

                            Clear

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
        MAINTENANCE REQUEST LIST
    ========================================================== --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header d-flex">

            <h5 class="mb-0">
                <i class="fas fa-list me-1"></i>
                Maintenance Request List
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
                                Maintenance Number
                            </th>

                            <th>
                                Service Request ID
                            </th>

                            <th>
                                Unit ID
                            </th>

                            <th>
                                Category
                            </th>

                            <th>
                                Sub Category
                            </th>

                            <th>
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


                                {{-- Maintenance Number --}}
                                <td>
                                    {{ \Illuminate\Support\Str::limit(
                                        (string) $item->maintenance_number,
                                        60
                                    ) ?: '-' }}
                                </td>


                                {{-- Service Request --}}
                                <td>
                                    {{ $item->service_request_id ?? '-' }}
                                </td>


                                {{-- Unit --}}
                                <td>
                                    {{ $item->unit_id ?? '-' }}
                                </td>


                                {{-- Category --}}
                                <td>
                                    {{ \Illuminate\Support\Str::limit(
                                        (string) $item->category,
                                        60
                                    ) ?: '-' }}
                                </td>


                                {{-- Sub Category --}}
                                <td>
                                    {{ \Illuminate\Support\Str::limit(
                                        (string) $item->sub_category,
                                        60
                                    ) ?: '-' }}
                                </td>


                                {{-- Status --}}
                                <td>

                                    @php
                                        $status = (string) $item->status;

                                        $successStatuses = [
                                            'Completed',
                                            'Closed',
                                            'Resolved',
                                        ];

                                        $warningStatuses = [
                                            'Pending',
                                            'On Hold',
                                        ];

                                        $primaryStatuses = [
                                            'Assigned',
                                            'In Progress',
                                        ];

                                        if (in_array($status, $successStatuses)) {
                                            $badgeClass = 'bg-success';
                                        } elseif (in_array($status, $warningStatuses)) {
                                            $badgeClass = 'bg-warning text-dark';
                                        } elseif (in_array($status, $primaryStatuses)) {
                                            $badgeClass = 'bg-primary';
                                        } elseif ($status === 'Cancelled') {
                                            $badgeClass = 'bg-danger';
                                        } else {
                                            $badgeClass = 'bg-secondary';
                                        }
                                    @endphp

                                    <span class="badge {{ $badgeClass }}">
                                        {{ $status ?: 'N/A' }}
                                    </span>

                                </td>


                                {{-- Actions --}}
                                <td>

                                    {{-- View --}}
                                    <a href="{{ route(
                                        'admin.maintenance-requests.show',
                                        $item->id
                                    ) }}"
                                       class="btn btn-sm btn-info">

                                        <i class="fas fa-eye"></i>
                                        View

                                    </a>


                                    {{-- Edit --}}
                                    @can('maintenance_requests.edit')

                                        <a href="{{ route(
                                            'admin.maintenance-requests.edit',
                                            $item->id
                                        ) }}"
                                           class="btn btn-sm btn-primary">

                                            <i class="fas fa-edit"></i>
                                            Edit

                                        </a>

                                    @endcan


                                    {{-- Delete --}}
                                    @can('maintenance_requests.delete')

                                        <form method="POST"
                                              action="{{ route(
                                                  'admin.maintenance-requests.destroy',
                                                  $item->id
                                              ) }}"
                                              class="d-inline"
                                              onsubmit="return confirm(
                                                  'Are you sure you want to delete this maintenance request?'
                                              )">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger">

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

                                        <i class="fas fa-inbox fa-2x mb-2"></i>

                                        <div>
                                            No maintenance requests found.
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