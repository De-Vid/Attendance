@extends('layouts.app')

@section('title', 'បង្កើតម៉េាង')

@section('content')

<div class="container bg-white p-4 rounded shadow-sm">

    <h2 class="mb-4">
        Update Time
    </h2>

    <form action="{{ route('attendance_types.update', $settings_type->id) }}" method="POST" enctype="multipart/form-data"
        class="row g-3">

        @csrf
        @method('PUT')
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <label>Name</label>
                    <div class="col-md-12">
                        <input type="text" name="name" class="form-control"
                            value="{{ $settings_type->name }}" required>
                    </div>

                </div>
                <div class="col-md-6">
                    <label>Label</label>
                    <div class="col-md-12">
                        <input type="text" name="label" class="form-control"
                            value="{{ $settings_type->label }}" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle me-1"></i>Update
            </button>
        </div>

    </form>

</div>

@endsection