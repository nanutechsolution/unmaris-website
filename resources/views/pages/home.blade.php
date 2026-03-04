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
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-unmaris-yellow rounded-full blur-[120px] opacity-10 z-0"></div>

        <!-- Slides Container -->
        <div class="relative min-h-[600px] md:min-h-[750px] flex items-center">
            @foreach($sliders as $index => $slider)
            <div x-show="activeSlide === {{ $index }}" 
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 translate-x-20"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0 -translate-x-20"
                 class="container mx-auto px-4 py-20 relative z-10 flex flex-col md:flex-row items-center"
                 x-cloak>
                
                <!-- Konten Teks -->
                <div class="w-full md:w-3/5 text-center md:text-left md:pr-10">
                    @if($slider->label)
                    <span class="inline-block py-1.5 px-4 rounded-full bg-unmaris-yellow text-unmaris-blue text-[10px] font-extrabold tracking-[0.2em] mb-6 uppercase shadow-sm">
                        {{ $slider->label }}
                    </span>
                    @endif

                    <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">
                        {!! $slider->title !!}
                    </h1>

                    <p class="text-lg md:text-xl text-gray-200 mb-10 max-w-2xl mx-auto md:mx-0 leading-relaxed">
                        {{ $slider->description }}
                    </p>

                    <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                        @if($slider->button_url)
                        <a href="{{ $slider->button_url }}" 
                           class="bg-unmaris-yellow text-unmaris-blue px-10 py-4 rounded-full font-bold text-lg hover:bg-yellow-400 hover:scale-105 transition-all shadow-xl text-center group">
                            {{ $slider->button_text ?? 'Lihat Selengkapnya' }}
                        </a>
                        @endif

                        <a href="{{ route('profile') }}" class="bg-white/10 backdrop-blur-sm border-2 border-white/20 text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-unmaris-blue transition-all text-center">
                            Kenali UNMARIS
                        </a>
                    </div>
                </div>
                
                <!-- Gambar Slider -->
                <div class="w-full md:w-2/5 mt-16 md:mt-0 hidden md:block">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-unmaris-yellow rounded-3xl blur-2xl opacity-10 transform -rotate-3 scale-105 group-hover:rotate-0 transition-transform duration-700"></div>
                        @if($slider->image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($slider->image) }}" 
                             alt="{{ strip_tags($slider->title) }}" 
                             class="rounded-3xl shadow-2xl relative z-10 border-8 border-white/10 object-cover aspect-[4/5] transform group-hover:scale-[1.02] transition-transform duration-700">
                        @else
                        <div class="rounded-3xl shadow-2xl relative z-10 border-8 border-white/10 bg-gray-800 aspect-[4/5] flex items-center justify-center">
                            <svg class="w-20 h-20 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Slider Navigation Controls -->
            <div class="absolute bottom-10 left-0 right-0 z-30 flex justify-center items-center gap-3">
                @foreach($sliders as $index => $slider)
                <button @click="activeSlide = {{ $index }}" 
                        class="h-2 rounded-full transition-all duration-300"
                        :class="activeSlide === {{ $index }} ? 'w-10 bg-unmaris-yellow' : 'w-2 bg-white/30 hover:bg-white/50'"></button>
                @endforeach
            </div>
            
            <!-- Navigation Arrows -->
            <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 z-20 flex justify-between px-4 md:px-10 pointer-events-none">
                <button @click="activeSlide = activeSlide === 0 ? totalSlides - 1 : activeSlide - 1" class="pointer-events-auto w-12 h-12 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center text-white hover:bg-unmaris-yellow hover:text-unmaris-blue transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="activeSlide = (activeSlide + 1) % totalSlides" class="pointer-events-auto w-12 h-12 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center text-white hover:bg-unmaris-yellow hover:text-unmaris-blue transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </section>
    @endif

    <!-- Stats Section (Dinamis dari Database) -->
    <section class="py-12 bg-white border-b border-gray-100">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="text-3xl md:text-4xl font-extrabold text-unmaris-blue mb-1">{{ $countProdi ?? 0 }}</p>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Program Studi</p>
                </div>
                <div>
                    <p class="text-3xl md:text-4xl font-extrabold text-unmaris-blue mb-1">{{ $countFakultas ?? 0 }}</p>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Fakultas</p>
                </div>
                <div>
                    <p class="text-3xl md:text-4xl font-extrabold text-unmaris-blue mb-1">{{ $countBerita ?? 0 }}+</p>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Publikasi & Riset</p>
                </div>
                <div>
                    <!-- Akreditasi kampus biasanya bersifat statis, jadi tetap dipertahankan -->
                    <p class="text-3xl md:text-4xl font-extrabold text-unmaris-blue mb-1">Baik Sekali</p>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Akreditasi Kampus</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mengapa UNMARIS Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-unmaris-blue inline-block border-b-4 border-unmaris-yellow pb-2">Mengapa Memilih Kami?</h2>
                <p class="text-gray-600 mt-4 text-lg">Keunggulan Universitas Stella Maris Sumba dalam membangun masa depan.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Poin 1 -->
                <div class="bg-white p-10 rounded-3xl shadow-sm hover:shadow-xl transition-all border border-gray-100 flex flex-col items-center text-center group">
                    <div class="w-20 h-20 bg-blue-50 text-unmaris-blue rounded-2xl flex items-center justify-center mb-8 group-hover:bg-unmaris-blue group-hover:text-white transition-colors duration-500">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Pendidikan Berkarakter</h3>
                    <p class="text-gray-500 leading-relaxed">Menanamkan nilai-nilai integritas, etika, dan karakter unggul di setiap lulusan.</p>
                </div>

                <!-- Poin 2 -->
                <div class="bg-white p-10 rounded-3xl shadow-sm hover:shadow-xl transition-all border border-gray-100 flex flex-col items-center text-center group">
                    <div class="w-20 h-20 bg-yellow-50 text-unmaris-yellow rounded-2xl flex items-center justify-center mb-8 group-hover:bg-unmaris-yellow group-hover:text-unmaris-blue transition-colors duration-500">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Fasilitas Modern</h3>
                    <p class="text-gray-500 leading-relaxed">Lingkungan kampus kondusif dengan laboratorium dan sistem pendukung terkini.</p>
                </div>

                <!-- Poin 3 -->
                <div class="bg-white p-10 rounded-3xl shadow-sm hover:shadow-xl transition-all border border-gray-100 flex flex-col items-center text-center group">
                    <div class="w-20 h-20 bg-blue-50 text-unmaris-blue rounded-2xl flex items-center justify-center mb-8 group-hover:bg-unmaris-blue group-hover:text-white transition-colors duration-500">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Lulusan Siap Kerja</h3>
                    <p class="text-gray-500 leading-relaxed">Kurikulum yang adaptif terhadap tantangan global dan kebutuhan industri digital.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section (Berita & Publikasi Terkini) -->
    <section class="py-24 bg-white overflow-hidden">
        <div class="container mx-auto px-4 max-w-6xl">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-16 gap-6 relative">
                <div class="text-center md:text-left relative z-10">
                    <span class="text-unmaris-blue font-bold tracking-widest uppercase text-xs mb-3 block">Update Informasi</span>
                    <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900">Berita & <span class="text-unmaris-blue">Publikasi</span></h2>
                    <div class="h-1.5 w-24 bg-unmaris-yellow mt-4 mx-auto md:mx-0 rounded-full"></div>
                </div>
                <a href="{{ route('news.index') }}" class="group inline-flex items-center gap-3 bg-gray-50 hover:bg-unmaris-blue px-6 py-3 rounded-full transition-all duration-300 border border-gray-100 shadow-sm">
                    <span class="text-unmaris-blue group-hover:text-white font-bold text-sm">Lihat Semua Berita</span>
                    <div class="w-8 h-8 bg-unmaris-yellow rounded-full flex items-center justify-center group-hover:rotate-45 transition-transform duration-500">
                        <svg class="w-4 h-4 text-unmaris-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </a>
            </div>

            @if(isset($latestNews) && $latestNews->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                    
                    <!-- LATEST NEWS HERO (Sisi Kiri - Besar) -->
                    @php $heroNews = $latestNews->first(); @endphp
                    <div class="lg:col-span-7 group">
                        <article class="relative h-full min-h-[450px] lg:min-h-[600px] rounded-[2.5rem] overflow-hidden shadow-2xl flex flex-col justify-end p-8 md:p-12 transition-all duration-500 hover:shadow-unmaris-blue/20">
                            <!-- Background Image -->
                            <div class="absolute inset-0 z-0">
                                @if($heroNews->featured_image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($heroNews->featured_image) }}" alt="{{ $heroNews->title }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-unmaris-blue"></div>
                                @endif
                                <!-- Overlay Multi-layer -->
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
                                <div class="absolute inset-0 bg-unmaris-blue/10 group-hover:bg-transparent transition-colors duration-500"></div>
                            </div>

                            <!-- Hero Content -->
                            <div class="relative z-10">
                                <div class="flex items-center gap-3 mb-6">
                                    <span class="bg-unmaris-yellow text-unmaris-blue text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-lg">
                                        {{ $heroNews->category->name }}
                                    </span>
                                    <span class="text-white/80 text-xs font-bold flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 bg-unmaris-yellow rounded-full animate-pulse"></div>
                                        Terbaru
                                    </span>
                                </div>
                                <h3 class="text-3xl md:text-5xl font-black text-white leading-tight mb-6 group-hover:text-unmaris-yellow transition-colors duration-300">
                                    <a href="{{ route('news.detail', $heroNews->slug) }}">
                                        {{ $heroNews->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-300 text-lg md:text-xl line-clamp-2 mb-8 max-w-2xl leading-relaxed">
                                    {{ $heroNews->excerpt }}
                                </p>
                                <a href="{{ route('news.detail', $heroNews->slug) }}" class="inline-flex items-center gap-4 text-white font-bold group/btn">
                                    <span class="border-b-2 border-unmaris-yellow pb-1 group-hover/btn:pr-4 transition-all">Baca Selengkapnya</span>
                                    <svg class="w-5 h-5 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </article>
                    </div>

                    <!-- SECONDARY NEWS (Sisi Kanan - Stacked) -->
                    <div class="lg:col-span-5 flex flex-col gap-8">
                        @forelse($latestNews->skip(1) as $item)
                            <article class="bg-white rounded-[2rem] p-5 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group/card flex gap-6 items-center">
                                <!-- Small Thumb -->
                                <div class="w-28 h-28 md:w-40 md:h-40 shrink-0 rounded-2xl overflow-hidden relative shadow-md">
                                    @if($item->featured_image)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($item->featured_image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover/card:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-unmaris-blue/10 group-hover/card:bg-transparent transition-colors"></div>
                                </div>

                                <!-- Card Body -->
                                <div class="flex-grow">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span class="text-[9px] font-black text-unmaris-blue uppercase tracking-tighter border-b border-unmaris-yellow pb-0.5">
                                            {{ $item->category->name }}
                                        </span>
                                        <span class="text-[10px] text-gray-400 font-bold">
                                            {{ $item->published_at->format('d M Y') }}
                                        </span>
                                    </div>
                                    <h4 class="text-lg md:text-xl font-bold text-gray-900 leading-snug mb-3 group-hover/card:text-unmaris-blue transition-colors">
                                        <a href="{{ route('news.detail', $item->slug) }}">
                                            {{ Str::limit($item->title, 50) }}
                                        </a>
                                    </h4>
                                    <a href="{{ route('news.detail', $item->slug) }}" class="text-unmaris-blue font-bold text-xs flex items-center gap-2 group/link">
                                        Selengkapnya
                                        <svg class="w-3.5 h-3.5 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                    </a>
                                </div>
                            </article>
                        @empty
                            <!-- Jika hanya ada 1 berita, sisi kanan bisa diisi info atau dikosongkan -->
                            <div class="h-full flex items-center justify-center border-2 border-dashed border-gray-100 rounded-[2rem] p-10 text-center">
                                <p class="text-gray-400 text-sm font-medium italic italic">Pantau terus untuk berita lainnya segera.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            @else
                <!-- TAMPILAN KOSONG -->
                <div class="text-center py-32 bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-8 shadow-sm">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 8H20"></path></svg>
                    </div>
                    <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Belum Ada Publikasi</h3>
                    <p class="text-gray-500 font-medium max-w-sm mx-auto">Kami sedang mempersiapkan informasi menarik untuk Anda. Silakan kembali lagi nanti.</p>
                </div>
            @endif
        </div>
    </section>

</x-layouts.app>