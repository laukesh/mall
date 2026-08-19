@extends('layouts.admin')

@section('title', 'New Design Package')

@section('content')
<section class="section">
  <div class="section-header"><h1>New Design Package</h1></div>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.design.packages.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-4 form-group">
            <label>Package Code *</label>
            <input type="text" name="package_code" class="form-control" value="{{ old('package_code') }}" required>
          </div>
          <div class="col-md-4 form-group">
            <label>Package Name *</label>
            <input type="text" name="package_name" class="form-control" value="{{ old('package_name') }}" required>
          </div>
          <div class="col-md-4 form-group">
            <label>Project *</label>
            <select name="project_id" class="form-control" required>
              <option value="">-- Select Project --</option>
              @foreach($projects as $project)
                <option value="{{ $project->id }}" @selected(old('project_id') == $project->id)>{{ $project->project_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group">
            <label>Package Type *</label>
            <select name="package_type" class="form-control" required>
              @foreach(['Architectural','Structural','MEP','Landscape','Interior','Infrastructure'] as $type)
                <option value="{{ $type }}" @selected(old('package_type') == $type)>{{ $type }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group">
            <label>Consultant *</label>
            <select name="consultant_id" class="form-control" required @disabled($consultants->isEmpty())>
              <option value="">-- Select Consultant --</option>
              @foreach($consultants as $consultant)
                <option value="{{ $consultant->id }}" @selected(old('consultant_id') == $consultant->id)>{{ $consultant->consultant_name }} ({{ $consultant->consultant_type }})</option>
              @endforeach
            </select>
            @if($consultants->isEmpty())
              <small class="text-danger">No consultants found. <a href="{{ route('admin.consultant.create') }}">Add a consultant</a> first.</small>
            @endif
          </div>
          <div class="col-md-4 form-group">
            <label>Status</label>
            <select name="status" class="form-control">
              @foreach(['Draft','In Review','Approved','Issued'] as $status)
                <option value="{{ $status }}" @selected(old('status', 'Draft') == $status)>{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group">
            <label>Start Date *</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
          </div>
          <div class="col-md-4 form-group">
            <label>Target Date *</label>
            <input type="date" name="target_date" class="form-control" value="{{ old('target_date') }}" required>
          </div>
          <div class="col-12 form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
          </div>
        </div>
        <button type="submit" class="btn btn-primary" @disabled($consultants->isEmpty())>Save Package</button>
        <a href="{{ route('admin.design.packages.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</section>
@endsection
