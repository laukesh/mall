@extends('layouts.app')

@section('title','Edit Mall')

@section('content')
    <h1>Edit Mall</h1>
    <form method="POST" action="{{ route('admin.malls.update', $mall->id) }}">
        @csrf
        @method('PUT')
        <label>Code <input name="mall_code" value="{{ old('mall_code', $mall->mall_code) }}"></label><br>
        <label>Name <input name="mall_name" value="{{ old('mall_name', $mall->mall_name) }}"></label><br>
        <label>City <input name="city" value="{{ old('city', $mall->city) }}"></label><br>
        <label>Status <input name="status" value="{{ old('status', $mall->status) }}"></label><br>
        <button type="submit">Update</button>
    </form>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    @endif
@endsection
