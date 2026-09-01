@php
    $comparison = $comparison ?? null;
@endphp

<div class="row g-3">

    <div class="col-md-6">

        <label class="form-label">
            Comparison Number
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="comparison_number"
            class="form-control @error('comparison_number') is-invalid @enderror"
            value="{{ old(
                'comparison_number',
                $comparison?->comparison_number
            ) }}"
            required
        >

        @error('comparison_number')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Comparison Date
        </label>

        <input
            type="date"
            name="comparison_date"
            class="form-control"
            value="{{ old(
                'comparison_date',
                $comparison?->comparison_date?->format('Y-m-d')
            ) }}"
        >

    </div>


    <div class="col-md-8">

        <label class="form-label">
            Comparison Title
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="comparison_title"
            class="form-control @error('comparison_title') is-invalid @enderror"
            value="{{ old(
                'comparison_title',
                $comparison?->comparison_title
            ) }}"
            required
        >

        @error('comparison_title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Evaluation Basis
            <span class="text-danger">*</span>
        </label>

        <select
            name="evaluation_basis"
            class="form-select"
            required
        >

            @foreach([
                'Lowest Evaluated Bid',
                'Best Value',
                'Combined Technical & Financial Score',
            ] as $basis)

                <option
                    value="{{ $basis }}"
                    @selected(
                        old(
                            'evaluation_basis',
                            $comparison?->evaluation_basis
                            ?? 'Lowest Evaluated Bid'
                        ) === $basis
                    )
                >
                    {{ $basis }}
                </option>

            @endforeach

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

            @foreach([
                'Draft',
                'Under Review',
                'Completed',
                'Approved',
                'Rejected',
            ] as $status)

                <option
                    value="{{ $status }}"
                    @selected(
                        old(
                            'status',
                            $comparison?->status ?? 'Draft'
                        ) === $status
                    )
                >
                    {{ $status }}
                </option>

            @endforeach

        </select>

    </div>


    <div class="col-12">

        <label class="form-label">
            Summary
        </label>

        <textarea
            name="summary"
            rows="4"
            class="form-control"
        >{{ old(
            'summary',
            $comparison?->summary
        ) }}</textarea>

    </div>


    <div class="col-12">

        <label class="form-label">
            Remarks
        </label>

        <textarea
            name="remarks"
            rows="3"
            class="form-control"
        >{{ old(
            'remarks',
            $comparison?->remarks
        ) }}</textarea>

    </div>

</div>