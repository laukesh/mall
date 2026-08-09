@extends('layouts.app')

@section('content')
<x-form-card title="Create Proposal Unit" subtitle="Create a proposal unit">
  <form method="POST" action="{{ route('proposal-units.store') }}">
    @csrf

    @include('admin.proposal_units._form')

    <div class="form-action d-flex justify-content-end gap-2 mt-3">
      <a href="{{ route('proposal-units.index') }}" class="btn btn-outline-secondary">Cancel</a>
      <button type="submit" class="btn btn-primary">Create</button>
    </div>
  </form>
</x-form-card>
@endsection
