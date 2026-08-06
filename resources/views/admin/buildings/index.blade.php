@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Buildings</h1>
        <a href="{{ route('admin.buildings.create') }}" class="btn btn-primary">New Building</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Name</th>
                <th>Mall</th>
                <th>Floors</th>
                <th>Units</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buildings as $b)
            <tr>
                <td>{{ $b->id }}</td>
                <td>{{ $b->building_code }}</td>
                <td>{{ $b->building_name }}</td>
                <td>{{ optional($b->mall)->name }}</td>
                <td>{{ $b->total_floors }}</td>
                <td>{{ $b->total_units }}</td>
                <td>{{ $b->status }}</td>
                <td>
                    <a href="{{ route('admin.buildings.show', $b->id) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('admin.buildings.edit', $b->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.buildings.destroy', $b->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete building?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $buildings->links() }}
</div>
@endsection
