<?php

namespace App\Repositories;

use App\Models\UnitType;

interface UnitTypeRepositoryInterface
{
    public function all(array $filters = []);

    public function find($id);

    public function create(array $data);

    public function update(
        UnitType $unitType,
        array $data
    );

    public function delete(UnitType $unitType);
}