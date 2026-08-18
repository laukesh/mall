<?php

namespace App\Http\Controllers;

use App\Models\Consultant;
use Illuminate\Http\Request;

class ConsultantController extends Controller
{
    public function index()
    {
        return view('admin.consultant.index', [
            'consultants' => Consultant::orderBy('consultant_name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.consultant.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'consultant_name' => 'required|string|max:200',
            'consultant_type' => 'required|in:Architect,Structural,MEP,Landscape,Interior,PMC',
            'company_name' => 'required|string|max:200',
            'contact_person' => 'required|string|max:150',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|max:150',
            'status' => 'required|in:Active,Inactive',
        ]);

        try {
            Consultant::create(array_merge($validated, [
                'address' => $request->input('address'),
                'gst_number' => $request->input('gst_number'),
            ]));

            return redirect()->route('admin.consultant.index')->with('success', 'Consultant created.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error creating consultant.');
        }
    }

    public function edit($id)
    {
        $consultant = Consultant::getDataById($id);
        if (!$consultant) {
            return redirect()->route('admin.consultant.index')->with('error', 'Consultant not found.');
        }

        return view('admin.consultant.edit', ['consultant' => $consultant]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'consultant_name' => 'required|string|max:200',
            'consultant_type' => 'required|in:Architect,Structural,MEP,Landscape,Interior,PMC',
            'company_name' => 'required|string|max:200',
            'contact_person' => 'required|string|max:150',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|max:150',
            'status' => 'required|in:Active,Inactive',
        ]);

        try {
            Consultant::where('id', $id)->update(array_merge($validated, [
                'address' => $request->input('address'),
                'gst_number' => $request->input('gst_number'),
            ]));

            return redirect()->route('admin.consultant.index')->with('success', 'Consultant updated.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error updating consultant.');
        }
    }

    public function destroy($id)
    {
        try {
            Consultant::where('id', $id)->delete();
            return redirect()->route('admin.consultant.index')->with('success', 'Consultant deleted.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Cannot delete consultant. It may be linked to design packages.', false);
        }
    }
}
