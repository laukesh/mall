@extends('layouts.app')

@section('title', $zone->zone_name)

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="h3 mb-1">
                {{ $zone->zone_name }}
            </h1>

            <p class="text-muted mb-0">
                Zone Code: {{ $zone->zone_code }}
            </p>

        </div>

        <div>

            @can('zones.edit')

                <a
                    href="{{ route('admin.zones.edit', $zone->id) }}"
                    class="btn btn-primary"
                >
                    Edit
                </a>

            @endcan

            <a
                href="{{ route('admin.zones.index') }}"
                class="btn btn-secondary"
            >
                ← Back
            </a>

        </div>

    </div>


    {{-- Zone Information --}}
    <div class="card mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Zone Information
            </h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <strong>Zone ID</strong>

                    <div>
                        {{ $zone->id }}
                    </div>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>Zone Code</strong>

                    <div>
                        {{ $zone->zone_code }}
                    </div>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>Zone Name</strong>

                    <div>
                        {{ $zone->zone_name }}
                    </div>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>Floor</strong>

                    <div>

                        {{ $zone->floor->floor_name ?? '-' }}

                        @if($zone->floor)

                            <small class="text-muted d-block">
                                {{ $zone->floor->floor_code }}
                            </small>

                        @endif

                    </div>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>Building</strong>

                    <div>

                        {{ $zone->floor?->building?->building_name ?? '-' }}

                    </div>

                </div>


                <div class="col-md-12 mb-3">

                    <strong>Description</strong>

                    <div>
                        {{ $zone->description ?: '-' }}
                    </div>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>Status</strong>

                    <div>

                        @if($zone->status === 'active')

                            <span class="badge bg-success">
                                Active
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                {{ ucfirst($zone->status) }}
                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Audit Information --}}
    <div class="card">

        <div class="card-header">

            <h5 class="mb-0">
                Audit Information
            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-3">

                    <strong>Created By</strong>

                    <div>
                        {{ $zone->creator->name ?? $zone->created_by ?? '-' }}
                    </div>

                </div>


                <div class="col-md-3">

                    <strong>Updated By</strong>

                    <div>
                        {{ $zone->updater->name ?? $zone->updated_by ?? '-' }}
                    </div>

                </div>


                <div class="col-md-3">

                    <strong>Created At</strong>

                    <div>
                        {{ $zone->created_at?->format('d M Y H:i') ?? '-' }}
                    </div>

                </div>


                <div class="col-md-3">

                    <strong>Updated At</strong>

                    <div>
                        {{ $zone->updated_at?->format('d M Y H:i') ?? '-' }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection