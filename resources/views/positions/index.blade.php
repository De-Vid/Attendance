@extends('layouts.app')

@section('title', 'ពិនិត្យវត្តមានបុគ្គលិក')

@section('content')
<div class="container-fluid">

    {{-- CARD TOP FILTER --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">

                {{-- Title --}}
                <div class="mb-3 mb-md-0">
                    <h4 class="fw-bold text-dark mb-1" style="font-family: 'Kantumruy Pro', sans-serif;">
                        <i class="fas fa-sitemap text-success me-2"></i>Positions
                    </h4>
                    <p class="text-muted small mb-0">
                        ទំព័រផ្ទៀងផ្ទាត់និងគ្រប់គ្រងតួនាទីរបស់បុគ្គលិកក្នុងក្រុមហ៊ុន
                    </p>
                </div>

                {{-- Button --}}
                <div class="text-end">
                    <a href="{{ route('positions.create') }}"
                        class="btn btn-primary rounded-pill px-4 py-2 shadow-sm fw-semibold">
                        <i class="bi bi-plus-lg me-1"></i> Add New
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">

            {{-- ALERT --}}
            @if(request()->has('employee_id') && isset($specificEmployee))
            <div
                class="alert alert-info mx-4 mt-4 rounded-3 d-flex justify-content-between align-items-center border-0 shadow-sm">
                <div>
                    <i class="bi bi-info-circle-fill me-2"></i>
                    កំពុងបង្ហាញប្រវត្តវត្តមានរបស់៖
                    <strong>{{ $specificEmployee->user->name }}</strong>
                </div>

                <a href="{{ route('positions.index') }}" class="btn btn-sm btn-dark rounded-3 px-3">
                    មើលទាំងអស់
                </a>
            </div>
            @endif

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light text-secondary">
                        <tr>
                            <th>ID</th>
                            <th>Position</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($positions as $position)
                        <tr>

                            <td class="fw-semibold">
                                #{{ $position->id }}
                            </td>

                            <td>
                                <div class="fw-bold">{{ $position->name }}</div>
                            </td>

                            <td>
                                <a href="{{ route('positions.edit', $position->id) }}"
                                    class="btn btn-outline-success btn-sm rounded-pill px-3 me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <button class="btn btn-outline-danger btn-sm rounded-pill px-3" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $position->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>

                                {{-- DELETE MODAL --}}
                                <div class="modal fade" id="deleteModal{{ $position->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 rounded-4 shadow">

                                            <div class="modal-header border-0">
                                                <h5 class="text-danger fw-bold">
                                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                                    បញ្ជាក់ការលុប
                                                </h5>
                                                <button class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body text-center py-4">
                                                <i class="bi bi-trash-fill text-danger fs-1"></i>
                                                <h5 class="mt-3">តើអ្នកពិតជាចង់លុបមែនទេ?</h5>
                                                <p class="text-muted">ទិន្នន័យមិនអាចត្រឡប់វិញបានទេ</p>
                                            </div>

                                            <div class="modal-footer border-0 justify-content-center">
                                                <button class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                                                    បោះបង់
                                                </button>

                                                <form method="POST"
                                                    action="{{ route('positions.destroy', $position->id) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="btn btn-danger rounded-pill px-4">
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
                            <td colspan="3" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                មិនទាន់មានទិន្នន័យ
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- PAGINATION (FIXED) --}}
            @if($positions->hasPages())
            <div class="d-flex justify-content-between align-items-center p-4 border-top">

                <div class="text-muted small">
                    បង្ហាញ {{ $positions->firstItem() }}
                    ដល់ {{ $positions->lastItem() }}
                    នៃ {{ $positions->total() }} ទិន្នន័យ
                </div>

                <div>
                    {{ $positions->appends(request()->query())->links() }}
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
}

.table-hover tbody tr:hover {
    background-color: #f1f5f9;
}
</style>
@endsection