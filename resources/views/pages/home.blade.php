<x-layouts.app title="Beranda - Universitas Stella Maris Sumba">

    <h1 class="sr-only">Universitas Stella Maris Sumba — Membangun Masa Depan dari Sumba untuk Dunia</h1>

    <!-- 0. POP-UP PROMO OVERLAY (PMB) -->
    @if(isset($popupPromo) && $popupPromo)
    <div x-data="{ promoOpen: false }"
        x-init="setTimeout(() => { if(!sessionStorage.getItem('promo_closed_{{ $popupPromo->id }}')) promoOpen = true }, 2000)">

        <div id="modal-title" x-show="promoOpen" style="display: none;" class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Background gelap (Backdrop) -->
            <div x-show="promoOpen"
                x-transition:enter="ease-out duration-500"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity"></div>

            <!-- Kontainer Modal -->
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

                    <!-- Kotak Pop-up Utama -->
                    <div x-show="promoOpen"
                        @click.away="promoOpen = false; sessionStorage.setItem('promo_closed_{{ $popupPromo->id }}', 'true')"
                        x-transition:enter="ease-out duration-500 delay-100"
                        x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-300"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">

                        <!-- Tombol Close (X) di pojok kanan atas -->
                        <button type="button" aria-label="Tutup popup promosi" @click="promoOpen = false; sessionStorage.setItem('promo_closed_{{ $popupPromo->id }}', 'true')" class="absolute top-4 right-4 z-20 w-10 h-10 bg-black/20 hover:bg-black/50 backdrop-blur-md rounded-full flex items-center justify-center text-white transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        <!-- Area Gambar (Hero Image Promo) -->
                        <div class="relative h-64 sm:h-72 w-full bg-unmaris-blue overflow-hidden group">
                            @if($popupPromo->image)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($popupPromo->image) }}" alt="{{ $popupPromo->title }}" class="w-full h-full object-cover opacity-70 transform group-hover:scale-110 transition-transform duration-1000">
                            @else
                            <div class="w-full h-full bg-unmaris-blue opacity-70"></div>
                            @endif

                            <!-- Gradasi agar teks di atas gambar terbaca jelas -->
                            <div class="absolute inset-0 bg-gradient-to-t from-unmaris-blue via-unmaris-blue/40 to-transparent"></div>

                            <!-- Teks di atas gambar -->
                            <div class="absolute bottom-6 left-6 right-6">
                                @if($popupPromo->subtitle)
                                <span class="inline-block px-3 py-1 bg-unmaris-yellow text-unmaris-blue text-[10px] font-black uppercase tracking-widest rounded-full mb-3 shadow-md animate-pulse">{{ $popupPromo->subtitle }}</span>
                                @endif
                                <h3 class="text-3xl sm:text-4xl font-black text-white leading-tight drop-shadow-md">{{ $popupPromo->title }}</h3>
                            </div>
                        </div>

                        <!-- Area Konten & Tombol CTA -->
                        <div class="p-6 sm:p-8 bg-white relative">
                            <!-- Dekorasi lengkungan kuning -->
                            <div class="absolute top-0 right-0 w-24 h-24 bg-unmaris-yellow/10 rounded-bl-full pointer-events-none"></div>

                            <div class="text-gray-600 text-sm sm:text-base leading-relaxed mb-8 relative z-10 prose prose-sm prose-p:mb-2 prose-strong:text-unmaris-blue">
                                {!! $popupPromo->description !!}
                            </div>

                            <div class="flex flex-col gap-3 relative z-10">
                                @if($popupPromo->button_url)
                                <a href="{{ $popupPromo->button_url }}" target="_blank" class="w-full flex items-center justify-center bg-unmaris-yellow text-unmaris-blue py-4 rounded-full font-black uppercase tracking-widest text-xs hover:bg-yellow-400 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                                    {{ $popupPromo->button_text ?? 'Daftar Sekarang' }}
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                                @endif
                                <button @click="promoOpen = false; sessionStorage.setItem('promo_closed_{{ $popupPromo->id }}', 'true')" class="w-full text-center bg-gray-50 text-gray-500 py-3.5 rounded-full font-bold uppercase tracking-widest text-xs hover:bg-gray-100 hover:text-gray-700 transition-colors">
                                    Lihat Website Dulu
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- 1. HERO SLIDER SECTION (Mobile Split Layout & Desktop Overlay) -->
    @if(isset($sliders) && $sliders->count() > 0)
    <section class="relative w-full h-[80svh] min-h-[540px] md:h-[85svh] lg:min-h-[750px] bg-unmaris-blue overflow-hidden group"
        aria-roledescription="carousel"
        aria-label="Sorotan Kampus UNMARIS"
        x-data="{ 
            activeSlide: 0, 
            totalSlides: {{ $sliders->count() }},
            paused: false,
            touchStartX: 0,
            touchEndX: 0,
            
            autoPlay() {
                setInterval(() => {
                    if (!this.paused) {
                        this.nextSlide();
                    }
                }, 8000)
            },
            nextSlide() {
                this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
            },
            prevSlide() {
                this.activeSlide = this.activeSlide === 0 ? this.totalSlides - 1 : this.activeSlide - 1;
            },
            handleTouchStart(e) {
                this.touchStartX = e.changedTouches[0].screenX;
                this.paused = true;
            },
            handleTouchEnd(e) {
                this.touchEndX = e.changedTouches[0].screenX;
                this.paused = false;
                this.handleSwipe();
            },
            handleSwipe() {
                const swipeThreshold = 50;
                if (this.touchStartX - this.touchEndX > swipeThreshold) {
                    this.nextSlide(); // Swipe Kiri
                }
                if (this.touchEndX - this.touchStartX > swipeThreshold) {
                    this.prevSlide(); // Swipe Kanan
                }
            },
            // Tambahan fungsi untuk navigasi keyboard
            handleKeydown(e) {
                if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    this.nextSlide();
                } else if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    this.prevSlide();
                }
            }
         }"
        x-init="autoPlay()"
        @mouseenter="paused = true"
        @mouseleave="paused = false"
        @touchstart="handleTouchStart($event)"
        @touchend="handleTouchEnd($event)"
        @keydown="handleKeydown($event)"
        tabindex="0"> <!-- Memungkinkan bagian ini menerima fokus keyboard -->

        <!-- Tombol untuk screen reader agar bisa skip slider -->
        <a href="#setelah-slider" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:p-4 focus:bg-white focus:text-unmaris-blue focus:font-bold">
            Lewati bagian slider
        </a>

        <!-- Live region untuk mengumumkan perubahan slide ke screen reader -->
        <div class="sr-only" aria-live="polite" aria-atomic="true">
            Menampilkan slide <span x-text="activeSlide + 1"></span> dari {{ $sliders->count() }}
        </div>

        <!-- Slides Container -->
        @foreach($sliders as $index => $slider)
        <div x-show="activeSlide === {{ $index }}"
            role="tabpanel"
            aria-roledescription="slide"
            :aria-hidden="activeSlide !== {{ $index }}"
            x-transition:enter="transition-opacity ease-out duration-1000"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-1000"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0 w-full h-full flex flex-col md:flex-row"
            x-cloak>

            <!-- 1. AREA GAMBAR -->
            <div class="relative w-full h-[45%] sm:h-[50%] md:h-full md:w-1/2 md:order-2 bg-gray-100 overflow-hidden">
                @if($slider->image)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($slider->image) }}"
                    alt="{{ strip_tags($slider->title) }}"
                    class="w-full h-full object-cover transform transition-transform duration-[20000ms] ease-out origin-center"
                    :class="activeSlide === {{ $index }} ? 'scale-110' : 'scale-100'">
                @else
                <div class="absolute inset-0 bg-gradient-to-br from-unmaris-blue via-[#241b7a] to-slate-900" aria-hidden="true">
                    <svg class="absolute inset-0 h-full w-full text-white opacity-[0.12]" fill="none" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <pattern id="hero-dots-{{ $index }}" x="0" y="0" width="12" height="12" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="1.4" fill="currentColor" />
                        </pattern>
                        <rect width="100" height="100" fill="url(#hero-dots-{{ $index }})" />
                    </svg>
                    <div class="absolute inset-0 grid place-items-center p-10">
                        <img src="{{ asset('images/logo-unmaris.png') }}" alt=""
                            class="h-20 w-auto opacity-90 drop-shadow-2xl md:h-28" loading="lazy">
                    </div>
                    <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-unmaris-blue/70 to-transparent"></div>
                </div>
                @endif
            </div>

            <!-- 2. AREA KONTEN / TEKS -->
            <div class="relative w-full h-[55%] sm:h-[50%] md:h-full md:w-1/2 bg-unmaris-blue flex flex-col justify-center px-6 md:px-12 lg:px-20 z-10 md:order-1 overflow-hidden">

                <!-- Elemen Dekorasi Titik-titik -->
                <div class="absolute right-0 bottom-0 md:-right-10 md:bottom-10 opacity-10 md:opacity-20 pointer-events-none" aria-hidden="true">
                    <svg width="200" height="200" fill="none" viewBox="0 0 100 100">
                        <pattern id="dots-{{ $index }}" x="0" y="0" width="10" height="10" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="1.5" fill="currentColor" class="text-white"></circle>
                        </pattern>
                        <rect width="100" height="100" fill="url(#dots-{{ $index }})"></rect>
                    </svg>
                </div>

                <div class="w-full max-w-xl relative"
                    x-show="activeSlide === {{ $index }}"
                    x-transition:enter="transition ease-out duration-1000 delay-300"
                    x-transition:enter-start="opacity-0 translate-y-12"
                    x-transition:enter-end="opacity-100 translate-y-0">

                    <!-- Label (Jika Ada) -->
                    @if($slider->label)
                    <div class="mb-3 md:mb-5 relative z-10">
                        <span class="inline-flex items-center px-3 py-1 md:px-4 md:py-1.5 rounded-full bg-white/10 text-unmaris-yellow border border-white/20 text-[10px] md:text-xs font-black uppercase tracking-[0.2em] shadow-sm">
                            {{ $slider->label }}
                        </span>
                    </div>
                    @endif

                    <!-- Judul Slider -->
                    <h2 id="slide-title-{{ $index }}" class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 leading-tight drop-shadow-lg relative z-10">
                        {!! $slider->title !!}
                    </h2>

                    <!-- Deskripsi -->
                    <p class="text-sm md:text-base lg:text-lg text-gray-200 mb-8 md:mb-10 max-w-lg leading-relaxed drop-shadow-md relative z-10 line-clamp-3 md:line-clamp-none">
                        {{ $slider->description }}
                    </p>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center relative z-10 pb-8 md:pb-0">
                        @if($slider->button_url)
                        <a href="{{ $slider->button_url }}"
                            :tabindex="activeSlide === {{ $index }} ? '0' : '-1'"
                            class="inline-flex justify-center items-center bg-unmaris-yellow text-unmaris-blue px-6 py-3 md:px-8 md:py-4 min-h-[44px] rounded-full font-black text-[10px] md:text-sm uppercase tracking-widest hover:bg-white hover:scale-105 transition-all shadow-lg focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-50">
                            {{ $slider->button_text ?? 'Jelajahi' }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Slider Navigation Controls (Dots) -->
        <div class="absolute bottom-6 md:bottom-12 left-6 md:left-12 lg:left-20 z-30 flex justify-start items-center gap-2 md:gap-3" role="tablist" aria-label="Pilih slide">
            @foreach($sliders as $index => $slider)
            <button @click="activeSlide = {{ $index }}"
                role="tab"
                :aria-selected="activeSlide === {{ $index }}"
                aria-controls="slide-panel-{{ $index }}"
                aria-label="Tampilkan slide {{ $index + 1 }} dari {{ $sliders->count() }}"
                class="h-1.5 rounded-full transition-all duration-500 overflow-hidden relative focus:outline-none focus:ring-2 focus:ring-unmaris-yellow focus:ring-offset-2 focus:ring-offset-unmaris-blue"
                :class="activeSlide === {{ $index }} ? 'w-12 md:w-16 bg-white/40' : 'w-2 md:w-3 bg-white/20 hover:bg-white/50'">
                <div x-show="activeSlide === {{ $index }}" class="absolute top-0 left-0 bottom-0 bg-unmaris-yellow" x-transition:enter="transition-all ease-linear duration-[8000ms]" x-transition:enter-start="w-0" x-transition:enter-end="w-full"></div>
            </button>
            @endforeach
        </div>

        <!-- Navigation Arrows (Khusus Desktop) -->
        <div class="hidden md:flex absolute inset-y-0 left-4 right-4 z-20 justify-between items-center pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-500">
            <button @click="activeSlide = activeSlide === 0 ? totalSlides - 1 : activeSlide - 1"
                aria-label="Slide sebelumnya"
                class="pointer-events-auto w-12 h-12 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center text-white hover:bg-unmaris-yellow hover:text-unmaris-blue hover:border-unmaris-yellow transition-all shadow-lg transform hover:-translate-x-1 focus:outline-none focus:ring-4 focus:ring-unmaris-yellow">
                <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button @click="activeSlide = (activeSlide + 1) % totalSlides"
                aria-label="Slide selanjutnya"
                class="pointer-events-auto w-12 h-12 rounded-full bg-black/20 backdrop-blur-sm border border-white/20 flex items-center justify-center text-white hover:bg-unmaris-yellow hover:text-unmaris-blue hover:border-unmaris-yellow transition-all shadow-lg transform hover:translate-x-1 focus:outline-none focus:ring-4 focus:ring-unmaris-yellow">
                <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </section>
    <!-- Anchor untuk link "Lewati bagian slider" -->
    <div id="setelah-slider" tabindex="-1"></div>
    @endif

    <!-- 1b. AKSES CEPAT LAYANAN -->
    <section class="border-b border-slate-100 bg-white" aria-label="Akses cepat layanan">
        <div class="container-page py-6 md:py-8">
            <div class="grid grid-cols-2 gap-3 md:grid-cols-4 md:gap-4">
                <a href="https://pmb.unmarissumba.ac.id" target="_blank" rel="noopener"
                    class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-3.5 transition hover:-translate-y-0.5 hover:border-unmaris-blue/30 hover:shadow-lg md:p-4">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-yellow-50 text-yellow-700 transition group-hover:bg-unmaris-yellow group-hover:text-unmaris-blue">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </span>
                    <span class="min-w-0">
                        <span class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Penerimaan</span>
                        <span class="block truncate text-sm font-bold text-slate-900 transition group-hover:text-unmaris-blue">Daftar PMB</span>
                    </span>
                </a>

                <a href="{{ route('scholarships.index') }}"
                    class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-3.5 transition hover:-translate-y-0.5 hover:border-unmaris-blue/30 hover:shadow-lg md:p-4">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-emerald-50 text-emerald-700 transition group-hover:bg-emerald-600 group-hover:text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v7" />
                        </svg>
                    </span>
                    <span class="min-w-0">
                        <span class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Kemahasiswaan</span>
                        <span class="block truncate text-sm font-bold text-slate-900 transition group-hover:text-unmaris-blue">Info Beasiswa</span>
                    </span>
                </a>

                <a href="{{ route('akademik.unduhan') }}"
                    class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-3.5 transition hover:-translate-y-0.5 hover:border-unmaris-blue/30 hover:shadow-lg md:p-4">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-blue-50 text-unmaris-blue transition group-hover:bg-unmaris-blue group-hover:text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </span>
                    <span class="min-w-0">
                        <span class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Akademik</span>
                        <span class="block truncate text-sm font-bold text-slate-900 transition group-hover:text-unmaris-blue">Pusat Unduhan</span>
                    </span>
                </a>

                <a href="{{ route('complaint.index') }}"
                    class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-3.5 transition hover:-translate-y-0.5 hover:border-unmaris-blue/30 hover:shadow-lg md:p-4">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-rose-50 text-rose-600 transition group-hover:bg-rose-600 group-hover:text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </span>
                    <span class="min-w-0">
                        <span class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Layanan</span>
                        <span class="block truncate text-sm font-bold text-slate-900 transition group-hover:text-unmaris-blue">Pengaduan</span>
                    </span>
                </a>
            </div>
        </div>
    </section>

    <!-- 2. STATISTIK KAMPUS -->
    <section class="relative z-20 border-b border-slate-100 bg-slate-50" aria-label="Statistik kampus">
        <div class="container-page py-8 md:py-10">
            <dl class="grid grid-cols-2 gap-4 md:grid-cols-4 md:gap-6">
                <div class="rounded-2xl bg-white p-5 text-center shadow-sm ring-1 ring-slate-200/60">
                    <dd class="font-display text-3xl font-extrabold text-unmaris-blue sm:text-4xl">{{ $countProdi ?? 0 }}</dd>
                    <dt class="mt-1 text-[10px] font-bold uppercase tracking-widest text-slate-500 md:text-xs">Program Studi</dt>
                </div>
                <div class="rounded-2xl bg-white p-5 text-center shadow-sm ring-1 ring-slate-200/60">
                    <dd class="font-display text-3xl font-extrabold text-unmaris-blue sm:text-4xl">{{ $countFakultas ?? 0 }}</dd>
                    <dt class="mt-1 text-[10px] font-bold uppercase tracking-widest text-slate-500 md:text-xs">Fakultas</dt>
                </div>
                <div class="rounded-2xl bg-white p-5 text-center shadow-sm ring-1 ring-slate-200/60">
                    <dd class="font-display text-3xl font-extrabold text-unmaris-blue sm:text-4xl">{{ $countBerita ?? 0 }}+</dd>
                    <dt class="mt-1 text-[10px] font-bold uppercase tracking-widest text-slate-500 md:text-xs">Berita &amp; Publikasi</dt>
                </div>
                <div class="rounded-2xl bg-unmaris-blue p-5 text-center shadow-sm">
                    <dd class="font-display text-2xl font-extrabold text-unmaris-yellow sm:text-3xl">Baik</dd>
                    <dt class="mt-1 text-[10px] font-bold uppercase tracking-widest text-white/70 md:text-xs">Akreditasi Institusi</dt>
                </div>
            </dl>
        </div>
    </section>

    <!-- 3. VIDEO PROFIL KAMPUS POPUP -->
    <section class="relative overflow-hidden bg-slate-900 py-16 md:py-24" x-data="{ videoOpen: false }"
        @keydown.escape.window="videoOpen = false"
        x-effect="document.documentElement.style.overflow = videoOpen ? 'hidden' : ''">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-unmaris-blue/30 mix-blend-multiply"></div>
            <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
                alt="" aria-hidden="true" loading="lazy"
                class="h-full w-full object-cover opacity-30 grayscale">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/80 to-transparent"></div>
        </div>

        <div class="container-page relative z-10">
            <div class="mx-auto max-w-4xl text-center">
                <span class="eyebrow-light mb-3">Mengenal Lebih Dekat</span>
                <h2 class="mb-8 text-balance text-3xl font-extrabold leading-tight text-white md:mb-12 md:text-4xl lg:text-5xl">Jelajahi Kampus<br>Universitas Stella Maris Sumba</h2>

                <button type="button" @click="videoOpen = true"
                    class="group relative inline-flex items-center justify-center rounded-full"
                    aria-label="Putar video profil kampus">
                    <span class="absolute inset-0 animate-ping rounded-full bg-unmaris-yellow opacity-20 transition-opacity duration-300 group-hover:opacity-40"></span>
                    <span class="absolute -inset-4 scale-100 rounded-full bg-unmaris-yellow/20 blur-xl transition-transform duration-500 group-hover:scale-110"></span>

                    <span class="relative z-10 flex h-20 w-20 items-center justify-center rounded-full border-4 border-white/10 bg-unmaris-yellow shadow-[0_0_40px_rgba(253,224,26,0.4)] transition-all duration-300 group-hover:scale-105 group-hover:bg-white md:h-28 md:w-28">
                        <svg class="ml-1.5 h-8 w-8 text-unmaris-blue md:ml-2 md:h-10 md:w-10" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                    </span>
                </button>

                <p class="mx-auto mt-8 max-w-2xl text-sm font-medium text-slate-300 md:mt-10 md:text-base">Tonton video profil kami untuk melihat fasilitas, suasana belajar, dan kegiatan kemahasiswaan yang akan Anda alami selama berkuliah di UNMARIS.</p>
            </div>
        </div>

        <!-- Video Modal -->
        <div x-show="videoOpen" style="display: none;" role="dialog" aria-modal="true" aria-label="Video profil kampus"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 backdrop-blur-none"
            x-transition:enter-end="opacity-100 backdrop-blur-md"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 backdrop-blur-md"
            x-transition:leave-end="opacity-0 backdrop-blur-none"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-4 sm:p-6 md:p-12">
            <div class="relative w-full max-w-5xl aspect-video bg-black rounded-2xl shadow-2xl overflow-hidden transform transition-all" @click.away="videoOpen = false">
                <button @click="videoOpen = false" aria-label="Tutup video"
                    class="absolute -top-12 right-0 p-2 text-white/70 transition-colors hover:text-unmaris-yellow md:-right-12 md:top-0">
                    <svg class="h-8 w-8 md:h-10 md:w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <template x-if="videoOpen">
                    <iframe
                        class="w-full h-full"
                        src="https://www.youtube.com/embed/QPd6QsoQaPA?autoplay=1&rel=0&modestbranding=1&showinfo=0&controls=1"
                        title="Video Profil"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </template>
            </div>
        </div>
    </section>



    <!-- 5. BERITA & UPDATE TERBARU -->
    @if(isset($latestNews) && $latestNews->count() > 0)
    <section class="section-y border-t border-slate-100 bg-white">
        <div class="container-page">
            <x-ui.section-heading eyebrow="Informasi Terkini" title="Berita Kampus"
                description="Kabar terbaru seputar akademik, prestasi, dan kehidupan kampus Universitas Stella Maris Sumba."
                :href="route('news.index')" link-label="Semua Berita" />

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 md:gap-7">
                @foreach($latestNews as $item)
                <article class="card card-hover group flex h-full flex-col overflow-hidden">
                    <a href="{{ route('news.detail', $item->slug) }}" class="relative block aspect-[4/3] overflow-hidden bg-slate-100">
                        @if($item->featured_image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($item->featured_image) }}"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                            alt="{{ $item->title }}" loading="lazy">
                        @else
                        <div class="flex h-full w-full items-center justify-center text-slate-300">
                            <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        @endif

                        @if($item->video_url)
                        <span class="absolute inset-0 z-10 flex items-center justify-center bg-slate-900/10 transition group-hover:bg-transparent">
                            <span class="flex h-11 w-11 items-center justify-center rounded-full bg-white/70 text-unmaris-blue shadow-lg backdrop-blur transition group-hover:scale-110">
                                <svg class="ml-0.5 h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                            </span>
                        </span>
                        @endif

                        <span class="absolute left-3 top-3 z-20 rounded-full bg-unmaris-blue/90 px-3 py-1 text-[9px] font-extrabold uppercase tracking-wider text-white backdrop-blur">
                            {{ $item->category->name }}
                        </span>
                    </a>

                    <div class="flex flex-1 flex-col p-5">
                        <time datetime="{{ $item->published_at?->toDateString() }}" class="text-[10px] font-bold uppercase tracking-widest text-slate-400">
                            {{ $item->published_at?->translatedFormat('d F Y') }}
                        </time>
                        <h3 class="mt-2 line-clamp-3 text-base font-bold leading-snug text-slate-900 transition group-hover:text-unmaris-blue">
                            <a href="{{ route('news.detail', $item->slug) }}">{{ $item->title }}</a>
                        </h3>
                        <a href="{{ route('news.detail', $item->slug) }}"
                            class="mt-auto inline-flex items-center gap-1.5 pt-4 text-[11px] font-extrabold uppercase tracking-widest text-unmaris-blue transition hover:gap-2.5">
                            Baca selengkapnya
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="mt-8 text-center md:hidden">
                <a href="{{ route('news.index') }}" class="btn-outline w-full">Baca Berita Lainnya</a>
            </div>
        </div>
    </section>
    @endif

    <!-- 4. FAKULTAS & PROGRAM STUDI -->
    <section class="section-y bg-slate-50">
        <div class="container-page">
            <x-ui.section-heading eyebrow="Jalur Keilmuan" title="Fakultas Pilihan"
                description="Temukan program studi yang sesuai dengan minat dan cita-cita Anda di UNMARIS."
                :href="route('faculties.index')" link-label="Lihat Semua Fakultas" />

            @if(isset($faculties) && $faculties->count() > 0)
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 md:gap-7">
                @foreach($faculties->take(3) as $faculty)
                <a href="{{ route('faculties.detail', $faculty->slug) }}"
                    class="card card-hover group flex h-full flex-col overflow-hidden">
                    <div class="relative h-48 overflow-hidden bg-unmaris-blue md:h-52">
                        @if($faculty->image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($faculty->image) }}"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                            alt="{{ $faculty->name }}" loading="lazy">
                        @else
                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-unmaris-blue to-blue-900">
                            <svg class="h-14 w-14 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent"></div>
                        <h3 class="absolute bottom-4 left-5 right-5 font-display text-xl font-bold leading-tight text-white transition-colors group-hover:text-unmaris-yellow">
                            {{ $faculty->name }}
                        </h3>
                    </div>
                    <div class="flex flex-1 flex-col p-5 md:p-6">
                        <p class="line-clamp-3 text-sm leading-relaxed text-slate-600">
                            {{ $faculty->description ?? 'Pendidikan tinggi berkualitas untuk mencetak lulusan unggul, profesional, dan berkarakter.' }}
                        </p>
                        <div class="mt-auto flex items-center justify-between border-t border-slate-100 pt-4 text-[10px] font-extrabold uppercase tracking-widest text-unmaris-blue md:text-xs">
                            <span class="inline-flex items-center gap-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                {{ $faculty->studyPrograms ? $faculty->studyPrograms->count() : 0 }} Program Studi
                            </span>
                            <svg class="h-4 w-4 transition-transform group-hover:translate-x-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <x-ui.empty-state title="Data fakultas belum tersedia"
                description="Informasi fakultas dan program studi akan segera ditampilkan di halaman ini." />
            @endif

            <div class="mt-8 text-center md:hidden">
                <a href="{{ route('faculties.index') }}" class="btn-navy w-full">Lihat Semua Fakultas</a>
            </div>
        </div>
    </section>
    @if(isset($testimonials) && $testimonials->count() > 0)
    <section class="section-y relative overflow-hidden bg-white">
        <div class="pointer-events-none absolute -right-24 top-0 h-96 w-96 rounded-full bg-unmaris-blue opacity-[0.04] blur-3xl" aria-hidden="true"></div>
        <div class="container-page relative z-10">
            <x-ui.section-heading align="center" eyebrow="Jejak Karier" title="Kisah Sukses Alumni"
                description="Pengalaman para lulusan yang kini berkarya dan memberi dampak di berbagai bidang." />

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3 md:gap-7">
                @foreach($testimonials as $testi)
                <figure class="card flex h-full flex-col p-7 md:p-8">
                    <svg class="mb-5 h-9 w-9 text-unmaris-yellow" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                    </svg>
                    <blockquote class="flex-1 text-sm leading-relaxed text-slate-600 md:text-base">“{{ $testi->message }}”</blockquote>
                    <figcaption class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
                        @if($testi->image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($testi->image) }}" alt="{{ $testi->name }}"
                            class="h-11 w-11 rounded-full border-2 border-slate-100 object-cover" loading="lazy">
                        @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($testi->name) }}&background=1B1464&color=FDE01A"
                            alt="{{ $testi->name }}" class="h-11 w-11 rounded-full border-2 border-slate-100" loading="lazy">
                        @endif
                        <div class="min-w-0">
                            <p class="truncate text-sm font-bold text-slate-900">{{ $testi->name }}</p>
                            <p class="truncate text-[10px] font-bold uppercase tracking-wider text-slate-500">
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


    <!-- 7. MITRA / PARTNERS (Marquee) -->
    @if(isset($partners) && $partners->count() > 0)
    <section class="border-y border-slate-100 bg-slate-50 py-10" aria-label="Institusi mitra UNMARIS">
        <div class="container-page mb-6 text-center">
            <p class="text-[10px] font-extrabold uppercase tracking-[0.22em] text-slate-400 md:text-xs">Telah Dipercaya oleh Berbagai Institusi</p>
        </div>

        <div class="marquee overflow-hidden">
            <div class="marquee-track flex w-max items-center gap-12 px-6 md:gap-16">
                @foreach($partners->concat($partners) as $partner)
                <div class="flex shrink-0 items-center gap-2.5 text-base font-extrabold text-slate-400 md:text-lg">
                    @if($partner->logo)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($partner->logo) }}" alt="{{ $partner->name }}"
                        class="h-7 w-auto max-w-[9rem] object-contain opacity-70 grayscale md:h-8" loading="lazy">
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

    <!-- 8. MENGAPA MEMILIH KAMI -->
    <section class="section-y bg-white">
        <div class="container-page">
            <x-ui.section-heading align="center" eyebrow="Nilai Inti" title="Mengapa Memilih Kami?"
                description="Tiga pilar yang membentuk pengalaman belajar dan kesiapan karier lulusan UNMARIS." />

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3 md:gap-7">
                <div class="card group flex h-full flex-col items-center p-8 text-center md:p-10">
                    <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-unmaris-blue transition-colors duration-300 group-hover:bg-unmaris-blue group-hover:text-white md:h-16 md:w-16">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="heading-3 mb-3">Pendidikan Berkarakter</h3>
                    <p class="text-sm leading-relaxed text-slate-600 md:text-base">Menanamkan nilai-nilai integritas, etika profesional, dan karakter unggul di setiap langkah akademik lulusan.</p>
                </div>

                <div class="card group flex h-full flex-col items-center p-8 text-center md:p-10">
                    <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-yellow-50 text-yellow-700 transition-colors duration-300 group-hover:bg-unmaris-yellow group-hover:text-unmaris-blue md:h-16 md:w-16">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="heading-3 mb-3">Fasilitas Modern</h3>
                    <p class="text-sm leading-relaxed text-slate-600 md:text-base">Dukungan lingkungan kampus yang kondusif dengan laboratorium terpadu dan sistem e-learning terkini.</p>
                </div>

                <div class="card group flex h-full flex-col items-center p-8 text-center md:p-10">
                    <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-unmaris-blue transition-colors duration-300 group-hover:bg-unmaris-blue group-hover:text-white md:h-16 md:w-16">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="heading-3 mb-3">Lulusan Siap Kerja</h3>
                    <p class="text-sm leading-relaxed text-slate-600 md:text-base">Kurikulum yang disusun adaptif terhadap tantangan global, riset terapan, dan kebutuhan industri digital.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. CALL TO ACTION (PMB) -->
    <section class="relative overflow-hidden border-t-[6px] border-unmaris-yellow bg-unmaris-blue py-16 md:py-24">
        <div class="pointer-events-none absolute inset-0 opacity-[0.07]" aria-hidden="true">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                <polygon points="100,100 0,0 100,0" />
            </svg>
        </div>
        <div class="pointer-events-none absolute left-1/2 top-1/2 h-[400px] w-[400px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-unmaris-yellow opacity-20 blur-[110px] md:h-[700px] md:w-[700px] md:blur-[150px]" aria-hidden="true"></div>

        <div class="container-page relative z-10">
            <div class="mx-auto max-w-3xl text-center">
                <span class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-[10px] font-extrabold uppercase tracking-widest text-white backdrop-blur-sm md:text-xs">
                    Penerimaan Mahasiswa Baru
                </span>
                <h2 class="text-balance text-3xl font-extrabold leading-tight text-white sm:text-4xl md:text-5xl">
                    Mulai Perjalanan Akademikmu Sekarang.
                </h2>
                <p class="mx-auto mt-5 max-w-2xl text-sm leading-relaxed text-slate-300 md:text-base lg:text-lg">
                    Jadilah bagian dari Universitas Stella Maris Sumba dan kembangkan potensimu untuk membawa perubahan positif bagi bangsa.
                </p>

                <div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <a href="https://pmb.unmarissumba.ac.id" target="_blank" rel="noopener" class="btn-primary w-full sm:w-auto">
                        Daftar Sekarang
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="{{ route('contact') }}" class="btn-light-outline w-full sm:w-auto">Hubungi Panitia PMB</a>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>