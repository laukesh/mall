@extends('layouts.app')

@section('title', 'Asset Income')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">
                Asset Income
            </h4>

            <div class="text-muted">

                {{ $asset->asset_code }}
                -
                {{ $asset->asset_name }}

            </div>

        </div>

        <div class="d-flex gap-2">

            <a href="{{ route(
                'admin.assets.show',
                $asset->id
            ) }}"
               class="btn btn-secondary">

                <i class="fas fa-arrow-left"></i>
                Back

            </a>

            <a href="{{ route(
                'admin.assets.incomes.create',
                $asset->id
            ) }}"
               class="btn btn-success">

                <i class="fas fa-plus"></i>
                Add Income

            </a>

        </div>

    </div>


    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif


    <div class="card">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="fas fa-money-bill-wave me-1"></i>

                Income History

            </h5>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered table-hover mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Period</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th width="130">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($incomes as $income)

                        <tr>

                            <td>
                                {{ $income->id }}
                            </td>

                            <td>
                                {{ $income->income_date?->format('d M Y') }}
                            </td>

                            <td>
                                {{ $income->income_type }}
                            </td>

                            <td>

                                {{ $income->billing_period_from?->format('d M Y') ?? '-' }}

                                <br>

                                <small class="text-muted">

                                    to

                                    {{ $income->billing_period_to?->format('d M Y') ?? '-' }}

                                </small>

                            </td>

                            <td>

                                ₹{{ number_format(
                                    $income->amount,
                                    2
                                ) }}

                            </td>

                            <td>

                                <span class="badge bg-success">

                                    {{ $income->status }}

                                </span>

                            </td>

                            <td>

                                <div class="d-flex gap-1">

                                    <a href="{{ route(
                                        'admin.assets.incomes.edit',
                                        [
                                            $asset->id,
                                            $income->id
                                        ]
                                    ) }}"
                                       class="btn btn-sm btn-primary">

                                        <i class="fas fa-pen"></i>

                                    </a>

                                    <form method="POST"
                                          action="{{ route(
                                              'admin.assets.incomes.destroy',
                                              [
                                                  $asset->id,
                                                  $income->id
                                              ]
                                          ) }}"
                                          onsubmit="return confirm(
                                              'Delete this income record?'
                                          );">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center py-5">

                                <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>

                                <h5>
                                    No Income Records
                                </h5>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        @if($incomes->hasPages())

            <div class="card-footer">

                {{ $incomes->links() }}

            </div>

        @endif

    </div>

</div>

@endsection