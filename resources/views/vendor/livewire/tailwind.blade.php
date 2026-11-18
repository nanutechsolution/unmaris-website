@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Navigation" class="flex flex-col items-center gap-3">
            <div class="flex items-center justify-center w-full sm:w-auto">
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center justify-center min-h-[44px] px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md leading-5 cursor-default">
                        {{ __('pagination.previous') }}
                    </span>
                @else
                    <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before" class="relative inline-flex items-center justify-center min-h-[44px] px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md leading-5 hover:text-gray-500 focus:outline-none focus:ring ring-blue-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                        {{ __('pagination.previous') }}
                    </button>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span aria-disabled="true" class="relative inline-flex items-center justify-center min-h-[44px] px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md leading-5 cursor-default">
                            {{ $element }}
                        </span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}" class="relative inline-flex items-center justify-center min-h-[44px] px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md leading-5 cursor-default">
                                    {{ $page }}
                                </span>
                            @else
                                <button type="button" wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="relative inline-flex items-center justify-center min-h-[44px] px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md leading-5 hover:text-gray-500 focus:outline-none focus:ring ring-blue-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after" class="relative inline-flex items-center justify-center min-h-[44px] px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md leading-5 hover:text-gray-500 focus:outline-none focus:ring ring-blue-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                        {{ __('pagination.next') }}
                    </button>
                @else
                    <span class="relative inline-flex items-center justify-center min-h-[44px] px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md leading-5 cursor-default">
                        {{ __('pagination.next') }}
                    </span>
                @endif
            </div>

            <p class="text-xs text-gray-400">
                {{ __('Showing') }} {{ $paginator->firstItem() }} {{ __('to') }} {{ $paginator->lastItem() }} {{ __('of') }} {{ $paginator->total() }} {{ __('results') }}
            </p>
        </nav>
    @endif
</div>
