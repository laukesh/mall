@extends('layouts.admin')

@section('title', 'Safety Inspections')

@section('content')
<section class="section">
  @include('components.hse-nav')
  <div class="section-header"><h1>Safety Inspections</h1></div>

  <div class="card mb-3"><div class="card-header"><h4>Record Inspection</h4></div>
    <div class="card-body">
      <form action="{{ route('admin.hse.inspection.store') }}" method="POST">
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
          <div class="col-md-3 form-group"><label>Inspection Date *</label><input type="date" name="inspection_date" class="form-control" required></div>
          <div class="col-md-3 form-group">
            <label>Inspection Type *</label>
            <select name="inspection_type" class="form-control" required>
              @foreach(['Daily','Weekly','Monthly','Special'] as $type)
                <option value="{{ $type }}">{{ $type }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group">
            <label>Overall Status *</label>
            <select name="overall_status" class="form-control" required>
              @foreach(['Safe','Unsafe'] as $status)
                <option value="{{ $status }}">{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12 form-group"><label>Remarks</label><textarea name="remarks" class="form-control" rows="2"></textarea></div>
        </div>
        <button type="submit" class="btn btn-primary">Record Inspection</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Project</th>
              <th>Date</th>
              <th>Type</th>
              <th>Status</th>
              <th>Remarks</th>
            </tr>
          </thead>
          <tbody>
            @forelse($inspections as $inspection)
            <tr>
              <td>{{ $inspection->project_id }}</td>
              <td>{{ $inspection->inspection_date }}</td>
              <td>{{ $inspection->inspection_type }}</td>
              <td><span class="badge bg-{{ $inspection->overall_status === 'Safe' ? 'success' : 'danger' }}">{{ $inspection->overall_status }}</span></td>
              <td>{{ $inspection->remarks ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No inspections recorded.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
