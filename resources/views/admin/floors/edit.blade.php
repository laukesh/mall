@extends('layouts.app')

@section('title', 'Edit Floor')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">Edit Floor</h1>

            <p class="text-muted mb-0">
                Update floor information.
            </p>
        </div>

        <a
            href="{{ route('admin.floors.index') }}"
            class="btn btn-secondary"
        >
            ← Back
        </a>

    </div>


    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Please fix the following errors:</strong>

            <ul class="mb-0 mt-2">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <div class="card">

        <div class="card-header">
            <h5 class="mb-0">
                Floor Information
            </h5>
        </div>

        <div class="card-body">

            <form
                method="POST"
                action="{{ route('admin.floors.update', $floor->id) }}"
            >

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Building --}}
                    <div class="col-md-6 mb-3">

                        <label
                            for="building_id"
                            class="form-label"
                        >
                            Building
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="building_id"
                            id="building_id"
                            class="form-select"
                            required
                        >

                            @foreach($buildings as $id => $name)

                                <option
                                    value="{{ $id }}"
                                    {{ old('building_id', $floor->building_id) == $id ? 'selected' : '' }}
                                >
                                    {{ $name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Floor Code --}}
                    <div class="col-md-6 mb-3">

                        <label
                            for="floor_code"
                            class="form-label"
                        >
                            Floor Code
                        </label>

                        <input
                            type="text"
                            name="floor_code"
                            id="floor_code"
                            class="form-control"
                            value="{{ old('floor_code', $floor->floor_code) }}"
                            required
                        >

                    </div>


                    {{-- Floor Name --}}
                    <div class="col-md-6 mb-3">

                        <label
                            for="floor_name"
                            class="form-label"
                        >
                            Floor Name
                        </label>

                        <input
                            type="text"
                            name="floor_name"
                            id="floor_name"
                            class="form-control"
                            value="{{ old('floor_name', $floor->floor_name) }}"
                            required
                        >

                    </div>


                    {{-- Floor Number --}}
                    <div class="col-md-6 mb-3">

                        <label
                            for="floor_number"
                            class="form-label"
                        >
                            Floor Number
                        </label>

                        <input
                            type="number"
                            name="floor_number"
                            id="floor_number"
                            class="form-control"
                            value="{{ old('floor_number', $floor->floor_number) }}"
                            min="0"
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
                                {{ old('status', $floor->status) === '1' ? 'selected' : '' }}
                            >
                                Active
                            </option>

                            <option
                                value="0"
                                {{ old('status', $floor->status) === '0' ? 'selected' : '' }}
                            >
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>


                <div class="d-flex justify-content-end gap-2 mt-3">

                    <a
                        href="{{ route('admin.floors.show', $floor->id) }}"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Update Floor
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection