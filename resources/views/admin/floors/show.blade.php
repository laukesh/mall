@extends('layouts.app')

@section('title', $floor->floor_name)

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="h3 mb-1">
                {{ $floor->floor_name }}
            </h1>

            <p class="text-muted mb-0">
                {{ $floor->floor_code }}
            </p>

        </div>

        <div>

            <a
                href="{{ route('admin.floors.edit', $floor->id) }}"
                class="btn btn-primary"
            >
                Edit
            </a>

            <a
                href="{{ route('admin.floors.index') }}"
                class="btn btn-secondary"
            >
                ← Back
            </a>

        </div>

    </div>


    <div class="card mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Floor Information
            </h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <strong>Floor ID</strong>
                    <div>{{ $floor->id }}</div>
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Building</strong>

                    <div>
                        {{ $floor->building->building_name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Floor Code</strong>
                    <div>{{ $floor->floor_code }}</div>
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Floor Name</strong>
                    <div>{{ $floor->floor_name }}</div>
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Floor Number</strong>
                    <div>{{ $floor->floor_number }}</div>
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Status</strong>

                    <div>

                        @if($floor->status === 'active')

                            <span class="badge bg-success">
                                Active
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                {{ ucfirst($floor->status) }}
                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Audit --}}
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
                        {{ $floor->creator->name ?? $floor->created_by ?? '-' }}
                    </div>
                </div>

                <div class="col-md-3">
                    <strong>Updated By</strong>

                    <div>
                        {{ $floor->updater->name ?? $floor->updated_by ?? '-' }}
                    </div>
                </div>

                <div class="col-md-3">
                    <strong>Created At</strong>

                    <div>
                        {{ $floor->created_at?->format('d M Y H:i') ?? '-' }}
                    </div>
                </div>

                <div class="col-md-3">
                    <strong>Updated At</strong>

                    <div>
                        {{ $floor->updated_at?->format('d M Y H:i') ?? '-' }}
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection