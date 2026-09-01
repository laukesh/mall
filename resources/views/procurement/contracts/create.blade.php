@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>

            <div class="text-muted small">
                Tender:
                {{ $procurementTender->tender_number }}
            </div>

            <h4>
                Create Contract
            </h4>

            <div class="text-muted">
                {{ $procurementTender->tender_title }}
            </div>

        </div>


        <a
            href="{{ route(
                'admin.procurement.tenders.contracts.index',
                $procurementTender
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


    @if($awards->isEmpty())

        <div class="alert alert-warning">

            <h6>
                No LOA Issued Award Available
            </h6>

            <p class="mb-0">

                A Contract can only be created after
                an Award has been approved and the
                Letter of Award has been issued.

            </p>

        </div>

    @else

        <form
            method="POST"
            action="{{ route(
                'admin.procurement.tenders.contracts.store',
                $procurementTender
            ) }}"
        >

            @csrf


            <div class="card">

                <div class="card-header">

                    <strong>
                        Contract Details
                    </strong>

                </div>


                <div class="card-body">

                    @include(
                        'procurement.contracts._form'
                    )

                </div>

            </div>


            <div class="d-flex justify-content-end gap-2 mt-4">

                <a
                    href="{{ route(
                        'admin.procurement.tenders.contracts.index',
                        $procurementTender
                    ) }}"
                    class="btn btn-outline-secondary"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Create Contract
                </button>

            </div>

        </form>

    @endif

</div>

@endsection