<?php

namespace App\Http\Controllers;

use App\Models\Land;
use App\Models\LandDocument;
use App\Models\LandHistory;
use App\Models\LandOwner;
use App\Models\LandPayment;
use App\Models\LandSurvey;
use App\Models\PmStatusHistory;
use App\Services\PmStatusHistoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandAcquisitionController extends Controller
{
    public function handleException(\Throwable $exception)
    {
        // Log the exception
        \Log::error('LandAcquisitionController Error: ' . $exception->getMessage());

        // Return an API or web response
        if (request()->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }

        return redirect()->back()->with('error', $exception->getMessage());
    }
    
    public function index()
    {
        $data = [
            'lands' => Land::getAllData(),
        ];

        return view('admin.land.index', $data);
    }

    public function create()
    {
        return view('admin.land.create');
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
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'remarks' => $request->input('remarks'),
                ]));

                LandHistory::create([
                    'land_id' => $land->id,
                    'event_type' => 'Created',
                    'event_date' => now(),
                    'performed_by' => user_id(),
                    'description' => 'Land record created',
                ]);

                PmStatusHistoryService::log(
                    PmStatusHistory::ENTITY_LAND,
                    $land->id,
                    null,
                    $land->acquisition_status,
                    'acquisition_status',
                    'Land record created'
                );
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
            'history' => LandHistory::with(['performer.roles', 'performer.role'])
                ->where('land_id', $id)
                ->orderByDesc('event_date')
                ->get(),
            'statusHistories' => PmStatusHistoryService::historiesFor(PmStatusHistory::ENTITY_LAND, (int) $id),
        ];

        return view('admin.land.show', $data);
    }

    public function edit($id)
    {
        $land = Land::getDataById($id);
        if (!$land) {
            return redirect()->route('admin.land.index')->with('error', 'Land record not found.');
        }

        return view('admin.land.edit', ['land' => $land]);
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

        $oldStatus = $land->acquisition_status;

        try {
            DB::transaction(function () use ($land, $validated, $request, $oldStatus, $id) {
                $land->update(array_merge($validated, [
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'remarks' => $request->input('remarks'),
                ]));

                if ($oldStatus !== $validated['acquisition_status']) {
                    LandHistory::create([
                        'land_id' => $id,
                        'event_type' => 'Approval',
                        'event_date' => now(),
                        'performed_by' => user_id(),
                        'description' => 'Acquisition status changed from ' . $oldStatus . ' to ' . $validated['acquisition_status'],
                    ]);

                    PmStatusHistoryService::log(
                        PmStatusHistory::ENTITY_LAND,
                        (int) $id,
                        $oldStatus,
                        $validated['acquisition_status'],
                        'acquisition_status',
                        'Updated via edit form'
                    );
                }
            });

            return redirect()->route('admin.land.show', $id)->with('success', 'Land record updated successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error updating land record.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $land = Land::getDataById($id);
        if (!$land) {
            return back()->with('error', 'Land record not found.');
        }

        $validated = $request->validate([
            'status' => 'required|in:Identified,Negotiation,Approved,Registered,Completed',
            'remarks' => 'nullable|string|max:500',
        ]);

        $oldStatus = $land->acquisition_status;
        if ($oldStatus === $validated['status']) {
            return back()->with('info', 'Status is already set to ' . $validated['status'] . '.');
        }

        Land::where('id', $id)->update(['acquisition_status' => $validated['status']]);

        LandHistory::create([
            'land_id' => $id,
            'event_type' => 'Approval',
            'event_date' => now(),
            'performed_by' => user_id(),
            'description' => 'Acquisition status changed from ' . $oldStatus . ' to ' . $validated['status'],
        ]);

        PmStatusHistoryService::log(
            PmStatusHistory::ENTITY_LAND,
            (int) $id,
            $oldStatus,
            $validated['status'],
            'acquisition_status',
            $validated['remarks'] ?? null
        );

        return back()->with('success', 'Land acquisition status updated.');
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
                'performed_by' => user_id(),
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
                'uploaded_by' => user_id(),
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
                'performed_by' => user_id(),
                'description' => 'Payment record added',
            ]);

            return redirect()->route('admin.land.show', $validated['land_id'])->with('success', 'Payment added successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error adding payment.', false);
        }
    }
}
