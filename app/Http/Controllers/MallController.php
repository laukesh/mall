<?php

namespace App\Http\Controllers;

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
        $this->middleware('auth')->except(['index','show']);
        $this->authorizeResource(Mall::class, 'mall');
    }

    public function index(Request $request)
    {
        $malls = $this->malls->all(['search' => $request->get('search')]);
        return view('malls.index', compact('malls'));
    }

    public function create()
    {
        $this->authorize('create', Mall::class);
        return view('malls.create');
    }

    public function store(MallRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id() ?? null;
        $mall = $this->malls->create($data);
        return redirect()->route('malls.show', $mall->id)->with('success', 'Mall created');
    }

    public function show(Mall $mall)
    {
        return view('malls.show', compact('mall'));
    }

    public function edit(Mall $mall)
    {
        $this->authorize('update', $mall);
        return view('malls.edit', compact('mall'));
    }

    public function update(MallRequest $request, Mall $mall)
    {
        $data = $request->validated();
        $data['updated_by'] = auth()->id() ?? null;
        $this->malls->update($mall, $data);
        return redirect()->route('malls.show', $mall->id)->with('success', 'Mall updated');
    }

    public function destroy(Mall $mall)
    {
        $this->authorize('delete', $mall);
        $this->malls->delete($mall);
        return redirect()->route('malls.index')->with('success', 'Mall removed');
    }
}
