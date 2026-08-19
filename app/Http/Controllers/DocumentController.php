<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Project;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        return view('admin.document.index', [
            'documents' => Document::orderByDesc('upload_date')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.document.create', [
            'projects' => Project::orderBy('project_name')->get(),
            'categories' => DocumentCategory::where('status', 'Active')->orderBy('category_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'category_id' => 'required|exists:document_categories,id',
            'document_number' => 'required|string|max:50|unique:documents,document_number',
            'document_title' => 'required|string|max:255',
            'approval_status' => 'required|in:Draft,Pending,Approved,Rejected',
            'visibility' => 'required|in:Internal,Contractor,Client,Public',
        ]);

        $filePath = '';
        if ($request->hasFile('document_file')) {
            $filePath = uploadFile($request->file('document_file'), 'documents');
        }

        Document::create(array_merge($validated, [
            'document_type' => $request->input('document_type'),
            'current_version' => $request->input('current_version', 'V1'),
            'uploaded_by' => id() ?: 1,
            'upload_date' => now(),
            'remarks' => $request->input('remarks'),
        ]));

        return redirect()->route('admin.document.index')->with('success', 'Document registered.');
    }

    public function show($id)
    {
        $document = Document::getDataById($id);
        if (!$document) {
            return redirect()->route('admin.document.index')->with('error', 'Document not found.');
        }

        return view('admin.document.show', ['document' => $document]);
    }

    public function edit($id)
    {
        $document = Document::getDataById($id);
        if (!$document) {
            return redirect()->route('admin.document.index')->with('error', 'Document not found.');
        }

        return view('admin.document.edit', [
            'document' => $document,
            'projects' => Project::orderBy('project_name')->get(),
            'categories' => DocumentCategory::where('status', 'Active')->orderBy('category_name')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'category_id' => 'required|exists:document_categories,id',
            'document_number' => 'required|string|max:50|unique:documents,document_number,' . $id,
            'document_title' => 'required|string|max:255',
            'approval_status' => 'required|in:Draft,Pending,Approved,Rejected',
            'visibility' => 'required|in:Internal,Contractor,Client,Public',
        ]);

        Document::where('id', $id)->update(array_merge($validated, [
            'document_type' => $request->input('document_type'),
            'current_version' => $request->input('current_version'),
            'remarks' => $request->input('remarks'),
        ]));

        return redirect()->route('admin.document.index')->with('success', 'Document updated.');
    }

    public function destroy($id)
    {
        Document::where('id', $id)->delete();
        return redirect()->route('admin.document.index')->with('success', 'Document deleted.');
    }

    public function categories()
    {
        return view('admin.document.categories', [
            'categories' => DocumentCategory::orderBy('category_name')->get(),
        ]);
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:100|unique:document_categories,category_name',
            'status' => 'required|in:Active,Inactive',
        ]);

        DocumentCategory::create(array_merge($validated, [
            'description' => $request->input('description'),
        ]));

        return back()->with('success', 'Category created.');
    }
}
