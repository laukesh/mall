@extends('layouts.admin')

@section('title', 'Goods Receipts')

@section('content')
<section class="section">
  @include('components.procurement-nav')
  <div class="section-header"><h1>Goods Receipts</h1></div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>GRN Number</th>
              <th>PO</th>
              <th>Received Date</th>
              <th>Warehouse</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($receipts as $receipt)
            <tr>
              <td>{{ $receipt->grn_number ?? $receipt->receipt_number ?? '-' }}</td>
              <td>{{ $receipt->purchase_order_id ?? $receipt->po_id ?? '-' }}</td>
              <td>{{ $receipt->received_date }}</td>
              <td>{{ $receipt->warehouse_id ?? '-' }}</td>
              <td><span class="badge bg-info">{{ $receipt->status ?? '-' }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No goods receipts found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
