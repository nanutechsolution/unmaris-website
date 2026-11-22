<div class="bg-canvas pb-16 md:pb-24">
    <x-ui.page-hero title="Berita & Publikasi" eyebrow="Pusat Media Resmi"
        description="Jendela informasi mengenai terobosan riset, prestasi, dan dinamika akademik di Universitas Stella Maris Sumba."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Berita & Publikasi'],
        ]" />

    <div class="container-page py-8 md:py-12">
        @php
            $activeCategory = $selectedCategory ? $categories->firstWhere('id', $selectedCategory) : null;
            $filterActive = $search || $selectedCategory || $tag;
        @endphp

        <!-- Panel pencarian & filter -->
        <section aria-labelledby="filter-heading"
            class="relative z-10 -mt-8 rounded-3xl border border-line bg-surface p-4 shadow-[var(--shadow-lift)] md:-mt-10 md:p-5">
            <h2 id="filter-heading" class="sr-only">Filter berita</h2>

            <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                <div class="hide-scrollbar -mx-1 flex w-full min-w-0 snap-x items-center gap-2 overflow-x-auto px-1 pb-1">
                    <button type="button" wire:click="filterCategory(null)" wire:key="category-all"
                        aria-pressed="{{ is_null($selectedCategory) ? 'true' : 'false' }}"
                        class="focus-navy inline-flex min-h-11 shrink-0 snap-start items-center justify-center rounded-full px-4 text-[13px] font-bold transition {{ is_null($selectedCategory) ? 'bg-unmaris-blue text-white shadow-[0_10px_20px_-12px_rgba(40,22,111,0.9)]' : 'border border-line-strong bg-surface text-body hover:border-unmaris-blue hover:text-brand-ink' }}">
                        Semua Berita
                    </button>
                    @foreach ($categories as $cat)
                        <button type="button" wire:click="filterCategory('{{ $cat->id }}')" wire:key="category-{{ $cat->id }}"
                            aria-pressed="{{ $selectedCategory == $cat->id ? 'true' : 'false' }}"
                            class="focus-navy inline-flex min-h-11 shrink-0 snap-start items-center justify-center rounded-full px-4 text-[13px] font-bold transition {{ $selectedCategory == $cat->id ? 'bg-unmaris-blue text-white shadow-[0_10px_20px_-12px_rgba(40,22,111,0.9)]' : 'border border-line-strong bg-surface text-body hover:border-unmaris-blue hover:text-brand-ink' }}">
                            {{ $cat->name }}
                        </button>
                    @endforeach
                </div>

                <div class="relative w-full shrink-0 xl:w-80">
                    <label for="pencarian-berita" class="sr-only">Cari artikel atau berita</label>
                    <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-muted" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />
                    </svg>
                    <input id="pencarian-berita" wire:model.live.debounce.500ms="search" type="search"
                        placeholder="Cari artikel atau berita…" autocomplete="off"
                        class="form-input min-h-11 rounded-full py-2.5 pl-11 pr-4">
                </div>
            </div>

            <div class="mt-4 flex flex-wrap items-center justify-between gap-3 border-t border-line pt-3.5">
                <p class="text-[13px] font-medium text-body" role="status" aria-live="polite">
                    Menampilkan <span class="font-bold text-brand-ink">{{ $news->total() }}</span> berita
                    @if ($activeCategory)
                        dalam kategori <span class="font-bold text-ink">{{ $activeCategory->name }}</span>
                    @endif
                    @if ($search)
                        untuk pencarian <span class="font-bold text-ink">&ldquo;{{ $search }}&rdquo;</span>
                    @endif
                </p>

                <div class="flex flex-wrap items-center gap-2">
                    @if ($tag)
                        <span class="inline-flex min-h-11 items-center gap-1 rounded-full bg-unmaris-yellow py-1 pl-3 pr-1 text-[12px] font-extrabold uppercase tracking-[0.06em] text-[#1b0f52]">
                            #{{ $tag }}
                            <button type="button" wire:click="clearTag"
                                class="focus-navy inline-flex h-9 w-9 items-center justify-center rounded-full transition hover:bg-[#1b0f52] hover:text-unmaris-yellow"
                                aria-label="Hapus filter tagar {{ $tag }}" title="Hapus filter tagar">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </span>
                    @endif

                    @if ($filterActive)
                        <a href="{{ route('news.index') }}" class="btn-ghost btn-sm">
                            Atur ulang filter
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <!-- Laporan utama -->
        @if ($featuredNews && $news->onFirstPage() && ! $search && ! $selectedCategory && ! $tag)
            @php
                $heroReadTime = ceil(str_word_count(strip_tags($featuredNews->content)) / 200) ?: 1;
            @endphp
            <section aria-labelledby="lead-story-heading" class="mt-8 md:mt-12">
                <div class="mb-5 flex items-center gap-3">
                    <span class="divider-yellow" aria-hidden="true"></span>
                    <p class="text-[11px] font-extrabold uppercase tracking-[0.2em] text-brand-ink">Laporan Utama</p>
                    <div class="h-px flex-1 bg-line" aria-hidden="true"></div>
                </div>

                <article class="overflow-hidden rounded-[2rem] border border-line bg-surface shadow-[var(--shadow-soft)]">
                    <div class="grid grid-cols-1 lg:grid-cols-12">
                        <a href="{{ route('news.detail', $featuredNews->slug) }}"
                            class="focus-navy group relative block overflow-hidden bg-navy-deep lg:col-span-7">
                            @if ($featuredNews->featured_image)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($featuredNews->featured_image) }}"
                                    alt="{{ $featuredNews->title }}" width="900" height="563" loading="eager"
                                    class="aspect-[16/10] h-full w-full object-cover transition duration-700 group-hover:scale-[1.03] motion-reduce:transition-none">
                            @else
                                <div class="relative flex aspect-[16/10] items-center justify-center overflow-hidden bg-navy-deep">
                                    <div class="pointer-events-none absolute inset-0 hero-grid opacity-70" aria-hidden="true"></div>
                                    <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-unmaris-yellow/20 blur-3xl" aria-hidden="true"></div>
                                    <div class="absolute left-6 top-6">
                                        <span class="chip-yellow">{{ $featuredNews->category->name }}</span>
                                    </div>
                                    <div class="relative px-6 text-center">
                                        <img src="{{ asset('images/logo-unmaris.png') }}" alt="" width="80" height="80"
                                            class="mx-auto h-20 w-20 object-contain opacity-90">
                                        <p class="mt-4 text-[10px] font-extrabold uppercase tracking-[0.24em] text-unmaris-yellow">
                                            Laporan Utama
                                        </p>
                                        <p class="mt-1 font-display text-sm font-bold text-white/50">Humas UNMARIS</p>
                                    </div>
                                </div>
                            @endif

                            @if ($featuredNews->video_url)
                                <span class="absolute bottom-4 right-4 inline-flex items-center gap-1.5 rounded-full bg-unmaris-yellow px-3 py-1.5 text-[11px] font-extrabold uppercase tracking-[0.08em] text-[#1b0f52]">
                                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                    Video
                                </span>
                            @endif
                        </a>

                        <div class="flex flex-col justify-center p-6 sm:p-8 lg:col-span-5 lg:p-10">
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-2 text-[10px] font-extrabold uppercase tracking-[0.14em]">
                                <span class="text-brand-ink">{{ $featuredNews->category->name }}</span>
                                <span class="h-1 w-1 rounded-full bg-line-strong" aria-hidden="true"></span>
                                <span class="text-muted">{{ $featuredNews->published_at?->locale('id')->translatedFormat('d M Y') ?? '-' }}</span>
                            </div>

                            <h2 id="lead-story-heading" class="mt-4 font-display text-2xl font-bold leading-[1.1] text-ink sm:text-3xl lg:text-[2.15rem]">
                                <a href="{{ route('news.detail', $featuredNews->slug) }}" class="focus-navy rounded transition-colors hover:text-brand-ink">
                                    {{ $featuredNews->title }}
                                </a>
                            </h2>

                            <p class="mt-4 line-clamp-3 text-sm leading-relaxed text-body sm:text-base">
                                {{ $featuredNews->excerpt }}
                            </p>

                            <div class="mt-6 flex flex-wrap items-center gap-x-4 gap-y-2 text-[12px] font-semibold text-muted">
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <circle cx="12" cy="12" r="9" />
                                        <path stroke-linecap="round" d="M12 7v5l3 2" />
                                    </svg>
                                    {{ $heroReadTime }} menit baca
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    {{ number_format($featuredNews->views) }} tayangan
                                </span>
                            </div>

                            <a href="{{ route('news.detail', $featuredNews->slug) }}" class="btn-navy focus-navy mt-7 w-full sm:w-auto">
                                {{ $featuredNews->video_url ? 'Tonton Video' : 'Baca Selengkapnya' }}
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
            </section>
        @endif

        <div class="mt-10 grid grid-cols-1 gap-8 lg:grid-cols-12 lg:gap-10 md:mt-14">
            <!-- Daftar berita -->
            <div class="lg:col-span-8">
                <div class="mb-5 flex items-center gap-3 md:mb-7">
                    <span class="divider-yellow" aria-hidden="true"></span>
                    <h2 class="heading-3">Berita Terbaru</h2>
                    <div class="h-px flex-1 bg-line" aria-hidden="true"></div>
                    <span class="inline-flex min-h-7 min-w-7 items-center justify-center rounded-full bg-surface-2 px-2 text-[12px] font-bold text-body">
                        {{ $news->total() }}
                    </span>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:gap-6">
                    @forelse ($news as $item)
                        @php
                            $readTime = ceil(str_word_count(strip_tags($item->content)) / 200) ?: 1;
                        @endphp
                        <article wire:key="news-{{ $item->id }}"
                            class="group flex h-full flex-col overflow-hidden rounded-3xl border border-line bg-surface transition duration-300 hover:-translate-y-1 hover:border-line-strong hover:shadow-[var(--shadow-lift)] motion-reduce:transition-none">
                            <a href="{{ route('news.detail', $item->slug) }}"
                                class="focus-navy group relative block overflow-hidden bg-navy-deep">
                                @if ($item->featured_image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($item->featured_image) }}"
                                        alt="{{ $item->title }}" width="640" height="360" loading="lazy"
                                        class="aspect-[16/9] w-full object-cover transition duration-700 group-hover:scale-105 motion-reduce:transition-none">
                                @else
                                    <div class="relative flex aspect-[16/9] items-center justify-center overflow-hidden bg-navy-deep">
                                        <div class="pointer-events-none absolute inset-0 hero-grid opacity-60" aria-hidden="true"></div>
                                        <div class="pointer-events-none absolute -right-10 -top-10 h-32 w-32 rounded-full bg-unmaris-yellow/15 blur-2xl" aria-hidden="true"></div>
                                        <img src="{{ asset('images/logo-unmaris.png') }}" alt="" width="56" height="56"
                                            loading="lazy" class="relative h-14 w-14 object-contain opacity-80">
                                    </div>
                                @endif

                                @if ($item->video_url)
                                    <span class="absolute bottom-3 right-3 inline-flex items-center gap-1.5 rounded-full bg-unmaris-yellow px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-[0.08em] text-[#1b0f52]">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                        Video
                                    </span>
                                @endif
                            </a>

                            <div class="flex flex-1 flex-col p-5">
                                <div class="mb-2.5 flex flex-wrap items-center gap-x-2.5 gap-y-1 text-[10px] font-extrabold uppercase tracking-[0.12em]">
                                    <span class="text-brand-ink">{{ $item->category->name }}</span>
                                    <span class="h-1 w-1 rounded-full bg-line-strong" aria-hidden="true"></span>
                                    <time class="text-muted" datetime="{{ $item->published_at?->toDateString() }}">
                                        {{ $item->published_at?->locale('id')->translatedFormat('d M Y') ?? '-' }}
                                    </time>
                                </div>

                                <h3 class="font-display text-lg font-bold leading-snug text-ink md:text-xl">
                                    <a href="{{ route('news.detail', $item->slug) }}" class="focus-navy rounded transition-colors hover:text-brand-ink">
                                        {{ $item->title }}
                                    </a>
                                </h3>

                                @if ($item->excerpt)
                                    <p class="mt-2.5 line-clamp-3 text-[13px] leading-relaxed text-body">
                                        {{ $item->excerpt }}
                                    </p>
                                @endif

                                <div class="mt-auto flex items-center justify-between gap-3 border-t border-line pt-4 text-[11px] font-semibold text-muted">
                                    <span>{{ $readTime }} menit baca</span>
                                    <span class="inline-flex items-center gap-1.5">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        {{ number_format($item->views) }}
                                    </span>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full">
                            <x-ui.empty-state title="Belum ada publikasi"
                                description="Silakan sesuaikan kata kunci pencarian atau filter kategori Anda.">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 8H20" />
                                </svg>
                            </x-ui.empty-state>
                        </div>
                    @endforelse
                </div>

                @if ($news->hasPages())
                    <div class="news-pagination mt-9 flex justify-center md:mt-11">
                        {{ $news->links() }}
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-4" aria-labelledby="terpopuler-heading">
                <div class="space-y-6 lg:sticky lg:top-24">
                    <section class="card p-5 md:p-6">
                        <div class="mb-3 flex items-center gap-3">
                            <span class="divider-yellow" aria-hidden="true"></span>
                            <h2 id="terpopuler-heading" class="heading-3">Terpopuler</h2>
                        </div>

                        <ol class="divide-y divide-line">
                            @forelse ($trendingNews as $index => $trend)
                                <li wire:key="trend-{{ $trend->id }}" class="py-3.5 first:pt-1 last:pb-0">
                                    <article class="group flex items-start gap-3">
                                        <span class="w-6 shrink-0 pt-0.5 font-display text-xl font-bold tabular-nums text-line-strong transition-colors group-hover:text-unmaris-yellow" aria-hidden="true">
                                            {{ sprintf('%02d', $index + 1) }}
                                        </span>
                                        <div class="min-w-0">
                                            <h3 class="text-sm font-bold leading-snug text-ink">
                                                <a href="{{ route('news.detail', $trend->slug) }}" class="focus-navy rounded transition-colors hover:text-brand-ink">
                                                    {{ $trend->title }}
                                                </a>
                                            </h3>
                                            <div class="mt-1.5 flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] font-semibold text-muted">
                                                <span class="text-brand-ink">{{ $trend->category->name }}</span>
                                                <span aria-hidden="true">&bull;</span>
                                                <span>{{ number_format($trend->views) }} tayangan</span>
                                            </div>
                                        </div>
                                    </article>
                                </li>
                            @empty
                                <li class="py-3 text-sm text-muted">Belum ada data berita populer.</li>
                            @endforelse
                        </ol>
                    </section>

                    <section class="relative overflow-hidden rounded-3xl bg-navy-deep p-6 text-white md:p-7" aria-labelledby="pembaruan-heading">
                        <div class="pointer-events-none absolute inset-0 hero-grid opacity-60" aria-hidden="true"></div>
                        <div class="pointer-events-none absolute -right-10 -top-10 h-36 w-36 rounded-full bg-unmaris-yellow/20 blur-2xl" aria-hidden="true"></div>
                        <div class="relative">
                            <span class="eyebrow-light mb-3">Tetap Terhubung</span>
                            <h2 id="pembaruan-heading" class="font-display text-2xl font-bold leading-tight text-white">
                                Dapatkan pembaruan kampus
                            </h2>
                            <p class="mt-2.5 text-sm leading-relaxed text-white/65">
                                Ikuti kanal resmi UNMARIS untuk kabar akademik, riset, dan prestasi terbaru.
                            </p>
                            <a href="{{ route('contact') }}" class="btn-primary mt-5 w-full">
                                Hubungi Kami
                            </a>
                        </div>
                    </section>
                </div>
            </aside>
        </div>
    </div>
</div>
