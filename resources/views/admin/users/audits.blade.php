@extends('layouts.app')

@section('content')
    <h1>Status Audits for {{ $user->name }}</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Field</th>
                <th>Old</th>
                <th>New</th>
                <th>Changed By</th>
                <th>When</th>
            </tr>
        </thead>
        <tbody>
        @foreach($audits as $a)
            <tr>
                <td>{{ $a->id }}</td>
                <td>{{ $a->field }}</td>
                <td>{{ $a->old_value }}</td>
                <td>{{ $a->new_value }}</td>
                <td>{{ $a->changed_by }}</td>
                <td>{{ $a->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $audits->links() }}
    <p><a href="{{ route('admin.users.show', $user->id) }}">Back</a></p>
@endsection
