<div class="bg-white min-h-screen pb-16 md:pb-24">
    <!-- Header Section (Premium Minimalist) -->
    <section class="bg-unmaris-blue text-white py-16 md:py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                <path d="M0 0 L100 0 L100 100 L0 100 Z" />
            </svg>
        </div>
        <div class="container mx-auto px-4 sm:px-6 relative z-10 text-center">
            <span class="text-unmaris-yellow font-black tracking-[0.2em] md:tracking-[0.3em] uppercase text-[10px] md:text-xs mb-3 md:mb-4 block">Pusat Media Resmi</span>
            <h1 class="text-4xl md:text-5xl lg:text-7xl font-black mb-4 md:mb-6 tracking-tighter">Berita & <span class="text-unmaris-yellow">Publikasi</span></h1>
            <p class="text-gray-300 text-sm md:text-lg lg:text-xl max-w-2xl mx-auto leading-relaxed font-medium">Jendela informasi mengenai terobosan riset, prestasi global, dan dinamika akademik di Universitas Stella Maris Sumba.</p>
        </div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 max-w-7xl -mt-8 md:-mt-10 relative z-20">
        <!-- Search & Filter Bar -->
        <div class="bg-white rounded-2xl md:rounded-[2rem] shadow-xl border border-gray-100 p-4 md:p-6 mb-10 md:mb-16">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-4 md:gap-6">
                
                <!-- Category Tabs (Horizontal Scroll on Mobile) -->
                <div class="flex items-center gap-2 overflow-x-auto w-full lg:w-auto pb-2 lg:pb-0 hide-scrollbar snap-x">
                    <button wire:click="filterCategory(null)" 
                        class="snap-start shrink-0 px-5 md:px-6 py-2 md:py-2.5 rounded-full text-xs md:text-sm font-bold transition-all {{ is_null($selectedCategory) ? 'bg-unmaris-blue text-white shadow-lg' : 'bg-gray-50 text-gray-500 hover:bg-gray-100' }}">
                        Semua Berita
                    </button>
                    @foreach($categories as $cat)
                        <button wire:click="filterCategory('{{ $cat->id }}')" 
                            class="snap-start shrink-0 px-5 md:px-6 py-2 md:py-2.5 rounded-full text-xs md:text-sm font-bold transition-all {{ $selectedCategory == $cat->id ? 'bg-unmaris-blue text-white shadow-lg' : 'bg-gray-50 text-gray-500 hover:bg-gray-100' }}">
                            {{ $cat->name }}
                        </button>
                    @endforeach
                </div>

                <!-- Search Input -->
                <div class="relative w-full lg:w-80 shrink-0">
                    <input wire:model.live.debounce.500ms="search" type="text" placeholder="Cari artikel atau berita..." 
                        class="w-full pl-10 md:pl-12 pr-4 md:pr-6 py-2.5 md:py-3 bg-gray-50 border border-gray-200 lg:border-none rounded-full focus:ring-2 focus:ring-unmaris-yellow focus:border-unmaris-yellow text-sm font-medium transition-all outline-none">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-400 absolute left-3.5 md:left-4 top-3 md:top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- 1. FEATURED HERO NEWS (Hanya di Halaman 1 & Tanpa Filter) -->
        @if($featuredNews && $news->onFirstPage() && !$search && !$selectedCategory)
            <div class="mb-12 md:mb-20 group">
                <article class="relative min-h-[400px] sm:min-h-[450px] md:min-h-[600px] rounded-3xl md:rounded-[3rem] overflow-hidden shadow-2xl flex flex-col justify-end p-6 sm:p-8 md:p-12 lg:p-16 transition-transform duration-700 hover:scale-[0.99]">
                    <!-- Image Layer -->
                    <div class="absolute inset-0 z-0">
                        @if($featuredNews->featured_image)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($featuredNews->featured_image) }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="{{ $featuredNews->title }}">
                        @else
                            <div class="w-full h-full bg-unmaris-blue"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/70 md:via-gray-900/50 to-transparent"></div>
                    </div>

                    <!-- Content Layer -->
                    <div class="relative z-10 max-w-4xl">
                        <div class="flex items-center gap-3 md:gap-4 mb-4 md:mb-6">
                            <span class="bg-unmaris-yellow text-unmaris-blue text-[9px] md:text-[10px] font-black px-3 md:px-5 py-1 md:py-2 rounded-full uppercase tracking-widest shadow-lg">
                                {{ $featuredNews->category->name }}
                            </span>
                            <span class="text-white/80 text-[10px] md:text-xs font-bold uppercase tracking-widest">{{ $featuredNews->published_at->format('d M Y') }}</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-black text-white leading-[1.15] md:leading-[1.1] mb-4 md:mb-8 group-hover:text-unmaris-yellow transition-colors duration-300">
                            <a href="{{ route('news.detail', $featuredNews->slug) }}">
                                {{ $featuredNews->title }}
                            </a>
                        </h2>
                        <p class="text-gray-300 text-sm sm:text-base md:text-lg lg:text-xl line-clamp-3 md:line-clamp-2 mb-6 md:mb-10 leading-relaxed font-medium">
                            {{ $featuredNews->excerpt }}
                        </p>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6">
                            <a href="{{ route('news.detail', $featuredNews->slug) }}" class="w-full sm:w-auto text-center bg-white text-unmaris-blue px-8 md:px-10 py-3 md:py-4 rounded-full font-black text-xs md:text-sm uppercase tracking-widest hover:bg-unmaris-yellow transition-all shadow-xl">
                                Baca Artikel
                            </a>
                            <div class="flex items-center justify-center sm:justify-start text-white/60 text-[10px] md:text-xs gap-4 font-bold">
                                <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> {{ number_format($featuredNews->views) }} Tayangan</span>
                                <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg> {{ number_format($featuredNews->shares) }} Dibagikan</span>
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
                    <h2 class="text-xl md:text-2xl font-black text-gray-900 uppercase tracking-tighter">Berita Terbaru</h2>
                    <div class="h-1 flex-grow bg-gray-100 rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 md:gap-x-10 gap-y-10 md:gap-y-16 mb-12 md:mb-20">
                    @forelse($news as $item)
                        <article class="group flex flex-col h-full bg-white rounded-2xl md:rounded-[2.5rem] p-3 md:p-4 border border-gray-50 hover:border-gray-100 hover:shadow-xl transition-all duration-500">
                            <a href="{{ route('news.detail', $item->slug) }}" class="block relative aspect-[4/3] rounded-xl md:rounded-[2rem] overflow-hidden mb-5 md:mb-8 shadow-sm">
                                @if($item->featured_image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($item->featured_image) }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="{{ $item->title }}">
                                @else
                                    <div class="w-full h-full bg-gray-50 flex items-center justify-center">
                                        <svg class="w-12 h-12 md:w-16 md:h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4 md:top-6 md:left-6">
                                    <span class="bg-unmaris-blue/90 backdrop-blur-md text-white text-[8px] md:text-[9px] font-black px-3 md:px-4 py-1.5 rounded-full uppercase tracking-tighter">
                                        {{ $item->category->name }}
                                    </span>
                                </div>
                            </a>
                            
                            <div class="px-2 md:px-4 flex flex-col flex-grow">
                                <span class="text-[9px] md:text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-3 md:mb-4 flex items-center gap-2">
                                    <div class="w-1 h-1 bg-unmaris-yellow rounded-full"></div>
                                    {{ $item->published_at->format('d F Y') }}
                                </span>
                                
                                <h3 class="text-lg md:text-xl lg:text-2xl font-black text-gray-900 leading-snug md:leading-tight mb-3 md:mb-4 group-hover:text-unmaris-blue transition-colors duration-300">
                                    <a href="{{ route('news.detail', $item->slug) }}">
                                        {{ Str::limit($item->title, 60) }}
                                    </a>
                                </h3>
                                
                                <p class="text-gray-500 text-xs md:text-sm leading-relaxed mb-6 md:mb-8 line-clamp-3 font-medium">
                                    {{ $item->excerpt }}
                                </p>
                                
                                <div class="mt-auto pt-4 md:pt-6 border-t border-gray-50 flex justify-between items-center">
                                    <a href="{{ route('news.detail', $item->slug) }}" class="text-unmaris-blue font-black text-[10px] md:text-xs uppercase tracking-widest flex items-center gap-1.5 md:gap-2 group/link">
                                        Selengkapnya
                                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                    <div class="flex items-center gap-2 text-gray-400">
                                        <span class="text-[9px] md:text-[10px] font-bold flex items-center">{{ number_format($item->views) }} <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full text-center py-20 md:py-32 bg-gray-50 rounded-3xl md:rounded-[3rem] border-2 border-dashed border-gray-200 px-4">
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 md:mb-6 shadow-sm">
                                <svg class="w-6 h-6 md:w-8 md:h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 8H20"></path></svg>
                            </div>
                            <h3 class="text-lg md:text-xl font-black text-gray-900 mb-2">Belum Ada Publikasi</h3>
                            <p class="text-gray-500 text-sm md:text-base font-medium">Silakan sesuaikan kata kunci pencarian atau filter kategori Anda.</p>
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
                        <h2 class="text-xl md:text-2xl font-black text-gray-900 uppercase tracking-tighter">Terpopuler</h2>
                        <div class="h-1 flex-grow bg-unmaris-yellow rounded-full"></div>
                    </div>

                    <div class="space-y-6 md:space-y-10">
                        @foreach($trendingNews as $index => $trend)
                            <article class="flex gap-4 md:gap-6 group/trend items-start">
                                <div class="relative shrink-0 pt-1">
                                    <span class="text-3xl md:text-5xl font-black text-gray-200 group-hover/trend:text-unmaris-yellow transition-colors duration-300">
                                        {{ sprintf("%02d", $index + 1) }}
                                    </span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[8px] md:text-[9px] font-black text-unmaris-blue uppercase tracking-widest mb-1 md:mb-2">
                                        {{ $trend->category->name }}
                                    </span>
                                    <h4 class="text-base md:text-lg font-bold text-gray-900 leading-snug group-hover/trend:text-unmaris-blue transition-colors">
                                        <a href="{{ route('news.detail', $trend->slug) }}">
                                            {{ Str::limit($trend->title, 55) }}
                                        </a>
                                    </h4>
                                    <div class="flex items-center gap-2 md:gap-3 mt-2 md:mt-3 text-[9px] md:text-[10px] text-gray-400 font-bold">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            {{ number_format($trend->views) }}
                                        </span>
                                        <span>•</span>
                                        <span>{{ $trend->published_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Newsletter or Call to Action in Sidebar -->
                    <div class="mt-12 md:mt-16 bg-gray-900 rounded-3xl md:rounded-[2.5rem] p-6 md:p-8 text-white relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-unmaris-yellow/10 rounded-full blur-2xl"></div>
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

<style>
/* Utilities untuk menyembunyikan scrollbar pada Tab Kategori di perangkat mobile */
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
.hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>

</div>
