@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3>Deposits</h3>
        <a href="{{ route('admin.revenue.deposits.create') }}" class="btn btn-primary">New Deposit</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Lease</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Received</th>
                <th>Balance</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($deposits as $d)
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->lease_agreement_id }}</td>
                    <td>{{ $d->deposit_type }}</td>
                    <td>{{ number_format($d->deposit_amount, 2) }}</td>
                    <td>{{ number_format($d->received_amount, 2) }}</td>
                    <td>{{ number_format($d->balance_amount, 2) }}</td>
                    <td>{{ optional($d->due_date)->format('Y-m-d') }}</td>
                    <td>{{ $d->payment_status }}</td>
                    <td>
                        <a href="{{ route('admin.revenue.deposits.edit', $d->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <form action="{{ route('admin.revenue.deposits.destroy', $d->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $deposits->links() }}
</div>
@endsection
