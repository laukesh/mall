@extends('layouts.admin')

@section('title', 'Mobilization Plan Details')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>{{ $plan->mobilization_name }} <small class="text-muted">({{ $plan->plan_number }})</small></h1>
    <div>
      <a href="{{ route('admin.mobilization.edit', $plan->id) }}" class="btn btn-secondary">Edit</a>
      <a href="{{ route('admin.mobilization.index') }}" class="btn btn-light">Back</a>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="card"><div class="card-header"><h4>Plan Details</h4></div>
        <div class="card-body">
          <p><strong>Type:</strong> {{ $plan->mobilization_type }}</p>
          <p><strong>Status:</strong> <span class="badge bg-info">{{ $plan->status }}</span></p>
          <p><strong>Planned Dates:</strong> {{ $plan->planned_start_date ?? '-' }} to {{ $plan->planned_end_date ?? '-' }}</p>
          @if($plan->remarks)<p><strong>Remarks:</strong> {{ $plan->remarks }}</p>@endif
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card"><div class="card-header"><h4>Add Resource</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.mobilization.resource.store') }}" method="POST">
            @csrf
            <input type="hidden" name="mobilization_plan_id" value="{{ $plan->id }}">
            <div class="form-group">
              <label>Resource Type *</label>
              <select name="resource_type" class="form-control" required>
                @foreach(['Labour','Equipment','Vehicle','Material','Tool'] as $type)
                  <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group"><label>Resource Name *</label><input type="text" name="resource_name" class="form-control" required></div>
            <div class="row">
              <div class="col-md-4 form-group"><label>Quantity *</label><input type="number" step="0.01" name="required_quantity" class="form-control" required></div>
              <div class="col-md-4 form-group"><label>Unit</label><input type="text" name="unit" class="form-control"></div>
              <div class="col-md-4 form-group"><label>Required Date</label><input type="date" name="required_date" class="form-control"></div>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Add Resource</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-3"><div class="card-header"><h4>Resources</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Type</th><th>Name</th><th>Quantity</th><th>Unit</th><th>Required Date</th></tr></thead>
        <tbody>
          @forelse($resources as $resource)
          <tr>
            <td>{{ $resource->resource_type }}</td>
            <td>{{ $resource->resource_name }}</td>
            <td>{{ $resource->required_quantity }}</td>
            <td>{{ $resource->unit ?? '-' }}</td>
            <td>{{ $resource->required_date ?? '-' }}</td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center text-muted">No resources recorded.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-md-6">
      <div class="card"><div class="card-header"><h4>Add Checklist Item</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.mobilization.checklist.store') }}" method="POST">
            @csrf
            <input type="hidden" name="mobilization_plan_id" value="{{ $plan->id }}">
            <div class="form-group"><label>Checklist Item *</label><input type="text" name="checklist_item" class="form-control" required></div>
            <div class="form-check mb-2">
              <input type="checkbox" name="completed" value="1" class="form-check-input" id="completed">
              <label class="form-check-label" for="completed">Completed</label>
            </div>
            <div class="form-group"><label>Verified Date</label><input type="date" name="verified_date" class="form-control"></div>
            <button type="submit" class="btn btn-sm btn-primary">Add Checklist Item</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-3"><div class="card-header"><h4>Checklists</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Item</th><th>Completed</th><th>Verified Date</th><th>Remarks</th></tr></thead>
        <tbody>
          @forelse($checklists as $item)
          <tr>
            <td>{{ $item->checklist_item }}</td>
            <td>{{ $item->completed ? 'Yes' : 'No' }}</td>
            <td>{{ $item->verified_date ?? '-' }}</td>
            <td>{{ $item->remarks ?? '-' }}</td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted">No checklist items recorded.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
