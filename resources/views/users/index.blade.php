@extends('layouts.app')

@section('title', 'User Roles & Permissions')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div class="mb-3 mb-md-0">
                    <h4 class="fw-bold text-dark mb-1" style="font-family: 'Kantumruy Pro', sans-serif;">
                        <i class="fas fa-users text-success me-2"></i>User Roles
                    </h4>
                    <p class="text-muted small mb-0">
                        ទំព័រផ្ទៀងផ្ទាត់ការគ្រប់គ្រងតួនាទីនៃអ្នកប្រើប្រាស់
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            @if(request()->has('employee_id') && isset($specificEmployee))
            <div
                class="alert alert-info mx-4 mt-4 rounded-3 d-flex justify-content-between align-items-center border-0 shadow-sm">
                <div>
                    <i class="bi bi-info-circle-fill me-2"></i>កំពុងបង្ហាញប្រវត្តវត្តមានរបស់៖
                    <strong>{{ $specificEmployee->user->name }}</strong>
                </div>

                <a href="{{ route('users.index') }}" class="btn btn-sm btn-dark rounded-3 px-3">
                    មើលទាំងអស់
                </a>
            </div>

            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th width="300">Update Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <form id="updateRoleForm{{ $user->id }}" action="{{ route('users.updateRole', $user->id) }}" method="POST" class="d-flex gap-2 align-items-center">

                                    @csrf

                                    <select name="role" class="form-select form-select-sm">
                                        <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>
                                            Staff
                                        </option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                                            Admin
                                        </option>
                                        <option value="leader" {{ $user->role == 'leader' ? 'selected' : '' }}>
                                            Leader
                                        </option>
                                    </select>

                                    <button type="button" class="btn btn-success btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $user->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </form>

                                <div class="modal fade" id="confirmModal{{ $user->id }}" tabindex="-1" aria-labelledby="confirmModalLabel{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow rounded-4">
                                            <div class="modal-header bg-success text-white border-0">
                                                <h5 class="modal-title" id="confirmModalLabel{{ $user->id }}">
                                                    <i class="bi bi-shield-check me-2"></i>បញ្ជាក់ការផ្លាស់ប្តូរ
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body text-center py-4">
                                                <i class="bi bi-exclamation-circle-fill text-warning fs-1 mb-3 d-block"></i>
                                                <h5 class="fw-bold mb-3">
                                                    តើអ្នកពិតជាចង់ Update Role មែនទេ?
                                                </h5>
                                                <p class="text-muted mb-1">
                                                    User:
                                                    <strong>{{ $user->name }}</strong>
                                                </p>
                                                <p class="text-muted mb-0">
                                                    Current Role:
                                                    <strong>
                                                        {{ ucfirst($user->role) }}
                                                    </strong>
                                                </p>
                                            </div>

                                            <div class="modal-footer border-0 justify-content-center pb-4">
                                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                                                    បោះបង់
                                                </button>

                                                {{-- CONFIRM --}}
                                                <button type="submit" form="updateRoleForm{{ $user->id }}" class="btn btn-success rounded-pill px-4">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    បាទ/ចាស Update
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        @empty

                        <tr>

                            <td colspan="4" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                មិនទាន់មានទិន្នន័យ
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if($users->hasPages())

            <div class="d-flex justify-content-between align-items-center p-4 border-top">
                <div class="text-muted small">
                    បង្ហាញ {{ $users->firstItem() }}
                    ដល់ {{ $users->lastItem() }}
                    នៃ {{ $users->total() }} ទិន្នន័យ
                </div>
                <div>
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
{{-- STYLE --}}
<style>
@import url('https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;600;700&display=swap');

body {
    background-color: #f8fafc;
    font-family: 'Kantumruy Pro', sans-serif;
}

.table-hover tbody tr:hover {
    background-color: #f1f5f9;
    transition: 0.2s;
}

.modal-content {
    animation: modalFade 0.3s ease;
}

@keyframes modalFade {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }

    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>
@endsection