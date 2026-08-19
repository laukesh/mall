@extends('layouts.admin')

@section('title', 'Add Work Package')

@section('content')
<section class="section">
  <div class="section-header"><h1>Add Work Package</h1></div>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.workpackage.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-4 form-group"><label>Package Code *</label><input type="text" name="package_code" class="form-control" value="{{ old('package_code') }}" required></div>
          <div class="col-md-8 form-group"><label>Package Name *</label><input type="text" name="package_name" class="form-control" value="{{ old('package_name') }}" required></div>
          <div class="col-md-4 form-group">
            <label>Project *</label>
            <select name="project_id" class="form-control" required>
              <option value="">-- Select Project --</option>
              @foreach($projects as $project)
                <option value="{{ $project->id }}" @selected(old('project_id') == $project->id)>{{ $project->project_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group">
            <label>Discipline *</label>
            <select name="discipline" class="form-control" required>
              @foreach(['Civil','Electrical','Plumbing','HVAC','ELV','Fire Fighting','Mechanical','Interior','Landscaping'] as $discipline)
                <option value="{{ $discipline }}" @selected(old('discipline') == $discipline)>{{ $discipline }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group">
            <label>Status *</label>
            <select name="status" class="form-control" required>
              @foreach(['Planned','In Progress','On Hold','Completed'] as $status)
                <option value="{{ $status }}" @selected(old('status', 'Planned') == $status)>{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group"><label>Planned Start</label><input type="date" name="planned_start_date" class="form-control" value="{{ old('planned_start_date') }}"></div>
          <div class="col-md-4 form-group"><label>Planned End</label><input type="date" name="planned_end_date" class="form-control" value="{{ old('planned_end_date') }}"></div>
          <div class="col-md-4 form-group"><label>Estimated Cost</label><input type="number" step="0.01" name="estimated_cost" class="form-control" value="{{ old('estimated_cost') }}"></div>
          <div class="col-12 form-group"><label>Description</label><textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea></div>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">Save Work Package</button>
          <a href="{{ route('admin.workpackage.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
