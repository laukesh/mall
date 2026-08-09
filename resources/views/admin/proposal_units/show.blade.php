@extends('layouts.app')

@section('content')
<x-form-card title="Proposal Unit" subtitle="View proposal unit">
  <div class="row">
    <div class="col-md-6">
      <dl class="row">
        <dt class="col-sm-4">Proposal</dt>
        <dd class="col-sm-8">{{ optional($item->proposal)->title ?? $item->proposal_id }}</dd>

        <dt class="col-sm-4">Unit</dt>
        <dd class="col-sm-8">{{ optional($item->unit)->unit_no ?? $item->unit_id }}</dd>

        <dt class="col-sm-4">Proposed Rent</dt>
        <dd class="col-sm-8">{{ $item->proposed_rent }}</dd>

        <dt class="col-sm-4">CAM Rate</dt>
        <dd class="col-sm-8">{{ $item->proposed_cam_rate }}</dd>

        <dt class="col-sm-4">Security Deposit</dt>
        <dd class="col-sm-8">{{ $item->proposed_security_deposit }}</dd>
      </dl>
    </div>

    <div class="col-md-6">
      <dl class="row">
        <dt class="col-sm-4">Rent Free Days</dt>
        <dd class="col-sm-8">{{ $item->rent_free_days }}</dd>

        <dt class="col-sm-4">Fitout Period (days)</dt>
        <dd class="col-sm-8">{{ $item->fitout_period_days }}</dd>

        <dt class="col-sm-4">Remarks</dt>
        <dd class="col-sm-8">{{ $item->remarks }}</dd>
      </dl>
    </div>
  </div>

  <div class="mt-3">
    <a href="{{ route('proposal-units.index') }}" class="btn btn-secondary">Back</a>
    <a href="{{ route('proposal-units.edit', $item->id) }}" class="btn btn-primary">Edit</a>
  </div>
</x-form-card>
@endsection
