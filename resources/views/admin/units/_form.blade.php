<div class="row">
  <div class="col-lg-6 col-md-12 col-sm-12">
    <div class="form-group">
      <label for="mall_id">Mall *</label>
      <select id="mall_id" name="mall_id" class="form-control">
        <option value="">Select mall</option>
        @foreach($malls as $id => $name)
          <option value="{{ $id }}" {{ (old('mall_id', $unit->mall_id ?? '') == $id) ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="col-lg-6 col-md-12 col-sm-12">
    <div class="form-group">
      <label for="building_id">Building *</label>
      <select id="building_id" name="building_id" class="form-control">
        <option value="">Select building</option>
        @foreach($buildings as $id => $name)
          <option value="{{ $id }}" {{ (old('building_id', $unit->building_id ?? '') == $id) ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="col-lg-6 col-md-12 col-sm-12">
    <div class="form-group">
      <label for="floor_id">Floor</label>
      <select id="floor_id" name="floor_id" class="form-control">
        <option value="">Select floor</option>
        @foreach($floors as $id => $name)
          <option value="{{ $id }}" {{ (old('floor_id', $unit->floor_id ?? '') == $id) ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="col-lg-6 col-md-12 col-sm-12">
    <div class="form-group">
      <label for="zone_id">Zone</label>
      <select id="zone_id" name="zone_id" class="form-control">
        <option value="">Select zone</option>
        @foreach($zones as $id => $name)
          <option value="{{ $id }}" {{ (old('zone_id', $unit->zone_id ?? '') == $id) ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="col-lg-6 col-md-12 col-sm-12">
    <div class="form-group">
      <label for="unit_type_id">Unit Type</label>
      <select id="unit_type_id" name="unit_type_id" class="form-control">
        <option value="">Select unit type</option>
        @foreach($unitTypes as $id => $name)
          <option value="{{ $id }}" {{ (old('unit_type_id', $unit->unit_type_id ?? '') == $id) ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="col-lg-6 col-md-12 col-sm-12">
    <div class="form-group">
      <label for="unit_status_id">Unit Status</label>
      <select id="unit_status_id" name="unit_status_id" class="form-control">
        <option value="">Select status</option>
        @foreach($unitStatuses as $id => $name)
          <option value="{{ $id }}" {{ (old('unit_status_id', $unit->unit_status_id ?? '') == $id) ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="col-lg-6 col-md-12 col-sm-12">
    <div class="form-group">
      <label for="unit_no">Unit No *</label>
      <input id="unit_no" name="unit_no" type="text" class="form-control" value="{{ old('unit_no', $unit->unit_no ?? '') }}" />
    </div>
  </div>

  <div class="col-lg-6 col-md-12 col-sm-12">
    <div class="form-group">
      <label for="shop_name">Shop Name</label>
      <input id="shop_name" name="shop_name" type="text" class="form-control" value="{{ old('shop_name', $unit->shop_name ?? '') }}" />
    </div>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="form-group">
      <label for="carpet_area">Carpet Area</label>
      <input id="carpet_area" name="carpet_area" type="number" step="0.01" class="form-control" value="{{ old('carpet_area', $unit->carpet_area ?? '') }}" />
    </div>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="form-group">
      <label for="builtup_area">Built-up Area</label>
      <input id="builtup_area" name="builtup_area" type="number" step="0.01" class="form-control" value="{{ old('builtup_area', $unit->builtup_area ?? '') }}" />
    </div>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="form-group">
      <label for="frontage">Frontage</label>
      <input id="frontage" name="frontage" type="number" step="0.01" class="form-control" value="{{ old('frontage', $unit->frontage ?? '') }}" />
    </div>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="form-group">
      <label for="monthly_rent">Monthly Rent</label>
      <input id="monthly_rent" name="monthly_rent" type="number" step="0.01" class="form-control" value="{{ old('monthly_rent', $unit->monthly_rent ?? '') }}" />
    </div>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="form-group">
      <label for="security_deposit">Security Deposit</label>
      <input id="security_deposit" name="security_deposit" type="number" step="0.01" class="form-control" value="{{ old('security_deposit', $unit->security_deposit ?? '') }}" />
    </div>
  </div>

  <div class="col-12">
    <div class="form-group">
      <label for="remarks">Remarks</label>
      <textarea id="remarks" name="remarks" class="form-control">{{ old('remarks', $unit->remarks ?? '') }}</textarea>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-12">
    <div class="form-group">
      <label for="status">Status</label>
      <select id="status" name="status" class="form-control">
        <option value="active" {{ (old('status', $unit->status ?? '') == 'active') ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ (old('status', $unit->status ?? '') == 'inactive') ? 'selected' : '' }}>Inactive</option>
      </select>
    </div>
  </div>
</div>
