<div class="row">
    <div class="col-lg-4 col-md-6 mb-3">
        <label for="payment_number" class="form-label fw-semibold">Payment Number <span class="text-danger">*</span></label>
        <input id="payment_number" name="payment_number" type="text" class="form-control @error('payment_number') is-invalid @enderror" value="{{ old('payment_number', $item->payment_number ?? '') }}" required>
        @error('payment_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

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
        <label for="invoice_number" class="form-label fw-semibold">Invoice Number</label>
        <input id="invoice_number" name="invoice_number" type="text" class="form-control @error('invoice_number') is-invalid @enderror" value="{{ old('invoice_number', $item->invoice_number ?? '') }}">
        @error('invoice_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="invoice_date" class="form-label fw-semibold">Invoice Date</label>
        <input id="invoice_date" name="invoice_date" type="date" class="form-control @error('invoice_date') is-invalid @enderror" value="{{ old('invoice_date', $item->invoice_date ?? '') }}">
        @error('invoice_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="invoice_amount" class="form-label fw-semibold">Invoice Amount</label>
        <input id="invoice_amount" name="invoice_amount" type="number" class="form-control @error('invoice_amount') is-invalid @enderror" value="{{ old('invoice_amount', $item->invoice_amount ?? '') }}" step="0.01">
        @error('invoice_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="tax_amount" class="form-label fw-semibold">Tax Amount</label>
        <input id="tax_amount" name="tax_amount" type="number" class="form-control @error('tax_amount') is-invalid @enderror" value="{{ old('tax_amount', $item->tax_amount ?? '') }}" step="0.01">
        @error('tax_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="tds_amount" class="form-label fw-semibold">TDS Amount</label>
        <input id="tds_amount" name="tds_amount" type="number" class="form-control @error('tds_amount') is-invalid @enderror" value="{{ old('tds_amount', $item->tds_amount ?? '') }}" step="0.01">
        @error('tds_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="other_deduction" class="form-label fw-semibold">Other Deduction</label>
        <input id="other_deduction" name="other_deduction" type="number" class="form-control @error('other_deduction') is-invalid @enderror" value="{{ old('other_deduction', $item->other_deduction ?? '') }}" step="0.01">
        @error('other_deduction')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="net_amount" class="form-label fw-semibold">Net Amount</label>
        <input id="net_amount" name="net_amount" type="number" class="form-control @error('net_amount') is-invalid @enderror" value="{{ old('net_amount', $item->net_amount ?? '') }}" step="0.01">
        @error('net_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="payment_date" class="form-label fw-semibold">Payment Date</label>
        <input id="payment_date" name="payment_date" type="date" class="form-control @error('payment_date') is-invalid @enderror" value="{{ old('payment_date', $item->payment_date ?? '') }}">
        @error('payment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="payment_method" class="form-label fw-semibold">Payment Method</label>
        <select id="payment_method" name="payment_method" class="form-select @error('payment_method') is-invalid @enderror">
            <option value="">Select Payment Method</option> <option value="Bank Transfer" {{ old('payment_method', $item->payment_method ?? '') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option> <option value="Cheque" {{ old('payment_method', $item->payment_method ?? '') == 'Cheque' ? 'selected' : '' }}>Cheque</option> <option value="Cash" {{ old('payment_method', $item->payment_method ?? '') == 'Cash' ? 'selected' : '' }}>Cash</option> <option value="UPI" {{ old('payment_method', $item->payment_method ?? '') == 'UPI' ? 'selected' : '' }}>UPI</option> <option value="Other" {{ old('payment_method', $item->payment_method ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
        </select>
        @error('payment_method')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="transaction_reference" class="form-label fw-semibold">Transaction Reference</label>
        <input id="transaction_reference" name="transaction_reference" type="text" class="form-control @error('transaction_reference') is-invalid @enderror" value="{{ old('transaction_reference', $item->transaction_reference ?? '') }}">
        @error('transaction_reference')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="">Select Status</option> <option value="Pending" {{ old('status', $item->status ?? '') == 'Pending' ? 'selected' : '' }}>Pending</option> <option value="Approved" {{ old('status', $item->status ?? '') == 'Approved' ? 'selected' : '' }}>Approved</option> <option value="Processing" {{ old('status', $item->status ?? '') == 'Processing' ? 'selected' : '' }}>Processing</option> <option value="Paid" {{ old('status', $item->status ?? '') == 'Paid' ? 'selected' : '' }}>Paid</option> <option value="Rejected" {{ old('status', $item->status ?? '') == 'Rejected' ? 'selected' : '' }}>Rejected</option> <option value="Cancelled" {{ old('status', $item->status ?? '') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="remarks" class="form-label fw-semibold">Remarks</label>
        <textarea id="remarks" name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror" placeholder="Enter remarks...">{{ old('remarks', $item->remarks ?? '') }}</textarea>
        @error('remarks')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

</div>
