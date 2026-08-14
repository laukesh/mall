@extends('layouts.app')

@section('content')
<x-form-card title="Create Unit Status" subtitle="Add a new unit status">
  <form method="POST" action="{{ route('admin.assets.unit-statuses.store') }}">
    @csrf

    @include('admin.assets.unit_statuses._form')

    <div class="form-action d-flex justify-content-end gap-2 mt-3">
      <a href="{{ route('admin.assets.unit-statuses.index') }}" class="btn btn-outline-secondary">Cancel</a>
      <button type="submit" class="btn btn-primary">Create</button>
    </div>
  </form>
</x-form-card>
@endsection
