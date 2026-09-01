<div class="row g-3">

    <div class="col-md-6">

        <label class="form-label">
            Approved Negotiation
            <span class="text-danger">*</span>
        </label>

        <select
            name="procurement_negotiation_id"
            id="procurement_negotiation_id"
            class="form-select"
            required
        >

            <option value="">
                -- Select Approved Negotiation --
            </option>

            @foreach($negotiations as $negotiation)

                <option
                    value="{{ $negotiation->id }}"
                    data-bidder="{{ $negotiation->bidder_name }}"
                    data-amount="{{ $negotiation->final_amount }}"
                    data-currency="{{ $negotiation->currency }}"
                >

                    {{ $negotiation->negotiation_number }}
                    -
                    {{ $negotiation->bidder_name }}

                </option>

            @endforeach

        </select>

        @error('procurement_negotiation_id')
            <div class="text-danger small">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Award Number
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="award_number"
            class="form-control"
            value="{{ old('award_number') }}"
            placeholder="AWD-2026-001"
            required
        >

    </div>


    <div class="col-md-8">

        <label class="form-label">
            Award Title
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="award_title"
            class="form-control"
            value="{{ old('award_title') }}"
            placeholder="Award for Procurement Tender"
            required
        >

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Award Date
        </label>

        <input
            type="date"
            name="award_date"
            class="form-control"
            value="{{ old(
                'award_date',
                now()->format('Y-m-d')
            ) }}"
        >

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Award Type
        </label>

        <select
            name="award_type"
            class="form-select"
        >

            <option value="Letter of Award">
                Letter of Award
            </option>

            <option value="Work Order">
                Work Order
            </option>

            <option value="Purchase Order">
                Purchase Order
            </option>

        </select>

    </div>


    <div class="col-md-6">

        <label class="form-label">
            LOA Number
        </label>

        <input
            type="text"
            name="loa_number"
            class="form-control"
            value="{{ old('loa_number') }}"
        >

    </div>


    <div class="col-md-6">

        <label class="form-label">
            LOA Date
        </label>

        <input
            type="date"
            name="loa_date"
            class="form-control"
            value="{{ old('loa_date') }}"
        >

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Acceptance Deadline
        </label>

        <input
            type="date"
            name="acceptance_deadline"
            class="form-control"
            value="{{ old('acceptance_deadline') }}"
        >

    </div>


    <div class="col-12">

        <div class="alert alert-info">

            <div class="row">

                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Awarded Bidder
                    </small>

                    <strong id="selectedBidder">
                        —
                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Final Negotiated Amount
                    </small>

                    <strong id="selectedAmount">
                        —
                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Currency
                    </small>

                    <strong id="selectedCurrency">
                        —
                    </strong>

                </div>

            </div>

        </div>

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Contract Required?
        </label>

        <select
            name="contract_required"
            class="form-select"
        >

            <option value="1" selected>
                Yes
            </option>

            <option value="0">
                No
            </option>

        </select>

    </div>


    <div class="col-12">

        <label class="form-label">
            Description
        </label>

        <textarea
            name="description"
            rows="3"
            class="form-control"
        >{{ old('description') }}</textarea>

    </div>


    <div class="col-12">

        <label class="form-label">
            Terms & Conditions
        </label>

        <textarea
            name="terms_and_conditions"
            rows="5"
            class="form-control"
        >{{ old('terms_and_conditions') }}</textarea>

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

        const select =
            document.getElementById(
                'procurement_negotiation_id'
            );

        const bidder =
            document.getElementById(
                'selectedBidder'
            );

        const amount =
            document.getElementById(
                'selectedAmount'
            );

        const currency =
            document.getElementById(
                'selectedCurrency'
            );


        function updateAward()
        {
            const option =
                select.options[
                    select.selectedIndex
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


            bidder.textContent =
                option.dataset.bidder || '—';


            amount.textContent =
                Number(
                    option.dataset.amount || 0
                ).toLocaleString(
                    undefined,
                    {
                        minimumFractionDigits: 2
                    }
                );


            currency.textContent =
                option.dataset.currency || 'INR';
        }


        select.addEventListener(
            'change',
            updateAward
        );


        updateAward();

    }
);

</script>