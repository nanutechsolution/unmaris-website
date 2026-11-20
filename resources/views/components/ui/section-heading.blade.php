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

<div class="mb-10 flex flex-col gap-6 md:mb-14 {{ $centered ? 'items-center text-center' : 'md:flex-row md:items-end md:justify-between' }}">
    <div class="{{ $centered ? 'max-w-2xl' : 'max-w-2xl' }}">
        @if ($eyebrow)
            <span class="eyebrow mb-3">{{ $eyebrow }}</span>
        @endif

        <h2 class="heading-2 text-balance">{{ $title }}</h2>

        @if ($description)
            <p class="mt-3 text-sm leading-relaxed text-slate-600 md:text-base">{{ $description }}</p>
        @endif
    </div>

    @if ($href && $linkLabel)
        <a href="{{ $href }}" class="group inline-flex shrink-0 items-center gap-2 text-xs font-extrabold uppercase tracking-widest text-unmaris-blue transition hover:text-unmaris-blue/70">
            {{ $linkLabel }}
            <span class="grid h-9 w-9 place-items-center rounded-full bg-yellow-50 transition group-hover:bg-unmaris-yellow">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </span>
        </a>
    @endif
</div>
