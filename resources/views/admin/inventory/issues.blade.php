@extends('layouts.admin')

@section('title', 'Material Issues')

@section('content')
<section class="section">
  @include('components.inventory-nav')
  <div class="section-header"><h1>Material Issues</h1></div>

  <div class="card mb-3"><div class="card-header"><h4>Record Material Issue</h4></div>
    <div class="card-body">
      <form action="{{ route('admin.inventory.issue.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-3 form-group">
            <label>Issue Request *</label>
            <select name="issue_request_id" class="form-control" required>
              <option value="">-- Select --</option>
              @foreach($issueRequests as $req)
                <option value="{{ $req->id }}">{{ $req->request_number }} ({{ $req->approval_status }})</option>
              @endforeach
            </select>
            @if($issueRequests->isEmpty())
              <small class="text-muted">No issue requests yet. <a href="{{ route('admin.inventory.issue-requests') }}">Create one first</a>.</small>
            @endif
          </div>
          <div class="col-md-3 form-group"><label>Issue Number *</label><input type="text" name="issue_number" class="form-control" required></div>
          <div class="col-md-3 form-group"><label>Issue Date *</label><input type="date" name="issue_date" class="form-control" required></div>
          <div class="col-md-3 form-group">
            <label>Warehouse *</label>
            <select name="warehouse_id" class="form-control" required>
              <option value="">-- Select --</option>
              @foreach($warehouses as $warehouse)
                <option value="{{ $warehouse->id }}">{{ $warehouse->warehouse_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group">
            <label>Contractor</label>
            <select name="contractor_id" class="form-control">
              <option value="">-- None --</option>
              @foreach($contractors as $contractor)
                <option value="{{ $contractor->id }}">{{ $contractor->company_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-8 form-group"><label>Remarks</label><input type="text" name="remarks" class="form-control"></div>
        </div>
        <button type="submit" class="btn btn-primary">Record Issue</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Issue No.</th>
              <th>Date</th>
              <th>Warehouse</th>
              <th>Contractor</th>
              <th>Remarks</th>
            </tr>
          </thead>
          <tbody>
            @forelse($issues as $issue)
            <tr>
              <td>{{ $issue->issue_number }}</td>
              <td>{{ $issue->issue_date }}</td>
              <td>{{ $issue->warehouse_id }}</td>
              <td>{{ $issue->contractor_id ?? '-' }}</td>
              <td>{{ $issue->remarks ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No material issues found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
