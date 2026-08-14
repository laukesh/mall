@extends('layouts.app')

@section('content')
<x-form-card title="Unit Status" subtitle="View status details">
  <div class="row">
    <div class="col-md-6">
      <dl class="row">
        <dt class="col-sm-4">Name</dt>
        <dd class="col-sm-8">{{ $status->status_name }}</dd>

        <dt class="col-sm-4">Description</dt>
        <dd class="col-sm-8">{{ $status->description }}</dd>

        <dt class="col-sm-4">Color</dt>
        <dd class="col-sm-8"><span style="display:inline-block;width:14px;height:14px;background:{{ $status->color_code }};border:1px solid #ccc;"></span> {{ $status->color_code }}</dd>

        <dt class="col-sm-4">Sort Order</dt>
        <dd class="col-sm-8">{{ $status->sort_order }}</dd>

        <dt class="col-sm-4">Active</dt>
        <dd class="col-sm-8">{{ $status->is_active ? 'Yes' : 'No' }}</dd>
      </dl>
    </div>
  </div>

  <div class="mt-3">
    <a href="{{ route('admin.assets.unit-statuses.index') }}" class="btn btn-secondary">Back</a>
    <a href="{{ route('admin.assets.unit-statuses.edit', $status->id) }}" class="btn btn-primary">Edit</a>
  </div>
</x-form-card>
@endsection
