<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Mall;
use App\Repositories\BuildingRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuildingController extends Controller
{
    protected $repo;

    public function __construct(BuildingRepositoryInterface $repo)
    {
        $this->middleware('auth');
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status', 'mall_id']);

        $buildings = $this->repo->all($filters);

        return view('admin.buildings.index', compact('buildings'));
    }

    public function create()
    {
        $malls = Mall::pluck('name', 'id');

        return view('admin.buildings.create', compact('malls'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mall_id'       => 'required|exists:malls,id',
            'building_code' => 'required|string|max:255|unique:buildings,building_code',
            'building_name' => 'required|string|max:255',
            'description'   => 'nullable|string',
            'total_floors'  => 'nullable|integer',
            'total_units'   => 'nullable|integer',
            'status'        => 'nullable|string|max:50',
        ]);

        $data['created_by'] = Auth::id();

        $this->repo->create($data);

        return redirect()
            ->route('admin.buildings.index')
            ->with('success', 'Building created.');
    }

    public function show(int $id)
    {
        $building = $this->repo->find($id);

        if (!$building) {
            abort(404);
        }

        return view('admin.buildings.show', compact('building'));
    }

    public function edit(int $id)
    {
        $building = $this->repo->find($id);

        if (!$building) {
            abort(404);
        }

        $malls = Mall::pluck('name', 'id');

        return view('admin.buildings.edit', compact('building', 'malls'));
    }

    public function update(Request $request, Building $building)
    {
        $data = $request->validate([
            'mall_id'       => 'required|exists:malls,id',
            'building_code' => 'required|string|max:255|unique:buildings,building_code,' . $building->id,
            'building_name' => 'required|string|max:255',
            'description'   => 'nullable|string',
            'total_floors'  => 'nullable|integer',
            'total_units'   => 'nullable|integer',
            'status'        => 'nullable|string|max:50',
        ]);

        $data['updated_by'] = Auth::id();

        $this->repo->update($building, $data);

        return redirect()
            ->route('admin.buildings.index')
            ->with('success', 'Building updated.');
    }

    public function destroy(Building $building)
    {
        $this->repo->delete($building);

        return redirect()
            ->route('admin.buildings.index')
            ->with('success', 'Building deleted.');
    }
}