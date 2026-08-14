<div class="row">
  <div class="col-lg-6 col-md-12 col-sm-12">
    <div class="form-group">
      <label for="proposal_id">Proposal *</label>
      <select id="proposal_id" name="proposal_id" class="form-control">
        <option value="">Select proposal</option>
        @foreach($proposals ?? [] as $id => $title)
          <option value="{{ $id }}" {{ (old('proposal_id', $item->proposal_id ?? '') == $id) ? 'selected' : '' }}>{{ $title }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="col-lg-6 col-md-12 col-sm-12">
    <div class="form-group">
      <label for="unit_id">Unit *</label>
      <select id="unit_id" name="unit_id" class="form-control">
        <option value="">Select unit</option>
        @foreach($units ?? [] as $id => $no)
          <option value="{{ $id }}" {{ (old('unit_id', $item->unit_id ?? '') == $id) ? 'selected' : '' }}>{{ $no }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="form-group">
      <label for="proposed_rent">Proposed Rent</label>
      <input id="proposed_rent" name="proposed_rent" type="number" step="0.01" class="form-control" value="{{ old('proposed_rent', $item->proposed_rent ?? '') }}" />
    </div>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="form-group">
      <label for="proposed_cam_rate">Proposed CAM Rate</label>
      <input id="proposed_cam_rate" name="proposed_cam_rate" type="number" step="0.01" class="form-control" value="{{ old('proposed_cam_rate', $item->proposed_cam_rate ?? '') }}" />
    </div>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="form-group">
      <label for="proposed_security_deposit">Proposed Security Deposit</label>
      <input id="proposed_security_deposit" name="proposed_security_deposit" type="number" step="0.01" class="form-control" value="{{ old('proposed_security_deposit', $item->proposed_security_deposit ?? '') }}" />
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-12">
    <div class="form-group">
      <label for="rent_free_days">Rent Free Days</label>
      <input id="rent_free_days" name="rent_free_days" type="number" class="form-control" value="{{ old('rent_free_days', $item->rent_free_days ?? 0) }}" />
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-12">
    <div class="form-group">
      <label for="fitout_period_days">Fitout Period (days)</label>
      <input id="fitout_period_days" name="fitout_period_days" type="number" class="form-control" value="{{ old('fitout_period_days', $item->fitout_period_days ?? 0) }}" />
    </div>
  </div>

  <div class="col-12">
    <div class="form-group">
      <label for="remarks">Remarks</label>
      <textarea id="remarks" name="remarks" class="form-control">{{ old('remarks', $item->remarks ?? '') }}</textarea>
    </div>
  </div>
</div>
