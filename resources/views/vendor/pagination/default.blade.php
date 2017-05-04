<div class="dataTables_paginate">
    @if ($paginator->onFirstPage())
        <a class="first paginate_button paginate_button_disabled">First</a>
        <a class="previous paginate_button paginate_button_disabled">Previous</a>
    @else
        <a class="first paginate_button" href="{{ $paginator->url(1) }}">First</a>
        <a class="previous paginate_button" href="{{$paginator->previousPageUrl()}}">Previous</a>
    @endif

@if ($paginator->lastPage() <= 5)
    @if ($paginator->total() != 0)
        @foreach ($elements as $element)
            @foreach ($element as $page => $url)
                <span>
                @if ($page == $paginator->currentPage())
                    <a class="paginate_active" href="{{ $url }}">{{ $page }}</a>
                @else
                    <a class="paginate_button" href="{{ $url }}">{{ $page }}</a>
                @endif
                </span>
            @endforeach
        @endforeach
    @endif
@else
    @if($paginator->currentPage() - 3 > 0 && ($paginator->currentPage()+2) < $paginator->lastPage())
        <a class="paginate_button paginate_button_disabled">...</a>
        @for($i = $paginator->currentPage() - 2; $i <= $paginator->currentPage() + 2; $i++)
            <span>
            @if ($i == $paginator->currentPage())
                <a class="paginate_active" href="{{ $paginator->url($i) }}">{{ $i }}</a>
            @else
                <a class="paginate_button" href="{{ $paginator->url($i) }}">{{ $i }}</a>
            @endif
            </span>
        @endfor
        <a class="paginate_button paginate_button_disabled">...</a>
    @elseif($paginator->currentPage() - 3 <= 0)
            @for($i = 1; $i <= $paginator->currentPage() + 2; $i++)
                <span>
                @if ($i == $paginator->currentPage())
                    <a class="paginate_active" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                @else
                    <a class="paginate_button" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                @endif
                </span>
            @endfor
        <a class="paginate_button paginate_button_disabled">...</a>
    @elseif($paginator->currentPage() >= $paginator->lastPage()-3)
        <a class="paginate_button paginate_button_disabled">...</a>
        @for($i = $paginator->currentPage() - 2; $i <= $paginator->lastPage(); $i++)
            <span>
            @if ($i == $paginator->currentPage())
                <a class="paginate_active" href="{{ $paginator->url($i) }}">{{ $i }}</a>
            @else
                <a class="paginate_button" href="{{ $paginator->url($i) }}">{{ $i }}</a>
            @endif
            </span>
        @endfor
    @endif
@endif

@if ($paginator->total() != 0)
    @if ($paginator->currentPage() == $paginator->lastPage())
        <a class="next paginate_button paginate_button_disabled">Next</a>
        <a class="last paginate_button paginate_button_disabled">Last</a>
    @else
        <a class="next paginate_button" href="{{$paginator->nextPageUrl()}}">Next</a>
        <a class="last paginate_button" href="{{$paginator->url($paginator->lastPage()) }}">Last</a>
    @endif
@endif

</div>