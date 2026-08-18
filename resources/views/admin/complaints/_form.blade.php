<div class="row">
    <div class="col-lg-4 col-md-6 mb-3">
        <label for="complaint_number" class="form-label fw-semibold">Complaint Number <span class="text-danger">*</span></label>
        <input id="complaint_number" name="complaint_number" type="text" class="form-control @error('complaint_number') is-invalid @enderror" value="{{ old('complaint_number', $item->complaint_number ?? '') }}" required>
        @error('complaint_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="tenant_id" class="form-label fw-semibold">Tenant ID</label>
        <input id="tenant_id" name="tenant_id" type="number" class="form-control @error('tenant_id') is-invalid @enderror" value="{{ old('tenant_id', $item->tenant_id ?? '') }}">
        @error('tenant_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="raised_by" class="form-label fw-semibold">Raised By</label>
        <input id="raised_by" name="raised_by" type="number" class="form-control @error('raised_by') is-invalid @enderror" value="{{ old('raised_by', $item->raised_by ?? '') }}">
        @error('raised_by')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
        <label for="complaint_category" class="form-label fw-semibold">Complaint Category <span class="text-danger">*</span></label>
        <input id="complaint_category" name="complaint_category" type="text" class="form-control @error('complaint_category') is-invalid @enderror" value="{{ old('complaint_category', $item->complaint_category ?? '') }}" required>
        @error('complaint_category')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="subject" class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
        <input id="subject" name="subject" type="text" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject', $item->subject ?? '') }}" required>
        @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="description" class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
        <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Enter description..." required>{{ old('description', $item->description ?? '') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="priority" class="form-label fw-semibold">Priority <span class="text-danger">*</span></label>
        <select id="priority" name="priority" class="form-select @error('priority') is-invalid @enderror" required>
            <option value="">Select Priority</option> <option value="Low" {{ old('priority', $item->priority ?? '') == 'Low' ? 'selected' : '' }}>Low</option> <option value="Medium" {{ old('priority', $item->priority ?? '') == 'Medium' ? 'selected' : '' }}>Medium</option> <option value="High" {{ old('priority', $item->priority ?? '') == 'High' ? 'selected' : '' }}>High</option> <option value="Critical" {{ old('priority', $item->priority ?? '') == 'Critical' ? 'selected' : '' }}>Critical</option>
        </select>
        @error('priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="assigned_to" class="form-label fw-semibold">Assigned To</label>
        <input id="assigned_to" name="assigned_to" type="number" class="form-control @error('assigned_to') is-invalid @enderror" value="{{ old('assigned_to', $item->assigned_to ?? '') }}">
        @error('assigned_to')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="service_request_id" class="form-label fw-semibold">Service Request ID</label>
        <input id="service_request_id" name="service_request_id" type="number" class="form-control @error('service_request_id') is-invalid @enderror" value="{{ old('service_request_id', $item->service_request_id ?? '') }}">
        @error('service_request_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="resolution_notes" class="form-label fw-semibold">Resolution Notes</label>
        <textarea id="resolution_notes" name="resolution_notes" rows="3" class="form-control @error('resolution_notes') is-invalid @enderror" placeholder="Enter resolution notes...">{{ old('resolution_notes', $item->resolution_notes ?? '') }}</textarea>
        @error('resolution_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="resolved_at" class="form-label fw-semibold">Resolved At</label>
        <input id="resolved_at" name="resolved_at" type="datetime-local" class="form-control @error('resolved_at') is-invalid @enderror" value="{{ old('resolved_at', $item->resolved_at ?? '') }}">
        @error('resolved_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="">Select Status</option> <option value="Open" {{ old('status', $item->status ?? '') == 'Open' ? 'selected' : '' }}>Open</option> <option value="Assigned" {{ old('status', $item->status ?? '') == 'Assigned' ? 'selected' : '' }}>Assigned</option> <option value="Under Investigation" {{ old('status', $item->status ?? '') == 'Under Investigation' ? 'selected' : '' }}>Under Investigation</option> <option value="In Progress" {{ old('status', $item->status ?? '') == 'In Progress' ? 'selected' : '' }}>In Progress</option> <option value="Resolved" {{ old('status', $item->status ?? '') == 'Resolved' ? 'selected' : '' }}>Resolved</option> <option value="Closed" {{ old('status', $item->status ?? '') == 'Closed' ? 'selected' : '' }}>Closed</option> <option value="Rejected" {{ old('status', $item->status ?? '') == 'Rejected' ? 'selected' : '' }}>Rejected</option> <option value="Cancelled" {{ old('status', $item->status ?? '') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

</div>
