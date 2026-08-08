@extends('layouts.app')

@section('title', $mall->mall_name)

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                {{ $mall->mall_name }}
            </h1>

            <p class="text-muted mb-0">
                Mall Code: {{ $mall->mall_code }}
            </p>
        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('admin.malls.edit', $mall->id) }}"
                class="btn btn-primary"
            >
                Edit Mall
            </a>

            <a
                href="{{ route('admin.malls.index') }}"
                class="btn btn-secondary"
            >
                ← Back to Malls
            </a>

        </div>

    </div>


    {{-- Basic Information --}}
    <div class="card mb-4">

        <div class="card-header">
            <h5 class="mb-0">Basic Information</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Mall ID</label>
                    <div>{{ $mall->id }}</div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Mall Code</label>
                    <div>{{ $mall->mall_code }}</div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Mall Name</label>
                    <div>{{ $mall->mall_name }}</div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Mall Type</label>
                    <div>{{ $mall->mall_type ?? '-' }}</div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Opening Date</label>
                    <div>
                        {{ $mall->opening_date
                            ? \Carbon\Carbon::parse($mall->opening_date)->format('d M Y')
                            : '-' }}
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Status</label>
                    <div>
                        @if($mall->status === 'active')
                            <span class="badge bg-success">
                                Active
                            </span>
                        @elseif($mall->status === 'inactive')
                            <span class="badge bg-secondary">
                                Inactive
                            </span>
                        @else
                            <span class="badge bg-warning text-dark">
                                {{ ucfirst($mall->status ?? 'Unknown') }}
                            </span>
                        @endif
                    </div>
                </div>

            </div>

        </div>

    </div>


    {{-- Address Information --}}
    <div class="card mb-4">

        <div class="card-header">
            <h5 class="mb-0">Address Information</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">
                        Address Line 1
                    </label>

                    <div>
                        {{ $mall->address_line1 ?? '-' }}
                    </div>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="fw-bold">
                        Address Line 2
                    </label>

                    <div>
                        {{ $mall->address_line2 ?? '-' }}
                    </div>
                </div>


                <div class="col-md-4 mb-3">
                    <label class="fw-bold">
                        City
                    </label>

                    <div>
                        {{ $mall->city ?? '-' }}
                    </div>
                </div>


                <div class="col-md-4 mb-3">
                    <label class="fw-bold">
                        State
                    </label>

                    <div>
                        {{ $mall->state ?? '-' }}
                    </div>
                </div>


                <div class="col-md-4 mb-3">
                    <label class="fw-bold">
                        Country
                    </label>

                    <div>
                        {{ $mall->country ?? '-' }}
                    </div>
                </div>


                <div class="col-md-4 mb-3">
                    <label class="fw-bold">
                        Postal Code
                    </label>

                    <div>
                        {{ $mall->postal_code ?? '-' }}
                    </div>
                </div>

            </div>

        </div>

    </div>


    {{-- Location --}}
    <div class="card mb-4">

        <div class="card-header">
            <h5 class="mb-0">Location</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">
                        Latitude
                    </label>

                    <div>
                        {{ $mall->latitude ?? '-' }}
                    </div>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="fw-bold">
                        Longitude
                    </label>

                    <div>
                        {{ $mall->longitude ?? '-' }}
                    </div>
                </div>

            </div>

        </div>

    </div>


    {{-- Area & Capacity --}}
    <div class="card mb-4">

        <div class="card-header">
            <h5 class="mb-0">Area & Capacity</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="fw-bold">
                        Total Area
                    </label>

                    <div>
                        {{ $mall->total_area ?? '-' }}
                    </div>
                </div>


                <div class="col-md-4 mb-3">
                    <label class="fw-bold">
                        Leasable Area
                    </label>

                    <div>
                        {{ $mall->leasable_area ?? '-' }}
                    </div>
                </div>


                <div class="col-md-4 mb-3">
                    <label class="fw-bold">
                        Parking Capacity
                    </label>

                    <div>
                        {{ $mall->parking_capacity ?? '-' }}
                    </div>
                </div>

            </div>

        </div>

    </div>


    {{-- Contact Information --}}
    <div class="card mb-4">

        <div class="card-header">
            <h5 class="mb-0">Contact Information</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">
                        Contact Person
                    </label>

                    <div>
                        {{ $mall->contact_person ?? '-' }}
                    </div>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="fw-bold">
                        Contact Number
                    </label>

                    <div>
                        {{ $mall->contact_number ?? '-' }}
                    </div>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="fw-bold">
                        Email
                    </label>

                    <div>
                        @if($mall->email)
                            <a href="mailto:{{ $mall->email }}">
                                {{ $mall->email }}
                            </a>
                        @else
                            -
                        @endif
                    </div>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="fw-bold">
                        Website
                    </label>

                    <div>
                        @if($mall->website)
                            <a
                                href="{{ $mall->website }}"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                {{ $mall->website }}
                            </a>
                        @else
                            -
                        @endif
                    </div>
                </div>

            </div>

        </div>

    </div>


    {{-- Audit Information --}}
    <div class="card mb-4">

        <div class="card-header">
            <h5 class="mb-0">Audit Information</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-3 mb-3">
                    <label class="fw-bold">
                        Created By
                    </label>

                    <div>
                        {{ $mall->created_by ?? '-' }}
                    </div>
                </div>


                <div class="col-md-3 mb-3">
                    <label class="fw-bold">
                        Updated By
                    </label>

                    <div>
                        {{ $mall->updated_by ?? '-' }}
                    </div>
                </div>


                <div class="col-md-3 mb-3">
                    <label class="fw-bold">
                        Created At
                    </label>

                    <div>
                        {{ $mall->created_at
                            ? $mall->created_at->format('d M Y H:i')
                            : '-' }}
                    </div>
                </div>


                <div class="col-md-3 mb-3">
                    <label class="fw-bold">
                        Updated At
                    </label>

                    <div>
                        {{ $mall->updated_at
                            ? $mall->updated_at->format('d M Y H:i')
                            : '-' }}
                    </div>
                </div>

            </div>

        </div>

    </div>


    {{-- Deleted Information --}}
    @if($mall->deleted_at)

        <div class="alert alert-warning">

            <strong>Deleted:</strong>

            {{ $mall->deleted_at->format('d M Y H:i') }}

        </div>

    @endif


    {{-- Bottom Actions --}}
    <div class="d-flex justify-content-end gap-2 mb-4">

        <a
            href="{{ route('admin.malls.index') }}"
            class="btn btn-secondary"
        >
            Back to Malls
        </a>

        <a
            href="{{ route('admin.malls.edit', $mall->id) }}"
            class="btn btn-primary"
        >
            Edit Mall
        </a>

    </div>

</div>

@endsection