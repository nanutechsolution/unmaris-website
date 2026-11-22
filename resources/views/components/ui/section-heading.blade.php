@props([
    'title',
    'eyebrow' => null,
    'description' => null,
    'align' => 'left',
    'href' => null,
    'linkLabel' => null,
])

@php
    $centered = $align === 'center';
@endphp

<div class="mb-10 flex flex-col gap-6 md:mb-12 {{ $centered ? 'items-center text-center' : 'md:flex-row md:items-end md:justify-between' }}">
    <div class="max-w-2xl">
        @if ($eyebrow)
            <span class="eyebrow mb-3">{{ $eyebrow }}</span>
        @endif

        <h2 class="heading-2">{{ $title }}</h2>

        @if ($description)
            <p class="mt-3 text-sm leading-relaxed text-body md:text-base">{{ $description }}</p>
        @endif

        <div class="mt-5 divider-yellow {{ $centered ? 'mx-auto' : '' }}"></div>
    </div>

    @if ($href && $linkLabel)
        <a href="{{ $href }}" class="link-arrow group shrink-0">
            {{ $linkLabel }}
            <span class="grid h-9 w-9 place-items-center rounded-full bg-unmaris-yellow text-[#1b0f52] transition group-hover:bg-navy-deep group-hover:text-unmaris-yellow">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </span>
        </a>
    @endif
</div>
