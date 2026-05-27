@extends('layouts.app')

@section('title', 'ពិនិត្យវត្តមានបុគ្គលិក')

@section('content')
<div class="container-fluid">

{{-- CARD TOP FILTER --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center g-3">

                {{-- Title (នៅខាងឆ្វេង) --}}
                <div class="mb-3 mb-md-0">
                    <h4 class="fw-bold text-dark mb-1" style="font-family: 'Kantumruy Pro', sans-serif;">
                        <i class="fas fa-user-tie text-success me-2"></i>គ្រប់គ្រងបុគ្គលិក
                    </h4>
                    <p class="text-muted small mb-0">ទំព័រផ្ទៀងផ្ទាត់ឈ្មេាះគ្គលិក</p>
                </div>

                {{-- Button Add New (នៅខាងស្តាំ) --}}
                <div class="text-end">
                    <a href="{{ route('employees.create') }}"
                        class="btn btn-primary rounded-pill px-4 py-2 shadow-sm fw-semibold w-100 w-md-auto">
                        <i class="bi bi-plus-lg me-1"></i>Add New
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">

            {{-- ALERT បង្ហាញព័ត៌មាន ពេលចុចមើលវត្តមានដាច់ដោយឡែករបស់បុគ្គលិកម្នាក់ (UX Standard) --}}
            @if(request()->has('employee_id') && isset($specificEmployee))
            <div class="alert alert-info mx-4 mt-4 rounded-3 d-flex justify-content-between align-items-center border-0 shadow-sm"
                style="background-color: #e0f2fe; color: #0369a1;">
                <div class="fs-15">
                    <i class="bi bi-info-circle-fill me-2 fs-5 align-middle"></i>
                    កំពុងបង្ហាញប្រវត្តវត្តមានទាំងអស់របស់៖ <strong
                        class="text-dark">{{ $specificEmployee->user->name }}</strong> (កូដបុគ្គលិក៖
                    #{{ $specificEmployee->staff_id ?? 'N/A' }})
                </div>
                <a href="{{ route('check_attendances.index') }}" class="btn btn-sm btn-dark rounded-3 px-3">
                    <i class="bi bi-arrow-left me-1"></i> មើលវត្តមានរួមប្រចាំថ្ងៃវិញ
                </a>
            </div>
            @endif

            {{-- 1. បង្ហាញជា TABLE ធម្មតាសម្រាប់តែអេក្រង់ធំ (Desktop/Tablet) --}}
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary" style="font-size: 14px;">
                        <tr>
                            <th class="ps-4 py-3">កូដបុគ្គលិក (Staff ID)</th>
                            <th class="py-3">ឈ្មោះ</th>
                            <th class="py-3">តួនាទី</th>
                            <th class="py-3">អ៊ីមែល</th>
                            <th class="py-3 text-center">QR Code ស្កែន</th>
                            <th class="pe-4 py-3 text-center" style="width: 150px;">សកម្មភាព</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $emp)
                        <tr>
                            <td class="ps-4 fw-semibold text-secondary">
                                #{{ $emp->staff_id }}
                            </td>
                            <td class="fw-bold text-dark">
                                {{ $emp->user->name ?? 'N/A' }}
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1.5 rounded-3 fw-medium">
                                    {{ $emp->user->position->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="text-muted small">
                                {{ $emp->user->email ?? 'N/A' }}
                            </td>
                            <td class="text-center">
                                <div class="mb-1 d-flex justify-content-center">
                                    {!! QrCode::size(50)->generate($emp->scan_code) !!}
                                </div>
                                <small class="text-muted font-monospace" style="font-size: 11px;">
                                    {{ $emp->scan_code }}
                                </small>
                            </td>
                            <td class="pe-4 text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('employees.print', $emp->id) }}" target="_blank"
                                        class="btn btn-outline-primary btn-sm rounded-pill px-2.5 shadow-sm"
                                        title="បោះពុម្ព">
                                        <i class="bi bi-printer"></i>
                                    </a>

                                    <button type="button"
                                        class="btn btn-outline-danger btn-sm rounded-pill px-2.5 shadow-sm"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal{{ $emp->id }}" title="លុប">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <div class="modal fade" id="deleteModal{{ $emp->id }}" tabindex="-1" aria-hidden="true">
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
                                                <h5 class="mt-3 fw-semibold">តើអ្នកពិតជាចង់លុបបុគ្គលិកនេះមែនទេ?</h5>
                                                <p class="text-muted mb-0">ទិន្នន័យរបស់បុគ្គលិកឈ្មោះ <strong
                                                        class="text-dark">{{ $emp->user->name ?? '' }}</strong>
                                                    នឹងមិនអាចយកត្រឡប់វិញបានទេ។</p>
                                            </div>
                                            <div class="modal-footer border-0 justify-content-center pb-4">
                                                <button type="button" class="btn btn-light rounded-pill px-4"
                                                    data-bs-dismiss="modal">បោះបង់</button>
                                                <form action="{{ route('employees.destroy', $emp->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger rounded-pill px-4 shadow-sm">
                                                        <i class="bi bi-trash me-1"></i>លុបចោល
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
                            <td colspan="6" class="text-center text-muted py-5">
                                <i
                                    class="bi bi-inbox fs-3 d-block mb-2 text-secondary"></i>មិនទាន់មានទិន្នន័យបុគ្គលិកឡើយ
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION LINKS (បានកែពី $attendances ទៅ $employees រួចរាល់) --}}
            @if($employees->hasPages())
            <div class="d-flex justify-content-between align-items-center p-4 border-top">
                <div class="text-muted small">
                    បង្ហាញ {{ $employees->firstItem() }} ដល់ {{ $employees->lastItem() }} នៃទិន្នន័យសរុប
                    {{ $employees->total() }} នាក់
                </div>
                <div>
                    {{ $employees->appends(request()->query())->links() }}
                </div>
            </div>
            @endif

        </div>
    </div>

</div>

{{-- CUSTOM INLINE STYLE --}}
<style>
@import url('https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;500;600;700&display=swap');

body {
    background-color: #f8fafc;
}

.table-hover tbody tr:hover {
    background-color: #f8fafc;
}

.avatar-placeholder {
    width: 40px;
    height: 40px;
    background-color: #f1f5f9;
    color: #64748b;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
}

.form-control:focus {
    border-color: #198754;
    box-shadow: none;
}

.style-btn-view {
    font-size: 12px;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.style-btn-view:hover {
    transform: translateY(-1px);
}

.fs-15 {
    font-size: 15px;
}
</style>
@endsection