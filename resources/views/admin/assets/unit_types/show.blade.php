@extends('layouts.app')

@section('title', $unitType->type_name)

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="h3 mb-1">
                {{ $unitType->type_name }}
            </h1>

            <p class="text-muted mb-0">
                Unit Type #{{ $unitType->id }}
            </p>

        </div>

        <div>

            @can('unit_types.edit')

                <a
                    href="{{ route(
                        'admin.assets.unit-types.edit',
                        $unitType->id
                    ) }}"
                    class="btn btn-primary"
                >
                    Edit
                </a>

            @endcan

            <a
                href="{{ route('admin.assets.unit-types.index') }}"
                class="btn btn-secondary"
            >
                ← Back
            </a>

        </div>

    </div>


    <div class="card mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Unit Type Information
            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <strong>ID</strong>

                    <div>
                        {{ $unitType->id }}
                    </div>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>Type Name</strong>

                    <div>
                        {{ $unitType->type_name }}
                    </div>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>Status</strong>

                    <div>

                        @if($unitType->status === 'active')

                            <span class="badge bg-success">
                                Active
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                {{ ucfirst($unitType->status) }}
                            </span>

                        @endif

                    </div>

                </div>


                <div class="col-md-12 mb-3">

                    <strong>Description</strong>

                    <div>
                        {{ $unitType->description ?: '-' }}
                    </div>

                </div>

            </div>

        </div>

    </div>


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
                        {{ $unitType->creator->name ?? '-' }}
                    </div>

                </div>


                <div class="col-md-3">

                    <strong>Updated By</strong>

                    <div>
                        {{ $unitType->updater->name ?? '-' }}
                    </div>

                </div>


                <div class="col-md-3">

                    <strong>Created At</strong>

                    <div>
                        {{ $unitType->created_at?->format(
                            'd M Y H:i'
                        ) ?? '-' }}
                    </div>

                </div>


                <div class="col-md-3">

                    <strong>Updated At</strong>

                    <div>
                        {{ $unitType->updated_at?->format(
                            'd M Y H:i'
                        ) ?? '-' }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection