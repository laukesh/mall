@extends('layouts.app')

@section('content')
<x-form-card title="Edit Unit" subtitle="Edit unit details"> 
  <form method="POST" action="{{ route('units.update', $unit->id) }}">
    @csrf
    @method('PUT')

    @include('admin.units._form')

    <div class="form-action d-flex justify-content-end gap-2 mt-3">
      <a href="{{ route('units.index') }}" class="btn btn-outline-secondary">Cancel</a>
      <button type="submit" class="btn btn-primary">Update</button>
    </div>
  </form>
</x-form-card>
@endsection
