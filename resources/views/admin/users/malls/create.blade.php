<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Create Mall</title>
</head>
<body>
    <h1>Create Mall</h1>
    <form method="POST" action="{{ route('malls.store') }}">
        @csrf
        <label>Code <input name="mall_code" value="{{ old('mall_code') }}"></label><br>
        <label>Name <input name="mall_name" value="{{ old('mall_name') }}"></label><br>
        <label>City <input name="city" value="{{ old('city') }}"></label><br>
        <label>Status <input name="status" value="{{ old('status') }}"></label><br>
        <button type="submit">Create</button>
    </form>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    @endif
</body>
</html>
