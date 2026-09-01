@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>

            <div class="text-muted small">
                Contract:
                {{ $contract->contract_number }}
            </div>

            <h4>
                Add Milestone
            </h4>

            <div class="text-muted">
                {{ $contract->contract_title }}
            </div>

        </div>


        <a
            href="{{ route(
                'admin.procurement.tenders.contracts.milestones.index',
                [
                    'procurementTender' => $procurementTender,
                    'contract' => $contract,
                ]
            ) }}"
            class="btn btn-outline-secondary"
        >
            Back
        </a>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route(
            'admin.procurement.tenders.contracts.milestones.store',
            [
                'procurementTender' => $procurementTender,
                'contract' => $contract,
            ]
        ) }}"
    >

        @csrf


        <div class="card">

            <div class="card-header">

                <strong>
                    Milestone Details
                </strong>

            </div>


            <div class="card-body">

                @include(
                    'procurement.contract-milestones._form'
                )

            </div>

        </div>


        <div class="d-flex justify-content-end gap-2 mt-4">

            <a
                href="{{ route(
                    'admin.procurement.tenders.contracts.milestones.index',
                    [
                        'procurementTender' => $procurementTender,
                        'contract' => $contract,
                    ]
                ) }}"
                class="btn btn-outline-secondary"
            >
                Cancel
            </a>


            <button
                type="submit"
                class="btn btn-primary"
            >
                Create Milestone
            </button>

        </div>

    </form>

</div>

@endsection