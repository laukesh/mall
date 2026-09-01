<div class="row g-3">

    <div class="col-md-4">

        <label class="form-label">
            Milestone Number
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="milestone_number"
            class="form-control"
            value="{{ old('milestone_number') }}"
            placeholder="M-001"
            required
        >

    </div>


    <div class="col-md-8">

        <label class="form-label">
            Milestone Title
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="milestone_title"
            class="form-control"
            value="{{ old('milestone_title') }}"
            placeholder="Site Mobilization"
            required
        >

    </div>


    <div class="col-12">

        <label class="form-label">
            Description
        </label>

        <textarea
            name="description"
            rows="3"
            class="form-control"
        >{{ old('description') }}</textarea>

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Planned Start Date
        </label>

        <input
            type="date"
            name="planned_start_date"
            class="form-control"
            value="{{ old('planned_start_date') }}"
        >

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Planned End Date
        </label>

        <input
            type="date"
            name="planned_end_date"
            class="form-control"
            value="{{ old('planned_end_date') }}"
        >

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Milestone Amount
            <span class="text-danger">*</span>
        </label>

        <input
            type="number"
            name="milestone_amount"
            class="form-control"
            step="0.01"
            min="0"
            value="{{ old('milestone_amount', 0) }}"
            required
        >

        <div class="form-text">
            Contract Currency:
            {{ $contract->currency }}
        </div>

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Initial Progress %
        </label>

        <input
            type="number"
            name="progress_percentage"
            class="form-control"
            step="0.01"
            min="0"
            max="100"
            value="{{ old('progress_percentage', 0) }}"
        >

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Deliverable Required?
        </label>

        <select
            name="deliverable_required"
            class="form-select"
        >

            <option value="0">
                No
            </option>

            <option value="1">
                Yes
            </option>

        </select>

    </div>


    <div class="col-md-4">

        <label class="form-label">
            Responsible User ID
        </label>

        <input
            type="number"
            name="responsible_user_id"
            class="form-control"
            value="{{ old('responsible_user_id') }}"
        >

    </div>


    <div class="col-12">

        <label class="form-label">
            Deliverable Description
        </label>

        <textarea
            name="deliverable_description"
            rows="3"
            class="form-control"
        >{{ old('deliverable_description') }}</textarea>

    </div>


    <div class="col-12">

        <label class="form-label">
            Remarks
        </label>

        <textarea
            name="remarks"
            rows="3"
            class="form-control"
        >{{ old('remarks') }}</textarea>

    </div>

</div>