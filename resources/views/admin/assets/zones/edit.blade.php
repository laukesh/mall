@extends('layouts.app')

@section('title', 'Edit Zone')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">Edit Zone</h1>

            <p class="text-muted">
                Update zone information.
            </p>
        </div>

        <a
            href="{{ route('admin.zones.index') }}"
            class="btn btn-secondary"
        >
            ← Back
        </a>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <div class="card">

        <div class="card-header">
            <h5 class="mb-0">
                Zone Information
            </h5>
        </div>

        <div class="card-body">

            <form
                method="POST"
                action="{{ route('admin.zones.update', $zone->id) }}"
            >

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Floor --}}
                    <div class="col-md-6 mb-3">

                        <label
                            for="floor_id"
                            class="form-label"
                        >
                            Floor
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="floor_id"
                            id="floor_id"
                            class="form-select"
                            required
                        >

                            @foreach($floors as $floor)

                                <option
                                    value="{{ $floor->id }}"
                                    {{ old('floor_id', $zone->floor_id) == $floor->id ? 'selected' : '' }}
                                >
                                    {{ $floor->building->building_name ?? 'Building' }}
                                    -
                                    {{ $floor->floor_name }}
                                    ({{ $floor->floor_code }})
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Zone Code --}}
                    <div class="col-md-6 mb-3">

                        <label
                            for="zone_code"
                            class="form-label"
                        >
                            Zone Code
                        </label>

                        <input
                            type="text"
                            name="zone_code"
                            id="zone_code"
                            class="form-control"
                            value="{{ old('zone_code', $zone->zone_code) }}"
                            required
                        >

                    </div>


                    {{-- Zone Name --}}
                    <div class="col-md-6 mb-3">

                        <label
                            for="zone_name"
                            class="form-label"
                        >
                            Zone Name
                        </label>

                        <input
                            type="text"
                            name="zone_name"
                            id="zone_name"
                            class="form-control"
                            value="{{ old('zone_name', $zone->zone_name) }}"
                            required
                        >

                    </div>


                    {{-- Status --}}
                    <div class="col-md-6 mb-3">

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
                            required
                        >

                            <option
                                value="1"
                                {{ old('status', $zone->status) === '1' ? 'selected' : '' }}
                            >
                                Active
                            </option>

                            <option
                                value="0"
                                {{ old('status', $zone->status) === '0' ? 'selected' : '' }}
                            >
                                Inactive
                            </option>

                        </select>

                    </div>


                    {{-- Description --}}
                    <div class="col-md-12 mb-3">

                        <label
                            for="description"
                            class="form-label"
                        >
                            Description
                        </label>

                        <textarea
                            name="description"
                            id="description"
                            rows="4"
                            class="form-control"
                        >{{ old('description', $zone->description) }}</textarea>

                    </div>

                </div>


                <div class="d-flex justify-content-end gap-2">

                    <a
                        href="{{ route('admin.zones.show', $zone->id) }}"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Update Zone
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection