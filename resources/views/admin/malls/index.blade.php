@extends('layouts.app')

@section('title','Malls')

@section('content')
<div class="mall-filter-bar">
  <div class="mall-filter-row">
    <h1>Malls</h1>
    <a href="{{ route('admin.malls.create') }}">Create Mall</a>
<!-- Filters Toolbar -->
		
    <form method="GET" action="{{ route('admin.malls.index') }}">
        <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">
        <button type="submit">Search</button>
    </form>
</div>
</div>
    @if(session('success'))<div>{{ session('success') }}</div>@endif
	<!-- Results Count -->
		<div class="mall-results-count">Showing {{ $malls->total() }} Malls</div>

		<!-- Data Table -->
		<div class="mall-table-wrapper">
		<div class="mall-table-scroll">
    <table class="mall-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Name</th>
                <th>City</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($malls as $mall)
            <tr>
                <td><span class="mall-unit-ref"><span class="mall-unit-ref">{{ $mall->id }}</span></td>
                <td><span class="mall-unit-ref">{{ $mall->mall_code }}</span></td>
                <td><span class="mall-unit-ref"><a href="{{ route('admin.malls.show', $mall->id) }}">{{ $mall->mall_name }}</a></span></td>
                <td><span class="mall-unit-ref">{{ $mall->city }}</span></td>
                <td><span class="mall-unit-ref">{{ $mall->status }}</span></td>
                <td><span class="mall-unit-ref">
                    <a href="{{ route('admin.malls.edit', $mall->id) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.malls.destroy', $mall->id) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </span></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    
</div>
</div>
@endsection
