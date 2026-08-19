@extends('layouts.admin')

@section('title', 'Expenses')

@section('content')
<section class="section">
  @include('components.finance-nav')
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Expenses</h1>
    <a href="{{ route('admin.finance.index') }}" class="btn btn-light">Back</a>
  </div>

  <div class="card mb-3"><div class="card-header"><h4>Record Expense</h4></div>
    <div class="card-body">
      <form action="{{ route('admin.finance.expense.store') }}" method="POST">
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
          <div class="col-md-3 form-group"><label>Expense Date *</label><input type="date" name="expense_date" class="form-control" required></div>
          <div class="col-md-3 form-group"><label>Category *</label><input type="text" name="expense_category" class="form-control" required></div>
          <div class="col-md-3 form-group"><label>Amount *</label><input type="number" step="0.01" name="amount" class="form-control" required></div>
          <div class="col-12 form-group"><label>Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
        </div>
        <button type="submit" class="btn btn-primary">Record Expense</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Date</th>
              <th>Project</th>
              <th>Category</th>
              <th>Amount</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            @forelse($expenses as $expense)
            <tr>
              <td>{{ $expense->expense_date }}</td>
              <td>{{ $expense->project_id }}</td>
              <td>{{ $expense->expense_category }}</td>
              <td>{{ number_format($expense->amount ?? 0, 2) }}</td>
              <td>{{ $expense->description ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No expenses found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
