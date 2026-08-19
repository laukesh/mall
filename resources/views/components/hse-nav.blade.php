<div class="mb-3">
  <a href="{{ route('admin.hse.incidents') }}" class="btn btn-sm {{ request()->routeIs('admin.hse.incidents') ? 'btn-primary' : 'btn-outline-primary' }}">Incidents</a>
  <a href="{{ route('admin.hse.inspections') }}" class="btn btn-sm {{ request()->routeIs('admin.hse.inspections') ? 'btn-primary' : 'btn-outline-primary' }}">Inspections</a>
  <a href="{{ route('admin.hse.ppe') }}" class="btn btn-sm {{ request()->routeIs('admin.hse.ppe') ? 'btn-primary' : 'btn-outline-primary' }}">PPE Inventory</a>
</div>
