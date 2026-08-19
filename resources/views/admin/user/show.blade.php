@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between"><h1>{{ $user->full_name }}</h1>
    <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-primary">Edit</a>
  </div>
  <div class="card"><div class="card-body">
    <div class="row">
      <div class="col-md-6"><p><strong>Employee Code:</strong> {{ $user->employee_code }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Mobile:</strong> {{ $user->mobile ?? '-' }}</p>
        <p><strong>Role:</strong> {{ $user->role->role_name ?? '-' }}</p></div>
      <div class="col-md-6"><p><strong>Designation:</strong> {{ $user->designation ?? '-' }}</p>
        <p><strong>Department:</strong> {{ $user->department ?? '-' }}</p>
        <p><strong>Status:</strong> {{ $user->status }}</p>
        <p><strong>Last Login:</strong> {{ $user->last_login ?? 'Never' }}</p></div>
    </div>
  </div></div>
</section>
@endsection
