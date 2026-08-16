@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')

<div class="container-fluid">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">
                <i class="fas fa-user-shield me-2"></i>
                Edit Role
            </h4>

            <div class="text-muted">
                Update role details and manage assigned permissions.
            </div>
        </div>

        <div>
            <a href="{{ route('admin.roles.index') }}"
               class="btn btn-outline-secondary">

                <i class="fas fa-arrow-left me-1"></i>
                Back to Roles

            </a>
        </div>

    </div>


    {{-- =========================================================
        VALIDATION ERRORS
    ========================================================== --}}
    @if($errors->any())

        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            <div class="fw-semibold mb-2">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Please correct the following errors:
            </div>

            <ul class="mb-0 ps-4">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- =========================================================
        EDIT ROLE FORM
    ========================================================== --}}
    <form method="POST"
          action="{{ route('admin.roles.update', $role->id) }}">

        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- =================================================
                ROLE INFORMATION
            ================================================== --}}
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white">

                        <h6 class="mb-0">
                            <i class="fas fa-id-badge me-2"></i>
                            Role Information
                        </h6>

                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <label for="name"
                                   class="form-label fw-semibold">

                                Role Name
                                <span class="text-danger">*</span>

                            </label>

                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $role->name) }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Enter role name"
                                   required>

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="form-text">
                                Update the unique name of this role.
                            </div>

                        </div>


                        {{-- Current Role --}}
                        <div class="mt-4">

                            <label class="form-label text-muted small">
                                Current Role
                            </label>

                            <div>
                                <span class="badge bg-primary fs-6">
                                    {{ $role->name }}
                                </span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                PERMISSIONS
            ================================================== --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <h6 class="mb-0">
                                    <i class="fas fa-key me-2"></i>
                                    Permissions
                                </h6>

                                <small class="text-muted">
                                    Select the permissions assigned to this role.
                                </small>

                            </div>

                            <div>

                                <button type="button"
                                        class="btn btn-sm btn-outline-primary"
                                        id="selectAllPermissions">

                                    <i class="fas fa-check-double me-1"></i>
                                    Select All

                                </button>

                                <button type="button"
                                        class="btn btn-sm btn-outline-secondary"
                                        id="clearAllPermissions">

                                    <i class="fas fa-times me-1"></i>
                                    Clear All

                                </button>

                            </div>

                        </div>

                    </div>


                    <div class="card-body">

                        @if($permissions->count())

                            <div class="row g-3">

                                @foreach($permissions as $permission)

                                    <div class="col-md-6 col-xl-4">

                                        <div class="form-check border rounded p-3 h-100">

                                            <input class="form-check-input permission-checkbox"
                                                   type="checkbox"
                                                   name="permissions[]"
                                                   value="{{ $permission->name }}"
                                                   id="permission_{{ $permission->id }}"

                                                   {{ in_array(
                                                       $permission->name,
                                                       old(
                                                           'permissions',
                                                           $role->permissions->pluck('name')->toArray()
                                                       )
                                                   ) ? 'checked' : '' }}>

                                            <label class="form-check-label ms-2"
                                                   for="permission_{{ $permission->id }}">

                                                <span class="fw-semibold">
                                                    {{ $permission->name }}
                                                </span>

                                            </label>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @else

                            <div class="text-center py-5">

                                <i class="fas fa-key fa-3x text-muted mb-3"></i>

                                <h6>No Permissions Found</h6>

                                <p class="text-muted mb-0">
                                    No permissions are currently available.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
            FORM ACTIONS
        ========================================================== --}}
        <div class="card border-0 shadow-sm mt-4">

            <div class="card-body">

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('admin.roles.index') }}"
                       class="btn btn-light">

                        <i class="fas fa-times me-1"></i>
                        Cancel

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fas fa-save me-1"></i>
                        Update Role

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>


{{-- =========================================================
    PERMISSION SELECTION SCRIPT
========================================================== --}}
@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const checkboxes = document.querySelectorAll('.permission-checkbox');

    const selectAllButton =
        document.getElementById('selectAllPermissions');

    const clearAllButton =
        document.getElementById('clearAllPermissions');


    // Select all permissions
    if (selectAllButton) {

        selectAllButton.addEventListener('click', function () {

            checkboxes.forEach(function (checkbox) {
                checkbox.checked = true;
            });

        });

    }


    // Clear all permissions
    if (clearAllButton) {

        clearAllButton.addEventListener('click', function () {

            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
            });

        });

    }

});
</script>

@endpush

@endsection