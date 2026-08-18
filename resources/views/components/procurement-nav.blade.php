<div class="mb-3">
  <a href="{{ route('admin.procurement.vendors') }}" class="btn btn-sm {{ request()->routeIs('admin.procurement.vendor*') ? 'btn-primary' : 'btn-outline-primary' }}">Vendors</a>
  <a href="{{ route('admin.procurement.requisitions') }}" class="btn btn-sm {{ request()->routeIs('admin.procurement.requisitions') ? 'btn-primary' : 'btn-outline-primary' }}">Requisitions</a>
  <a href="{{ route('admin.procurement.orders') }}" class="btn btn-sm {{ request()->routeIs('admin.procurement.orders') ? 'btn-primary' : 'btn-outline-primary' }}">Purchase Orders</a>
  <a href="{{ route('admin.procurement.receipts') }}" class="btn btn-sm {{ request()->routeIs('admin.procurement.receipts') ? 'btn-primary' : 'btn-outline-primary' }}">Goods Receipts</a>
</div>
