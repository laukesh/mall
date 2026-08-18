@extends('layouts.admin')

@section('title', 'New Drawing')

@section('content')
<section class="section">
  <div class="section-header"><h1>New Drawing</h1></div>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.design.drawings.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-6 form-group">
            <label>Design Package *</label>
            <select name="design_package_id" class="form-control" required>
              <option value="">-- Select Package --</option>
              @foreach($packages as $package)
                <option value="{{ $package->id }}" @selected(old('design_package_id') == $package->id)>{{ $package->package_code }} - {{ $package->package_name }} ({{ $package->project?->project_name ?? 'No project' }})</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group">
            <label>Drawing Number *</label>
            <input type="text" name="drawing_number" class="form-control" value="{{ old('drawing_number') }}" required>
          </div>
          <div class="col-md-3 form-group">
            <label>Revision</label>
            <input type="text" name="current_revision" class="form-control" value="{{ old('current_revision', 'R0') }}">
          </div>
          <div class="col-12 form-group">
            <label>Drawing Title *</label>
            <input type="text" name="drawing_title" class="form-control" value="{{ old('drawing_title') }}" required>
          </div>
          <div class="col-md-4 form-group">
            <label>Drawing Type *</label>
            <select name="drawing_type" class="form-control" required>
              @foreach(['Concept','Tender','Construction','Shop','As-Built'] as $type)
                <option value="{{ $type }}" @selected(old('drawing_type') == $type)>{{ $type }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group">
            <label>Discipline *</label>
            <select name="discipline" class="form-control" required>
              @foreach(['Architectural','Structural','Electrical','Plumbing','HVAC','Fire Fighting','ELV'] as $discipline)
                <option value="{{ $discipline }}" @selected(old('discipline') == $discipline)>{{ $discipline }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group">
            <label>Status</label>
            <select name="drawing_status" class="form-control">
              @foreach(['Draft','Under Review','Approved','IFC','Superseded'] as $status)
                <option value="{{ $status }}" @selected(old('drawing_status', 'Draft') == $status)>{{ $status }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Save Drawing</button>
        <a href="{{ route('admin.design.drawings.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</section>
@endsection
