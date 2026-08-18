@extends('layouts.admin')

@section('title', 'Payments')

@section('content')
<section class="section">
  @include('components.finance-nav')
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Payments</h1>
    <a href="{{ route('admin.finance.index') }}" class="btn btn-light">Back</a>
  </div>

  <div class="card mb-3"><div class="card-header"><h4>Record Payment</h4></div>
    <div class="card-body">
      <form action="{{ route('admin.finance.payment.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-3 form-group">
            <label>Payment Type *</label>
            <select name="payment_type" class="form-control" required>
              @foreach(['Contractor','Vendor','Client Refund','Miscellaneous'] as $type)
                <option value="{{ $type }}">{{ $type }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group"><label>Payment Date *</label><input type="date" name="payment_date" class="form-control" required></div>
          <div class="col-md-3 form-group">
            <label>Payment Mode *</label>
            <select name="payment_mode" class="form-control" required>
              @foreach(['Bank Transfer','Cheque','Cash','NEFT','RTGS','UPI'] as $mode)
                <option value="{{ $mode }}">{{ $mode }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group"><label>Amount *</label><input type="number" step="0.01" name="amount" class="form-control" required></div>
          <div class="col-md-3 form-group">
            <label>Status *</label>
            <select name="status" class="form-control" required>
              @foreach(['Pending','Completed','Failed'] as $status)
                <option value="{{ $status }}">{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group"><label>Transaction Reference</label><input type="text" name="transaction_reference" class="form-control"></div>
        </div>
        <button type="submit" class="btn btn-primary">Record Payment</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Date</th>
              <th>Type</th>
              <th>Mode</th>
              <th>Amount</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($payments as $payment)
            <tr>
              <td>{{ $payment->payment_date }}</td>
              <td>{{ $payment->payment_type }}</td>
              <td>{{ $payment->payment_mode }}</td>
              <td>{{ number_format($payment->amount ?? 0, 2) }}</td>
              <td><span class="badge bg-info">{{ $payment->status }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No payments found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
