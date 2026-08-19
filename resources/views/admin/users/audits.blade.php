@extends('layouts.app')

@section('title', 'Status Audits')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">
                <i class="fas fa-history me-2"></i>
                Status Audits
            </h4>

            <div class="text-muted">
                View status change history for
                <strong>{{ $user->name }}</strong>
            </div>
        </div>

        <div>
            <a href="{{ route('admin.users.show', $user->id) }}"
               class="btn btn-outline-secondary">

                <i class="fas fa-arrow-left me-1"></i>
                Back to User
            </a>
        </div>

    </div>


    {{-- Audit Card --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>
                <h6 class="mb-0">
                    <i class="fas fa-exchange-alt me-2"></i>
                    Status Change History
                </h6>
            </div>

            <span class="badge bg-secondary">
                {{ $audits->total() }} Records
            </span>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th width="70">#</th>
                            <th>Field</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                            <th>Changed By</th>
                            <th>Changed At</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($audits as $audit)

                        <tr>

                            <td>
                                <span class="text-muted">
                                    {{ $audit->id }}
                                </span>
                            </td>


                            <td>
                                <span class="badge bg-info-subtle text-info">
                                    {{ $audit->field }}
                                </span>
                            </td>


                            <td>
                                @if($audit->old_value !== null && $audit->old_value !== '')
                                    <span class="badge bg-danger-subtle text-danger">
                                        {{ $audit->old_value }}
                                    </span>
                                @else
                                    <span class="text-muted">
                                        —
                                    </span>
                                @endif
                            </td>


                            <td>
                                @if($audit->new_value !== null && $audit->new_value !== '')
                                    <span class="badge bg-success-subtle text-success">
                                        {{ $audit->new_value }}
                                    </span>
                                @else
                                    <span class="text-muted">
                                        —
                                    </span>
                                @endif
                            </td>


                            <td>
                                <div class="d-flex align-items-center">

                                    <div class="me-2">
                                        <i class="fas fa-user-circle fa-lg text-muted"></i>
                                    </div>

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $audit->changed_by ?? 'System' }}
                                        </div>
                                    </div>

                                </div>
                            </td>


                            <td>
                                @if($audit->created_at)

                                    <div class="fw-semibold">
                                        {{ $audit->created_at->format('d M Y') }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $audit->created_at->format('h:i A') }}
                                    </small>

                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center py-5">

                                <div class="text-muted">

                                    <i class="fas fa-history fa-3x mb-3"></i>

                                    <h6>No Status Audits Found</h6>

                                    <p class="mb-0">
                                        No status changes have been recorded
                                        for this user.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Pagination --}}
        @if($audits->hasPages())

            <div class="card-footer bg-white">

                <div class="d-flex justify-content-between align-items-center">

                    <div class="text-muted small">
                        Showing
                        <strong>{{ $audits->firstItem() }}</strong>
                        to
                        <strong>{{ $audits->lastItem() }}</strong>
                        of
                        <strong>{{ $audits->total() }}</strong>
                        records
                    </div>

                    <div>
                        {{ $audits->links() }}
                    </div>

                </div>

            </div>

        @endif

    </div>

</div>

@endsection