@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Building</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.buildings.store') }}" method="POST">
        @csrf
        @include('admin.buildings._form', ['building' => null])
        <button class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
