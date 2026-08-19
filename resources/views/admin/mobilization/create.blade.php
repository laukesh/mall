@extends('layouts.admin')

@section('title', 'Add Mobilization Plan')

@section('content')
<section class="section">
  <div class="section-header"><h1>Add Mobilization Plan</h1></div>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.mobilization.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-4 form-group"><label>Plan Number *</label><input type="text" name="plan_number" class="form-control" value="{{ old('plan_number') }}" required></div>
          <div class="col-md-8 form-group"><label>Mobilization Name *</label><input type="text" name="mobilization_name" class="form-control" value="{{ old('mobilization_name') }}" required></div>
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
            <label>Type *</label>
            <select name="mobilization_type" class="form-control" required>
              @foreach(['Initial','Additional','Emergency'] as $type)
                <option value="{{ $type }}" @selected(old('mobilization_type') == $type)>{{ $type }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group">
            <label>Status *</label>
            <select name="status" class="form-control" required>
              @foreach(['Draft','Approved','In Progress','Completed'] as $status)
                <option value="{{ $status }}" @selected(old('status', 'Draft') == $status)>{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group"><label>Planned Start</label><input type="date" name="planned_start_date" class="form-control" value="{{ old('planned_start_date') }}"></div>
          <div class="col-md-4 form-group"><label>Planned End</label><input type="date" name="planned_end_date" class="form-control" value="{{ old('planned_end_date') }}"></div>
          <div class="col-md-4 form-group"><label>Approval Date</label><input type="date" name="approval_date" class="form-control" value="{{ old('approval_date') }}"></div>
          <div class="col-12 form-group"><label>Remarks</label><textarea name="remarks" class="form-control" rows="3">{{ old('remarks') }}</textarea></div>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">Save Plan</button>
          <a href="{{ route('admin.mobilization.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
