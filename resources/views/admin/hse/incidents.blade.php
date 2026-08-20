@extends('layouts.admin')

@section('title', 'HSE Incidents')

@section('content')
<section class="section">
  @include('components.hse-nav')
  <div class="section-header"><h1>HSE Incidents</h1></div>

  <div class="card mb-3"><div class="card-header"><h4>Report Incident</h4></div>
    <div class="card-body">
      <form action="{{ route('admin.hse.incident.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-3 form-group">
            <label>Project *</label>
            <select name="project_id" class="form-control" required>
              <option value="">-- Select --</option>
              @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->project_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group"><label>Incident Number *</label><input type="text" name="incident_number" class="form-control" required></div>
          <div class="col-md-3 form-group">
            <label>Incident Type *</label>
            <select name="incident_type" class="form-control" required>
              @foreach(['Near Miss','Minor Injury','Major Injury','Property Damage','Fatality'] as $type)
                <option value="{{ $type }}">{{ $type }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group"><label>Incident Date *</label><input type="date" name="incident_date" class="form-control" required></div>
          <div class="col-md-6 form-group"><label>Description *</label><textarea name="description" class="form-control" rows="2" required></textarea></div>
          <div class="col-md-3 form-group"><label>Location</label><input type="text" name="location" class="form-control"></div>
          <div class="col-md-3 form-group">
            <label>Status *</label>
            <select name="status" class="form-control" required>
              @foreach(['Open','Under Investigation','Closed'] as $status)
                <option value="{{ $status }}">{{ $status }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Report Incident</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Number</th>
              <th>Project</th>
              <th>Type</th>
              <th>Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($incidents as $incident)
            <tr>
              <td><a href="{{ route('admin.hse.incident.show', $incident->id) }}">{{ $incident->incident_number }}</a></td>
              <td>{{ $incident->project_id }}</td>
              <td>{{ $incident->incident_type }}</td>
              <td>{{ $incident->incident_date }}</td>
              <td><span class="badge bg-{{ $incident->status === 'Closed' ? 'success' : 'warning' }}">{{ $incident->status }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No incidents recorded.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
