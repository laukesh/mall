@extends('layouts.app')

@section('title', 'Vendor Performance')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1"><i class="fas fa-layer-group me-2"></i>Vendor Performance</h4>
            <div class="text-muted">Manage vendor performance.</div>
        </div>

        @can('vendor_performance.create')
            <a href="{{ route('admin.maintenance.vendor-performance.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Vendor Performance
            </a>
        @endcan
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-1"></i>Search & Filter</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.maintenance.vendor-performance.index') }}">
                <div class="row g-3">
                    <div class="col-md-7">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" id="search" name="search" class="form-control"
                               placeholder="Search..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select">
                            <option value="">All Status</option>
                            @foreach({repr(next((f[4] for f in m["fields"] if f[0]=="status"), []))} as $status)
                                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search me-1"></i>Search</button>
                        <a href="{{ route('admin.maintenance.vendor-performance.index') }}" class="btn btn-secondary">Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list me-1"></i>Vendor Performance List</h5>
            <span class="text-muted">Total: {{ $items->total() }}</span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="70">ID</th>
                            <th>Vendor User ID</th>
                            <th>Contract ID</th>
                            <th>Evaluation Period Start</th>
                            <th>Evaluation Period End</th>
                            <th>Quality Rating</th>
                            <th>Status</th>
                            <th width="220">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ \Illuminate\Support\Str::limit((string) $item->vendor_user_id, 60) ?: '-' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit((string) $item->contract_id, 60) ?: '-' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit((string) $item->evaluation_period_start, 60) ?: '-' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit((string) $item->evaluation_period_end, 60) ?: '-' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit((string) $item->quality_rating, 60) ?: '-' }}</td>
                            <td>
                                <span class="badge { (string) $item->status === 'Active' || (string) $item->status === 'Completed' || (string) $item->status === 'Paid' || (string) $item->status === 'Resolved' ? 'bg-success' : 'bg-secondary' }">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.maintenance.vendor-performance.show', $item->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> View
                                </a>

                                @can('vendor_performance.edit')
                                    <a href="{{ route('admin.maintenance.vendor-performance.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                @endcan

                                @can('vendor_performance.delete')
                                    <form method="POST" action="{{ route('admin.maintenance.vendor-performance.destroy', $item->id) }}" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted"><i class="fas fa-inbox fa-2x mb-2"></i><div>No records found.</div></div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($items->hasPages())
            <div class="card-footer">
                {{ $items->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
