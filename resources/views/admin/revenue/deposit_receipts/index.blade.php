@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3>Deposit Receipts</h3>
        <a href="{{ route('admin.revenue.deposit_receipts.create') }}" class="btn btn-primary">New Receipt</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Deposit</th>
                <th>Receipt No</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Mode</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($receipts as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->deposit_id }}</td>
                    <td>{{ $r->receipt_no }}</td>
                    <td>{{ optional($r->receipt_date)->format('Y-m-d') }}</td>
                    <td>{{ number_format($r->payment_amount, 2) }}</td>
                    <td>{{ $r->payment_mode }}</td>
                    <td>{{ $r->payment_status }}</td>
                    <td>
                        <a href="{{ route('admin.revenue.deposit_receipts.edit', $r->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <form action="{{ route('admin.revenue.deposit_receipts.destroy', $r->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $receipts->links() }}
</div>
@endsection
