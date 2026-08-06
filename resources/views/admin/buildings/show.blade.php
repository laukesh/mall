@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Building Details</h1>

    <table class="table">
        <tr><th>ID</th><td>{{ $building->id }}</td></tr>
        <tr><th>Code</th><td>{{ $building->building_code }}</td></tr>
        <tr><th>Name</th><td>{{ $building->building_name }}</td></tr>
        <tr><th>Mall</th><td>{{ optional($building->mall)->name }}</td></tr>
        <tr><th>Description</th><td>{{ $building->description }}</td></tr>
        <tr><th>Total Floors</th><td>{{ $building->total_floors }}</td></tr>
        <tr><th>Total Units</th><td>{{ $building->total_units }}</td></tr>
        <tr><th>Status</th><td>{{ $building->status }}</td></tr>
    </table>

    <a href="{{ route('admin.buildings.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
