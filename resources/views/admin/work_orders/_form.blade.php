<div class="row">
    <div class="col-lg-4 col-md-6 mb-3">
        <label for="work_order_number" class="form-label fw-semibold">Work Order Number <span class="text-danger">*</span></label>
        <input id="work_order_number" name="work_order_number" type="text" class="form-control @error('work_order_number') is-invalid @enderror" value="{{ old('work_order_number', $item->work_order_number ?? '') }}" required>
        @error('work_order_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="maintenance_request_id" class="form-label fw-semibold">Maintenance Request ID <span class="text-danger">*</span></label>
        <input id="maintenance_request_id" name="maintenance_request_id" type="number" class="form-control @error('maintenance_request_id') is-invalid @enderror" value="{{ old('maintenance_request_id', $item->maintenance_request_id ?? '') }}" step="0.01" required>
        @error('maintenance_request_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="unit_id" class="form-label fw-semibold">Unit ID</label>
        <input id="unit_id" name="unit_id" type="number" class="form-control @error('unit_id') is-invalid @enderror" value="{{ old('unit_id', $item->unit_id ?? '') }}">
        @error('unit_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="department_id" class="form-label fw-semibold">Department ID</label>
        <input id="department_id" name="department_id" type="number" class="form-control @error('department_id') is-invalid @enderror" value="{{ old('department_id', $item->department_id ?? '') }}">
        @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="assigned_to" class="form-label fw-semibold">Assigned To</label>
        <input id="assigned_to" name="assigned_to" type="number" class="form-control @error('assigned_to') is-invalid @enderror" value="{{ old('assigned_to', $item->assigned_to ?? '') }}">
        @error('assigned_to')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="vendor_id" class="form-label fw-semibold">Vendor ID</label>
        <input id="vendor_id" name="vendor_id" type="number" class="form-control @error('vendor_id') is-invalid @enderror" value="{{ old('vendor_id', $item->vendor_id ?? '') }}">
        @error('vendor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="work_title" class="form-label fw-semibold">Work Title <span class="text-danger">*</span></label>
        <input id="work_title" name="work_title" type="text" class="form-control @error('work_title') is-invalid @enderror" value="{{ old('work_title', $item->work_title ?? '') }}" required>
        @error('work_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="work_description" class="form-label fw-semibold">Work Description <span class="text-danger">*</span></label>
        <textarea id="work_description" name="work_description" rows="3" class="form-control @error('work_description') is-invalid @enderror" placeholder="Enter work description..." required>{{ old('work_description', $item->work_description ?? '') }}</textarea>
        @error('work_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="priority" class="form-label fw-semibold">Priority <span class="text-danger">*</span></label>
        <select id="priority" name="priority" class="form-select @error('priority') is-invalid @enderror" required>
            <option value="">Select Priority</option> <option value="Low" {{ old('priority', $item->priority ?? '') == 'Low' ? 'selected' : '' }}>Low</option> <option value="Medium" {{ old('priority', $item->priority ?? '') == 'Medium' ? 'selected' : '' }}>Medium</option> <option value="High" {{ old('priority', $item->priority ?? '') == 'High' ? 'selected' : '' }}>High</option> <option value="Critical" {{ old('priority', $item->priority ?? '') == 'Critical' ? 'selected' : '' }}>Critical</option>
        </select>
        @error('priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="scheduled_start" class="form-label fw-semibold">Scheduled Start</label>
        <input id="scheduled_start" name="scheduled_start" type="datetime-local" class="form-control @error('scheduled_start') is-invalid @enderror" value="{{ old('scheduled_start', $item->scheduled_start ?? '') }}">
        @error('scheduled_start')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="scheduled_end" class="form-label fw-semibold">Scheduled End</label>
        <input id="scheduled_end" name="scheduled_end" type="datetime-local" class="form-control @error('scheduled_end') is-invalid @enderror" value="{{ old('scheduled_end', $item->scheduled_end ?? '') }}">
        @error('scheduled_end')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="actual_start" class="form-label fw-semibold">Actual Start</label>
        <input id="actual_start" name="actual_start" type="datetime-local" class="form-control @error('actual_start') is-invalid @enderror" value="{{ old('actual_start', $item->actual_start ?? '') }}">
        @error('actual_start')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="actual_end" class="form-label fw-semibold">Actual End</label>
        <input id="actual_end" name="actual_end" type="datetime-local" class="form-control @error('actual_end') is-invalid @enderror" value="{{ old('actual_end', $item->actual_end ?? '') }}">
        @error('actual_end')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="estimated_cost" class="form-label fw-semibold">Estimated Cost</label>
        <input id="estimated_cost" name="estimated_cost" type="number" class="form-control @error('estimated_cost') is-invalid @enderror" value="{{ old('estimated_cost', $item->estimated_cost ?? '') }}" step="0.01">
        @error('estimated_cost')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="actual_cost" class="form-label fw-semibold">Actual Cost</label>
        <input id="actual_cost" name="actual_cost" type="number" class="form-control @error('actual_cost') is-invalid @enderror" value="{{ old('actual_cost', $item->actual_cost ?? '') }}" step="0.01">
        @error('actual_cost')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="completion_percentage" class="form-label fw-semibold">Completion Percentage</label>
        <input id="completion_percentage" name="completion_percentage" type="number" class="form-control @error('completion_percentage') is-invalid @enderror" value="{{ old('completion_percentage', $item->completion_percentage ?? '') }}" step="0.01">
        @error('completion_percentage')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="">Select Status</option> <option value="Draft" {{ old('status', $item->status ?? '') == 'Draft' ? 'selected' : '' }}>Draft</option> <option value="Assigned" {{ old('status', $item->status ?? '') == 'Assigned' ? 'selected' : '' }}>Assigned</option> <option value="Scheduled" {{ old('status', $item->status ?? '') == 'Scheduled' ? 'selected' : '' }}>Scheduled</option> <option value="In Progress" {{ old('status', $item->status ?? '') == 'In Progress' ? 'selected' : '' }}>In Progress</option> <option value="On Hold" {{ old('status', $item->status ?? '') == 'On Hold' ? 'selected' : '' }}>On Hold</option> <option value="Completed" {{ old('status', $item->status ?? '') == 'Completed' ? 'selected' : '' }}>Completed</option> <option value="Verified" {{ old('status', $item->status ?? '') == 'Verified' ? 'selected' : '' }}>Verified</option> <option value="Cancelled" {{ old('status', $item->status ?? '') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="completion_notes" class="form-label fw-semibold">Completion Notes</label>
        <textarea id="completion_notes" name="completion_notes" rows="3" class="form-control @error('completion_notes') is-invalid @enderror" placeholder="Enter completion notes...">{{ old('completion_notes', $item->completion_notes ?? '') }}</textarea>
        @error('completion_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="verification_notes" class="form-label fw-semibold">Verification Notes</label>
        <textarea id="verification_notes" name="verification_notes" rows="3" class="form-control @error('verification_notes') is-invalid @enderror" placeholder="Enter verification notes...">{{ old('verification_notes', $item->verification_notes ?? '') }}</textarea>
        @error('verification_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="verified_by" class="form-label fw-semibold">Verified By</label>
        <input id="verified_by" name="verified_by" type="number" class="form-control @error('verified_by') is-invalid @enderror" value="{{ old('verified_by', $item->verified_by ?? '') }}">
        @error('verified_by')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="verified_at" class="form-label fw-semibold">Verified At</label>
        <input id="verified_at" name="verified_at" type="datetime-local" class="form-control @error('verified_at') is-invalid @enderror" value="{{ old('verified_at', $item->verified_at ?? '') }}">
        @error('verified_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

</div>
