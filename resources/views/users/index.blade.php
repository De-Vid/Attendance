@extends('layouts.app')

@section('title', 'User Roles')

@section('content')

<div class="container-fluid bg-white p-4 rounded-4 shadow-sm">

    {{-- HEADER + SEARCH --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4 class="fw-bold mb-0">User Roles</h4>

        <form method="GET"
              action="{{ route('users.index') }}"
              class="d-flex align-items-center bg-light p-2 px-3 rounded-3 shadow-sm">

            <i class="bi bi-search text-muted me-2"></i>

            <input type="text"
                   id="searchInput"
                   name="search"
                   class="form-control border-0 bg-transparent shadow-none"
                   placeholder="Search by name..."
                   value="{{ request('search') }}"
                   style="width: 220px;">

        </form>

    </div>

    {{-- TABLE --}}
    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Update Role</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($users as $user)

                <tr>

                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    <td>
                        <span class="badge bg-primary">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>

                    {{-- FORM --}}
                    <td>
                        <form id="form{{ $user->id }}"
                              action="{{ route('users.updateRole', $user->id) }}"
                              method="POST">
                            @csrf

                            <select name="role" class="form-select">
                                <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="leader" {{ $user->role == 'leader' ? 'selected' : '' }}>Leader</option>
                            </select>
                        </form>
                    </td>

                    {{-- ACTION --}}
                    <td>
                        <button type="button"
                                class="btn btn-success"
                                onclick="openModal({{ $user->id }}, '{{ $user->name }}')">

                            <i class="bi bi-pencil-square"></i>

                        </button>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        មិនទាន់មានទិន្នន័យ
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-end mt-4">
        {{ $users->links() }}
    </div>

</div>

{{-- ========================= --}}
{{-- MODAL UI (MODERN STANDARD) --}}
{{-- ========================= --}}
<div class="modal-overlay" id="customModal" onclick="closeModalOnOverlay(event)">

    <div class="modal-box">

        <div class="modal-icon-wrapper">
            <i class="bi bi-exclamation-circle-fill"></i>
        </div>

        <div class="modal-title">
            បញ្ជាក់ការផ្លាស់ប្តូរ
        </div>

        <div class="modal-text" id="modalText">
            </div>

        <div class="btn-group-modal">

            <button class="btn-modal btn-cancel" onclick="closeModal()">
                បោះបង់
            </button>

            <button class="btn-modal btn-confirm" id="confirmBtn">
                យល់ព្រមបច្ចុប្បន្នភាព
            </button>

        </div>

    </div>

</div>

{{-- ========================= --}}
{{-- STYLE --}}
{{-- ========================= --}}
<style>
/* Overlay with modern blur effect */
.modal-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(15, 23, 42, 0.45); 
    backdrop-filter: blur(8px);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    opacity: 0;
    transition: opacity 0.25s ease;
}

.modal-overlay.show {
    display: flex;
    opacity: 1;
}

/* Premium Modal Box Design */
.modal-box {
    width: 100%;
    max-width: 400px;
    background: #ffffff;
    border-radius: 24px;
    padding: 32px 24px;
    text-align: center;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    transform: scale(0.9);
    transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    margin: 0 16px;
}

.modal-overlay.show .modal-box {
    transform: scale(1);
}

/* Warning Icon Wrapper */
.modal-icon-wrapper {
    width: 64px;
    height: 64px;
    background: #fef3c7; 
    color: #d97706; 
    font-size: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin: 0 auto 18px;
}

/* Typography Khmer Standard */
.modal-title {
    font-family: 'Kantumruy Pro', 'Khmer OS Siemreap', sans-serif;
    font-weight: 700;
    font-size: 20px;
    color: #1e293b;
    margin-bottom: 8px;
}

.modal-text {
    font-family: 'Kantumruy Pro', 'Khmer OS Siemreap', sans-serif;
    font-size: 15px;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 28px;
}

/* Buttons Configuration */
.btn-group-modal {
    display: flex;
    justify-content: center;
    gap: 12px;
}

.btn-modal {
    flex: 1;
    padding: 11px 20px;
    border-radius: 12px;
    border: none;
    font-family: 'Kantumruy Pro', 'Khmer OS Siemreap', sans-serif;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
}

/* Cancel Button */
.btn-cancel {
    background: #f1f5f9;
    color: #475569;
}

.btn-cancel:hover {
    background: #e2e8f0;
    color: #334155;
}

/* Confirm Button */
.btn-confirm {
    background: #0ea5e9; 
    color: white;
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.2);
}

.btn-confirm:hover {
    background: #0284c7;
    box-shadow: 0 6px 16px rgba(2, 132, 199, 0.3);
    transform: translateY(-1px);
}

.btn-confirm:active {
    transform: translateY(0);
}
</style>

{{-- ========================= --}}
{{-- JS --}}
{{-- ========================= --}}
<script>
function openModal(id, name) {
    const modal = document.getElementById('customModal');
    
    // Open modal with smooth fade-in
    modal.style.display = 'flex';
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);

    // Dynamic Khmer Text
    document.getElementById('modalText').innerHTML =
        "តើអ្នកពិតជាចង់ធ្វើបច្ចុប្បន្នភាពតួនាទី (Role) របស់ <strong style='color:#1e293b;'>" + name + "</strong> មែនទេ?";

    // Action Form Submit
    document.getElementById('confirmBtn').onclick = function () {
        document.getElementById('form' + id).submit();
    };
}

function closeModal() {
    const modal = document.getElementById('customModal');
    modal.classList.remove('show');
    
    // Wait for transition to end before hidden
    setTimeout(() => {
        modal.style.display = 'none';
    }, 250); 
}

// Close when clicking outside the modal box (UX Standard)
function closeModalOnOverlay(event) {
    if (event.target.id === 'customModal') {
        closeModal();
    }
}

/* Auto search with debounce */
let timeout = null;

document.getElementById('searchInput').addEventListener('keyup', function () {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        this.closest('form').submit();
    }, 500);
});
</script>

@endsection