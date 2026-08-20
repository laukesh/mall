@props(['user' => null, 'userId' => null])

@php
  $actor = $user;
  if (! $actor && $userId) {
    $actor = \App\Models\User::with(['roles', 'role'])->find($userId);
  }
@endphp

@if($actor)
  <span>{{ $actor->display_name }}</span>
@elseif($userId)
  <span class="text-muted">User #{{ $userId }}</span>
@else
  <span class="text-muted">-</span>
@endif
