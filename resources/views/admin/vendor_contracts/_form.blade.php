<div class="row">
    <div class="col-lg-4 col-md-6 mb-3">
        <label for="contract_number" class="form-label fw-semibold">Contract Number <span class="text-danger">*</span></label>
        <input id="contract_number" name="contract_number" type="text" class="form-control @error('contract_number') is-invalid @enderror" value="{{ old('contract_number', $item->contract_number ?? '') }}" required>
        @error('contract_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="vendor_user_id" class="form-label fw-semibold">Vendor User ID <span class="text-danger">*</span></label>
        <input id="vendor_user_id" name="vendor_user_id" type="number" class="form-control @error('vendor_user_id') is-invalid @enderror" value="{{ old('vendor_user_id', $item->vendor_user_id ?? '') }}" required>
        @error('vendor_user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="contract_title" class="form-label fw-semibold">Contract Title <span class="text-danger">*</span></label>
        <input id="contract_title" name="contract_title" type="text" class="form-control @error('contract_title') is-invalid @enderror" value="{{ old('contract_title', $item->contract_title ?? '') }}" required>
        @error('contract_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="contract_type" class="form-label fw-semibold">Contract Type <span class="text-danger">*</span></label>
        <input id="contract_type" name="contract_type" type="text" class="form-control @error('contract_type') is-invalid @enderror" value="{{ old('contract_type', $item->contract_type ?? '') }}" required>
        @error('contract_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="description" class="form-label fw-semibold">Description</label>
        <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Enter description...">{{ old('description', $item->description ?? '') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="start_date" class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
        <input id="start_date" name="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $item->start_date ?? '') }}" required>
        @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="end_date" class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
        <input id="end_date" name="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $item->end_date ?? '') }}" required>
        @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="contract_value" class="form-label fw-semibold">Contract Value</label>
        <input id="contract_value" name="contract_value" type="number" class="form-control @error('contract_value') is-invalid @enderror" value="{{ old('contract_value', $item->contract_value ?? '') }}" step="0.01">
        @error('contract_value')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="payment_terms" class="form-label fw-semibold">Payment Terms</label>
        <textarea id="payment_terms" name="payment_terms" rows="3" class="form-control @error('payment_terms') is-invalid @enderror" placeholder="Enter payment terms...">{{ old('payment_terms', $item->payment_terms ?? '') }}</textarea>
        @error('payment_terms')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="renewal_type" class="form-label fw-semibold">Renewal Type <span class="text-danger">*</span></label>
        <select id="renewal_type" name="renewal_type" class="form-select @error('renewal_type') is-invalid @enderror" required>
            <option value="">Select Renewal Type</option> <option value="Manual" {{ old('renewal_type', $item->renewal_type ?? '') == 'Manual' ? 'selected' : '' }}>Manual</option> <option value="Automatic" {{ old('renewal_type', $item->renewal_type ?? '') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
        </select>
        @error('renewal_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="renewal_date" class="form-label fw-semibold">Renewal Date</label>
        <input id="renewal_date" name="renewal_date" type="date" class="form-control @error('renewal_date') is-invalid @enderror" value="{{ old('renewal_date', $item->renewal_date ?? '') }}">
        @error('renewal_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="notice_period_days" class="form-label fw-semibold">Notice Period Days</label>
        <input id="notice_period_days" name="notice_period_days" type="number" class="form-control @error('notice_period_days') is-invalid @enderror" value="{{ old('notice_period_days', $item->notice_period_days ?? '') }}">
        @error('notice_period_days')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="document_path" class="form-label fw-semibold">Document Path</label>
        <input id="document_path" name="document_path" type="text" class="form-control @error('document_path') is-invalid @enderror" value="{{ old('document_path', $item->document_path ?? '') }}">
        @error('document_path')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="">Select Status</option> <option value="Draft" {{ old('status', $item->status ?? '') == 'Draft' ? 'selected' : '' }}>Draft</option> <option value="Active" {{ old('status', $item->status ?? '') == 'Active' ? 'selected' : '' }}>Active</option> <option value="Expired" {{ old('status', $item->status ?? '') == 'Expired' ? 'selected' : '' }}>Expired</option> <option value="Terminated" {{ old('status', $item->status ?? '') == 'Terminated' ? 'selected' : '' }}>Terminated</option> <option value="Renewed" {{ old('status', $item->status ?? '') == 'Renewed' ? 'selected' : '' }}>Renewed</option> <option value="Cancelled" {{ old('status', $item->status ?? '') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="remarks" class="form-label fw-semibold">Remarks</label>
        <textarea id="remarks" name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror" placeholder="Enter remarks...">{{ old('remarks', $item->remarks ?? '') }}</textarea>
        @error('remarks')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

</div>
