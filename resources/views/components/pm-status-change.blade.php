@props([
    'action',
    'currentStatus',
    'statuses',
    'title' => 'Change Status',
])

<div class="card">
  <div class="card-header"><h4>{{ $title }}</h4></div>
  <div class="card-body">
    <p class="mb-2"><strong>Current:</strong> <span class="badge bg-info">{{ $currentStatus }}</span></p>
    <form action="{{ $action }}" method="POST">
      @csrf
      <div class="form-group">
        <label>New Status *</label>
        <select name="status" class="form-control" required>
          @foreach($statuses as $status)
            <option value="{{ $status }}" @selected($status === $currentStatus)>{{ $status }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Remarks</label>
        <textarea name="remarks" class="form-control" rows="2" placeholder="Reason for status change">{{ old('remarks') }}</textarea>
      </div>
      <button type="submit" class="btn btn-sm btn-primary">Update Status</button>
    </form>
  </div>
</div>
