<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\MallRepositoryInterface;
use App\Models\Mall;
use App\Http\Requests\MallRequest;

class MallController extends Controller
{
    protected $malls;

    public function __construct(MallRepositoryInterface $malls)
    {
        $this->malls = $malls;
        $this->middleware(['auth','can:manage-users']);
    }

    public function index(Request $request)
    {
        $malls = $this->malls->all(['search' => $request->get('search')]);
        return view('admin.malls.index', compact('malls'));
    }

    public function create()
    {
        $this->authorize('create', Mall::class);
        return view('admin.malls.create');
    }

    public function store(MallRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id() ?? null;
        $mall = $this->malls->create($data);
        return redirect()->route('admin.malls.show', $mall->id)->with('success', 'Mall created');
    }

    public function show($id)
    {
        $mall = $this->malls->find($id);
        if (! $mall) abort(404);
        return view('admin.malls.show', compact('mall'));
    }

    public function edit($id)
    {
        $mall = $this->malls->find($id);
        if (! $mall) abort(404);
        $this->authorize('update', $mall);
        return view('admin.malls.edit', compact('mall'));
    }

    public function update(MallRequest $request, $id)
    {
        $mall = $this->malls->find($id);
        if (! $mall) abort(404);
        $data = $request->validated();
        $data['updated_by'] = auth()->id() ?? null;
        $this->malls->update($mall, $data);
        return redirect()->route('admin.malls.show', $mall->id)->with('success', 'Mall updated');
    }

    public function destroy($id)
    {
        $mall = $this->malls->find($id);
        if (! $mall) abort(404);
        $this->authorize('delete', $mall);
        $this->malls->delete($mall);
        return redirect()->route('admin.malls.index')->with('success', 'Mall removed');
    }
}
