{{-- resources/views/leader/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Leader Dashboard')

@section('content')
<div class="container-fluid">
    <div class="dash-wrap">
        @php
        $myTotal = \App\Models\Leave::where('user_id', Auth::id())->count();
        $myApproved = \App\Models\Leave::where('user_id', Auth::id())->where('status','approved')->count();

        $staffPending = \App\Models\Leave::whereHas('user', fn($q) =>
        $q->where('role','staff'))->where('status','pending')->count();
        $staffApproved = \App\Models\Leave::whereHas('user', fn($q) =>
        $q->where('role','staff'))->where('status','approved')->count();
        $staffRejected = \App\Models\Leave::whereHas('user', fn($q) =>
        $q->where('role','staff'))->where('status','rejected')->count();
        $staffTotal = $staffPending + $staffApproved + $staffRejected;
        @endphp

        {{-- ── Alert pending ── --}}
        @if($staffPending > 0)
        <div class="pending-alert">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg>
            មានការស្នើរសុំ <strong>{{ $staffPending }}</strong> កំពុងរង់ចាំការអនុម័តពីអ្នក
            <a href="{{ route('leader.leaves.index', ['status'=>'pending']) }}">ចូលមើល →</a>
        </div>
        @endif

        {{-- ── Staff Stats ── --}}
        <p class="section-label">ការស្នើរសុំ Staff</p>
        <div class="stats-row row g-3">

            <!-- Total Staff -->
            <div class="col-md-3 w-100">
                <div class="stat-box bg-primary text-white p-3 rounded shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8"
                                viewBox="0 0 24 24">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold">{{ $staffTotal }}</div>
                            <div>សរុប Staff</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending -->
            <div class="col-md-3 w-100">
                <div class="stat-box bg-warning text-dark p-3 rounded shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold">
                                {{ $staffPending }}
                            </div>
                            <div>រង់ចាំ</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Approved -->
            <div class="col-md-3 w-100">
                <div class="stat-box bg-success text-white p-3 rounded shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8"
                                viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold">{{ $staffApproved }}</div>
                            <div>បានអនុម័ត</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rejected -->
            <div class="col-md-3 w-100">
                <div class="stat-box bg-danger text-white p-3 rounded shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="15" y1="9" x2="9" y2="15" />
                                <line x1="9" y1="9" x2="15" y2="15" />
                            </svg>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold">{{ $staffRejected }}</div>
                            <div>បានបដិសេធ</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── My Leaves Stats ── --}}
        <p class="section-label">ច្បាប់ខ្លួនឯង</p>
        <div class="stats-row row g-3">

            <!-- Total Leave -->
            <div class="col-md-6 w-100">
                <div class="stat-box bg-secondary text-white p-3 rounded shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8"
                                viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold">{{ $myTotal }}</div>
                            <div>ច្បាប់ខ្ញុំ (សរុប)</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Approved Leave -->
            <div class="col-md-6 w-100">
                <div class="stat-box bg-info text-white p-3 rounded shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8"
                                viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold">{{ $myApproved }}</div>
                            <div>ច្បាប់ខ្ញុំ (អនុម័ត)</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="bottom-grid">

            {{-- ── Pending requests ── --}}
            <div class="section-card">
                <div class="section-head">
                    <h2 class="section-title">
                        ⏳ Staff រង់ចាំអនុម័ត
                        @if($staffPending > 0)
                        <span class="count-badge">{{ $staffPending }}</span>
                        @endif
                    </h2>
                    <a href="{{ route('leader.leaves.index') }}" class="see-all">មើលទាំងអស់ →</a>
                </div>

                @php
                $pendingLeaves = \App\Models\Leave::with('user')
                ->whereHas('user', fn($q) => $q->where('role','staff'))
                ->where('status','pending')
                ->orderBy('created_at','asc')
                ->take(5)->get();
                @endphp

                @if($pendingLeaves->count())
                <div class="leave-list">
                    @foreach($pendingLeaves as $leave)
                    <div class="leave-item">
                        <div class="mini-avatar">{{ strtoupper(substr($leave->user->name,0,1)) }}</div>
                        <div class="li-info">
                            <span class="li-name">{{ $leave->user->name }}</span>
                            <span class="li-date">{{ $leave->getTypeLabel() }} · {{ $leave->total_days }} ថ្ងៃ</span>
                        </div>
                        <span class="li-ago">{{ $leave->created_at->diffForHumans() }}</span>
                        <a href="{{ route('leader.leaves.show', $leave) }}" class="btn-review">អនុម័ត</a>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-dash">
                    <svg width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24"
                        opacity=".3">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                    <p>មិនមានការស្នើរសុំរង់ចាំ</p>
                </div>
                @endif
            </div>

            {{-- ── Quick actions ── --}}
            <div class="side-col">
                <div class="section-card" style="margin-bottom:1rem">
                    <h2 class="section-title" style="margin-bottom:1rem">សកម្មភាពរហ័ស</h2>
                    <div class="quick-stack">
                        <a href="{{ route('leader.leaves.index', ['status'=>'pending']) }}" class="quick-row qr-amber">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                            <span>ច្បាប់រង់ចាំ ({{ $staffPending }})</span>
                        </a>
                        <a href="{{ route('leader.leaves.index', ['status'=>'approved']) }}" class="quick-row qr-green">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                            <span>ច្បាប់បានអនុម័ត</span>
                        </a>
                        <a href="{{ route('leader.leaves.index') }}" class="quick-row qr-blue">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <line x1="8" y1="6" x2="21" y2="6" />
                                <line x1="8" y1="12" x2="21" y2="12" />
                                <line x1="8" y1="18" x2="21" y2="18" />
                                <line x1="3" y1="6" x2="3.01" y2="6" />
                                <line x1="3" y1="12" x2="3.01" y2="12" />
                                <line x1="3" y1="18" x2="3.01" y2="18" />
                            </svg>
                            <span>ច្បាប់ Staff ទាំងអស់</span>
                        </a>
                    </div>
                </div>

                {{-- Progress ring --}}
                <div class="section-card approve-rate-card">
                    <h2 class="section-title" style="margin-bottom:.8rem">អត្រាអនុម័ត</h2>
                    @php
                    $rate = $staffTotal > 0 ? round(($staffApproved / $staffTotal) * 100) : 0;
                    $circumference = 2 * 3.14159 * 36;
                    $offset = $circumference - ($rate / 100) * $circumference;
                    @endphp
                    <div class="ring-wrap">
                        <svg width="90" height="90" viewBox="0 0 90 90">
                            <circle cx="45" cy="45" r="36" fill="none" stroke="#f3f4f6" stroke-width="8" />
                            <circle cx="45" cy="45" r="36" fill="none" stroke="#22c55e" stroke-width="8"
                                stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $offset }}"
                                stroke-linecap="round" transform="rotate(-90 45 45)" />
                            <text x="45" y="49" text-anchor="middle" font-size="16" font-weight="700"
                                fill="#111827">{{ $rate }}%</text>
                        </svg>
                        <div class="ring-label">
                            <span>{{ $staffApproved }} / {{ $staffTotal }}</span>
                            <span>អនុម័ត / សរុប</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Hanuman:wght@400;700&family=Noto+Sans+Khmer:wght@300;400;600&display=swap');

* {
    box-sizing: border-box;
}

/* Greeting */

/* Alert */
.pending-alert {
    display: flex;
    align-items: center;
    gap: .6rem;
    background: #6495ED;
    border: 1px solid #090909;
    border-radius: 10px;
    padding: .75rem 1rem;
    margin-bottom: 1.3rem;
    font-size: .88rem;
    color: white;
    flex-wrap: wrap;
}

.pending-alert strong {
    font-weight: 700;
}

.pending-alert a {
    margin-left: auto;
    color: white;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
}

.pending-alert a:hover {
    text-decoration: underline;
}


/* Stats */
.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: .9rem;
    margin-bottom: 1.3rem;
}

.stat-box {
    background: #fff;
    border-radius: 14px;
    padding: 1.1rem 1.2rem;
    display: flex;
    align-items: center;
    gap: .9rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, .05), 0 4px 14px rgba(0, 0, 0, .04);
    border: 1px solid #f1f5f9;
    transition: transform .2s;
    position: relative;
    overflow: hidden;
}

.stat-box:hover {
    transform: translateY(-2px);
}

.sb-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.sb-slate .sb-icon {
    background: #f8fafc;
    color: #475569;
}

.sb-amber .sb-icon {
    background: #fffbeb;
    color: #f59e0b;
}

.sb-green .sb-icon {
    background: #f0fdf4;
    color: #22c55e;
}

.sb-red .sb-icon {
    background: #fef2f2;
    color: #ef4444;
}

.sb-indigo .sb-icon {
    background: #eef2ff;
    color: #6366f1;
}

.sb-num {
    display: block;
    font-size: 1.8rem;
    font-weight: 700;
    line-height: 1.1;
}

.sb-label {
    font-size: .78rem;
    color: #6b7280;
    margin-top: .1rem;
    display: block;
}

.sb-slate .sb-num {
    color: #334155;
}

.sb-amber .sb-num {
    color: #d97706;
}

.sb-green .sb-num {
    color: #16a34a;
}

.sb-red .sb-num {
    color: #dc2626;
}

.sb-indigo .sb-num {
    color: #4f46e5;
}

/* Pulse dot */
.pulse-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #f59e0b;
    margin-left: .4rem;
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes pulse {

    0%,
    100% {
        opacity: 1;
        transform: scale(1)
    }

    50% {
        opacity: .5;
        transform: scale(1.4)
    }
}

/* Bottom grid */
.bottom-grid {
    display: grid;
    grid-template-columns: 1fr 280px;
    gap: 1rem;
}

@media (max-width: 720px) {
    .bottom-grid {
        grid-template-columns: 1fr;
    }
}

/* Section card */
.section-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, .05), 0 4px 14px rgba(0, 0, 0, .04);
    border: 1px solid #f1f5f9;
}

.section-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.section-title {
    font-size: .95rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: .5rem;
}

.count-badge {
    background: #fef3c7;
    color: #92400e;
    border-radius: 20px;
    padding: .1rem .55rem;
    font-size: .75rem;
    font-weight: 700;
}

.see-all {
    font-size: .82rem;
    color: #6366f1;
    text-decoration: none;
    font-weight: 600;
}

.see-all:hover {
    text-decoration: underline;
}

/* Leave list */
.leave-list {
    display: flex;
    flex-direction: column;
    gap: .55rem;
}

.leave-item {
    display: flex;
    align-items: center;
    gap: .8rem;
    padding: .7rem .85rem;
    background: #fafafa;
    border-radius: 10px;
    border: 1px solid #f1f5f9;
    transition: background .15s;
}

.leave-item:hover {
    background: #fefce8;
}

.mini-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #0f172a;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .8rem;
    font-weight: 700;
    flex-shrink: 0;
}

.li-info {
    flex: 1;
    min-width: 0;
}

.li-name {
    display: block;
    font-size: .86rem;
    font-weight: 600;
    color: #0f172a;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.li-date {
    display: block;
    font-size: .76rem;
    color: #9ca3af;
    margin-top: .1rem;
}

.li-ago {
    font-size: .75rem;
    color: #94a3b8;
    white-space: nowrap;
}

.btn-review {
    display: inline-block;
    padding: .28rem .7rem;
    background: #fef3c7;
    color: #92400e;
    border-radius: 8px;
    font-size: .78rem;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
    transition: all .2s;
}

.btn-review:hover {
    background: #fde68a;
}

.empty-dash {
    text-align: center;
    padding: 2rem;
    color: #9ca3af;
    font-size: .88rem;
}

/* Quick stack */
.quick-stack {
    display: flex;
    flex-direction: column;
    gap: .5rem;
}

.quick-row {
    display: flex;
    align-items: center;
    gap: .65rem;
    padding: .7rem .85rem;
    border-radius: 10px;
    text-decoration: none;
    font-size: .85rem;
    font-weight: 600;
    transition: all .15s;
    border: 1px solid transparent;
}

.quick-row:hover {
    transform: translateX(3px);
}

.qr-amber {
    color: #92400e;
    background: #fffbeb;
    border-color: #fde68a;
}

.qr-amber:hover {
    background: #fef3c7;
}

.qr-green {
    color: #166534;
    background: #f0fdf4;
    border-color: #bbf7d0;
}

.qr-green:hover {
    background: #dcfce7;
}

.qr-blue {
    color: #1e40af;
    background: #eff6ff;
    border-color: #bfdbfe;
}

.qr-blue:hover {
    background: #dbeafe;
}

/* Approve rate */
.approve-rate-card .ring-wrap {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.ring-label {
    display: flex;
    flex-direction: column;
}

.ring-label span:first-child {
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
}

.ring-label span:last-child {
    font-size: .76rem;
    color: #9ca3af;
    margin-top: .2rem;
}

@media (max-width: 600px) {
    .stats-row {
        grid-template-columns: 1fr 1fr;
    }
}
</style>
@endpush