<?php

namespace App\Http\Controllers\Admin\Vendors;

use App\Http\Controllers\Controller;
use App\Repositories\VendorServiceRepositoryInterface;
use Illuminate\Http\Request;

class VendorServiceController extends Controller
{
    public function __construct(
        private readonly VendorServiceRepositoryInterface $repository
    ) {}

    public function index(Request $request)
    {
        $items = $this->repository->all($request->only(['search', 'status', 'per_page']));

        return view('admin.vendor_services.index', compact('items'));
    }

    public function create()
    {
        return view('admin.vendor_services.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $item = $this->repository->create($data);

        return redirect()
            ->route('admin.vendor_services.show', $item->id)
            ->with('success', 'Vendor Service created successfully.');
    }

    public function show(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.vendor_services.show', compact('item'));
    }

    public function edit(int $id)
    {
        $item = $this->repository->find($id);

        return view('admin.vendor_services.edit', compact('item'));
    }

    public function update(Request $request, int $id)
    {
        $data = $this->validated($request, $id);
        $data['updated_by'] = auth()->id();

        $item = $this->repository->update($id, $data);

        return redirect()
            ->route('admin.vendor_services.show', $item->id)
            ->with('success', 'Vendor Service updated successfully.');
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);

        return redirect()
            ->route('admin.vendor_services.index')
            ->with('success', 'Vendor Service deleted successfully.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        $rules = [
            'vendor_user_id' => 'required|numeric',
            'service_name' => 'required|string|max:200',
            'service_category' => 'nullable|string|max:200',
            'description' => 'nullable|string',
            'service_rate' => 'nullable|numeric',
            'rate_unit' => 'nullable|string|max:200',
            'emergency_available' => 'nullable|in:0,1',
            'status' => 'required|in:Active,Inactive',
            'remarks' => 'nullable|string',
        ];

        if ($id) {
            $rules = array_map(
                fn ($rule) => str_replace('{id}', (string) $id, $rule),
                $rules
            );
        } else {
            $rules = array_map(
                fn ($rule) => str_replace(',{id}', '', $rule),
                $rules
            );
        }

        return $request->validate($rules);
    }
}
