<?php

namespace App\Http\Controllers;

use App\Models\GeneratedReport;
use App\Models\KpiMetric;
use App\Models\ReportDefinition;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.report.index', [
            'definitions' => ReportDefinition::where('is_active', 1)->orderBy('module_name')->get(),
            'generated' => GeneratedReport::orderByDesc('generated_at')->limit(20)->get(),
            'kpis' => KpiMetric::orderBy('module_name')->get(),
        ]);
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'report_id' => 'required|exists:report_definitions,id',
            'file_format' => 'required|in:PDF,Excel,CSV',
        ]);

        GeneratedReport::create([
            'report_id' => $validated['report_id'],
            'generated_by' => id() ?: 1,
            'generated_at' => now(),
            'file_path' => 'reports/' . uniqid('report_') . '.' . strtolower($validated['file_format']),
            'file_format' => $validated['file_format'],
            'status' => 'Generated',
        ]);

        return back()->with('success', 'Report generated successfully.');
    }
}
