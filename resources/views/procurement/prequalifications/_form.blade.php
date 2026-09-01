@php
    $prequalification = $prequalification ?? null;
@endphp

<div class="row g-3">

    {{-- Prequalification Number --}}
    <div class="col-md-4">

        <label class="form-label">
            Prequalification No.
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="prequalification_no"
            class="form-control @error('prequalification_no') is-invalid @enderror"
            value="{{ old(
                'prequalification_no',
                $prequalification?->prequalification_no
            ) }}"
            maxlength="100"
            required
        >

        @error('prequalification_no')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Bidder --}}
    <div class="col-md-8">

        <label class="form-label">
            Tender Bidder
        </label>

        @if($prequalification)

            <input
                type="text"
                class="form-control"
                value="{{ $prequalification->tenderBidder->bidder->company_name }}
                    ({{ $prequalification->tenderBidder->bidder->bidder_code }})"
                readonly
            >

        @else

            <select
                name="procurement_tender_bidder_id"
                class="form-select @error('procurement_tender_bidder_id') is-invalid @enderror"
                required
            >

                <option value="">
                    -- Select Tender Bidder --
                </option>

                @foreach($availableBidders as $tenderBidder)

                    <option
                        value="{{ $tenderBidder->id }}"
                        @selected(
                            old('procurement_tender_bidder_id')
                            == $tenderBidder->id
                        )
                    >

                        {{ $tenderBidder->bidder->company_name }}

                        -
                        {{ $tenderBidder->bidder->bidder_code }}

                    </option>

                @endforeach

            </select>

            @error('procurement_tender_bidder_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        @endif

    </div>


    {{-- Submission Date --}}
    <div class="col-md-4">

        <label class="form-label">
            Submission Date
        </label>

        <input
            type="date"
            name="submission_date"
            class="form-control @error('submission_date') is-invalid @enderror"
            value="{{ old(
                'submission_date',
                $prequalification?->submission_date?->format('Y-m-d')
            ) }}"
        >

        @error('submission_date')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Evaluation Date --}}
    <div class="col-md-4">

        <label class="form-label">
            Evaluation Date
        </label>

        <input
            type="date"
            name="evaluation_date"
            class="form-control @error('evaluation_date') is-invalid @enderror"
            value="{{ old(
                'evaluation_date',
                $prequalification?->evaluation_date?->format('Y-m-d')
            ) }}"
        >

        @error('evaluation_date')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Evaluator Name --}}
    <div class="col-md-4">

        <label class="form-label">
            Evaluator Name
        </label>

        <input
            type="text"
            name="evaluator_name"
            class="form-control @error('evaluator_name') is-invalid @enderror"
            maxlength="255"
            value="{{ old(
                'evaluator_name',
                $prequalification?->evaluator_name
            ) }}"
        >

        @error('evaluator_name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Status --}}
    <div class="col-md-4">

        <label class="form-label">
            Status
            <span class="text-danger">*</span>
        </label>

        <select
            name="status"
            class="form-select @error('status') is-invalid @enderror"
            required
        >

            @foreach([
                'Draft',
                'Submitted',
                'Under Evaluation',
            ] as $status)

                <option
                    value="{{ $status }}"
                    @selected(
                        old(
                            'status',
                            $prequalification?->status ?? 'Draft'
                        ) === $status
                    )
                >
                    {{ $status }}
                </option>

            @endforeach

        </select>

        <div class="form-text">
            Qualified / Not Qualified is calculated from evaluation criteria.
        </div>

        @error('status')

            <div class="invalid-feedback">
                {{ $message }}
            </div>

        @enderror

    </div>


    {{-- Evaluation Summary --}}
    <div class="col-12">

        <label class="form-label">
            Evaluation Summary
        </label>

        <textarea
            name="evaluation_summary"
            rows="4"
            class="form-control @error('evaluation_summary') is-invalid @enderror"
            placeholder="Enter overall evaluation summary"
        >{{ old(
            'evaluation_summary',
            $prequalification?->evaluation_summary
        ) }}</textarea>

        @error('evaluation_summary')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Remarks --}}
    <div class="col-12">

        <label class="form-label">
            Remarks
        </label>

        <textarea
            name="remarks"
            rows="3"
            class="form-control @error('remarks') is-invalid @enderror"
            placeholder="Additional remarks"
        >{{ old(
            'remarks',
            $prequalification?->remarks
        ) }}</textarea>

        @error('remarks')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

</div>