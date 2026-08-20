<?php

namespace App\Services;

use App\Models\PmStatusHistory;
use App\Models\ProjectStatusHistory;
use App\Models\WorkPackageHistory;

class PmStatusHistoryService
{
    public static function log(
        string $entityType,
        int $entityId,
        ?string $oldValue,
        string $newValue,
        string $fieldName = 'status',
        ?string $remarks = null
    ): void {
        $changedBy = user_id();
        $changedAt = now();

        PmStatusHistory::create([
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'field_name' => $fieldName,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'changed_by' => $changedBy,
            'remarks' => $remarks,
            'changed_at' => $changedAt,
        ]);

        if ($entityType === PmStatusHistory::ENTITY_PROJECT) {
            ProjectStatusHistory::create([
                'project_id' => $entityId,
                'previous_status' => $oldValue,
                'current_status' => $newValue,
                'changed_by' => $changedBy,
                'remarks' => $remarks,
                'changed_at' => $changedAt,
            ]);
        }

        if ($entityType === PmStatusHistory::ENTITY_WORK_PACKAGE) {
            WorkPackageHistory::create([
                'work_package_id' => $entityId,
                'action' => 'status_change',
                'old_value' => $oldValue,
                'new_value' => $newValue,
                'changed_by' => $changedBy,
                'changed_at' => $changedAt,
            ]);
        }
    }

    public static function historiesFor(string $entityType, int $entityId)
    {
        return PmStatusHistory::forEntity($entityType, $entityId)
            ->with(['changedBy.roles', 'changedBy.role'])
            ->get();
    }

    public static function recent(int $limit = 100)
    {
        return PmStatusHistory::with(['changedBy.roles', 'changedBy.role'])
            ->orderByDesc('changed_at')
            ->limit($limit)
            ->get();
    }
}
