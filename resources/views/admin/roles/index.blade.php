@extends('layouts.app')

@section('title', 'Roles')

@section('content')

<div class="container-fluid">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">
                <i class="fas fa-user-shield me-2"></i>
                Roles
            </h4>

            <div class="text-muted">
                Manage roles and their assigned permissions.
            </div>
        </div>

        <div>
            <a href="{{ route('admin.roles.create') }}"
               class="btn btn-primary">

                <i class="fas fa-plus me-1"></i>
                Create Role

            </a>
        </div>

    </div>


    {{-- =========================================================
        SUCCESS MESSAGE
    ========================================================== --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show"
             role="alert">

            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- =========================================================
        ERROR MESSAGE
    ========================================================== --}}
    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show"
             role="alert">

            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- =========================================================
        ROLES TABLE
    ========================================================== --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h6 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Role List
                    </h6>

                    <small class="text-muted">
                        Manage application roles and permissions.
                    </small>

                </div>

                <span class="badge bg-secondary">
                    {{ $roles->total() }} Roles
                </span>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th width="80">ID</th>

                            <th>Role Name</th>

                            <th>Permissions</th>

                            <th width="180" class="text-center">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($roles as $role)

                        <tr>

                            {{-- ID --}}
                            <td>

                                <span class="badge bg-light text-dark border">
                                    #{{ $role->id }}
                                </span>

                            </td>


                            {{-- Role Name --}}
                            <td>

                                <div class="d-flex align-items-center">

                                    <div class="rounded-circle bg-primary text-white
                                                d-flex align-items-center justify-content-center
                                                me-2"
                                         style="width:38px;height:38px;">

                                        <i class="fas fa-user-shield"></i>

                                    </div>

                                    <div>

                                        <div class="fw-semibold">
                                            {{ $role->name }}
                                        </div>

                                        <small class="text-muted">
                                            Role ID: {{ $role->id }}
                                        </small>

                                    </div>

                                </div>

                            </td>


                            {{-- Permissions --}}
                            <td>

                                @forelse($role->permissions as $permission)

                                    <span class="badge bg-info-subtle text-info me-1 mb-1">
                                        {{ $permission->name }}
                                    </span>

                                @empty

                                    <span class="text-muted">
                                        No permissions assigned
                                    </span>

                                @endforelse

                            </td>


                            {{-- Actions --}}
                            <td class="text-center">

                                <div class="d-inline-flex gap-1">

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.roles.edit', $role->id) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Edit Role">

                                        <i class="fas fa-edit"></i>

                                    </a>


                                    {{-- Delete --}}
                                    <form method="POST"
                                          action="{{ route('admin.roles.destroy', $role->id) }}"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete the role &quot;{{ $role->name }}&quot;?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Delete Role">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4"
                                class="text-center py-5">

                                <div class="text-muted">

                                    <i class="fas fa-user-shield fa-3x mb-3"></i>

                                    <h6>No Roles Found</h6>

                                    <p class="mb-3">
                                        No roles have been created yet.
                                    </p>

                                    <a href="{{ route('admin.roles.create') }}"
                                       class="btn btn-primary btn-sm">

                                        <i class="fas fa-plus me-1"></i>
                                        Create First Role

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =========================================================
            PAGINATION
        ========================================================== --}}
        @if($roles->hasPages())

            <div class="card-footer bg-white">

                <div class="d-flex justify-content-between align-items-center">

                    <div class="text-muted small">

                        Showing
                        <strong>{{ $roles->firstItem() }}</strong>
                        to
                        <strong>{{ $roles->lastItem() }}</strong>
                        of
                        <strong>{{ $roles->total() }}</strong>
                        roles

                    </div>

                    <div>
                        {{ $roles->links() }}
                    </div>

                </div>

            </div>

        @endif

    </div>

</div>

@endsection