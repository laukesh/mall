@extends('layouts.admin')

@section('title', 'Drawing Details')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>{{ $drawing->drawing_title }} <small class="text-muted">({{ $drawing->drawing_number }})</small></h1>
    <a href="{{ route('admin.design.drawings.index') }}" class="btn btn-light">Back</a>
  </div>

  <div class="card">
    <div class="card-header"><h4>Drawing Details</h4></div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <p><strong>Type:</strong> {{ $drawing->drawing_type }}</p>
          <p><strong>Discipline:</strong> {{ $drawing->discipline }}</p>
          <p><strong>Current Revision:</strong> {{ $drawing->current_revision }}</p>
        </div>
        <div class="col-md-6">
          <p><strong>Status:</strong> <span class="badge bg-info">{{ $drawing->drawing_status }}</span></p>
          <p><strong>Upload Date:</strong> {{ $drawing->upload_date }}</p>
          <p><strong>Package:</strong> {{ $drawing->designPackage?->package_name ?? '—' }}</p>
          <p><strong>Project:</strong> {{ $drawing->designPackage?->project?->project_name ?? '—' }}</p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
