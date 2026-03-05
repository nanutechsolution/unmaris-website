<x-layouts.app title="Beranda - Universitas Stella Maris Sumba">

    <!-- 0. POP-UP PROMO OVERLAY (PMB) -->
    @if(isset($popupPromo) && $popupPromo)
    <div x-data="{ promoOpen: false }"
        x-init="setTimeout(() => { if(!sessionStorage.getItem('promo_closed_{{ $popupPromo->id }}')) promoOpen = true }, 2000)">

        <div x-show="promoOpen" style="display: none;" class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
                        <button @click="promoOpen = false; sessionStorage.setItem('promo_closed_{{ $popupPromo->id }}', 'true')" class="absolute top-4 right-4 z-20 w-10 h-10 bg-black/20 hover:bg-black/50 backdrop-blur-md rounded-full flex items-center justify-center text-white transition-all shadow-sm">
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
    <!-- 1. HERO SLIDER SECTION (Premium Cinematic Layout) -->
    @if(isset($sliders) && $sliders->count() > 0)
    <section class="relative w-full h-[85vh] min-h-[600px] lg:min-h-[750px] bg-unmaris-blue overflow-hidden group"
        x-data="{ 
                activeSlide: 0, 
                totalSlides: {{ $sliders->count() }},
                paused: false,
                autoPlay() {
                    setInterval(() => {
                        if (!this.paused) {
                            this.activeSlide = (this.activeSlide + 1) % this.totalSlides
                        }
                    }, 8000)
                }
             }"
        x-init="autoPlay()"
        @mouseenter="paused = true"
        @mouseleave="paused = false"
        @touchstart="paused = true"
        @touchend="paused = false">

        <!-- Slides Container -->
        @foreach($sliders as $index => $slider)
        <div x-show="activeSlide === {{ $index }}"
            x-transition:enter="transition-opacity ease-out duration-1000"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-1000"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0 w-full h-full"
            x-cloak>

            <!-- Background Image & Overlays -->
            <div class="absolute inset-0 w-full h-full overflow-hidden bg-unmaris-blue">
                @if($slider->image)
                <!-- Efek Slow Zoom (Ken Burns Effect) -->
                <img src="{{ \Illuminate\Support\Facades\Storage::url($slider->image) }}"
                    alt="{{ strip_tags($slider->title) }}"
                    class="w-full h-full object-cover transform transition-transform duration-[15000ms] ease-out origin-center"
                    :class="activeSlide === {{ $index }} ? 'scale-110' : 'scale-100'">
                @else
                <!-- Fallback Pattern jika admin tidak unggah gambar -->
                <div class="absolute inset-0 opacity-10 flex items-center justify-center">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                        <path d="M0 0 L100 0 L100 100 L0 100 Z" />
                    </svg>
                </div>
                @endif

                <!-- Deep Gradient Overlays: Menjamin teks selalu terbaca -->
                <!-- Gradient Kiri ke Kanan (Kuat di kiri untuk teks) -->
                <div class="absolute inset-0 bg-gradient-to-r from-unmaris-blue/95 via-unmaris-blue/70 to-transparent"></div>
                <!-- Gradient Bawah ke Atas (Khusus mobile agar teks bawah tetap jelas) -->
                <div class="absolute inset-0 bg-gradient-to-t from-unmaris-blue/90 via-unmaris-blue/20 to-transparent md:hidden"></div>
            </div>

            <!-- Konten Teks -->
            <div class="relative z-10 container mx-auto px-4 sm:px-6 md:px-8 h-full flex flex-col justify-end md:justify-center pb-24 md:pb-0">
                <div class="max-w-3xl"
                    x-show="activeSlide === {{ $index }}"
                    x-transition:enter="transition ease-out duration-1000 delay-300"
                    x-transition:enter-start="opacity-0 translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0">

                    @if($slider->label)
                    <div class="mb-5 md:mb-6">
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-unmaris-yellow text-[10px] md:text-xs font-bold uppercase tracking-[0.2em] shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-unmaris-yellow mr-2 animate-pulse"></span>
                            {{ $slider->label }}
                        </span>
                    </div>
                    @endif

                    <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-white mb-4 md:mb-6 leading-[1.2] md:leading-[1.1] tracking-tight drop-shadow-lg">
                        {!! $slider->title !!}
                    </h1>

                    <p class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-200 mb-8 md:mb-10 max-w-2xl leading-relaxed font-medium drop-shadow-md">
                        {{ $slider->description }}
                    </p>

                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        @if($slider->button_url)
                        <a href="{{ $slider->button_url }}"
                            class="w-full sm:w-auto inline-flex justify-center items-center bg-unmaris-yellow text-unmaris-blue px-8 py-3.5 md:py-4 rounded-full font-black text-xs md:text-sm uppercase tracking-widest hover:bg-white hover:scale-105 transition-all shadow-lg">
                            {{ $slider->button_text ?? 'Jelajahi' }}
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                        @endif

                        <a href="{{ route('profile') }}" class="w-full sm:w-auto inline-flex justify-center items-center bg-white/10 backdrop-blur-md border border-white/20 text-white px-8 py-3.5 md:py-4 rounded-full font-bold text-xs md:text-sm uppercase tracking-widest hover:bg-white hover:text-unmaris-blue transition-all">
                            Profil Kampus
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Slider Navigation Controls (Dots) -->
        <div class="absolute bottom-8 md:bottom-12 left-0 right-0 z-30 flex justify-center items-center gap-3">
            @foreach($sliders as $index => $slider)
            <button @click="activeSlide = {{ $index }}"
                aria-label="Slide {{ $index + 1 }}"
                class="h-1 md:h-1.5 rounded-full transition-all duration-500 overflow-hidden relative"
                :class="activeSlide === {{ $index }} ? 'w-10 md:w-16 bg-white/30' : 'w-2 md:w-3 bg-white/30 hover:bg-white/50'">
                <!-- Progress bar animation effect inside the active dot -->
                <div x-show="activeSlide === {{ $index }}"
                    class="absolute top-0 left-0 bottom-0 bg-unmaris-yellow"
                    x-transition:enter="transition-all ease-linear duration-[8000ms]"
                    x-transition:enter-start="w-0"
                    x-transition:enter-end="w-full">
                </div>
            </button>
            @endforeach
        </div>

        <!-- Navigation Arrows (Hidden on very small screens, Elegant design) -->
        <div class="hidden md:flex absolute inset-y-0 right-4 lg:right-10 z-20 flex-col justify-center gap-4 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-500">
            <button @click="activeSlide = activeSlide === 0 ? totalSlides - 1 : activeSlide - 1" class="pointer-events-auto w-12 h-12 rounded-full bg-black/20 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white hover:bg-unmaris-yellow hover:text-unmaris-blue hover:border-unmaris-yellow transition-all shadow-lg transform hover:-translate-x-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button @click="activeSlide = (activeSlide + 1) % totalSlides" class="pointer-events-auto w-12 h-12 rounded-full bg-black/20 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white hover:bg-unmaris-yellow hover:text-unmaris-blue hover:border-unmaris-yellow transition-all shadow-lg transform hover:translate-x-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </section>
    @endif

    <!-- 2. STATISTIK KAMPUS -->
    <section class="py-8 md:py-12 bg-white border-b border-gray-100 relative z-20 -mt-4 md:-mt-6 rounded-t-2xl md:rounded-t-3xl shadow-[0_-10px_40px_rgba(0,0,0,0.05)]">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 text-center divide-x-0 md:divide-x divide-gray-100">
                <div class="p-2 transform transition hover:-translate-y-1">
                    <p class="text-3xl sm:text-4xl md:text-5xl font-black text-unmaris-blue mb-1 drop-shadow-sm">{{ $countProdi ?? 0 }}</p>
                    <p class="text-[10px] md:text-xs lg:text-sm text-gray-500 font-bold uppercase tracking-widest">Program Studi</p>
                </div>
                <div class="p-2 transform transition hover:-translate-y-1">
                    <p class="text-3xl sm:text-4xl md:text-5xl font-black text-unmaris-blue mb-1 drop-shadow-sm">{{ $countFakultas ?? 0 }}</p>
                    <p class="text-[10px] md:text-xs lg:text-sm text-gray-500 font-bold uppercase tracking-widest">Fakultas Utama</p>
                </div>
                <div class="p-2 transform transition hover:-translate-y-1">
                    <p class="text-3xl sm:text-4xl md:text-5xl font-black text-unmaris-blue mb-1 drop-shadow-sm">{{ $countBerita ?? 0 }}+</p>
                    <p class="text-[10px] md:text-xs lg:text-sm text-gray-500 font-bold uppercase tracking-widest">Publikasi & Riset</p>
                </div>
                <div class="p-2 transform transition hover:-translate-y-1">
                    <p class="text-2xl sm:text-3xl md:text-4xl font-black text-unmaris-blue mb-1 md:mt-1 drop-shadow-sm">Baik Sekali</p>
                    <p class="text-[10px] md:text-xs lg:text-sm text-gray-500 font-bold uppercase tracking-widest">Akreditasi Institusi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. VIDEO PROFIL KAMPUS POPUP -->
    <section class="py-16 md:py-24 bg-gray-900 relative overflow-hidden" x-data="{ videoOpen: false }">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-unmaris-blue/30 mix-blend-multiply"></div>
            <!-- Anda bisa mengganti link ini dengan gambar kampus UNMARIS dari atas (drone) -->
            <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Kampus Background" class="w-full h-full object-cover opacity-30 grayscale">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/80 to-transparent"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <span class="text-unmaris-yellow font-black tracking-widest uppercase text-[10px] md:text-xs mb-3 block">Mengenal Lebih Dekat</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-8 md:mb-12 leading-tight">Jelajahi Kampus<br>Universitas Stella Maris Sumba</h2>

                <div class="relative inline-block group cursor-pointer" @click="videoOpen = true">
                    <div class="absolute inset-0 bg-unmaris-yellow rounded-full animate-ping opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                    <div class="absolute -inset-4 bg-unmaris-yellow/20 rounded-full scale-100 group-hover:scale-110 transition-transform duration-500 blur-xl"></div>

                    <div class="relative w-20 h-20 md:w-28 md:h-28 bg-unmaris-yellow rounded-full flex items-center justify-center shadow-[0_0_40px_rgba(253,224,26,0.4)] group-hover:scale-105 group-hover:bg-white transition-all duration-300 z-10 border-4 border-white/10">
                        <svg class="w-8 h-8 md:w-10 md:h-10 text-unmaris-blue ml-1.5 md:ml-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                    </div>
                </div>

                <p class="text-gray-300 mt-8 md:mt-10 text-sm md:text-base max-w-2xl mx-auto font-medium">Tonton video profil kami untuk melihat fasilitas, suasana belajar, dan kegiatan kemahasiswaan yang akan Anda alami selama berkuliah di UNMARIS.</p>
            </div>
        </div>

        <!-- Video Modal -->
        <div x-show="videoOpen" style="display: none;"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 backdrop-blur-none"
            x-transition:enter-end="opacity-100 backdrop-blur-md"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 backdrop-blur-md"
            x-transition:leave-end="opacity-0 backdrop-blur-none"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-4 sm:p-6 md:p-12">
            <div class="relative w-full max-w-5xl aspect-video bg-black rounded-2xl shadow-2xl overflow-hidden transform transition-all" @click.away="videoOpen = false">
                <button @click="videoOpen = false" class="absolute -top-12 right-0 md:-right-12 md:top-0 text-white/70 hover:text-unmaris-yellow transition-colors p-2">
                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <template x-if="videoOpen">
                    <iframe class="w-full h-full" src="https://www.youtube.com/watch?v=QPd6QsoQaPA" title="Video Profil" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </template>
            </div>
        </div>
    </section>

    <!-- 4. FAKULTAS & PROGRAM STUDI -->
    <section class="py-16 md:py-24 bg-gray-50">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-10 md:mb-16 gap-6">
                <div class="text-center md:text-left">
                    <span class="text-unmaris-blue font-black tracking-widest uppercase text-[10px] md:text-xs mb-2 md:mb-3 block">Jalur Keilmuan</span>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 border-b-4 border-unmaris-yellow inline-block pb-2">Fakultas Pilihan</h2>
                </div>
                <a href="{{ route('faculties.index') }}" class="hidden md:inline-flex items-center bg-white border border-gray-200 px-6 py-3 rounded-full text-unmaris-blue font-bold hover:bg-unmaris-blue hover:text-white transition-all shadow-sm">
                    Lihat Semua Fakultas <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @if(isset($faculties) && $faculties->count() > 0)
                @foreach($faculties->take(3) as $faculty)
                <a href="{{ route('faculties.detail', $faculty->slug) }}" class="group bg-white rounded-2xl md:rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 overflow-hidden flex flex-col h-full transform hover:-translate-y-2">
                    <div class="h-48 md:h-56 bg-unmaris-blue relative overflow-hidden">
                        @if($faculty->image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($faculty->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000" alt="{{ $faculty->name }}">
                        @else
                        <div class="w-full h-full opacity-30 bg-gradient-to-br from-unmaris-blue to-blue-900 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent"></div>
                        <h3 class="absolute bottom-4 md:bottom-5 left-5 md:left-6 right-5 md:right-6 text-xl md:text-2xl font-bold text-white leading-tight group-hover:text-unmaris-yellow transition-colors">{{ $faculty->name }}</h3>
                    </div>
                    <div class="p-5 md:p-6 flex-grow flex flex-col justify-between">
                        <p class="text-gray-500 text-sm md:text-base mb-6 line-clamp-3 leading-relaxed font-medium">{{ $faculty->description ?? 'Pendidikan tinggi berkualitas untuk mencetak lulusan unggul, profesional, dan berkarakter.' }}</p>
                        <div class="flex items-center justify-between text-unmaris-blue font-bold text-[10px] md:text-xs uppercase tracking-widest mt-auto border-t border-gray-50 pt-4 group-hover:text-unmaris-yellow transition-colors">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                {{ $faculty->studyPrograms ? $faculty->studyPrograms->count() : 0 }} Program Studi
                            </span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </div>
                    </div>
                </a>
                @endforeach
                @endif
            </div>

            <div class="mt-8 text-center md:hidden">
                <a href="{{ route('faculties.index') }}" class="inline-flex items-center justify-center w-full bg-unmaris-blue text-white px-6 py-4 rounded-full font-bold hover:bg-unmaris-yellow hover:text-unmaris-blue transition shadow-md">
                    Lihat Semua Fakultas
                </a>
            </div>
        </div>
    </section>

    <!-- 5. BERITA & UPDATE TERBARU (PENAMBAHAN BARU) -->
    @if(isset($latestNews) && $latestNews->count() > 0)
    <section class="py-16 md:py-24 bg-white border-t border-gray-100">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-10 md:mb-16 gap-6">
                <div class="text-center md:text-left">
                    <span class="text-unmaris-blue font-black tracking-widest uppercase text-[10px] md:text-xs mb-2 md:mb-3 block">Informasi Terkini</span>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 border-b-4 border-unmaris-yellow inline-block pb-2">Berita Kampus</h2>
                </div>
                <a href="{{ route('news.index') }}" class="hidden md:inline-flex items-center text-unmaris-blue font-black text-xs md:text-sm uppercase tracking-widest hover:text-unmaris-yellow transition group">
                    Semua Berita
                    <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center ml-3 group-hover:bg-unmaris-yellow transition-colors">
                        <svg class="w-4 h-4 text-unmaris-blue transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                @foreach($latestNews as $item)
                <article class="group bg-gray-50 rounded-[2rem] p-3 border border-gray-100 hover:border-gray-200 hover:shadow-xl transition-all duration-500 flex flex-col h-full">
                    <a href="{{ route('news.detail', $item->slug) }}" class="block relative aspect-[4/3] rounded-2xl overflow-hidden mb-4 shadow-sm">
                        @if($item->featured_image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($item->featured_image) }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="{{ $item->title }}">
                        @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif

                        @if($item->video_url)
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors z-10 flex items-center justify-center">
                            <div class="w-10 h-10 bg-white/50 backdrop-blur-md rounded-full flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-4 h-4 ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                            </div>
                        </div>
                        @endif

                        <div class="absolute top-3 left-3 z-20">
                            <span class="bg-unmaris-blue/90 backdrop-blur-md text-white text-[8px] font-black px-3 py-1.5 rounded-full uppercase tracking-tighter shadow-sm">
                                {{ $item->category->name }}
                            </span>
                        </div>
                    </a>

                    <div class="px-2 flex flex-col flex-grow">
                        <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mb-2 flex items-center gap-1.5">
                            <div class="w-1.5 h-1.5 bg-unmaris-yellow rounded-full"></div>
                            {{ $item->published_at->format('d M Y') }}
                        </span>
                        <h3 class="text-sm md:text-base font-black text-gray-900 leading-snug mb-3 group-hover:text-unmaris-blue transition-colors line-clamp-3">
                            <a href="{{ route('news.detail', $item->slug) }}">
                                {{ $item->title }}
                            </a>
                        </h3>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="mt-8 text-center md:hidden">
                <a href="{{ route('news.index') }}" class="inline-block w-full bg-gray-50 border border-gray-200 text-gray-700 px-6 py-3.5 rounded-full font-bold text-sm hover:bg-unmaris-blue hover:text-white transition shadow-sm">
                    Baca Berita Lainnya
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- 6. TESTIMONI ALUMNI (UI DRAFT - Modul Akan Dibuat) -->
    @if(isset($testimonials) && $testimonials->count() > 0)
    <section class="py-16 md:py-24 bg-gray-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-unmaris-blue opacity-5 rounded-l-full blur-3xl pointer-events-none"></div>
        <div class="container mx-auto px-4 max-w-7xl relative z-10">
            <div class="text-center mb-12 md:mb-16">
                <span class="text-unmaris-blue font-black tracking-widest uppercase text-[10px] md:text-xs mb-2 md:mb-3 block">Jejak Karir</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 inline-block border-b-4 border-unmaris-yellow pb-2">Kisah Sukses Alumni</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                @foreach($testimonials as $testi)
                <div class="bg-white p-8 md:p-10 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 relative group flex flex-col h-full">
                    <div class="absolute top-8 right-8 text-gray-100 group-hover:text-unmaris-yellow transition-colors opacity-50">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                    </div>
                    <p class="text-gray-600 text-sm md:text-base leading-relaxed mb-8 relative z-10 font-medium italic flex-grow">"{{ $testi->message }}"</p>
                    <div class="flex items-center gap-4 mt-auto relative z-10">
                        @if($testi->image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($testi->image) }}" alt="{{ $testi->name }}" class="w-12 h-12 rounded-full border-2 border-gray-100 object-cover">
                        @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($testi->name) }}&background=1B1464&color=FDE01A" alt="{{ $testi->name }}" class="w-12 h-12 rounded-full border-2 border-gray-100">
                        @endif
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm">{{ $testi->name }}</h4>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">
                                {{ $testi->job_title }} {{ $testi->company ? 'di ' . $testi->company : '' }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif


    <!-- 7. MITRA / PARTNERS (Marquee Simpel) -->
    @if(isset($partners) && $partners->count() > 0)
    <section class="py-10 border-t border-b border-gray-100 bg-white overflow-hidden">
        <div class="container mx-auto px-4 text-center mb-6">
            <p class="text-[10px] md:text-xs font-black text-gray-400 uppercase tracking-widest">Telah Dipercaya Oleh Berbagai Institusi</p>
        </div>
        <!-- Infinite Scroll Animation Wrapper (Tailwind util class needed in app.css, or just simple flex wrap for now) -->
        <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-60 grayscale hover:grayscale-0 transition-all duration-500 max-w-5xl mx-auto px-4">
            @foreach($partners as $partner)
            <div class="text-xl font-black text-gray-400 flex items-center gap-2">
                @if($partner->logo)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($partner->logo) }}" alt="{{ $partner->name }}" class="h-8 object-contain">
                @else
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                </svg>
                @endif
                {{ $partner->name }}
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- 8. MENGAPA MEMILIH KAMI -->
    <section class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="text-center mb-12 md:mb-16">
                <span class="text-unmaris-blue font-black tracking-widest uppercase text-[10px] md:text-xs mb-2 md:mb-3 block">Nilai Inti</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 inline-block border-b-4 border-unmaris-yellow pb-2">Mengapa Memilih Kami?</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <div class="bg-gray-50 p-8 md:p-10 rounded-[2.5rem] shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col items-center text-center group">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-blue-100 text-unmaris-blue rounded-2xl flex items-center justify-center mb-6 md:mb-8 group-hover:bg-unmaris-blue group-hover:text-white transition-colors duration-500 shadow-sm transform group-hover:rotate-6">
                        <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3">Pendidikan Berkarakter</h3>
                    <p class="text-gray-500 text-sm md:text-base leading-relaxed font-medium">Menanamkan nilai-nilai integritas, etika profesional, dan karakter unggul di setiap langkah akademik lulusan.</p>
                </div>

                <div class="bg-gray-50 p-8 md:p-10 rounded-[2.5rem] shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col items-center text-center group">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-yellow-100 text-yellow-700 rounded-2xl flex items-center justify-center mb-6 md:mb-8 group-hover:bg-unmaris-yellow group-hover:text-unmaris-blue transition-colors duration-500 shadow-sm transform group-hover:rotate-6">
                        <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3">Fasilitas Modern</h3>
                    <p class="text-gray-500 text-sm md:text-base leading-relaxed font-medium">Dukungan lingkungan kampus yang kondusif dengan laboratorium terpadu dan sistem e-learning terkini.</p>
                </div>

                <div class="bg-gray-50 p-8 md:p-10 rounded-[2.5rem] shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col items-center text-center group">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-blue-100 text-unmaris-blue rounded-2xl flex items-center justify-center mb-6 md:mb-8 group-hover:bg-unmaris-blue group-hover:text-white transition-colors duration-500 shadow-sm transform group-hover:-rotate-6">
                        <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3">Lulusan Siap Kerja</h3>
                    <p class="text-gray-500 text-sm md:text-base leading-relaxed font-medium">Kurikulum yang disusun adaptif terhadap tantangan global, riset terapan, dan kebutuhan industri digital.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. CALL TO ACTION (PMB) -->
    <section class="py-16 md:py-24 relative overflow-hidden bg-unmaris-blue border-t-8 border-unmaris-yellow">
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                <polygon points="100,100 0,0 100,0" />
            </svg>
        </div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] md:w-[800px] md:h-[800px] bg-unmaris-yellow rounded-full blur-[100px] md:blur-[150px] opacity-20 pointer-events-none"></div>

        <div class="container mx-auto px-4 relative z-10 text-center max-w-4xl">
            <span class="inline-block py-1.5 px-4 md:px-5 bg-white/10 border border-white/20 text-white rounded-full text-[10px] md:text-xs font-bold tracking-widest uppercase mb-4 md:mb-6 backdrop-blur-sm shadow-sm">Penerimaan Mahasiswa Baru</span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white mb-4 md:mb-6 leading-tight">Mulai Perjalanan<br>Akademikmu Sekarang.</h2>
            <p class="text-base md:text-lg lg:text-xl text-gray-300 mb-8 md:mb-12 font-medium px-4 md:px-0">Jadilah bagian dari Universitas Stella Maris Sumba dan kembangkan potensimu untuk membawa perubahan positif bagi bangsa.</p>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 px-4 md:px-0">
                <a href="https://pmb.unmaris.ac.id" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center bg-unmaris-yellow text-unmaris-blue font-black text-base md:text-lg px-8 md:px-10 py-4 md:py-5 rounded-full hover:bg-white hover:scale-105 transition-all shadow-[0_10px_30px_rgba(253,224,26,0.3)]">
                    Daftar Sekarang <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
                <a href="{{ route('contact') }}" class="w-full sm:w-auto inline-flex items-center justify-center bg-transparent border-2 border-white/30 text-white font-bold text-base md:text-lg px-8 md:px-10 py-4 md:py-5 rounded-full hover:bg-white/10 hover:border-white transition-all">
                    Hubungi Panitia PMB
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>