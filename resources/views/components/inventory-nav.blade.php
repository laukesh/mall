<div class="mb-3">
  <a href="{{ route('admin.inventory.materials') }}" class="btn btn-sm {{ request()->routeIs('admin.inventory.materials') ? 'btn-primary' : 'btn-outline-primary' }}">Materials</a>
  <a href="{{ route('admin.inventory.warehouses') }}" class="btn btn-sm {{ request()->routeIs('admin.inventory.warehouses') ? 'btn-primary' : 'btn-outline-primary' }}">Warehouses</a>
  <a href="{{ route('admin.inventory.stock') }}" class="btn btn-sm {{ request()->routeIs('admin.inventory.stock') ? 'btn-primary' : 'btn-outline-primary' }}">Stock</a>
  <a href="{{ route('admin.inventory.issue-requests') }}" class="btn btn-sm {{ request()->routeIs('admin.inventory.issue-requests') ? 'btn-primary' : 'btn-outline-primary' }}">Issue Requests</a>
  <a href="{{ route('admin.inventory.issues') }}" class="btn btn-sm {{ request()->routeIs('admin.inventory.issues') ? 'btn-primary' : 'btn-outline-primary' }}">Issues</a>
</div>
