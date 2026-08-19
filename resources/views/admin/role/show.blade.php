@extends('layouts.admin')

@section('title', 'Role Details')

@section('content')
<section class="section">
  <div class="section-header"><h1>{{ $role->role_name }}</h1></div>
  <div class="card"><div class="card-body">
    <p><strong>Description:</strong> {{ $role->role_description ?? '-' }}</p>
    <p><strong>Status:</strong> {{ $role->status ? 'Active' : 'Inactive' }}</p>
  </div></div>
</section>
@endsection
