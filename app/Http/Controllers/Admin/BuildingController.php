<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BuildingRepository;
use App\Models\Mall;

class BuildingController extends Controller
{
    protected $repo;

    public function __construct(BuildingRepository $repo)
    {
        $this->middleware(['auth','can:manage-malls']);
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $buildings = $this->repo->paginate($perPage);
        return view('admin.buildings.index', compact('buildings'));
    }

    public function create()
    {
        $malls = Mall::pluck('name','id');
        return view('admin.buildings.create', compact('malls'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mall_id' => 'required|exists:malls,id',
            'building_code' => 'required|string|max:255|unique:buildings,building_code',
            'building_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_floors' => 'nullable|integer',
            'total_units' => 'nullable|integer',
            'status' => 'nullable|string|max:50',
        ]);

        $data['created_by'] = auth()->id();

        $this->repo->create($data);

        return redirect()->route('admin.buildings.index')->with('success', 'Building created.');
    }

    public function show($id)
    {
        $building = $this->repo->find($id);
        return view('admin.buildings.show', compact('building'));
    }

    public function edit($id)
    {
        $building = $this->repo->find($id);
        $malls = Mall::pluck('name','id');
        return view('admin.buildings.edit', compact('building','malls'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'mall_id' => 'required|exists:malls,id',
            'building_code' => 'required|string|max:255|unique:buildings,building_code,'.$id,
            'building_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_floors' => 'nullable|integer',
            'total_units' => 'nullable|integer',
            'status' => 'nullable|string|max:50',
        ]);

        $data['updated_by'] = auth()->id();

        $this->repo->update($id, $data);

        return redirect()->route('admin.buildings.index')->with('success', 'Building updated.');
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return redirect()->route('admin.buildings.index')->with('success', 'Building deleted.');
    }
}
