<div class="dataTables_paginate">
    @if ($paginator->onFirstPage())
        <a class="first paginate_button paginate_button_disabled" href="">First</a>
        <a class="previous paginate_button paginate_button_disabled" href="">Previous</a>
    @else
        <a class="first paginate_button" href="{{ $paginator->url(1) }}">First</a>
        <a class="previous paginate_button" href="{{$paginator->previousPageUrl()}}">Previous</a>
    @endif

@if ($paginator->lastPage() <= 5)
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
@else
    @if($paginator->currentPage() - 3 > 0 && ($paginator->currentPage()+2) < $paginator->lastPage())
        <a class="paginate_active" href="">...</a>
        @for($i = $paginator->currentPage() - 2; $i <= $paginator->currentPage() + 2; $i++)
                <span>
                @if ($i == $paginator->currentPage())
                    <a class="paginate_active" href="{{ $elements[0][$i] }}">{{ $i }}</a>
                @else
                    <a class="paginate_button" href="{{ $elements[0][$i] }}">{{ $i }}</a>
                @endif
                </span>
            @endfor
        <a class="paginate_active" href="">...</a>
    @elseif($paginator->currentPage() - 3 <= 0)
            @for($i = 1; $i <= $paginator->currentPage() + 2; $i++)
                <span>
                @if ($i == $paginator->currentPage())
                    <a class="paginate_active" href="{{ $elements[0][$i] }}">{{ $i }}</a>
                @else
                    <a class="paginate_button" href="{{ $elements[0][$i] }}">{{ $i }}</a>
                @endif
                </span>
            @endfor
        <a class="paginate_active" href="">...</a>
    @elseif($paginator->currentPage() >= $paginator->lastPage()-3)
        <a class="paginate_active" href="">...</a>
        @for($i = $paginator->currentPage() - 2; $i <= $paginator->lastPage(); $i++)
            <span>
            @if ($i == $paginator->currentPage())
                <a class="paginate_active" href="{{ $elements[0][$i] }}">{{ $i }}</a>
            @else
                <a class="paginate_button" href="{{ $elements[0][$i] }}">{{ $i }}</a>
            @endif
            </span>
        @endfor
    @endif
@endif

@if ($paginator->currentPage() == count($elements[0]))
    <a class="next paginate_button paginate_button_disabled" href="">Next</a>
    <a class="last paginate_button paginate_button_disabled" href="">Last</a>
@else
    <a class="next paginate_button" href="{{$paginator->nextPageUrl()}}">Next</a>
    <a class="last paginate_button" href="{{$paginator->url($paginator->lastPage()) }}">Last</a>
@endif

</div>

    {{--<ul class="pagination">--}}
        {{-- Previous Page Link --}}
        {{--@if ($paginator->onFirstPage())--}}
            {{--<li class="page-item disabled"><span class="page-link paginate_active">&laquo;</span></li>--}}
        {{--@else--}}
            {{--<li class="page-item paginate_button"><a class="page-link paginate_active" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>--}}
        {{--@endif--}}

        {{-- Pagination Elements --}}
        {{--@foreach ($elements as $element)--}}
            {{-- "Three Dots" Separator --}}
            {{--@if (is_string($element))--}}
                {{--<li class="page-item disabled"><span class="page-link paginate_active">{{ $element }}</span></li>--}}
            {{--@endif--}}

            {{-- Array Of Links --}}
            {{--@if (is_array($element))--}}
                {{--@foreach ($element as $page => $url)--}}
                    {{--@if ($page == $paginator->currentPage())--}}
                        {{--<li class="page-item active paginate_button"><span class="page-link paginate_active">{{ $page }}</span></li>--}}
                    {{--@else--}}
                        {{--<li class="page-item paginate_button"><a class="page-link paginate_active" href="{{ $url }}">{{ $page }}</a></li>--}}
                    {{--@endif--}}
                {{--@endforeach--}}
            {{--@endif--}}
        {{--@endforeach--}}

        {{-- Next Page Link --}}
        {{--@if ($paginator->hasMorePages())--}}
            {{--<li class="page-item paginate_button"><a class="page-link paginate_active" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>--}}
        {{--@else--}}
            {{--<li class="page-item disabled"><span class="page-link paginate_active">&raquo;</span></li>--}}
        {{--@endif--}}
    {{--</ul>--}}
