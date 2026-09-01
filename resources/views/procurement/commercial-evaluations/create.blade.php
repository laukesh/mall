@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">
                Add Commercial Evaluation
            </h4>

            <div class="text-muted">

                Tender:
                <strong>
                    {{ $procurementTender->tender_number }}
                </strong>

                -
                {{ $procurementTender->tender_title }}

            </div>
        </div>


        <a
            href="{{ route(
                'admin.procurement.tenders.commercial-evaluations.index',
                $procurementTender
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
            'admin.procurement.tenders.commercial-evaluations.store',
            $procurementTender
        ) }}"
    >

        @csrf

        <div class="card">

            <div class="card-header">
                <strong>Commercial Evaluation</strong>
            </div>


            <div class="card-body">

                {{-- Qualified Submission --}}
                <div class="mb-4">

                    <label class="form-label">
                        Technically Qualified Submission
                        <span class="text-danger">*</span>
                    </label>


                    <select
                        name="procurement_tender_submission_id"
                        class="form-select @error('procurement_tender_submission_id') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            -- Select Qualified Submission --
                        </option>


                        @foreach(
                            $availableSubmissions
                            as $submission
                        )

                            <option
                                value="{{ $submission->id }}"
                                @selected(
                                    old(
                                        'procurement_tender_submission_id'
                                    ) == $submission->id
                                )
                            >

                                {{ $submission->submission_number }}

                                -

                                {{
                                    $submission
                                        ->tenderBidder
                                        ->bidder
                                        ->company_name
                                }}

                                -

                                {{
                                    number_format(
                                        $submission->quoted_amount,
                                        2
                                    )
                                }}

                                {{ $submission->currency }}

                                |
                                Technical Score:
                                {{
                                    number_format(
                                        $submission
                                            ->technicalEvaluation
                                            ->technical_score,
                                        2
                                    )
                                }}

                            </option>

                        @endforeach

                    </select>


                    @error('procurement_tender_submission_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror


                    @if($availableSubmissions->isEmpty())

                        <div class="text-danger small mt-2">

                            No technically qualified submissions
                            are available for Commercial Evaluation.

                        </div>

                    @else

                        <div class="text-muted small mt-2">

                            Only submissions with a
                            <strong>Qualified</strong>
                            Technical Evaluation are shown.

                        </div>

                    @endif

                </div>


                @include(
                    'procurement.commercial-evaluations._form',
                    [
                        'evaluation' => null,
                        'selectedSubmission' => null,
                    ]
                )

            </div>


            <div class="card-footer text-end">

                <a
                    href="{{ route(
                        'admin.procurement.tenders.commercial-evaluations.index',
                        $procurementTender
                    ) }}"
                    class="btn btn-outline-secondary"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="btn btn-primary"
                    @disabled($availableSubmissions->isEmpty())
                >
                    Save Commercial Evaluation
                </button>

            </div>

        </div>

    </form>

</div>

@endsection