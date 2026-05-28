{{-- resources/views/leader/leaves/show.blade.php --}}
@extends('layouts.app')

@section('title', 'លម្អិតច្បាប់')

@section('content')
<div class="container-fluid">
    <div class="leave-detail-wrapper">
    {{-- Header Section --}}
    <div class="page-header-container">
        <div class="header-left">
            <h1 class="page-title">លម្អិតការស្នើរសុំច្បាប់</h1>
            <p class="page-subtitle">ពិនិត្យ គ្រប់គ្រង និងសម្រេចចិត្តលើការស្នើរសុំរបស់បុគ្គលិក</p>
        </div>
        <div class="header-right">
            <a href="{{ route('leader.leaves.index') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="icon-sm">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                ត្រឡប់ក្រោយ
            </a>
        </div>
    </div>

    {{-- Session Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="icon-md">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Main Content Grid --}}
    <div class="detail-grid-layout">
        
        {{-- Left: Information Card --}}
        <div class="main-info-card">
            <div class="card-hero-header status-bg-{{ $leave->status }}">
                <div class="user-profile-block">
                    <div class="avatar-circle">{{ strtoupper(substr($leave->user->name, 0, 1)) }}</div>
                    <div class="user-meta">
                        <h2 class="user-fullname">{{ $leave->user->name }}</h2>
                        <span class="user-email-text">{{ $leave->user->email }}</span>
                    </div>
                </div>
                <div class="badge-status-wrap">
                    <span class="status-pill {{ $leave->getStatusBadgeClass() }}">
                        <span class="dot-indicator"></span>
                        @if($leave->status === 'pending') កំពុងរង់ចាំ
                        @elseif($leave->status === 'approved') បានអនុម័ត
                        @else បានបដិសេធ
                        @endif
                    </span>
                </div>
            </div>

            <div class="card-details-body">
                <div class="info-list-group">
                    <div class="info-item-row">
                        <span class="info-label">ប្រភេទច្បាប់</span>
                        <span class="type-pill type-{{ $leave->type }}">{{ $leave->getTypeLabel() }}</span>
                    </div>
                    <div class="info-item-row">
                        <span class="info-label">ថ្ងៃចាប់ផ្តើម</span>
                        <span class="info-value date-value">{{ $leave->start_date->format('d M Y') }}</span>
                    </div>
                    <div class="info-item-row">
                        <span class="info-label">ថ្ងៃបញ្ចប់</span>
                        <span class="info-value date-value">{{ $leave->end_date->format('d M Y') }}</span>
                    </div>
                    <div class="info-item-row total-days-row">
                        <span class="info-label">រយៈពេលសរុប</span>
                        <span class="info-value counter-badge">{{ $leave->total_days }} ថ្ងៃ</span>
                    </div>
                    <div class="info-item-row">
                        <span class="info-label">កាលបរិច្ឆេទស្នើសុំ</span>
                        <span class="info-value timestamp">{{ $leave->created_at->format('d/m/Y @ H:i') }}</span>
                    </div>
                </div>

                {{-- Reason Section --}}
                <div class="content-block-box metadata-box">
                    <h4 class="block-title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="icon-xs">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501c1.153-.086 2.294-.213 3.423-.379 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                        </svg>
                        មូលហេតុនៃការសុំច្បាប់
                    </h4>
                    <p class="block-text">{{ $leave->reason }}</p>
                </div>

                {{-- Leader Note View (If processed) --}}
                @if($leave->leader_note)
                <div class="content-block-box note-box-{{ $leave->isApproved() ? 'approved' : 'rejected' }}">
                    <h4 class="block-title">
                        <span class="note-status-dot"></span>
                        កំណត់សម្គាល់ពីថ្នាក់ដឹកនាំ ({{ $leave->approver?->name }})
                    </h4>
                    <p class="block-text">{{ $leave->leader_note }}</p>
                    @if($leave->approved_at)
                        <div class="note-footer-time">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="icon-xs">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $leave->approved_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>

        {{-- Right: Actions Sidebar --}}
        <div class="sidebar-action-panel">
            @if($leave->isPending())
                <div class="sticky-action-card">
                    <h3 class="panel-main-title">ពិនិត្យ និងសម្រេចចិត្ត</h3>
                    
                    {{-- Approve Form --}}
                    <div class="action-wrapper-box approve-zone">
                        <div class="zone-header">
                            <span class="zone-icon zone-icon-approve">✔</span>
                            <h5>អនុម័តការសុំច្បាប់</h5>
                        </div>
                        <form action="{{ route('leader.leaves.approve', $leave) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <textarea name="leader_note" rows="3" class="modern-textarea" placeholder="បញ្ចូលមតិយោបល់បន្ថែម (ស្រេចចិត្ត)..."></textarea>
                                @error('leader_note') <span class="input-error-msg">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" class="btn-action-submit btn-submit-approve" onclick="return confirm('តើអ្នកពិតជាចង់អនុម័តច្បាប់នេះ?')">
                                អនុម័តយល់ព្រម
                            </button>
                        </form>
                    </div>

                    <div class="ui-divider">
                        <span>ឬ</span>
                    </div>

                    {{-- Reject Form --}}
                    <div class="action-wrapper-box reject-zone">
                        <div class="zone-header">
                            <span class="zone-icon zone-icon-reject">✕</span>
                            <h5>បដិសេធការសុំច្បាប់</h5>
                        </div>
                        <form action="{{ route('leader.leaves.reject', $leave) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <textarea name="leader_note" rows="3" class="modern-textarea" placeholder="សូមបញ្ចូលមូលហេតុនៃការបដិសេធ (ចាំបាច់)..." required></textarea>
                                @error('leader_note') <span class="input-error-msg">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" class="btn-action-submit btn-submit-reject" onclick="return confirm('តើអ្នកពិតជាចង់បដិសេធច្បាប់នេះ?')">
                                បដិសេធចោល
                            </button>
                        </form>
                    </div>
                </div>
            @else
                {{-- State: Processed --}}
                <div class="processed-status-card state-{{ $leave->status }}">
                    <div class="state-icon-circle">
                        @if($leave->isApproved())
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="icon-lg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="icon-lg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        @endif
                    </div>
                    <h4 class="state-title">ច្បាប់នេះត្រូវបានសម្រេចរួចរាល់</h4>
                    <p class="state-description">
                        ស្ថានភាព៖ <strong>{{ $leave->isApproved() ? 'បានអនុម័ត' : 'បានបដិសេធ' }}</strong> <br>
                        ដោយថ្នាក់ដឹកនាំ៖ <span class="approver-name">{{ $leave->approver?->name ?? 'N/A' }}</span>
                    </p>
                    @if($leave->approved_at)
                        <span class="state-time-badge">{{ $leave->approved_at->format('d/m/Y H:i') }}</span>
                    @endif
                </div>
            @endif
        </div>

    </div>
</div>
</div>
@endsection

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Kantumruy+Pro:wght@400;500;600;700&display=swap');

    :root {
        --font-khmer: 'Kantumruy Pro', 'Inter', sans-serif;
        --p-primary: #4f46e5;
        --p-primary-hover: #4338ca;
        --s-success: #10b981;
        --s-success-bg: #ecfdf5;
        --s-danger: #f43f5e;
        --s-danger-bg: #fff1f2;
        --s-warning: #f59e0b;
        --s-warning-bg: #fffbeb;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
    }

    .leave-detail-wrapper {
        font-family: var(--font-khmer);
        color: var(--text-dark);
        max-width: 100%;
        margin: 0 auto;
        padding: 1.5rem;
    }

    /* Icons utils */
    .icon-sm { width: 1.1rem; height: 1.1rem; }
    .icon-md { width: 1.4rem; height: 1.4rem; }
    .icon-lg { width: 2rem; height: 2rem; }
    .icon-xs { width: 1rem; height: 1rem; vertical-align: middle; margin-right: 4px;}

    /* Page Header */
    .page-header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 1rem;
    }
    .page-title { font-size: 1.6rem; font-weight: 700; color: var(--text-dark); margin: 0; }
    .page-subtitle { color: var(--text-muted); font-size: 0.9rem; margin-top: 0.25rem; }
    
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.2rem;
        background-color: #fff;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        color: var(--text-dark);
        font-weight: 500;
        font-size: 0.88rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-back:hover {
        background-color: #f8fafc;
        border-color: #cbd5e1;
    }

    /* Alerts */
    .alert {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        font-size: 0.93rem;
    }
    .alert-success { background: var(--s-success-bg); color: #065f46; border: 1px solid #a7f3d0; }

    /* Layout Grid */
    .detail-grid-layout {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 2rem;
        align-items: start;
    }

    /* Main Info Card */
    .main-info-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    /* Modern Headers */
    .card-hero-header {
        padding: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--border-color);
    }
    .status-bg-pending { background-color: #fafafa; }
    .status-bg-approved { background-color: #f8fafc; }
    .status-bg-rejected { background-color: #f8fafc; }

    .user-profile-block { display: flex; align-items: center; gap: 1.25rem; }
    .avatar-circle {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        font-weight: 700;
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
    }
    .user-fullname { font-size: 1.25rem; font-weight: 700; color: var(--text-dark); margin: 0; }
    .user-email-text { font-size: 0.85rem; color: var(--text-muted); display: block; margin-top: 0.15rem; }

    /* Status Pills */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .badge-pending { background: var(--s-warning-bg); color: #92400e; }
    .badge-pending .dot-indicator { background: var(--s-warning); }
    
    .badge-approved { background: var(--s-success-bg); color: #065f46; }
    .badge-approved .dot-indicator { background: var(--s-success); }
    
    .badge-rejected { background: var(--s-danger-bg); color: #9f1239; }
    .badge-rejected .dot-indicator { background: var(--s-danger); }

    .dot-indicator { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }

    /* Info Rows */
    .card-details-body { padding: 2rem; }
    .info-list-group { margin-bottom: 2rem; }
    .info-item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .info-item-row:last-child { border-bottom: none; }
    .info-label { color: var(--text-muted); font-size: 0.9rem; font-weight: 500; }
    .info-value { color: var(--text-dark); font-weight: 600; font-size: 0.95rem; }
    .date-value { font-family: 'Inter', sans-serif; letter-spacing: -0.3px; }
    
    .total-days-row {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 12px;
        border: 1px dashed var(--border-color);
        margin: 0.5rem 0;
    }
    .counter-badge {
        background: var(--p-primary);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 1rem;
    }
    .timestamp { color: var(--text-muted); font-size: 0.85rem; font-weight: 400; }

    /* Type Pills */
    .type-pill { padding: 0.35rem 0.8rem; border-radius: 8px; font-size: 0.8rem; font-weight: 600; }
    .type-annual   { background: #eff6ff; color: #1e40af; }
    .type-sick     { background: #fdf2f8; color: #9d174d; }
    .type-personal { background: #f5f3ff; color: #5b21b6; }
    .type-unpaid   { background: #fff7ed; color: #9a3412; }

    /* Blocks (Reason & Notes) */
    .content-block-box {
        border-radius: 12px;
        padding: 1.25rem;
        margin-top: 1.5rem;
    }
    .metadata-box { background: #f8fafc; border: 1px solid var(--border-color); }
    
    .note-box-approved { background: var(--s-success-bg); border-left: 4px solid var(--s-success); }
    .note-box-rejected { background: var(--s-danger-bg); border-left: 4px solid var(--s-danger); }
    
    .note-box-approved .note-status-dot { background: var(--s-success); }
    .note-box-rejected .note-status-dot { background: var(--s-danger); }
    .note-status-dot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; margin-right: 5px; vertical-align: middle;}

    .block-title {
        display: flex;
        align-items: center;
        font-size: 0.92rem;
        font-weight: 700;
        color: #475569;
        margin: 0 0 0.6rem 0;
    }
    .block-text { font-size: 0.93rem; line-height: 1.7; color: #334155; margin: 0; }
    .note-footer-time {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 0.75rem;
    }

    /* Sidebar Actions */
    .sidebar-action-panel {  }
    .sticky-action-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .panel-main-title { font-size: 1.05rem; font-weight: 700; margin: 0 0 1.25rem; text-align: center; color: var(--text-dark); }
    
    .action-wrapper-box {
        border-radius: 12px;
        padding: 1rem;
        border: 1px solid var(--border-color);
    }
    .zone-header { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem; }
    .zone-header h5 { margin: 0; font-size: 0.9rem; font-weight: 700; }
    
    .approve-zone { background-color: #fcfdfd; border-color: #e6f4ea; }
    .approve-zone h5 { color: #137333; }
    .reject-zone { background-color: #fdfcfc; border-color: #fce8e6; }
    .reject-zone h5 { color: #c5221f; }

    .zone-icon {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.65rem;
        color: white;
        font-weight: bold;
    }
    .zone-icon-approve { background-color: var(--s-success); }
    .zone-icon-reject { background-color: var(--s-danger); }

    .modern-textarea {
        width: 100%;
        padding: 0.65rem 0.85rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.85rem;
        font-family: var(--font-khmer);
        box-sizing: border-box;
        resize: vertical;
        transition: all 0.2s ease;
    }
    .modern-textarea:focus {
        outline: none;
        border-color: var(--p-primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
    }
    
    .input-error-msg { color: var(--s-danger); font-size: 0.8rem; display: block; margin-top: 0.25rem; }

    .btn-action-submit {
        width: 100%;
        padding: 0.65rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.88rem;
        font-family: var(--font-khmer);
        cursor: pointer;
        margin-top: 0.75rem;
        transition: background-color 0.2s;
    }
    .btn-submit-approve { background: var(--s-success); color: white; }
    .btn-submit-approve:hover { background: #049f6e; }
    .btn-submit-reject { background: var(--s-danger); color: white; }
    .btn-submit-reject:hover { background: #e11d48; }

    .ui-divider {
        text-align: center;
        position: relative;
        margin: 1.25rem 0;
    }
    .ui-divider::before {
        content: "";
        position: absolute;
        left: 0; top: 50%; width: 100%; height: 1px;
        background-color: var(--border-color);
        z-index: 1;
    }
    .ui-divider span {
        background: #fff;
        padding: 0 0.75rem;
        color: var(--text-muted);
        font-size: 0.82rem;
        position: relative;
        z-index: 2;
    }

    /* Processed Finished UI */
    .processed-status-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        padding: 2.5rem 1.5rem;
        text-align: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .state-icon-circle {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
    }
    .state-approved .state-icon-circle { background-color: var(--s-success-bg); color: var(--s-success); }
    .state-rejected .state-icon-circle { background-color: var(--s-danger-bg); color: var(--s-danger); }
    
    .state-title { font-size: 1.1rem; font-weight: 700; margin: 0 0 0.5rem 0; }
    .state-description { color: #475569; font-size: 0.9rem; line-height: 1.6; margin: 0 0 1rem 0; }
    .approver-name { color: var(--p-primary); font-weight: 600; }
    .state-time-badge {
        display: inline-block;
        background: #f1f5f9;
        color: #475569;
        font-size: 0.78rem;
        padding: 0.3rem 0.75rem;
        border-radius: 6px;
        font-family: 'Inter', sans-serif;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .detail-grid-layout { grid-template-columns: 1fr; gap: 1.5rem; }
    }
</style>
@endpush