@extends('layouts.admin')

@section('title', 'New Feasibility Study')

@section('content')
<section class="section">
  <div class="section-header"><h1>New Feasibility Study</h1></div>
  <div class="card"><div class="card-body">
    <form action="{{ route('admin.feasibility.store') }}" method="POST">@csrf
      <div class="row">
        <div class="col-md-4 form-group"><label>Feasibility Code *</label><input type="text" name="feasibility_code" class="form-control" required></div>
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
          <label>Land Parcel *</label>
          <select name="land_id" class="form-control" required>
            <option value="">-- Select Land --</option>
            @foreach($lands as $land)<option value="{{ $land->id }}">{{ $land->land_code }} - {{ $land->land_name }}</option>@endforeach
          </select>
        </div>
        <div class="col-12 form-group"><label>Study Title *</label><input type="text" name="study_title" class="form-control" required></div>
        <div class="col-md-3 form-group"><label>Study Date *</label><input type="date" name="study_date" class="form-control" required></div>
        <div class="col-md-3 form-group"><label>Est. Project Cost *</label><input type="number" step="0.01" name="estimated_project_cost" class="form-control" required></div>
        <div class="col-md-3 form-group"><label>Duration (Months) *</label><input type="number" name="estimated_duration_months" class="form-control" required></div>
        <div class="col-md-3 form-group"><label>Expected ROI % *</label><input type="number" step="0.01" name="expected_roi" class="form-control" required></div>
        <div class="col-md-4 form-group">
          <label>Recommendation *</label>
          <select name="recommendation" class="form-control" required>
            @foreach(['Proceed','Revise','Reject'] as $r)<option value="{{ $r }}">{{ $r }}</option>@endforeach
          </select>
        </div>
        <div class="col-md-4 form-group">
          <label>Status</label>
          <select name="status" class="form-control">
            @foreach(['Draft','Submitted','Approved','Rejected'] as $s)<option value="{{ $s }}">{{ $s }}</option>@endforeach
          </select>
        </div>
        <div class="col-12 form-group"><label>Remarks</label><textarea name="remarks" class="form-control" rows="3"></textarea></div>
      </div>
      <button type="submit" class="btn btn-primary">Save Study</button>
      <a href="{{ route('admin.feasibility.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div></div>
</section>
@endsection
