@extends('layouts.admin')

@section('title', 'Finance')

@section('content')
<section class="section">
  @include('components.finance-nav')
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Finance Overview</h1>
    <div>
      <a href="{{ route('admin.finance.payments') }}" class="btn btn-secondary">Payments</a>
      <a href="{{ route('admin.finance.expenses') }}" class="btn btn-secondary">Expenses</a>
      <a href="{{ route('admin.finance.budgets') }}" class="btn btn-secondary">Budgets</a>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-4 col-md-6">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary"><i class="fas fa-money-bill-wave"></i></div>
        <div class="card-wrap">
          <div class="card-header"><h4>Recent Payments</h4></div>
          <div class="card-body">{{ $payments->count() }}</div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card card-statistic-1">
        <div class="card-icon bg-warning"><i class="fas fa-receipt"></i></div>
        <div class="card-wrap">
          <div class="card-header"><h4>Recent Expenses</h4></div>
          <div class="card-body">{{ $expenses->count() }}</div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card card-statistic-1">
        <div class="card-icon bg-success"><i class="fas fa-chart-pie"></i></div>
        <div class="card-wrap">
          <div class="card-header"><h4>Budget Lines</h4></div>
          <div class="card-body">{{ $budgets->count() }}</div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-lg-6">
      <div class="card"><div class="card-header"><h4>Recent Payments</h4></div>
        <div class="card-body p-0">
          <table class="table mb-0">
            <thead><tr><th>Date</th><th>Type</th><th>Amount</th><th>Status</th></tr></thead>
            <tbody>
              @forelse($payments as $payment)
              <tr>
                <td>{{ $payment->payment_date }}</td>
                <td>{{ $payment->payment_type }}</td>
                <td>{{ number_format($payment->amount ?? 0, 2) }}</td>
                <td><span class="badge bg-info">{{ $payment->status }}</span></td>
              </tr>
              @empty
              <tr><td colspan="4" class="text-center text-muted">No payments.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card"><div class="card-header"><h4>Recent Expenses</h4></div>
        <div class="card-body p-0">
          <table class="table mb-0">
            <thead><tr><th>Date</th><th>Category</th><th>Amount</th></tr></thead>
            <tbody>
              @forelse($expenses as $expense)
              <tr>
                <td>{{ $expense->expense_date }}</td>
                <td>{{ $expense->expense_category }}</td>
                <td>{{ number_format($expense->amount ?? 0, 2) }}</td>
              </tr>
              @empty
              <tr><td colspan="3" class="text-center text-muted">No expenses.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
