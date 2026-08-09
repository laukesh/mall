@extends('layouts.app')

@section('content')
<x-form-card title="Unit Details" subtitle="View unit"> 
  <div class="row">
    <div class="col-md-6">
      <dl class="row">
        <dt class="col-sm-4">Unit No</dt>
        <dd class="col-sm-8">{{ $unit->unit_no }}</dd>

        <dt class="col-sm-4">Shop Name</dt>
        <dd class="col-sm-8">{{ $unit->shop_name }}</dd>

        <dt class="col-sm-4">Mall</dt>
        <dd class="col-sm-8">{{ optional($unit->mall)->name }}</dd>

        <dt class="col-sm-4">Building</dt>
        <dd class="col-sm-8">{{ optional($unit->building)->name }}</dd>

        <dt class="col-sm-4">Floor</dt>
        <dd class="col-sm-8">{{ optional($unit->floor)->name }}</dd>

        <dt class="col-sm-4">Zone</dt>
        <dd class="col-sm-8">{{ optional($unit->zone)->name }}</dd>
      </dl>
    </div>

    <div class="col-md-6">
      <dl class="row">
        <dt class="col-sm-4">Carpet Area</dt>
        <dd class="col-sm-8">{{ $unit->carpet_area }}</dd>

        <dt class="col-sm-4">Built-up Area</dt>
        <dd class="col-sm-8">{{ $unit->builtup_area }}</dd>

        <dt class="col-sm-4">Monthly Rent</dt>
        <dd class="col-sm-8">{{ $unit->monthly_rent }}</dd>

        <dt class="col-sm-4">Status</dt>
        <dd class="col-sm-8">{{ optional($unit->unitStatus)->name ?? $unit->status }}</dd>
      </dl>
    </div>
  </div>

  <div class="mt-3">
    <a href="{{ route('units.index') }}" class="btn btn-secondary">Back</a>
    <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-primary">Edit</a>
  </div>
</x-form-card>
@endsection
