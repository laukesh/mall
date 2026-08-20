@props([
    'action',
    'currentProgress' => 0,
    'title' => 'Update Work Progress',
])

<div class="card">
  <div class="card-header"><h4>{{ $title }}</h4></div>
  <div class="card-body">
    <p class="mb-2"><strong>Current:</strong> <span class="badge bg-success">{{ number_format((float) $currentProgress, 1) }}%</span></p>
    <form action="{{ $action }}" method="POST">
      @csrf
      <div class="form-group">
        <label>Progress % *</label>
        <input type="number" name="progress_percentage" class="form-control" min="0" max="100" step="0.1"
               value="{{ old('progress_percentage', $currentProgress) }}" required>
      </div>
      <div class="form-group">
        <label>Remarks</label>
        <textarea name="remarks" class="form-control" rows="2" placeholder="Notes on progress update">{{ old('remarks') }}</textarea>
      </div>
      <button type="submit" class="btn btn-sm btn-success">Update Progress</button>
    </form>
  </div>
</div>
