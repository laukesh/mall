@extends('layouts.app')

@section('title', 'Assets')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1"><i class="fas fa-boxes me-2"></i>Assets</h4>
            <div class="text-muted">Manage mall assets.</div>
        </div>

        @can('assets.create')
            <a href="{{ route('admin.assets.assets.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Asset
            </a>
        @endcan
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
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
            <form method="GET" action="{{ route('admin.assets.assets.index') }}">
                <div class="row g-3">
                    <div class="col-lg-5 col-md-6">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" id="search" name="search" class="form-control"
                               placeholder="Asset code, name, serial number..." value="{{ request('search') }}">
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <input type="text" id="status" name="status" class="form-control"
                               placeholder="Status" value="{{ request('status') }}">
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label for="asset_category" class="form-label">Category</label>
                        <select id="asset_category" name="asset_category" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($assetCategories ?? [] as $id => $name)
                                <option value="{{ $id }}" {{ (string)request('asset_category') === (string)$id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i> Search
                        </button>
                        <a href="{{ route('admin.assets.assets.index') }}" class="btn btn-secondary">Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list me-1"></i>Asset List</h5>
            <span class="text-muted">Total: {{ $items->total() }}</span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">ID</th>
                            <th>Asset Code</th>
                            <th>Asset Name</th>
                            <th>Category</th>
                            <th>Asset Type</th>
                            <th>Serial Number</th>
                            <th>Unit</th>
                            <th>Status</th>
                            <th width="220">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>

                            <td>
                                <a href="{{ route('admin.assets.assets.show', $item->id) }}"
                                   class="text-decoration-none fw-semibold">
                                    {{ $item->asset_code ?: '-' }}
                                </a>
                            </td>

                            <td>{{ \Illuminate\Support\Str::limit((string)$item->asset_name, 50) ?: '-' }}</td>

                            <td>
                                {{ optional($item->assetCategory)->category_name
                                    ?? optional($item->category)->category_name
                                    ?? $item->asset_category
                                    ?? '-' }}
                            </td>

                            <td>{{ $item->asset_type ?: '-' }}</td>
                            <td>{{ $item->serial_number ?: '-' }}</td>

                            <td>
                                {{ optional($item->unit)->unit_no
                                    ?? optional($item->unit)->name
                                    ?? $item->unit_id
                                    ?? '-' }}
                            </td>

                            <td>
                                @php
                                    $successStatuses = ['Active', 'Completed', 'Paid', 'Resolved', 'Operational'];
                                    $status = (string)$item->status;
                                @endphp
                                <span class="badge {{ in_array($status, $successStatuses, true) ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $status ?: 'N/A' }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('admin.assets.assets.show', $item->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> View
                                </a>

                                @can('assets.edit')
                                    <a href="{{ route('admin.assets.assets.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                @endcan

                                @can('assets.delete')
                                    <form method="POST"
                                          action="{{ route('admin.assets.assets.destroy', $item->id) }}"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this asset?')">
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
                            <td colspan="9" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-box-open fa-2x mb-2"></i>
                                    <div>No assets found.</div>
                                </div>
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
