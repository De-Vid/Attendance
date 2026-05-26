@extends('layouts.app')

@section('title', 'បង្កើតតួនាទី')

@section('content')

<div class="container-fluid bg-white p-4 rounded shadow-sm">

    <h2 class="mb-4">
        ចុះឈ្មោះតួនាទី
    </h2>

    <form action="{{ route('positions.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">

        @csrf
        <label>Position Name</label>
        <div class="col-md-6">
            <input type="text" name="name" class="form-control" placeholder="Position Name" required>
        </div>

<div class="col-md-12">
    <button type="submit" class="btn btn-success">
        <i class="bi bi-check-circle me-1"></i>Save
    </button>
</div>

    </form>

</div>

@endsection