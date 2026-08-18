@extends('layouts.admin')

@section('title', 'Mobilization Plans')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Mobilization Plans</h1>
    <a href="{{ route('admin.mobilization.create') }}" class="btn btn-primary">Add Plan</a>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Plan No.</th>
              <th>Name</th>
              <th>Project</th>
              <th>Type</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($plans as $plan)
            <tr>
              <td>{{ $plan->plan_number }}</td>
              <td>{{ $plan->mobilization_name }}</td>
              <td>{{ $plan->project_id }}</td>
              <td>{{ $plan->mobilization_type }}</td>
              <td><span class="badge bg-info">{{ $plan->status }}</span></td>
              <td class="text-end">
                <a href="{{ route('admin.mobilization.show', $plan->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                <a href="{{ route('admin.mobilization.edit', $plan->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                <form action="{{ route('admin.mobilization.destroy', $plan->id) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this plan?')">Delete</button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No mobilization plans found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
