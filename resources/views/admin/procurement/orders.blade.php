@extends('layouts.admin')

@section('title', 'Purchase Orders')

@section('content')
<section class="section">
  @include('components.procurement-nav')
  <div class="section-header"><h1>Purchase Orders</h1></div>

  <div class="card mb-3"><div class="card-header"><h4>Create Purchase Order</h4></div>
    <div class="card-body">
      <form action="{{ route('admin.procurement.order.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-3 form-group"><label>PO Number *</label><input type="text" name="po_number" class="form-control" required></div>
          <div class="col-md-3 form-group">
            <label>Vendor *</label>
            <select name="vendor_id" class="form-control" required>
              <option value="">-- Select --</option>
              @foreach($vendors as $vendor)
                <option value="{{ $vendor->id }}">{{ $vendor->vendor_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group">
            <label>Project *</label>
            <select name="project_id" class="form-control" required>
              <option value="">-- Select --</option>
              @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->project_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group"><label>Order Date *</label><input type="date" name="order_date" class="form-control" required></div>
          <div class="col-md-3 form-group"><label>Expected Delivery</label><input type="date" name="expected_delivery_date" class="form-control"></div>
          <div class="col-md-3 form-group"><label>Total Amount</label><input type="number" step="0.01" name="total_amount" class="form-control"></div>
          <div class="col-md-3 form-group">
            <label>Status *</label>
            <select name="status" class="form-control" required>
              @foreach(['Draft','Issued','Partially Received','Completed','Cancelled'] as $status)
                <option value="{{ $status }}">{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group"><label>Payment Terms</label><input type="text" name="payment_terms" class="form-control"></div>
        </div>
        <button type="submit" class="btn btn-primary">Create PO</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>PO Number</th>
              <th>Vendor</th>
              <th>Project</th>
              <th>Order Date</th>
              <th>Amount</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($orders as $order)
            <tr>
              <td><a href="{{ route('admin.procurement.order.show', $order->id) }}">{{ $order->po_number }}</a></td>
              <td>{{ $order->vendor_id }}</td>
              <td>{{ $order->project_id }}</td>
              <td>{{ $order->order_date }}</td>
              <td>{{ number_format($order->total_amount ?? 0, 2) }}</td>
              <td><span class="badge bg-info">{{ $order->status }}</span></td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No purchase orders found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
