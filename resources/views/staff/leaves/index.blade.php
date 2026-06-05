@extends('layouts.app')

@section('title', 'បញ្ជីច្បាប់របស់ខ្ញុំ')

@section('content')
<div class="container">
<div class="page-header">
    <div>
        <a href="{{ route('staff.dashboard') }}" class="btn-back">
            ← ត្រឡប់ក្រោយ
        </a>
        <h2>បញ្ជីច្បាប់របស់ខ្ញុំ</h2>
    </div>

    <a href="{{ route('staff.leaves.create') }}" class="btn btn-primary">
        + ស្នើរសុំច្បាប់ថ្មី
    </a>
</div>

    {{-- Statistics --}}
<div class="stats-row">

    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">សរុបច្បាប់</span>
            <h3>{{ $stats['total'] }}</h3>
        </div>
        <div class="stat-icon bg-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">កំពុងរង់ចាំ</span>
            <h3>{{ $stats['pending'] }}</h3>
        </div>
        <div class="stat-icon bg-warning">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">បានអនុម័ត</span>
            <h3>{{ $stats['approved'] }}</h3>
        </div>
        <div class="stat-icon bg-success">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M22 11.08V12A10 10 0 1 1 12 2"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">បានបដិសេធ</span>
            <h3>{{ $stats['rejected'] }}</h3>
        </div>
        <div class="stat-icon bg-danger">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <line x1="15" y1="9" x2="9" y2="15"/>
                <line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
        </div>
    </div>

</div>

    {{-- Leave Table --}}
    <div class="card">
        <div class="card-header">
            <strong>ប្រវត្តិការស្នើរសុំច្បាប់</strong>
        </div>

        <div class="card-body">
            @if($leaves->count())
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ប្រភេទ</th>
                                <th>ថ្ងៃចាប់ផ្តើម</th>
                                <th>ថ្ងៃបញ្ចប់</th>
                                <th>ចំនួនថ្ងៃ</th>
                                <th>ស្ថានភាព</th>
                                <th>សកម្មភាព</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($leaves as $leave)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $leave->getTypeLabel() }}</td>

                                <td>
                                    {{ \Carbon\Carbon::parse($leave->start_date)->format('d/m/Y') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($leave->end_date)->format('d/m/Y') }}
                                </td>

                                <td>{{ $leave->total_days }}</td>

                                <td>
                                    @if($leave->status == 'pending')
                                        <span class="badge bg-warning">
                                            រង់ចាំ
                                        </span>
                                    @elseif($leave->status == 'approved')
                                        <span class="badge bg-success">
                                            អនុម័ត
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            បដិសេធ
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($leave->status == 'pending')
                                        <form action="{{ route('staff.leaves.destroy', $leave->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('តើអ្នកចង់លុបមែនទេ?')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-danger">
                                                លុប
                                            </button>
                                        </form>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $leaves->links() }}
                </div>

            @else
                <div class="alert alert-info">
                    មិនទាន់មានការស្នើរសុំច្បាប់នៅឡើយ។
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.stats-row{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
    margin-bottom:24px;
}

.stat-card{
    background:#fff;
    border-radius:12px;
    padding:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border:1px solid #e5e7eb;
    box-shadow:0 1px 3px rgba(0,0,0,.06);
}

.stat-info h3{
    margin:6px 0 0;
    font-size:30px;
    font-weight:700;
    color:#111827;
}

.stat-label{
    color:#6b7280;
    font-size:14px;
    font-weight:500;
}

.stat-icon{
    width:52px;
    height:52px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
}

.stat-icon svg{
    width:24px;
    height:24px;
}

.bg-primary{
    background:#3b82f6;
}

.bg-warning{
    background:#f59e0b;
}

.bg-success{
    background:#22c55e;
}

.bg-danger{
    background:#ef4444;
}
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:24px;
}

.page-header h2{
    margin-top:8px;
    margin-bottom:0;
    font-size:28px;
    font-weight:700;
}

.btn-back{
    text-decoration:none;
    color:#6b7280;
    font-size:14px;
    font-weight:500;
}

.btn-back:hover{
    color:#111827;
}
</style>
@endsection