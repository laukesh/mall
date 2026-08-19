@extends('layouts.app')

@section('title', $status->status_name)

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                {{ $status->status_name }}
            </h1>

            <p class="text-muted mb-0">
                Unit Status #{{ $status->id }}
            </p>
        </div>

        <div>

            @can('unit_statuses.edit')

                <a
                    href="{{ route(
                        'admin.assets.unit-statuses.edit',
                        $status->id
                    ) }}"
                    class="btn btn-primary"
                >
                    Edit
                </a>

            @endcan

            <a
                href="{{ route('admin.assets.unit-statuses.index') }}"
                class="btn btn-secondary"
            >
                ← Back
            </a>

        </div>

    </div>


    {{-- Unit Status Information --}}
    <div class="card mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Unit Status Information
            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                {{-- ID --}}
                <div class="col-md-4 mb-3">

                    <strong>ID</strong>

                    <div>
                        {{ $status->id }}
                    </div>

                </div>


                {{-- Status Name --}}
                <div class="col-md-4 mb-3">

                    <strong>Status Name</strong>

                    <div>
                        {{ $status->status_name }}
                    </div>

                </div>


                {{-- Active Status --}}
                <div class="col-md-4 mb-3">

                    <strong>Status</strong>

                    <div>

                        @if($status->is_active)

                            <span class="badge bg-success">
                                Active
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                Inactive
                            </span>

                        @endif

                    </div>

                </div>


                {{-- Color --}}
                <div class="col-md-6 mb-3">

                    <strong>Color</strong>

                    <div class="d-flex align-items-center mt-1">

                        @if($status->color_code)

                            <span
                                style="
                                    display:inline-block;
                                    width:30px;
                                    height:30px;
                                    background-color: {{ $status->color_code }};
                                    border:1px solid #ccc;
                                    border-radius:5px;
                                    margin-right:10px;
                                "
                                title="{{ $status->color_code }}"
                            ></span>

                            <code>
                                {{ $status->color_code }}
                            </code>

                        @else

                            <span class="text-muted">
                                -
                            </span>

                        @endif

                    </div>

                </div>


                {{-- Sort Order --}}
                <div class="col-md-6 mb-3">

                    <strong>Sort Order</strong>

                    <div>
                        <span class="badge bg-light text-dark">
                            {{ $status->sort_order }}
                        </span>
                    </div>

                </div>


                {{-- Description --}}
                <div class="col-md-12 mb-3">

                    <strong>Description</strong>

                    <div class="mt-1">

                        {{ $status->description ?: '-' }}

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

                {{-- Created By --}}
                <div class="col-md-3 mb-3">

                    <strong>Created By</strong>

                    <div>
                        {{ $status->creator->name ?? '-' }}
                    </div>

                </div>


                {{-- Updated By --}}
                <div class="col-md-3 mb-3">

                    <strong>Updated By</strong>

                    <div>
                        {{ $status->updater->name ?? '-' }}
                    </div>

                </div>


                {{-- Created At --}}
                <div class="col-md-3 mb-3">

                    <strong>Created At</strong>

                    <div>
                        {{ $status->created_at?->format('d M Y H:i') ?? '-' }}
                    </div>

                </div>


                {{-- Updated At --}}
                <div class="col-md-3 mb-3">

                    <strong>Updated At</strong>

                    <div>
                        {{ $status->updated_at?->format('d M Y H:i') ?? '-' }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection