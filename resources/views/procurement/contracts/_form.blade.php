<div class="row g-3">

    <div class="col-md-6">

        <label class="form-label">
            LOA / Award
            <span class="text-danger">*</span>
        </label>

        <select
            name="procurement_award_id"
            id="procurement_award_id"
            class="form-select"
            required
        >

            <option value="">
                -- Select LOA Issued Award --
            </option>

            @foreach($awards as $award)

                <option
                    value="{{ $award->id }}"
                    data-bidder="{{ $award->bidder_name }}"
                    data-amount="{{ $award->awarded_amount }}"
                    data-currency="{{ $award->currency }}"
                    data-loa="{{ $award->loa_number }}"
                    data-loa-date="{{ $award->loa_date?->format('Y-m-d') }}"
                >

                    {{ $award->award_number }}
                    -
                    {{ $award->bidder_name }}

                </option>

            @endforeach

        </select>

        @error('procurement_award_id')
            <div class="text-danger small">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Contract Number
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="contract_number"
            class="form-control"
            value="{{ old('contract_number') }}"
            placeholder="CON-2026-001"
            required
        >

    </div>


    <div class="col-md-8">

        <label class="form-label">
            Contract Title
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="contract_title"
            class="form-control"
            value="{{ old('contract_title') }}"
            placeholder="Procurement Contract"
            required
        >

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Contract Type
        </label>

        <select
            name="contract_type"
            class="form-select"
        >

            <option value="Procurement Contract">
                Procurement Contract
            </option>

            <option value="Works Contract">
                Works Contract
            </option>

            <option value="Service Contract">
                Service Contract
            </option>

            <option value="Supply Contract">
                Supply Contract
            </option>

        </select>

    </div>


    <div class="col-12">

        <div class="alert alert-info">

            <div class="row">

                <div class="col-md-3">

                    <small class="text-muted d-block">
                        Bidder
                    </small>

                    <strong id="selectedBidder">
                        —
                    </strong>

                </div>


                <div class="col-md-3">

                    <small class="text-muted d-block">
                        Contract Amount
                    </small>

                    <strong id="selectedAmount">
                        —
                    </strong>

                </div>


                <div class="col-md-3">

                    <small class="text-muted d-block">
                        Currency
                    </small>

                    <strong id="selectedCurrency">
                        —
                    </strong>

                </div>


                <div class="col-md-3">

                    <small class="text-muted d-block">
                        LOA
                    </small>

                    <strong id="selectedLoa">
                        —
                    </strong>

                </div>

            </div>

        </div>

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Contract Start Date
        </label>

        <input
            type="date"
            name="contract_start_date"
            class="form-control"
            value="{{ old('contract_start_date') }}"
        >

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Contract End Date
        </label>

        <input
            type="date"
            name="contract_end_date"
            class="form-control"
            value="{{ old('contract_end_date') }}"
        >

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Duration (Days)
        </label>

        <input
            type="number"
            name="contract_duration_days"
            class="form-control"
            min="1"
            value="{{ old('contract_duration_days') }}"
        >

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Signing Date
        </label>

        <input
            type="date"
            name="signing_date"
            class="form-control"
            value="{{ old('signing_date') }}"
        >

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Performance Security
        </label>

        <select
            name="performance_security_required"
            class="form-select"
        >

            <option value="0">
                Not Required
            </option>

            <option value="1">
                Required
            </option>

        </select>

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Performance Security Amount
        </label>

        <input
            type="number"
            step="0.01"
            min="0"
            name="performance_security_amount"
            class="form-control"
            value="{{ old(
                'performance_security_amount',
                0
            ) }}"
        >

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Retention
        </label>

        <select
            name="retention_required"
            class="form-select"
        >

            <option value="0">
                Not Required
            </option>

            <option value="1">
                Required
            </option>

        </select>

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Retention %
        </label>

        <input
            type="number"
            step="0.01"
            min="0"
            max="100"
            name="retention_percentage"
            class="form-control"
            value="{{ old(
                'retention_percentage',
                0
            ) }}"
        >

    </div>


    <div class="col-12">

        <label class="form-label">
            Scope of Work
        </label>

        <textarea
            name="scope_of_work"
            rows="4"
            class="form-control"
        >{{ old('scope_of_work') }}</textarea>

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
            Special Conditions
        </label>

        <textarea
            name="special_conditions"
            rows="4"
            class="form-control"
        >{{ old('special_conditions') }}</textarea>

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
                'procurement_award_id'
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

        const loa =
            document.getElementById(
                'selectedLoa'
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
                loa.textContent = '—';

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


            loa.textContent =
                option.dataset.loa || '—';
        }


        select.addEventListener(
            'change',
            updateAward
        );


        updateAward();

    }
);

</script>