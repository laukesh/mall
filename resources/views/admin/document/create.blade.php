@extends('layouts.admin')

@section('title', 'Add Document')

@section('content')
<section class="section">
  <div class="section-header"><h1>Add Document</h1></div>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.document.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
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
            <label>Category *</label>
            <select name="category_id" class="form-control" required>
              <option value="">-- Select Category --</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->category_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group"><label>Document Number *</label><input type="text" name="document_number" class="form-control" value="{{ old('document_number') }}" required></div>
          <div class="col-md-8 form-group"><label>Document Title *</label><input type="text" name="document_title" class="form-control" value="{{ old('document_title') }}" required></div>
          <div class="col-md-4 form-group"><label>Document Type</label><input type="text" name="document_type" class="form-control" value="{{ old('document_type') }}"></div>
          <div class="col-md-4 form-group">
            <label>Approval Status *</label>
            <select name="approval_status" class="form-control" required>
              @foreach(['Draft','Pending','Approved','Rejected'] as $status)
                <option value="{{ $status }}" @selected(old('approval_status', 'Draft') == $status)>{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group">
            <label>Visibility *</label>
            <select name="visibility" class="form-control" required>
              @foreach(['Internal','Contractor','Client','Public'] as $visibility)
                <option value="{{ $visibility }}" @selected(old('visibility', 'Internal') == $visibility)>{{ $visibility }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group"><label>Version</label><input type="text" name="current_version" class="form-control" value="{{ old('current_version', 'V1') }}"></div>
          <div class="col-md-4 form-group"><label>File</label><input type="file" name="document_file" class="form-control"></div>
          <div class="col-12 form-group"><label>Remarks</label><textarea name="remarks" class="form-control" rows="2">{{ old('remarks') }}</textarea></div>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">Save Document</button>
          <a href="{{ route('admin.document.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
