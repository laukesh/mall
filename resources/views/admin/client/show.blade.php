@extends('layouts.admin')

@section('title', 'Client Details')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>{{ $client->client_name }} <small class="text-muted">({{ $client->client_code }})</small></h1>
    <div>
      <a href="{{ route('admin.client.edit', $client->id) }}" class="btn btn-secondary">Edit</a>
      <a href="{{ route('admin.client.index') }}" class="btn btn-light">Back</a>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="card"><div class="card-header"><h4>Client Details</h4></div>
        <div class="card-body">
          <p><strong>Type:</strong> {{ $client->client_type }}</p>
          <p><strong>Contact:</strong> {{ $client->contact_person ?? '-' }} / {{ $client->mobile ?? '-' }}</p>
          <p><strong>Email:</strong> {{ $client->email ?? '-' }}</p>
          <p><strong>GST:</strong> {{ $client->gst_number ?? '-' }}</p>
          <p><strong>Status:</strong> <span class="badge bg-{{ $client->status === 'Active' ? 'success' : 'secondary' }}">{{ $client->status }}</span></p>
          <p><strong>Address:</strong> {{ $client->address ?? '-' }}, {{ $client->city ?? '' }}, {{ $client->state ?? '' }} {{ $client->pincode ?? '' }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card"><div class="card-header"><h4>Add Invoice</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.client.invoice.store') }}" method="POST">
            @csrf
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <div class="form-group">
              <label>Project *</label>
              <select name="project_id" class="form-control" required>
                <option value="">-- Select Project --</option>
                @foreach($projects as $project)
                  <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group"><label>Invoice Number *</label><input type="text" name="invoice_number" class="form-control" required></div>
            <div class="row">
              <div class="col-md-6 form-group"><label>Invoice Date *</label><input type="date" name="invoice_date" class="form-control" required></div>
              <div class="col-md-6 form-group"><label>Due Date</label><input type="date" name="due_date" class="form-control"></div>
            </div>
            <div class="row">
              <div class="col-md-4 form-group"><label>Amount</label><input type="number" step="0.01" name="invoice_amount" class="form-control"></div>
              <div class="col-md-4 form-group"><label>GST Amount</label><input type="number" step="0.01" name="gst_amount" class="form-control"></div>
              <div class="col-md-4 form-group">
                <label>Payment Status *</label>
                <select name="payment_status" class="form-control" required>
                  @foreach(['Pending','Partial','Paid'] as $status)
                    <option value="{{ $status }}">{{ $status }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Add Invoice</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-3"><div class="card-header"><h4>Invoices</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Invoice No.</th><th>Date</th><th>Amount</th><th>GST</th><th>Payment Status</th></tr></thead>
        <tbody>
          @forelse($invoices as $invoice)
          <tr>
            <td>{{ $invoice->invoice_number }}</td>
            <td>{{ $invoice->invoice_date }}</td>
            <td>{{ number_format($invoice->invoice_amount ?? 0, 2) }}</td>
            <td>{{ number_format($invoice->gst_amount ?? 0, 2) }}</td>
            <td><span class="badge bg-info">{{ $invoice->payment_status }}</span></td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center text-muted">No invoices recorded.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
