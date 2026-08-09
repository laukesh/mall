@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3>Invoice #{{ $invoice->invoice_no ?? $invoice->id }}</h3>
        <div>
            <a href="{{ route('admin.revenue.invoices.index') }}" class="btn btn-secondary">Back to list</a>
            @can('update', $invoice)
                <a href="{{ route('admin.revenue.invoices.edit', $invoice->id) }}" class="btn btn-primary">Edit</a>
            @endcan
        </div>
    </div>

    <table class="table table-striped">
        <tr><th>ID</th><td>{{ $invoice->id }}</td></tr>
        <tr><th>Invoice No</th><td>{{ $invoice->invoice_no }}</td></tr>
        <tr><th>Lease Agreement</th><td>{{ $invoice->lease_agreement_id }}</td></tr>
        <tr><th>Tenant</th><td>{{ $invoice->tenant_id }}</td></tr>
        <tr><th>Invoice Date</th><td>{{ optional($invoice->invoice_date)->format('Y-m-d') }}</td></tr>
        <tr><th>Billing Period</th><td>{{ optional($invoice->billing_period_from)->format('Y-m-d') }} - {{ optional($invoice->billing_period_to)->format('Y-m-d') }}</td></tr>
        <tr><th>Due Date</th><td>{{ optional($invoice->due_date)->format('Y-m-d') }}</td></tr>
        <tr><th>Subtotal</th><td>{{ number_format($invoice->subtotal, 2) }}</td></tr>
        <tr><th>Tax</th><td>{{ number_format($invoice->tax_amount, 2) }}</td></tr>
        <tr><th>Total</th><td>{{ number_format($invoice->total_amount, 2) }}</td></tr>
        <tr><th>Paid</th><td>{{ number_format($invoice->paid_amount, 2) }}</td></tr>
        <tr><th>Balance</th><td>{{ number_format($invoice->balance_amount, 2) }}</td></tr>
        <tr><th>Status</th><td>{{ $invoice->invoice_status }}</td></tr>
        <tr><th>Remarks</th><td>{{ $invoice->remarks }}</td></tr>
    </table>

    <h5>Items</h5>
    @if($invoice->items && $invoice->items->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Rate</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->item_description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ number_format($item->rate, 2) }}</td>
                        <td>{{ number_format($item->total_amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No items.</p>
    @endif
</div>
@endsection
