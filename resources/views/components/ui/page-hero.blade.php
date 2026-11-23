@props([
    'title',
    'eyebrow' => null,
    'description' => null,
    'breadcrumbs' => [],
    'align' => 'left',
    'image' => null,
    'imageSrcset' => null,
    'imageSizes' => '(min-width: 1024px) 42vw, 100vw',
    'imageAlt' => '',
    'imagePosition' => 'center',
    'imageWidth' => 1600,
    'imageHeight' => 1066,
])

@php
    $centered = $align === 'center';
@endphp

<section class="relative isolate overflow-hidden border-b border-line bg-canvas">
    <div class="pointer-events-none absolute inset-0 surface-dots opacity-[0.35]" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -right-24 -top-24 hidden h-[26rem] w-[26rem] rounded-full bg-unmaris-yellow lg:block dark:opacity-75" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -right-10 top-1/2 hidden h-64 w-64 -translate-y-1/2 rounded-full border-[22px] border-unmaris-blue/10 lg:block dark:border-white/10" aria-hidden="true"></div>
    <div class="pointer-events-none absolute bottom-0 left-0 h-1.5 w-32 bg-unmaris-yellow md:w-48" aria-hidden="true"></div>

    <div class="container-page relative z-10 py-12 md:py-16 lg:py-20">
        <div class="{{ $image ? 'grid items-center gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:gap-14' : '' }}">
            <div class="{{ $centered ? 'mx-auto max-w-3xl text-center' : 'max-w-3xl' }}">
                @if (! empty($breadcrumbs))
                    <nav aria-label="Breadcrumb" class="{{ $centered ? 'flex justify-center' : '' }}">
                        <ol class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] font-semibold uppercase tracking-[0.1em] text-muted">
                            @foreach ($breadcrumbs as $crumb)
                                <li class="flex items-center gap-2">
                                    @if (! $loop->first)
                                        <svg class="h-3 w-3 text-line-strong" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    @endif
                                    @if (! empty($crumb['url']))
                                        <a href="{{ $crumb['url'] }}" class="inline-flex min-h-9 items-center rounded transition hover:text-brand-ink">{{ $crumb['label'] }}</a>
                                    @else
                                        <span class="text-brand-ink" aria-current="page">{{ $crumb['label'] }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                @endif

                <div class="mt-7">
                    @if ($eyebrow)
                        <span class="eyebrow mb-4">{{ $eyebrow }}</span>
                    @endif

                    <h1 class="page-title">{{ $title }}</h1>

                    @if ($description)
                        <p class="mt-5 max-w-2xl text-base leading-relaxed text-body md:text-lg {{ $centered ? 'mx-auto' : '' }}">
                            {{ $description }}
                        </p>
                    @endif

                    @if (! $slot->isEmpty())
                        <div class="mt-8 flex flex-wrap items-center gap-3 {{ $centered ? 'justify-center' : '' }}">
                            {{ $slot }}
                        </div>
                    @endif
                </div>
            </div>

            @if ($image)
                <figure class="relative">
                    <div class="relative overflow-hidden rounded-[1.75rem] border border-line bg-navy-deep shadow-[var(--shadow-lift)]"
                        style="aspect-ratio: {{ $imageWidth }} / {{ $imageHeight }}">
                        <picture>
                            @if ($imageSrcset)
                                <source type="image/webp" srcset="{{ $imageSrcset }}" sizes="{{ $imageSizes }}">
                            @endif
                            <img src="{{ $image }}"
                                alt="{{ $imageAlt }}" width="{{ $imageWidth }}" height="{{ $imageHeight }}"
                                fetchpriority="high" decoding="async"
                                class="h-full w-full object-cover"
                                style="object-position: {{ $imagePosition }}">
                        </picture>
                    </div>
                    <span class="absolute -bottom-3 left-6 h-1.5 w-24 rounded-full bg-unmaris-yellow" aria-hidden="true"></span>
                </figure>
            @endif
        </div>
    </div>
</section>
