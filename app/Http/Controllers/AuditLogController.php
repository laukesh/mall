<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index()
    {
        return view('admin.audit.index', [
            'logs' => AuditLog::orderByDesc('created_at')->limit(200)->get(),
        ]);
    }

    public function show($id)
    {
        $log = AuditLog::getDataById($id);
        if (!$log) {
            return redirect()->route('admin.audit.index')->with('error', 'Log entry not found.');
        }

        return view('admin.audit.show', ['log' => $log]);
    }
}
