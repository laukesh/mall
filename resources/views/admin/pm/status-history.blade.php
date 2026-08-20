@extends('layouts.admin')

@section('title', 'Status History')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Project Management Status History</h1>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <form method="GET" action="{{ route('admin.pm.status-history.index') }}" class="row">
        <div class="col-md-4 form-group">
          <label>Entity Type</label>
          <select name="entity_type" class="form-control">
            <option value="">All Types</option>
            @foreach($entityTypes as $value => $label)
              <option value="{{ $value }}" @selected(request('entity_type') == $value)>{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4 form-group">
          <label>Entity ID</label>
          <input type="number" name="entity_id" class="form-control" value="{{ request('entity_id') }}" placeholder="Optional">
        </div>
        <div class="col-md-4 form-group d-flex align-items-end">
          <button type="submit" class="btn btn-primary me-2">Filter</button>
          <a href="{{ route('admin.pm.status-history.index') }}" class="btn btn-secondary">Reset</a>
        </div>
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
              <th>Entity</th>
              <th>ID</th>
              <th>Field</th>
              <th>From</th>
              <th>To</th>
              <th>Changed By</th>
              <th>Role</th>
              <th>Remarks</th>
            </tr>
          </thead>
          <tbody>
            @forelse($histories as $history)
            <tr>
              <td>{{ $history->changed_at ? \Carbon\Carbon::parse($history->changed_at)->format('d M Y H:i') : '-' }}</td>
              <td>{{ $entityTypes[$history->entity_type] ?? $history->entity_type }}</td>
              <td>{{ $history->entity_id }}</td>
              <td>{{ $history->field_name }}</td>
              <td>{{ $history->old_value ?? '-' }}</td>
              <td><span class="badge bg-info">{{ $history->new_value }}</span></td>
              <td>
                <x-history-user :user="$history->changedBy" :userId="$history->changed_by" />
              </td>
              <td>{{ $history->changedBy?->role_label ?? '-' }}</td>
              <td>{{ $history->remarks ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="9" class="text-center text-muted py-4">No status history found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    @if($histories->hasPages())
    <div class="card-footer">{{ $histories->links() }}</div>
    @endif
  </div>
</section>
@endsection
