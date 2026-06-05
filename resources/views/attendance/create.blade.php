@extends('layouts.app')

@section('title', 'បង្កើតបុគ្គលិក')

@section('content')

<div class="container-fluid bg-white p-4 rounded shadow-sm">

    <h2 class="mb-4">
        ចុះឈ្មោះបុគ្គលិក
    </h2>

    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">

        @csrf

        <div class="col-md-6">
            <label for="staff_id" class="form-label">អត្តលេខបុគ្គលិក</label>
            <input type="text" name="staff_id" class="form-control" placeholder="អត្តលេខបុគ្គលិក" required>
        </div>

        <div class="col-md-6">
            <label for="name" class="form-label">ឈ្មោះបុគ្គលិក</label>
            <input type="text" name="name" class="form-control" placeholder="ឈ្មោះបុគ្គលិក" required>
        </div>
        <div class="col-md-6 mt-2">
            <label for="salary" class="form-label">ប្រាក់ខែ</label>
            <input type="number" name="salary" class="form-control" placeholder="Salary" step="0.01" required>
        </div>
        <div class="col-md-6 mt-2">
            <label for="email" class="form-label">អ៊ីមែល</label>
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>

        <div class="col-md-6 mt-2">
            <label for="phone" class="form-label">លេខទូរស័ព្ទ</label>
            <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
        </div>

        <div class="col-md-6 mt-2">
            <label for="position_id" class="form-label">តួនាទី</label>
            <select name="position_id" class="form-select" required>

                <option value="">-- ជ្រើសរើសតួនាទី --</option>

                @foreach($positions as $position)
                <option value="{{ $position->id }}">
                    {{ $position->name }}
                </option>
                @endforeach

            </select>
        </div>
        <div class="col-md-6 mt-2">
            <label for="password" class="form-label">ពាក្យសំងាត់</label>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <div class="col-md-6 mt-2">
            <label for="password_confirmation" class="form-label">បញ្ជាក់ពាក្យសំងាត់</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password"
                required>
        </div>
        <div class="col-md-6 mt-2">
            <label for="birth_date" class="form-label">ថ្ងៃខែឆ្នាំកំណើត</label>
            <input type="date" name="birth_date" class="form-control" placeholder="Birth Date">
        </div>
        <div class="col-md-6 mt-2">
            <label for="image" class="form-label">រូបថត</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle me-1"></i>Save
            </button>
        </div>

    </form>

</div>

@endsection