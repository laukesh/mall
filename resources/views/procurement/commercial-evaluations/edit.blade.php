@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">
                Edit Commercial Evaluation
            </h4>

            <div class="text-muted">

                {{ $evaluation->evaluation_number }}

                -

                {{
                    $evaluation
                        ->submission
                        ->tenderBidder
                        ->bidder
                        ->company_name
                }}

            </div>

        </div>


        <a
            href="{{ route(
                'admin.procurement.tenders.commercial-evaluations.show',
                [
                    'procurementTender' => $procurementTender,
                    'evaluation' => $evaluation,
                ]
            ) }}"
            class="btn btn-outline-secondary"
        >
            Back
        </a>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Please correct the following:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route(
            'admin.procurement.tenders.commercial-evaluations.update',
            [
                'procurementTender' => $procurementTender,
                'evaluation' => $evaluation,
            ]
        ) }}"
    >

        @csrf
        @method('PUT')


        <div class="card">

            <div class="card-header">
                <strong>Commercial Evaluation</strong>
            </div>


            <div class="card-body">

                <div class="row mb-4">

                    <div class="col-md-6">

                        <label class="form-label">
                            Tender Submission
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{
                                $evaluation
                                    ->submission
                                    ->submission_number
                            }}"
                            readonly
                        >

                    </div>


                    <div class="col-md-6">

                        <label class="form-label">
                            Bidder
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{
                                $evaluation
                                    ->submission
                                    ->tenderBidder
                                    ->bidder
                                    ->company_name
                            }}"
                            readonly
                        >

                    </div>

                </div>


                @include(
                    'procurement.commercial-evaluations._form',
                    [
                        'evaluation' => $evaluation,
                        'selectedSubmission' =>
                            $evaluation->submission,
                    ]
                )

            </div>


            <div class="card-footer text-end">

                <a
                    href="{{ route(
                        'admin.procurement.tenders.commercial-evaluations.show',
                        [
                            'procurementTender' => $procurementTender,
                            'evaluation' => $evaluation,
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
                    Update Commercial Evaluation
                </button>

            </div>

        </div>

    </form>

</div>

@endsection