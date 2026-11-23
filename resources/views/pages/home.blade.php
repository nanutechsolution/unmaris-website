<x-layouts.app title="Beranda - Universitas Stella Maris Sumba"
    description="Universitas Stella Maris Sumba (UNMARIS) membangun generasi unggul, berkarakter, dan berdaya saing global dari Sumba untuk dunia.">

    @php
        $sliderCount = isset($sliders) ? $sliders->count() : 0;
    @endphp

    <!-- Pop-up promo PMB dari CMS -->
    @if (isset($popupPromo) && $popupPromo)
        <div x-data="{ promoOpen: false }"
            x-init="setTimeout(() => { if (!sessionStorage.getItem('promo_closed_{{ $popupPromo->id }}')) promoOpen = true }, 2200)"
            @keydown.escape.window="promoOpen = false; sessionStorage.setItem('promo_closed_{{ $popupPromo->id }}', 'true')">

            <div x-show="promoOpen" x-cloak role="dialog" aria-modal="true" aria-labelledby="judul-promo"
                class="fixed inset-0 z-[120] overflow-y-auto p-4 sm:p-6">
                <div x-show="promoOpen" @click="promoOpen = false; sessionStorage.setItem('promo_closed_{{ $popupPromo->id }}', 'true')"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-[#0b0720]/80 backdrop-blur-sm" aria-hidden="true"></div>

                <div class="relative flex min-h-full items-center justify-center">
                    <div x-show="promoOpen"
                        @click.away="promoOpen = false; sessionStorage.setItem('promo_closed_{{ $popupPromo->id }}', 'true')"
                        x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-y-6 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-6 sm:scale-95"
                        class="relative w-full max-w-lg overflow-hidden rounded-3xl border border-line bg-surface shadow-2xl">

                        <button type="button"
                            @click="promoOpen = false; sessionStorage.setItem('promo_closed_{{ $popupPromo->id }}', 'true')"
                            class="absolute right-3 top-3 z-20 grid h-11 w-11 place-items-center rounded-full bg-[#0b0720]/55 text-white backdrop-blur transition hover:bg-[#0b0720]/80"
                            aria-label="Tutup promosi">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <div class="relative h-56 w-full overflow-hidden bg-navy-deep sm:h-64">
                            @if ($popupPromo->image)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($popupPromo->image) }}"
                                    alt="{{ $popupPromo->title }}" width="640" height="320"
                                    class="h-full w-full object-cover opacity-80">
                            @else
                                <div class="absolute inset-0 hero-grid opacity-60" aria-hidden="true"></div>
                                <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-unmaris-yellow/30 blur-2xl" aria-hidden="true"></div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-navy-deep via-navy-deep/35 to-transparent"></div>
                            <div class="absolute inset-x-0 bottom-0 p-6">
                                @if ($popupPromo->subtitle)
                                    <span class="chip-yellow mb-3">{{ $popupPromo->subtitle }}</span>
                                @endif
                                <h2 id="judul-promo" class="font-display text-3xl font-bold leading-tight text-white sm:text-4xl">
                                    {{ $popupPromo->title }}
                                </h2>
                            </div>
                        </div>

                        <div class="p-6 sm:p-8">
                            <div class="prose-unmaris text-sm sm:text-base">
                                {!! $popupPromo->description !!}
                            </div>

                            <div class="mt-7 flex flex-col gap-2.5">
                                @if ($popupPromo->button_url)
                                    <a href="{{ $popupPromo->button_url }}" target="_blank" rel="noopener" class="btn-primary w-full">
                                        {{ $popupPromo->button_text ?? 'Daftar Sekarang' }}
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </a>
                                @endif
                                <button type="button"
                                    @click="promoOpen = false; sessionStorage.setItem('promo_closed_{{ $popupPromo->id }}', 'true')"
                                    class="min-h-11 w-full text-center text-xs font-extrabold uppercase tracking-[0.12em] text-muted transition hover:text-ink">
                                    Lihat website dulu
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Hero / sorotan kampus -->
    <section class="relative isolate overflow-hidden bg-[#1b0f52] text-white" aria-roledescription="carousel"
        aria-label="Sorotan kampus Universitas Stella Maris Sumba"
        x-data="{
            activeSlide: 0,
            totalSlides: {{ max($sliderCount, 1) }},
            paused: false,
            timer: null,
            next() { this.activeSlide = (this.activeSlide + 1) % this.totalSlides; },
            prev() { this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides; },
            goTo(index) { this.activeSlide = index; },
            togglePause() { this.paused = !this.paused; },
            handleKeydown(event) {
                if (event.key === 'ArrowRight') { event.preventDefault(); this.next(); }
                if (event.key === 'ArrowLeft') { event.preventDefault(); this.prev(); }
            },
            init() {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) { this.paused = true; return; }
                this.timer = setInterval(() => { if (!this.paused) this.next(); }, 8000);
            },
            destroy() { clearInterval(this.timer); }
        }"
        @mouseenter="paused = true" @mouseleave="paused = false" @focusin="paused = true" @focusout="paused = false"
        @keydown="handleKeydown($event)" tabindex="0">

        <div class="pointer-events-none absolute inset-0 hero-grid" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -left-32 top-1/4 h-80 w-80 rounded-full bg-unmaris-yellow/10 blur-[110px]" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -right-20 bottom-0 h-96 w-96 rounded-full border-[60px] border-white/[0.03]" aria-hidden="true"></div>

        <a href="#layanan-cepat" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-xl focus:bg-unmaris-yellow focus:px-4 focus:py-3 focus:text-sm focus:font-bold focus:text-[#1b0f52]">
            Lewati sorotan kampus
        </a>

        <div class="container-page relative z-10 grid items-center gap-12 pb-24 pt-10 sm:pt-12 lg:grid-cols-[1.12fr_0.88fr] lg:gap-16 lg:pb-28 lg:pt-16">
            <div class="min-w-0">
                <div class="mb-8 flex flex-wrap items-center gap-x-4 gap-y-2">
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-3.5 py-1.5 text-[10px] font-extrabold uppercase tracking-[0.16em] text-white/80 backdrop-blur">
                        <span class="h-1.5 w-1.5 rounded-full bg-unmaris-yellow"></span>
                        Universitas Stella Maris Sumba
                    </span>
                    <span class="hidden items-center gap-2 text-[11px] font-semibold text-white/50 sm:inline-flex">
                        Tambolaka, Sumba Barat Daya
                    </span>
                </div>

                <div class="grid">
                    @forelse ($sliders as $index => $slider)
                        <div class="col-start-1 row-start-1" x-show="activeSlide === {{ $index }}" x-cloak
                            role="group" aria-roledescription="slide"
                            aria-label="Sorotan {{ $index + 1 }} dari {{ $sliderCount }}"
                            :aria-hidden="activeSlide !== {{ $index }}"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 translate-y-3"
                            x-transition:enter-end="opacity-100 translate-y-0">

                            @if ($slider->label)
                                <span class="inline-flex items-center gap-2 rounded-full bg-unmaris-yellow px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-[0.14em] text-[#1b0f52]">
                                    {{ $slider->label }}
                                </span>
                            @endif

                            @if ($loop->first)
                                <h1 class="hero-title mt-5">{!! $slider->title !!}</h1>
                            @else
                                <h2 class="hero-title mt-5">{!! $slider->title !!}</h2>
                            @endif

                            <p class="mt-5 max-w-xl text-base leading-relaxed text-white/70 md:text-lg">
                                {{ $slider->description }}
                            </p>

                            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                                @if ($slider->button_url)
                                    <a href="{{ $slider->button_url }}" class="btn-primary w-full sm:w-auto" @if (str_starts_with($slider->button_url, 'http')) target="_blank" rel="noopener" @endif>
                                        {{ $slider->button_text ?? 'Jelajahi' }}
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </a>
                                @endif
                                <a href="{{ route('profile') }}" class="btn-light-outline w-full sm:w-auto">
                                    Jelajahi UNMARIS
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-start-1 row-start-1">
                            <h1 class="hero-title">Membangun Masa Depan<br><span>Dari Sumba Untuk Dunia</span></h1>
                            <p class="mt-5 max-w-xl text-base leading-relaxed text-white/70 md:text-lg">
                                Universitas Stella Maris Sumba membentuk karakter unggul, inovatif, dan berdaya saing global.
                            </p>
                            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                                <a href="https://pmb.unmaris.ac.id" target="_blank" rel="noopener" class="btn-primary w-full sm:w-auto">Daftar PMB</a>
                                <a href="{{ route('profile') }}" class="btn-light-outline w-full sm:w-auto">Jelajahi UNMARIS</a>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if ($sliderCount > 1)
                    <div class="mt-10 border-t border-white/10 pt-5">
                        <div class="flex flex-wrap items-center justify-between gap-5">
                            <div class="flex items-center gap-2">
                                <button type="button" @click="prev()" aria-label="Sorotan sebelumnya"
                                    class="grid h-11 w-11 place-items-center rounded-full border border-white/20 text-white transition hover:border-unmaris-yellow hover:bg-unmaris-yellow hover:text-[#1b0f52]">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button type="button" @click="next()" aria-label="Sorotan selanjutnya"
                                    class="grid h-11 w-11 place-items-center rounded-full border border-white/20 text-white transition hover:border-unmaris-yellow hover:bg-unmaris-yellow hover:text-[#1b0f52]">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                                <button type="button" @click="togglePause()" :aria-pressed="paused ? 'true' : 'false'"
                                    :aria-label="paused ? 'Putar sorotan otomatis' : 'Jeda sorotan otomatis'"
                                    class="grid h-11 w-11 place-items-center rounded-full border border-white/20 text-white transition hover:border-unmaris-yellow hover:text-unmaris-yellow">
                                    <svg x-show="!paused" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M6 5h4v14H6zM14 5h4v14h-4z" />
                                    </svg>
                                    <svg x-show="paused" x-cloak class="ml-0.5 h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="flex items-center gap-2" role="group" aria-label="Pilih sorotan kampus">
                                @foreach ($sliders as $index => $slider)
                                    <button type="button" @click="goTo({{ $index }})"
                                        aria-label="Tampilkan sorotan {{ $index + 1 }}"
                                        :aria-current="activeSlide === {{ $index }} ? 'true' : 'false'"
                                        class="h-2 rounded-full transition-all duration-300"
                                        :class="activeSlide === {{ $index }} ? 'w-10 bg-unmaris-yellow' : 'w-2 bg-white/25 hover:bg-white/50'"></button>
                                @endforeach
                                <span class="ml-2 font-display text-xs font-bold tabular-nums text-white/50">
                                    <span x-text="String(activeSlide + 1).padStart(2, '0')">01</span> / {{ str_pad($sliderCount, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                        </div>
                        <div class="sr-only" aria-live="polite" aria-atomic="true">
                            Menampilkan sorotan <span x-text="activeSlide + 1">{{ 1 }}</span> dari {{ $sliderCount }}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Panel identitas -->
            <div class="relative hidden lg:block">
                <div class="absolute -inset-3 rounded-[2.5rem] border border-white/10" aria-hidden="true"></div>
                <div class="relative overflow-hidden rounded-[2rem] bg-unmaris-yellow p-7 text-[#1b0f52] shadow-[0_30px_80px_-30px_rgba(0,0,0,0.7)]">
                    <div class="pointer-events-none absolute inset-0 pattern-dots-navy opacity-70" aria-hidden="true"></div>
                    <div class="relative">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-[10px] font-extrabold uppercase tracking-[0.18em]">Universitas Stella Maris</p>
                                <p class="mt-1 font-display text-4xl font-bold leading-none tracking-[-0.04em]">UNMARIS</p>
                            </div>
                            <span class="grid h-14 w-14 shrink-0 place-items-center rounded-2xl bg-white p-1.5 shadow-sm ring-1 ring-[#1b0f52]/10">
                                <img src="{{ asset('images/logo-unmaris.png') }}" alt="" width="48" height="48"
                                    class="h-full w-full object-contain">
                            </span>
                        </div>

                        <p class="mt-9 max-w-[17rem] text-sm font-semibold leading-relaxed">
                            Pendidikan tinggi yang tumbuh dari Sumba, terbuka untuk dunia.
                        </p>

                        <dl class="mt-8 grid grid-cols-2 gap-4 border-t border-[#1b0f52]/20 pt-6">
                            <div>
                                <dd class="font-display text-4xl font-bold leading-none">{{ $countFakultas ?? 0 }}</dd>
                                <dt class="mt-2 text-[10px] font-extrabold uppercase tracking-[0.14em]">Fakultas</dt>
                            </div>
                            <div>
                                <dd class="font-display text-4xl font-bold leading-none">{{ $countProdi ?? 0 }}</dd>
                                <dt class="mt-2 text-[10px] font-extrabold uppercase tracking-[0.14em]">Program Studi</dt>
                            </div>
                        </dl>

                        <p class="mt-7 flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.1em]">
                            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Tambolaka, Sumba Barat Daya
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan cepat -->
    <section id="layanan-cepat" class="relative z-20 border-b border-line bg-canvas" aria-label="Layanan cepat">
        <div class="container-page -mt-12 md:-mt-14">
            <div class="grid grid-cols-2 gap-3 md:grid-cols-4 md:gap-4">
                <a href="https://pmb.unmaris.ac.id" target="_blank" rel="noopener"
                    class="group flex min-h-[92px] flex-col justify-between gap-4 rounded-2xl bg-unmaris-yellow p-4 text-[#1b0f52] shadow-[0_18px_40px_-20px_rgba(245,217,0,0.55)] transition duration-300 hover:-translate-y-1 md:p-5">
                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-[#1b0f52] text-unmaris-yellow">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0v7m-4-4l4 4 4-4" />
                        </svg>
                    </span>
                    <span>
                        <span class="block text-[9px] font-extrabold uppercase tracking-[0.14em] opacity-70">Penerimaan</span>
                        <span class="mt-0.5 block text-sm font-bold">Daftar PMB</span>
                    </span>
                </a>

                <a href="{{ route('scholarships.index') }}"
                    class="group flex min-h-[92px] flex-col justify-between gap-4 rounded-2xl border border-line bg-surface p-4 shadow-[var(--shadow-soft)] transition duration-300 hover:-translate-y-1 hover:border-line-strong md:p-5">
                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-surface-2 text-brand-ink transition group-hover:bg-unmaris-blue group-hover:text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0v7" />
                        </svg>
                    </span>
                    <span>
                        <span class="block text-[9px] font-extrabold uppercase tracking-[0.14em] text-muted">Kemahasiswaan</span>
                        <span class="mt-0.5 block text-sm font-bold text-ink">Info Beasiswa</span>
                    </span>
                </a>

                <a href="{{ route('akademik.unduhan') }}"
                    class="group flex min-h-[92px] flex-col justify-between gap-4 rounded-2xl border border-line bg-surface p-4 shadow-[var(--shadow-soft)] transition duration-300 hover:-translate-y-1 hover:border-line-strong md:p-5">
                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-surface-2 text-brand-ink transition group-hover:bg-unmaris-blue group-hover:text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </span>
                    <span>
                        <span class="block text-[9px] font-extrabold uppercase tracking-[0.14em] text-muted">Akademik</span>
                        <span class="mt-0.5 block text-sm font-bold text-ink">Pusat Unduhan</span>
                    </span>
                </a>

                <a href="{{ route('complaint.index') }}"
                    class="group flex min-h-[92px] flex-col justify-between gap-4 rounded-2xl border border-line bg-surface p-4 shadow-[var(--shadow-soft)] transition duration-300 hover:-translate-y-1 hover:border-line-strong md:p-5">
                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-surface-2 text-brand-ink transition group-hover:bg-unmaris-blue group-hover:text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </span>
                    <span>
                        <span class="block text-[9px] font-extrabold uppercase tracking-[0.14em] text-muted">Layanan</span>
                        <span class="mt-0.5 block text-sm font-bold text-ink">Pengaduan</span>
                    </span>
                </a>
            </div>
        </div>
    </section>

    <!-- Statistik kampus -->
    <section class="bg-canvas" aria-label="Statistik kampus">
        <div class="container-page py-12 md:py-16">
            <dl class="grid grid-cols-2 gap-x-6 gap-y-10 md:grid-cols-4">
                <div class="border-t-2 border-unmaris-yellow pt-4">
                    <dd class="font-display text-4xl font-bold leading-none text-ink md:text-5xl">{{ $countFakultas ?? 0 }}</dd>
                    <dt class="mt-2 text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Fakultas</dt>
                </div>
                <div class="border-t-2 border-unmaris-yellow pt-4">
                    <dd class="font-display text-4xl font-bold leading-none text-ink md:text-5xl">{{ $countProdi ?? 0 }}</dd>
                    <dt class="mt-2 text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Program Studi</dt>
                </div>
                <div class="border-t-2 border-unmaris-yellow pt-4">
                    <dd class="font-display text-4xl font-bold leading-none text-ink md:text-5xl">{{ $countTerakreditasi ?? 0 }}</dd>
                    <dt class="mt-2 text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Prodi Terakreditasi</dt>
                </div>
                <div class="border-t-2 border-unmaris-yellow pt-4">
                    <dd class="font-display text-4xl font-bold leading-none text-ink md:text-5xl">{{ $countBerita ?? 0 }}<span class="text-unmaris-yellow">+</span></dd>
                    <dt class="mt-2 text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Berita &amp; Publikasi</dt>
                </div>
            </dl>
        </div>
    </section>

    <!-- Berita terbaru -->
    @if (isset($latestNews) && $latestNews->count() > 0)
        <section class="section-y border-y border-line bg-surface">
            <div class="container-page">
                <x-ui.section-heading eyebrow="Informasi Terkini" title="Berita Kampus"
                    description="Kabar terbaru seputar akademik, prestasi, dan kehidupan kampus Universitas Stella Maris Sumba."
                    :href="route('news.index')" link-label="Semua Berita" />

                @php
                    $featuredNews = $latestNews->first();
                    $otherNews = $latestNews->skip(1);
                    $hasOthers = $otherNews->count() > 0;
                @endphp

                <div class="grid gap-8 lg:grid-cols-12 lg:gap-10">
                    <article class="group {{ $hasOthers ? 'lg:col-span-7' : 'lg:col-span-12' }}">
                        <a href="{{ route('news.detail', $featuredNews->slug) }}"
                            class="relative block aspect-[16/10] overflow-hidden rounded-3xl border border-line bg-navy-deep">
                            @if ($featuredNews->featured_image)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($featuredNews->featured_image) }}"
                                    alt="{{ $featuredNews->title }}" width="900" height="560" loading="lazy"
                                    class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.03]">
                            @else
                                <div class="absolute inset-0 hero-grid opacity-70" aria-hidden="true"></div>
                                <div class="absolute -right-16 -top-16 h-64 w-64 rounded-full bg-unmaris-yellow/20 blur-3xl" aria-hidden="true"></div>
                                <div class="absolute inset-0 flex flex-col justify-between p-6 md:p-8">
                                    <span class="chip-yellow self-start">{{ $featuredNews->category?->name ?? 'Berita Kampus' }}</span>
                                    <div>
                                        <p class="font-display text-7xl font-bold leading-none text-white/10">01</p>
                                        <p class="mt-2 text-[10px] font-extrabold uppercase tracking-[0.2em] text-unmaris-yellow">Laporan Utama</p>
                                    </div>
                                </div>
                            @endif
                            <span class="absolute bottom-5 right-5 grid h-11 w-11 place-items-center rounded-full bg-unmaris-yellow text-[#1b0f52] transition group-hover:scale-110">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H8m9 0v9" />
                                </svg>
                            </span>
                        </a>

                        <div class="pt-5">
                            <div class="flex flex-wrap items-center gap-3 text-[11px] font-bold uppercase tracking-[0.1em]">
                                <span class="text-brand-ink">{{ $featuredNews->category?->name ?? 'Berita Kampus' }}</span>
                                <span class="h-1 w-1 rounded-full bg-line-strong" aria-hidden="true"></span>
                                <time class="text-muted" datetime="{{ $featuredNews->published_at?->toDateString() }}">
                                    {{ $featuredNews->published_at?->translatedFormat('d F Y') }}
                                </time>
                            </div>
                            <h3 class="mt-3 font-display text-2xl font-bold leading-tight text-ink md:text-3xl">
                                <a href="{{ route('news.detail', $featuredNews->slug) }}" class="transition hover:text-brand-ink">
                                    {{ $featuredNews->title }}
                                </a>
                            </h3>
                            @if ($featuredNews->excerpt)
                                <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-body md:text-base">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($featuredNews->excerpt), 180) }}
                                </p>
                            @endif
                            <a href="{{ route('news.detail', $featuredNews->slug) }}" class="link-arrow group/link mt-5">
                                Baca selengkapnya
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </article>

                    @if ($hasOthers)
                        <div class="lg:col-span-5">
                            <div class="rounded-3xl border border-line bg-canvas p-2">
                                @foreach ($otherNews as $item)
                                    <a href="{{ route('news.detail', $item->slug) }}"
                                        class="group flex gap-4 rounded-2xl p-4 transition hover:bg-surface-2">
                                        <span class="font-display text-2xl font-bold leading-none text-line-strong">
                                            {{ str_pad($loop->iteration + 1, 2, '0', STR_PAD_LEFT) }}
                                        </span>
                                        <span class="min-w-0">
                                            <span class="flex flex-wrap items-center gap-2 text-[9px] font-extrabold uppercase tracking-[0.12em]">
                                                <span class="text-brand-ink">{{ $item->category?->name ?? 'Berita' }}</span>
                                                <span class="text-muted">{{ $item->published_at?->translatedFormat('d M Y') }}</span>
                                            </span>
                                            <span class="mt-1.5 block text-sm font-bold leading-snug text-ink transition group-hover:text-brand-ink">
                                                {{ $item->title }}
                                            </span>
                                        </span>
                                    </a>
                                @endforeach
                            </div>

                            <a href="{{ route('news.index') }}" class="btn-outline mt-4 w-full">
                                Lihat semua berita
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <!-- Fakultas -->
    <section class="section-y bg-canvas">
        <div class="container-page">
            <x-ui.section-heading eyebrow="Jalur Keilmuan" title="Fakultas Pilihan"
                description="Temukan program studi yang sesuai dengan minat dan cita-cita Anda di UNMARIS."
                :href="route('faculties.index')" link-label="Lihat Semua Fakultas" />

            @if (isset($faculties) && $faculties->count() > 0)
                <div class="grid gap-4 md:grid-cols-2 md:gap-6">
                    @foreach ($faculties as $faculty)
                        <a href="{{ route('faculties.detail', $faculty->slug) }}"
                            class="group flex h-full flex-col rounded-3xl border border-line bg-surface p-6 shadow-[var(--shadow-soft)] transition duration-300 hover:-translate-y-1 hover:border-line-strong hover:shadow-[var(--shadow-lift)] md:p-8">
                            <div class="flex items-start justify-between gap-4">
                                <span class="font-display text-5xl font-bold leading-none text-line-strong transition group-hover:text-unmaris-yellow">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full border border-line text-brand-ink transition group-hover:border-unmaris-yellow group-hover:bg-unmaris-yellow group-hover:text-[#1b0f52]">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H8m9 0v9" />
                                    </svg>
                                </span>
                            </div>

                            <h3 class="mt-6 font-display text-2xl font-bold leading-tight text-ink">{{ $faculty->name }}</h3>
                            <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-body">
                                {{ \Illuminate\Support\Str::limit(strip_tags($faculty->description ?? ''), 170) }}
                            </p>

                            @if ($faculty->studyPrograms->count() > 0)
                                <div class="mt-5 flex flex-wrap gap-1.5">
                                    @foreach ($faculty->studyPrograms->take(4) as $prodi)
                                        <span class="chip !px-2.5 !py-1 !text-[9px]">{{ $prodi->name }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="mt-auto flex items-center justify-between gap-4 border-t border-line pt-5 text-[10px] font-extrabold uppercase tracking-[0.12em] text-muted md:mt-6">
                                <span>{{ $faculty->studyPrograms->count() }} Program Studi</span>
                                <span class="inline-flex items-center gap-1.5 text-brand-ink">
                                    Lihat fakultas
                                    <svg class="h-3.5 w-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <x-ui.empty-state title="Data fakultas belum tersedia"
                    description="Informasi fakultas dan program studi akan segera ditampilkan di halaman ini." />
            @endif
        </div>
    </section>

    <!-- Video profil -->
    <section class="relative overflow-hidden bg-navy-deep py-16 text-white md:py-24" x-data="{ videoOpen: false }">
        <div class="pointer-events-none absolute inset-0 hero-grid opacity-70" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -left-24 top-0 h-72 w-72 rounded-full bg-unmaris-yellow/10 blur-[100px]" aria-hidden="true"></div>

        <div class="container-page relative z-10 grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
            <div>
                <span class="eyebrow-light mb-4">Mengenal Lebih Dekat</span>
                <h2 class="font-display text-3xl font-bold leading-[1.02] tracking-tight text-white md:text-4xl lg:text-5xl">
                    Jelajahi kampus<br>Universitas Stella Maris Sumba
                </h2>
                <p class="mt-5 max-w-lg text-sm leading-relaxed text-white/65 md:text-base">
                    Tonton video profil kami untuk melihat fasilitas, suasana belajar, dan kegiatan kemahasiswaan yang akan Anda alami selama berkuliah di UNMARIS.
                </p>
                <button type="button"
                    @click="videoOpen = true; $nextTick(() => $refs.videoDialog.showModal())"
                    class="btn-primary mt-7">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                    Putar video profil
                </button>
            </div>

            <button type="button" @click="videoOpen = true; $nextTick(() => $refs.videoDialog.showModal())"
                class="group relative block aspect-video w-full overflow-hidden rounded-3xl border border-white/15 bg-[#100a2e] text-left"
                aria-label="Putar video profil kampus">
                <span class="pointer-events-none absolute inset-0 pattern-dots-light opacity-40" aria-hidden="true"></span>
                <span class="absolute left-5 top-5 chip-yellow">Video Profil</span>
                <span class="absolute inset-0 grid place-items-center">
                    <span class="relative grid h-20 w-20 place-items-center rounded-full bg-unmaris-yellow text-[#1b0f52] shadow-[0_0_50px_rgba(245,217,0,0.35)] transition duration-300 group-hover:scale-105 md:h-24 md:w-24">
                        <span class="absolute inset-0 -z-10 animate-ping rounded-full bg-unmaris-yellow/25 opacity-60"></span>
                        <svg class="ml-1 h-8 w-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                    </span>
                </span>
                <span class="absolute bottom-5 left-5 right-5 flex items-end justify-between gap-4">
                    <span class="font-display text-xl font-bold text-white md:text-2xl">UNMARIS dalam gerak</span>
                    <img src="{{ asset('images/logo-unmaris.png') }}" alt="" width="44" height="44"
                        class="h-11 w-11 rounded-xl bg-white/10 object-contain p-1">
                </span>
            </button>
        </div>

        <dialog x-ref="videoDialog" @close="videoOpen = false"
            @click="if ($event.target === $refs.videoDialog) $refs.videoDialog.close()"
            aria-label="Video profil Universitas Stella Maris Sumba"
            class="w-[min(1080px,calc(100%-2rem))] max-w-none overflow-visible rounded-2xl bg-transparent p-0 backdrop:bg-black/85 backdrop:backdrop-blur-sm">
            <div class="relative aspect-video overflow-hidden rounded-2xl bg-black">
                <button type="button" @click="$refs.videoDialog.close()"
                    class="absolute -top-12 right-0 grid h-11 w-11 place-items-center rounded-full bg-white/10 text-white transition hover:bg-unmaris-yellow hover:text-[#1b0f52]"
                    aria-label="Tutup video">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <template x-if="videoOpen">
                    <iframe class="h-full w-full" src="https://www.youtube.com/embed/QPd6QsoQaPA?autoplay=1&rel=0&modestbranding=1&controls=1"
                        title="Video Profil Universitas Stella Maris Sumba" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </template>
            </div>
        </dialog>
    </section>

    <!-- Nilai dan keunggulan -->
    <section class="section-y bg-surface">
        <div class="container-page">
            <x-ui.section-heading align="left" eyebrow="Nilai Inti" title="Mengapa memilih UNMARIS?"
                description="Tiga pilar yang membentuk pengalaman belajar dan kesiapan karier lulusan UNMARIS." />

            <div class="grid gap-4 md:grid-cols-3 md:gap-6">
                @php
                    $pillars = [
                        ['title' => 'Pendidikan Berkarakter', 'text' => 'Menanamkan nilai-nilai integritas, etika profesional, dan karakter unggul di setiap langkah akademik lulusan.', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                        ['title' => 'Fasilitas Modern', 'text' => 'Dukungan lingkungan kampus yang kondusif dengan laboratorium terpadu dan sistem e-learning terkini.', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                        ['title' => 'Lulusan Siap Kerja', 'text' => 'Kurikulum yang disusun adaptif terhadap tantangan global, riset terapan, dan kebutuhan industri digital.', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                    ];
                @endphp

                @foreach ($pillars as $pillar)
                    <article class="group flex h-full flex-col rounded-3xl border border-line bg-canvas p-7 transition duration-300 hover:border-line-strong md:p-8">
                        <div class="flex items-center justify-between">
                            <span class="grid h-12 w-12 place-items-center rounded-2xl bg-unmaris-yellow text-[#1b0f52] transition group-hover:bg-unmaris-blue group-hover:text-unmaris-yellow">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $pillar['icon'] }}" />
                                </svg>
                            </span>
                            <span class="font-display text-3xl font-bold text-line-strong">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <h3 class="mt-8 heading-3">{{ $pillar['title'] }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-body">{{ $pillar['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimoni alumni -->
    @if (isset($testimonials) && $testimonials->count() > 0)
        <section class="section-y relative overflow-hidden border-y border-line bg-surface-2">
            <div class="pointer-events-none absolute -right-24 top-0 h-96 w-96 rounded-full bg-unmaris-yellow/40 blur-3xl" aria-hidden="true"></div>
            <div class="container-page relative z-10">
                <x-ui.section-heading eyebrow="Jejak Karier" title="Kisah Sukses Alumni"
                    description="Pengalaman para lulusan yang kini berkarya dan memberi dampak di berbagai bidang." />

                <div class="grid gap-4 md:grid-cols-3 md:gap-6">
                    @foreach ($testimonials->take(3) as $testi)
                        @php
                            $initials = \Illuminate\Support\Str::of($testi->name)->explode(' ')->filter()->map(fn ($word) => mb_substr($word, 0, 1))->take(2)->implode('');
                        @endphp
                        <figure class="flex h-full flex-col rounded-3xl border border-line bg-surface p-7 shadow-[var(--shadow-soft)]">
                            <svg class="h-8 w-8 text-unmaris-yellow" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                            <blockquote class="mt-4 flex-1 text-sm leading-relaxed text-body md:text-base">“{{ $testi->message }}”</blockquote>
                            <figcaption class="mt-6 flex items-center gap-3 border-t border-line pt-5">
                                @if ($testi->image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($testi->image) }}" alt="{{ $testi->name }}"
                                        width="48" height="48" loading="lazy" class="h-12 w-12 rounded-full object-cover">
                                @else
                                    <span class="grid h-12 w-12 place-items-center rounded-full bg-unmaris-yellow font-display text-sm font-bold text-[#1b0f52]" aria-hidden="true">{{ $initials }}</span>
                                @endif
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-bold text-ink">{{ $testi->name }}</p>
                                    <p class="truncate text-[10px] font-bold uppercase tracking-[0.08em] text-muted">
                                        {{ $testi->job_title }}{{ $testi->company ? ' di ' . $testi->company : '' }}
                                    </p>
                                </div>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Mitra -->
    @if (isset($partners) && $partners->count() > 0)
        <section class="border-b border-line bg-surface py-10" aria-label="Institusi mitra UNMARIS">
            <div class="container-page mb-6 text-center">
                <p class="text-[10px] font-extrabold uppercase tracking-[0.22em] text-muted md:text-xs">Telah Dipercaya oleh Berbagai Institusi</p>
            </div>

            <div class="marquee overflow-hidden">
                <div class="marquee-track flex w-max items-center gap-12 px-6 md:gap-16">
                    @foreach ($partners->concat($partners) as $partner)
                        <div class="flex shrink-0 items-center gap-2.5 text-base font-extrabold text-muted md:text-lg">
                            @if ($partner->logo)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($partner->logo) }}" alt="{{ $partner->name }}"
                                    width="144" height="32" loading="lazy" class="h-8 w-auto max-w-[9rem] object-contain opacity-70 grayscale">
                            @else
                                <svg class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                                </svg>
                                <span>{{ $partner->name }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</x-layouts.app>
