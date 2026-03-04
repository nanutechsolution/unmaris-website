<x-layouts.app title="Beranda - Universitas Stella Maris Sumba">
    
    <!-- Hero Slider Section (Menggunakan Alpine.js) -->
    <section class="relative bg-unmaris-blue text-white overflow-hidden" 
             x-data="{ 
                activeSlide: 1, 
                slides: [1, 2, 3],
                autoPlay() {
                    setInterval(() => {
                        this.activeSlide = this.activeSlide === this.slides.length ? 1 : this.activeSlide + 1
                    }, 6000)
                }
             }" 
             x-init="autoPlay()">
        
        <!-- Background Pattern & Global Glow -->
        <div class="absolute inset-0 opacity-10 z-0">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon fill="currentColor" points="0,100 100,0 100,100"/>
            </svg>
        </div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-unmaris-yellow rounded-full blur-[120px] opacity-10 z-0"></div>

        <!-- Slides Container -->
        <div class="relative min-h-[600px] md:min-h-[700px] flex items-center">
            
            <!-- Slide 1: PMB -->
            <div x-show="activeSlide === 1" 
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 translate-x-12"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0 -translate-x-12"
                 class="container mx-auto px-4 py-20 relative z-10 flex flex-col md:flex-row items-center">
                
                <div class="w-full md:w-3/5 text-center md:text-left md:pr-10">
                    <span class="inline-block py-1.5 px-4 rounded-full bg-unmaris-yellow text-unmaris-blue text-[10px] font-extrabold tracking-[0.2em] mb-6 uppercase shadow-sm">
                        Admission Open 2025/2026
                    </span>
                    <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">
                        Membangun Masa Depan<br>
                        <span class="text-unmaris-yellow">Dari Sumba Untuk Dunia</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-200 mb-10 max-w-2xl mx-auto md:mx-0 leading-relaxed">
                        Wujudkan cita-cita di Universitas Stella Maris Sumba. Kampus peradaban yang membentuk karakter unggul, inovatif, dan berdaya saing global.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                        <a href="https://pmb.unmaris.ac.id" target="_blank" class="bg-unmaris-yellow text-unmaris-blue px-10 py-4 rounded-full font-bold text-lg hover:bg-yellow-400 hover:scale-105 transition-all shadow-xl text-center group">
                            Daftar Sekarang 
                        </a>
                        <a href="{{ route('profile') }}" class="bg-white/10 backdrop-blur-sm border-2 border-white/20 text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-unmaris-blue transition-all text-center">
                            Kenali UNMARIS
                        </a>
                    </div>
                </div>
                
                <div class="w-full md:w-2/5 mt-16 md:mt-0 hidden md:block">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                             alt="Gedung UNMARIS" 
                             class="rounded-3xl shadow-2xl relative z-10 border-8 border-white/10 object-cover aspect-[4/5] transform hover:rotate-2 transition-transform duration-500">
                    </div>
                </div>
            </div>

            <!-- Slide 2: Beasiswa & Prestasi -->
            <div x-show="activeSlide === 2" 
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 translate-x-12"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0 -translate-x-12"
                 class="container mx-auto px-4 py-20 relative z-10 flex flex-col md:flex-row items-center" x-cloak>
                
                <div class="w-full md:w-3/5 text-center md:text-left md:pr-10">
                    <span class="inline-block py-1.5 px-4 rounded-full bg-blue-500 text-white text-[10px] font-extrabold tracking-[0.2em] mb-6 uppercase shadow-sm">
                        Scholarship Program
                    </span>
                    <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">
                        Pendidikan Berkualitas<br>
                        <span class="text-unmaris-yellow">Tanpa Batas Biaya</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-200 mb-10 max-w-2xl mx-auto md:mx-0 leading-relaxed">
                        Tersedia berbagai program beasiswa prestasi dan bantuan biaya pendidikan bagi putra-putri terbaik daerah Sumba.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                        <a href="#" class="bg-unmaris-yellow text-unmaris-blue px-10 py-4 rounded-full font-bold text-lg hover:bg-yellow-400 transition-all shadow-xl text-center">
                            Info Beasiswa
                        </a>
                    </div>
                </div>
                
                <div class="w-full md:w-2/5 mt-16 md:mt-0 hidden md:block">
                    <img src="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Mahasiswa Berprestasi" 
                         class="rounded-3xl shadow-2xl relative z-10 border-8 border-white/10 object-cover aspect-[4/5]">
                </div>
            </div>

            <!-- Slide 3: Fasilitas & E-Learning -->
            <div x-show="activeSlide === 3" 
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 translate-x-12"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0 -translate-x-12"
                 class="container mx-auto px-4 py-20 relative z-10 flex flex-col md:flex-row items-center" x-cloak>
                
                <div class="w-full md:w-3/5 text-center md:text-left md:pr-10">
                    <span class="inline-block py-1.5 px-4 rounded-full bg-green-500 text-white text-[10px] font-extrabold tracking-[0.2em] mb-6 uppercase shadow-sm">
                        Modern Facilities
                    </span>
                    <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">
                        Lingkungan Belajar<br>
                        <span class="text-unmaris-yellow">Inovatif & Modern</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-200 mb-10 max-w-2xl mx-auto md:mx-0 leading-relaxed">
                        Fasilitas penunjang akademik yang lengkap, laboratorium terstandarisasi, dan dukungan sistem E-Learning terpadu.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                        <a href="{{ route('akademik.sistem') }}" class="bg-unmaris-yellow text-unmaris-blue px-10 py-4 rounded-full font-bold text-lg hover:bg-yellow-400 transition-all shadow-xl text-center">
                            Lihat Fasilitas
                        </a>
                    </div>
                </div>
                
                <div class="w-full md:w-2/5 mt-16 md:mt-0 hidden md:block">
                    <img src="https://images.unsplash.com/photo-1498243639359-2cee966503c5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Laboratorium UNMARIS" 
                         class="rounded-3xl shadow-2xl relative z-10 border-8 border-white/10 object-cover aspect-[4/5]">
                </div>
            </div>

            <!-- Slider Controls (Bottom Centered) -->
            <div class="absolute bottom-10 left-0 right-0 z-30 flex justify-center items-center gap-3">
                <template x-for="slide in slides" :key="slide">
                    <button @click="activeSlide = slide" 
                            class="h-2 rounded-full transition-all duration-300"
                            :class="activeSlide === slide ? 'w-10 bg-unmaris-yellow' : 'w-2 bg-white/30 hover:bg-white/50'"></button>
                </template>
            </div>
            
            <!-- Navigation Arrows (Sides) -->
            <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 z-20 flex justify-between px-4 md:px-10 pointer-events-none">
                <button @click="activeSlide = activeSlide === 1 ? slides.length : activeSlide - 1" class="pointer-events-auto w-12 h-12 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center text-white hover:bg-unmaris-yellow hover:text-unmaris-blue transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="activeSlide = activeSlide === slides.length ? 1 : activeSlide + 1" class="pointer-events-auto w-12 h-12 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center text-white hover:bg-unmaris-yellow hover:text-unmaris-blue transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-white border-b border-gray-100">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="text-3xl md:text-4xl font-extrabold text-unmaris-blue mb-1">12+</p>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Program Studi</p>
                </div>
                <div>
                    <p class="text-3xl md:text-4xl font-extrabold text-unmaris-blue mb-1">2.5k+</p>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Mahasiswa Aktif</p>
                </div>
                <div>
                    <p class="text-3xl md:text-4xl font-extrabold text-unmaris-blue mb-1">100+</p>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Dosen Ahli</p>
                </div>
                <div>
                    <p class="text-3xl md:text-4xl font-extrabold text-unmaris-blue mb-1">95%</p>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Keterserapan Kerja</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-unmaris-blue inline-block border-b-4 border-unmaris-yellow pb-2">Mengapa UNMARIS?</h2>
                <p class="text-gray-600 mt-4 text-lg">Keunggulan kami dalam mendidik generasi penerus bangsa.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Point 1 -->
                <div class="bg-white p-10 rounded-3xl shadow-sm hover:shadow-xl transition-all border border-gray-100 flex flex-col items-center text-center group">
                    <div class="w-20 h-20 bg-blue-50 text-unmaris-blue rounded-2xl flex items-center justify-center mb-8 group-hover:bg-unmaris-blue group-hover:text-white transition-colors duration-500">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Kurikulum Berbasis Industri</h3>
                    <p class="text-gray-500 leading-relaxed">Materi pembelajaran yang disinkronisasi dengan kebutuhan dunia kerja masa kini.</p>
                </div>

                <!-- Point 2 -->
                <div class="bg-white p-10 rounded-3xl shadow-sm hover:shadow-xl transition-all border border-gray-100 flex flex-col items-center text-center group">
                    <div class="w-20 h-20 bg-yellow-50 text-unmaris-yellow rounded-2xl flex items-center justify-center mb-8 group-hover:bg-unmaris-yellow group-hover:text-unmaris-blue transition-colors duration-500">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Fasilitas Modern</h3>
                    <p class="text-gray-500 leading-relaxed">Laboratorium lengkap, perpustakaan digital, dan lingkungan kampus yang nyaman.</p>
                </div>

                <!-- Point 3 -->
                <div class="bg-white p-10 rounded-3xl shadow-sm hover:shadow-xl transition-all border border-gray-100 flex flex-col items-center text-center group">
                    <div class="w-20 h-20 bg-blue-50 text-unmaris-blue rounded-2xl flex items-center justify-center mb-8 group-hover:bg-unmaris-blue group-hover:text-white transition-colors duration-500">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Pembentukan Karakter</h3>
                    <p class="text-gray-500 leading-relaxed">Fokus pada integritas dan etika kristiani untuk mencetak agen perubahan sosial.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-12 gap-4">
                <div class="text-center md:text-left">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-unmaris-blue">Berita & Publikasi</h2>
                    <p class="text-gray-600 mt-2">Update informasi terkini dari civitas akademika.</p>
                </div>
                <a href="{{ route('news.index') }}" class="inline-flex items-center text-unmaris-blue font-bold hover:text-unmaris-yellow transition group">
                    Lihat Semua Berita 
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($latestNews as $item)
                    <article class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-100 flex flex-col h-full group">
                        <a href="{{ route('news.detail', $item->slug) }}" class="block relative overflow-hidden">
                            <div class="h-60 bg-gray-200 w-full flex items-center justify-center overflow-hidden">
                                @if($item->featured_image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($item->featured_image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover transform transition duration-700 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-unmaris-blue opacity-5 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-unmaris-blue opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="absolute top-4 left-4">
                                <span class="bg-unmaris-yellow text-unmaris-blue text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-tighter shadow-md">
                                    {{ $item->category->name }}
                                </span>
                            </div>
                        </a>
                        <div class="p-8 flex flex-col flex-grow">
                            <div class="flex items-center text-xs text-gray-400 mb-4 font-bold">
                                <svg class="w-4 h-4 mr-1.5 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $item->published_at->format('d M Y') }}
                            </div>
                            <h3 class="text-xl font-bold mb-4 text-gray-900 leading-tight group-hover:text-unmaris-blue transition-colors">
                                <a href="{{ route('news.detail', $item->slug) }}">
                                    {{ Str::limit($item->title, 55) }}
                                </a>
                            </h3>
                            <p class="text-gray-500 text-sm mb-6 flex-grow leading-relaxed">
                                {{ Str::limit($item->excerpt, 90) }}
                            </p>
                            <a href="{{ route('news.detail', $item->slug) }}" class="inline-flex items-center text-sm font-extrabold text-unmaris-blue hover:text-unmaris-yellow transition-all mt-auto group/read">
                                Baca Selengkapnya 
                                <svg class="w-4 h-4 ml-1.5 transform group-hover/read:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 text-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                        <p class="text-gray-400 font-medium italic">Belum ada berita yang dipublikasikan hari ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

</x-layouts.app>