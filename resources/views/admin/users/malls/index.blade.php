<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Malls</title>
</head>
<body>
    <h1>Malls</h1>
    <a href="{{ route('malls.create') }}">Create Mall</a>

    <form method="GET" action="{{ route('malls.index') }}">
        <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">
        <button type="submit">Search</button>
    </form>

    @if(session('success'))<div>{{ session('success') }}</div>@endif

    <table border="1">
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
                <td>{{ $mall->id }}</td>
                <td>{{ $mall->mall_code }}</td>
                <td><a href="{{ route('malls.show', $mall->id) }}">{{ $mall->mall_name }}</a></td>
                <td>{{ $mall->city }}</td>
                <td>{{ $mall->status }}</td>
                <td>
                    <a href="{{ route('malls.edit', $mall->id) }}">Edit</a>
                    <form method="POST" action="{{ route('malls.destroy', $mall->id) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $malls->links() }}
</body>
</html>
