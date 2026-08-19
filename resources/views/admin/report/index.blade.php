@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
<section class="section">
  <div class="section-header"><h1>Reports & KPIs</h1></div>

  <div class="row">
    <div class="col-md-5">
      <div class="card"><div class="card-header"><h4>Generate Report</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.report.generate') }}" method="POST">
            @csrf
            <div class="form-group">
              <label>Report *</label>
              <select name="report_id" class="form-control" required>
                <option value="">-- Select Report --</option>
                @foreach($definitions as $definition)
                  <option value="{{ $definition->id }}">{{ $definition->module_name }} - {{ $definition->report_name ?? $definition->name ?? 'Report' }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>File Format *</label>
              <select name="file_format" class="form-control" required>
                @foreach(['PDF','Excel','CSV'] as $format)
                  <option value="{{ $format }}">{{ $format }}</option>
                @endforeach
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Generate Report</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="card"><div class="card-header"><h4>KPI Metrics</h4></div>
        <div class="card-body p-0">
          <table class="table mb-0">
            <thead><tr><th>Module</th><th>Metric</th><th>Value</th><th>Period</th></tr></thead>
            <tbody>
              @forelse($kpis as $kpi)
              <tr>
                <td>{{ $kpi->module_name }}</td>
                <td>{{ $kpi->metric_name ?? $kpi->kpi_name ?? '-' }}</td>
                <td>{{ $kpi->metric_value ?? $kpi->value ?? '-' }}</td>
                <td>{{ $kpi->period ?? '-' }}</td>
              </tr>
              @empty
              <tr><td colspan="4" class="text-center text-muted">No KPI metrics available.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-3"><div class="card-header"><h4>Recently Generated Reports</h4></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead><tr><th>Report</th><th>Format</th><th>Generated At</th><th>Status</th></tr></thead>
        <tbody>
          @forelse($generated as $report)
          <tr>
            <td>{{ $report->report_id }}</td>
            <td>{{ $report->file_format }}</td>
            <td>{{ $report->generated_at }}</td>
            <td><span class="badge bg-info">{{ $report->status }}</span></td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted">No reports generated yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
