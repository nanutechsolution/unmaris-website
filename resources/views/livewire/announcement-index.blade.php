<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Header Section -->
    <section class="bg-unmaris-blue text-white py-16 mb-12 relative overflow-hidden">
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 border-b-4 border-unmaris-yellow inline-block pb-2">Pengumuman & Agenda</h1>
            <p class="text-lg text-gray-200 max-w-2xl mx-auto mt-4">Papan informasi resmi terkait agenda akademik, seminar, beasiswa, dan kegiatan kampus UNMARIS.</p>
        </div>
    </section>

    <div class="container mx-auto px-4 max-w-5xl">
        
        <!-- Tabs Navigasi Filter -->
        <div class="flex flex-wrap justify-center gap-2 md:gap-4 mb-10">
            <button wire:click="setTab('semua')" class="px-6 py-2.5 rounded-full font-bold transition {{ $activeTab === 'semua' ? 'bg-unmaris-yellow text-unmaris-blue shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100' }}">Semua Info</button>
            <button wire:click="setTab('pengumuman')" class="px-6 py-2.5 rounded-full font-bold transition {{ $activeTab === 'pengumuman' ? 'bg-unmaris-yellow text-unmaris-blue shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100' }}">Pengumuman</button>
            <button wire:click="setTab('agenda')" class="px-6 py-2.5 rounded-full font-bold transition {{ $activeTab === 'agenda' ? 'bg-unmaris-yellow text-unmaris-blue shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100' }}">Agenda Acara</button>
        </div>

        <!-- Loading Indicator saat pindah tab -->
        <div wire:loading wire:target="setTab" class="w-full text-center py-10">
            <div class="inline-block animate-spin rounded-full h-10 w-10 border-t-4 border-b-4 border-unmaris-blue"></div>
            <p class="mt-2 text-gray-500 font-medium">Memuat data...</p>
        </div>

        <!-- List Pengumuman -->
        <div wire:loading.remove wire:target="setTab" class="space-y-6">
            @forelse($announcements as $item)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 flex flex-col md:flex-row gap-6 hover:shadow-md transition">
                    
                    <!-- Kiri: Ikon/Tanggal Box -->
                    <div class="shrink-0 flex md:flex-col items-center justify-center gap-3 md:gap-0 w-full md:w-32 {{ $item->type === 'agenda' ? 'bg-unmaris-blue text-white' : 'bg-yellow-50 text-unmaris-yellow' }} rounded-xl p-4 text-center">
                        @if($item->type === 'agenda')
                            <span class="text-sm font-semibold uppercase">{{ $item->start_date->format('M') }}</span>
                            <span class="text-4xl font-extrabold">{{ $item->start_date->format('d') }}</span>
                            <span class="text-sm">{{ $item->start_date->format('Y') }}</span>
                        @else
                            <svg class="w-12 h-12 mb-2 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                            <span class="font-bold text-sm">PENGUMUMAN</span>
                        @endif
                    </div>

                    <!-- Kanan: Detail -->
                    <div class="flex-grow">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-xs font-bold {{ $item->type === 'agenda' ? 'text-unmaris-blue bg-blue-50' : 'text-yellow-700 bg-yellow-100' }} px-3 py-1 rounded-full uppercase tracking-wider">
                                {{ $item->type === 'agenda' ? 'Agenda' : 'Informasi' }}
                            </span>
                            @if($item->type === 'agenda' && $item->location)
                                <span class="text-xs text-gray-500 flex items-center"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>{{ $item->location }}</span>
                            @endif
                        </div>
                        
                        <h2 class="text-2xl font-bold text-gray-900 mb-3 leading-tight">{{ $item->title }}</h2>
                        <div class="prose prose-sm text-gray-600 mb-4 line-clamp-3">
                            {!! strip_tags($item->content) !!}
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <a href="{{ route('announcements.detail', $item->slug) }}" class="text-unmaris-blue font-bold hover:text-unmaris-yellow transition text-sm flex items-center">
                                Baca Selengkapnya <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            
                            @if($item->attachment)
                                <a href="{{ asset('storage/'.$item->attachment) }}" target="_blank" class="text-gray-500 hover:text-gray-900 font-medium text-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Unduh Lampiran
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <h3 class="text-xl font-bold text-gray-700">Belum ada data</h3>
                    <p class="text-gray-500 mt-2">Belum ada pengumuman atau agenda yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8 flex justify-center">
            {{ $announcements->links() }}
        </div>
    </div>
</div>
