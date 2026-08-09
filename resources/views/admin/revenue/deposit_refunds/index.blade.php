@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3>Deposit Refunds</h3>
        <a href="{{ route('admin.revenue.deposit_refunds.create') }}" class="btn btn-primary">New Refund</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Deposit</th>
                <th>Refund No</th>
                <th>Date</th>
                <th>Refund Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($refunds as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->deposit_id }}</td>
                    <td>{{ $r->refund_no }}</td>
                    <td>{{ optional($r->refund_date)->format('Y-m-d') }}</td>
                    <td>{{ number_format($r->refund_amount, 2) }}</td>
                    <td>{{ $r->refund_status }}</td>
                    <td>
                        <a href="{{ route('admin.revenue.deposit_refunds.edit', $r->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <form action="{{ route('admin.revenue.deposit_refunds.destroy', $r->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $refunds->links() }}
</div>
@endsection
