@extends('layouts.app')

@section('title', 'Positions')

@section('content')

<div class="container-fluid bg-white p-4 rounded-4 shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Positions</h4>
        </div>
        <a href="{{ route('positions.create') }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm fw-semibold">
            <i class="bi bi-plus-square me-1"></i>Add New
        </a>
    </div>
    <div class="d-flex justify-content-end align-items-center mb-3">

        <!-- Search Form -->
        <form method="GET" action="{{ route('positions.index') }}"
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
                    <th>ID</th>
                    <th>Name</th>
                    <th width="180">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($positions as $position)
                <tr>
                    <td class="fw-semibold">
                        {{ $position->id }}
                    </td>
                    <td>
                        {{ $position->name }}
                    </td>
                    <td>
                        <a href="{{ route('positions.edit', $position->id) }}"
                            class="btn btn-outline-success btn-sm rounded-pill px-3 shadow-sm me-1">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm"
                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $position->id }}">
                            <i class="bi bi-trash"></i>
                        </button>

                        <div class="modal fade" id="deleteModal{{ $position->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 rounded-4 shadow">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title fw-bold text-danger">
                                            <i class="bi bi-exclamation-triangle-fill me-2"></i>បញ្ជាក់ការលុប
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center py-4">
                                        <i class="bi bi-trash-fill text-danger" style="font-size: 55px;"></i>
                                        <h5 class="mt-3 fw-semibold">តើអ្នកពិតជាចង់លុបមែនទេ?</h5>
                                        <p class="text-muted mb-0">ទិន្នន័យនេះនឹងមិនអាចយកត្រឡប់វិញបានទេ។</p>
                                    </div>

                                    <div class="modal-footer border-0 justify-content-center pb-4">
                                        <button type="button" class="btn btn-light rounded-pill px-4"
                                            data-bs-dismiss="modal">
                                            បោះបង់
                                        </button>
                                        <form action="{{ route('positions.destroy', $position->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger rounded-pill px-4 shadow-sm">
                                                <i class="bi bi-trash me-1"></i>លុប
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>មិនទាន់មានទិន្នន័យ
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
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