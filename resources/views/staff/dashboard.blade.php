@extends('layouts.app')

@section('title', 'Staff Dashboard')

@section('content')

<div style="margin-bottom:1.5rem;">
    <h1 style="font-size:1.4rem; font-weight:700;">💼 Staff Dashboard</h1>
    <p style="color:#64748B; font-size:.88rem; margin-top:.3rem;">ស្វាគមន៍មក {{ $user->name }}!</p>
</div>

<!-- Welcome Card -->
<div class="card" style="border-left:4px solid #059669; text-align:center; padding:2.5rem;">
    <div style="font-size:3rem; margin-bottom:.75rem;">👋</div>
    <h2 style="font-size:1.2rem; font-weight:700; color:#065F46; margin-bottom:.5rem;">
        សួស្ដី, {{ $user->name }}!
    </h2>
    <p style="color:#64748B; font-size:.9rem; margin-bottom:1.5rem;">
        អ្នកបានចូលប្រើប្រព័ន្ធក្នុងនាម <strong>Staff</strong> ដោយជោគជ័យ
    </p>
    <div style="display:inline-flex; gap:.75rem; flex-wrap:wrap; justify-content:center;">
        <div style="background:#F0FDF4; border:1px solid #BBF7D0; border-radius:8px; padding:.75rem 1.25rem; font-size:.85rem;">
            📧 <strong>{{ $user->email }}</strong>
        </div>
        <div style="background:#F0FDF4; border:1px solid #BBF7D0; border-radius:8px; padding:.75rem 1.25rem; font-size:.85rem;">
            🏷️ Role: <strong style="color:#059669;">Staff</strong>
        </div>
    </div>
</div>

<!-- Quick Note -->
<div class="card" style="background:#FFFBEB; border:1px solid #FDE68A;">
    <div style="display:flex; gap:.75rem; align-items:flex-start;">
        <span style="font-size:1.3rem;">ℹ️</span>
        <div style="font-size:.88rem; color:#92400E;">
            <strong>ចំណាំ:</strong> Staff មានសិទ្ធចូលមើល Dashboard ផ្ទាល់ខ្លួនប៉ុណ្ណោះ។
            ដើម្បីទទួលបានសិទ្ធបន្ថែម សូមទំនាក់ទំនង Admin ឬ Leader របស់អ្នក។
        </div>
    </div>
</div>

@endsection
