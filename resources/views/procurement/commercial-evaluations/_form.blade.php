@php
    $evaluation = $evaluation ?? null;
@endphp

<div class="row g-3">

    <div class="col-md-6">
        <label class="form-label">
            Evaluation Number <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="evaluation_number"
            class="form-control @error('evaluation_number') is-invalid @enderror"
            value="{{ old('evaluation_number', $evaluation?->evaluation_number) }}"
            required
        >

        @error('evaluation_number')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="col-md-6">
        <label class="form-label">Evaluation Date</label>

        <input
            type="date"
            name="evaluation_date"
            class="form-control @error('evaluation_date') is-invalid @enderror"
            value="{{ old(
                'evaluation_date',
                $evaluation?->evaluation_date?->format('Y-m-d')
            ) }}"
        >

        @error('evaluation_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="col-md-6">
        <label class="form-label">Evaluator</label>

        <input
            type="text"
            name="evaluator_name"
            class="form-control @error('evaluator_name') is-invalid @enderror"
            value="{{ old(
                'evaluator_name',
                $evaluation?->evaluator_name ?? auth()->user()?->name
            ) }}"
        >

        @error('evaluator_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="col-md-6">
        <label class="form-label">Currency</label>

        <input
            type="text"
            class="form-control"
            value="{{ $evaluation?->currency ?? 'INR' }}"
            readonly
        >
    </div>


    <div class="col-md-4">
        <label class="form-label">
            Original Quoted Amount
        </label>

        <input
            type="text"
            class="form-control"
            value="{{ $evaluation
                ? number_format($evaluation->quoted_amount, 2)
                : number_format(
                    $selectedSubmission?->quoted_amount ?? 0,
                    2
                )
            }}"
            readonly
        >
    </div>


    <div class="col-md-4">
        <label class="form-label">
            Evaluated Amount <span class="text-danger">*</span>
        </label>

        <input
            type="number"
            step="0.01"
            min="0"
            name="evaluated_amount"
            id="evaluated_amount"
            class="form-control @error('evaluated_amount') is-invalid @enderror"
            value="{{ old(
                'evaluated_amount',
                $evaluation?->evaluated_amount ??
                    $selectedSubmission?->quoted_amount ??
                    0
            ) }}"
            required
        >

        @error('evaluated_amount')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="col-md-4">
        <label class="form-label">Tax Amount</label>

        <input
            type="number"
            step="0.01"
            min="0"
            name="tax_amount"
            id="tax_amount"
            class="form-control @error('tax_amount') is-invalid @enderror"
            value="{{ old(
                'tax_amount',
                $evaluation?->tax_amount ?? 0
            ) }}"
        >

        @error('tax_amount')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="col-md-4">
        <label class="form-label">Discount Amount</label>

        <input
            type="number"
            step="0.01"
            min="0"
            name="discount_amount"
            id="discount_amount"
            class="form-control @error('discount_amount') is-invalid @enderror"
            value="{{ old(
                'discount_amount',
                $evaluation?->discount_amount ?? 0
            ) }}"
        >

        @error('discount_amount')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="col-md-4">
        <label class="form-label">
            Final Evaluated Amount <span class="text-danger">*</span>
        </label>

        <input
            type="number"
            step="0.01"
            min="0"
            name="final_evaluated_amount"
            id="final_evaluated_amount"
            class="form-control @error('final_evaluated_amount') is-invalid @enderror"
            value="{{ old(
                'final_evaluated_amount',
                $evaluation?->final_evaluated_amount ?? 0
            ) }}"
            required
        >

        @error('final_evaluated_amount')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="col-md-4">
        <label class="form-label">
            Price Score <span class="text-danger">*</span>
        </label>

        <input
            type="number"
            step="0.01"
            min="0"
            name="price_score"
            class="form-control @error('price_score') is-invalid @enderror"
            value="{{ old(
                'price_score',
                $evaluation?->price_score ?? 0
            ) }}"
            required
        >

        @error('price_score')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="col-md-4">
        <label class="form-label">
            Maximum Price Score <span class="text-danger">*</span>
        </label>

        <input
            type="number"
            step="0.01"
            min="0.01"
            name="maximum_price_score"
            class="form-control @error('maximum_price_score') is-invalid @enderror"
            value="{{ old(
                'maximum_price_score',
                $evaluation?->maximum_price_score ?? 100
            ) }}"
            required
        >

        @error('maximum_price_score')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="col-md-6">
        <label class="form-label">
            Commercial Compliance <span class="text-danger">*</span>
        </label>

        <select
            name="commercial_compliance"
            class="form-select @error('commercial_compliance') is-invalid @enderror"
            required
        >

            @foreach([
                'Pending',
                'Compliant',
                'Partially Compliant',
                'Non-Compliant'
            ] as $compliance)

                <option
                    value="{{ $compliance }}"
                    @selected(
                        old(
                            'commercial_compliance',
                            $evaluation?->commercial_compliance ?? 'Pending'
                        ) === $compliance
                    )
                >
                    {{ $compliance }}
                </option>

            @endforeach

        </select>

        @error('commercial_compliance')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="col-md-6">
        <label class="form-label">
            Status <span class="text-danger">*</span>
        </label>

        <select
            name="status"
            class="form-select @error('status') is-invalid @enderror"
            required
        >

            @foreach([
                'Draft',
                'Under Evaluation',
                'Completed',
                'Approved',
                'Rejected'
            ] as $status)

                <option
                    value="{{ $status }}"
                    @selected(
                        old(
                            'status',
                            $evaluation?->status ?? 'Draft'
                        ) === $status
                    )
                >
                    {{ $status }}
                </option>

            @endforeach

        </select>

        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="col-md-6">
        <label class="form-label">Strengths</label>

        <textarea
            name="strengths"
            rows="4"
            class="form-control"
        >{{ old(
            'strengths',
            $evaluation?->strengths
        ) }}</textarea>
    </div>


    <div class="col-md-6">
        <label class="form-label">Weaknesses</label>

        <textarea
            name="weaknesses"
            rows="4"
            class="form-control"
        >{{ old(
            'weaknesses',
            $evaluation?->weaknesses
        ) }}</textarea>
    </div>


    <div class="col-12">
        <label class="form-label">
            Evaluation Summary
        </label>

        <textarea
            name="evaluation_summary"
            rows="4"
            class="form-control"
        >{{ old(
            'evaluation_summary',
            $evaluation?->evaluation_summary
        ) }}</textarea>
    </div>


    <div class="col-12">
        <label class="form-label">Remarks</label>

        <textarea
            name="remarks"
            rows="3"
            class="form-control"
        >{{ old(
            'remarks',
            $evaluation?->remarks
        ) }}</textarea>
    </div>

</div>


<div class="alert alert-info mt-4">

    <strong>Commercial Evaluation:</strong>

    The final evaluated amount should consider applicable
    taxes, discounts and commercial adjustments.

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const evaluatedAmount =
        document.getElementById('evaluated_amount');

    const taxAmount =
        document.getElementById('tax_amount');

    const discountAmount =
        document.getElementById('discount_amount');

    const finalAmount =
        document.getElementById('final_evaluated_amount');


    function calculateFinalAmount() {

        if (
            !evaluatedAmount ||
            !taxAmount ||
            !discountAmount ||
            !finalAmount
        ) {
            return;
        }

        const evaluated =
            parseFloat(evaluatedAmount.value) || 0;

        const tax =
            parseFloat(taxAmount.value) || 0;

        const discount =
            parseFloat(discountAmount.value) || 0;

        const final =
            evaluated + tax - discount;

        finalAmount.value =
            Math.max(final, 0).toFixed(2);
    }


    evaluatedAmount?.addEventListener(
        'input',
        calculateFinalAmount
    );

    taxAmount?.addEventListener(
        'input',
        calculateFinalAmount
    );

    discountAmount?.addEventListener(
        'input',
        calculateFinalAmount
    );

});
</script>