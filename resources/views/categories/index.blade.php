@extends('layouts.app')


@section('content')

    <div class="d-flex justify-content-end m-2">
        <a href="{{ route('categories.create') }}" class="btn btn-success">
            Add Category
        </a>
    </div>

    <div class="card">
        <div class="card-header">Categories
        </div>
    </div>

@endsection