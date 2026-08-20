@extends('layouts.admin')

@section('title', 'Purchase Requisitions')

@section('content')
<section class="section">
  @include('components.procurement-nav')
  <div class="section-header"><h1>Purchase Requisitions</h1></div>

  <div class="card mb-3"><div class="card-header"><h4>Create Requisition</h4></div>
    <div class="card-body">
      <form action="{{ route('admin.procurement.requisition.store') }}" method="POST">
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
          <div class="col-md-3 form-group"><label>Requisition No. *</label><input type="text" name="requisition_no" class="form-control" required></div>
          <div class="col-md-3 form-group"><label>Request Date *</label><input type="date" name="request_date" class="form-control" required></div>
          <div class="col-md-3 form-group"><label>Required Date</label><input type="date" name="required_date" class="form-control"></div>
          <div class="col-md-3 form-group">
            <label>Approval Status *</label>
            <select name="approval_status" class="form-control" required>
              @foreach(['Pending','Approved','Rejected'] as $status)
                <option value="{{ $status }}">{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group">
            <label>Priority</label>
            <select name="priority" class="form-control">
              @foreach(['Low','Medium','High'] as $priority)
                <option value="{{ $priority }}">{{ $priority }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6 form-group"><label>Remarks</label><input type="text" name="remarks" class="form-control"></div>
        </div>
        <button type="submit" class="btn btn-primary">Create Requisition</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Requisition No.</th>
              <th>Project</th>
              <th>Request Date</th>
              <th>Priority</th>
              <th>Approval Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($requisitions as $req)
            <tr>
              <td><a href="{{ route('admin.procurement.requisition.show', $req->id) }}">{{ $req->requisition_no }}</a></td>
              <td>{{ $req->project_id }}</td>
              <td>{{ $req->request_date }}</td>
              <td>{{ $req->priority ?? '-' }}</td>
              <td><span class="badge bg-info">{{ $req->approval_status }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No requisitions found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
