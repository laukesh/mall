@extends('layouts.admin')

@section('title', 'Purchase Order')

@section('content')
<section class="section">
  @include('components.procurement-nav')
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>PO {{ $order->po_number }}</h1>
    <a href="{{ route('admin.procurement.orders') }}" class="btn btn-light">Back</a>
  </div>

  <div class="card">
    <div class="card-body">
      <p><strong>Vendor ID:</strong> {{ $order->vendor_id }}</p>
      <p><strong>Project ID:</strong> {{ $order->project_id }}</p>
      <p><strong>Order Date:</strong> {{ $order->order_date }}</p>
      <p><strong>Expected Delivery:</strong> {{ $order->expected_delivery_date ?? '-' }}</p>
      <p><strong>Total Amount:</strong> {{ $order->total_amount ? number_format($order->total_amount, 2) : '-' }}</p>
      <p><strong>Status:</strong> <span class="badge bg-info">{{ $order->status }}</span></p>
      <p><strong>Work Progress:</strong> {{ number_format((float) ($order->progress_percentage ?? 0), 1) }}%</p>
    </div>
  </div>

  <x-pm-tracking-panel
    :statusAction="route('admin.procurement.order.status.update', $order->id)"
    :progressAction="route('admin.procurement.order.progress.update', $order->id)"
    :currentStatus="$order->status"
    :statuses="['Draft','Issued','Partially Received','Completed','Cancelled']"
    :currentProgress="$order->progress_percentage ?? 0"
    :histories="$statusHistories ?? collect()"
    statusTitle="Change PO Status"
    historyTitle="Purchase Order History"
  />
</section>
@endsection
