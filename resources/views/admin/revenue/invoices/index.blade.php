@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3>Invoices</h3>
        <a href="{{ route('admin.revenue.invoices.create') }}" class="btn btn-primary">New Invoice</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Invoice No</th>
                <th>Lease</th>
                <th>Tenant</th>
                <th>Invoice Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->invoice_no }}</td>
                    <td>{{ $invoice->lease_agreement_id }}</td>
                    <td>{{ $invoice->tenant_id }}</td>
                    <td>{{ optional($invoice->invoice_date)->format('Y-m-d') }}</td>
                    <td>{{ number_format($invoice->total_amount, 2) }}</td>
                    <td>{{ $invoice->invoice_status }}</td>
                    <td>
                        <a href="{{ route('admin.revenue.invoices.show', $invoice->id) }}" class="btn btn-sm btn-secondary">View</a>
                        @can('update', $invoice)
                            <a href="{{ route('admin.revenue.invoices.edit', $invoice->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        @endcan
                        @can('delete', $invoice)
                            <form action="{{ route('admin.revenue.invoices.destroy', $invoice->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this invoice?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No invoices found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $invoices->links() }}
</div>
@endsection
