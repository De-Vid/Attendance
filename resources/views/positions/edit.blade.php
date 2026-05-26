@extends('layouts.app')

@section('title', 'បង្កើតតួនាទី')

@section('content')

<div class="container-fluid bg-white p-4 rounded shadow-sm">

    <h2 class="mb-4">
        Update Position
    </h2>

    <form action="{{ route('positions.update', $position->id) }}" method="POST" enctype="multipart/form-data" class="row g-3">

        @csrf
        @method('PUT')
        <label>Position Name</label>
        <div class="col-md-6">
            <input type="text" name="name" class="form-control" value="{{ $position->name }}">
        </div>

    <div class="col-md-12">
        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle me-1"></i>Update
        </button>
    </div>

    </form>

</div>

@endsection