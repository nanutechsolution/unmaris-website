<div class="min-h-screen bg-slate-50 pb-20">
    <x-ui.page-hero title="Direktori Publikasi Ilmiah" eyebrow="Lembaga Penelitian & Pengabdian Masyarakat"
        description="Kumpulan repositori jurnal, artikel riset, buku, dan laporan pengabdian masyarakat hasil karya sivitas akademika Universitas Stella Maris Sumba."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Publikasi Ilmiah'],
        ]" />

    <div class="container-page py-10 md:py-14">
        
        <!-- Filter & Search Bar (Sticky) -->
        <div class="sticky top-20 z-30 mb-10 flex flex-col items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm md:p-5 lg:flex-row lg:gap-6">
            <!-- Tabs Navigasi -->
            <div class="hide-scrollbar flex w-full snap-x gap-2 overflow-x-auto pb-1 lg:w-auto lg:pb-0">
                <button wire:click="setTab('semua')" class="shrink-0 snap-start whitespace-nowrap rounded-full px-5 py-2 text-xs font-bold transition md:text-sm {{ $activeTab === 'semua' ? 'bg-unmaris-blue text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Semua Karya</button>
                <button wire:click="setTab('jurnal')" class="shrink-0 snap-start whitespace-nowrap rounded-full px-5 py-2 text-xs font-bold transition md:text-sm {{ $activeTab === 'jurnal' ? 'bg-unmaris-blue text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Jurnal Ilmiah</button>
                <button wire:click="setTab('pengabdian')" class="shrink-0 snap-start whitespace-nowrap rounded-full px-5 py-2 text-xs font-bold transition md:text-sm {{ $activeTab === 'pengabdian' ? 'bg-unmaris-blue text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Pengabdian</button>
                <button wire:click="setTab('buku')" class="shrink-0 snap-start whitespace-nowrap rounded-full px-5 py-2 text-xs font-bold transition md:text-sm {{ $activeTab === 'buku' ? 'bg-unmaris-blue text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Buku</button>
                <button wire:click="setTab('hki')" class="shrink-0 snap-start whitespace-nowrap rounded-full px-5 py-2 text-xs font-bold transition md:text-sm {{ $activeTab === 'hki' ? 'bg-unmaris-blue text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">HKI</button>
            </div>

            <!-- Kolom Pencarian -->
            <div class="relative w-full shrink-0 lg:w-72">
                <label for="pencarian-publikasi" class="sr-only">Cari judul atau nama penulis</label>
                <input id="pencarian-publikasi" wire:model.live.debounce.500ms="search" type="search" placeholder="Cari judul atau nama penulis..."
                    class="w-full rounded-full border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm font-medium outline-none transition focus:border-unmaris-yellow focus:ring-2 focus:ring-unmaris-yellow">
                <svg class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <!-- Indikator Loading -->
        <div wire:loading wire:target="setTab, search" class="w-full py-12 text-center" role="status" aria-live="polite">
            <div class="inline-block h-12 w-12 animate-spin rounded-full border-b-4 border-t-4 border-unmaris-blue"></div>
            <p class="mt-4 text-xs font-bold uppercase tracking-widest text-slate-500">Menyinkronkan Basis Data...</p>
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
                <x-ui.empty-state title="Publikasi Tidak Ditemukan"
                    description="Coba gunakan kata kunci pencarian lain atau pilih kategori yang berbeda.">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </x-ui.empty-state>
            @endforelse
        </div>

        <!-- Navigasi Halaman -->
        <div class="mt-12 flex justify-center">
            {{ $publications->links() }}
        </div>
    </div>
</div>