<div class="min-h-screen bg-slate-50 pb-16 md:pb-24">
    <x-ui.page-hero title="Berita & Publikasi" eyebrow="Pusat Media Resmi"
        description="Jendela informasi mengenai terobosan riset, prestasi global, dan dinamika akademik di Universitas Stella Maris Sumba."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Berita & Publikasi'],
        ]" />

    <div class="container-page py-8 md:py-12">
        @php
            $activeCategory = $selectedCategory ? $categories->firstWhere('id', $selectedCategory) : null;
        @endphp

        <!-- Panel Pencarian & Filter -->
        <section aria-labelledby="filter-heading" class="mb-8 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm md:mb-12 md:p-5">
            <h2 id="filter-heading" class="sr-only">Filter berita</h2>

            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <!-- Tab Kategori -->
                <div class="hide-scrollbar -mx-1 flex w-full min-w-0 snap-x items-center gap-2 overflow-x-auto px-1 pb-1">
                    <button type="button" wire:click="filterCategory(null)" wire:key="category-all"
                        aria-pressed="{{ is_null($selectedCategory) ? 'true' : 'false' }}"
                        class="focus-navy inline-flex min-h-11 shrink-0 snap-start items-center justify-center rounded-full px-4 text-sm font-semibold transition {{ is_null($selectedCategory) ? 'bg-unmaris-blue text-white shadow-sm' : 'border border-slate-300 bg-white text-slate-700 hover:border-unmaris-blue hover:text-unmaris-blue' }}">
                        Semua Berita
                    </button>
                    @foreach($categories as $cat)
                    <button type="button" wire:click="filterCategory('{{ $cat->id }}')" wire:key="category-{{ $cat->id }}"
                        aria-pressed="{{ $selectedCategory == $cat->id ? 'true' : 'false' }}"
                        class="focus-navy inline-flex min-h-11 shrink-0 snap-start items-center justify-center rounded-full px-4 text-sm font-semibold transition {{ $selectedCategory == $cat->id ? 'bg-unmaris-blue text-white shadow-sm' : 'border border-slate-300 bg-white text-slate-700 hover:border-unmaris-blue hover:text-unmaris-blue' }}">
                        {{ $cat->name }}
                    </button>
                    @endforeach
                </div>

                <!-- Pencarian -->
                <div class="relative w-full shrink-0 lg:w-80">
                    <label for="pencarian-berita" class="sr-only">Cari artikel atau berita</label>
                    <input id="pencarian-berita" wire:model.live.debounce.500ms="search" type="search"
                        placeholder="Cari artikel atau berita..."
                        class="min-h-11 w-full rounded-full border border-slate-300 bg-slate-50 py-2.5 pl-11 pr-4 text-sm font-medium text-slate-900 outline-none transition placeholder:text-slate-500 focus:border-unmaris-blue focus:ring-2 focus:ring-unmaris-blue">
                    <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Ringkasan Hasil -->
            <div class="mt-4 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-3">
                <p class="text-[13px] font-medium text-slate-600" role="status" aria-live="polite">
                    Menampilkan <span class="font-bold text-unmaris-blue">{{ $news->total() }}</span> berita
                    @if($activeCategory)
                    dalam kategori <span class="font-bold text-slate-900">{{ $activeCategory->name }}</span>
                    @endif
                    @if($search)
                    untuk pencarian <span class="font-bold text-slate-900">&ldquo;{{ $search }}&rdquo;</span>
                    @endif
                </p>

                @if($tag)
                <span class="inline-flex min-h-11 items-center gap-1 rounded-full bg-unmaris-yellow py-1 pl-3 pr-1 text-[12px] font-extrabold uppercase tracking-wider text-unmaris-blue">
                    #{{ $tag }}
                    <button type="button" wire:click="clearTag"
                        class="focus-navy inline-flex h-11 w-11 items-center justify-center rounded-full transition hover:bg-unmaris-blue hover:text-white"
                        aria-label="Hapus filter tagar {{ $tag }}" title="Hapus filter tagar">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </span>
                @endif
            </div>
        </section>

        <!-- Laporan Utama -->
        @if($featuredNews && $news->onFirstPage() && !$search && !$selectedCategory && !$tag)
        @php
            $heroReadTime = ceil(str_word_count(strip_tags($featuredNews->content)) / 200) ?: 1;
        @endphp
        <section aria-labelledby="lead-story-heading" class="mb-10 md:mb-14">
            <div class="mb-4 flex items-center gap-3">
                <span class="h-5 w-1 rounded-full bg-unmaris-blue" aria-hidden="true"></span>
                <p class="text-[12px] font-extrabold uppercase tracking-[0.2em] text-unmaris-blue">Laporan Utama</p>
                <div class="h-px flex-1 bg-slate-200" aria-hidden="true"></div>
            </div>

            <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="grid grid-cols-1 lg:grid-cols-12">
                    <!-- Gambar (tanpa teks di atas foto) -->
                    <a href="{{ route('news.detail', $featuredNews->slug) }}"
                        class="focus-navy group relative block overflow-hidden bg-slate-100 lg:col-span-7">
                        @if($featuredNews->featured_image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($featuredNews->featured_image) }}"
                            alt="{{ $featuredNews->title }}"
                            class="aspect-[16/10] h-full w-full object-cover transition duration-500 group-hover:scale-[1.03] motion-reduce:transition-none">
                        @else
                        <div class="relative flex aspect-[16/10] items-center justify-center overflow-hidden bg-unmaris-blue">
                            <svg class="absolute inset-0 h-full w-full text-white opacity-10" fill="none" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                                <pattern id="lead-pattern-{{ $featuredNews->id }}" x="0" y="0" width="12" height="12" patternUnits="userSpaceOnUse">
                                    <circle cx="2" cy="2" r="1.4" fill="currentColor" />
                                </pattern>
                                <rect width="100" height="100" fill="url(#lead-pattern-{{ $featuredNews->id }})" />
                            </svg>
                            <img src="{{ asset('images/logo-unmaris.png') }}" alt=""
                                class="relative h-16 w-auto opacity-25 md:h-20" loading="lazy">
                        </div>
                        @endif

                        @if($featuredNews->video_url)
                        <span class="absolute bottom-3 right-3 inline-flex items-center gap-1.5 rounded-full bg-unmaris-blue px-3 py-1.5 text-[12px] font-bold text-white">
                            <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                            Video
                        </span>
                        @endif
                    </a>

                    <!-- Panel Konten -->
                    <div class="flex flex-col justify-center p-5 sm:p-7 lg:col-span-5 lg:p-8">
                        <div class="mb-3 flex flex-wrap items-center gap-2">
                            <span class="inline-flex rounded-full bg-unmaris-yellow px-3 py-1 text-[12px] font-extrabold uppercase tracking-wider text-unmaris-blue">
                                {{ $featuredNews->category->name }}
                            </span>
                        </div>

                        <h2 id="lead-story-heading" class="text-balance font-display text-2xl font-extrabold leading-tight text-slate-900 sm:text-3xl lg:text-4xl">
                            <a href="{{ route('news.detail', $featuredNews->slug) }}"
                                class="focus-navy rounded transition-colors hover:text-unmaris-blue">
                                {{ $featuredNews->title }}
                            </a>
                        </h2>

                        <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-slate-600 sm:text-base">
                            {{ $featuredNews->excerpt }}
                        </p>

                        <div class="mt-5 flex flex-wrap items-center gap-x-3 gap-y-2 text-[13px] font-medium text-slate-600">
                            <time datetime="{{ $featuredNews->published_at?->toDateString() }}">
                                {{ $featuredNews->published_at?->locale('id')->translatedFormat('d M Y') ?? '-' }}
                            </time>
                            <span aria-hidden="true">&bull;</span>
                            <span>{{ $heroReadTime }} menit baca</span>
                        </div>

                        <div class="mt-6 flex flex-wrap items-center gap-4">
                            <a href="{{ route('news.detail', $featuredNews->slug) }}" class="btn-navy focus-navy w-full sm:w-auto">
                                {{ $featuredNews->video_url ? 'Tonton Video' : 'Baca Selengkapnya' }}
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                            <span class="inline-flex items-center gap-1.5 text-[13px] font-medium text-slate-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ number_format($featuredNews->views) }} tayangan
                            </span>
                        </div>
                    </div>
                </div>
            </article>
        </section>
        @endif

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12 lg:gap-10">
            <!-- Feed Berita -->
            <div class="lg:col-span-8">
                <div class="mb-5 flex items-center gap-3 md:mb-7">
                    <span class="h-5 w-1 rounded-full bg-unmaris-blue" aria-hidden="true"></span>
                    <h2 class="heading-3">Berita Terbaru</h2>
                    <div class="h-px flex-1 bg-slate-200" aria-hidden="true"></div>
                    <span class="inline-flex min-h-7 min-w-7 items-center justify-center rounded-full bg-slate-100 px-2 text-[12px] font-bold text-slate-600">
                        {{ $news->total() }}
                    </span>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:gap-6">
                    @forelse($news as $item)
                    @php
                        $readTime = ceil(str_word_count(strip_tags($item->content)) / 200) ?: 1;
                    @endphp
                    <article wire:key="news-{{ $item->id }}"
                        class="group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:border-slate-300 hover:shadow-lg motion-reduce:transition-none">
                        <a href="{{ route('news.detail', $item->slug) }}"
                            class="focus-navy group relative block overflow-hidden bg-slate-100">
                            @if($item->featured_image)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($item->featured_image) }}"
                                alt="{{ $item->title }}"
                                class="aspect-[16/9] w-full object-cover transition duration-500 group-hover:scale-105 motion-reduce:transition-none">
                            @else
                            <div class="relative flex aspect-[16/9] items-center justify-center overflow-hidden bg-unmaris-blue">
                                <svg class="absolute inset-0 h-full w-full text-white opacity-10" fill="none" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                                    <pattern id="card-pattern-{{ $item->id }}" x="0" y="0" width="12" height="12" patternUnits="userSpaceOnUse">
                                        <circle cx="2" cy="2" r="1.4" fill="currentColor" />
                                    </pattern>
                                    <rect width="100" height="100" fill="url(#card-pattern-{{ $item->id }})" />
                                </svg>
                                <img src="{{ asset('images/logo-unmaris.png') }}" alt=""
                                    class="relative h-12 w-auto opacity-25" loading="lazy">
                            </div>
                            @endif

                            @if($item->video_url)
                            <span class="absolute bottom-3 right-3 inline-flex items-center gap-1.5 rounded-full bg-unmaris-blue px-2.5 py-1 text-[12px] font-bold text-white">
                                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                                Video
                            </span>
                            @endif
                        </a>

                        <div class="flex flex-1 flex-col p-4 md:p-5">
                            <span class="mb-2 inline-flex w-fit rounded-full bg-yellow-50 px-2.5 py-1 text-[12px] font-extrabold uppercase tracking-wider text-unmaris-blue">
                                {{ $item->category->name }}
                            </span>

                            <h3 class="text-lg font-bold leading-snug text-slate-900 md:text-xl">
                                <a href="{{ route('news.detail', $item->slug) }}"
                                    class="focus-navy rounded transition-colors hover:text-unmaris-blue">
                                    {{ $item->title }}
                                </a>
                            </h3>

                            <p class="mt-2 line-clamp-2 text-[13px] leading-relaxed text-slate-600 md:text-sm">
                                {{ $item->excerpt }}
                            </p>

                            <div class="mt-3 flex flex-wrap items-center gap-x-2.5 gap-y-1 text-[12px] font-medium text-slate-600 md:text-[13px]">
                                <time datetime="{{ $item->published_at?->toDateString() }}">
                                    {{ $item->published_at?->locale('id')->translatedFormat('d M Y') ?? '-' }}
                                </time>
                                <span aria-hidden="true">&bull;</span>
                                <span>{{ $readTime }} menit baca</span>
                            </div>

                            <div class="mt-auto flex items-center justify-between gap-3 border-t border-slate-100 pt-3">
                                <a href="{{ route('news.detail', $item->slug) }}"
                                    class="focus-navy inline-flex min-h-11 items-center gap-1.5 rounded text-sm font-bold text-unmaris-blue transition hover:underline">
                                    {{ $item->video_url ? 'Tonton Video' : 'Baca Artikel' }}
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                                <span class="inline-flex items-center gap-1 text-[12px] font-medium text-slate-600">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    {{ number_format($item->views) }}
                                </span>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div class="col-span-full">
                        <x-ui.empty-state title="Belum Ada Publikasi"
                            description="Silakan sesuaikan kata kunci pencarian atau filter kategori Anda.">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 8H20" />
                            </svg>
                        </x-ui.empty-state>
                    </div>
                    @endforelse
                </div>

                <div class="news-pagination mt-8 flex justify-center md:mt-10">
                    {{ $news->links() }}
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-4" aria-labelledby="terpopuler-heading">
                <div class="space-y-6 lg:sticky lg:top-24">
                    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm md:p-5">
                        <div class="mb-2 flex items-center gap-3">
                            <span class="h-5 w-1 rounded-full bg-unmaris-blue" aria-hidden="true"></span>
                            <h2 id="terpopuler-heading" class="text-lg font-extrabold text-slate-900">Terpopuler</h2>
                        </div>

                        <ol class="divide-y divide-slate-100">
                            @forelse($trendingNews as $index => $trend)
                            <li wire:key="trend-{{ $trend->id }}" class="py-3 first:pt-1 last:pb-0">
                                <article class="group flex items-start gap-3">
                                    <span class="w-6 shrink-0 pt-0.5 text-xl font-extrabold tabular-nums text-slate-300 transition-colors group-hover:text-unmaris-blue" aria-hidden="true">
                                        {{ sprintf('%02d', $index + 1) }}
                                    </span>
                                    <div class="min-w-0">
                                        <h3 class="text-sm font-bold leading-snug text-slate-900 md:text-[15px]">
                                            <a href="{{ route('news.detail', $trend->slug) }}"
                                                class="focus-navy rounded transition-colors hover:text-unmaris-blue">
                                                {{ $trend->title }}
                                            </a>
                                        </h3>
                                        <div class="mt-1.5 flex flex-wrap items-center gap-x-2 gap-y-1 text-[12px] font-medium text-slate-600">
                                            <span>{{ $trend->category->name }}</span>
                                            <span aria-hidden="true">&bull;</span>
                                            <span>{{ number_format($trend->views) }} tayangan</span>
                                        </div>
                                    </div>
                                </article>
                            </li>
                            @empty
                            <li class="py-3 text-sm text-slate-600">Belum ada data berita populer.</li>
                            @endforelse
                        </ol>
                    </section>

                    <section class="relative overflow-hidden rounded-2xl bg-unmaris-blue p-5 text-white md:p-6">
                        <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full bg-unmaris-yellow/20 blur-2xl" aria-hidden="true"></div>
                        <h2 class="relative text-lg font-extrabold">Dapatkan Pembaruan</h2>
                        <p class="relative mt-2 text-sm leading-relaxed text-slate-200">
                            Ikuti kanal resmi UNMARIS untuk kabar akademik, riset, dan prestasi terbaru.
                        </p>
                        <a href="{{ route('contact') }}" class="btn-primary focus-navy relative mt-5 w-full">
                            Hubungi Kami
                        </a>
                    </section>
                </div>
            </aside>
        </div>
    </div>
</div>
