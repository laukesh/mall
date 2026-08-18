@extends('layouts.admin')

@section('title', 'Project Budgets')

@section('content')
<section class="section">
  @include('components.finance-nav')
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Project Budgets</h1>
    <a href="{{ route('admin.finance.index') }}" class="btn btn-light">Back</a>
  </div>

  <div class="card mb-3"><div class="card-header"><h4>Add Budget Line</h4></div>
    <div class="card-body">
      <form action="{{ route('admin.finance.budget.store') }}" method="POST">
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
          <div class="col-md-3 form-group"><label>Budget Category *</label><input type="text" name="budget_category" class="form-control" required></div>
          <div class="col-md-2 form-group"><label>Estimated</label><input type="number" step="0.01" name="estimated_amount" class="form-control"></div>
          <div class="col-md-2 form-group"><label>Approved</label><input type="number" step="0.01" name="approved_amount" class="form-control"></div>
          <div class="col-md-2 form-group"><label>Utilized</label><input type="number" step="0.01" name="utilized_amount" class="form-control" value="0"></div>
        </div>
        <button type="submit" class="btn btn-primary">Add Budget Line</button>
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
              <th>Category</th>
              <th>Estimated</th>
              <th>Approved</th>
              <th>Utilized</th>
              <th>Remaining</th>
            </tr>
          </thead>
          <tbody>
            @forelse($budgets as $budget)
            <tr>
              <td>{{ $budget->project_id }}</td>
              <td>{{ $budget->budget_category }}</td>
              <td>{{ number_format($budget->estimated_amount ?? 0, 2) }}</td>
              <td>{{ number_format($budget->approved_amount ?? 0, 2) }}</td>
              <td>{{ number_format($budget->utilized_amount ?? 0, 2) }}</td>
              <td>{{ number_format($budget->remaining_amount ?? 0, 2) }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No budget lines found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
