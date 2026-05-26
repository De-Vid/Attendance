@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="container-fluid bg-white p-4 rounded-4 shadow-sm">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">បញ្ជីបុគ្គលិក</h4>
        </div>
        <a href="{{ route('employees.create') }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm fw-semibold">
            <i class="bi bi-plus-square me-1"></i>Add New
        </a>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>អត្តលេខ</th>
                    <th>ឈ្មោះ</th>
                    <th>Role</th>
                    <th>Position</th>
                    <th>Email</th>
                    <th class="text-center">QR Code</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                <tr>
                    <td class="fw-semibold">
                        {{ $emp->staff_id }}
                    </td>
                    <td>
                        {{ $emp->user->name ?? 'N/A' }}
                    </td>
                    <td>
                        {{ $emp->user->role ?? 'N/A' }}
                    </td>
                    <td>
                        {{ $emp->user->position->name ?? 'N/A' }}
                    </td>
                    <td>
                        {{ $emp->user->email ?? 'N/A' }}
                    </td>
                    <td class="text-center">
                        <div class="mb-2">
                            {!! QrCode::size(50)->generate($emp->scan_code) !!}
                        </div>
                        <small class="text-muted">
                            {{ $emp->scan_code }}
                        </small>
                    </td>
                    <td class="text-center">

                        <!-- Delete Button -->
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm"
                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $emp->id }}">

                            <i class="bi bi-trash"></i>

                        </button>

                        <a href="{{ route('employees.print', $emp->id) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm me-1">
                            <i class="bi bi-printer"></i>
                        </a>

                        <!-- Modal -->
                        <div class="modal fade" id="deleteModal{{ $emp->id }}" tabindex="-1" aria-hidden="true">

                            <div class="modal-dialog modal-dialog-centered">

                                <div class="modal-content border-0 rounded-4 shadow">

                                    <div class="modal-header border-0">

                                        <h5 class="modal-title fw-bold text-danger">
                                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                            បញ្ជាក់ការលុប
                                        </h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                        </button>

                                    </div>

                                    <div class="modal-body text-center py-4">

                                        <i class="bi bi-trash-fill text-danger" style="font-size: 55px;"></i>

                                        <h5 class="mt-3 fw-semibold">
                                            តើអ្នកពិតជាចង់លុបមែនទេ?
                                        </h5>

                                        <p class="text-muted mb-0">
                                            ទិន្នន័យនេះនឹងមិនអាចយកត្រឡប់វិញបានទេ។
                                        </p>

                                    </div>

                                    <div class="modal-footer border-0 justify-content-center pb-4">

                                        <button type="button" class="btn btn-light rounded-pill px-4"
                                            data-bs-dismiss="modal">

                                            បោះបង់

                                        </button>

                                        <form action="{{ route('employees.destroy', $emp->id) }}" method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger rounded-pill px-4 shadow-sm">

                                                <i class="bi bi-trash me-1"></i>
                                                លុប

                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </td>
                </tr>

                @empty

                <tr>

                    <td colspan="4" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>មិនទាន់មានបុគ្គលិក
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-end mt-4">
        {{ $employees->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>

@endsection