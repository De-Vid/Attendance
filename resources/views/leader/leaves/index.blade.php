{{-- resources/views/leader/leaves/index.blade.php --}}
@extends('layouts.app')

@section('title', 'គ្រប់គ្រងច្បាប់')

@section('content')
<div class="container-fluid" style="padding: 0; max-width: 100vw;">
    <div class="leader-page">

    {{-- ===== Alerts ===== --}}
    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif

    {{-- ===== Stats Overview ===== --}}
    <div class="stats-grid">
        <div class="stat-card s-blue">
            <div class="stat-icon">👤</div>
            <div><span class="stat-num">{{ $stats['my_total'] }}</span><br><span class="stat-label">ច្បាប់ខ្ញុំ</span></div>
        </div>
        <div class="stat-card s-orange">
            <div class="stat-icon">⏳</div>
            <div><span class="stat-num">{{ $stats['staff_pending'] }}</span><br><span class="stat-label">Staff រង់ចាំ</span></div>
        </div>
        <div class="stat-card s-green">
            <div class="stat-icon">✅</div>
            <div><span class="stat-num">{{ $stats['staff_approved'] }}</span><br><span class="stat-label">Staff បានអនុម័ត</span></div>
        </div>
        <div class="stat-card s-red">
            <div class="stat-icon">❌</div>
            <div><span class="stat-num">{{ $stats['staff_rejected'] }}</span><br><span class="stat-label">Staff បានបដិសេធ</span></div>
        </div>
    </div>

    {{-- ===== TABS ===== --}}
    <div class="tab-nav">
        <button class="tab-btn active" onclick="showTab('staff-tab', this)">
            👥 ច្បាប់ Staff <span class="tab-badge">{{ $stats['staff_pending'] }}</span>
        </button>
        <button class="tab-btn" onclick="showTab('my-tab', this)">
            👤 ច្បាប់ខ្ញុំ
        </button>
    </div>

    {{-- ===== TAB: Staff Leaves ===== --}}
    <div id="staff-tab" class="tab-content active">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">📋 ការស្នើរសុំច្បាប់ Staff</h2>

                {{-- Filter --}}
                <div class="filter-group">
                    @foreach(['all'=>'ទាំងអស់','pending'=>'រង់ចាំ','approved'=>'បានអនុម័ត','rejected'=>'បានបដិសេធ'] as $val=>$label)
                    <a href="{{ route('leader.leaves.index', ['status'=>$val]) }}"
                       class="filter-btn {{ $statusFilter === $val ? 'filter-active' : '' }}">
                        {{ $label }}
                    </a>
                    @endforeach
                </div>
            </div>

            @if($staffLeaves->count() > 0)
            <div class="table-wrapper">
                <table class="leave-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ឈ្មោះ Staff</th>
                            <th>ប្រភេទ</th>
                            <th>ចាប់ផ្តើម</th>
                            <th>បញ្ចប់</th>
                            <th>ថ្ងៃ</th>
                            <th>មូលហេតុ</th>
                            <th>សភាព</th>
                            <th>សកម្មភាព</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staffLeaves as $leave)
                        <tr class="{{ $leave->isPending() ? 'row-pending' : '' }}">
                            <td class="text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="staff-name">
                                    <div class="avatar">{{ strtoupper(substr($leave->user->name, 0, 1)) }}</div>
                                    <span>{{ $leave->user->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="type-badge type-{{ $leave->type }}">
                                    {{ $leave->getTypeLabel() }}
                                </span>
                            </td>
                            <td>{{ $leave->start_date->format('d/m/Y') }}</td>
                            <td>{{ $leave->end_date->format('d/m/Y') }}</td>
                            <td class="text-center"><strong>{{ $leave->total_days }}</strong></td>
                            <td class="reason-cell" title="{{ $leave->reason }}">{{ Str::limit($leave->reason, 40) }}</td>
                            <td>
                                <span class="status-badge {{ $leave->getStatusBadgeClass() }}">
                                    @if($leave->status === 'pending') ⏳ រង់ចាំ
                                    @elseif($leave->status === 'approved') ✅ អនុម័ត
                                    @else ❌ បដិសេធ
                                    @endif
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('leader.leaves.show', $leave) }}" class="btn-view">👁 មើល</a>
                                    @if($leave->isPending())
                                        <button onclick="openApproveModal({{ $leave->id }}, 'approve')"
                                                class="btn-approve">✅ Approve</button>
                                        <button onclick="openApproveModal({{ $leave->id }}, 'reject')"
                                                class="btn-reject">❌ Reject</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrap">{{ $staffLeaves->appends(['status'=>$statusFilter])->links() }}</div>
            @else
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <p>មិនមានការស្នើរសុំច្បាប់</p>
            </div>
            @endif
        </div>
    </div>

    {{-- ===== TAB: My Leaves ===== --}}
    <div id="my-tab" class="tab-content">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">👤 ច្បាប់របស់ខ្ញុំ</h2>
            </div>
            @if($myLeaves->count() > 0)
            <div class="table-wrapper">
                <table class="leave-table">
                    <thead>
                        <tr>
                            <th>#</th><th>ប្រភេទ</th><th>ចាប់ផ្តើម</th>
                            <th>បញ្ចប់</th><th>ថ្ងៃ</th><th>មូលហេតុ</th><th>សភាព</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($myLeaves as $leave)
                        <tr>
                            <td class="text-muted">{{ $loop->iteration }}</td>
                            <td><span class="type-badge type-{{ $leave->type }}">{{ $leave->getTypeLabel() }}</span></td>
                            <td>{{ $leave->start_date->format('d/m/Y') }}</td>
                            <td>{{ $leave->end_date->format('d/m/Y') }}</td>
                            <td class="text-center"><strong>{{ $leave->total_days }}</strong></td>
                            <td class="reason-cell" title="{{ $leave->reason }}">{{ Str::limit($leave->reason, 50) }}</td>
                            <td>
                                <span class="status-badge {{ $leave->getStatusBadgeClass() }}">
                                    @if($leave->status === 'pending') ⏳ រង់ចាំ
                                    @elseif($leave->status === 'approved') ✅ អនុម័ត
                                    @else ❌ បដិសេធ
                                    @endif
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state"><div class="empty-icon">📭</div><p>មិនទាន់មានច្បាប់</p></div>
            @endif
        </div>
    </div>
</div>

{{-- ===== Approve/Reject Modal ===== --}}
<div id="actionModal" class="modal-overlay" style="display:none">
    <div class="modal-box">
        <div class="modal-header" id="modalHeader">
            <h3 id="modalTitle"></h3>
            <button onclick="closeModal()" class="modal-close">×</button>
        </div>
        <div class="modal-body">
            <form id="actionForm" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label" id="noteLabel">Note (ចាំបាច់)</label>
                    <textarea name="leader_note" id="leaderNote" rows="3"
                              class="form-input"
                              placeholder="បញ្ចូលកំណត់សម្គាល់..."></textarea>
                    <span class="field-error" id="noteError" style="display:none">សូមបញ្ចូលមូលហេតុ</span>
                </div>
                <div class="modal-actions">
                    <button type="button" onclick="closeModal()" class="btn-cancel">បោះបង់</button>
                    <button type="submit" class="btn-modal-action" id="modalActionBtn"></button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

@endsection

@push('styles')
<style>
    .leader-page { width: 100%; max-width: none; margin: 0; padding: 1.5rem; }
    .alert { padding: .85rem 1.2rem; border-radius: 8px; margin-bottom: 1rem; }
    .alert-success { background: #f0fff4; color: #276749; border: 1px solid #9ae6b4; }
    .alert-error   { background: #fff5f5; color: #c53030; border: 1px solid #feb2b2; }

    /* Stats */
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
    .stat-card { background: #fff; border-radius: 12px; padding: 1.1rem 1.3rem; display: flex; align-items: center; gap: .9rem; box-shadow: 0 1px 4px rgba(0,0,0,.08); border-left: 4px solid transparent; }
    .s-blue   { border-color: #667eea; }
    .s-orange { border-color: #f6ad55; }
    .s-green  { border-color: #48bb78; }
    .s-red    { border-color: #fc8181; }
    .stat-icon { font-size: 1.8rem; }
    .stat-num  { font-size: 1.7rem; font-weight: 700; color: #2d3748; line-height: 1; }
    .stat-label { font-size: .8rem; color: #718096; }

    /* Tabs */
    .tab-nav { display: flex; gap: .5rem; margin-bottom: 1rem; }
    .tab-btn { background: #fff; border: 1.5px solid #e2e8f0; border-radius: 8px; padding: .55rem 1.1rem; cursor: pointer; font-size: .9rem; font-weight: 600; color: #4a5568; transition: all .2s; display: flex; align-items: center; gap: .4rem; }
    .tab-btn.active { background: #667eea; color: #fff; border-color: #667eea; }
    .tab-badge { background: #fc8181; color: #fff; border-radius: 12px; padding: .1rem .45rem; font-size: .75rem; }
    .tab-btn.active .tab-badge { background: rgba(255,255,255,.3); }
    .tab-content { display: none; }
    .tab-content.active { display: block; }

    /* Card */
    .card { background: #fff; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,.08); overflow: hidden; }
    .card-header { padding: 1rem 1.3rem; border-bottom: 1px solid #edf2f7; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .7rem; }
    .card-title { font-size: 1.05rem; font-weight: 700; color: #2d3748; margin: 0; }

    /* Filter */
    .filter-group { display: flex; gap: .4rem; flex-wrap: wrap; }
    .filter-btn { padding: .3rem .75rem; border-radius: 6px; background: #f7fafc; color: #4a5568; text-decoration: none; font-size: .82rem; font-weight: 500; border: 1px solid #e2e8f0; transition: all .2s; }
    .filter-btn:hover { background: #edf2f7; }
    .filter-active { background: #667eea; color: #fff; border-color: #667eea; }

    /* Table */
    .table-wrapper { overflow-x: auto; }
    .leave-table { width: 100%; border-collapse: collapse; font-size: .9rem; }
    .leave-table th { background: #f7fafc; padding: .85rem 1rem; text-align: left; font-weight: 600; color: #4a5568; border-bottom: 2px solid #e2e8f0; white-space: nowrap; }
    .leave-table td { padding: .75rem 1rem; border-bottom: 1px solid #edf2f7; vertical-align: middle; }
    .leave-table tbody tr:hover { background: #f7fafc; }
    .row-pending { background: #fffbeb; }
    .text-center { text-align: center; }
    .text-muted  { color: #a0aec0; }
    .reason-cell { max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    /* Staff name */
    .staff-name { display: flex; align-items: center; gap: .5rem; }
    .avatar { width: 28px; height: 28px; border-radius: 50%; background: #667eea; color: #fff; display: flex; align-items: center; justify-content: center; font-size: .78rem; font-weight: 700; flex-shrink: 0; }

    /* Badges */
    .status-badge, .type-badge { display: inline-block; padding: .25rem .65rem; border-radius: 20px; font-size: .78rem; font-weight: 600; white-space: nowrap; }
    .badge-pending  { background: #fefcbf; color: #975a16; }
    .badge-approved { background: #c6f6d5; color: #276749; }
    .badge-rejected { background: #fed7d7; color: #c53030; }
    .type-annual   { background: #ebf8ff; color: #2b6cb0; }
    .type-sick     { background: #fff5f5; color: #c53030; }
    .type-personal { background: #faf5ff; color: #6b46c1; }
    .type-unpaid   { background: #fffbeb; color: #92400e; }

    /* Action btns */
    .action-btns { display: flex; gap: .4rem; flex-wrap: wrap; }
    .btn-view    { padding: .28rem .65rem; border-radius: 6px; background: #ebf8ff; color: #2b6cb0; text-decoration: none; font-size: .8rem; font-weight: 500; white-space: nowrap; }
    .btn-approve { padding: .28rem .65rem; border-radius: 6px; background: #c6f6d5; color: #276749; border: none; cursor: pointer; font-size: .8rem; font-weight: 600; white-space: nowrap; }
    .btn-reject  { padding: .28rem .65rem; border-radius: 6px; background: #fed7d7; color: #c53030; border: none; cursor: pointer; font-size: .8rem; font-weight: 600; white-space: nowrap; }

    /* Empty */
    .empty-state { padding: 2.5rem; text-align: center; color: #718096; }
    .empty-icon  { font-size: 2.5rem; }

    /* Pagination */
    .pagination-wrap { padding: 1rem 1.2rem; border-top: 1px solid #edf2f7; }

    /* Modal */
    .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 1000; display: flex; align-items: center; justify-content: center; padding: 1rem; }
    .modal-box     { background: #fff; border-radius: 12px; width: 100%; max-width: 440px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,.2); }
    .modal-header  { padding: 1rem 1.3rem; display: flex; justify-content: space-between; align-items: center; }
    .modal-header h3 { margin: 0; font-size: 1.1rem; font-weight: 700; }
    .modal-close   { background: none; border: none; font-size: 1.4rem; cursor: pointer; color: #718096; line-height: 1; }
    .modal-body    { padding: 1.2rem 1.3rem; }
    .form-group    { margin-bottom: 1rem; }
    .form-label    { display: block; font-weight: 600; color: #4a5568; margin-bottom: .4rem; font-size: .9rem; }
    .form-input    { width: 100%; padding: .65rem .9rem; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: .9rem; box-sizing: border-box; }
    .form-input:focus { outline: none; border-color: #667eea; }
    .field-error   { color: #e53e3e; font-size: .82rem; }
    .modal-actions { display: flex; justify-content: flex-end; gap: .7rem; margin-top: .5rem; }
    .btn-cancel    { padding: .6rem 1.2rem; border: 1.5px solid #e2e8f0; border-radius: 8px; background: #fff; color: #4a5568; cursor: pointer; font-weight: 600; }
    .btn-modal-action { padding: .6rem 1.4rem; border: none; border-radius: 8px; color: #fff; cursor: pointer; font-weight: 700; }
</style>
@endpush

@push('scripts')
<script>
    // Tab switching
    function showTab(id, btn) {
        document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.getElementById(id).classList.add('active');
        btn.classList.add('active');
    }

    // Modal
    let currentAction = null;
    function openApproveModal(leaveId, action) {
        currentAction = action;
        const isApprove = action === 'approve';
        const modal = document.getElementById('actionModal');
        const header = document.getElementById('modalHeader');
        const note   = document.getElementById('leaderNote');

        document.getElementById('modalTitle').textContent = isApprove ? '✅ Approve ច្បាប់' : '❌ Reject ច្បាប់';
        document.getElementById('noteLabel').textContent  = isApprove ? 'Note (ស្រេចចិត្ត)' : 'មូលហេតុនៃការបដិសេធ (ចាំបាច់)';

        const btn = document.getElementById('modalActionBtn');
        btn.textContent  = isApprove ? 'Approve' : 'Reject';
        btn.style.background = isApprove ? '#48bb78' : '#fc8181';
        header.style.borderBottom = `3px solid ${isApprove ? '#48bb78' : '#fc8181'}`;

        note.placeholder = isApprove ? 'បញ្ចូលកំណត់សម្គាល់... (ស្រេចចិត្ត)' : 'សូមបញ្ចូលមូលហេតុ...';
        note.value = '';

        const url = isApprove
            ? `/leader/leaves/${leaveId}/approve`
            : `/leader/leaves/${leaveId}/reject`;

        document.getElementById('actionForm').action = url;
        modal.style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('actionModal').style.display = 'none';
        document.getElementById('noteError').style.display = 'none';
    }

    // Validate reject note
    document.getElementById('actionForm').addEventListener('submit', function(e) {
        if (currentAction === 'reject') {
            const note = document.getElementById('leaderNote').value.trim();
            if (!note) {
                e.preventDefault();
                document.getElementById('noteError').style.display = 'block';
            }
        }
    });

    // Close on overlay click
    document.getElementById('actionModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endpush
