@extends('layouts.admin')

@section('title', 'Warehouse Stock')

@section('content')
<section class="section">
  @include('components.inventory-nav')
  <div class="section-header"><h1>Warehouse Stock</h1></div>

  <div class="card mb-3"><div class="card-header"><h4>Add Stock Entry</h4></div>
    <div class="card-body">
      <form action="{{ route('admin.inventory.stock.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-3 form-group">
            <label>Warehouse *</label>
            <select name="warehouse_id" id="warehouse_id" class="form-control" required>
              <option value="">-- Select --</option>
              @foreach($warehouses as $warehouse)
                <option value="{{ $warehouse->id }}">{{ $warehouse->warehouse_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group">
            <label>Material *</label>
            <select name="material_id" id="material_id" class="form-control" required>
              <option value="">-- Select --</option>
              @foreach($materials as $material)
                <option value="{{ $material->id }}">{{ $material->material_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2 form-group"><label>Available Qty *</label><input type="number" step="0.01" name="available_quantity" class="form-control" required></div>
          <div class="col-md-2 form-group"><label>Unit *</label><input type="text" name="unit" class="form-control" required></div>
          <div class="col-md-2 form-group"><label>Reserved Qty</label><input type="number" step="0.01" name="reserved_quantity" class="form-control" value="0"></div>
        </div>
        <button type="submit" class="btn btn-primary">Add Stock</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Warehouse</th>
              <th>Material</th>
              <th>Available</th>
              <th>Reserved</th>
              <th>Unit</th>
              <th>Last Updated</th>
            </tr>
          </thead>
          <tbody>
            @forelse($stock as $item)
            <tr>
              <td>{{ $item->warehouse->warehouse_name ?? '-' }}</td>
              <td>{{ $item->material->material_name ?? '-' }}</td>
              <td>{{ number_format($item->available_quantity ?? 0, 2) }}</td>
              <td>{{ number_format($item->reserved_quantity ?? 0, 2) }}</td>
              <td>{{ $item->unit }}</td>
              <td>{{ $item->last_updated }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No stock entries found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
(function () {
  const existingStock = @json($existingStock);
  const warehouseSelect = document.getElementById('warehouse_id');
  const materialSelect = document.getElementById('material_id');
  const materialOptions = Array.from(materialSelect.options).slice(1);

  function filterMaterials() {
    const warehouseId = warehouseSelect.value;
    const usedMaterialIds = warehouseId ? (existingStock[warehouseId] || []) : [];

    materialSelect.value = '';
    materialOptions.forEach(function (option) {
      const isUsed = usedMaterialIds.includes(Number(option.value));
      option.hidden = isUsed;
      option.disabled = isUsed;
    });
  }

  warehouseSelect.addEventListener('change', filterMaterials);
  filterMaterials();
})();
</script>
@endpush
