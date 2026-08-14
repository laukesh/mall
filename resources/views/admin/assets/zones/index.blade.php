@extends('layouts.app')

@section('title', 'Zones')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">Zones</h1>

            <p class="text-muted mb-0">
                Manage floor zones.
            </p>
        </div>

        @can('zones.create')
            <a
                href="{{ route('admin.assets.zones.create') }}"
                class="btn btn-primary"
            >
                + Add Zone
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
                action="{{ route('admin.assets.zones.index') }}"
            >

                <div class="row g-2">

                    <div class="col-md-8">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search zone code or name..."
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

                        <a
                            href="{{ route('admin.assets.zones.index') }}"
                            class="btn btn-secondary"
                        >
                            Clear
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Zone Table --}}
    <div class="card">

        <div class="card-header">

            <h5 class="mb-0">
                Zone List
            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover table-bordered mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>ID</th>
                            <th>Floor</th>
                            <th>Zone Code</th>
                            <th>Zone Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($zones as $zone)

                        <tr>

                            <td>
                                {{ $zone->id }}
                            </td>

                            <td>

                                {{ $zone->floor->floor_name ?? '-' }}

                                @if($zone->floor?->building)

                                    <small class="text-muted d-block">
                                        {{ $zone->floor->building->building_name }}
                                    </small>

                                @endif

                            </td>

                            <td>
                                <strong>
                                    {{ $zone->zone_code }}
                                </strong>
                            </td>

                            <td>

                                <a
                                    href="{{ route('admin.assets.zones.show', $zone->id) }}"
                                >
                                    {{ $zone->zone_name }}
                                </a>

                            </td>

                            <td>
                                {{ \Illuminate\Support\Str::limit(
                                    $zone->description,
                                    50
                                ) ?: '-' }}
                            </td>

                            <td>

                                @if($zone->status === 'active')

                                    <span class="badge bg-success">
                                        Active
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        {{ ucfirst($zone->status) }}
                                    </span>

                                @endif

                            </td>

                            <td>

                                <a
                                    href="{{ route('admin.assets.zones.show', $zone->id) }}"
                                    class="btn btn-sm btn-info"
                                >
                                    View
                                </a>

                                @can('zones.edit')

                                    <a
                                        href="{{ route('admin.assets.zones.edit', $zone->id) }}"
                                        class="btn btn-sm btn-primary"
                                    >
                                        Edit
                                    </a>

                                @endcan


                                @can('zones.delete')

                                    <form
                                        method="POST"
                                        action="{{ route('admin.assets.zones.destroy', $zone->id) }}"
                                        class="d-inline"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this zone?')"
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
                                No zones found.
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