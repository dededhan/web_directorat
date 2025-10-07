@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div class="flex flex-1 items-center justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-400">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-teal-600 hover:border-teal-300 hover:text-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-teal-600 hover:border-teal-300 hover:text-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative inline-flex items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-400">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-500">
                    {!! __('Showing') !!}
                    <span class="font-medium text-gray-900">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-medium text-gray-900">{{ $paginator->lastItem() }}</span>
                    {!! __('of') !!}
                    <span class="font-medium text-gray-900">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rounded-md shadow-sm">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span class="relative inline-flex items-center rounded-l-md border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-300">
                            <span class="sr-only">{{ __('pagination.previous') }}</span>
                            <i class='bx bx-chevron-left text-lg'></i>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center rounded-l-md border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-teal-600 hover:border-teal-300 hover:text-teal-700 focus:z-20 focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            <span class="sr-only">{{ __('pagination.previous') }}</span>
                            <i class='bx bx-chevron-left text-lg'></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span class="relative inline-flex items-center border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-400">{{ $element }}</span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="relative inline-flex items-center border border-teal-500 bg-teal-50 px-3 py-2 text-sm font-semibold text-teal-700 focus:z-20 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-teal-600 hover:border-teal-300 hover:text-teal-700 focus:z-20 focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center rounded-r-md border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-teal-600 hover:border-teal-300 hover:text-teal-700 focus:z-20 focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            <span class="sr-only">{{ __('pagination.next') }}</span>
                            <i class='bx bx-chevron-right text-lg'></i>
                        </a>
                    @else
                        <span class="relative inline-flex items-center rounded-r-md border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-300">
                            <span class="sr-only">{{ __('pagination.next') }}</span>
                            <i class='bx bx-chevron-right text-lg'></i>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
