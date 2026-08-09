@extends('layouts.app')

@section('content')
<x-form-card title="Units" subtitle="Manage units"> 
  <div class="mb-3 d-flex justify-content-between">
    <a href="{{ route('units.create') }}" class="btn btn-primary">Create Unit</a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Unit No</th>
          <th>Shop Name</th>
          <th>Mall</th>
          <th>Building</th>
          <th>Floor</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($units as $unit)
        <tr>
          <td>{{ $unit->id }}</td>
          <td>{{ $unit->unit_no }}</td>
          <td>{{ $unit->shop_name }}</td>
          <td>{{ optional($unit->mall)->name }}</td>
          <td>{{ optional($unit->building)->name }}</td>
          <td>{{ optional($unit->floor)->name }}</td>
          <td>{{ optional($unit->unitStatus)->name ?? $unit->status }}</td>
          <td>
            <a href="{{ route('units.show', $unit->id) }}" class="btn btn-sm btn-info">View</a>
            <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('units.destroy', $unit->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-3">
      {{ $units->links() }}
    </div>
  </div>
</x-form-card>
@endsection
