@props(['histories', 'title' => 'Status History'])

<div class="card mt-3">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h4>{{ $title }}</h4>
    <a href="{{ route('admin.pm.status-history.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
  </div>
  <div class="card-body p-0">
    <table class="table mb-0">
      <thead>
        <tr>
          <th>Date</th>
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
          <td>{{ $history->field_name ?? 'status' }}</td>
          <td>{{ $history->old_value ?? '-' }}</td>
          <td><span class="badge bg-info">{{ $history->new_value }}</span></td>
          <td>
            <x-history-user :user="$history->changedBy" :userId="$history->changed_by" />
          </td>
          <td>{{ $history->changedBy?->role_label ?? '-' }}</td>
          <td>{{ $history->remarks ?? '-' }}</td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted">No status changes recorded.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
