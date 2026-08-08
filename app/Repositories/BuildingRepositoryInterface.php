<?php

namespace App\Repositories;

use App\Models\Building;

interface BuildingRepositoryInterface
{
   // public function paginate(int $perPage = 15);
    public function all(array $filters = []);
    public function find(int $id): ?Building;
    public function create(array $data): Building;
    public function update(Building $building, array $data): Building;
    public function delete(Building $building): bool;
}