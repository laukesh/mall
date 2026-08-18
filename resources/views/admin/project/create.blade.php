@extends('layouts.admin')

@section('title', 'Add Project')

@section('content')
<section class="section">
  <div class="section-header"><h1>Add Project</h1></div>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.project.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-4 form-group">
            <label>Project Code *</label>
            <input type="text" name="project_code" class="form-control" value="{{ old('project_code') }}" required>
          </div>
          <div class="col-md-8 form-group">
            <label>Project Name *</label>
            <input type="text" name="project_name" class="form-control" value="{{ old('project_name') }}" required>
          </div>
          <div class="col-md-4 form-group">
            <label>Client *</label>
            <select name="client_id" class="form-control" required>
              <option value="">-- Select Client --</option>
              @foreach($clients as $client)
                <option value="{{ $client->id }}" @selected(old('client_id') == $client->id)>{{ $client->client_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group">
            <label>Project Type *</label>
            <select name="project_type" class="form-control" required>
              @foreach(['Residential','Commercial','Industrial','Infrastructure'] as $type)
                <option value="{{ $type }}" @selected(old('project_type') == $type)>{{ $type }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group">
            <label>Status *</label>
            <select name="status" class="form-control" required>
              @foreach(['Planning','Active','On Hold','Completed','Cancelled'] as $status)
                <option value="{{ $status }}" @selected(old('status', 'Planning') == $status)>{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6 form-group"><label>Location</label><input type="text" name="location" class="form-control" value="{{ old('location') }}"></div>
          <div class="col-md-3 form-group"><label>City</label><input type="text" name="city" class="form-control" value="{{ old('city') }}"></div>
          <div class="col-md-3 form-group"><label>State</label><input type="text" name="state" class="form-control" value="{{ old('state') }}"></div>
          <div class="col-md-4 form-group">
            <label>Project Manager</label>
            <select name="project_manager_id" class="form-control">
              <option value="">-- Select Manager --</option>
              @foreach($managers as $manager)
                <option value="{{ $manager->id }}" @selected(old('project_manager_id') == $manager->id)>{{ $manager->full_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group"><label>Planned Start Date</label><input type="date" name="planned_start_date" class="form-control" value="{{ old('planned_start_date') }}"></div>
          <div class="col-md-4 form-group"><label>Planned End Date</label><input type="date" name="planned_end_date" class="form-control" value="{{ old('planned_end_date') }}"></div>
          <div class="col-md-4 form-group"><label>Estimated Cost</label><input type="number" step="0.01" name="estimated_cost" class="form-control" value="{{ old('estimated_cost') }}"></div>
          <div class="col-md-4 form-group"><label>Approved Budget</label><input type="number" step="0.01" name="approved_budget" class="form-control" value="{{ old('approved_budget') }}"></div>
          <div class="col-12 form-group"><label>Remarks</label><textarea name="remarks" class="form-control" rows="3">{{ old('remarks') }}</textarea></div>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">Save Project</button>
          <a href="{{ route('admin.project.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
