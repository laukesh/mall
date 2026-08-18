@extends('layouts.admin')

@section('title', 'Feasibility Study Details')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>{{ $study->study_title }} <small class="text-muted">({{ $study->feasibility_code }})</small></h1>
    <div>
      <a href="{{ route('admin.feasibility.edit', $study->id) }}" class="btn btn-secondary">Edit</a>
      <a href="{{ route('admin.feasibility.index') }}" class="btn btn-light">Back</a>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><h4>Study Overview</h4></div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <p><strong>Project:</strong> {{ $study->project?->project_name ?? '—' }}</p>
          <p><strong>Study Date:</strong> {{ $study->study_date }}</p>
          <p><strong>Est. Project Cost:</strong> {{ number_format($study->estimated_project_cost, 2) }}</p>
          <p><strong>Duration:</strong> {{ $study->estimated_duration_months }} months</p>
        </div>
        <div class="col-md-6">
          <p><strong>Expected ROI:</strong> {{ $study->expected_roi }}%</p>
          <p><strong>Recommendation:</strong>
            <span class="badge bg-{{ $study->recommendation === 'Proceed' ? 'success' : ($study->recommendation === 'Reject' ? 'danger' : 'warning') }}">
              {{ $study->recommendation }}
            </span>
          </p>
          <p><strong>Status:</strong> {{ $study->status }}</p>
          @if($study->remarks)<p><strong>Remarks:</strong> {{ $study->remarks }}</p>@endif
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header"><h4>Add Soil Investigation</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.feasibility.soil.store') }}" method="POST">
            @csrf
            <input type="hidden" name="feasibility_id" value="{{ $study->id }}">
            <div class="row">
              <div class="col-md-6 form-group"><label>Test Number *</label><input type="text" name="test_number" class="form-control" required></div>
              <div class="col-md-6 form-group"><label>Test Date *</label><input type="date" name="test_date" class="form-control" required></div>
              <div class="col-md-6 form-group"><label>Testing Agency *</label><input type="text" name="testing_agency" class="form-control" required></div>
              <div class="col-md-6 form-group"><label>Soil Type *</label><input type="text" name="soil_type" class="form-control" required></div>
              <div class="col-md-6 form-group"><label>Bearing Capacity *</label><input type="number" step="0.01" name="bearing_capacity" class="form-control" required></div>
              <div class="col-md-6 form-group"><label>Water Table Depth *</label><input type="number" step="0.01" name="water_table_depth" class="form-control" required></div>
              <div class="col-12 form-group"><label>Remarks</label><textarea name="remarks" class="form-control" rows="2"></textarea></div>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Add Soil Test</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-header"><h4>Add Risk Assessment</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.feasibility.risk.store') }}" method="POST">
            @csrf
            <input type="hidden" name="feasibility_id" value="{{ $study->id }}">
            <div class="form-group">
              <label>Risk Category *</label>
              <select name="risk_category" class="form-control" required>
                @foreach(['Technical','Financial','Legal','Environmental','Operational'] as $cat)
                  <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group"><label>Description *</label><textarea name="risk_description" class="form-control" rows="2" required></textarea></div>
            <div class="row">
              <div class="col-md-6 form-group">
                <label>Probability *</label>
                <select name="probability" class="form-control" required>
                  @foreach(['Low','Medium','High'] as $p)<option value="{{ $p }}">{{ $p }}</option>@endforeach
                </select>
              </div>
              <div class="col-md-6 form-group">
                <label>Impact *</label>
                <select name="impact" class="form-control" required>
                  @foreach(['Low','Medium','High'] as $i)<option value="{{ $i }}">{{ $i }}</option>@endforeach
                </select>
              </div>
            </div>
            <div class="form-group"><label>Mitigation Strategy</label><textarea name="mitigation_strategy" class="form-control" rows="2"></textarea></div>
            <button type="submit" class="btn btn-sm btn-primary">Add Risk</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-3">
    <div class="card-header"><h4>Soil Investigations</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Test No.</th><th>Date</th><th>Agency</th><th>Soil Type</th><th>Bearing Capacity</th><th>Water Table</th></tr></thead>
        <tbody>
          @forelse($soilTests as $test)
          <tr>
            <td>{{ $test->test_number }}</td>
            <td>{{ $test->test_date }}</td>
            <td>{{ $test->testing_agency }}</td>
            <td>{{ $test->soil_type }}</td>
            <td>{{ $test->bearing_capacity }}</td>
            <td>{{ $test->water_table_depth }}</td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center text-muted">No soil tests recorded.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="card mt-3">
    <div class="card-header"><h4>Risk Assessments</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Category</th><th>Description</th><th>Probability</th><th>Impact</th><th>Status</th></tr></thead>
        <tbody>
          @forelse($risks as $risk)
          <tr>
            <td>{{ $risk->risk_category }}</td>
            <td>{{ Str::limit($risk->risk_description, 60) }}</td>
            <td>{{ $risk->probability }}</td>
            <td>{{ $risk->impact }}</td>
            <td><span class="badge bg-info">{{ $risk->status }}</span></td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center text-muted">No risks recorded.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
