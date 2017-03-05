@if ($paginator->hasPages())
  <ul class="pagination text-center" role="navigation" aria-label="Pagination">
    @if ($paginator->onFirstPage())
      <li class="pagination-previous disabled">@lang('view.page_prev')</li>
    @else
      <li class="pagination-previous"><a href="{{ $paginator->previousPageUrl() }}" aria-label="{{ __('view.page_prev') }}">@lang('view.page_prev')</a></li>
    @endif

    @foreach ($elements as $element)
      @if(is_string($element))
        <li class="ellipsis"></li>
      @endif

      @if(is_array($element))
        @foreach ($element as $page => $url)
          @if($page == $paginator->currentPage())
            <li class="current"><span class="show-for-sr">@lang('view.page_current')</span> {{ $page }}</li>
          @else
            <li><a href="{{ $url }}" aria-label="Page {{ $page }}">{{ $page }}</a></li>
          @endif
        @endforeach
      @endif
    @endforeach

    @if ($paginator->hasMorePages())
      <li class="pagination-next"><a href="{{ $paginator->nextPageUrl() }}" aria-label="{{ __('view.page_next') }}">@lang('view.page_next')</a></li>
    @else
      <li class="pagination-next disabled">@lang('view.page_next')</li>
    @endif
  </ul>
@endif
