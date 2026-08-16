<div class="row">

    {{-- Status Name --}}
    <div class="col-md-6 mb-3">

        <label for="status_name" class="form-label">
            Status Name
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="status_name"
            id="status_name"
            class="form-control @error('status_name') is-invalid @enderror"
            value="{{ old('status_name', $status->status_name ?? '') }}"
            placeholder="e.g. Available"
            required
        >

        @error('status_name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Color Code --}}
    <div class="col-md-6 mb-3">

        <label for="color_code" class="form-label">
            Color Code
        </label>

        <div class="input-group">

            <input
                type="text"
                name="color_code"
                id="color_code"
                class="form-control @error('color_code') is-invalid @enderror"
                value="{{ old('color_code', $status->color_code ?? '') }}"
                placeholder="#ffffff"
                maxlength="7"
            >

            <span class="input-group-text p-1">
                <input
                    type="color"
                    id="color_picker"
                    class="form-control form-control-color border-0"
                    value="{{ old('color_code', $status->color_code ?? '#ffffff') }}"
                    title="Choose status color"
                >
            </span>

        </div>

        @error('color_code')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Description --}}
    <div class="col-md-12 mb-3">

        <label for="description" class="form-label">
            Description
        </label>

        <textarea
            name="description"
            id="description"
            rows="4"
            class="form-control @error('description') is-invalid @enderror"
            placeholder="Enter status description..."
        >{{ old('description', $status->description ?? '') }}</textarea>

        @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Sort Order --}}
    <div class="col-md-6 mb-3">

        <label for="sort_order" class="form-label">
            Sort Order
        </label>

        <input
            type="number"
            name="sort_order"
            id="sort_order"
            class="form-control @error('sort_order') is-invalid @enderror"
            value="{{ old('sort_order', $status->sort_order ?? 0) }}"
            min="0"
        >

        @error('sort_order')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Active --}}
    <div class="col-md-6 mb-3">

        <label for="is_active" class="form-label">
            Status
            <span class="text-danger">*</span>
        </label>

        <select
            name="is_active"
            id="is_active"
            class="form-select @error('is_active') is-invalid @enderror"
            required
        >

            <option
                value="1"
                {{ old('is_active', $status->is_active ?? 1) == 1 ? 'selected' : '' }}
            >
                Active
            </option>

            <option
                value="0"
                {{ old('is_active', $status->is_active ?? 1) == 0 ? 'selected' : '' }}
            >
                Inactive
            </option>

        </select>

        @error('is_active')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const colorInput = document.getElementById('color_code');
    const colorPicker = document.getElementById('color_picker');

    if (!colorInput || !colorPicker) {
        return;
    }

    colorPicker.addEventListener('input', function () {
        colorInput.value = this.value;
    });

    colorInput.addEventListener('input', function () {

        const value = this.value.trim();

        if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
            colorPicker.value = value;
        }

    });

});
</script>
@endpush