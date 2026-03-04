<x-layouts.app title="Beranda - Universitas Stella Maris Sumba">
    
    <!-- Hero Slider Section (Dinamis dengan Pause on Hover) -->
    @if(isset($sliders) && $sliders->count() > 0)
    <section class="relative bg-unmaris-blue text-white overflow-hidden" 
             x-data="{ 
                activeSlide: 0, 
                totalSlides: {{ $sliders->count() }},
                paused: false,
                autoPlay() {
                    setInterval(() => {
                        if (!this.paused) {
                            this.activeSlide = (this.activeSlide + 1) % this.totalSlides
                        }
                    }, 7000)
                }
             }" 
             x-init="autoPlay()"
             @mouseenter="paused = true"
             @mouseleave="paused = false">
        
        <!-- Background Pattern & Global Glow -->
        <div class="absolute inset-0 opacity-10 z-0">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon fill="currentColor" points="0,100 100,0 100,100"/>
            </svg>
        </div>
        <div class="absolute -top-24 -left-24 w-64 h-64 md:w-96 md:h-96 bg-unmaris-yellow rounded-full blur-[80px] md:blur-[120px] opacity-20 z-0"></div>

        <!-- Slides Container -->
        <div class="relative min-h-[500px] md:min-h-[650px] lg:min-h-[750px] flex items-center">
            @foreach($sliders as $index => $slider)
            <div x-show="activeSlide === {{ $index }}" 
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 translate-x-10 md:translate-x-20"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0 -translate-x-10 md:-translate-x-20"
                 class="container mx-auto px-4 py-16 md:py-20 relative z-10 flex flex-col lg:flex-row items-center"
                 x-cloak>
                
                <!-- Konten Teks -->
                <div class="w-full lg:w-3/5 text-center lg:text-left lg:pr-10 pt-8 lg:pt-0">
                    @if($slider->label)
                    <span class="inline-block py-1 px-3 md:py-1.5 md:px-4 rounded-full bg-unmaris-yellow text-unmaris-blue text-[9px] md:text-[10px] font-extrabold tracking-[0.2em] mb-4 md:mb-6 uppercase shadow-sm">
                        {{ $slider->label }}
                    </span>
                    @endif

                    <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold mb-4 md:mb-6 leading-[1.1] md:leading-tight">
                        {!! $slider->title !!}
                    </h1>

                    <p class="text-base sm:text-lg md:text-xl text-gray-200 mb-8 md:mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        {{ $slider->description }}
                    </p>

                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-3 md:gap-4">
                        @if($slider->button_url)
                        <a href="{{ $slider->button_url }}" 
                           class="w-full sm:w-auto bg-unmaris-yellow text-unmaris-blue px-8 md:px-10 py-3.5 md:py-4 rounded-full font-bold text-sm md:text-lg hover:bg-yellow-400 hover:scale-105 transition-all shadow-xl text-center group">
                            {{ $slider->button_text ?? 'Lihat Selengkapnya' }}
                        </a>
                        @endif

                        <a href="{{ route('profile') }}" class="w-full sm:w-auto bg-white/10 backdrop-blur-sm border border-white/20 text-white px-8 md:px-10 py-3.5 md:py-4 rounded-full font-bold text-sm md:text-lg hover:bg-white hover:text-unmaris-blue transition-all text-center">
                            Kenali UNMARIS
                        </a>
                    </div>
                </div>
                
                <!-- Gambar Slider -->
                <div class="w-full lg:w-2/5 mt-12 lg:mt-0 hidden md:block">
                    <div class="relative group max-w-sm mx-auto lg:max-w-none">
                        <div class="absolute inset-0 bg-unmaris-yellow rounded-3xl blur-2xl opacity-10 transform -rotate-3 scale-105 group-hover:rotate-0 transition-transform duration-700"></div>
                        @if($slider->image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($slider->image) }}" 
                             alt="{{ strip_tags($slider->title) }}" 
                             class="rounded-3xl shadow-2xl relative z-10 border-4 md:border-8 border-white/10 object-cover aspect-[4/5] transform group-hover:scale-[1.02] transition-transform duration-700">
                        @else
                        <div class="rounded-3xl shadow-2xl relative z-10 border-4 md:border-8 border-white/10 bg-gray-800 aspect-[4/5] flex items-center justify-center">
                            <svg class="w-16 h-16 md:w-20 md:h-20 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Slider Navigation Controls -->
            <div class="absolute bottom-6 md:bottom-10 left-0 right-0 z-30 flex justify-center items-center gap-2 md:gap-3">
                @foreach($sliders as $index => $slider)
                <button @click="activeSlide = {{ $index }}" 
                        aria-label="Slide {{ $index + 1 }}"
                        class="h-1.5 md:h-2 rounded-full transition-all duration-300"
                        :class="activeSlide === {{ $index }} ? 'w-8 md:w-10 bg-unmaris-yellow' : 'w-2 bg-white/30 hover:bg-white/50'"></button>
                @endforeach
            </div>
            
            <!-- Navigation Arrows (Hidden on very small screens) -->
            <div class="hidden sm:flex absolute inset-x-0 top-1/2 -translate-y-1/2 z-20 justify-between px-4 md:px-10 pointer-events-none">
                <button @click="activeSlide = activeSlide === 0 ? totalSlides - 1 : activeSlide - 1" class="pointer-events-auto w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center text-white hover:bg-unmaris-yellow hover:text-unmaris-blue transition-all">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="activeSlide = (activeSlide + 1) % totalSlides" class="pointer-events-auto w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center text-white hover:bg-unmaris-yellow hover:text-unmaris-blue transition-all">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </section>
    @endif

    <!-- Stats Section (Dinamis dari Database) -->
    <section class="py-8 md:py-12 bg-white border-b border-gray-100 relative z-20 -mt-4 md:-mt-6 rounded-t-2xl md:rounded-t-3xl shadow-sm">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 text-center divide-x-0 md:divide-x divide-gray-100">
                <div class="p-2">
                    <p class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-unmaris-blue mb-1">{{ $countProdi ?? 0 }}</p>
                    <p class="text-[10px] md:text-xs lg:text-sm text-gray-500 font-bold uppercase tracking-wider">Program Studi</p>
                </div>
                <div class="p-2">
                    <p class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-unmaris-blue mb-1">{{ $countFakultas ?? 0 }}</p>
                    <p class="text-[10px] md:text-xs lg:text-sm text-gray-500 font-bold uppercase tracking-wider">Fakultas</p>
                </div>
                <div class="p-2">
                    <p class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-unmaris-blue mb-1">{{ $countBerita ?? 0 }}+</p>
                    <p class="text-[10px] md:text-xs lg:text-sm text-gray-500 font-bold uppercase tracking-wider">Publikasi & Riset</p>
                </div>
                <div class="p-2">
                    <p class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-unmaris-blue mb-1 md:mt-1">Baik Sekali</p>
                    <p class="text-[10px] md:text-xs lg:text-sm text-gray-500 font-bold uppercase tracking-wider">Akreditasi Institusi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Fakultas & Program Studi Preview -->
    <section class="py-16 md:py-24 bg-gray-50">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-10 md:mb-16 gap-6">
                <div class="text-center md:text-left">
                    <span class="text-unmaris-blue font-bold tracking-widest uppercase text-[10px] md:text-xs mb-2 md:mb-3 block">Jalur Pendidikan</span>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 border-b-4 border-unmaris-yellow inline-block pb-2">Fakultas Pilihan</h2>
                </div>
                <a href="{{ route('faculties.index') }}" class="hidden md:inline-flex items-center bg-white border border-gray-200 px-6 py-3 rounded-full text-unmaris-blue font-bold hover:bg-unmaris-blue hover:text-white transition-all shadow-sm">
                    Lihat Semua Fakultas <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @if(isset($featuredFaculties) && $featuredFaculties->count() > 0)
                    @foreach($featuredFaculties as $faculty)
                        <a href="{{ route('faculties.detail', $faculty->slug) }}" class="group bg-white rounded-2xl md:rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col h-full transform hover:-translate-y-2">
                            <div class="h-48 md:h-56 bg-unmaris-blue relative overflow-hidden">
                                @if($faculty->image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($faculty->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $faculty->name }}">
                                @else
                                    <div class="w-full h-full opacity-30 bg-gradient-to-br from-unmaris-blue to-blue-900 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent"></div>
                                <h3 class="absolute bottom-4 md:bottom-5 left-5 md:left-6 right-5 md:right-6 text-xl md:text-2xl font-bold text-white leading-tight group-hover:text-unmaris-yellow transition-colors">{{ $faculty->name }}</h3>
                            </div>
                            <div class="p-5 md:p-6 flex-grow flex flex-col justify-between">
                                <p class="text-gray-500 text-sm md:text-base mb-6 line-clamp-3 leading-relaxed">{{ $faculty->description ?? 'Pendidikan tinggi berkualitas untuk mencetak lulusan unggul, profesional, dan berkarakter.' }}</p>
                                <div class="flex items-center justify-between text-unmaris-blue font-bold text-[10px] md:text-xs uppercase tracking-widest mt-auto border-t border-gray-50 pt-4 group-hover:text-unmaris-yellow transition-colors">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        {{ $faculty->study_programs_count ?? 0 }} Program Studi
                                    </span>
                                    <svg class="w-4 h-4 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-gray-100">
                        <p class="text-gray-500 font-medium">Data Fakultas sedang diperbarui.</p>
                    </div>
                @endif
            </div>
            
            <div class="mt-8 text-center md:hidden">
                <a href="{{ route('faculties.index') }}" class="inline-flex items-center justify-center w-full bg-unmaris-blue text-white px-6 py-4 rounded-full font-bold hover:bg-unmaris-yellow hover:text-unmaris-blue transition shadow-md">
                    Lihat Semua Fakultas
                </a>
            </div>
        </div>
    </section>

    <!-- Mengapa UNMARIS Section -->
    <section class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="text-center mb-12 md:mb-16">
                <span class="text-unmaris-blue font-bold tracking-widest uppercase text-[10px] md:text-xs mb-2 md:mb-3 block">Nilai Inti</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 inline-block border-b-4 border-unmaris-yellow pb-2">Mengapa Memilih Kami?</h2>
                <p class="text-gray-600 mt-4 md:mt-5 text-base md:text-lg max-w-2xl mx-auto">Keunggulan Universitas Stella Maris Sumba dalam membangun karakter dan kompetensi masa depan.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <div class="bg-gray-50 p-8 md:p-10 rounded-2xl md:rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col items-center text-center group">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-blue-100 text-unmaris-blue rounded-xl md:rounded-2xl flex items-center justify-center mb-6 md:mb-8 group-hover:bg-unmaris-blue group-hover:text-white transition-colors duration-500">
                        <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3 md:mb-4">Pendidikan Berkarakter</h3>
                    <p class="text-gray-500 text-sm md:text-base leading-relaxed">Menanamkan nilai-nilai integritas, etika profesional, dan karakter unggul di setiap langkah akademik lulusan.</p>
                </div>

                <div class="bg-gray-50 p-8 md:p-10 rounded-2xl md:rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col items-center text-center group">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-yellow-100 text-yellow-700 rounded-xl md:rounded-2xl flex items-center justify-center mb-6 md:mb-8 group-hover:bg-unmaris-yellow group-hover:text-unmaris-blue transition-colors duration-500">
                        <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3 md:mb-4">Fasilitas Modern</h3>
                    <p class="text-gray-500 text-sm md:text-base leading-relaxed">Dukungan lingkungan kampus yang kondusif dengan laboratorium terpadu dan sistem e-learning terkini.</p>
                </div>

                <div class="bg-gray-50 p-8 md:p-10 rounded-2xl md:rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col items-center text-center group">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-blue-100 text-unmaris-blue rounded-xl md:rounded-2xl flex items-center justify-center mb-6 md:mb-8 group-hover:bg-unmaris-blue group-hover:text-white transition-colors duration-500">
                        <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3 md:mb-4">Lulusan Siap Kerja</h3>
                    <p class="text-gray-500 text-sm md:text-base leading-relaxed">Kurikulum yang disusun adaptif terhadap tantangan global, riset terapan, dan kebutuhan industri digital.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pengumuman & Agenda Papan Informasi -->
    <section class="py-16 md:py-24 bg-gray-900 text-white relative overflow-hidden">
        <div class="absolute right-0 bottom-0 w-full md:w-1/2 h-full opacity-5 pointer-events-none">
            <svg viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor" class="w-full h-full"><path d="M0 100 L100 0 L100 100 Z" /></svg>
        </div>
        
        <div class="container mx-auto px-4 max-w-7xl relative z-10">
            <div class="flex flex-col lg:flex-row gap-10 md:gap-12 lg:gap-16">
                <!-- Kiri: Judul -->
                <div class="w-full lg:w-1/3 text-center lg:text-left">
                    <span class="text-unmaris-yellow font-bold tracking-widest uppercase text-[10px] md:text-xs mb-2 md:mb-3 block">Pusat Informasi</span>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold mb-4 md:mb-6 leading-tight">Pengumuman &<br class="hidden lg:block">Agenda Kampus</h2>
                    <p class="text-gray-400 text-sm md:text-base mb-6 md:mb-8 max-w-md mx-auto lg:mx-0">Jangan lewatkan informasi akademik, jadwal kegiatan, dan pengumuman penting terbaru dari universitas.</p>
                    <a href="{{ route('announcements.index') }}" class="inline-flex items-center justify-center w-full sm:w-auto bg-gray-800 hover:bg-gray-700 text-white border border-gray-600 px-6 py-3.5 rounded-full font-bold transition group">
                        Lihat Papan Informasi
                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>

                <!-- Kanan: List Pengumuman -->
                <div class="w-full lg:w-2/3">
                    @if(isset($recentAnnouncements) && $recentAnnouncements->count() > 0)
                        <div class="space-y-4 md:space-y-5">
                            @foreach($recentAnnouncements as $announcement)
                                <a href="{{ route('announcements.detail', $announcement->slug) }}" class="block bg-gray-800/50 hover:bg-gray-800 border border-gray-700/50 hover:border-unmaris-yellow/50 rounded-2xl p-5 md:p-6 transition-all group">
                                    <div class="flex flex-row items-center gap-4 md:gap-6">
                                        <!-- Kotak Tanggal -->
                                        <div class="shrink-0 text-center w-14 md:w-16 bg-gray-900 py-2 rounded-xl border border-gray-700 group-hover:border-unmaris-yellow/30 transition-colors">
                                            <span class="block text-unmaris-yellow text-[10px] md:text-xs font-bold uppercase tracking-wider mb-0.5">{{ $announcement->start_date->format('M') }}</span>
                                            <span class="block text-xl md:text-2xl font-black text-white leading-none">{{ $announcement->start_date->format('d') }}</span>
                                        </div>
                                        <!-- Detail -->
                                        <div class="flex-grow min-w-0">
                                            <div class="flex items-center gap-2 mb-1.5 md:mb-2">
                                                <span class="text-[8px] md:text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wider {{ $announcement->type === 'agenda' ? 'bg-unmaris-blue text-white' : 'bg-yellow-500 text-gray-900' }}">
                                                    {{ $announcement->type }}
                                                </span>
                                            </div>
                                            <h3 class="text-base md:text-lg font-bold text-gray-100 group-hover:text-white leading-snug truncate md:whitespace-normal md:line-clamp-2">{{ $announcement->title }}</h3>
                                        </div>
                                        <div class="hidden sm:block shrink-0 text-gray-600 group-hover:text-unmaris-yellow transition">
                                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-800/30 border border-dashed border-gray-700 rounded-2xl p-8 md:p-12 text-center h-full flex flex-col justify-center items-center">
                            <svg class="w-10 h-10 md:w-12 md:h-12 text-gray-600 mb-3 md:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                            <p class="text-gray-400 text-sm md:text-base">Belum ada pengumuman atau agenda terbaru bulan ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- News Section (Berita & Publikasi Terkini) -->
    <section class="py-16 md:py-24 bg-gray-50 overflow-hidden border-t border-gray-200">
        <div class="container mx-auto px-4 max-w-7xl">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-10 md:mb-16 gap-6">
                <div class="text-center md:text-left relative z-10">
                    <span class="text-unmaris-blue font-bold tracking-widest uppercase text-[10px] md:text-xs mb-2 md:mb-3 block">Update Informasi</span>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900">Berita & <span class="text-unmaris-blue">Publikasi</span></h2>
                    <div class="h-1.5 w-16 md:w-24 bg-unmaris-yellow mt-3 md:mt-4 mx-auto md:mx-0 rounded-full"></div>
                </div>
                <a href="{{ route('news.index') }}" class="group inline-flex items-center gap-3 bg-white hover:bg-unmaris-blue px-5 md:px-6 py-2.5 md:py-3 rounded-full transition-all duration-300 border border-gray-200 shadow-sm hover:shadow-md">
                    <span class="text-unmaris-blue group-hover:text-white font-bold text-xs md:text-sm">Semua Berita</span>
                    <div class="w-6 h-6 md:w-8 md:h-8 bg-unmaris-yellow rounded-full flex items-center justify-center group-hover:rotate-45 transition-transform duration-500">
                        <svg class="w-3 h-3 md:w-4 md:h-4 text-unmaris-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </a>
            </div>

            @if(isset($latestNews) && $latestNews->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-10">
                    
                    <!-- LATEST NEWS HERO (Sisi Kiri - Besar) -->
                    @php $heroNews = $latestNews->first(); @endphp
                    <div class="w-full lg:col-span-7 group">
                        <article class="relative h-full min-h-[350px] sm:min-h-[450px] lg:min-h-[600px] rounded-3xl md:rounded-[2.5rem] overflow-hidden shadow-lg md:shadow-xl flex flex-col justify-end p-6 md:p-10 lg:p-12 transition-all duration-500 hover:shadow-2xl">
                            <!-- Background Image -->
                            <div class="absolute inset-0 z-0">
                                @if($heroNews->featured_image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($heroNews->featured_image) }}" alt="{{ $heroNews->title }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-unmaris-blue"></div>
                                @endif
                                <!-- Overlay Multi-layer -->
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 md:via-gray-900/40 to-transparent"></div>
                                <div class="absolute inset-0 bg-unmaris-blue/10 group-hover:bg-transparent transition-colors duration-500"></div>
                            </div>

                            <!-- Hero Content -->
                            <div class="relative z-10">
                                <div class="flex items-center gap-2 md:gap-3 mb-4 md:mb-6">
                                    <span class="bg-unmaris-yellow text-unmaris-blue text-[8px] md:text-[10px] font-black px-3 md:px-4 py-1 md:py-1.5 rounded-full uppercase tracking-widest shadow-sm">
                                        {{ $heroNews->category->name }}
                                    </span>
                                    <span class="text-white/80 text-[10px] md:text-xs font-bold flex items-center gap-1.5 md:gap-2">
                                        <div class="w-1.5 h-1.5 bg-unmaris-yellow rounded-full animate-pulse"></div>
                                        Terbaru
                                    </span>
                                </div>
                                <h3 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black text-white leading-tight mb-3 md:mb-6 group-hover:text-unmaris-yellow transition-colors duration-300 line-clamp-3 md:line-clamp-none">
                                    <a href="{{ route('news.detail', $heroNews->slug) }}">
                                        {{ $heroNews->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-300 text-sm md:text-lg lg:text-xl line-clamp-2 md:line-clamp-3 mb-6 md:mb-8 max-w-2xl leading-relaxed hidden sm:block">
                                    {{ $heroNews->excerpt }}
                                </p>
                                <a href="{{ route('news.detail', $heroNews->slug) }}" class="inline-flex items-center gap-3 md:gap-4 text-white font-bold text-sm md:text-base group/btn">
                                    <span class="border-b-2 border-unmaris-yellow pb-1 group-hover/btn:pr-2 md:group-hover/btn:pr-4 transition-all">Baca Artikel</span>
                                    <svg class="w-4 h-4 md:w-5 md:h-5 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </article>
                    </div>

                    <!-- SECONDARY NEWS (Sisi Kanan - Stacked) -->
                    <div class="w-full lg:col-span-5 flex flex-col gap-4 md:gap-6 lg:gap-8">
                        @forelse($latestNews->skip(1) as $item)
                            <article class="bg-white rounded-2xl md:rounded-[2rem] p-3 md:p-5 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group/card flex gap-4 md:gap-6 items-center">
                                <!-- Small Thumb -->
                                <div class="w-24 h-24 sm:w-28 sm:h-28 md:w-36 md:h-36 shrink-0 rounded-xl md:rounded-2xl overflow-hidden relative shadow-sm">
                                    @if($item->featured_image)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($item->featured_image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover/card:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                            <svg class="w-6 h-6 md:w-8 md:h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-unmaris-blue/0 group-hover/card:bg-unmaris-blue/10 transition-colors"></div>
                                </div>

                                <!-- Card Body -->
                                <div class="flex-grow min-w-0 py-1">
                                    <div class="flex items-center gap-2 md:gap-3 mb-2 md:mb-3">
                                        <span class="text-[8px] md:text-[9px] font-black text-unmaris-blue uppercase tracking-tighter border-b border-unmaris-yellow pb-0.5 truncate max-w-[100px] md:max-w-none">
                                            {{ $item->category->name }}
                                        </span>
                                        <span class="text-[9px] md:text-[10px] text-gray-400 font-bold shrink-0">
                                            {{ $item->published_at->format('d M Y') }}
                                        </span>
                                    </div>
                                    <h4 class="text-sm sm:text-base md:text-lg lg:text-xl font-bold text-gray-900 leading-snug md:leading-tight mb-2 md:mb-3 group-hover/card:text-unmaris-blue transition-colors line-clamp-2 md:line-clamp-3">
                                        <a href="{{ route('news.detail', $item->slug) }}">
                                            {{ $item->title }}
                                        </a>
                                    </h4>
                                    <a href="{{ route('news.detail', $item->slug) }}" class="text-unmaris-blue font-bold text-[10px] md:text-xs flex items-center gap-1.5 md:gap-2 group/link mt-auto inline-block">
                                        Selengkapnya
                                        <svg class="w-3 h-3 md:w-3.5 md:h-3.5 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                    </a>
                                </div>
                            </article>
                        @empty
                            <div class="h-full flex items-center justify-center border-2 border-dashed border-gray-200 rounded-[2rem] p-10 text-center">
                                <p class="text-gray-400 text-sm font-medium italic">Pantau terus untuk berita lainnya segera.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            @else
                <!-- TAMPILAN KOSONG -->
                <div class="text-center py-20 md:py-32 bg-white rounded-3xl md:rounded-[3rem] border border-gray-100 shadow-sm mx-4 md:mx-0">
                    <div class="w-16 h-16 md:w-24 md:h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 md:mb-8">
                        <svg class="w-8 h-8 md:w-10 md:h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 8H20"></path></svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-extrabold text-gray-900 mb-2">Belum Ada Publikasi</h3>
                    <p class="text-gray-500 font-medium max-w-sm mx-auto text-sm md:text-base">Kami sedang mempersiapkan informasi menarik untuk Anda. Silakan kembali lagi nanti.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Call To Action (PMB) Section -->
    <section class="py-16 md:py-24 relative overflow-hidden bg-unmaris-blue border-t-4 md:border-t-8 border-unmaris-yellow">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                <polygon points="100,100 0,0 100,0"/>
            </svg>
        </div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] md:w-[800px] md:h-[800px] bg-unmaris-yellow rounded-full blur-[100px] md:blur-[150px] opacity-20 pointer-events-none"></div>

        <div class="container mx-auto px-4 relative z-10 text-center max-w-4xl">
            <span class="inline-block py-1.5 px-4 md:px-5 bg-white/10 border border-white/20 text-white rounded-full text-[10px] md:text-xs font-bold tracking-widest uppercase mb-4 md:mb-6 backdrop-blur-sm shadow-sm">
                Penerimaan Mahasiswa Baru
            </span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white mb-4 md:mb-6 leading-tight">Mulai Perjalanan<br>Akademikmu Sekarang.</h2>
            <p class="text-base md:text-lg lg:text-xl text-gray-300 mb-8 md:mb-12 font-medium px-4 md:px-0">Jadilah bagian dari Universitas Stella Maris Sumba dan kembangkan potensimu untuk membawa perubahan positif bagi bangsa.</p>
            
            <div class="flex flex-col sm:flex-row justify-center items-center gap-3 md:gap-4 px-4 md:px-0">
                <a href="https://pmb.unmarissumba.ac.id" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center bg-unmaris-yellow text-unmaris-blue font-black text-base md:text-lg px-8 md:px-10 py-4 md:py-5 rounded-full hover:bg-white hover:scale-105 transition-all shadow-[0_10px_30px_rgba(253,224,26,0.3)]">
                    Daftar Sekarang
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                <a href="{{ route('contact') }}" class="w-full sm:w-auto inline-flex items-center justify-center bg-transparent border-2 border-white/30 text-white font-bold text-base md:text-lg px-8 md:px-10 py-4 md:py-5 rounded-full hover:bg-white/10 hover:border-white transition-all">
                    Hubungi Panitia PMB
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>