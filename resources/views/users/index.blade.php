@extends('layouts.app')

@section('title', 'Attendance Settings')

@section('content')
<div class="container-fluid bg-white p-4 rounded-4 shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4 class="fw-bold mb-0">User Roles</h4>

        <!-- Search Form -->
        <form method="GET" action="{{ route('users.index') }}"
            class="d-flex align-items-center bg-light p-2 px-3 rounded-3 shadow-sm">

            <i class="bi bi-search text-muted me-2"></i>

            <input type="text" id="searchInput" name="search" class="form-control border-0 bg-transparent shadow-none"
                placeholder="Search by name..." value="{{ request('search') }}" style="width: 220px;">

        </form>

    </div>
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
                    <td>
                        <form id="form{{ $user->id }}" action="{{ route('users.updateRole', $user->id) }}"
                            method="POST">
                            @csrf
                            <select name="role" class="form-select">
                                <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>
                                    Staff
                                </option>

                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                                    Admin
                                </option>

                                <option value="leader" {{ $user->role == 'leader' ? 'selected' : '' }}>
                                    Leader
                                </option>

                            </select>
                        </form>
                    </td>
                    <td>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#updateModal{{ $user->id }}">
                            <i class="bi bi-pencil-square me-1"></i>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="updateModal{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirm Update</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        តើអ្នកពិតជាចង់ update role របស់
                                        <strong>{{ $user->name }}</strong> មែនទេ?
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Cancel
                                        </button>

                                        <!-- Submit form -->
                                        <button type="submit" form="form{{ $user->id }}" class="btn btn-success">
                                            Yes, Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
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

    <!-- Pagination -->
    <div class="d-flex justify-content-end mt-4">
        {{ $users->links() }}
    </div>

</div>
<script>
let timeout = null;

document.getElementById('searchInput').addEventListener('keyup', function() {

    clearTimeout(timeout);

    timeout = setTimeout(() => {
        this.closest('form').submit();
    }, 500); // delay 0.5s

});
</script>
@endsection