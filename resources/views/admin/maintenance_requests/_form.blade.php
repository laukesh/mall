<div class="row">
    <div class="col-lg-4 col-md-6 mb-3">
        <label for="maintenance_number" class="form-label fw-semibold">Maintenance Number <span class="text-danger">*</span></label>
        <input id="maintenance_number" name="maintenance_number" type="text" class="form-control @error('maintenance_number') is-invalid @enderror" value="{{ old('maintenance_number', $item->maintenance_number ?? '') }}" required>
        @error('maintenance_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="service_request_id" class="form-label fw-semibold">Service Request ID <span class="text-danger">*</span></label>
        <input id="service_request_id" name="service_request_id" type="number" class="form-control @error('service_request_id') is-invalid @enderror" value="{{ old('service_request_id', $item->service_request_id ?? '') }}" required>
        @error('service_request_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="unit_id" class="form-label fw-semibold">Unit ID</label>
        <input id="unit_id" name="unit_id" type="number" class="form-control @error('unit_id') is-invalid @enderror" value="{{ old('unit_id', $item->unit_id ?? '') }}">
        @error('unit_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="category" class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
        <input id="category" name="category" type="text" class="form-control @error('category') is-invalid @enderror" value="{{ old('category', $item->category ?? '') }}" required>
        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="sub_category" class="form-label fw-semibold">Sub Category</label>
        <input id="sub_category" name="sub_category" type="text" class="form-control @error('sub_category') is-invalid @enderror" value="{{ old('sub_category', $item->sub_category ?? '') }}">
        @error('sub_category')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
        <input id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $item->title ?? '') }}" required>
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="description" class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
        <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Enter description..." required>{{ old('description', $item->description ?? '') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="assessment" class="form-label fw-semibold">Assessment</label>
        <textarea id="assessment" name="assessment" rows="3" class="form-control @error('assessment') is-invalid @enderror" placeholder="Enter assessment...">{{ old('assessment', $item->assessment ?? '') }}</textarea>
        @error('assessment')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="priority" class="form-label fw-semibold">Priority <span class="text-danger">*</span></label>
        <select id="priority" name="priority" class="form-select @error('priority') is-invalid @enderror" required>
            <option value="">Select Priority</option> <option value="Low" {{ old('priority', $item->priority ?? '') == 'Low' ? 'selected' : '' }}>Low</option> <option value="Medium" {{ old('priority', $item->priority ?? '') == 'Medium' ? 'selected' : '' }}>Medium</option> <option value="High" {{ old('priority', $item->priority ?? '') == 'High' ? 'selected' : '' }}>High</option> <option value="Critical" {{ old('priority', $item->priority ?? '') == 'Critical' ? 'selected' : '' }}>Critical</option>
        </select>
        @error('priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
        <label for="planned_start_date" class="form-label fw-semibold">Planned Start Date</label>
        <input id="planned_start_date" name="planned_start_date" type="date" class="form-control @error('planned_start_date') is-invalid @enderror" value="{{ old('planned_start_date', $item->planned_start_date ?? '') }}">
        @error('planned_start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="planned_end_date" class="form-label fw-semibold">Planned End Date</label>
        <input id="planned_end_date" name="planned_end_date" type="date" class="form-control @error('planned_end_date') is-invalid @enderror" value="{{ old('planned_end_date', $item->planned_end_date ?? '') }}">
        @error('planned_end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="">Select Status</option> <option value="Open" {{ old('status', $item->status ?? '') == 'Open' ? 'selected' : '' }}>Open</option> <option value="Under Assessment" {{ old('status', $item->status ?? '') == 'Under Assessment' ? 'selected' : '' }}>Under Assessment</option> <option value="Assigned" {{ old('status', $item->status ?? '') == 'Assigned' ? 'selected' : '' }}>Assigned</option> <option value="Scheduled" {{ old('status', $item->status ?? '') == 'Scheduled' ? 'selected' : '' }}>Scheduled</option> <option value="In Progress" {{ old('status', $item->status ?? '') == 'In Progress' ? 'selected' : '' }}>In Progress</option> <option value="On Hold" {{ old('status', $item->status ?? '') == 'On Hold' ? 'selected' : '' }}>On Hold</option> <option value="Resolved" {{ old('status', $item->status ?? '') == 'Resolved' ? 'selected' : '' }}>Resolved</option> <option value="Closed" {{ old('status', $item->status ?? '') == 'Closed' ? 'selected' : '' }}>Closed</option> <option value="Cancelled" {{ old('status', $item->status ?? '') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
        <label for="closed_at" class="form-label fw-semibold">Closed At</label>
        <input id="closed_at" name="closed_at" type="datetime-local" class="form-control @error('closed_at') is-invalid @enderror" value="{{ old('closed_at', $item->closed_at ?? '') }}">
        @error('closed_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

</div>
