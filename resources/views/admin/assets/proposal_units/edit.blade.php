@extends('layouts.app')

@section('content')
<x-form-card title="Edit Proposal Unit" subtitle="Edit proposal unit">
  <form method="POST" action="{{ route('admin.assets.proposal_units.update', $item->id) }}">
    @csrf
    @method('PUT')

    @include('admin.assets.proposal_units._form')

    <div class="form-action d-flex justify-content-end gap-2 mt-3">
      <a href="{{ route('admin.assets.proposal_units.index') }}" class="btn btn-outline-secondary">Cancel</a>
      <button type="submit" class="btn btn-primary">Update</button>
    </div>
  </form>
</x-form-card>
@endsection
