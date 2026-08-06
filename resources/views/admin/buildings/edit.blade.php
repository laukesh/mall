@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Building</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.buildings.update', $building->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.buildings._form')
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
