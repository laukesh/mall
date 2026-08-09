@extends('layouts.app')

@section('content')
<x-form-card title="Create Unit" subtitle="Create new unit"> 
  <form method="POST" action="{{ route('units.store') }}">
    @csrf

    @include('admin.units._form')

    <div class="form-action d-flex justify-content-end gap-2 mt-3">
      <a href="{{ route('units.index') }}" class="btn btn-outline-secondary">Cancel</a>
      <button type="submit" class="btn btn-primary">Create</button>
    </div>
  </form>
</x-form-card>
@endsection
