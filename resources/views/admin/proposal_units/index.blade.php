@extends('layouts.app')

@section('content')
<x-form-card title="Proposal Units" subtitle="Manage proposal units">
  <div class="mb-3 d-flex justify-content-between">
    <a href="{{ route('proposal-units.create') }}" class="btn btn-primary">Create Proposal Unit</a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Proposal</th>
          <th>Unit</th>
          <th>Proposed Rent</th>
          <th>CAM Rate</th>
          <th>Security Deposit</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ optional($item->proposal)->title ?? $item->proposal_id }}</td>
          <td>{{ optional($item->unit)->unit_no ?? $item->unit_id }}</td>
          <td>{{ $item->proposed_rent }}</td>
          <td>{{ $item->proposed_cam_rate }}</td>
          <td>{{ $item->proposed_security_deposit }}</td>
          <td>
            <a href="{{ route('proposal-units.show', $item->id) }}" class="btn btn-sm btn-info">View</a>
            <a href="{{ route('proposal-units.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('proposal-units.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-3">{{ $items->links() }}</div>
  </div>
</x-form-card>
@endsection
