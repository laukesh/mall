<?php

namespace App\Http\Controllers;

use App\Models\PmStatusHistory;
use App\Services\PmStatusHistoryService;
use Illuminate\Http\Request;

class PmStatusHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = PmStatusHistory::query()
            ->with(['changedBy.roles', 'changedBy.role'])
            ->orderByDesc('changed_at');

        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->input('entity_type'));
        }

        if ($request->filled('entity_id')) {
            $query->where('entity_id', $request->input('entity_id'));
        }

        return view('admin.pm.status-history', [
            'histories' => $query->paginate(50)->withQueryString(),
            'entityTypes' => PmStatusHistory::entityTypeLabels(),
        ]);
    }
}
