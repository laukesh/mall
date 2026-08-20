<?php

namespace App\Http\Controllers;

use App\Models\Boq;
use App\Models\Consultant;
use App\Models\DesignPackage;
use App\Models\Drawing;
use App\Models\PmStatusHistory;
use App\Models\Project;
use App\Models\Rfi;
use App\Models\User;
use App\Services\PmStatusHistoryService;
use App\Traits\TracksPmHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DesignController extends Controller
{
    use TracksPmHistory;

    private const PACKAGE_STATUSES = ['Draft', 'In Review', 'Approved', 'Issued', 'Completed'];
    private const DRAWING_STATUSES = ['Draft', 'Under Review', 'Approved', 'Issued', 'Superseded'];

    public function index()
    {
        return view('admin.design.index', [
            'packages' => DesignPackage::with('project')->orderByDesc('id')->get(),
            'drawings' => Drawing::with('designPackage')->orderByDesc('id')->get(),
            'boqItems' => Boq::with('project')->orderByDesc('id')->get(),
            'rfis' => Rfi::with('project')->orderByDesc('id')->get(),
        ]);
    }

    public function packages()
    {
        return view('admin.design.packages', [
            'packages' => DesignPackage::with('project')->orderByDesc('id')->get(),
        ]);
    }

    public function createPackage()
    {
        return view('admin.design.create', [
            'projects' => Project::orderBy('project_name')->get(),
            'consultants' => Consultant::getAllData(),
        ]);
    }

    public function storePackage(Request $request)
    {
        $validated = $request->validate([
            'package_code' => 'required|string|max:30|unique:design_packages,package_code',
            'project_id' => 'required|exists:projects,id',
            'package_name' => 'required|string|max:200',
            'package_type' => 'required|in:Architectural,Structural,MEP,Landscape,Interior,Infrastructure',
            'consultant_id' => 'required|exists:consultants,id',
            'start_date' => 'required|date',
            'target_date' => 'required|date|after_or_equal:start_date',
        ]);

        try {
            $package = DB::transaction(function () use ($validated, $request) {
                $package = DesignPackage::create(array_merge($validated, [
                    'description' => $request->input('description'),
                    'status' => $request->input('status', 'Draft'),
                    'created_by' => id() ?: 1,
                ]));

                $this->pmLogStatus(PmStatusHistory::ENTITY_DESIGN_PACKAGE, $package->id, null, $package->status, 'status', 'Design package created');

                return $package;
            });

            return redirect()->route('admin.design.packages.show', $package->id)->with('success', 'Design package created successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error creating design package.');
        }
    }

    public function showPackage($id)
    {
        $package = DesignPackage::with(['project', 'consultant'])->find($id);
        if (! $package) {
            return redirect()->route('admin.design.packages.index')->with('error', 'Design package not found.');
        }

        return view('admin.design.package_show', [
            'package' => $package,
            'drawings' => Drawing::where('design_package_id', $id)->orderByDesc('id')->get(),
            'statusHistories' => PmStatusHistoryService::historiesFor(PmStatusHistory::ENTITY_DESIGN_PACKAGE, (int) $id),
        ]);
    }

    public function updatePackageStatus(Request $request, $id)
    {
        $package = DesignPackage::find($id);
        if (! $package) {
            return back()->with('error', 'Design package not found.');
        }

        return $this->pmUpdateStatus($request, $package, PmStatusHistory::ENTITY_DESIGN_PACKAGE, 'status', self::PACKAGE_STATUSES);
    }

    public function updatePackageProgress(Request $request, $id)
    {
        $package = DesignPackage::find($id);
        if (! $package) {
            return back()->with('error', 'Design package not found.');
        }

        return $this->pmUpdateProgress($request, $package, PmStatusHistory::ENTITY_DESIGN_PACKAGE);
    }

    public function drawings()
    {
        return view('admin.design.drawings', [
            'drawings' => Drawing::with('designPackage')->orderByDesc('id')->get(),
            'packages' => DesignPackage::with('project')->orderByDesc('id')->get(),
        ]);
    }

    public function createDrawing()
    {
        return view('admin.design.create_drawing', [
            'packages' => DesignPackage::with('project')->orderByDesc('id')->get(),
        ]);
    }

    public function storeDrawing(Request $request)
    {
        $validated = $request->validate([
            'design_package_id' => 'required|exists:design_packages,id',
            'drawing_number' => 'required|string|max:100',
            'drawing_title' => 'required|string|max:255',
            'drawing_type' => 'required|in:Concept,Tender,Construction,Shop,As-Built',
            'discipline' => 'required|in:Architectural,Structural,Electrical,Plumbing,HVAC,Fire Fighting,ELV',
        ]);

        try {
            $drawing = Drawing::create(array_merge($validated, [
                'current_revision' => $request->input('current_revision', 'R0'),
                'drawing_status' => $request->input('drawing_status', 'Draft'),
                'uploaded_by' => id() ?: 1,
                'upload_date' => now(),
            ]));

            $this->pmLogStatus(PmStatusHistory::ENTITY_DRAWING, $drawing->id, null, $drawing->drawing_status, 'drawing_status', 'Drawing created');

            return redirect()->route('admin.design.drawings.show', $drawing->id)->with('success', 'Drawing created successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error creating drawing.');
        }
    }

    public function showDrawing($id)
    {
        $drawing = Drawing::with('designPackage.project')->find($id);
        if (! $drawing) {
            return redirect()->route('admin.design.drawings.index')->with('error', 'Drawing not found.');
        }

        return view('admin.design.show', [
            'drawing' => $drawing,
            'statusHistories' => PmStatusHistoryService::historiesFor(PmStatusHistory::ENTITY_DRAWING, (int) $id),
        ]);
    }

    public function updateDrawingStatus(Request $request, $id)
    {
        $drawing = Drawing::find($id);
        if (! $drawing) {
            return back()->with('error', 'Drawing not found.');
        }

        return $this->pmUpdateStatus($request, $drawing, PmStatusHistory::ENTITY_DRAWING, 'drawing_status', self::DRAWING_STATUSES, 'drawing_status');
    }

    public function updateDrawingProgress(Request $request, $id)
    {
        $drawing = Drawing::find($id);
        if (! $drawing) {
            return back()->with('error', 'Drawing not found.');
        }

        return $this->pmUpdateProgress($request, $drawing, PmStatusHistory::ENTITY_DRAWING);
    }

    public function boqIndex()
    {
        return view('admin.design.boq', [
            'boqItems' => Boq::with('project')->orderByDesc('id')->get(),
            'projects' => Project::orderBy('project_name')->get(),
            'drawings' => Drawing::orderByDesc('id')->get(),
        ]);
    }

    public function storeBoq(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'boq_number' => 'required|string|max:50',
            'item_code' => 'required|string|max:50',
            'item_description' => 'required|string',
            'unit' => 'required|string|max:20',
            'quantity' => 'required|numeric|min:0',
            'estimated_rate' => 'required|numeric|min:0',
        ]);

        try {
            Boq::create(array_merge($validated, [
                'drawing_id' => $request->input('drawing_id') ?: null,
                'estimated_amount' => $validated['quantity'] * $validated['estimated_rate'],
            ]));

            return redirect()->route('admin.design.boq.index')->with('success', 'BOQ item added successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error adding BOQ item.');
        }
    }

    public function rfiIndex()
    {
        return view('admin.design.rfis', [
            'rfis' => Rfi::with('project')->orderByDesc('id')->get(),
            'projects' => Project::orderBy('project_name')->get(),
            'drawings' => Drawing::orderByDesc('id')->get(),
            'users' => User::getAll(),
        ]);
    }

    public function storeRfi(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'priority' => 'required|in:Low,Medium,High,Critical',
        ]);

        try {
            $rfi = Rfi::create(array_merge($validated, [
                'drawing_id' => $request->input('drawing_id') ?: null,
                'raised_by' => id() ?: 1,
                'status' => 'Open',
            ]));

            $this->pmLogStatus(PmStatusHistory::ENTITY_RFI, $rfi->id, null, $rfi->status, 'status', 'RFI created');

            return redirect()->route('admin.design.rfi.index')->with('success', 'RFI created successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error creating RFI.');
        }
    }
}
