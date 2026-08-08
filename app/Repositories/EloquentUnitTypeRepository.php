<?php

namespace App\Repositories;

use App\Models\UnitType;

class EloquentUnitTypeRepository
    implements UnitTypeRepositoryInterface
{
    /**
     * Get all unit types.
     */
    public function all(array $filters = [])
    {
        $query = UnitType::with([
            'creator',
            'updater',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */
        if (!empty($filters['search'])) {

            $search = $filters['search'];

            $query->where(function ($q) use ($search) {

                $q->where(
                    'type_name',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'description',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'status',
                    'like',
                    "%{$search}%"
                );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */
        if (!empty($filters['status'])) {

            $query->where(
                'status',
                $filters['status']
            );
        }

        return $query
            ->orderBy('type_name')
            ->get();
    }

    /**
     * Find unit type.
     */
    public function find($id)
    {
        return UnitType::with([
            'creator',
            'updater',
        ])->find($id);
    }

    /**
     * Create unit type.
     */
    public function create(array $data)
    {
        return UnitType::create($data);
    }

    /**
     * Update unit type.
     */
    public function update(
        UnitType $unitType,
        array $data
    ) {
        $unitType->update($data);

        return $unitType->fresh([
            'creator',
            'updater',
        ]);
    }

    /**
     * Delete unit type.
     */
    public function delete(UnitType $unitType)
    {
        return $unitType->delete();
    }
}