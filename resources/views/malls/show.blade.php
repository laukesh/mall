@extends('layouts.app')

@section('title', $mall->mall_name)

@section('content')
    <h1>{{ $mall->mall_name }}</h1>
    <p>Code: {{ $mall->mall_code }}</p>
    <p>Type: {{ $mall->mall_type }}</p>
    <p>Address: {{ $mall->address_line1 }} {{ $mall->address_line2 }}</p>
    <p>City: {{ $mall->city }}</p>
    <p>Status: {{ $mall->status }}</p>
    <a href="{{ route('malls.edit', $mall->id) }}">Edit</a>
    <a href="{{ route('malls.index') }}">Back</a>
@endsection
