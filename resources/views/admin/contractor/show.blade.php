@extends('layouts.admin')

@section('title', 'Contractor Details')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>{{ $contractor->company_name }} <small class="text-muted">({{ $contractor->contractor_code }})</small></h1>
    <div>
      <a href="{{ route('admin.contractor.edit', $contractor->id) }}" class="btn btn-secondary">Edit</a>
      <a href="{{ route('admin.contractor.index') }}" class="btn btn-light">Back</a>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="card"><div class="card-header"><h4>Contractor Details</h4></div>
        <div class="card-body">
          <p><strong>Type:</strong> {{ $contractor->contractor_type }}</p>
          @if($parentContractor)
          <p><strong>Parent Contractor:</strong> {{ $parentContractor->company_name }} ({{ $parentContractor->contractor_code }})</p>
          @endif
          <p><strong>Contact:</strong> {{ $contractor->contact_person ?? '-' }} / {{ $contractor->mobile ?? '-' }}</p>
          <p><strong>Email:</strong> {{ $contractor->email ?? '-' }}</p>
          <p><strong>GST/PAN:</strong> {{ $contractor->gst_number ?? '-' }} / {{ $contractor->pan_number ?? '-' }}</p>
          <p><strong>Status:</strong> <span class="badge bg-{{ $contractor->status === 'Active' ? 'success' : 'secondary' }}">{{ $contractor->status }}</span></p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <x-pm-status-change
        :action="route('admin.contractor.status.update', $contractor->id)"
        :currentStatus="$contractor->status"
        :statuses="['Active','Inactive','Blacklisted']"
      />
    </div>
  </div>

  @if(($subContractors ?? collect())->isNotEmpty())
  <div class="card mt-3"><div class="card-header"><h4>Sub-Contractors</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Code</th><th>Company</th><th>Status</th></tr></thead>
        <tbody>
          @foreach($subContractors as $sub)
          <tr>
            <td><a href="{{ route('admin.contractor.show', $sub->id) }}">{{ $sub->contractor_code }}</a></td>
            <td>{{ $sub->company_name }}</td>
            <td><span class="badge bg-info">{{ $sub->status }}</span></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif

  <div class="row mt-3">
    <div class="col-md-6">
      <div class="card"><div class="card-header"><h4>Add Contract</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.contractor.contract.store') }}" method="POST">
            @csrf
            <input type="hidden" name="contractor_id" value="{{ $contractor->id }}">
            <div class="form-group">
              <label>Project *</label>
              <select name="project_id" class="form-control" required>
                <option value="">-- Select Project --</option>
                @foreach($projects as $project)
                  <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group"><label>Contract Number *</label><input type="text" name="contract_number" class="form-control" required></div>
            <div class="form-group"><label>Contract Title *</label><input type="text" name="contract_title" class="form-control" required></div>
            <div class="row">
              <div class="col-md-6 form-group">
                <label>Contract Type *</label>
                <select name="contract_type" class="form-control" required>
                  @foreach(['Labour','Material','Turnkey','EPC'] as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 form-group">
                <label>Status *</label>
                <select name="status" class="form-control" required>
                  @foreach(['Active','Expired','Closed'] as $status)
                    <option value="{{ $status }}">{{ $status }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 form-group"><label>Contract Value</label><input type="number" step="0.01" name="contract_value" class="form-control"></div>
              <div class="col-md-4 form-group"><label>Start Date</label><input type="date" name="start_date" class="form-control"></div>
              <div class="col-md-4 form-group"><label>End Date</label><input type="date" name="end_date" class="form-control"></div>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Add Contract</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-3"><div class="card-header"><h4>Contracts</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Number</th><th>Title</th><th>Type</th><th>Value</th><th>Status</th></tr></thead>
        <tbody>
          @forelse($contracts as $contract)
          <tr>
            <td>{{ $contract->contract_number }}</td>
            <td>{{ $contract->contract_title }}</td>
            <td>{{ $contract->contract_type }}</td>
            <td>{{ number_format($contract->contract_value ?? 0, 2) }}</td>
            <td><span class="badge bg-info">{{ $contract->status }}</span></td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center text-muted">No contracts recorded.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="card mt-3"><div class="card-header"><h4>Add Bill</h4></div>
    <div class="card-body">
      <form action="{{ route('admin.contractor.bill.store') }}" method="POST">
        @csrf
        <input type="hidden" name="contractor_id" value="{{ $contractor->id }}">
        <div class="row">
          <div class="col-md-3 form-group">
            <label>Project *</label>
            <select name="project_id" class="form-control" required>
              <option value="">-- Select --</option>
              @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->project_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group"><label>Bill Number *</label><input type="text" name="bill_number" class="form-control" required></div>
          <div class="col-md-3 form-group"><label>Bill Date *</label><input type="date" name="bill_date" class="form-control" required></div>
          <div class="col-md-3 form-group">
            <label>Bill Type *</label>
            <select name="bill_type" class="form-control" required>
              @foreach(['RA Bill','Final Bill','Advance Bill'] as $type)
                <option value="{{ $type }}">{{ $type }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group"><label>Gross Amount</label><input type="number" step="0.01" name="gross_amount" class="form-control"></div>
          <div class="col-md-3 form-group"><label>Bill Amount</label><input type="number" step="0.01" name="bill_amount" class="form-control"></div>
          <div class="col-md-3 form-group"><label>Net Payable</label><input type="number" step="0.01" name="net_payable" class="form-control"></div>
          <div class="col-md-3 form-group">
            <label>Status *</label>
            <select name="status" class="form-control" required>
              @foreach(['Submitted','Verified','Approved','Paid','Rejected'] as $status)
                <option value="{{ $status }}">{{ $status }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Add Bill</button>
      </form>
    </div>
  </div>

  <div class="card mt-3"><div class="card-header"><h4>Bills</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Bill No.</th><th>Date</th><th>Type</th><th>Amount</th><th>Status</th><th>Change Status</th></tr></thead>
        <tbody>
          @forelse($bills as $bill)
          <tr>
            <td>{{ $bill->bill_number }}</td>
            <td>{{ $bill->bill_date }}</td>
            <td>{{ $bill->bill_type }}</td>
            <td>{{ number_format($bill->bill_amount ?? $bill->gross_amount ?? 0, 2) }}</td>
            <td><span class="badge bg-info">{{ $bill->status }}</span></td>
            <td>
              <form action="{{ route('admin.contractor.bill.status.update', $bill->id) }}" method="POST" class="d-flex gap-1">
                @csrf
                <select name="status" class="form-control form-control-sm">
                  @foreach(['Submitted','Verified','Approved','Paid','Rejected'] as $status)
                    <option value="{{ $status }}" @selected($bill->status == $status)>{{ $status }}</option>
                  @endforeach
                </select>
                <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center text-muted">No bills recorded.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <x-pm-status-history-table :histories="$statusHistories ?? collect()" />
</section>
@endsection
