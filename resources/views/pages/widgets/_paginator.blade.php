@if ($paginator->hasPages())
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <div class="d-flex flex-wrap mr-3">
        <a href="{{ $paginator->url(1) }}" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1 {{ ($paginator->currentPage() == 1) ? 'disabled' : '' }}">
            <i class="ki ki-bold-double-arrow-back icon-xs"></i>
        </a>
        <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1 {{ ($paginator->currentPage() == 1) ? 'disabled' : '' }}">
            <i class="ki ki-bold-arrow-back icon-xs"></i>
        </a>

        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <?php
                $half_total_links = 4;
                $from = $paginator->currentPage() - $half_total_links;
                $to = $paginator->currentPage() + $half_total_links;
                if ($paginator->currentPage() < $half_total_links) {
                    $to += $half_total_links - $paginator->currentPage();
                }
                if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                    $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
                }
            ?>
            @if ($from < $i && $i < $to)
                <a href="{{ $paginator->url($i) }}" data-page="{{ $i }}" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">{{ $i }}</a>
            @endif
        @endfor

        <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1 {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
            <i class="ki ki-bold-arrow-next icon-xs"></i>
        </a>
        <a href="{{ $paginator->url($paginator->lastPage()) }}" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1 {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
            <i class="ki ki-bold-double-arrow-next icon-xs"></i>
        </a>
    </div>
    <div class="d-flex align-items-center">
        <span class="text-muted">Showing {{$paginator->firstItem()}} to {{$paginator->lastItem()}} of {{$paginator->total()}} entries</span>
    </div>
</div>
@endif
