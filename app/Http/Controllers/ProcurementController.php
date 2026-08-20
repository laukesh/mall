<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceipt;
use App\Models\PmStatusHistory;
use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use App\Models\Vendor;
use App\Services\PmStatusHistoryService;
use App\Traits\TracksPmHistory;
use Illuminate\Http\Request;

class ProcurementController extends Controller
{
    use TracksPmHistory;

    private const REQUISITION_STATUSES = ['Pending', 'Approved', 'Rejected'];
    private const ORDER_STATUSES = ['Draft', 'Issued', 'Partially Received', 'Completed', 'Cancelled'];

    public function vendors()
    {
        return view('admin.procurement.vendors', [
            'vendors' => Vendor::orderBy('vendor_name')->get(),
        ]);
    }

    public function createVendor()
    {
        return view('admin.procurement.vendor_create');
    }

    public function storeVendor(Request $request)
    {
        $validated = $request->validate([
            'vendor_code' => 'required|string|max:30|unique:vendors,vendor_code',
            'vendor_name' => 'required|string|max:200',
            'status' => 'required|in:Active,Inactive,Blacklisted',
        ]);

        Vendor::create(array_merge($validated, [
            'contact_person' => $request->input('contact_person'),
            'mobile' => $request->input('mobile'),
            'email' => $request->input('email'),
            'gst_number' => $request->input('gst_number'),
            'pan_number' => $request->input('pan_number'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'pincode' => $request->input('pincode'),
            'vendor_category' => $request->input('vendor_category'),
        ]));

        return redirect()->route('admin.procurement.vendors')->with('success', 'Vendor created.');
    }

    public function requisitions()
    {
        return view('admin.procurement.requisitions', [
            'requisitions' => PurchaseRequisition::orderByDesc('request_date')->get(),
            'projects' => Project::orderBy('project_name')->get(),
        ]);
    }

    public function showRequisition($id)
    {
        $requisition = PurchaseRequisition::find($id);
        if (! $requisition) {
            return redirect()->route('admin.procurement.requisitions')->with('error', 'Requisition not found.');
        }

        return view('admin.procurement.requisition_show', [
            'requisition' => $requisition,
            'statusHistories' => PmStatusHistoryService::historiesFor(PmStatusHistory::ENTITY_PURCHASE_REQUISITION, (int) $id),
        ]);
    }

    public function storeRequisition(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'requisition_no' => 'required|string|max:30|unique:purchase_requisitions,requisition_no',
            'request_date' => 'required|date',
            'approval_status' => 'required|in:' . implode(',', self::REQUISITION_STATUSES),
        ]);

        $requisition = PurchaseRequisition::create(array_merge($validated, [
            'requested_by' => id() ?: 1,
            'required_date' => $request->input('required_date'),
            'priority' => $request->input('priority', 'Medium'),
            'remarks' => $request->input('remarks'),
        ]));

        $this->pmLogStatus(PmStatusHistory::ENTITY_PURCHASE_REQUISITION, $requisition->id, null, $requisition->approval_status, 'approval_status', 'Requisition created');

        return redirect()->route('admin.procurement.requisition.show', $requisition->id)->with('success', 'Purchase requisition created.');
    }

    public function updateRequisitionStatus(Request $request, $id)
    {
        $requisition = PurchaseRequisition::find($id);
        if (! $requisition) {
            return back()->with('error', 'Requisition not found.');
        }

        return $this->pmUpdateStatus($request, $requisition, PmStatusHistory::ENTITY_PURCHASE_REQUISITION, 'approval_status', self::REQUISITION_STATUSES, 'approval_status');
    }

    public function updateRequisitionProgress(Request $request, $id)
    {
        $requisition = PurchaseRequisition::find($id);
        if (! $requisition) {
            return back()->with('error', 'Requisition not found.');
        }

        return $this->pmUpdateProgress($request, $requisition, PmStatusHistory::ENTITY_PURCHASE_REQUISITION);
    }

    public function orders()
    {
        return view('admin.procurement.orders', [
            'orders' => PurchaseOrder::orderByDesc('order_date')->get(),
            'vendors' => Vendor::where('status', 'Active')->get(),
            'projects' => Project::orderBy('project_name')->get(),
        ]);
    }

    public function showOrder($id)
    {
        $order = PurchaseOrder::find($id);
        if (! $order) {
            return redirect()->route('admin.procurement.orders')->with('error', 'Purchase order not found.');
        }

        return view('admin.procurement.order_show', [
            'order' => $order,
            'statusHistories' => PmStatusHistoryService::historiesFor(PmStatusHistory::ENTITY_PURCHASE_ORDER, (int) $id),
        ]);
    }

    public function storeOrder(Request $request)
    {
        $validated = $request->validate([
            'po_number' => 'required|string|max:30|unique:purchase_orders,po_number',
            'vendor_id' => 'required|exists:vendors,id',
            'project_id' => 'required|exists:projects,id',
            'order_date' => 'required|date',
            'status' => 'required|in:' . implode(',', self::ORDER_STATUSES),
        ]);

        $order = PurchaseOrder::create(array_merge($validated, [
            'requisition_id' => $request->input('requisition_id') ?: null,
            'expected_delivery_date' => $request->input('expected_delivery_date'),
            'total_amount' => $request->input('total_amount'),
            'payment_terms' => $request->input('payment_terms'),
            'delivery_address' => $request->input('delivery_address'),
        ]));

        $this->pmLogStatus(PmStatusHistory::ENTITY_PURCHASE_ORDER, $order->id, null, $order->status, 'status', 'Purchase order created');

        return redirect()->route('admin.procurement.order.show', $order->id)->with('success', 'Purchase order created.');
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = PurchaseOrder::find($id);
        if (! $order) {
            return back()->with('error', 'Purchase order not found.');
        }

        return $this->pmUpdateStatus($request, $order, PmStatusHistory::ENTITY_PURCHASE_ORDER, 'status', self::ORDER_STATUSES);
    }

    public function updateOrderProgress(Request $request, $id)
    {
        $order = PurchaseOrder::find($id);
        if (! $order) {
            return back()->with('error', 'Purchase order not found.');
        }

        return $this->pmUpdateProgress($request, $order, PmStatusHistory::ENTITY_PURCHASE_ORDER);
    }

    public function receipts()
    {
        return view('admin.procurement.receipts', [
            'receipts' => GoodsReceipt::orderByDesc('received_date')->get(),
        ]);
    }
}
