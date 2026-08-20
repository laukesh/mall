<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\PmStatusHistory;
use App\Models\Project;
use App\Services\PmStatusHistoryService;
use App\Traits\TracksPmHistory;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    use TracksPmHistory;

    private const STATUSES = ['Draft', 'Pending', 'Approved', 'Rejected'];

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
            'approval_status' => 'required|in:' . implode(',', self::STATUSES),
            'visibility' => 'required|in:Internal,Contractor,Client,Public',
        ]);

        if ($request->hasFile('document_file')) {
            uploadFile($request->file('document_file'), 'documents');
        }

        $document = Document::create(array_merge($validated, [
            'document_type' => $request->input('document_type'),
            'current_version' => $request->input('current_version', 'V1'),
            'uploaded_by' => id() ?: 1,
            'upload_date' => now(),
            'remarks' => $request->input('remarks'),
        ]));

        $this->pmLogStatus(PmStatusHistory::ENTITY_DOCUMENT, $document->id, null, $document->approval_status, 'approval_status', 'Document registered');

        return redirect()->route('admin.document.show', $document->id)->with('success', 'Document registered.');
    }

    public function show($id)
    {
        $document = Document::getDataById($id);
        if (! $document) {
            return redirect()->route('admin.document.index')->with('error', 'Document not found.');
        }

        return view('admin.document.show', [
            'document' => $document,
            'statusHistories' => PmStatusHistoryService::historiesFor(PmStatusHistory::ENTITY_DOCUMENT, (int) $id),
        ]);
    }

    public function edit($id)
    {
        $document = Document::getDataById($id);
        if (! $document) {
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
        $document = Document::find($id);
        if (! $document) {
            return redirect()->route('admin.document.index')->with('error', 'Document not found.');
        }

        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'category_id' => 'required|exists:document_categories,id',
            'document_number' => 'required|string|max:50|unique:documents,document_number,' . $id,
            'document_title' => 'required|string|max:255',
            'approval_status' => 'required|in:' . implode(',', self::STATUSES),
            'visibility' => 'required|in:Internal,Contractor,Client,Public',
        ]);

        $oldStatus = $document->approval_status;
        $oldProgress = $document->progress_percentage ?? 0;

        $document->update(array_merge($validated, [
            'document_type' => $request->input('document_type'),
            'current_version' => $request->input('current_version'),
            'remarks' => $request->input('remarks'),
            'progress_percentage' => $request->input('progress_percentage', $oldProgress),
        ]));

        if ($oldStatus !== $validated['approval_status']) {
            $this->pmLogStatus(PmStatusHistory::ENTITY_DOCUMENT, (int) $id, $oldStatus, $validated['approval_status'], 'approval_status', 'Updated via edit form');
        }

        $newProgress = $request->input('progress_percentage', $oldProgress);
        if ((float) $oldProgress !== (float) $newProgress) {
            $this->pmLogStatus(PmStatusHistory::ENTITY_DOCUMENT, (int) $id, (string) $oldProgress, (string) $newProgress, 'progress_percentage', 'Updated via edit form');
        }

        return redirect()->route('admin.document.show', $id)->with('success', 'Document updated.');
    }

    public function updateStatus(Request $request, $id)
    {
        $document = Document::find($id);
        if (! $document) {
            return back()->with('error', 'Document not found.');
        }

        return $this->pmUpdateStatus($request, $document, PmStatusHistory::ENTITY_DOCUMENT, 'approval_status', self::STATUSES, 'approval_status');
    }

    public function updateProgress(Request $request, $id)
    {
        $document = Document::find($id);
        if (! $document) {
            return back()->with('error', 'Document not found.');
        }

        return $this->pmUpdateProgress($request, $document, PmStatusHistory::ENTITY_DOCUMENT);
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
