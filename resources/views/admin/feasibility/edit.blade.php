@extends('layouts.admin')

@section('title', 'Edit Feasibility Study')

@section('content')
<section class="section">
  <div class="section-header"><h1>Edit Feasibility Study</h1></div>
  <div class="card"><div class="card-body">
    <form action="{{ route('admin.feasibility.update', $study->id) }}" method="POST">@csrf
      <div class="row">
        <div class="col-md-4 form-group"><label>Feasibility Code *</label><input type="text" name="feasibility_code" class="form-control" value="{{ $study->feasibility_code }}" required></div>
        <div class="col-md-4 form-group">
          <label>Project *</label>
          <select name="project_id" class="form-control" required>
            <option value="">-- Select Project --</option>
            @foreach($projects as $project)
              <option value="{{ $project->id }}" @selected(old('project_id', $study->project_id) == $project->id)>{{ $project->project_name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4 form-group">
          <label>Land Parcel *</label>
          <select name="land_id" class="form-control" required>
            @foreach($lands as $land)<option value="{{ $land->id }}" @selected($study->land_id == $land->id)>{{ $land->land_code }} - {{ $land->land_name }}</option>@endforeach
          </select>
        </div>
        <div class="col-12 form-group"><label>Study Title *</label><input type="text" name="study_title" class="form-control" value="{{ $study->study_title }}" required></div>
        <div class="col-md-3 form-group"><label>Study Date *</label><input type="date" name="study_date" class="form-control" value="{{ $study->study_date }}" required></div>
        <div class="col-md-3 form-group"><label>Est. Project Cost *</label><input type="number" step="0.01" name="estimated_project_cost" class="form-control" value="{{ $study->estimated_project_cost }}" required></div>
        <div class="col-md-3 form-group"><label>Duration (Months) *</label><input type="number" name="estimated_duration_months" class="form-control" value="{{ $study->estimated_duration_months }}" required></div>
        <div class="col-md-3 form-group"><label>Expected ROI % *</label><input type="number" step="0.01" name="expected_roi" class="form-control" value="{{ $study->expected_roi }}" required></div>
        <div class="col-md-4 form-group">
          <label>Recommendation *</label>
          <select name="recommendation" class="form-control" required>
            @foreach(['Proceed','Revise','Reject'] as $r)<option value="{{ $r }}" @selected($study->recommendation == $r)>{{ $r }}</option>@endforeach
          </select>
        </div>
        <div class="col-md-4 form-group">
          <label>Status *</label>
          <select name="status" class="form-control" required>
            @foreach(['Draft','Submitted','Approved','Rejected'] as $s)<option value="{{ $s }}" @selected($study->status == $s)>{{ $s }}</option>@endforeach
          </select>
        </div>
        <div class="col-12 form-group"><label>Remarks</label><textarea name="remarks" class="form-control" rows="3">{{ $study->remarks }}</textarea></div>
      </div>
      <button type="submit" class="btn btn-primary">Update Study</button>
      <a href="{{ route('admin.feasibility.show', $study->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div></div>
</section>
@endsection
