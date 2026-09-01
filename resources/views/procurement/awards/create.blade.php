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
                Create Award
            </h4>

            <div class="text-muted">
                {{ $procurementTender->tender_title }}
            </div>

        </div>


        <a
            href="{{ route(
                'admin.procurement.tenders.awards.index',
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


    @if($negotiations->isEmpty())

        <div class="alert alert-warning">

            <h6>
                No Approved Negotiation Available
            </h6>

            <p class="mb-0">

                An Award can only be created after a
                Negotiation has been finalized and approved.

            </p>

        </div>

    @else

        <form
            method="POST"
            action="{{ route(
                'admin.procurement.tenders.awards.store',
                $procurementTender
            ) }}"
        >

            @csrf

            <div class="card">

                <div class="card-header">

                    <strong>
                        Award Details
                    </strong>

                </div>

                <div class="card-body">

                    @include(
                        'procurement.awards._form'
                    )

                </div>

            </div>


            <div class="d-flex justify-content-end gap-2 mt-4">

                <a
                    href="{{ route(
                        'admin.procurement.tenders.awards.index',
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
                    Create Award
                </button>

            </div>

        </form>

    @endif

</div>

@endsection