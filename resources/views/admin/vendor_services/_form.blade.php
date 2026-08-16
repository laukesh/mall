<div class="row">
    <div class="col-lg-4 col-md-6 mb-3">
        <label for="vendor_user_id" class="form-label fw-semibold">Vendor User ID <span class="text-danger">*</span></label>
        <input id="vendor_user_id" name="vendor_user_id" type="number" class="form-control @error('vendor_user_id') is-invalid @enderror" value="{{ old('vendor_user_id', $item->vendor_user_id ?? '') }}" required>
        @error('vendor_user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="service_name" class="form-label fw-semibold">Service Name <span class="text-danger">*</span></label>
        <input id="service_name" name="service_name" type="text" class="form-control @error('service_name') is-invalid @enderror" value="{{ old('service_name', $item->service_name ?? '') }}" required>
        @error('service_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="service_category" class="form-label fw-semibold">Service Category</label>
        <input id="service_category" name="service_category" type="text" class="form-control @error('service_category') is-invalid @enderror" value="{{ old('service_category', $item->service_category ?? '') }}">
        @error('service_category')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="description" class="form-label fw-semibold">Description</label>
        <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Enter description...">{{ old('description', $item->description ?? '') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="service_rate" class="form-label fw-semibold">Service Rate</label>
        <input id="service_rate" name="service_rate" type="number" class="form-control @error('service_rate') is-invalid @enderror" value="{{ old('service_rate', $item->service_rate ?? '') }}" step="0.01">
        @error('service_rate')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="rate_unit" class="form-label fw-semibold">Rate Unit</label>
        <input id="rate_unit" name="rate_unit" type="text" class="form-control @error('rate_unit') is-invalid @enderror" value="{{ old('rate_unit', $item->rate_unit ?? '') }}">
        @error('rate_unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="emergency_available" class="form-label fw-semibold">Emergency Available</label>
        <select id="emergency_available" name="emergency_available" class="form-select @error('emergency_available') is-invalid @enderror">
            <option value="">Select Emergency Available</option> <option value="0" {{ old('emergency_available', $item->emergency_available ?? '') == '0' ? 'selected' : '' }}>No</option> <option value="1" {{ old('emergency_available', $item->emergency_available ?? '') == '1' ? 'selected' : '' }}>Yes</option>
        </select>
        @error('emergency_available')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="">Select Status</option> <option value="Active" {{ old('status', $item->status ?? '') == 'Active' ? 'selected' : '' }}>Active</option> <option value="Inactive" {{ old('status', $item->status ?? '') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="remarks" class="form-label fw-semibold">Remarks</label>
        <textarea id="remarks" name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror" placeholder="Enter remarks...">{{ old('remarks', $item->remarks ?? '') }}</textarea>
        @error('remarks')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

</div>
