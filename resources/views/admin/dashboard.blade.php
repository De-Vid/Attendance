@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<h1 class="mb-4 fw-bold">Dashboard</h1>
<div class="row g-3">
    <div class="col-lg-3 col-md-6">
        <div class="p-3 rounded-4 text-white bg-success shadow-sm d-flex justify-content-between align-items-center">
            <div>
                <div class="fs-2 fw-bold">{{ $stats['total_users'] }}</div>
                <div class="opacity-75">Total Users</div>
            </div>
            <div class="fs-1 opacity-75">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="p-3 rounded-4 text-white bg-danger shadow-sm d-flex justify-content-between align-items-center">
            <div>
                <div class="fs-2 fw-bold">{{ $stats['total_admin'] }}</div>
                <div class="opacity-75">Admins</div>
            </div>
            <div class="fs-1 opacity-75">
                <i class="fas fa-user-shield"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="p-3 rounded-4 text-white bg-primary shadow-sm d-flex justify-content-between align-items-center">
            <div>
                <div class="fs-2 fw-bold">{{ $stats['total_leader'] }}</div>
                <div class="opacity-75">Leaders</div>
            </div>
            <div class="fs-1 opacity-75">
                <i class="fas fa-user-tie"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="p-3 rounded-4 text-dark bg-warning shadow-sm d-flex justify-content-between align-items-center">
            <div>
                <div class="fs-2 fw-bold">{{ $stats['total_staff'] }}</div>
                <div class="opacity-75">Staff</div>
            </div>
            <div class="fs-1 opacity-75">
                <i class="fas fa-user-tag"></i>
            </div>
        </div>
    </div>
</div>

@endsection