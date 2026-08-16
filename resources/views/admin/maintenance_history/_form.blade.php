<div class="row">
    <div class="col-lg-4 col-md-6 mb-3">
        <label for="history_number" class="form-label fw-semibold">History Number <span class="text-danger">*</span></label>
        <input id="history_number" name="history_number" type="text" class="form-control @error('history_number') is-invalid @enderror" value="{{ old('history_number', $item->history_number ?? '') }}" required>
        @error('history_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="asset_id" class="form-label fw-semibold">Asset ID <span class="text-danger">*</span></label>
        <input id="asset_id" name="asset_id" type="number" class="form-control @error('asset_id') is-invalid @enderror" value="{{ old('asset_id', $item->asset_id ?? '') }}" required>
        @error('asset_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="work_order_id" class="form-label fw-semibold">Work Order ID</label>
        <input id="work_order_id" name="work_order_id" type="number" class="form-control @error('work_order_id') is-invalid @enderror" value="{{ old('work_order_id', $item->work_order_id ?? '') }}">
        @error('work_order_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="preventive_maintenance_id" class="form-label fw-semibold">Preventive Maintenance ID</label>
        <input id="preventive_maintenance_id" name="preventive_maintenance_id" type="number" class="form-control @error('preventive_maintenance_id') is-invalid @enderror" value="{{ old('preventive_maintenance_id', $item->preventive_maintenance_id ?? '') }}">
        @error('preventive_maintenance_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="maintenance_type" class="form-label fw-semibold">Maintenance Type <span class="text-danger">*</span></label>
        <input id="maintenance_type" name="maintenance_type" type="text" class="form-control @error('maintenance_type') is-invalid @enderror" value="{{ old('maintenance_type', $item->maintenance_type ?? '') }}" required>
        @error('maintenance_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="maintenance_date" class="form-label fw-semibold">Maintenance Date <span class="text-danger">*</span></label>
        <input id="maintenance_date" name="maintenance_date" type="date" class="form-control @error('maintenance_date') is-invalid @enderror" value="{{ old('maintenance_date', $item->maintenance_date ?? '') }}" required>
        @error('maintenance_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="description" class="form-label fw-semibold">Description</label>
        <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Enter description...">{{ old('description', $item->description ?? '') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="problem_reported" class="form-label fw-semibold">Problem Reported</label>
        <textarea id="problem_reported" name="problem_reported" rows="3" class="form-control @error('problem_reported') is-invalid @enderror" placeholder="Enter problem reported...">{{ old('problem_reported', $item->problem_reported ?? '') }}</textarea>
        @error('problem_reported')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="work_performed" class="form-label fw-semibold">Work Performed <span class="text-danger">*</span></label>
        <textarea id="work_performed" name="work_performed" rows="3" class="form-control @error('work_performed') is-invalid @enderror" placeholder="Enter work performed..." required>{{ old('work_performed', $item->work_performed ?? '') }}</textarea>
        @error('work_performed')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="findings" class="form-label fw-semibold">Findings</label>
        <textarea id="findings" name="findings" rows="3" class="form-control @error('findings') is-invalid @enderror" placeholder="Enter findings...">{{ old('findings', $item->findings ?? '') }}</textarea>
        @error('findings')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="parts_replaced" class="form-label fw-semibold">Parts Replaced</label>
        <textarea id="parts_replaced" name="parts_replaced" rows="3" class="form-control @error('parts_replaced') is-invalid @enderror" placeholder="Enter parts replaced...">{{ old('parts_replaced', $item->parts_replaced ?? '') }}</textarea>
        @error('parts_replaced')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="technician_id" class="form-label fw-semibold">Technician ID</label>
        <input id="technician_id" name="technician_id" type="number" class="form-control @error('technician_id') is-invalid @enderror" value="{{ old('technician_id', $item->technician_id ?? '') }}">
        @error('technician_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="vendor_id" class="form-label fw-semibold">Vendor ID</label>
        <input id="vendor_id" name="vendor_id" type="number" class="form-control @error('vendor_id') is-invalid @enderror" value="{{ old('vendor_id', $item->vendor_id ?? '') }}">
        @error('vendor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="downtime_hours" class="form-label fw-semibold">Downtime Hours</label>
        <input id="downtime_hours" name="downtime_hours" type="number" class="form-control @error('downtime_hours') is-invalid @enderror" value="{{ old('downtime_hours', $item->downtime_hours ?? '') }}" step="0.01">
        @error('downtime_hours')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="labour_cost" class="form-label fw-semibold">Labour Cost</label>
        <input id="labour_cost" name="labour_cost" type="number" class="form-control @error('labour_cost') is-invalid @enderror" value="{{ old('labour_cost', $item->labour_cost ?? '') }}" step="0.01">
        @error('labour_cost')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="material_cost" class="form-label fw-semibold">Material Cost</label>
        <input id="material_cost" name="material_cost" type="number" class="form-control @error('material_cost') is-invalid @enderror" value="{{ old('material_cost', $item->material_cost ?? '') }}" step="0.01">
        @error('material_cost')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="total_cost" class="form-label fw-semibold">Total Cost</label>
        <input id="total_cost" name="total_cost" type="number" class="form-control @error('total_cost') is-invalid @enderror" value="{{ old('total_cost', $item->total_cost ?? '') }}" step="0.01">
        @error('total_cost')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="condition_before" class="form-label fw-semibold">Condition Before</label>
        <select id="condition_before" name="condition_before" class="form-select @error('condition_before') is-invalid @enderror">
            <option value="">Select Condition Before</option> <option value="Excellent" {{ old('condition_before', $item->condition_before ?? '') == 'Excellent' ? 'selected' : '' }}>Excellent</option> <option value="Good" {{ old('condition_before', $item->condition_before ?? '') == 'Good' ? 'selected' : '' }}>Good</option> <option value="Fair" {{ old('condition_before', $item->condition_before ?? '') == 'Fair' ? 'selected' : '' }}>Fair</option> <option value="Poor" {{ old('condition_before', $item->condition_before ?? '') == 'Poor' ? 'selected' : '' }}>Poor</option> <option value="Critical" {{ old('condition_before', $item->condition_before ?? '') == 'Critical' ? 'selected' : '' }}>Critical</option>
        </select>
        @error('condition_before')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="condition_after" class="form-label fw-semibold">Condition After</label>
        <select id="condition_after" name="condition_after" class="form-select @error('condition_after') is-invalid @enderror">
            <option value="">Select Condition After</option> <option value="Excellent" {{ old('condition_after', $item->condition_after ?? '') == 'Excellent' ? 'selected' : '' }}>Excellent</option> <option value="Good" {{ old('condition_after', $item->condition_after ?? '') == 'Good' ? 'selected' : '' }}>Good</option> <option value="Fair" {{ old('condition_after', $item->condition_after ?? '') == 'Fair' ? 'selected' : '' }}>Fair</option> <option value="Poor" {{ old('condition_after', $item->condition_after ?? '') == 'Poor' ? 'selected' : '' }}>Poor</option> <option value="Critical" {{ old('condition_after', $item->condition_after ?? '') == 'Critical' ? 'selected' : '' }}>Critical</option>
        </select>
        @error('condition_after')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="warranty_claim" class="form-label fw-semibold">Warranty Claim</label>
        <select id="warranty_claim" name="warranty_claim" class="form-select @error('warranty_claim') is-invalid @enderror">
            <option value="">Select Warranty Claim</option> <option value="0" {{ old('warranty_claim', $item->warranty_claim ?? '') == '0' ? 'selected' : '' }}>No</option> <option value="1" {{ old('warranty_claim', $item->warranty_claim ?? '') == '1' ? 'selected' : '' }}>Yes</option>
        </select>
        @error('warranty_claim')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="next_maintenance_date" class="form-label fw-semibold">Next Maintenance Date</label>
        <input id="next_maintenance_date" name="next_maintenance_date" type="date" class="form-control @error('next_maintenance_date') is-invalid @enderror" value="{{ old('next_maintenance_date', $item->next_maintenance_date ?? '') }}">
        @error('next_maintenance_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="">Select Status</option> <option value="Completed" {{ old('status', $item->status ?? '') == 'Completed' ? 'selected' : '' }}>Completed</option> <option value="Cancelled" {{ old('status', $item->status ?? '') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option> <option value="Failed" {{ old('status', $item->status ?? '') == 'Failed' ? 'selected' : '' }}>Failed</option>
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="remarks" class="form-label fw-semibold">Remarks</label>
        <textarea id="remarks" name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror" placeholder="Enter remarks...">{{ old('remarks', $item->remarks ?? '') }}</textarea>
        @error('remarks')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

</div>
