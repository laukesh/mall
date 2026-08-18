<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        return view('admin.client.index', [
            'clients' => Client::orderBy('client_name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.client.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_code' => 'required|string|max:30|unique:clients,client_code',
            'client_name' => 'required|string|max:200',
            'client_type' => 'required|in:Individual,Company,Government',
            'status' => 'required|in:Active,Inactive',
        ]);

        try {
            Client::create(array_merge($validated, [
                'contact_person' => $request->input('contact_person'),
                'mobile' => $request->input('mobile'),
                'email' => $request->input('email'),
                'gst_number' => $request->input('gst_number'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'country' => $request->input('country', 'India'),
                'pincode' => $request->input('pincode'),
                'remarks' => $request->input('remarks'),
            ]));

            return redirect()->route('admin.client.index')->with('success', 'Client created.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error creating client.');
        }
    }

    public function show($id)
    {
        $client = Client::getDataById($id);
        if (!$client) {
            return redirect()->route('admin.client.index')->with('error', 'Client not found.');
        }

        return view('admin.client.show', [
            'client' => $client,
            'invoices' => ClientInvoice::where('client_id', $id)->orderByDesc('invoice_date')->get(),
            'projects' => \App\Models\Project::where('client_id', $id)->get(),
        ]);
    }

    public function edit($id)
    {
        $client = Client::getDataById($id);
        if (!$client) {
            return redirect()->route('admin.client.index')->with('error', 'Client not found.');
        }

        return view('admin.client.edit', ['client' => $client]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'client_code' => 'required|string|max:30|unique:clients,client_code,' . $id,
            'client_name' => 'required|string|max:200',
            'client_type' => 'required|in:Individual,Company,Government',
            'status' => 'required|in:Active,Inactive',
        ]);

        try {
            Client::where('id', $id)->update(array_merge($validated, [
                'contact_person' => $request->input('contact_person'),
                'mobile' => $request->input('mobile'),
                'email' => $request->input('email'),
                'gst_number' => $request->input('gst_number'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'country' => $request->input('country', 'India'),
                'pincode' => $request->input('pincode'),
                'remarks' => $request->input('remarks'),
            ]));

            return redirect()->route('admin.client.index')->with('success', 'Client updated.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error updating client.');
        }
    }

    public function destroy($id)
    {
        try {
            Client::where('id', $id)->delete();
            return redirect()->route('admin.client.index')->with('success', 'Client deleted.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error deleting client.', false);
        }
    }

    public function storeInvoice(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'project_id' => 'required|exists:projects,id',
            'invoice_number' => 'required|string|max:50|unique:client_invoices,invoice_number',
            'invoice_date' => 'required|date',
            'payment_status' => 'required|in:Pending,Partial,Paid',
        ]);

        ClientInvoice::create(array_merge($validated, [
            'invoice_amount' => $request->input('invoice_amount'),
            'gst_amount' => $request->input('gst_amount'),
            'due_date' => $request->input('due_date'),
        ]));

        return back()->with('success', 'Invoice created.');
    }
}
