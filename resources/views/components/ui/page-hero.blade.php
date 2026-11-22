@props([
    'title',
    'eyebrow' => null,
    'description' => null,
    'breadcrumbs' => [],
    'align' => 'center',
])

@php
    $centered = $align === 'center';
@endphp

<section class="relative overflow-hidden bg-unmaris-blue text-white">
    <div class="pointer-events-none absolute inset-0 opacity-[0.07]" aria-hidden="true">
        <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
            <polygon points="0,100 100,0 100,100" />
        </svg>
    </div>
    <div class="pointer-events-none absolute -top-24 right-0 h-72 w-72 rounded-full bg-unmaris-yellow opacity-20 blur-[110px]" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -bottom-24 left-0 h-64 w-64 rounded-full bg-blue-400 opacity-20 blur-[100px]" aria-hidden="true"></div>

    <div class="container-page relative z-10 py-14 md:py-20">
        <div class="{{ $centered ? 'mx-auto max-w-3xl text-center' : 'max-w-4xl' }}">
            @if (! empty($breadcrumbs))
                <nav aria-label="Breadcrumb" class="mb-5 {{ $centered ? 'flex justify-center' : '' }}">
                    <ol class="flex flex-wrap items-center gap-x-2 gap-y-4 text-xs font-semibold text-white/60">
                        @foreach ($breadcrumbs as $crumb)
                            <li class="flex items-center gap-2">
                                @if (! $loop->first)
                                    <span class="text-white/30" aria-hidden="true">/</span>
                                @endif
                                @if (! empty($crumb['url']))
                                    <a href="{{ $crumb['url'] }}" class="-my-3.5 inline-flex min-h-11 items-center rounded transition hover:text-unmaris-yellow">{{ $crumb['label'] }}</a>
                                @else
                                    <span class="text-unmaris-yellow" aria-current="page">{{ $crumb['label'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>
            @endif

            @if ($eyebrow)
                <span class="eyebrow-light mb-4">{{ $eyebrow }}</span>
            @endif

            <h1 class="text-balance text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">
                {{ $title }}
            </h1>

            @if ($description)
                <p class="mt-5 text-base leading-relaxed text-slate-200 md:text-lg {{ $centered ? 'mx-auto max-w-2xl' : 'max-w-2xl' }}">
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
</section>
