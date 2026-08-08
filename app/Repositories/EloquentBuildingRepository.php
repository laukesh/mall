<?php

namespace App\Repositories;

use App\Models\Building;

class EloquentBuildingRepository implements BuildingRepositoryInterface
{
    public function all(array $filters = [])
    {
        $query = Building::query();

        if (! empty($filters['search'])) {
            $s = '%'.$filters['search'].'%';
            $query->where('building_name', 'like', $s)
                  ->orWhere('building_code', 'like', $s)
                  ->orWhere('city', 'like', $s);
        }

        return $query->orderBy('id', 'desc')->paginate(20);
    }

    public function find(int $id): ?Building
    {
        return Building::find($id);
    }

    public function create(array $data): Building
    {
        return Building::create($data);
    }

    public function update(Building $building, array $data): Building
    {
        $building->fill($data);
        $building->save();
        return $building;
    }

    public function delete(Building $building): bool
    {
        return (bool) $building->delete();
    }
}
