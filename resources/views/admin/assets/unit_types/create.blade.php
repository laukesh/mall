@extends('layouts.app')

@section('title', 'Create Unit Type')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                Create Unit Type
            </h1>

            <p class="text-muted">
                Add a new unit type.
            </p>
        </div>

        <a
            href="{{ route('admin.assets.unit-types.index') }}"
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
                Unit Type Information
            </h5>
        </div>

        <div class="card-body">

            <form
                method="POST"
                action="{{ route('admin.assets.unit-types.store') }}"
            >

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label
                            for="type_name"
                            class="form-label"
                        >
                            Type Name
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="type_name"
                            id="type_name"
                            class="form-control @error('type_name') is-invalid @enderror"
                            value="{{ old('type_name') }}"
                            placeholder="e.g. Retail Shop"
                            required
                        >

                        @error('type_name')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-6 mb-3">

                        <label
                            for="status"
                            class="form-label"
                        >
                            Status
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="form-select"
                            required
                        >

                            <option
                                value="1"
                                {{ old('status', '1') === '1'
                                    ? 'selected'
                                    : '' }}
                            >
                                Active
                            </option>

                            <option
                                value="0"
                                {{ old('status', '0') === '0'
                                    ? 'selected'
                                    : '' }}
                            >
                                Inactive
                            </option>

                        </select>

                    </div>


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
                            placeholder="Enter description..."
                        >{{ old('description') }}</textarea>

                    </div>

                </div>


                <div class="d-flex justify-content-end gap-2">

                    <a
                        href="{{ route('admin.assets.unit-types.index') }}"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Create Unit Type
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection