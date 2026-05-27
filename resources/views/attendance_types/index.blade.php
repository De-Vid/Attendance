@extends('layouts.app')

@section('title', 'ពិនិត្យមើលម៉េាង')

@section('content')
<div class="container-fluid">

    {{-- CARD TOP FILTER --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">

                {{-- Title --}}
                <div class="mb-3 mb-md-0">
                    <h4 class="fw-bold text-dark mb-1" style="font-family: 'Kantumruy Pro', sans-serif;">
                        <i class="fas fa-calendar-alt text-success me-2"></i>Set Days
                    </h4>
                    <p class="text-muted small mb-0">
                        ទំព័រផ្ទៀងផ្ទាត់ការកំណត់ម៉េាង
                    </p>
                </div>

                {{-- Button --}}
                <div class="text-end">
                    <a href="{{ route('attendance_types.create') }}"
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

                <a href="{{ route('attendance-settings.index') }}" class="btn btn-sm btn-dark rounded-3 px-3">
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
                            <th>Name</th>
                            <th>Label</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($settings_type as $setting)
                        <tr>
                            <td class="fw-semibold">{{ $setting->id }}</td>
                            <td>{{ $setting->name }}</td>
                            <td>{{ $setting->label }}</td>
                            <td>
                                <a href="{{ route('attendance_types.edit', $setting->id) }}"
                                    class="btn btn-outline-success btn-sm rounded-pill px-3 shadow-sm me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{ $setting->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>

                                <div class="modal fade" id="deleteModal{{ $setting->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 rounded-4 shadow">
                                            <div class="modal-header border-0">
                                                <h5 class="modal-title fw-bold text-danger">
                                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>បញ្ជាក់ការលុប
                                                </h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center py-4">
                                                <i class="bi bi-trash-fill text-danger" style="font-size: 55px;"></i>
                                                <h5 class="mt-3 fw-semibold">តើអ្នកពិតជាចង់លុបមែនទេ?</h5>
                                                <p class="text-muted mb-0">ទិន្នន័យនេះនឹងមិនអាចយកត្រឡប់វិញបានទេ។</p>
                                            </div>

                                            <div class="modal-footer border-0 justify-content-center pb-4">
                                                <button type="button" class="btn btn-light rounded-pill px-4"
                                                    data-bs-dismiss="modal">
                                                    បោះបង់
                                                </button>
                                                <form action="{{ route('attendance_types.destroy', $setting->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger rounded-pill px-4 shadow-sm">
                                                        <i class="bi bi-trash me-1"></i>លុប
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
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>មិនទាន់មានទិន្នន័យ
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- PAGINATION (FIXED) --}}
            @if($settings_type->hasPages())
            <div class="d-flex justify-content-between align-items-center p-4 border-top">

                <div class="text-muted small">
                    បង្ហាញ {{ $settings_type->firstItem() }}
                    ដល់ {{ $settings_type->lastItem() }}
                    នៃ {{ $settings_type->total() }} ទិន្នន័យ
                </div>

                <div>
                    {{ $settings_type->appends(request()->query())->links() }}
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