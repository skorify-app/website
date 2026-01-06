@if ($paginator->hasPages())
    <nav style="display: inline-flex; gap: 5px;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span style="padding: 6px 12px; background-color: #e9ecef; color: #6c757d; border-radius: 4px; font-size: 14px; cursor: not-allowed;">‹ Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="padding: 6px 12px; background-color: #001D39; color: #fff; border-radius: 4px; font-size: 14px; text-decoration: none;">‹ Sebelumnya</a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span style="padding: 6px 12px; color: #6c757d; font-size: 14px;">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="padding: 6px 12px; background-color: #001D39; color: #fff; border-radius: 4px; font-size: 14px; font-weight: bold;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="padding: 6px 12px; background-color: #f8f9fa; color: #001D39; border-radius: 4px; font-size: 14px; text-decoration: none; border: 1px solid #dee2e6;">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="padding: 6px 12px; background-color: #001D39; color: #fff; border-radius: 4px; font-size: 14px; text-decoration: none;">Selanjutnya ›</a>
        @else
            <span style="padding: 6px 12px; background-color: #e9ecef; color: #6c757d; border-radius: 4px; font-size: 14px; cursor: not-allowed;">Selanjutnya ›</span>
        @endif
    </nav>
@endif
