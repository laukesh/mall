@extends('layouts.admin')

@section('title', 'Land Details')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>{{ $land->land_name }} <small class="text-muted">({{ $land->land_code }})</small></h1>
    <div>
      <a href="{{ route('admin.land.edit', $land->id) }}" class="btn btn-secondary">Edit</a>
      <a href="{{ route('admin.land.index') }}" class="btn btn-light">Back</a>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="card"><div class="card-header"><h4>Land Details</h4></div>
        <div class="card-body">
          <p><strong>Survey Number:</strong> {{ $land->survey_number }}</p>
          <p><strong>Location:</strong> {{ $land->village }}, {{ $land->taluka }}, {{ $land->district }}, {{ $land->state }}</p>
          <p><strong>Area:</strong> {{ number_format($land->total_area, 2) }} {{ $land->area_unit }}</p>
          <p><strong>Status:</strong> <span class="badge bg-info">{{ $land->acquisition_status }}</span></p>
          @if($land->remarks)<p><strong>Remarks:</strong> {{ $land->remarks }}</p>@endif
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card"><div class="card-header"><h4>Add Owner</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.land.owner.store') }}" method="POST">
            @csrf
            <input type="hidden" name="land_id" value="{{ $land->id }}">
            <div class="form-group"><label>Owner Name *</label><input type="text" name="owner_name" class="form-control" required></div>
            <div class="row">
              <div class="col-md-6 form-group"><label>Mobile *</label><input type="text" name="mobile" class="form-control" required></div>
              <div class="col-md-6 form-group"><label>Ownership % *</label><input type="number" step="0.01" name="ownership_percentage" class="form-control" required></div>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Add Owner</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-3"><div class="card-header"><h4>Owners</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Name</th><th>Mobile</th><th>Ownership %</th><th>Primary</th></tr></thead>
        <tbody>
          @forelse($owners as $owner)
          <tr>
            <td>{{ $owner->owner_name }}</td>
            <td>{{ $owner->mobile }}</td>
            <td>{{ $owner->ownership_percentage }}%</td>
            <td>{{ $owner->is_primary_owner ? 'Yes' : 'No' }}</td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted">No owners recorded.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header"><h4>Add Survey</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.land.survey.store') }}" method="POST">
            @csrf
            <input type="hidden" name="land_id" value="{{ $land->id }}">
            <div class="form-group"><label>Survey Date *</label><input type="date" name="survey_date" class="form-control" required></div>
            <div class="form-group"><label>Survey Agency *</label><input type="text" name="survey_agency" class="form-control" required></div>
            <div class="form-group"><label>Surveyor Name *</label><input type="text" name="surveyor_name" class="form-control" required></div>
            <div class="row">
              <div class="col-md-6 form-group"><label>Measured Area *</label><input type="number" step="0.01" name="measured_area" class="form-control" required></div>
              <div class="col-md-6 form-group"><label>Area Unit *</label><input type="text" name="area_unit" class="form-control" value="Sq Ft" required></div>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Add Survey</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-header"><h4>Upload Document</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.land.document.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="land_id" value="{{ $land->id }}">
            <div class="form-group">
              <label>Document Type *</label>
              <select name="document_type" class="form-control" required>
                @foreach(['Sale Deed','Title Deed','Mutation','Khata','Patta','Tax Receipt','SurveyMap','NOC','Other'] as $type)
                  <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group"><label>Document Number *</label><input type="text" name="document_number" class="form-control" required></div>
            <div class="row">
              <div class="col-md-6 form-group"><label>Issue Date *</label><input type="date" name="issue_date" class="form-control" required></div>
              <div class="col-md-6 form-group"><label>Expiry Date</label><input type="date" name="expiry_date" class="form-control"></div>
            </div>
            <div class="form-group"><label>File</label><input type="file" name="file" class="form-control"></div>
            <button type="submit" class="btn btn-sm btn-primary">Upload Document</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-3">
    <div class="card-header"><h4>Surveys</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Date</th><th>Agency</th><th>Surveyor</th><th>Measured Area</th></tr></thead>
        <tbody>
          @forelse($surveys as $survey)
          <tr>
            <td>{{ $survey->survey_date }}</td>
            <td>{{ $survey->survey_agency }}</td>
            <td>{{ $survey->surveyor_name }}</td>
            <td>{{ number_format($survey->measured_area, 2) }} {{ $survey->area_unit }}</td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted">No surveys recorded.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="card mt-3">
    <div class="card-header"><h4>Documents</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Type</th><th>Number</th><th>Issue Date</th><th>Status</th></tr></thead>
        <tbody>
          @forelse($documents as $doc)
          <tr>
            <td>{{ $doc->document_type }}</td>
            <td>{{ $doc->document_number }}</td>
            <td>{{ $doc->issue_date }}</td>
            <td><span class="badge bg-info">{{ $doc->status }}</span></td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted">No documents uploaded.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @if($owners->count())
  <div class="card mt-3">
    <div class="card-header"><h4>Add Payment</h4></div>
    <div class="card-body">
      <form action="{{ route('admin.land.payment.store') }}" method="POST">
        @csrf
        <input type="hidden" name="land_id" value="{{ $land->id }}">
        <div class="row">
          <div class="col-md-3 form-group">
            <label>Owner *</label>
            <select name="owner_id" class="form-control" required>
              @foreach($owners as $owner)
                <option value="{{ $owner->id }}">{{ $owner->owner_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group"><label>Payment Date *</label><input type="date" name="payment_date" class="form-control" required></div>
          <div class="col-md-3 form-group">
            <label>Mode *</label>
            <select name="payment_mode" class="form-control" required>
              @foreach(['Cheque','NEFT','RTGS','Cash'] as $mode)<option value="{{ $mode }}">{{ $mode }}</option>@endforeach
            </select>
          </div>
          <div class="col-md-3 form-group"><label>Amount *</label><input type="number" step="0.01" name="amount" class="form-control" required></div>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Add Payment</button>
      </form>
    </div>
  </div>
  @endif

  <div class="card mt-3">
    <div class="card-header"><h4>Payments</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Date</th><th>Mode</th><th>Amount</th><th>Status</th></tr></thead>
        <tbody>
          @forelse($payments as $payment)
          <tr>
            <td>{{ $payment->payment_date }}</td>
            <td>{{ $payment->payment_mode }}</td>
            <td>{{ number_format($payment->amount, 2) }}</td>
            <td><span class="badge bg-info">{{ $payment->payment_status }}</span></td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted">No payments recorded.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="card mt-3"><div class="card-header"><h4>History</h4></div>
    <div class="card-body">
      @forelse($history as $event)
        <div class="mb-2"><strong>{{ $event->event_type }}</strong> — {{ $event->description }} <small class="text-muted">({{ $event->event_date }})</small></div>
      @empty
        <p class="text-muted mb-0">No history events.</p>
      @endforelse
    </div>
  </div>
</section>
@endsection
