@extends('layouts.app')

@section('content')
<x-form-card title="Unit Statuses" subtitle="Manage unit statuses">
  <div class="mb-3 d-flex justify-content-between">
    <a href="{{ route('admin.unit-statuses.create') }}" class="btn btn-primary">Create Status</a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Color</th>
          <th>Sort</th>
          <th>Active</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($statuses as $status)
        <tr>
          <td>{{ $status->id }}</td>
          <td>{{ $status->status_name }}</td>
          <td><span style="display:inline-block;width:14px;height:14px;background:{{ $status->color_code }};border:1px solid #ccc;"></span> {{ $status->color_code }}</td>
          <td>{{ $status->sort_order }}</td>
          <td>{{ $status->is_active ? 'Yes' : 'No' }}</td>
          <td>
            <a href="{{ route('admin.unit-statuses.show', $status->id) }}" class="btn btn-sm btn-info">View</a>
            <a href="{{ route('admin.unit-statuses.edit', $status->id) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('admin.unit-statuses.destroy', $status->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-3">{{ $statuses->links() }}</div>
  </div>
</x-form-card>
@endsection
