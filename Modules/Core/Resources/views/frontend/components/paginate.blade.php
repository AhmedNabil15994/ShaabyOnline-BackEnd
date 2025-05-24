@if ($paginator->lastPage() > 1)
    <ul class="pagination d-md-flex justify-content-md-end align-items-md-center">
        <li class="page-item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->url($paginator->currentPage() - 1) }}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>

        @for ($i = ($paginator->lastPage() - $paginator->currentPage() >= 5 ? $paginator->currentPage() : ($paginator->currentPage() - 5 >= 1 ? $paginator->currentPage() - 5:1));
         $i <= ($paginator->lastPage() - $paginator->currentPage() >= 5 ? $paginator->currentPage() + 5 :$paginator->lastPage()); $i++)
            <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
        @endfor

        <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->url($paginator->currentPage()+1) }}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
@endif