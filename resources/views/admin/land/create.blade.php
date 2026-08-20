@extends('layouts.admin')

@section('title', 'Add Land')

@section('content')
<section class="section">
  <div class="section-header"><h1>Add Land Parcel</h1></div>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.land.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-4 form-group">
            <label>Land Code *</label>
            <input type="text" name="land_code" class="form-control" value="{{ old('land_code') }}" required>
          </div>
          <div class="col-md-8 form-group">
            <label>Land Name *</label>
            <input type="text" name="land_name" class="form-control" value="{{ old('land_name') }}" required>
          </div>
          <div class="col-md-4 form-group">
            <label>Survey Number *</label>
            <input type="text" name="survey_number" class="form-control" value="{{ old('survey_number') }}" required>
          </div>
          <div class="col-md-4 form-group">
            <label>Acquisition Status *</label>
            <select name="acquisition_status" class="form-control" required>
              @foreach(['Identified','Negotiation','Approved','Registered','Completed'] as $status)
                <option value="{{ $status }}" @selected(old('acquisition_status', 'Identified') == $status)>{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group"><label>Village *</label><input type="text" name="village" class="form-control" value="{{ old('village') }}" required></div>
          <div class="col-md-3 form-group"><label>Taluka *</label><input type="text" name="taluka" class="form-control" value="{{ old('taluka') }}" required></div>
          <div class="col-md-3 form-group"><label>District *</label><input type="text" name="district" class="form-control" value="{{ old('district') }}" required></div>
          <div class="col-md-3 form-group"><label>State *</label><input type="text" name="state" class="form-control" value="{{ old('state') }}" required></div>
          <div class="col-md-4 form-group"><label>Total Area *</label><input type="number" step="0.01" name="total_area" class="form-control" value="{{ old('total_area') }}" required></div>
          <div class="col-md-4 form-group">
            <label>Area Unit *</label>
            <select name="area_unit" class="form-control" required>
              @foreach(['Sq Ft','Sq Mt','Acre','Hectare'] as $unit)
                <option value="{{ $unit }}" @selected(old('area_unit') == $unit)>{{ $unit }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2 form-group"><label>Latitude</label><input type="number" step="0.0000001" name="latitude" class="form-control" value="{{ old('latitude') }}"></div>
          <div class="col-md-2 form-group"><label>Longitude</label><input type="number" step="0.0000001" name="longitude" class="form-control" value="{{ old('longitude') }}"></div>
          <div class="col-12 form-group"><label>Remarks</label><textarea name="remarks" class="form-control" rows="3">{{ old('remarks') }}</textarea></div>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">Save Land</button>
          <a href="{{ route('admin.land.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
