@extends('layouts.app')

@section('title', 'Malls')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Malls</h1>
            <p class="text-muted mb-0">
                Manage all registered malls.
            </p>
        </div>

        <a href="{{ route('admin.malls.create') }}" class="btn btn-primary">
            + Add Mall
        </a>
    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
            </button>
        </div>
    @endif


    {{-- Error Message --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
            </button>
        </div>
    @endif


    {{-- Search --}}
    <div class="card mb-4">
        <div class="card-body">

            <form
                method="GET"
                action="{{ route('admin.malls.index') }}"
            >
                <div class="row g-2">

                    <div class="col-md-8">
                        <label for="search" class="form-label">
                            Search Mall
                        </label>

                        <input
                            type="text"
                            name="search"
                            id="search"
                            class="form-control"
                            placeholder="Search by code, name, city, type..."
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="col-md-4 d-flex align-items-end gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Search
                        </button>

                        @if(request('search'))
                            <a
                                href="{{ route('admin.malls.index') }}"
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


    {{-- Mall Table --}}
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Mall List
            </h5>

            <span class="text-muted">
                {{ $malls->count() }} mall(s)
            </span>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover table-bordered mb-0">

                    <thead class="table-light">

                        <tr>
                            <th width="70">ID</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th width="180">Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($malls as $mall)

                            <tr>

                                {{-- ID --}}
                                <td>
                                    {{ $mall->id }}
                                </td>


                                {{-- Code --}}
                                <td>
                                    <strong>
                                        {{ $mall->mall_code }}
                                    </strong>
                                </td>


                                {{-- Name --}}
                                <td>
                                    <a
                                        href="{{ route('admin.malls.show', $mall->id) }}"
                                        class="text-decoration-none"
                                    >
                                        {{ $mall->mall_name }}
                                    </a>
                                </td>


                                {{-- Type --}}
                                <td>
                                    {{ $mall->mall_type ?? '-' }}
                                </td>


                                {{-- City --}}
                                <td>
                                    {{ $mall->city ?? '-' }}
                                </td>


                                {{-- Country --}}
                                <td>
                                    {{ $mall->country ?? '-' }}
                                </td>


                                {{-- Contact --}}
                                <td>
                                    {{ $mall->contact_number ?? '-' }}
                                </td>


                                {{-- Status --}}
                                <td>

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

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="d-flex gap-1">

                                        {{-- View --}}
                                        <a
                                            href="{{ route('admin.malls.show', $mall->id) }}"
                                            class="btn btn-sm btn-info"
                                        >
                                            View
                                        </a>


                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('admin.malls.edit', $mall->id) }}"
                                            class="btn btn-sm btn-primary"
                                        >
                                            Edit
                                        </a>


                                        {{-- Delete --}}
                                        <form
                                            method="POST"
                                            action="{{ route('admin.malls.destroy', $mall->id) }}"
                                            class="d-inline"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this mall?')"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="9"
                                    class="text-center py-4"
                                >
                                    <div class="text-muted">
                                        No malls found.
                                    </div>

                                    @if(request('search'))
                                        <a
                                            href="{{ route('admin.malls.index') }}"
                                            class="btn btn-sm btn-secondary mt-2"
                                        >
                                            Clear Search
                                        </a>
                                    @endif
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