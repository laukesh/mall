<?php

namespace App\Http\Controllers;

use App\Models\Boq;
use App\Models\Consultant;
use App\Models\DesignPackage;
use App\Models\Drawing;
use App\Models\Project;
use App\Models\Rfi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DesignController extends Controller
{
    public function index()
    {
        $data = [
            'packages' => DesignPackage::with('project')->orderByDesc('id')->get(),
            'drawings' => Drawing::with('designPackage')->orderByDesc('id')->get(),
            'boqItems' => Boq::with('project')->orderByDesc('id')->get(),
            'rfis' => Rfi::with('project')->orderByDesc('id')->get(),
        ];

        return view('admin.design.index', $data);
    }

    public function packages()
    {
        $data = [
            'packages' => DesignPackage::with('project')->orderByDesc('id')->get(),
        ];

        return view('admin.design.packages', $data);
    }

    public function createPackage()
    {
        $data = [
            'projects' => Project::orderBy('project_name')->get(),
            'consultants' => Consultant::getAllData(),
        ];

        return view('admin.design.create', $data);
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
            DB::transaction(function () use ($validated, $request) {
                DesignPackage::create(array_merge($validated, [
                    'description' => $request->input('description'),
                    'status' => $request->input('status', 'Draft'),
                    'created_by' => id() ?: 1,
                ]));
            });

            return redirect()->route('admin.design.packages.index')->with('success', 'Design package created successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error creating design package.');
        }
    }

    public function drawings()
    {
        $data = [
            'drawings' => Drawing::with('designPackage')->orderByDesc('id')->get(),
            'packages' => DesignPackage::with('project')->orderByDesc('id')->get(),
        ];

        return view('admin.design.drawings', $data);
    }

    public function createDrawing()
    {
        $data = [
            'packages' => DesignPackage::with('project')->orderByDesc('id')->get(),
        ];

        return view('admin.design.create_drawing', $data);
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

            return redirect()->route('admin.design.drawings.show', $drawing->id)->with('success', 'Drawing created successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error creating drawing.');
        }
    }

    public function showDrawing($id)
    {
        $drawing = Drawing::with('designPackage.project')->find($id);
        if (!$drawing) {
            return redirect()->route('admin.design.drawings.index')->with('error', 'Drawing not found.');
        }

        $data = [
            'drawing' => $drawing,
        ];

        return view('admin.design.show', $data);
    }

    public function boqIndex()
    {
        $data = [
            'boqItems' => Boq::with('project')->orderByDesc('id')->get(),
            'projects' => Project::orderBy('project_name')->get(),
            'drawings' => Drawing::orderByDesc('id')->get(),
        ];

        return view('admin.design.boq', $data);
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
        $data = [
            'rfis' => Rfi::with('project')->orderByDesc('id')->get(),
            'projects' => Project::orderBy('project_name')->get(),
            'drawings' => Drawing::orderByDesc('id')->get(),
            'users' => User::getAll(),
        ];

        return view('admin.design.rfis', $data);
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
            Rfi::create(array_merge($validated, [
                'drawing_id' => $request->input('drawing_id') ?: null,
                'raised_by' => id() ?: 1,
                'status' => 'Open',
            ]));

            return redirect()->route('admin.design.rfi.index')->with('success', 'RFI created successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error creating RFI.');
        }
    }
}
