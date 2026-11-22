<x-layouts.app :title="$news->title . ' - UNMARIS'" :description="$news->excerpt" :ogImage="$news->featured_image ? url(Storage::url($news->featured_image)) : url('images/logo-unmaris.png')">
    <!-- JSON-LD Schema untuk Artikel (SEO) -->
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "Article",
            "headline": "{{ addslashes($news->title) }}",
            "datePublished": "{{ $news->published_at ? $news->published_at->toIso8601String() : '' }}",
            "dateModified": "{{ $news->updated_at->toIso8601String() }}",
            "author": [{
                "@@type": "Organization",
                "name": "Universitas Stella Maris Sumba",
                "url": "{{ url('images/logo-unmaris.png') }}"
            }],
            "description": "{{ addslashes($news->excerpt) }}",
            "image": "{{ $news->featured_image ? url(Storage::url($news->featured_image)) : url('images/logo-unmaris.png') }}"
        }
    </script>

    <!-- Bar progres baca -->
    <div class="pointer-events-none fixed left-0 top-0 z-[60] h-[3px] w-full" aria-hidden="true"
        x-data="{ scrollProgress: 0 }"
        x-on:scroll.window="
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            scrollProgress = height > 0 ? (winScroll / height) * 100 : 0;
        ">
        <div class="h-full bg-unmaris-yellow transition-all duration-150 motion-reduce:transition-none"
            :style="`width: ${scrollProgress}%`"></div>
    </div>

    @php
        $readTime = ceil(str_word_count(strip_tags($news->content)) / 200) ?: 1;
        $shareButtons = [
            ['platform' => 'facebook', 'label' => 'Facebook'],
            ['platform' => 'x', 'label' => 'X'],
            ['platform' => 'whatsapp', 'label' => 'WhatsApp'],
        ];
    @endphp

    <div class="bg-canvas pb-16 md:pb-24"
        x-data="{
            copied: false,
            copyText: 'Salin',
            async shareArticle(platform) {
                const url = encodeURIComponent(window.location.href);
                const title = encodeURIComponent(@js($news->title));
                let shareUrl = '';

                if (platform === 'facebook') shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                if (platform === 'whatsapp') shareUrl = `https://api.whatsapp.com/send?text=${title}%20${url}`;
                if (platform === 'x') shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;

                if (platform === 'copy') {
                    try {
                        await navigator.clipboard.writeText(window.location.href);
                    } catch (error) {
                        const tempInput = document.createElement('textarea');
                        tempInput.value = window.location.href;
                        tempInput.setAttribute('readonly', '');
                        tempInput.style.position = 'absolute';
                        tempInput.style.left = '-9999px';
                        document.body.appendChild(tempInput);
                        tempInput.select();
                        document.execCommand('copy');
                        document.body.removeChild(tempInput);
                    }

                    this.copied = true;
                    this.copyText = 'Tersalin';
                    setTimeout(() => {
                        this.copied = false;
                        this.copyText = 'Salin';
                    }, 2500);
                } else if (shareUrl) {
                    window.open(shareUrl, '_blank', 'noopener,noreferrer');
                }

                const csrfToken = document.querySelector('meta[name=\'csrf-token\']');
                if (csrfToken) {
                    fetch(@js(route('news.share.increment', $news->id)), {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    }).catch((error) => console.warn('Share stat error:', error));
                }
            }
        }">

        <!-- Kepala artikel -->
        <section class="relative overflow-hidden border-b border-line bg-canvas">
            <div class="pointer-events-none absolute inset-0 surface-dots opacity-30" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -right-24 -top-24 hidden h-80 w-80 rounded-full bg-unmaris-yellow lg:block dark:opacity-60" aria-hidden="true"></div>

            <div class="container-page relative z-10 py-8 md:py-12 lg:py-14">
                <div class="max-w-4xl">
                    <nav class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] font-semibold uppercase tracking-[0.08em] text-muted" aria-label="Breadcrumb">
                        <a href="{{ route('home') }}" class="focus-navy inline-flex min-h-9 items-center rounded transition-colors hover:text-brand-ink">Beranda</a>
                        <svg class="h-3 w-3 text-line-strong" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="{{ route('news.index') }}" class="focus-navy inline-flex min-h-9 items-center rounded transition-colors hover:text-brand-ink">Berita</a>
                        <svg class="h-3 w-3 text-line-strong" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-brand-ink" aria-current="page">{{ $news->category->name }}</span>
                    </nav>

                    <div class="mt-6 flex flex-wrap items-center gap-2">
                        <span class="chip-yellow">{{ $news->category->name }}</span>
                        @if ($news->video_url)
                            <span class="chip">
                                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                                Liputan Video
                            </span>
                        @endif
                    </div>

                    <h1 id="judul-artikel" class="mt-5 page-title break-words">
                        {{ $news->title }}
                    </h1>

                    @if ($news->excerpt)
                        <p class="mt-5 max-w-3xl text-base leading-relaxed text-body sm:text-lg">
                            {{ $news->excerpt }}
                        </p>
                    @endif

                    <div class="mt-7 flex flex-col gap-4 border-t-2 border-unmaris-yellow pt-5 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-3">
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-unmaris-yellow font-display text-sm font-bold text-[#1b0f52]" aria-hidden="true">
                                U
                            </span>
                            <div>
                                <p class="text-sm font-bold text-ink">Humas UNMARIS</p>
                                <p class="mt-0.5 flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] font-semibold text-muted">
                                    <time datetime="{{ $news->published_at?->toDateString() }}">
                                        {{ $news->published_at?->locale('id')->translatedFormat('d F Y') ?? '-' }}
                                    </time>
                                    <span aria-hidden="true">&bull;</span>
                                    <span>{{ $readTime }} menit baca</span>
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-1.5" role="group" aria-label="Bagikan artikel">
                            @foreach ($shareButtons as $share)
                                <button type="button" x-on:click="shareArticle('{{ $share['platform'] }}')"
                                    class="focus-navy inline-flex h-11 w-11 items-center justify-center rounded-full border border-line bg-surface text-brand-ink transition hover:border-unmaris-blue hover:bg-unmaris-blue hover:text-white"
                                    aria-label="Bagikan ke {{ $share['label'] }}" title="Bagikan ke {{ $share['label'] }}">
                                    @if ($share['platform'] === 'facebook')
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                        </svg>
                                    @elseif ($share['platform'] === 'x')
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.045 4.126H5.078z" />
                                        </svg>
                                    @else
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                        </svg>
                                    @endif
                                </button>
                            @endforeach

                            <button type="button" x-on:click="shareArticle('copy')"
                                class="focus-navy inline-flex h-11 items-center justify-center gap-2 rounded-full border border-line bg-surface px-4 text-[12px] font-bold text-brand-ink transition hover:border-unmaris-blue hover:bg-unmaris-blue hover:text-white"
                                :aria-label="copied ? 'Tautan tersalin' : 'Salin tautan artikel'" title="Salin tautan artikel">
                                <svg x-show="!copied" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                                <svg x-show="copied" style="display: none;" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span x-text="copyText">Salin</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Isi artikel -->
        <div class="container-page pt-8 md:pt-12">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-12 lg:gap-10">
                <div class="lg:col-span-8">
                    <article aria-labelledby="judul-artikel">
                        <!-- Gambar utama -->
                        <figure class="mb-6 md:mb-8">
                            <div class="overflow-hidden rounded-3xl border border-line bg-navy-deep shadow-[var(--shadow-soft)]">
                                @if ($news->featured_image)
                                    <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}"
                                        width="1200" height="675"
                                        class="aspect-video w-full object-cover">
                                @else
                                    <div class="relative flex aspect-[16/9] items-center justify-center overflow-hidden bg-navy-deep">
                                        <div class="pointer-events-none absolute inset-0 hero-grid opacity-60" aria-hidden="true"></div>
                                        <div class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-unmaris-yellow/15 blur-3xl" aria-hidden="true"></div>
                                        <div class="relative px-6 text-center">
                                            <img src="{{ asset('images/logo-unmaris.png') }}" alt="" width="80" height="80"
                                                class="mx-auto h-20 w-20 object-contain opacity-90">
                                            <p class="mt-4 text-[10px] font-extrabold uppercase tracking-[0.24em] text-unmaris-yellow">
                                                Dokumentasi Humas UNMARIS
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if ($news->featured_image)
                                <figcaption class="mt-2 text-[11px] font-medium text-muted">Foto: Humas UNMARIS</figcaption>
                            @endif
                        </figure>

                        <div class="rounded-3xl border border-line bg-surface p-5 shadow-[var(--shadow-soft)] sm:p-7 md:p-10">
                            <!-- Video pendukung -->
                            @if ($news->video_url)
                                @php
                                    $rawUrl = $news->video_url;
                                    $embedUrl = $rawUrl;
                                    $videoType = 'youtube';

                                    if (str_contains($rawUrl, 'youtube.com/watch?v=')) {
                                        $embedUrl = str_replace('watch?v=', 'embed/', $rawUrl);
                                        $embedUrl = explode('&', $embedUrl)[0];
                                    } elseif (str_contains($rawUrl, 'youtu.be/')) {
                                        $embedUrl = str_replace('youtu.be/', 'www.youtube.com/embed/', $rawUrl);
                                        $embedUrl = explode('?', $embedUrl)[0];
                                    } elseif (str_contains($rawUrl, 'tiktok.com')) {
                                        $videoType = 'tiktok';
                                        preg_match('/video\/(\d+)/', $rawUrl, $matches);
                                        if (isset($matches[1])) {
                                            $embedUrl = 'https://www.tiktok.com/embed/v2/' . $matches[1];
                                        }
                                    } elseif (str_contains($rawUrl, 'facebook.com') || str_contains($rawUrl, 'fb.watch')) {
                                        $videoType = 'facebook';
                                        $embedUrl = 'https://www.facebook.com/plugins/video.php?href=' . urlencode($rawUrl) . '&show_text=false&width=auto';
                                    }
                                @endphp

                                <div class="mb-8 overflow-hidden rounded-2xl border border-line {{ $videoType === 'tiktok' ? 'mx-auto max-w-sm' : '' }}">
                                    <div class="flex items-center gap-2 border-b border-line bg-unmaris-yellow px-4 py-2 text-[10px] font-extrabold uppercase tracking-[0.14em] text-[#1b0f52]">
                                        <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                        Liputan Media
                                    </div>
                                    <div class="w-full bg-black {{ $videoType === 'tiktok' ? 'aspect-[9/16]' : 'aspect-video' }}">
                                        <iframe class="h-full w-full" src="{{ $embedUrl }}" title="Video liputan: {{ $news->title }}"
                                            frameborder="0" loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe>
                                    </div>
                                </div>
                            @endif

                            <div class="prose-berita max-w-[68ch]">
                                {!! $news->content !!}
                            </div>

                            @if (isset($news->tags) && $news->tags->count() > 0)
                                <div class="mt-10 flex flex-wrap items-center gap-2 border-t border-line pt-6">
                                    <span class="mr-1 text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Topik:</span>
                                    @foreach ($news->tags as $tag)
                                        <a href="{{ route('news.index', ['tag' => $tag->name]) }}"
                                            class="focus-navy inline-flex min-h-11 items-center rounded-full border border-line bg-surface px-4 text-[12px] font-bold text-brand-ink transition hover:border-unmaris-blue hover:bg-unmaris-blue hover:text-white">
                                            #{{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Bilah berbagi -->
                            <section id="bagikan" aria-labelledby="bagikan-heading"
                                class="mt-10 rounded-2xl border border-line bg-surface-2 p-5 md:p-6">
                                <div class="flex flex-col gap-5">
                                    <div>
                                        <h2 id="bagikan-heading" class="heading-3">Bagikan artikel ini</h2>
                                        <p class="mt-1 text-sm leading-relaxed text-body">Bantu sebarkan informasi ini ke jaringan Anda.</p>
                                        <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-1 text-[11px] font-bold text-muted">
                                            <span class="inline-flex items-center gap-1.5">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                                {{ number_format($news->views) }} tayangan
                                            </span>
                                            <span class="inline-flex items-center gap-1.5">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                                </svg>
                                                {{ number_format($news->shares) }} dibagikan
                                            </span>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2 sm:grid-cols-4" role="group" aria-label="Pilihan berbagi artikel">
                                        @foreach ($shareButtons as $share)
                                            <button type="button" x-on:click="shareArticle('{{ $share['platform'] }}')"
                                                class="focus-navy inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-full border border-line bg-surface px-3 text-[12px] font-bold text-brand-ink transition hover:border-unmaris-blue hover:bg-unmaris-blue hover:text-white">
                                                @if ($share['platform'] === 'facebook')
                                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                                    </svg>
                                                @elseif ($share['platform'] === 'x')
                                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.045 4.126H5.078z" />
                                                    </svg>
                                                @else
                                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                                    </svg>
                                                @endif
                                                {{ $share['label'] }}
                                            </button>
                                        @endforeach
                                        <button type="button" x-on:click="shareArticle('copy')"
                                            class="focus-navy inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-full border border-line bg-surface px-3 text-[12px] font-bold text-brand-ink transition hover:border-unmaris-blue hover:bg-unmaris-blue hover:text-white">
                                            <svg x-show="!copied" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                            </svg>
                                            <svg x-show="copied" style="display: none;" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span x-text="copyText">Salin</span>
                                        </button>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- Kotak penulis -->
                        <section aria-labelledby="penulis-heading" class="mt-6 rounded-3xl border border-line bg-surface p-5 shadow-[var(--shadow-soft)] md:p-6">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                                <span class="grid h-16 w-16 shrink-0 place-items-center rounded-2xl bg-unmaris-yellow font-display text-xl font-bold text-[#1b0f52]" aria-hidden="true">
                                    U
                                </span>
                                <div>
                                    <p class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Ditulis oleh</p>
                                    <h2 id="penulis-heading" class="mt-1 heading-3">Humas UNMARIS</h2>
                                    <p class="text-sm font-semibold text-body">Departemen Publikasi &amp; Informasi</p>
                                    <p class="mt-2 text-sm leading-relaxed text-body">
                                        Berkomitmen menyajikan informasi akademik, riset, dan prestasi institusi secara tepat dan telus.
                                    </p>
                                </div>
                            </div>
                        </section>
                    </article>
                </div>

                <!-- Sidebar -->
                <aside class="lg:col-span-4" aria-labelledby="terpopuler-heading">
                    <div class="space-y-6 lg:sticky lg:top-24">
                        <section class="card p-5">
                            <div class="mb-3 flex items-center gap-3">
                                <span class="divider-yellow" aria-hidden="true"></span>
                                <h2 id="terpopuler-heading" class="heading-3">Terpopuler</h2>
                            </div>

                            <ol class="divide-y divide-line">
                                @forelse ($popularNews as $index => $popular)
                                    <li class="py-3.5 first:pt-1 last:pb-0">
                                        <article class="group flex items-start gap-3">
                                            <span class="w-6 shrink-0 pt-0.5 font-display text-xl font-bold tabular-nums text-line-strong transition-colors group-hover:text-unmaris-yellow" aria-hidden="true">
                                                {{ sprintf('%02d', $index + 1) }}
                                            </span>
                                            <div class="min-w-0">
                                                <h3 class="text-sm font-bold leading-snug text-ink">
                                                    <a href="{{ route('news.detail', $popular->slug) }}" class="focus-navy rounded transition-colors hover:text-brand-ink">
                                                        {{ $popular->title }}
                                                    </a>
                                                </h3>
                                                <div class="mt-1.5 flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] font-semibold text-muted">
                                                    <span class="text-brand-ink">{{ $popular->category->name }}</span>
                                                    <span aria-hidden="true">&bull;</span>
                                                    <span>{{ number_format($popular->views) }} tayangan</span>
                                                </div>
                                            </div>
                                        </article>
                                    </li>
                                @empty
                                    <li class="py-3 text-sm text-muted">Belum ada data berita populer.</li>
                                @endforelse
                            </ol>
                        </section>

                        <a href="{{ route('news.index') }}" class="btn-outline w-full">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke indeks berita
                        </a>
                    </div>
                </aside>
            </div>

            <!-- Berita terkait -->
            @if ($relatedNews->isNotEmpty())
                <section aria-labelledby="terkait-heading" class="mt-12 md:mt-16">
                    <div class="mb-5 flex items-center gap-3 md:mb-7">
                        <span class="divider-yellow" aria-hidden="true"></span>
                        <h2 id="terkait-heading" class="heading-3">Berita Terkait</h2>
                        <div class="h-px flex-1 bg-line" aria-hidden="true"></div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3">
                        @foreach ($relatedNews as $rel)
                            <article class="group flex h-full flex-row overflow-hidden rounded-3xl border border-line bg-surface transition duration-300 hover:-translate-y-1 hover:border-line-strong hover:shadow-[var(--shadow-lift)] motion-reduce:transition-none sm:flex-col">
                                <a href="{{ route('news.detail', $rel->slug) }}"
                                    class="focus-navy block w-28 shrink-0 self-stretch overflow-hidden bg-navy-deep sm:w-full sm:self-auto">
                                    @if ($rel->featured_image)
                                        <img src="{{ Storage::url($rel->featured_image) }}" alt="{{ $rel->title }}"
                                            width="480" height="270" loading="lazy"
                                            class="h-full w-full object-cover transition duration-700 group-hover:scale-105 motion-reduce:transition-none sm:aspect-[16/9] sm:h-auto">
                                    @else
                                        <div class="relative flex h-full w-full items-center justify-center overflow-hidden bg-navy-deep sm:aspect-[16/9] sm:h-auto">
                                            <div class="pointer-events-none absolute inset-0 hero-grid opacity-60" aria-hidden="true"></div>
                                            <img src="{{ asset('images/logo-unmaris.png') }}" alt="" width="40" height="40"
                                                loading="lazy" class="relative h-10 w-10 object-contain opacity-80 sm:h-12 sm:w-12">
                                        </div>
                                    @endif
                                </a>

                                <div class="flex min-w-0 flex-1 flex-col p-4">
                                    <span class="mb-1.5 text-[9px] font-extrabold uppercase tracking-[0.12em] text-brand-ink">{{ $rel->category->name }}</span>
                                    <h3 class="font-display text-sm font-bold leading-snug text-ink sm:text-base">
                                        <a href="{{ route('news.detail', $rel->slug) }}" class="focus-navy rounded transition-colors hover:text-brand-ink">
                                            {{ $rel->title }}
                                        </a>
                                    </h3>
                                    <time datetime="{{ $rel->published_at?->toDateString() }}"
                                        class="mt-2 text-[11px] font-semibold text-muted">
                                        {{ $rel->published_at?->locale('id')->translatedFormat('d M Y') ?? '-' }}
                                    </time>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>
</x-layouts.app>
