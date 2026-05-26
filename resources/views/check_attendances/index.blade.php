@extends('layouts.app')

@section('title', 'ពិនិត្យវត្តមានបុគ្គលិក')

@section('content')
<div class="container-fluid">

    {{-- CARD TOP FILTER --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">

                {{-- Title --}}
                <div class="col-md-4">
                    <h4 class="fw-bold text-dark mb-1" style="font-family: 'Kantumruy Pro', sans-serif;">
                        <i class="fas fa-calendar-check text-success me-2"></i>ពិនិត្យវត្តមានបុគ្គលិក
                    </h4>
                    <p class="text-muted small mb-0">ទំព័រផ្ទៀងផ្ទាត់ និងតាមដានវត្តមានស្កែនប្រចាំថ្ងៃ</p>
                </div>

                {{-- Filter & Search Form --}}
                <div class="col-md-8">
                    <form method="GET" action="{{ route('check_attendances.index') }}"
                        class="row g-2 justify-content-md-end">

                        {{-- រក្សាទុក employee_id ក្នុងទម្រង់ hidden បើកំពុងមើលវត្តមានបុគ្គលិកម្នាក់ៗ --}}
                        @if(request('employee_id'))
                        <input type="hidden" name="employee_id" value="{{ request('employee_id') }}">
                        @endif

                        {{-- Search Input --}}
                        <div class="col-sm-5 col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i
                                        class="bi bi-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control bg-light border-start-0"
                                    placeholder="ស្វែងរកឈ្មោះបុគ្គលិក..." value="{{ request('search') }}">
                            </div>
                        </div>

                        {{-- Date Input (លាក់ ឬអសកម្ម ពេលកំពុងមើលវត្តមានទាំងអស់របស់បុគ្គលិកម្នាក់) --}}
                        <div class="col-sm-4 col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i
                                        class="bi bi-calendar3 text-muted"></i></span>
                                <input type="date" name="date" class="form-control bg-light border-start-0"
                                    value="{{ request('date', date('Y-m-d')) }}" @if(request('employee_id')) disabled
                                    title="សូមត្រឡប់ទៅមើលទំពររួមវិញដើម្បីចម្រោះតាមថ្ងៃ" @endif
                                    onchange="this.form.submit()">
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="col-sm-3 col-md-2">
                            <button type="submit" class="btn btn-success w-100 fw-semibold">
                                <i class="bi bi-arrow-clockwise me-1"></i> ស្វែងរក
                            </button>
                        </div>

                    </form>
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

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary" style="font-size: 14px;">
                        <tr>
                            <th class="ps-4 py-3">កូដបុគ្គលិក (Staff ID)</th>
                            <th class="py-3">ឈ្មោះ និងអ៊ីមែល</th>
                            <th class="py-3">កាលបរិច្ឆេទ</th>
                            <th class="py-3">ម៉ោងស្កែន</th>
                            <th class="py-3">ស្ថានភាព</th>
                            <th class="pe-4 py-3 text-end">ប្រភេទសកម្មភាព</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        <tr>
                            {{-- Staff ID --}}
                            <td class="ps-4 text-secondary fw-semibold">
                                #{{ $attendance->employee->staff_id ?? 'N/A' }}
                            </td>

                            {{-- Employee Profiling + Action View All Button --}}
                            <td>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-placeholder me-3">
                                            {{ mb_substr($attendance->employee->user->name ?? 'U', 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">
                                                {{ $attendance->employee->user->name ?? 'មិនស្គាល់' }}</h6>
                                            <span
                                                class="text-muted small">{{ $attendance->employee->user->email ?? '' }}</span>
                                        </div>
                                    </div>

                                    {{-- ប៊ូតុងមើលវត្តមានទាំងអស់សម្រាប់បុគ្គលិកម្នាក់នេះ (បង្ហាញតែពេលស្ថិតក្នុងទំព័ររួម) --}}
                                    @if(!request()->has('employee_id') && isset($attendance->employee))
                                    <a href="{{ route('check_attendances.index', ['employee_id' => $attendance->employee_id]) }}"
                                        class="btn btn-sm btn-outline-primary rounded-3 px-2 py-1 me-4 style-btn-view"
                                        title="មើលប្រវត្តវត្តមានទាំងអស់របស់បុគ្គលិកនេះ">
                                        <i class="bi bi-eye-fill me-1"></i> មើលទាំងអស់
                                    </a>
                                    @endif
                                </div>
                            </td>

                            {{-- Date --}}
                            <td class="text-secondary">
                                {{ \Carbon\Carbon::parse($attendance->date)->format('d-M-Y') }}
                            </td>

                            {{-- Scanned At --}}
                            <td class="fw-medium text-dark">
                                <i class="bi bi-clock-history me-1 text-muted"></i>
                                {{ \Carbon\Carbon::parse($attendance->scanned_at)->format('H:i:s A') }}
                            </td>

                            {{-- Status Badge --}}
                            <td>
                                @php
                                $statusStyle = 'bg-secondary-subtle text-secondary';
                                if (str_contains($attendance->status, 'មកយឺត')) {
                                $statusStyle = 'bg-danger-subtle text-danger border border-danger-subtle';
                                } elseif (str_contains($attendance->status, 'ចេញទាន់ពេល') ||
                                str_contains($attendance->status, '08:')) {
                                $statusStyle = 'bg-success-subtle text-success border border-success-subtle';
                                } elseif (str_contains($attendance->status, 'ចេញមុនម៉ោង')) {
                                $statusStyle = 'bg-warning-subtle text-warning-emphasis border border-warning-subtle';
                                }
                                @endphp
                                <span class="badge px-3 py-2 rounded-pill fw-semibold {{ $statusStyle }}">
                                    {{ $attendance->status }}
                                </span>
                            </td>

                            {{-- Attendance Type Badge --}}
                            <td class="pe-4 text-end">
                                @if($attendance->attendance_type_id == 1 || $attendance->attendance_type_id == 3)
                                <span
                                    class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-3 px-2 py-1">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Scan In (ចូល)
                                </span>
                                @else
                                <span
                                    class="badge bg-info-subtle text-info-emphasis border border-info-subtle rounded-3 px-2 py-1">
                                    <i class="bi bi-box-arrow-left me-1"></i> Scan Out (ចេញ)
                                </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class="bi bi-folder-x fs-1 text-muted d-block mb-3"></i>
                                    <p class="mb-0 fw-medium" style="font-family: 'Kantumruy Pro', sans-serif;">
                                        មិនមានទិន្នន័យវត្តមានឡើយ</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION LINKS --}}
            @if($attendances->hasPages())
            <div class="d-flex justify-content-between align-items-center p-4 border-top">
                <div class="text-muted small">
                    បង្ហាញ {{ $attendances->firstItem() }} ដល់ {{ $attendances->lastItem() }} នៃទិន្នន័យសរុប
                    {{ $attendances->total() }}
                </div>
                <div>
                    {{ $attendances->appends(request()->query())->links() }}
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