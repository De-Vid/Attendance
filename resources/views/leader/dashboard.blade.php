@extends('layouts.app')

@section('title', 'Leader Dashboard')

@section('content')

<div style="margin-bottom:1.5rem;">
    <h1 style="font-size:1.4rem; font-weight:700;">🎯 Leader Dashboard</h1>
    <p style="color:#64748B; font-size:.88rem; margin-top:.3rem;">ស្វាគមន៍មក {{ Auth::user()->name }} — Leader Panel</p>
</div>

<!-- Info Card -->
<div class="card" style="border-left:4px solid #D97706;">
    <div style="display:flex; align-items:center; gap:1rem;">
        <div style="font-size:2.5rem;">🎯</div>
        <div>
            <div style="font-size:1rem; font-weight:700; color:#92400E;">Leader Access</div>
            <div style="font-size:.85rem; color:#64748B; margin-top:.2rem;">អ្នកមានសិទ្ធមើល Staff ក្រោមការដឹកនាំរបស់អ្នក</div>
        </div>
    </div>
</div>

<!-- Staff List -->
<div class="card">
    <div class="card-title">👥 Staff ក្រោមការដឹកនាំ ({{ $staff->count() }} នាក់)</div>

    @if($staff->isEmpty())
        <p style="color:#64748B; text-align:center; padding:2rem; font-size:.9rem;">មិនទាន់មាន Staff ណាមួយទេ</p>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ឈ្មោះ</th>
                        <th>អ៊ីមែល</th>
                        <th>ស្ថានភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staff as $i => $member)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td style="font-weight:600;">{{ $member->name }}</td>
                        <td style="color:#64748B;">{{ $member->email }}</td>
                        <td><span class="pill pill-staff">Active</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
