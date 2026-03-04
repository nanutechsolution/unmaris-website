<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Header Section (Elegan & Berwibawa) -->
    <section class="bg-unmaris-blue text-white py-16 md:py-24 relative overflow-hidden border-b-8 border-unmaris-yellow">
        <!-- Elemen Dekoratif Edukasi -->
        <div class="absolute inset-0 opacity-5">
            <svg class="h-full w-full md:w-1/2" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                <polygon points="0,100 100,0 100,100" />
            </svg>
        </div>
        <div class="absolute top-0 right-0 w-64 h-64 md:w-96 md:h-96 bg-unmaris-yellow rounded-full blur-[80px] md:blur-[120px] opacity-10 pointer-events-none z-0"></div>
        
        <div class="container mx-auto px-4 text-center relative z-10">
            <span class="inline-block py-1.5 px-4 rounded-full bg-white/10 border border-white/20 text-white text-[10px] md:text-xs font-bold tracking-widest uppercase mb-4 shadow-sm backdrop-blur-sm">Lembaga Penelitian & Pengabdian Masyarakat</span>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-black mb-4 leading-tight tracking-tighter">Direktori <span class="text-unmaris-yellow">Publikasi Ilmiah</span></h1>
            <p class="text-sm md:text-lg text-gray-300 max-w-3xl mx-auto mt-4 font-medium px-2 leading-relaxed">Kumpulan repositori jurnal, artikel riset, buku, dan laporan pengabdian masyarakat hasil karya sivitas akademika Universitas Stella Maris Sumba.</p>
        </div>
    </section>

    <div class="container mx-auto px-4 max-w-6xl -mt-8 relative z-20">
        
        <!-- Filter & Search Bar (Sticky) -->
        <div class="bg-white p-4 md:p-6 rounded-2xl md:rounded-[2rem] shadow-xl border border-gray-100 mb-10 flex flex-col lg:flex-row justify-between items-center gap-4 lg:gap-6 sticky top-20 z-30">
            <!-- Tabs Navigasi -->
            <div class="flex overflow-x-auto w-full lg:w-auto pb-2 lg:pb-0 hide-scrollbar gap-2 snap-x">
                <button wire:click="setTab('semua')" class="snap-start whitespace-nowrap px-6 py-2.5 rounded-full font-bold text-xs md:text-sm transition-all {{ $activeTab === 'semua' ? 'bg-unmaris-blue text-white shadow-md' : 'bg-gray-50 text-gray-500 hover:bg-gray-100' }}">Semua Karya</button>
                <button wire:click="setTab('jurnal')" class="snap-start whitespace-nowrap px-6 py-2.5 rounded-full font-bold text-xs md:text-sm transition-all {{ $activeTab === 'jurnal' ? 'bg-unmaris-blue text-white shadow-md' : 'bg-gray-50 text-gray-500 hover:bg-gray-100' }}">Jurnal Ilmiah</button>
                <button wire:click="setTab('pengabdian')" class="snap-start whitespace-nowrap px-6 py-2.5 rounded-full font-bold text-xs md:text-sm transition-all {{ $activeTab === 'pengabdian' ? 'bg-unmaris-blue text-white shadow-md' : 'bg-gray-50 text-gray-500 hover:bg-gray-100' }}">Pengabdian</button>
                <button wire:click="setTab('buku')" class="snap-start whitespace-nowrap px-6 py-2.5 rounded-full font-bold text-xs md:text-sm transition-all {{ $activeTab === 'buku' ? 'bg-unmaris-blue text-white shadow-md' : 'bg-gray-50 text-gray-500 hover:bg-gray-100' }}">Buku</button>
                <button wire:click="setTab('hki')" class="snap-start whitespace-nowrap px-6 py-2.5 rounded-full font-bold text-xs md:text-sm transition-all {{ $activeTab === 'hki' ? 'bg-unmaris-blue text-white shadow-md' : 'bg-gray-50 text-gray-500 hover:bg-gray-100' }}">HKI</button>
            </div>

            <!-- Kolom Pencarian -->
            <div class="w-full lg:w-80 shrink-0 relative">
                <input wire:model.live.debounce.500ms="search" type="text" placeholder="Cari judul atau nama penulis..." 
                    class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-unmaris-yellow focus:border-unmaris-yellow transition-all text-sm font-medium">
                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>

        <!-- Indikator Loading -->
        <div wire:loading wire:target="setTab, search" class="w-full text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-unmaris-blue"></div>
            <p class="mt-4 text-gray-500 font-bold tracking-widest uppercase text-xs">Menyinkronkan Basis Data...</p>
        </div>

        <!-- Daftar Publikasi (List Layout untuk kesan akademik) -->
        <div wire:loading.remove wire:target="setTab, search" class="space-y-6">
            @forelse($publications as $pub)
                <article class="bg-white rounded-2xl md:rounded-[2rem] p-6 md:p-8 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 flex flex-col md:flex-row gap-6 md:gap-8 group border-l-8 {{ $pub->type === 'jurnal' ? 'border-l-blue-500' : ($pub->type === 'pengabdian' ? 'border-l-green-500' : ($pub->type === 'buku' ? 'border-l-yellow-500' : 'border-l-red-500')) }}">
                    
                    <!-- Meta Info Kiri (Desktop) / Atas (Mobile) -->
                    <div class="shrink-0 md:w-48 border-b md:border-b-0 md:border-r border-gray-100 pb-4 md:pb-0 md:pr-8 flex flex-row md:flex-col justify-between md:justify-start items-center md:items-start gap-4">
                        <div class="flex flex-col items-start gap-2">
                            <span class="inline-flex items-center text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-lg bg-gray-50 text-gray-600 border border-gray-200">
                                @if($pub->type === 'jurnal') <svg class="w-3.5 h-3.5 mr-1.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg> @endif
                                @if($pub->type === 'pengabdian') <svg class="w-3.5 h-3.5 mr-1.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg> @endif
                                {{ strtoupper($pub->type) }}
                            </span>
                            @if($pub->publication_date)
                                <span class="text-xs font-bold text-gray-400 mt-1 md:mt-4 block">{{ $pub->publication_date->format('d M Y') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Konten Tengah -->
                    <div class="flex-grow">
                        <h2 class="text-xl md:text-2xl font-black text-gray-900 leading-snug mb-3 group-hover:text-unmaris-blue transition-colors">{{ $pub->title }}</h2>
                        
                        <div class="flex items-center text-unmaris-blue font-bold text-sm mb-4">
                            <svg class="w-4 h-4 mr-2 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ $pub->author }}
                        </div>

                        @if($pub->abstract)
                            <p class="text-gray-600 text-sm leading-relaxed mb-6 line-clamp-3 md:line-clamp-4">{{ $pub->abstract }}</p>
                        @endif

                        <!-- Tombol Aksi Bawah -->
                        <div class="flex flex-wrap gap-3">
                            @if($pub->link_url)
                                <a href="{{ $pub->link_url }}" target="_blank" class="inline-flex items-center px-5 py-2 rounded-lg bg-gray-50 hover:bg-unmaris-blue hover:text-white text-unmaris-blue font-bold text-xs uppercase tracking-widest border border-gray-200 transition-all">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    Kunjungi Tautan
                                </a>
                            @endif

                            @if($pub->file_path)
                                <a href="{{ asset('storage/'.$pub->file_path) }}" target="_blank" class="inline-flex items-center px-5 py-2 rounded-lg bg-unmaris-yellow text-unmaris-blue font-black text-xs uppercase tracking-widest shadow-sm hover:shadow-md hover:scale-105 transition-all">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Unduh Dokumen
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="text-center py-24 bg-white rounded-[2rem] border border-gray-100 shadow-sm">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-800 mb-2">Publikasi Tidak Ditemukan</h3>
                    <p class="text-gray-500 font-medium">Coba gunakan kata kunci pencarian lain atau pilih kategori yang berbeda.</p>
                </div>
            @endforelse
        </div>

        <!-- Navigasi Halaman -->
        <div class="mt-12 flex justify-center">
            {{ $publications->links() }}
        </div>
    </div>
</div>

<style>
.hide-scrollbar::-webkit-scrollbar { display: none; }
.hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>