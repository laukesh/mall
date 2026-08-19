<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceipt;
use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ProcurementController extends Controller
{
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

    public function storeRequisition(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'requisition_no' => 'required|string|max:30|unique:purchase_requisitions,requisition_no',
            'request_date' => 'required|date',
            'approval_status' => 'required|in:Pending,Approved,Rejected',
        ]);

        PurchaseRequisition::create(array_merge($validated, [
            'requested_by' => id() ?: 1,
            'required_date' => $request->input('required_date'),
            'priority' => $request->input('priority', 'Medium'),
            'remarks' => $request->input('remarks'),
        ]));

        return back()->with('success', 'Purchase requisition created.');
    }

    public function orders()
    {
        return view('admin.procurement.orders', [
            'orders' => PurchaseOrder::orderByDesc('order_date')->get(),
            'vendors' => Vendor::where('status', 'Active')->get(),
            'projects' => Project::orderBy('project_name')->get(),
        ]);
    }

    public function storeOrder(Request $request)
    {
        $validated = $request->validate([
            'po_number' => 'required|string|max:30|unique:purchase_orders,po_number',
            'vendor_id' => 'required|exists:vendors,id',
            'project_id' => 'required|exists:projects,id',
            'order_date' => 'required|date',
            'status' => 'required|in:Draft,Issued,Partially Received,Completed,Cancelled',
        ]);

        PurchaseOrder::create(array_merge($validated, [
            'requisition_id' => $request->input('requisition_id') ?: null,
            'expected_delivery_date' => $request->input('expected_delivery_date'),
            'total_amount' => $request->input('total_amount'),
            'payment_terms' => $request->input('payment_terms'),
            'delivery_address' => $request->input('delivery_address'),
        ]));

        return back()->with('success', 'Purchase order created.');
    }

    public function receipts()
    {
        return view('admin.procurement.receipts', [
            'receipts' => GoodsReceipt::orderByDesc('received_date')->get(),
        ]);
    }
}
