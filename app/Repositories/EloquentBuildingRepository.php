<?php

namespace App\Repositories;

use App\Models\Building;

/**
 * Eloquent implementation of BuildingRepositoryInterface.
 */
class EloquentBuildingRepository implements BuildingRepositoryInterface
{
    /**
     * @var Building
     */
    protected $model;

    public function __construct(Building $building)
    {
        $this->model = $building;
    }

    /**
     * @inheritDoc
     */
    public function all(array $filters = [])
    {
        $query = $this->model->with('mall')->orderBy('building_name');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('building_name', 'like', "%{$search}%")
                  ->orWhere('building_code', 'like', "%{$search}%");
            });
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['mall_id'])) {
            $query->where('mall_id', $filters['mall_id']);
        }

        return $query->paginate(15)->withQueryString();
    }

    /**
     * @inheritDoc
     */
    public function find(int $id)
    {
        return $this->model->with('mall')->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @inheritDoc
     */
    public function update(Building $building, array $data)
    {
        $building->update($data);
        return $building->fresh('mall');
    }

    /**
     * @inheritDoc
     */
    public function delete(Building $building): bool
    {
        return (bool) $building->delete();
    }
}