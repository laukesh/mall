<?php

namespace App\Http\Controllers;

use App\Models\Land;
use App\Models\LandDocument;
use App\Models\LandHistory;
use App\Models\LandOwner;
use App\Models\LandPayment;
use App\Models\LandSurvey;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandAcquisitionController extends Controller
{
    public function index()
    {
        $data = [
            'lands' => Land::getAllData(),
        ];

        return view('admin.land.index', $data);
    }

    public function create()
    {
        $data = [
            'projects' => Project::getAllData(),
        ];

        return view('admin.land.create', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'land_code' => 'required|string|max:30|unique:lands,land_code',
            'land_name' => 'required|string|max:200',
            'survey_number' => 'required|string|max:100',
            'village' => 'required|string|max:150',
            'taluka' => 'required|string|max:150',
            'district' => 'required|string|max:150',
            'state' => 'required|string|max:100',
            'total_area' => 'required|numeric',
            'area_unit' => 'required|in:Sq Ft,Sq Mt,Acre,Hectare',
            'acquisition_status' => 'required|in:Identified,Negotiation,Approved,Registered,Completed',
        ]);

        try {
            DB::transaction(function () use ($validated, $request) {
                $land = Land::create(array_merge($validated, [
                    'project_id' => $request->input('project_id') ?: null,
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'remarks' => $request->input('remarks'),
                ]));

                LandHistory::create([
                    'land_id' => $land->id,
                    'event_type' => 'Created',
                    'event_date' => now(),
                    'performed_by' => id() ?: 1,
                    'description' => 'Land record created',
                ]);
            });

            return redirect()->route('admin.land.index')->with('success', 'Land record created successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error creating land record.');
        }
    }

    public function show($id)
    {
        $land = Land::getDataById($id);
        if (!$land) {
            return redirect()->route('admin.land.index')->with('error', 'Land record not found.');
        }

        $data = [
            'land' => $land,
            'owners' => LandOwner::where('land_id', $id)->get(),
            'surveys' => LandSurvey::where('land_id', $id)->get(),
            'documents' => LandDocument::where('land_id', $id)->get(),
            'payments' => LandPayment::where('land_id', $id)->get(),
            'history' => LandHistory::where('land_id', $id)->orderByDesc('event_date')->get(),
        ];

        return view('admin.land.show', $data);
    }

    public function edit($id)
    {
        $land = Land::getDataById($id);
        if (!$land) {
            return redirect()->route('admin.land.index')->with('error', 'Land record not found.');
        }

        $data = [
            'land' => $land,
            'projects' => Project::getAllData(),
        ];

        return view('admin.land.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $land = Land::getDataById($id);
        if (!$land) {
            return redirect()->route('admin.land.index')->with('error', 'Land record not found.');
        }

        $validated = $request->validate([
            'land_code' => 'required|string|max:30|unique:lands,land_code,' . $id,
            'land_name' => 'required|string|max:200',
            'survey_number' => 'required|string|max:100',
            'village' => 'required|string|max:150',
            'taluka' => 'required|string|max:150',
            'district' => 'required|string|max:150',
            'state' => 'required|string|max:100',
            'total_area' => 'required|numeric',
            'area_unit' => 'required|in:Sq Ft,Sq Mt,Acre,Hectare',
            'acquisition_status' => 'required|in:Identified,Negotiation,Approved,Registered,Completed',
        ]);

        try {
            DB::transaction(function () use ($land, $validated, $request) {
                $land->update(array_merge($validated, [
                    'project_id' => $request->input('project_id') ?: null,
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'remarks' => $request->input('remarks'),
                ]));
            });

            return redirect()->route('admin.land.show', $id)->with('success', 'Land record updated successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error updating land record.');
        }
    }

    public function destroy($id)
    {
        try {
            $land = Land::getDataById($id);
            if ($land) {
                $land->delete();
            }

            return redirect()->route('admin.land.index')->with('success', 'Land record deleted successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error deleting land record.', false);
        }
    }

    public function storeOwner(Request $request)
    {
        $validated = $request->validate([
            'land_id' => 'required|exists:lands,id',
            'owner_name' => 'required|string|max:200',
            'mobile' => 'required|string|max:20',
            'ownership_percentage' => 'required|numeric|min:0|max:100',
        ]);

        try {
            LandOwner::create(array_merge($validated, [
                'father_name' => $request->input('father_name'),
                'email' => $request->input('email'),
                'aadhaar_number' => $request->input('aadhaar_number'),
                'pan_number' => $request->input('pan_number'),
                'address' => $request->input('address'),
                'is_primary_owner' => $request->boolean('is_primary_owner'),
            ]));

            return redirect()->route('admin.land.show', $validated['land_id'])->with('success', 'Owner added successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error adding owner.', false);
        }
    }

    public function storeSurvey(Request $request)
    {
        $validated = $request->validate([
            'land_id' => 'required|exists:lands,id',
            'survey_date' => 'required|date',
            'survey_agency' => 'required|string|max:200',
            'surveyor_name' => 'required|string|max:150',
            'measured_area' => 'required|numeric',
            'area_unit' => 'required|string|max:20',
        ]);

        try {
            LandSurvey::create(array_merge($validated, [
                'boundary_description' => $request->input('boundary_description'),
                'remarks' => $request->input('remarks'),
            ]));

            LandHistory::create([
                'land_id' => $validated['land_id'],
                'event_type' => 'Survey',
                'event_date' => now(),
                'performed_by' => id() ?: 1,
                'description' => 'Survey record added',
            ]);

            return redirect()->route('admin.land.show', $validated['land_id'])->with('success', 'Survey added successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error adding survey.', false);
        }
    }

    public function storeDocument(Request $request)
    {
        $validated = $request->validate([
            'land_id' => 'required|exists:lands,id',
            'document_type' => 'required|string',
            'document_number' => 'required|string|max:100',
            'issue_date' => 'required|date',
        ]);

        try {
            $filePath = '';
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('land/documents', 'public');
            }

            LandDocument::create(array_merge($validated, [
                'expiry_date' => $request->input('expiry_date'),
                'uploaded_by' => id() ?: 1,
                'file_path' => $filePath,
                'status' => 'Pending',
            ]));

            return redirect()->route('admin.land.show', $validated['land_id'])->with('success', 'Document uploaded successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error uploading document.', false);
        }
    }

    public function storePayment(Request $request)
    {
        $validated = $request->validate([
            'land_id' => 'required|exists:lands,id',
            'owner_id' => 'required|exists:land_owners,id',
            'payment_date' => 'required|date',
            'payment_mode' => 'required|in:Cheque,NEFT,RTGS,Cash',
            'amount' => 'required|numeric|min:0',
        ]);

        try {
            LandPayment::create(array_merge($validated, [
                'payment_reference' => $request->input('payment_reference'),
                'payment_status' => $request->input('payment_status', 'Pending'),
                'remarks' => $request->input('remarks'),
            ]));

            LandHistory::create([
                'land_id' => $validated['land_id'],
                'event_type' => 'Payment',
                'event_date' => now(),
                'performed_by' => id() ?: 1,
                'description' => 'Payment record added',
            ]);

            return redirect()->route('admin.land.show', $validated['land_id'])->with('success', 'Payment added successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error adding payment.', false);
        }
    }
}
