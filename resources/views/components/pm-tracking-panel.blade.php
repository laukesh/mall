@props([
    'statusAction' => null,
    'progressAction' => null,
    'currentStatus',
    'statuses' => [],
    'currentProgress' => null,
    'histories',
    'statusTitle' => 'Change Status',
    'progressTitle' => 'Update Work Progress',
    'historyTitle' => 'Status & Progress History',
])

<div class="row">
  @if($statusAction)
  <div class="col-md-{{ $progressAction ? '6' : '12' }}">
    <x-pm-status-change
      :action="$statusAction"
      :currentStatus="$currentStatus"
      :statuses="$statuses"
      :title="$statusTitle"
    />
  </div>
  @endif
  @if($progressAction)
  <div class="col-md-{{ $statusAction ? '6' : '12' }}">
    <x-pm-progress-change
      :action="$progressAction"
      :currentProgress="$currentProgress ?? 0"
      :title="$progressTitle"
    />
  </div>
  @endif
</div>

<x-pm-status-history-table :histories="$histories ?? collect()" :title="$historyTitle" />
