@extends('layouts.app')

@section('content')
<x-form-card title="Edit Unit Status" subtitle="Edit unit status details">
  <form method="POST" action="{{ route('unit-statuses.update', $status->id) }}">
    @csrf
    @method('PUT')

    @include('admin.unit_statuses._form')

    <div class="form-action d-flex justify-content-end gap-2 mt-3">
      <a href="{{ route('unit-statuses.index') }}" class="btn btn-outline-secondary">Cancel</a>
      <button type="submit" class="btn btn-primary">Update</button>
    </div>
  </form>
</x-form-card>
@endsection
