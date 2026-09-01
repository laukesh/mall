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
                Edit Bid Comparison
            </h4>

        </div>


        <a
            href="{{ route(
                'admin.procurement.tenders.bid-comparisons.show',
                [
                    'procurementTender' =>
                        $procurementTender,

                    'comparison' =>
                        $comparison,
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
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route(
            'admin.procurement.tenders.bid-comparisons.update',
            [
                'procurementTender' =>
                    $procurementTender,

                'comparison' =>
                    $comparison,
            ]
        ) }}"
    >

        @csrf
        @method('PUT')


        <div class="card mb-4">

            <div class="card-header">
                <strong>Comparison Details</strong>
            </div>

            <div class="card-body">

                @include(
                    'procurement.bid-comparisons._form',
                    [
                        'comparison' =>
                            $comparison,
                    ]
                )

            </div>

        </div>


        <div class="card">

            <div class="card-header">

                <strong>
                    Qualified Commercial Bids
                </strong>

            </div>


            <div class="card-body p-0">

                @if(
                    $eligibleCommercialEvaluations->isNotEmpty()
                )

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                            <tr>

                                <th width="50">
                                    Select
                                </th>

                                <th>
                                    Bidder
                                </th>

                                <th>
                                    Submission
                                </th>

                                <th>
                                    Quoted Amount
                                </th>

                                <th>
                                    Final Amount
                                </th>

                                <th>
                                    Price Score
                                </th>

                            </tr>

                            </thead>


                            <tbody>

                            @foreach(
                                $eligibleCommercialEvaluations
                                as $evaluation
                            )

                                <tr>

                                    <td>

                                        <input
                                            type="checkbox"
                                            name="selected_evaluations[]"
                                            value="{{ $evaluation->id }}"
                                            class="form-check-input"
                                            @checked(
                                                in_array(
                                                    $evaluation->id,
                                                    old(
                                                        'selected_evaluations',
                                                        $selectedEvaluationIds
                                                    )
                                                )
                                            )
                                        >

                                    </td>


                                    <td>

                                        {{
                                            $evaluation
                                                ->submission
                                                ?->tenderBidder
                                                ?->bidder
                                                ?->company_name
                                            ?? 'Unknown Bidder'
                                        }}

                                    </td>


                                    <td>

                                        {{
                                            $evaluation
                                                ->submission
                                                ?->submission_number
                                            ?? '—'
                                        }}

                                    </td>


                                    <td>

                                        {{
                                            number_format(
                                                (float)
                                                $evaluation->quoted_amount,
                                                2
                                            )
                                        }}

                                        {{ $evaluation->currency }}

                                    </td>


                                    <td>

                                        <strong>

                                            {{
                                                number_format(
                                                    (float)
                                                    $evaluation
                                                        ->final_evaluated_amount,
                                                    2
                                                )
                                            }}

                                        </strong>

                                        {{ $evaluation->currency }}

                                    </td>


                                    <td>

                                        {{
                                            number_format(
                                                (float)
                                                $evaluation->price_score,
                                                2
                                            )
                                        }}

                                        /

                                        {{
                                            number_format(
                                                (float)
                                                $evaluation
                                                    ->maximum_price_score,
                                                2
                                            )
                                        }}

                                    </td>

                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="alert alert-warning m-3">

                        No Qualified Commercial Evaluations
                        are currently available.

                    </div>

                @endif

            </div>

        </div>


        <div class="d-flex justify-content-end gap-2 mt-4">

            <a
                href="{{ route(
                    'admin.procurement.tenders.bid-comparisons.show',
                    [
                        'procurementTender' =>
                            $procurementTender,

                        'comparison' =>
                            $comparison,
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
                Update Comparison
            </button>

        </div>

    </form>

</div>

@endsection