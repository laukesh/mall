<div class="mb-3">
  <a href="{{ route('admin.finance.index') }}" class="btn btn-sm {{ request()->routeIs('admin.finance.index') ? 'btn-primary' : 'btn-outline-primary' }}">Overview</a>
  <a href="{{ route('admin.finance.payments') }}" class="btn btn-sm {{ request()->routeIs('admin.finance.payments') ? 'btn-primary' : 'btn-outline-primary' }}">Payments</a>
  <a href="{{ route('admin.finance.expenses') }}" class="btn btn-sm {{ request()->routeIs('admin.finance.expenses') ? 'btn-primary' : 'btn-outline-primary' }}">Expenses</a>
  <a href="{{ route('admin.finance.budgets') }}" class="btn btn-sm {{ request()->routeIs('admin.finance.budgets') ? 'btn-primary' : 'btn-outline-primary' }}">Budgets</a>
</div>
