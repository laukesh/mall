@extends('layouts.admin')

@section('title', 'Audit Logs')

@section('content')
<section class="section">
  <div class="section-header"><h1>Audit Logs</h1></div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Module</th>
              <th>Action</th>
              <th>User</th>
              <th>IP Address</th>
              <th>Date</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($logs as $log)
            <tr>
              <td>{{ $log->module }}</td>
              <td>{{ $log->action }}</td>
              <td>{{ $log->user_id ?? '-' }}</td>
              <td>{{ $log->ip_address ?? '-' }}</td>
              <td>{{ $log->created_at }}</td>
              <td class="text-end">
                <a href="{{ route('admin.audit.show', $log->id) }}" class="btn btn-sm btn-outline-primary">View</a>
              </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No audit logs found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
