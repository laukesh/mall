@extends('layouts.app')

@section('title', 'Floors')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">Floors</h1>
            <p class="text-muted mb-0">
                Manage building floors.
            </p>
        </div>

        <a
            href="{{ route('admin.floors.create') }}"
            class="btn btn-primary"
        >
            + Add Floor
        </a>

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
                action="{{ route('admin.floors.index') }}"
            >

                <div class="row g-2">

                    <div class="col-md-8">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search floor code or name..."
                            value="{{ request('search') }}"
                        >

                    </div>

                    <div class="col-md-4">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Search
                        </button>

                        @if(request('search'))

                            <a
                                href="{{ route('admin.floors.index') }}"
                                class="btn btn-secondary"
                            >
                                Clear
                            </a>

                        @endif

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Table --}}
    <div class="card">

        <div class="card-header">
            <h5 class="mb-0">
                Floor List
            </h5>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover table-bordered mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>ID</th>
                            <th>Building</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Floor No.</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($floors as $floor)

                            <tr>

                                <td>
                                    {{ $floor->id }}
                                </td>

                                <td>
                                    {{ $floor->building->building_name ?? '-' }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $floor->floor_code }}
                                    </strong>
                                </td>

                                <td>
                                    <a
                                        href="{{ route('admin.floors.show', $floor->id) }}"
                                    >
                                        {{ $floor->floor_name }}
                                    </a>
                                </td>

                                <td>
                                    {{ $floor->floor_number }}
                                </td>

                                <td>

                                    @if($floor->status === 'active')

                                        <span class="badge bg-success">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ ucfirst($floor->status) }}
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <a
                                        href="{{ route('admin.floors.show', $floor->id) }}"
                                        class="btn btn-sm btn-info"
                                    >
                                        View
                                    </a>

                                    <a
                                        href="{{ route('admin.floors.edit', $floor->id) }}"
                                        class="btn btn-sm btn-primary"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.floors.destroy', $floor->id) }}"
                                        method="POST"
                                        class="d-inline"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this floor?')"
                                        >
                                            Delete
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="7"
                                    class="text-center py-4"
                                >
                                    No floors found.
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