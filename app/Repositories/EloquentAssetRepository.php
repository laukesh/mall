<?php

namespace App\Repositories;

use App\Models\Asset;

class EloquentAssetRepository implements AssetRepositoryInterface
{
    public function all(array $filters = [])
    {
        return $this->query($filters)
            ->latest('id')
            ->get();
    }

    public function paginate(array $filters = [], int $perPage = 15)
    {
        return $this->query($filters)
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function find(int $id)
    {
        return Asset::with([
            'unit',
            'building',
            'floor',
            'zone',
            'department',
            'assignedUser',
            'vendor',
            'creator',
            'updater',
        ])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Asset::create($data);
    }

    public function update(int $id, array $data)
    {
        $asset = Asset::findOrFail($id);

        $asset->update($data);

        return $asset->refresh();
    }

    public function delete(int $id): bool
    {
        return (bool) Asset::findOrFail($id)->delete();
    }

    protected function query(array $filters = [])
    {
        $query = Asset::query()->with([
            'unit',
            'building',
            'floor',
            'zone',
            'department',
            'assignedUser',
            'vendor',
            'creator',
            'updater',
        ]);

        if (!empty($filters['search'])) {

            $search = $filters['search'];

            $query->where(function ($q) use ($search) {

                $q->where('asset_code', 'like', "%{$search}%")
                    ->orWhere('asset_name', 'like', "%{$search}%")
                    ->orWhere('asset_type', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%")
                    ->orWhere('model_number', 'like', "%{$search}%")
                    ->orWhere('manufacturer', 'like', "%{$search}%");
            });
        }

        if (
            isset($filters['status']) &&
            $filters['status'] !== ''
        ) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['asset_category'])) {
            $query->where(
                'asset_category',
                $filters['asset_category']
            );
        }

        if (!empty($filters['building_id'])) {
            $query->where(
                'building_id',
                $filters['building_id']
            );
        }

        if (!empty($filters['floor_id'])) {
            $query->where(
                'floor_id',
                $filters['floor_id']
            );
        }

        if (!empty($filters['zone_id'])) {
            $query->where(
                'zone_id',
                $filters['zone_id']
            );
        }

        if (!empty($filters['unit_id'])) {
            $query->where(
                'unit_id',
                $filters['unit_id']
            );
        }

        return $query;
    }
}