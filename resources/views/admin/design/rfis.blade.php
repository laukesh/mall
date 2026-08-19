@extends('layouts.admin')

@section('title', 'RFIs')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Requests for Information (RFIs)</h1>
    <a href="{{ route('admin.design.index') }}" class="btn btn-light">Dashboard</a>
  </div>

  <div class="row">
    <div class="col-md-5">
      <div class="card">
        <div class="card-header"><h4>Raise New RFI</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.design.rfi.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label>Project *</label>
              <select name="project_id" class="form-control" required>
                <option value="">-- Select Project --</option>
                @foreach($projects as $project)
                  <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Drawing (optional)</label>
              <select name="drawing_id" class="form-control">
                <option value="">-- None --</option>
                @foreach($drawings as $drawing)
                  <option value="{{ $drawing->id }}">{{ $drawing->drawing_number }} - {{ $drawing->drawing_title }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Assign To *</label>
              <select name="assigned_to" class="form-control" required>
                <option value="">-- Select User --</option>
                @foreach($users as $user)
                  <option value="{{ $user->id }}">{{ $user->full_name }} ({{ $user->email }})</option>
                @endforeach
              </select>
            </div>
            <div class="form-group"><label>Subject *</label><input type="text" name="subject" class="form-control" required></div>
            <div class="form-group"><label>Description *</label><textarea name="description" class="form-control" rows="3" required></textarea></div>
            <div class="row">
              <div class="col-md-6 form-group">
                <label>Priority *</label>
                <select name="priority" class="form-control" required>
                  @foreach(['Low','Medium','High','Critical'] as $priority)
                    <option value="{{ $priority }}">{{ $priority }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 form-group"><label>Due Date *</label><input type="date" name="due_date" class="form-control" required></div>
            </div>
            <button type="submit" class="btn btn-primary">Raise RFI</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="card">
        <div class="card-header"><h4>RFI List</h4></div>
        <div class="card-body p-0">
          <table class="table table-striped mb-0">
            <thead>
              <tr>
                <th>Project</th>
                <th>Subject</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Due Date</th>
              </tr>
            </thead>
            <tbody>
              @forelse($rfis as $rfi)
              <tr>
                <td>{{ $rfi->project?->project_name ?? '—' }}</td>
                <td>{{ $rfi->subject }}</td>
                <td>
                  <span class="badge bg-{{ $rfi->priority === 'Critical' ? 'danger' : ($rfi->priority === 'High' ? 'warning' : 'secondary') }}">
                    {{ $rfi->priority }}
                  </span>
                </td>
                <td><span class="badge bg-info">{{ $rfi->status }}</span></td>
                <td>{{ $rfi->due_date }}</td>
              </tr>
              @empty
              <tr><td colspan="5" class="text-center text-muted py-4">No RFIs found.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
