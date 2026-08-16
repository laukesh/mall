<div class="row">
    <div class="col-lg-4 col-md-6 mb-3">
        <label for="vendor_user_id" class="form-label fw-semibold">Vendor User ID <span class="text-danger">*</span></label>
        <input id="vendor_user_id" name="vendor_user_id" type="number" class="form-control @error('vendor_user_id') is-invalid @enderror" value="{{ old('vendor_user_id', $item->vendor_user_id ?? '') }}" required>
        @error('vendor_user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="contract_id" class="form-label fw-semibold">Contract ID</label>
        <input id="contract_id" name="contract_id" type="number" class="form-control @error('contract_id') is-invalid @enderror" value="{{ old('contract_id', $item->contract_id ?? '') }}">
        @error('contract_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="evaluation_period_start" class="form-label fw-semibold">Evaluation Period Start <span class="text-danger">*</span></label>
        <input id="evaluation_period_start" name="evaluation_period_start" type="date" class="form-control @error('evaluation_period_start') is-invalid @enderror" value="{{ old('evaluation_period_start', $item->evaluation_period_start ?? '') }}" required>
        @error('evaluation_period_start')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="evaluation_period_end" class="form-label fw-semibold">Evaluation Period End <span class="text-danger">*</span></label>
        <input id="evaluation_period_end" name="evaluation_period_end" type="date" class="form-control @error('evaluation_period_end') is-invalid @enderror" value="{{ old('evaluation_period_end', $item->evaluation_period_end ?? '') }}" required>
        @error('evaluation_period_end')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="quality_rating" class="form-label fw-semibold">Quality Rating</label>
        <input id="quality_rating" name="quality_rating" type="number" class="form-control @error('quality_rating') is-invalid @enderror" value="{{ old('quality_rating', $item->quality_rating ?? '') }}" step="0.01">
        @error('quality_rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="response_rating" class="form-label fw-semibold">Response Rating</label>
        <input id="response_rating" name="response_rating" type="number" class="form-control @error('response_rating') is-invalid @enderror" value="{{ old('response_rating', $item->response_rating ?? '') }}" step="0.01">
        @error('response_rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="timeliness_rating" class="form-label fw-semibold">Timeliness Rating</label>
        <input id="timeliness_rating" name="timeliness_rating" type="number" class="form-control @error('timeliness_rating') is-invalid @enderror" value="{{ old('timeliness_rating', $item->timeliness_rating ?? '') }}" step="0.01">
        @error('timeliness_rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="safety_rating" class="form-label fw-semibold">Safety Rating</label>
        <input id="safety_rating" name="safety_rating" type="number" class="form-control @error('safety_rating') is-invalid @enderror" value="{{ old('safety_rating', $item->safety_rating ?? '') }}" step="0.01">
        @error('safety_rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="communication_rating" class="form-label fw-semibold">Communication Rating</label>
        <input id="communication_rating" name="communication_rating" type="number" class="form-control @error('communication_rating') is-invalid @enderror" value="{{ old('communication_rating', $item->communication_rating ?? '') }}" step="0.01">
        @error('communication_rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="overall_rating" class="form-label fw-semibold">Overall Rating</label>
        <input id="overall_rating" name="overall_rating" type="number" class="form-control @error('overall_rating') is-invalid @enderror" value="{{ old('overall_rating', $item->overall_rating ?? '') }}" step="0.01">
        @error('overall_rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="jobs_assigned" class="form-label fw-semibold">Jobs Assigned</label>
        <input id="jobs_assigned" name="jobs_assigned" type="number" class="form-control @error('jobs_assigned') is-invalid @enderror" value="{{ old('jobs_assigned', $item->jobs_assigned ?? '') }}">
        @error('jobs_assigned')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="jobs_completed" class="form-label fw-semibold">Jobs Completed</label>
        <input id="jobs_completed" name="jobs_completed" type="number" class="form-control @error('jobs_completed') is-invalid @enderror" value="{{ old('jobs_completed', $item->jobs_completed ?? '') }}">
        @error('jobs_completed')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="jobs_delayed" class="form-label fw-semibold">Jobs Delayed</label>
        <input id="jobs_delayed" name="jobs_delayed" type="number" class="form-control @error('jobs_delayed') is-invalid @enderror" value="{{ old('jobs_delayed', $item->jobs_delayed ?? '') }}">
        @error('jobs_delayed')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="sla_compliance_percentage" class="form-label fw-semibold">SLA Compliance %</label>
        <input id="sla_compliance_percentage" name="sla_compliance_percentage" type="number" class="form-control @error('sla_compliance_percentage') is-invalid @enderror" value="{{ old('sla_compliance_percentage', $item->sla_compliance_percentage ?? '') }}" step="0.01">
        @error('sla_compliance_percentage')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="strengths" class="form-label fw-semibold">Strengths</label>
        <textarea id="strengths" name="strengths" rows="3" class="form-control @error('strengths') is-invalid @enderror" placeholder="Enter strengths...">{{ old('strengths', $item->strengths ?? '') }}</textarea>
        @error('strengths')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="issues" class="form-label fw-semibold">Issues</label>
        <textarea id="issues" name="issues" rows="3" class="form-control @error('issues') is-invalid @enderror" placeholder="Enter issues...">{{ old('issues', $item->issues ?? '') }}</textarea>
        @error('issues')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="improvement_plan" class="form-label fw-semibold">Improvement Plan</label>
        <textarea id="improvement_plan" name="improvement_plan" rows="3" class="form-control @error('improvement_plan') is-invalid @enderror" placeholder="Enter improvement plan...">{{ old('improvement_plan', $item->improvement_plan ?? '') }}</textarea>
        @error('improvement_plan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="reviewer_id" class="form-label fw-semibold">Reviewer ID</label>
        <input id="reviewer_id" name="reviewer_id" type="number" class="form-control @error('reviewer_id') is-invalid @enderror" value="{{ old('reviewer_id', $item->reviewer_id ?? '') }}">
        @error('reviewer_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="review_date" class="form-label fw-semibold">Review Date <span class="text-danger">*</span></label>
        <input id="review_date" name="review_date" type="date" class="form-control @error('review_date') is-invalid @enderror" value="{{ old('review_date', $item->review_date ?? '') }}" required>
        @error('review_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="">Select Status</option> <option value="Draft" {{ old('status', $item->status ?? '') == 'Draft' ? 'selected' : '' }}>Draft</option> <option value="Completed" {{ old('status', $item->status ?? '') == 'Completed' ? 'selected' : '' }}>Completed</option> <option value="Approved" {{ old('status', $item->status ?? '') == 'Approved' ? 'selected' : '' }}>Approved</option> <option value="Cancelled" {{ old('status', $item->status ?? '') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="remarks" class="form-label fw-semibold">Remarks</label>
        <textarea id="remarks" name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror" placeholder="Enter remarks...">{{ old('remarks', $item->remarks ?? '') }}</textarea>
        @error('remarks')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

</div>
