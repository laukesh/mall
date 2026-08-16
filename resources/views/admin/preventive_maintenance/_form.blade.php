<div class="row">
    <div class="col-lg-4 col-md-6 mb-3">
        <label for="asset_id" class="form-label fw-semibold">Asset ID <span class="text-danger">*</span></label>
        <input id="asset_id" name="asset_id" type="number" class="form-control @error('asset_id') is-invalid @enderror" value="{{ old('asset_id', $item->asset_id ?? '') }}" required>
        @error('asset_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="maintenance_code" class="form-label fw-semibold">Maintenance Code <span class="text-danger">*</span></label>
        <input id="maintenance_code" name="maintenance_code" type="text" class="form-control @error('maintenance_code') is-invalid @enderror" value="{{ old('maintenance_code', $item->maintenance_code ?? '') }}" required>
        @error('maintenance_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="maintenance_title" class="form-label fw-semibold">Maintenance Title <span class="text-danger">*</span></label>
        <input id="maintenance_title" name="maintenance_title" type="text" class="form-control @error('maintenance_title') is-invalid @enderror" value="{{ old('maintenance_title', $item->maintenance_title ?? '') }}" required>
        @error('maintenance_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="description" class="form-label fw-semibold">Description</label>
        <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Enter description...">{{ old('description', $item->description ?? '') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="maintenance_type" class="form-label fw-semibold">Maintenance Type <span class="text-danger">*</span></label>
        <input id="maintenance_type" name="maintenance_type" type="text" class="form-control @error('maintenance_type') is-invalid @enderror" value="{{ old('maintenance_type', $item->maintenance_type ?? '') }}" required>
        @error('maintenance_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="frequency" class="form-label fw-semibold">Frequency <span class="text-danger">*</span></label>
        <select id="frequency" name="frequency" class="form-select @error('frequency') is-invalid @enderror" required>
            <option value="">Select Frequency</option> <option value="Daily" {{ old('frequency', $item->frequency ?? '') == 'Daily' ? 'selected' : '' }}>Daily</option> <option value="Weekly" {{ old('frequency', $item->frequency ?? '') == 'Weekly' ? 'selected' : '' }}>Weekly</option> <option value="Monthly" {{ old('frequency', $item->frequency ?? '') == 'Monthly' ? 'selected' : '' }}>Monthly</option> <option value="Quarterly" {{ old('frequency', $item->frequency ?? '') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option> <option value="Half-Yearly" {{ old('frequency', $item->frequency ?? '') == 'Half-Yearly' ? 'selected' : '' }}>Half-Yearly</option> <option value="Yearly" {{ old('frequency', $item->frequency ?? '') == 'Yearly' ? 'selected' : '' }}>Yearly</option> <option value="Custom" {{ old('frequency', $item->frequency ?? '') == 'Custom' ? 'selected' : '' }}>Custom</option>
        </select>
        @error('frequency')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="frequency_value" class="form-label fw-semibold">Frequency Value <span class="text-danger">*</span></label>
        <input id="frequency_value" name="frequency_value" type="number" class="form-control @error('frequency_value') is-invalid @enderror" value="{{ old('frequency_value', $item->frequency_value ?? '') }}" required>
        @error('frequency_value')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="last_maintenance_date" class="form-label fw-semibold">Last Maintenance Date</label>
        <input id="last_maintenance_date" name="last_maintenance_date" type="date" class="form-control @error('last_maintenance_date') is-invalid @enderror" value="{{ old('last_maintenance_date', $item->last_maintenance_date ?? '') }}">
        @error('last_maintenance_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="next_due_date" class="form-label fw-semibold">Next Due Date</label>
        <input id="next_due_date" name="next_due_date" type="date" class="form-control @error('next_due_date') is-invalid @enderror" value="{{ old('next_due_date', $item->next_due_date ?? '') }}">
        @error('next_due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="estimated_hours" class="form-label fw-semibold">Estimated Hours</label>
        <input id="estimated_hours" name="estimated_hours" type="number" class="form-control @error('estimated_hours') is-invalid @enderror" value="{{ old('estimated_hours', $item->estimated_hours ?? '') }}" step="0.01">
        @error('estimated_hours')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="estimated_cost" class="form-label fw-semibold">Estimated Cost</label>
        <input id="estimated_cost" name="estimated_cost" type="number" class="form-control @error('estimated_cost') is-invalid @enderror" value="{{ old('estimated_cost', $item->estimated_cost ?? '') }}" step="0.01">
        @error('estimated_cost')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="assigned_department_id" class="form-label fw-semibold">Assigned Department ID</label>
        <input id="assigned_department_id" name="assigned_department_id" type="number" class="form-control @error('assigned_department_id') is-invalid @enderror" value="{{ old('assigned_department_id', $item->assigned_department_id ?? '') }}" step="0.01">
        @error('assigned_department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
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

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="checklist" class="form-label fw-semibold">Checklist</label>
        <textarea id="checklist" name="checklist" rows="3" class="form-control @error('checklist') is-invalid @enderror" placeholder="Enter checklist...">{{ old('checklist', $item->checklist ?? '') }}</textarea>
        @error('checklist')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="reminder_days" class="form-label fw-semibold">Reminder Days</label>
        <input id="reminder_days" name="reminder_days" type="number" class="form-control @error('reminder_days') is-invalid @enderror" value="{{ old('reminder_days', $item->reminder_days ?? '') }}">
        @error('reminder_days')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="">Select Status</option> <option value="Active" {{ old('status', $item->status ?? '') == 'Active' ? 'selected' : '' }}>Active</option> <option value="Inactive" {{ old('status', $item->status ?? '') == 'Inactive' ? 'selected' : '' }}>Inactive</option> <option value="Completed" {{ old('status', $item->status ?? '') == 'Completed' ? 'selected' : '' }}>Completed</option> <option value="Cancelled" {{ old('status', $item->status ?? '') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="remarks" class="form-label fw-semibold">Remarks</label>
        <textarea id="remarks" name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror" placeholder="Enter remarks...">{{ old('remarks', $item->remarks ?? '') }}</textarea>
        @error('remarks')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

</div>
