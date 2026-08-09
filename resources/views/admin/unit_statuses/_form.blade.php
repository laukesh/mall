<div class="row">
  <div class="col-lg-6 col-md-12 col-sm-12">
    <div class="form-group">
      <label for="status_name">Status Name *</label>
      <input id="status_name" name="status_name" type="text" class="form-control" value="{{ old('status_name', $status->status_name ?? '') }}" />
    </div>
  </div>

  <div class="col-lg-6 col-md-12 col-sm-12">
    <div class="form-group">
      <label for="color_code">Color Code</label>
      <input id="color_code" name="color_code" type="text" class="form-control" placeholder="#ffffff" value="{{ old('color_code', $status->color_code ?? '') }}" />
    </div>
  </div>

  <div class="col-12">
    <div class="form-group">
      <label for="description">Description</label>
      <textarea id="description" name="description" class="form-control">{{ old('description', $status->description ?? '') }}</textarea>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-12">
    <div class="form-group">
      <label for="sort_order">Sort Order</label>
      <input id="sort_order" name="sort_order" type="number" class="form-control" value="{{ old('sort_order', $status->sort_order ?? 0) }}" />
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-12">
    <div class="form-group">
      <label for="is_active">Active</label>
      <select id="is_active" name="is_active" class="form-control">
        <option value="1" {{ (old('is_active', $status->is_active ?? 1) == 1) ? 'selected' : '' }}>Yes</option>
        <option value="0" {{ (old('is_active', $status->is_active ?? 1) == 0) ? 'selected' : '' }}>No</option>
      </select>
    </div>
  </div>
</div>
