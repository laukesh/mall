@extends('layouts.admin')

@section('title', 'Bill of Quantities')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Bill of Quantities (BOQ)</h1>
    <a href="{{ route('admin.design.index') }}" class="btn btn-light">Dashboard</a>
  </div>

  <div class="row">
    <div class="col-md-5">
      <div class="card">
        <div class="card-header"><h4>Add BOQ Item</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.design.boq.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label>Project *</label>
              <select name="project_id" class="form-control" required>
                <option value="">-- Select Project --</option>
                @foreach($projects as $project)
                  <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Drawing (optional)</label>
              <select name="drawing_id" class="form-control">
                <option value="">-- None --</option>
                @foreach($drawings as $drawing)
                  <option value="{{ $drawing->id }}">{{ $drawing->drawing_number }} - {{ $drawing->drawing_title }}</option>
                @endforeach
              </select>
            </div>
            <div class="row">
              <div class="col-md-6 form-group"><label>BOQ Number *</label><input type="text" name="boq_number" class="form-control" required></div>
              <div class="col-md-6 form-group"><label>Item Code *</label><input type="text" name="item_code" class="form-control" required></div>
            </div>
            <div class="form-group"><label>Description *</label><textarea name="item_description" class="form-control" rows="2" required></textarea></div>
            <div class="row">
              <div class="col-md-4 form-group"><label>Unit *</label><input type="text" name="unit" class="form-control" required></div>
              <div class="col-md-4 form-group"><label>Quantity *</label><input type="number" step="0.001" name="quantity" class="form-control" required></div>
              <div class="col-md-4 form-group"><label>Rate *</label><input type="number" step="0.01" name="estimated_rate" class="form-control" required></div>
            </div>
            <button type="submit" class="btn btn-primary">Add Item</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="card">
        <div class="card-header"><h4>BOQ Items</h4></div>
        <div class="card-body p-0">
          <table class="table table-striped mb-0">
            <thead>
              <tr>
                <th>Project</th>
                <th>BOQ No.</th>
                <th>Item Code</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Rate</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              @forelse($boqItems as $item)
              <tr>
                <td>{{ $item->project?->project_name ?? '—' }}</td>
                <td>{{ $item->boq_number }}</td>
                <td>{{ $item->item_code }}</td>
                <td>{{ Str::limit($item->item_description, 40) }}</td>
                <td>{{ number_format($item->quantity, 3) }} {{ $item->unit }}</td>
                <td>{{ number_format($item->estimated_rate, 2) }}</td>
                <td>{{ number_format($item->estimated_amount, 2) }}</td>
              </tr>
              @empty
              <tr><td colspan="7" class="text-center text-muted py-4">No BOQ items found.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
