@extends('layouts.app')

@section('title', 'Asset Details')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1"><i class="fas fa-box me-2"></i>Asset Details</h4>
            <div class="text-muted">View asset information.</div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.assets.assets.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>

            @can('assets.edit')
                <a href="{{ route('admin.assets.assets.edit', $item->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            @endcan
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Asset Information</h5>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-lg-6">
                    <dl class="row">
                        <dt class="col-sm-5">Asset Code</dt>
                        <dd class="col-sm-7">{{ $item->asset_code ?: '-' }}</dd>

                        <dt class="col-sm-5">Asset Name</dt>
                        <dd class="col-sm-7">{{ $item->asset_name ?: '-' }}</dd>

                        <dt class="col-sm-5">Category</dt>
                        <dd class="col-sm-7">
                            {{ optional($item->assetCategory)->category_name
                                ?? optional($item->category)->category_name
                                ?? $item->asset_category
                                ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Asset Type</dt>
                        <dd class="col-sm-7">{{ $item->asset_type ?: '-' }}</dd>

                        <dt class="col-sm-5">Serial Number</dt>
                        <dd class="col-sm-7">{{ $item->serial_number ?: '-' }}</dd>

                        <dt class="col-sm-5">Model Number</dt>
                        <dd class="col-sm-7">{{ $item->model_number ?: '-' }}</dd>

                        <dt class="col-sm-5">Manufacturer</dt>
                        <dd class="col-sm-7">{{ $item->manufacturer ?: '-' }}</dd>

                        <dt class="col-sm-5">Status</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-secondary">{{ $item->status ?: 'N/A' }}</span>
                        </dd>

                        <dt class="col-sm-5">Condition</dt>
                        <dd class="col-sm-7">{{ $item->conditions ?: '-' }}</dd>
                    </dl>
                </div>

                <div class="col-lg-6">
                    <dl class="row">
                        <dt class="col-sm-5">Unit</dt>
                        <dd class="col-sm-7">
                            {{ optional($item->unit)->unit_no ?? optional($item->unit)->name ?? $item->unit_id ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Building</dt>
                        <dd class="col-sm-7">
                            {{ optional($item->building)->building_name ?? optional($item->building)->name ?? $item->building_id ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Floor</dt>
                        <dd class="col-sm-7">
                            {{ optional($item->floor)->floor_name ?? optional($item->floor)->name ?? $item->floor_id ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Zone</dt>
                        <dd class="col-sm-7">
                            {{ optional($item->zone)->zone_name ?? optional($item->zone)->name ?? $item->zone_id ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Department</dt>
                        <dd class="col-sm-7">{{ $item->department_id ?? '-' }}</dd>

                        <dt class="col-sm-5">Assigned To</dt>
                        <dd class="col-sm-7">
                            {{ optional($item->assignee)->name ?? optional($item->assignedUser)->name ?? $item->assigned_to ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Vendor</dt>
                        <dd class="col-sm-7">
                            {{ optional($item->vendor)->name ?? $item->vendor_id ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Location</dt>
                        <dd class="col-sm-7">{{ $item->location_description ?: '-' }}</dd>
                    </dl>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-6">
                    <h6 class="fw-semibold mb-3">
                        <i class="fas fa-calendar-alt me-1"></i> Purchase & Installation
                    </h6>

                    <dl class="row">
                        <dt class="col-sm-5">Purchase Date</dt>
                        <dd class="col-sm-7">{{ $item->purchase_date ?: '-' }}</dd>

                        <dt class="col-sm-5">Installation Date</dt>
                        <dd class="col-sm-7">{{ $item->installation_date ?: '-' }}</dd>

                        <dt class="col-sm-5">Purchase Cost</dt>
                        <dd class="col-sm-7">
                            {{ $item->purchase_cost !== null ? number_format((float)$item->purchase_cost, 2) : '-' }}
                        </dd>

                        <dt class="col-sm-5">Useful Life</dt>
                        <dd class="col-sm-7">
                            {{ $item->useful_life_years !== null ? $item->useful_life_years . ' years' : '-' }}
                        </dd>
                    </dl>
                </div>

                <div class="col-lg-6">
                    <h6 class="fw-semibold mb-3">
                        <i class="fas fa-shield-alt me-1"></i> Warranty
                    </h6>

                    <dl class="row">
                        <dt class="col-sm-5">Warranty Start</dt>
                        <dd class="col-sm-7">{{ $item->warranty_start_date ?: '-' }}</dd>

                        <dt class="col-sm-5">Warranty End</dt>
                        <dd class="col-sm-7">{{ $item->warranty_end_date ?: '-' }}</dd>
                    </dl>
                </div>
            </div>

            <hr>

            <h6 class="fw-semibold mb-2">
                <i class="fas fa-comment-alt me-1"></i> Remarks
            </h6>

            <div class="border rounded p-3 bg-light">
                {{ $item->remarks ?: 'No remarks available.' }}
            </div>

        </div>
    </div>
</div>
@endsection
