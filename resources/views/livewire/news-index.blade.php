<div class="min-h-screen bg-white pb-16 md:pb-24">
    <x-ui.page-hero title="Berita & Publikasi" eyebrow="Pusat Media Resmi"
        description="Jendela informasi mengenai terobosan riset, prestasi global, dan dinamika akademik di Universitas Stella Maris Sumba."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Berita & Publikasi'],
        ]" />

    <div class="container-page py-10 md:py-14">
        <!-- Search & Filter Bar -->
        <div class="mb-10 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm md:mb-14 md:p-5">
            <div class="flex flex-col items-center justify-between gap-4 lg:flex-row md:gap-6">

                <!-- Category Tabs (Horizontal Scroll on Mobile) -->
                <div class="hide-scrollbar flex w-full min-w-0 flex-1 snap-x items-center gap-2 overflow-x-auto pb-1 lg:pb-0">
                    <button wire:click="filterCategory(null)"
                        class="shrink-0 snap-start rounded-full px-5 py-2 text-xs font-bold transition md:text-sm {{ is_null($selectedCategory) ? 'bg-unmaris-blue text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Semua Berita
                    </button>
                    @foreach($categories as $cat)
                    <button wire:click="filterCategory('{{ $cat->id }}')"
                        class="shrink-0 snap-start rounded-full px-5 py-2 text-xs font-bold transition md:text-sm {{ $selectedCategory == $cat->id ? 'bg-unmaris-blue text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ $cat->name }}
                    </button>
                    @endforeach
                </div>

                <!-- Search Input -->
                <div class="relative w-full shrink-0 lg:w-80">
                    <label for="pencarian-berita" class="sr-only">Cari artikel atau berita</label>
                    <input id="pencarian-berita" wire:model.live.debounce.500ms="search" type="search"
                        placeholder="Cari artikel atau berita..."
                        class="w-full rounded-full border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm font-medium outline-none transition focus:border-unmaris-yellow focus:ring-2 focus:ring-unmaris-yellow md:pl-11 md:pr-6">
                    <svg class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400 md:h-5 md:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Indikator Filter Tagar (Hanya Muncul Jika Sedang Memfilter Tag) -->
            @if($tag)
            <div class="mt-5 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-4">
                <span class="text-sm font-medium text-slate-500">Menampilkan hasil untuk tagar:</span>
                <span class="inline-flex items-center rounded-full bg-unmaris-yellow px-4 py-1.5 text-xs font-extrabold uppercase tracking-widest text-unmaris-blue shadow-sm">
                    #{{ $tag }}
                    <button wire:click="clearTag" class="ml-2 transition-colors hover:text-red-600" title="Hapus Filter Tagar"
                        aria-label="Hapus filter tagar {{ $tag }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </span>
            </div>
            @endif
        </div>

        <!-- 1. FEATURED HERO NEWS (Hanya di Halaman 1 & Tanpa Filter) -->
        @if($featuredNews && $news->onFirstPage() && !$search && !$selectedCategory && !$tag)
        <div class="mb-12 md:mb-20 group">
            <article class="group relative flex flex-col overflow-hidden rounded-3xl bg-slate-900 shadow-xl ring-1 ring-slate-800 md:min-h-[460px] md:justify-end">

                <!-- Image / Latar -->
                <div class="relative h-64 w-full shrink-0 overflow-hidden md:absolute md:inset-0 md:h-full">
                    @if($featuredNews->featured_image)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($featuredNews->featured_image) }}"
                        class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                        alt="{{ $featuredNews->title }}">
                    @else
                    <div class="absolute inset-0 bg-gradient-to-br from-unmaris-blue via-[#241b7a] to-slate-900">
                        <svg class="absolute inset-0 h-full w-full text-white opacity-[0.08]" fill="none" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                            <pattern id="featured-dots" x="0" y="0" width="10" height="10" patternUnits="userSpaceOnUse">
                                <circle cx="2" cy="2" r="1.3" fill="currentColor" />
                            </pattern>
                            <rect width="100" height="100" fill="url(#featured-dots)" />
                        </svg>
                        <img src="{{ asset('images/logo-unmaris.png') }}" alt=""
                            class="absolute right-10 top-1/2 hidden h-28 w-auto -translate-y-1/2 opacity-20 md:block" loading="lazy">
                    </div>
                    @endif

                    <!-- Indikator Video -->
                    @if($featuredNews->video_url)
                    <div class="absolute inset-0 z-10 flex items-center justify-center">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-unmaris-yellow/90 text-unmaris-blue shadow-[0_0_30px_rgba(253,224,26,0.4)] backdrop-blur-sm transition-transform duration-500 group-hover:scale-110 md:h-20 md:w-20">
                            <svg class="ml-1 h-8 w-8 md:h-10 md:w-10" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </div>
                    </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/80 to-slate-900/20"></div>
                </div>

                <!-- Content -->
                <div class="relative z-10 flex w-full flex-col p-6 sm:p-8 md:w-11/12 md:p-12 lg:w-4/5 lg:p-14">

                    <!-- Kategori, Tanggal & Masa Membaca -->
                    <div class="mb-4 flex flex-wrap items-center gap-3 md:mb-6 md:gap-4">
                        <span class="rounded-full bg-unmaris-yellow px-4 py-1.5 text-[10px] font-extrabold uppercase tracking-widest text-unmaris-blue shadow-lg md:text-[11px]">
                            {{ $featuredNews->category->name }}
                        </span>
                        <div class="flex flex-wrap items-center gap-x-2 text-[10px] font-bold uppercase tracking-widest text-slate-300 md:text-xs">
                            <svg class="h-3.5 w-3.5 text-unmaris-yellow md:h-4 md:w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <time datetime="{{ $featuredNews->published_at?->toDateString() }}">{{ $featuredNews->published_at->format('d M Y') }}</time>
                            @php $heroReadTime = ceil(str_word_count(strip_tags($featuredNews->content)) / 200) ?: 1; @endphp
                            <span class="text-slate-500" aria-hidden="true">•</span>
                            <span class="text-unmaris-yellow">{{ $heroReadTime }} menit baca</span>
                        </div>
                    </div>

                    <!-- Judul Utama -->
                    <h2 class="mb-4 text-balance font-display text-2xl font-extrabold leading-tight text-white transition-colors md:mb-6 md:text-4xl lg:text-5xl">
                        <a href="{{ route('news.detail', $featuredNews->slug) }}" class="transition hover:text-unmaris-yellow">
                            {{ $featuredNews->title }}
                        </a>
                    </h2>

                    <!-- Excerpt -->
                    <p class="mb-7 line-clamp-3 max-w-2xl text-sm leading-relaxed text-slate-300 md:mb-9 md:text-base">
                        {{ $featuredNews->excerpt }}
                    </p>

                    <!-- Aksi & Meta Stats -->
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:gap-8">
                        <a href="{{ route('news.detail', $featuredNews->slug) }}" class="btn-primary w-full sm:w-auto">
                            @if($featuredNews->video_url) Tonton Video @else Baca Artikel @endif
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>

                        <div class="flex items-center justify-center gap-5 text-[10px] font-bold uppercase tracking-widest text-slate-400 sm:justify-start md:text-xs">
                            <span class="flex items-center gap-1.5">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ number_format($featuredNews->views) }} Tayangan
                            </span>
                            <div class="h-1 w-1 rounded-full bg-slate-600" aria-hidden="true"></div>
                            <span class="flex items-center gap-1.5">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                                {{ number_format($featuredNews->shares) }} Dibagikan
                            </span>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 md:gap-16">
            <!-- 2. MAIN NEWS GRID (Kiri) -->
            <div class="lg:col-span-8">
                <div class="flex items-center gap-4 mb-6 md:mb-10">
                    <h2 class="heading-3">Berita Terbaru</h2>
                    <div class="h-px flex-grow bg-slate-200" aria-hidden="true"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 md:gap-x-10 gap-y-10 md:gap-y-16 mb-12 md:mb-20">
                    @forelse($news as $item)
                    @php
                    $readTime = ceil(str_word_count(strip_tags($item->content)) / 200) ?: 1;
                    @endphp
                    <article class="group flex flex-col h-full bg-white rounded-2xl md:rounded-[2.5rem] p-3 md:p-4 border border-gray-50 hover:border-gray-100 hover:shadow-xl transition-all duration-500">
                        <a href="{{ route('news.detail', $item->slug) }}" class="block relative aspect-[4/3] rounded-xl md:rounded-[2rem] overflow-hidden mb-5 md:mb-8 shadow-sm">
                            @if($item->featured_image)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($item->featured_image) }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="{{ $item->title }}">
                            @else
                            <div class="w-full h-full bg-gray-50 flex items-center justify-center">
                                <svg class="w-12 h-12 md:w-16 md:h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif

                            <!-- Video Overlay Indicator -->
                            @if($item->video_url)
                            <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors duration-500 z-10 flex items-center justify-center">
                                <div class="w-12 h-12 bg-white/30 backdrop-blur-md rounded-full flex items-center justify-center border border-white/50 group-hover:bg-unmaris-yellow group-hover:border-unmaris-yellow group-hover:text-unmaris-blue text-white transition-all duration-500 shadow-lg group-hover:scale-110">
                                    <svg class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </div>
                            @endif

                            <div class="absolute top-4 left-4 md:top-6 md:left-6 z-20">
                                <span class="bg-unmaris-blue/90 backdrop-blur-md text-white text-[8px] md:text-[9px] font-black px-3 md:px-4 py-1.5 rounded-full uppercase tracking-tighter shadow-sm">
                                    {{ $item->category->name }}
                                </span>
                            </div>
                        </a>

                        <div class="px-2 md:px-4 flex flex-col flex-grow">
                            <div class="flex items-center gap-3 mb-3 md:mb-4 text-[9px] md:text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                <span class="flex items-center gap-1.5">
                                    <div class="w-1.5 h-1.5 bg-unmaris-yellow rounded-full"></div>
                                    {{ $item->published_at->format('d M Y') }}
                                </span>
                                <div class="w-1 h-1 bg-gray-200 rounded-full"></div>
                                <span class="text-unmaris-blue">{{ $readTime }} Mnt Baca</span>
                            </div>

                            <h3 class="text-lg md:text-xl lg:text-2xl font-black text-gray-900 leading-snug md:leading-tight mb-3 md:mb-4 group-hover:text-unmaris-blue transition-colors duration-300">
                                <a href="{{ route('news.detail', $item->slug) }}">
                                    {{ Str::limit($item->title, 60) }}
                                </a>
                            </h3>

                            <p class="text-gray-500 text-xs md:text-sm leading-relaxed mb-6 md:mb-8 line-clamp-3 font-medium">
                                {{ $item->excerpt }}
                            </p>

                            <div class="mt-auto pt-4 md:pt-6 border-t border-gray-50 flex justify-between items-center">
                                <a href="{{ route('news.detail', $item->slug) }}" class="text-unmaris-blue font-black text-[10px] md:text-xs uppercase tracking-widest flex items-center gap-1.5 md:gap-2 group/link hover:text-unmaris-yellow transition-colors">
                                    {{ $item->video_url ? 'Tonton Video' : 'Selengkapnya' }}
                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                                <div class="flex items-center gap-2 text-gray-400">
                                    <span class="text-[9px] md:text-[10px] font-bold flex items-center">{{ number_format($item->views) }} <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg></span>
                                </div>
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

                <!-- Pagination -->
                <div class="mt-8 md:mt-12 flex justify-center">
                    {{ $news->links() }}
                </div>
            </div>

            <!-- 3. TRENDING SIDEBAR (Kanan) -->
            <aside class="lg:col-span-4 mt-12 lg:mt-0">
                <div class="sticky top-24">
                    <div class="flex items-center gap-4 mb-8 md:mb-10">
                        <h2 class="heading-3">Terpopuler</h2>
                        <div class="h-1 flex-grow rounded-full bg-unmaris-yellow" aria-hidden="true"></div>
                    </div>

                    <div class="space-y-6 md:space-y-10">
                        @foreach($trendingNews as $index => $trend)
                        <article class="flex gap-4 md:gap-6 group/trend items-start relative">
                            <div class="relative shrink-0 pt-1">
                                <span class="text-3xl md:text-5xl font-black text-gray-200 group-hover/trend:text-unmaris-yellow transition-colors duration-300">
                                    {{ sprintf("%02d", $index + 1) }}
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[8px] md:text-[9px] font-black text-unmaris-blue uppercase tracking-widest mb-1 md:mb-2">
                                    {{ $trend->category->name }}
                                </span>
                                <h4 class="text-base md:text-lg font-bold text-gray-900 leading-snug group-hover/trend:text-unmaris-blue transition-colors pr-6">
                                    <a href="{{ route('news.detail', $trend->slug) }}">
                                        {{ Str::limit($trend->title, 55) }}
                                    </a>
                                </h4>
                                <div class="flex items-center gap-2 md:gap-3 mt-2 md:mt-3 text-[9px] md:text-[10px] text-gray-400 font-bold">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ number_format($trend->views) }}
                                    </span>
                                    <span>•</span>
                                    <span>{{ $trend->published_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <!-- Small Video Icon in Trending -->
                            @if($trend->video_url)
                            <div class="absolute right-0 top-1.5 text-unmaris-blue bg-blue-50 p-1 rounded-md">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                            </div>
                            @endif
                        </article>
                        @endforeach
                    </div>

                    <!-- Newsletter or Call to Action in Sidebar -->
                    <div class="mt-12 md:mt-16 bg-gray-900 rounded-3xl md:rounded-[2.5rem] p-6 md:p-8 text-white relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-   32 h-32 bg-unmaris-yellow/10 rounded-full blur-2xl"></div>
                        <h3 class="text-lg md:text-xl font-black mb-3 md:mb-4 relative z-10">Dapatkan Pembaruan.</h3>
                        <p class="text-gray-400 text-xs md:text-sm mb-5 md:mb-6 relative z-10 leading-relaxed">Dapatkan informasi riset dan berita akademik terkini langsung di kotak masuk Anda.</p>
                        <a href="{{ route('contact') }}" class="inline-block w-full text-center bg-unmaris-yellow text-unmaris-blue py-3 md:py-3.5 rounded-full font-black text-[10px] md:text-xs uppercase tracking-widest hover:bg-white transition-all">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>

</div>