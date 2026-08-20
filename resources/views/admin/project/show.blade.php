@extends('layouts.admin')

@section('title', 'Project Details')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>{{ $project->project_name }} <small class="text-muted">({{ $project->project_code }})</small></h1>
    <div>
      <a href="{{ route('admin.project.edit', $project->id) }}" class="btn btn-secondary">Edit</a>
      <a href="{{ route('admin.project.index') }}" class="btn btn-light">Back</a>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="card"><div class="card-header"><h4>Project Details</h4></div>
        <div class="card-body">
          <p><strong>Type:</strong> {{ $project->project_type ?? '-' }}</p>
          <p><strong>Status:</strong> <span class="badge bg-info">{{ $project->status }}</span></p>
          <p><strong>Work Progress:</strong> {{ number_format((float) ($project->progress_percentage ?? 0), 1) }}%</p>
          <p><strong>Location:</strong> {{ $project->location ?? '-' }}, {{ $project->city ?? '' }}, {{ $project->state ?? '' }}</p>
          <p><strong>Planned Dates:</strong> {{ $project->planned_start_date ?? '-' }} to {{ $project->planned_end_date ?? '-' }}</p>
          <p><strong>Estimated Cost:</strong> {{ $project->estimated_cost ? number_format($project->estimated_cost, 2) : '-' }}</p>
          <p><strong>Approved Budget:</strong> {{ $project->approved_budget ? number_format($project->approved_budget, 2) : '-' }}</p>
          @if($project->remarks)<p><strong>Remarks:</strong> {{ $project->remarks }}</p>@endif
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <x-pm-status-change
        :action="route('admin.project.status.update', $project->id)"
        :currentStatus="$project->status"
        :statuses="['Planning','Active','On Hold','Completed','Cancelled']"
        title="Change Project Status"
      />
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-md-6">
      <x-pm-progress-change
        :action="route('admin.project.progress.update', $project->id)"
        :currentProgress="$project->progress_percentage ?? 0"
        title="Update Project Progress"
      />
    </div>
  </div>

  @if(($lands ?? collect())->isNotEmpty())
  <div class="card mt-3"><div class="card-header"><h4>Assigned Lands</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Code</th><th>Name</th><th>Location</th><th>Area</th><th>Status</th></tr></thead>
        <tbody>
          @foreach($lands as $land)
          <tr>
            <td><a href="{{ route('admin.land.show', $land->id) }}">{{ $land->land_code }}</a></td>
            <td>{{ $land->land_name }}</td>
            <td>{{ $land->village }}, {{ $land->district }}</td>
            <td>{{ number_format($land->total_area, 2) }} {{ $land->area_unit }}</td>
            <td><span class="badge bg-info">{{ $land->acquisition_status }}</span></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif

  <div class="row mt-3">
    <div class="col-md-6">
      <div class="card"><div class="card-header"><h4>Add Phase</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.project.phase.store') }}" method="POST">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            <div class="form-group"><label>Phase Name *</label><input type="text" name="phase_name" class="form-control" required></div>
            <div class="row">
              <div class="col-md-4 form-group"><label>Sequence No.</label><input type="number" name="sequence_no" class="form-control"></div>
              <div class="col-md-4 form-group"><label>Start Date</label><input type="date" name="planned_start_date" class="form-control"></div>
              <div class="col-md-4 form-group"><label>End Date</label><input type="date" name="planned_end_date" class="form-control"></div>
            </div>
            <div class="form-group">
              <label>Status *</label>
              <select name="status" class="form-control" required>
                @foreach(['Pending','In Progress','Completed'] as $status)
                  <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
              </select>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Add Phase</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-3"><div class="card-header"><h4>Phases</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Seq</th><th>Phase Name</th><th>Start</th><th>End</th><th>Status</th></tr></thead>
        <tbody>
          @forelse($phases as $phase)
          <tr>
            <td>{{ $phase->sequence_no }}</td>
            <td>{{ $phase->phase_name }}</td>
            <td>{{ $phase->planned_start_date }}</td>
            <td>{{ $phase->planned_end_date }}</td>
            <td><span class="badge bg-info">{{ $phase->status }}</span></td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center text-muted">No phases recorded.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="card mt-3"><div class="card-header"><h4>Milestones</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Name</th><th>Target Date</th><th>Status</th></tr></thead>
        <tbody>
          @forelse($milestones as $milestone)
          <tr>
            <td>{{ $milestone->milestone_name ?? $milestone->name ?? '-' }}</td>
            <td>{{ $milestone->target_date ?? $milestone->planned_date ?? '-' }}</td>
            <td><span class="badge bg-info">{{ $milestone->status ?? '-' }}</span></td>
          </tr>
          @empty
          <tr><td colspan="3" class="text-center text-muted">No milestones recorded.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-md-6">
      <div class="card"><div class="card-header"><h4>Add Team Member</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.project.team.store') }}" method="POST">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            <div class="form-group">
              <label>User *</label>
              <select name="user_id" class="form-control" required>
                <option value="">-- Select User --</option>
                @foreach($users as $user)
                  <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group"><label>Designation</label><input type="text" name="designation" class="form-control"></div>
            <div class="form-group"><label>Assigned Date</label><input type="date" name="assigned_date" class="form-control"></div>
            <div class="form-group">
              <label>Status *</label>
              <select name="status" class="form-control" required>
                @foreach(['Active','Inactive'] as $status)
                  <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
              </select>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Add Team Member</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-3"><div class="card-header"><h4>Team</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>User ID</th><th>Designation</th><th>Assigned Date</th><th>Status</th></tr></thead>
        <tbody>
          @forelse($team as $member)
          <tr>
            <td>{{ $member->user_id }}</td>
            <td>{{ $member->designation ?? '-' }}</td>
            <td>{{ $member->assigned_date }}</td>
            <td><span class="badge bg-info">{{ $member->status }}</span></td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted">No team members assigned.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <x-pm-status-history-table :histories="$statusHistories ?? collect()" title="Project Status History" />
</section>
@endsection
