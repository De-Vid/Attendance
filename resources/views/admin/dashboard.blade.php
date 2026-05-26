@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<h1 class="mb-4 fw-bold">Dashboard</h1>

<div class="row g-3">

    <!-- Total Users -->
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card bg-green-card p-3">

            <div class="icon">
                <i class="fas fa-users"></i>
            </div>

            <div class="count">
                {{ $stats['total_users'] }}
            </div>

            <div class="title">
                Total Users
            </div>

        </div>
    </div>

    <!-- Admin -->
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card bg-red-card p-3">

            <div class="icon">
                <i class="fas fa-user-shield"></i>
            </div>

            <div class="count">
                {{ $stats['total_admin'] }}
            </div>

            <div class="title">
                Total Admins
            </div>

        </div>
    </div>

    <!-- Leader -->
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card bg-blue-card p-3">

            <div class="icon">
                <i class="fas fa-user"></i>
            </div>

            <div class="count">
                {{ $stats['total_leader'] }}
            </div>

            <div class="title">
                Regular Users
            </div>

        </div>
    </div>

</div>

@endsection