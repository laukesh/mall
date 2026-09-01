<div class="row g-3">

    <div class="col-md-6">

        <label class="form-label">
            Bid Comparison
            <span class="text-danger">*</span>
        </label>

        <select
            name="procurement_bid_comparison_id"
            id="procurement_bid_comparison_id"
            class="form-select"
            required
        >

            <option value="">
                -- Select Bid Comparison --
            </option>

            @foreach($comparisons as $comparison)

                @php
                    $recommended =
                        $comparison
                            ->recommendedSubmission
                            ?->tenderBidder
                            ?->bidder
                            ?->company_name
                        ?? 'Unknown Bidder';
                @endphp

                <option
                    value="{{ $comparison->id }}"
                    data-amount="{{ $comparison->lowest_evaluated_amount }}"
                    data-currency="{{ $comparison->currency }}"
                    data-bidder="{{ $recommended }}"
                >

                    {{ $comparison->comparison_number }}
                    -
                    {{ $comparison->comparison_title }}
                    |
                    {{ $recommended }}

                </option>

            @endforeach

        </select>

        @error('procurement_bid_comparison_id')
            <div class="text-danger small">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Negotiation Number
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="negotiation_number"
            class="form-control"
            value="{{ old('negotiation_number') }}"
            placeholder="NEG-2026-001"
            required
        >

    </div>


    <div class="col-md-8">

        <label class="form-label">
            Negotiation Title
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="negotiation_title"
            class="form-control"
            value="{{ old('negotiation_title') }}"
            placeholder="Negotiation with Recommended Bidder"
            required
        >

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Negotiation Date
        </label>

        <input
            type="date"
            name="negotiation_date"
            class="form-control"
            value="{{ old(
                'negotiation_date',
                now()->format('Y-m-d')
            ) }}"
        >

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Negotiation Type
        </label>

        <select
            name="negotiation_type"
            class="form-select"
        >

            <option value="">
                -- Select Type --
            </option>

            <option value="Price Negotiation">
                Price Negotiation
            </option>

            <option value="Commercial Negotiation">
                Commercial Negotiation
            </option>

            <option value="Technical & Commercial Negotiation">
                Technical & Commercial Negotiation
            </option>

            <option value="Final Negotiation">
                Final Negotiation
            </option>

        </select>

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Status
            <span class="text-danger">*</span>
        </label>

        <select
            name="status"
            class="form-select"
            required
        >

            <option value="Draft">
                Draft
            </option>

            <option value="Under Review">
                Under Review
            </option>

            <option value="Completed">
                Completed
            </option>

            <option value="Approved">
                Approved
            </option>

        </select>

    </div>


    <div class="col-12">

        <div class="alert alert-info">

            <div class="row">

                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Recommended Bidder
                    </small>

                    <strong id="selectedBidder">
                        —
                    </strong>

                </div>

                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Original Amount
                    </small>

                    <strong id="originalAmount">
                        —
                    </strong>

                </div>

                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Currency
                    </small>

                    <strong id="originalCurrency">
                        —
                    </strong>

                </div>

            </div>

        </div>

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Bidder Amount
            <span class="text-danger">*</span>
        </label>

        <input
            type="number"
            step="0.01"
            min="0"
            name="bidder_amount"
            id="bidder_amount"
            class="form-control"
            value="{{ old('bidder_amount') }}"
            required
        >

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Negotiated Amount
            <span class="text-danger">*</span>
        </label>

        <input
            type="number"
            step="0.01"
            min="0"
            name="negotiated_amount"
            id="negotiated_amount"
            class="form-control"
            value="{{ old('negotiated_amount') }}"
            required
        >

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Discount Amount
        </label>

        <input
            type="number"
            step="0.01"
            min="0"
            name="discount_amount"
            class="form-control"
            value="{{ old('discount_amount', 0) }}"
        >

    </div>


    <div class="col-12">

        <label class="form-label">
            Bidder Comments
        </label>

        <textarea
            name="bidder_comments"
            rows="3"
            class="form-control"
        >{{ old('bidder_comments') }}</textarea>

    </div>


    <div class="col-12">

        <label class="form-label">
            Evaluator Comments
        </label>

        <textarea
            name="evaluator_comments"
            rows="3"
            class="form-control"
        >{{ old('evaluator_comments') }}</textarea>

    </div>


    <div class="col-12">

        <label class="form-label">
            Summary
        </label>

        <textarea
            name="summary"
            rows="3"
            class="form-control"
        >{{ old('summary') }}</textarea>

    </div>


    <div class="col-12">

        <label class="form-label">
            Remarks
        </label>

        <textarea
            name="remarks"
            rows="3"
            class="form-control"
        >{{ old('remarks') }}</textarea>

    </div>

</div>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const comparison =
            document.getElementById(
                'procurement_bid_comparison_id'
            );

        const bidder =
            document.getElementById(
                'selectedBidder'
            );

        const amount =
            document.getElementById(
                'originalAmount'
            );

        const currency =
            document.getElementById(
                'originalCurrency'
            );

        const bidderAmount =
            document.getElementById(
                'bidder_amount'
            );

        const negotiatedAmount =
            document.getElementById(
                'negotiated_amount'
            );


        function updateComparison()
        {
            const option =
                comparison.options[
                    comparison.selectedIndex
                ];

            if (
                !option ||
                !option.value
            ) {

                bidder.textContent = '—';
                amount.textContent = '—';
                currency.textContent = '—';

                return;
            }


            const selectedBidder =
                option.dataset.bidder || '—';

            const selectedAmount =
                option.dataset.amount || '0';

            const selectedCurrency =
                option.dataset.currency || 'INR';


            bidder.textContent =
                selectedBidder;

            amount.textContent =
                Number(
                    selectedAmount
                ).toLocaleString(
                    undefined,
                    {
                        minimumFractionDigits: 2
                    }
                );

            currency.textContent =
                selectedCurrency;


            if (!bidderAmount.value) {

                bidderAmount.value =
                    selectedAmount;
            }


            if (!negotiatedAmount.value) {

                negotiatedAmount.value =
                    selectedAmount;
            }
        }


        comparison.addEventListener(
            'change',
            updateComparison
        );


        updateComparison();

    }
);

</script>