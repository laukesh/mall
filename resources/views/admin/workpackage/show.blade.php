@extends('layouts.admin')

@section('title', 'Work Package Details')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>{{ $package->package_name }} <small class="text-muted">({{ $package->package_code }})</small></h1>
    <div>
      <a href="{{ route('admin.workpackage.edit', $package->id) }}" class="btn btn-secondary">Edit</a>
      <a href="{{ route('admin.workpackage.index') }}" class="btn btn-light">Back</a>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="card"><div class="card-header"><h4>Package Details</h4></div>
        <div class="card-body">
          <p><strong>Discipline:</strong> {{ $package->discipline }}</p>
          <p><strong>Status:</strong> <span class="badge bg-info">{{ $package->status }}</span></p>
          <p><strong>Planned Dates:</strong> {{ $package->planned_start_date ?? '-' }} to {{ $package->planned_end_date ?? '-' }}</p>
          <p><strong>Estimated Cost:</strong> {{ $package->estimated_cost ? number_format($package->estimated_cost, 2) : '-' }}</p>
          @if($package->description)<p><strong>Description:</strong> {{ $package->description }}</p>@endif
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card"><div class="card-header"><h4>Add Task</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.workpackage.task.store') }}" method="POST">
            @csrf
            <input type="hidden" name="work_package_id" value="{{ $package->id }}">
            <div class="row">
              <div class="col-md-4 form-group"><label>Task Code *</label><input type="text" name="task_code" class="form-control" required></div>
              <div class="col-md-8 form-group"><label>Task Name *</label><input type="text" name="task_name" class="form-control" required></div>
            </div>
            <div class="form-group">
              <label>Status *</label>
              <select name="status" class="form-control" required>
                @foreach(['Pending','Running','Completed','Delayed'] as $status)
                  <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
              </select>
            </div>
            <div class="row">
              <div class="col-md-4 form-group">
                <label>Priority</label>
                <select name="priority" class="form-control">
                  @foreach(['Low','Medium','High'] as $priority)
                    <option value="{{ $priority }}">{{ $priority }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4 form-group"><label>Start Date</label><input type="date" name="planned_start_date" class="form-control"></div>
              <div class="col-md-4 form-group"><label>End Date</label><input type="date" name="planned_end_date" class="form-control"></div>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Add Task</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-3"><div class="card-header"><h4>Tasks</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Code</th><th>Task Name</th><th>Priority</th><th>Status</th><th>Planned Dates</th></tr></thead>
        <tbody>
          @forelse($tasks as $task)
          <tr>
            <td>{{ $task->task_code }}</td>
            <td>{{ $task->task_name }}</td>
            <td>{{ $task->priority ?? '-' }}</td>
            <td><span class="badge bg-info">{{ $task->status }}</span></td>
            <td>{{ $task->planned_start_date ?? '-' }} - {{ $task->planned_end_date ?? '-' }}</td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center text-muted">No tasks recorded.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
