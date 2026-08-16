<div class="row">
    <div class="col-lg-4 col-md-6 mb-3">
        <label for="work_order_id" class="form-label fw-semibold">Work Order ID <span class="text-danger">*</span></label>
        <input id="work_order_id" name="work_order_id" type="number" class="form-control @error('work_order_id') is-invalid @enderror" value="{{ old('work_order_id', $item->work_order_id ?? '') }}" required>
        @error('work_order_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="task_number" class="form-label fw-semibold">Task Number <span class="text-danger">*</span></label>
        <input id="task_number" name="task_number" type="text" class="form-control @error('task_number') is-invalid @enderror" value="{{ old('task_number', $item->task_number ?? '') }}" required>
        @error('task_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="task_title" class="form-label fw-semibold">Task Title <span class="text-danger">*</span></label>
        <input id="task_title" name="task_title" type="text" class="form-control @error('task_title') is-invalid @enderror" value="{{ old('task_title', $item->task_title ?? '') }}" required>
        @error('task_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="task_description" class="form-label fw-semibold">Task Description</label>
        <textarea id="task_description" name="task_description" rows="3" class="form-control @error('task_description') is-invalid @enderror" placeholder="Enter task description...">{{ old('task_description', $item->task_description ?? '') }}</textarea>
        @error('task_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="assigned_to" class="form-label fw-semibold">Assigned To</label>
        <input id="assigned_to" name="assigned_to" type="number" class="form-control @error('assigned_to') is-invalid @enderror" value="{{ old('assigned_to', $item->assigned_to ?? '') }}">
        @error('assigned_to')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="priority" class="form-label fw-semibold">Priority <span class="text-danger">*</span></label>
        <select id="priority" name="priority" class="form-select @error('priority') is-invalid @enderror" required>
            <option value="">Select Priority</option> <option value="Low" {{ old('priority', $item->priority ?? '') == 'Low' ? 'selected' : '' }}>Low</option> <option value="Medium" {{ old('priority', $item->priority ?? '') == 'Medium' ? 'selected' : '' }}>Medium</option> <option value="High" {{ old('priority', $item->priority ?? '') == 'High' ? 'selected' : '' }}>High</option> <option value="Critical" {{ old('priority', $item->priority ?? '') == 'Critical' ? 'selected' : '' }}>Critical</option>
        </select>
        @error('priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="sequence_no" class="form-label fw-semibold">Sequence No</label>
        <input id="sequence_no" name="sequence_no" type="number" class="form-control @error('sequence_no') is-invalid @enderror" value="{{ old('sequence_no', $item->sequence_no ?? '') }}">
        @error('sequence_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="estimated_hours" class="form-label fw-semibold">Estimated Hours</label>
        <input id="estimated_hours" name="estimated_hours" type="number" class="form-control @error('estimated_hours') is-invalid @enderror" value="{{ old('estimated_hours', $item->estimated_hours ?? '') }}" step="0.01">
        @error('estimated_hours')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="actual_hours" class="form-label fw-semibold">Actual Hours</label>
        <input id="actual_hours" name="actual_hours" type="number" class="form-control @error('actual_hours') is-invalid @enderror" value="{{ old('actual_hours', $item->actual_hours ?? '') }}" step="0.01">
        @error('actual_hours')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="completion_percentage" class="form-label fw-semibold">Completion Percentage</label>
        <input id="completion_percentage" name="completion_percentage" type="number" class="form-control @error('completion_percentage') is-invalid @enderror" value="{{ old('completion_percentage', $item->completion_percentage ?? '') }}" step="0.01">
        @error('completion_percentage')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="scheduled_start" class="form-label fw-semibold">Scheduled Start</label>
        <input id="scheduled_start" name="scheduled_start" type="datetime-local" class="form-control @error('scheduled_start') is-invalid @enderror" value="{{ old('scheduled_start', $item->scheduled_start ?? '') }}">
        @error('scheduled_start')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="scheduled_end" class="form-label fw-semibold">Scheduled End</label>
        <input id="scheduled_end" name="scheduled_end" type="datetime-local" class="form-control @error('scheduled_end') is-invalid @enderror" value="{{ old('scheduled_end', $item->scheduled_end ?? '') }}">
        @error('scheduled_end')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="actual_start" class="form-label fw-semibold">Actual Start</label>
        <input id="actual_start" name="actual_start" type="datetime-local" class="form-control @error('actual_start') is-invalid @enderror" value="{{ old('actual_start', $item->actual_start ?? '') }}">
        @error('actual_start')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="actual_end" class="form-label fw-semibold">Actual End</label>
        <input id="actual_end" name="actual_end" type="datetime-local" class="form-control @error('actual_end') is-invalid @enderror" value="{{ old('actual_end', $item->actual_end ?? '') }}">
        @error('actual_end')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="">Select Status</option> <option value="Pending" {{ old('status', $item->status ?? '') == 'Pending' ? 'selected' : '' }}>Pending</option> <option value="Assigned" {{ old('status', $item->status ?? '') == 'Assigned' ? 'selected' : '' }}>Assigned</option> <option value="In Progress" {{ old('status', $item->status ?? '') == 'In Progress' ? 'selected' : '' }}>In Progress</option> <option value="On Hold" {{ old('status', $item->status ?? '') == 'On Hold' ? 'selected' : '' }}>On Hold</option> <option value="Completed" {{ old('status', $item->status ?? '') == 'Completed' ? 'selected' : '' }}>Completed</option> <option value="Cancelled" {{ old('status', $item->status ?? '') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-lg-6 col-md-12 mb-3">
        <label for="completion_notes" class="form-label fw-semibold">Completion Notes</label>
        <textarea id="completion_notes" name="completion_notes" rows="3" class="form-control @error('completion_notes') is-invalid @enderror" placeholder="Enter completion notes...">{{ old('completion_notes', $item->completion_notes ?? '') }}</textarea>
        @error('completion_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

</div>
