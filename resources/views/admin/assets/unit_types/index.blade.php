@extends('layouts.app')

@section('title', 'Unit Types')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">Unit Types</h1>

            <p class="text-muted mb-0">
                Manage mall unit types.
            </p>
        </div>

        @can('unit_types.create')

            <a
                href="{{ route('admin.unit-types.create') }}"
                class="btn btn-primary"
            >
                + Add Unit Type
            </a>

        @endcan

    </div>


    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- Search --}}
    <div class="card mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('admin.unit-types.index') }}"
            >

                <div class="row g-2">

                    <div class="col-md-7">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search unit type..."
                            value="{{ request('search') }}"
                        >

                    </div>


                    <div class="col-md-3">

                        <select
                            name="status"
                            class="form-select"
                        >

                            <option value="">
                                All Status
                            </option>

                            <option
                                value="active"
                                {{ request('status') === 'active' ? 'selected' : '' }}
                            >
                                Active
                            </option>

                            <option
                                value="inactive"
                                {{ request('status') === 'inactive' ? 'selected' : '' }}
                            >
                                Inactive
                            </option>

                        </select>

                    </div>


                    <div class="col-md-2">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Search
                        </button>

                        <a
                            href="{{ route('admin.unit-types.index') }}"
                            class="btn btn-secondary"
                        >
                            Clear
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Table --}}
    <div class="card">

        <div class="card-header">

            <h5 class="mb-0">
                Unit Type List
            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered table-hover mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>ID</th>
                            <th>Type Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($unitTypes as $unitType)

                        <tr>

                            <td>
                                {{ $unitType->id }}
                            </td>

                            <td>

                                <a
                                    href="{{ route(
                                        'admin.unit-types.show',
                                        $unitType->id
                                    ) }}"
                                >
                                    <strong>
                                        {{ $unitType->type_name }}
                                    </strong>
                                </a>

                            </td>

                            <td>

                                {{ \Illuminate\Support\Str::limit(
                                    $unitType->description,
                                    70
                                ) ?: '-' }}

                            </td>

                            <td>

                                @if($unitType->status === 'active')

                                    <span class="badge bg-success">
                                        Active
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        {{ ucfirst($unitType->status) }}
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $unitType->creator->name ?? '-' }}
                            </td>

                            <td>
                                {{ $unitType->updater->name ?? '-' }}
                            </td>

                            <td>

                                <a
                                    href="{{ route(
                                        'admin.unit-types.show',
                                        $unitType->id
                                    ) }}"
                                    class="btn btn-sm btn-info"
                                >
                                    View
                                </a>


                                @can('unit_types.edit')

                                    <a
                                        href="{{ route(
                                            'admin.unit-types.edit',
                                            $unitType->id
                                        ) }}"
                                        class="btn btn-sm btn-primary"
                                    >
                                        Edit
                                    </a>

                                @endcan


                                @can('unit_types.delete')

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.unit-types.destroy',
                                            $unitType->id
                                        ) }}"
                                        class="d-inline"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this unit type?')"
                                        >
                                            Delete
                                        </button>

                                    </form>

                                @endcan

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-4"
                            >
                                No unit types found.
                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection