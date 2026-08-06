<?php

namespace App\Repositories;

use App\Models\Building;
use App\Repositories\Interfaces\BuildingRepositoryInterface;

class BuildingRepository implements BuildingRepositoryInterface
{
    protected $model;

    public function __construct(Building $building)
    {
        $this->model = $building;
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->with('mall')->orderBy('building_name')->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->model->with('mall')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $building = $this->model->findOrFail($id);
        $building->update($data);
        return $building;
    }

    public function delete(int $id)
    {
        $building = $this->model->findOrFail($id);
        return $building->delete();
    }
}
