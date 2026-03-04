<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Header Section -->
    <section class="bg-unmaris-blue text-white py-16 mb-12 relative overflow-hidden">
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 border-b-4 border-unmaris-yellow inline-block pb-2">Pusat Unduhan Akademik</h1>
            <p class="text-lg text-gray-200 max-w-2xl mx-auto mt-4">Akses dan unduh dokumen penting seperti Kalender Akademik, Jadwal Kuliah, dan Buku Pedoman Universitas Stella Maris Sumba.</p>
        </div>
    </section>

    <div class="container mx-auto px-4 max-w-6xl">

        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-10 flex flex-col md:flex-row justify-between items-center gap-4 sticky top-20 z-30">
            <!-- Tabs -->
            <div class="flex overflow-x-auto w-full md:w-auto pb-2 md:pb-0 hide-scrollbar gap-2">
                <button wire:click="setTab('semua')" class="whitespace-nowrap px-5 py-2 rounded-full font-bold text-sm transition {{ $activeTab === 'semua' ? 'bg-unmaris-blue text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Semua Dokumen</button>
                <button wire:click="setTab('kalender_akademik')" class="whitespace-nowrap px-5 py-2 rounded-full font-bold text-sm transition {{ $activeTab === 'kalender_akademik' ? 'bg-unmaris-blue text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Kalender Akademik</button>
                <button wire:click="setTab('jadwal_kuliah')" class="whitespace-nowrap px-5 py-2 rounded-full font-bold text-sm transition {{ $activeTab === 'jadwal_kuliah' ? 'bg-unmaris-blue text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Jadwal Kuliah</button>
                <button wire:click="setTab('buku_pedoman')" class="whitespace-nowrap px-5 py-2 rounded-full font-bold text-sm transition {{ $activeTab === 'buku_pedoman' ? 'bg-unmaris-blue text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Buku Pedoman</button>
            </div>

            <!-- Search -->
            <div class="w-full md:w-72 relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari dokumen..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-unmaris-yellow focus:border-transparent text-sm">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Loading State -->
        <div wire:loading wire:target="setTab, search" class="w-full text-center py-10">
            <div class="inline-block animate-spin rounded-full h-10 w-10 border-t-4 border-b-4 border-unmaris-blue"></div>
            <p class="mt-2 text-gray-500 font-medium">Memuat dokumen...</p>
        </div>

        <!-- Grid Dokumen -->
        <div wire:loading.remove wire:target="setTab, search" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($documents as $doc)
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition-shadow border border-gray-100 flex flex-col h-full border-t-4 {{ $doc->category === 'kalender_akademik' ? 'border-red-500' : ($doc->category === 'jadwal_kuliah' ? 'border-blue-500' : 'border-unmaris-yellow') }}">

                <div class="flex items-start gap-4 mb-4">
                    <!-- Icon berdasarkan tipe file (Asumsi PDF secara umum) -->
                    <div class="w-12 h-12 shrink-0 bg-red-50 text-red-500 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block mb-1">
                            {{ ucwords(str_replace('_', ' ', $doc->category)) }}
                        </span>
                        <h3 class="text-lg font-bold text-gray-900 leading-tight">{{ $doc->title }}</h3>
                    </div>
                </div>

                @if($doc->description)
                <p class="text-gray-600 text-sm mb-6 flex-grow">{{ Str::limit($doc->description, 80) }}</p>
                @else
                <div class="flex-grow mb-6"></div>
                @endif

                <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-xs text-gray-400 font-medium">Diperbarui: {{ $doc->updated_at->format('d M Y') }}</span>

                    <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" download class="inline-flex items-center text-sm font-bold text-white bg-unmaris-blue hover:bg-unmaris-yellow hover:text-unmaris-blue px-4 py-2 rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Unduh
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16 bg-white rounded-2xl border border-gray-100">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-xl font-bold text-gray-700">Tidak ada dokumen ditemukan</h3>
                <p class="text-gray-500 mt-2">Coba gunakan kata kunci pencarian lain atau pilih kategori yang berbeda.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-8 flex justify-center">
            {{ $documents->links() }}
        </div>
    </div>

    <style>
        /* CSS khusus untuk menyembunyikan scrollbar di menu Tab filter */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

</div>