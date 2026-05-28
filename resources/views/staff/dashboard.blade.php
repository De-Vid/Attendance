{{-- resources/views/staff/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Staff Dashboard')

@section('content')
<div class="container-fluid">
    <div class="dash-wrap">

    {{-- ── Greeting ── --}}
    <div class="greeting-bar">
        <a href="{{ route('staff.leaves.create') }}" class="btn-request">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            ស្នើរសុំច្បាប់
        </a>
    </div>

    {{-- ── Stats ── --}}
    @php
        $total    = \App\Models\Leave::where('user_id', Auth::id())->count();
        $pending  = \App\Models\Leave::where('user_id', Auth::id())->where('status','pending')->count();
        $approved = \App\Models\Leave::where('user_id', Auth::id())->where('status','approved')->count();
        $rejected = \App\Models\Leave::where('user_id', Auth::id())->where('status','rejected')->count();
    @endphp

    <div class="stats-row">
        <div class="stat-box sb-blue">
            <div class="sb-icon">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div class="sb-body">
                <span class="sb-num">{{ $total }}</span>
                <span class="sb-label">សរុបច្បាប់</span>
            </div>
        </div>
        <div class="stat-box sb-amber">
            <div class="sb-icon">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="sb-body">
                <span class="sb-num">{{ $pending }}</span>
                <span class="sb-label">កំពុងរង់ចាំ</span>
            </div>
        </div>
        <div class="stat-box sb-green">
            <div class="sb-icon">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="sb-body">
                <span class="sb-num">{{ $approved }}</span>
                <span class="sb-label">បានអនុម័ត</span>
            </div>
        </div>
        <div class="stat-box sb-red">
            <div class="sb-icon">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div class="sb-body">
                <span class="sb-num">{{ $rejected }}</span>
                <span class="sb-label">បានបដិសេធ</span>
            </div>
        </div>
    </div>

    {{-- ── Recent Leaves ── --}}
    <div class="section-card">
        <div class="section-head">
            <h2 class="section-title">ច្បាប់ចុងក្រោយ</h2>
            <a href="{{ route('staff.leaves.index') }}" class="see-all">មើលទាំងអស់ →</a>
        </div>

        @php
            $recentLeaves = \App\Models\Leave::where('user_id', Auth::id())
                ->orderBy('created_at','desc')->take(5)->get();
        @endphp

        @if($recentLeaves->count())
        <div class="leave-list">
            @foreach($recentLeaves as $leave)
            <div class="leave-item">
                <div class="li-type type-{{ $leave->type }}">
                    @if($leave->type === 'annual') 🗓
                    @elseif($leave->type === 'sick') 🏥
                    @elseif($leave->type === 'personal') 👤
                    @else 💰
                    @endif
                </div>
                <div class="li-info">
                    <span class="li-name">{{ $leave->getTypeLabel() }}</span>
                    <span class="li-date">{{ $leave->start_date->format('d/m/Y') }} — {{ $leave->end_date->format('d/m/Y') }}</span>
                </div>
                <div class="li-days">{{ $leave->total_days }} ថ្ងៃ</div>
                <span class="li-badge {{ $leave->getStatusBadgeClass() }}">
                    @if($leave->status === 'pending') រង់ចាំ
                    @elseif($leave->status === 'approved') អនុម័ត
                    @else បដិសេធ
                    @endif
                </span>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-dash">
            <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24" opacity=".3"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <p>មិនទាន់មានច្បាប់នៅឡើយ</p>
            <a href="{{ route('staff.leaves.create') }}" class="btn-request" style="margin-top:.6rem">ស្នើរសុំដំបូង</a>
        </div>
        @endif
    </div>


</div>
</div>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Hanuman:wght@400;700&family=Noto+Sans+Khmer:wght@300;400;600&display=swap');

* { box-sizing: border-box; }
.dash-wrap { max-width: 100%; margin: 0 auto; padding: 1.5rem; font-family: 'Noto Sans Khmer', sans-serif; }

/* Greeting */
.greeting-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.8rem; gap: 1rem; flex-wrap: wrap; }
.greeting-left { display: flex; align-items: center; gap: 1rem; }
.avatar-ring { width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg,#6366f1,#8b5cf6); display: flex; align-items: center; justify-content: center; box-shadow: 0 0 0 3px #fff, 0 0 0 5px #e0e7ff; }
.avatar-letter { color: #fff; font-size: 1.3rem; font-weight: 700; line-height: 1; }
.greeting-sub  { margin: 0; font-size: .8rem; color: #9ca3af; letter-spacing: .03em; }
.greeting-name { margin: .1rem 0 0; font-size: 1.35rem; font-weight: 700; color: #111827; font-family: 'Hanuman', serif; }

.btn-request { display: inline-flex; align-items: center; gap: .4rem; background: #4f46e5; color: #fff; padding: .6rem 1.2rem; border-radius: 10px; font-weight: 600; text-decoration: none; font-size: .88rem; transition: all .2s; box-shadow: 0 4px 12px rgba(79,70,229,.3); }
.btn-request:hover { background: #4338ca; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(79,70,229,.35); }

/* Stats */
.stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
.stat-box { background: #fff; border-radius: 14px; padding: 1.2rem 1.3rem; display: flex; align-items: center; gap: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.05); border: 1px solid #f3f4f6; transition: transform .2s; }
.stat-box:hover { transform: translateY(-2px); }
.sb-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.sb-blue  .sb-icon { background: #eff6ff; color: #3b82f6; }
.sb-amber .sb-icon { background: #fffbeb; color: #f59e0b; }
.sb-green .sb-icon { background: #f0fdf4; color: #22c55e; }
.sb-red   .sb-icon { background: #fef2f2; color: #ef4444; }
.sb-num   { display: block; font-size: 1.8rem; font-weight: 700; line-height: 1.1; color: #111827; }
.sb-label { font-size: .8rem; color: #6b7280; margin-top: .1rem; display: block; }
.sb-blue  .sb-num { color: #2563eb; }
.sb-amber .sb-num { color: #d97706; }
.sb-green .sb-num { color: #16a34a; }
.sb-red   .sb-num { color: #dc2626; }

/* Section card */
.section-card { background: #fff; border-radius: 16px; padding: 1.3rem; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.05); border: 1px solid #f3f4f6; margin-bottom: 1.2rem; }
.section-head  { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
.section-title { font-size: 1rem; font-weight: 700; color: #111827; margin: 0; }
.see-all { font-size: .82rem; color: #6366f1; text-decoration: none; font-weight: 600; }
.see-all:hover { text-decoration: underline; }

/* Leave list */
.leave-list { display: flex; flex-direction: column; gap: .6rem; }
.leave-item { display: flex; align-items: center; gap: .9rem; padding: .75rem .9rem; background: #fafafa; border-radius: 10px; border: 1px solid #f3f4f6; transition: background .15s; }
.leave-item:hover { background: #f5f3ff; }
.li-type { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
.type-annual   .li-type { background: #eff6ff; }
.type-sick     .li-type { background: #fef2f2; }
.type-personal .li-type { background: #faf5ff; }
.type-unpaid   .li-type { background: #fffbeb; }
.li-info { flex: 1; min-width: 0; }
.li-name { display: block; font-size: .88rem; font-weight: 600; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.li-date { display: block; font-size: .78rem; color: #9ca3af; margin-top: .1rem; }
.li-days { font-size: .82rem; font-weight: 600; color: #6366f1; white-space: nowrap; margin-right: .2rem; }
.li-badge { display: inline-block; padding: .2rem .6rem; border-radius: 20px; font-size: .75rem; font-weight: 600; white-space: nowrap; }
.badge-pending  { background: #fef3c7; color: #92400e; }
.badge-approved { background: #dcfce7; color: #166534; }
.badge-rejected { background: #fee2e2; color: #991b1b; }

.empty-dash { text-align: center; padding: 2rem; color: #9ca3af; font-size: .9rem; }

/* Quick actions */
.quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 1rem; }
.quick-card { display: flex; flex-direction: column; align-items: center; gap: .7rem; padding: 1.4rem 1rem; background: #fff; border-radius: 14px; text-decoration: none; font-size: .88rem; font-weight: 600; border: 1px solid #f3f4f6; box-shadow: 0 1px 3px rgba(0,0,0,.06); transition: all .2s; }
.quick-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,.1); }
.qc-blue { color: #4f46e5; } .qc-blue:hover { background: #eff6ff; border-color: #c7d2fe; }
.qc-green { color: #16a34a; } .qc-green:hover { background: #f0fdf4; border-color: #bbf7d0; }

@media (max-width: 600px) {
    .stats-row { grid-template-columns: 1fr 1fr; }
    .greeting-bar { flex-direction: column; align-items: flex-start; }
}
</style>
@endpush