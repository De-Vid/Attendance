@if ($paginator->hasPages())

<nav class="d-flex justify-content-center mt-4">

    <ul class="pagination pagination-lg shadow-sm">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())

            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link rounded-start-pill px-4 border-0 bg-light text-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Back
                </span>
            </li>

        @else

            <li class="page-item">
                <a class="page-link rounded-start-pill px-4 border-0 shadow-sm"
                   href="{{ $paginator->previousPageUrl() }}"
                   rel="prev">

                    <i class="bi bi-arrow-left me-1"></i>
                    Back

                </a>
            </li>

        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)

            {{-- Three Dots --}}
            @if (is_string($element))

                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link border-0">
                        {{ $element }}
                    </span>
                </li>

            @endif

            {{-- Page Links --}}
            @if (is_array($element))

                @foreach ($element as $page => $url)

                    @if ($page == $paginator->currentPage())

                        <li class="page-item active" aria-current="page">
                            <span class="page-link border-0 shadow-sm">
                                {{ $page }}
                            </span>
                        </li>

                    @else

                        <li class="page-item">
                            <a class="page-link border-0 shadow-sm"
                               href="{{ $url }}">

                                {{ $page }}

                            </a>
                        </li>

                    @endif

                @endforeach

            @endif

        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())

            <li class="page-item">
                <a class="page-link rounded-end-pill px-4 border-0 shadow-sm"
                   href="{{ $paginator->nextPageUrl() }}"
                   rel="next">

                    Next
                    <i class="bi bi-arrow-right ms-1"></i>

                </a>
            </li>

        @else

            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link rounded-end-pill px-4 border-0 bg-light text-secondary">

                    Next
                    <i class="bi bi-arrow-right ms-1"></i>

                </span>
            </li>

        @endif

    </ul>

</nav>

@endif