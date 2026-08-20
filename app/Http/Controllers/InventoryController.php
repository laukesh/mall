<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\MaterialIssue;
use App\Models\MaterialIssueRequest;
use App\Models\PmStatusHistory;
use App\Models\Project;
use App\Models\Warehouse;
use App\Models\WarehouseStock;
use App\Services\PmStatusHistoryService;
use App\Traits\TracksPmHistory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InventoryController extends Controller
{
    use TracksPmHistory;

    private const ISSUE_REQUEST_STATUSES = ['Pending', 'Approved', 'Rejected'];

    public function materials()
    {
        return view('admin.inventory.materials', [
            'materials' => Material::orderBy('material_name')->get(),
            'categories' => MaterialCategory::orderBy('category_name')->get(),
        ]);
    }

    public function storeMaterial(Request $request)
    {
        $validated = $request->validate([
            'material_code' => 'required|string|max:30|unique:materials,material_code',
            'category_id' => 'required|exists:material_categories,id',
            'material_name' => 'required|string|max:200',
            'unit' => 'required|string|max:20',
            'status' => 'required|in:Active,Inactive',
        ]);

        Material::create(array_merge($validated, [
            'specification' => $request->input('specification'),
            'minimum_stock' => $request->input('minimum_stock'),
            'maximum_stock' => $request->input('maximum_stock'),
        ]));

        return back()->with('success', 'Material created.');
    }

    public function warehouses()
    {
        return view('admin.inventory.warehouses', [
            'warehouses' => Warehouse::orderBy('warehouse_name')->get(),
        ]);
    }

    public function storeWarehouse(Request $request)
    {
        $validated = $request->validate([
            'warehouse_code' => 'required|string|max:20|unique:warehouses,warehouse_code',
            'warehouse_name' => 'required|string|max:150',
            'warehouse_type' => 'required|in:Central Store,Site Store',
            'status' => 'required|in:Active,Inactive',
        ]);

        Warehouse::create(array_merge($validated, [
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'incharge_user_id' => $request->input('incharge_user_id') ?: null,
        ]));

        return back()->with('success', 'Warehouse created.');
    }

    public function stock()
    {
        $stock = WarehouseStock::with(['warehouse', 'material'])
            ->orderByDesc('last_updated')
            ->get();

        return view('admin.inventory.stock', [
            'stock' => $stock,
            'warehouses' => Warehouse::where('status', 'Active')->get(),
            'materials' => Material::where('status', 'Active')->get(),
            'existingStock' => $stock->groupBy('warehouse_id')
                ->map(fn ($rows) => $rows->pluck('material_id')->values()),
        ]);
    }

    public function storeStock(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'material_id' => [
                'required',
                'exists:materials,id',
                Rule::unique('warehouse_stock')->where(fn ($query) => $query->where('warehouse_id', $request->input('warehouse_id'))),
            ],
            'available_quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:20',
        ]);

        WarehouseStock::create(array_merge($validated, [
            'reserved_quantity' => $request->input('reserved_quantity', 0),
            'damaged_quantity' => $request->input('damaged_quantity', 0),
            'last_updated' => now(),
        ]));

        return back()->with('success', 'Stock entry added.');
    }

    public function issueRequests()
    {
        return view('admin.inventory.issue-requests', [
            'requests' => MaterialIssueRequest::orderByDesc('request_date')->get(),
            'projects' => Project::orderBy('project_name')->get(),
        ]);
    }

    public function showIssueRequest($id)
    {
        $issueRequest = MaterialIssueRequest::find($id);
        if (! $issueRequest) {
            return redirect()->route('admin.inventory.issue-requests')->with('error', 'Issue request not found.');
        }

        return view('admin.inventory.issue_request_show', [
            'issueRequest' => $issueRequest,
            'statusHistories' => PmStatusHistoryService::historiesFor(PmStatusHistory::ENTITY_MATERIAL_ISSUE_REQUEST, (int) $id),
        ]);
    }

    public function storeIssueRequest(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'request_number' => 'required|string|max:30|unique:material_issue_requests,request_number',
            'request_date' => 'required|date',
            'approval_status' => 'required|in:' . implode(',', self::ISSUE_REQUEST_STATUSES),
        ]);

        $issueRequest = MaterialIssueRequest::create(array_merge($validated, [
            'requested_by' => id() ?: 1,
            'work_package_id' => $request->input('work_package_id') ?: null,
            'required_date' => $request->input('required_date'),
            'priority' => $request->input('priority', 'Medium'),
            'remarks' => $request->input('remarks'),
        ]));

        $this->pmLogStatus(PmStatusHistory::ENTITY_MATERIAL_ISSUE_REQUEST, $issueRequest->id, null, $issueRequest->approval_status, 'approval_status', 'Issue request created');

        return redirect()->route('admin.inventory.issue-request.show', $issueRequest->id)->with('success', 'Material issue request created.');
    }

    public function updateIssueRequestStatus(Request $request, $id)
    {
        $issueRequest = MaterialIssueRequest::find($id);
        if (! $issueRequest) {
            return back()->with('error', 'Issue request not found.');
        }

        return $this->pmUpdateStatus($request, $issueRequest, PmStatusHistory::ENTITY_MATERIAL_ISSUE_REQUEST, 'approval_status', self::ISSUE_REQUEST_STATUSES, 'approval_status');
    }

    public function updateIssueRequestProgress(Request $request, $id)
    {
        $issueRequest = MaterialIssueRequest::find($id);
        if (! $issueRequest) {
            return back()->with('error', 'Issue request not found.');
        }

        return $this->pmUpdateProgress($request, $issueRequest, PmStatusHistory::ENTITY_MATERIAL_ISSUE_REQUEST);
    }

    public function issues()
    {
        return view('admin.inventory.issues', [
            'issues' => MaterialIssue::orderByDesc('issue_date')->get(),
            'issueRequests' => MaterialIssueRequest::orderByDesc('request_date')->get(),
            'warehouses' => Warehouse::where('status', 'Active')->get(),
            'contractors' => Contractor::where('status', 'Active')->get(),
        ]);
    }

    public function storeIssue(Request $request)
    {
        $validated = $request->validate([
            'issue_request_id' => 'required|exists:material_issue_requests,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'issue_number' => 'required|string|max:30|unique:material_issues,issue_number',
            'issue_date' => 'required|date',
        ]);

        MaterialIssue::create(array_merge($validated, [
            'issued_by' => id() ?: 1,
            'received_by' => $request->input('received_by') ?: null,
            'contractor_id' => $request->input('contractor_id') ?: null,
            'remarks' => $request->input('remarks'),
        ]));

        return back()->with('success', 'Material issue recorded.');
    }
}
