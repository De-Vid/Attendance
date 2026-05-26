@extends('layouts.app')

@section('title', 'បង្កើតម៉េាង')

@section('content')

<div class="container bg-white p-4 rounded shadow-sm">

    <h2 class="mb-4">
        Update Time
    </h2>

    <form action="{{ route('attendance-settings.update', $setting->id) }}" method="POST" enctype="multipart/form-data"
        class="row g-3">

        @csrf
        @method('PUT')
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <label>Morning Check-in</label>
                    <div class="col-md-12">
                        <input type="time" name="morning_check_in" class="form-control"
                            value="{{ $setting->morning_check_in }}" required>
                    </div>

                    <label>Morning Check-out</label>
                    <div class="col-md-12">
                        <input type="time" name="morning_check_out" class="form-control"
                            value="{{ $setting->morning_check_out }}" required>
                    </div>

                </div>
                <div class="col-md-6">
                    <label>Afternoon Check-in</label>
                    <div class="col-md-12">
                        <input type="time" name="afternoon_check_in" class="form-control"
                            value="{{ $setting->afternoon_check_in }}" required>
                    </div>

                    <label>Afternoon Check-out</label>
                    <div class="col-md-12">
                        <input type="time" name="afternoon_check_out" class="form-control"
                            value="{{ $setting->afternoon_check_out }}" required>
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