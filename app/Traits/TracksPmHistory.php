<?php

namespace App\Traits;

use App\Services\PmStatusHistoryService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

trait TracksPmHistory
{
    protected function pmLogStatus(
        string $entityType,
        int $entityId,
        ?string $oldValue,
        string $newValue,
        string $fieldName = 'status',
        ?string $remarks = null
    ): void {
        PmStatusHistoryService::log($entityType, $entityId, $oldValue, $newValue, $fieldName, $remarks);
    }

    protected function pmUpdateStatus(
        Request $request,
        Model $record,
        string $entityType,
        string $statusColumn,
        array $allowedStatuses,
        ?string $fieldName = null
    ): RedirectResponse {
        $fieldName = $fieldName ?? $statusColumn;

        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', $allowedStatuses),
            'remarks' => 'nullable|string|max:500',
        ]);

        $oldStatus = $record->{$statusColumn};
        if ($oldStatus === $validated['status']) {
            return back()->with('info', 'Status is already set to ' . $validated['status'] . '.');
        }

        $record->update([$statusColumn => $validated['status']]);

        $this->pmLogStatus(
            $entityType,
            (int) $record->id,
            $oldStatus,
            $validated['status'],
            $fieldName,
            $validated['remarks'] ?? null
        );

        return back()->with('success', 'Status updated.');
    }

    protected function pmUpdateProgress(
        Request $request,
        Model $record,
        string $entityType
    ): RedirectResponse {
        $validated = $request->validate([
            'progress_percentage' => 'required|numeric|min:0|max:100',
            'remarks' => 'nullable|string|max:500',
        ]);

        $oldProgress = $record->progress_percentage ?? 0;
        $newProgress = (float) $validated['progress_percentage'];

        if ((float) $oldProgress === $newProgress) {
            return back()->with('info', 'Progress is already ' . $newProgress . '%.');
        }

        $record->update(['progress_percentage' => $newProgress]);

        $this->pmLogStatus(
            $entityType,
            (int) $record->id,
            (string) $oldProgress,
            (string) $newProgress,
            'progress_percentage',
            $validated['remarks'] ?? null
        );

        return back()->with('success', 'Work progress updated.');
    }
}
