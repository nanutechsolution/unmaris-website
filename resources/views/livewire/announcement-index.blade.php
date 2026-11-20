<div class="min-h-screen bg-slate-50 pb-20">
    <x-ui.page-hero title="Pengumuman & Agenda" eyebrow="Papan Informasi Resmi"
        description="Papan informasi resmi terkait agenda akademik, seminar, beasiswa, dan kegiatan kampus UNMARIS."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Pengumuman & Agenda'],
        ]" />

    <div class="container-page max-w-5xl py-10 md:py-14">
        
        <!-- Tabs Navigasi Filter -->
        <div class="mb-10 flex flex-wrap justify-center gap-2 md:gap-3">
            <button wire:click="setTab('semua')" class="rounded-full px-6 py-2.5 text-sm font-bold transition {{ $activeTab === 'semua' ? 'bg-unmaris-blue text-white shadow-md' : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-100' }}">Semua Info</button>
            <button wire:click="setTab('pengumuman')" class="rounded-full px-6 py-2.5 text-sm font-bold transition {{ $activeTab === 'pengumuman' ? 'bg-unmaris-blue text-white shadow-md' : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-100' }}">Pengumuman</button>
            <button wire:click="setTab('agenda')" class="rounded-full px-6 py-2.5 text-sm font-bold transition {{ $activeTab === 'agenda' ? 'bg-unmaris-blue text-white shadow-md' : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-100' }}">Agenda Acara</button>
        </div>

        <!-- Loading Indicator saat pindah tab -->
        <div wire:loading wire:target="setTab" class="w-full py-10 text-center" role="status" aria-live="polite">
            <div class="inline-block h-10 w-10 animate-spin rounded-full border-b-4 border-t-4 border-unmaris-blue"></div>
            <p class="mt-2 font-medium text-slate-500">Memuat data...</p>
        </div>

        <!-- List Pengumuman -->
        <div wire:loading.remove wire:target="setTab" class="space-y-5">
            @forelse($announcements as $item)
                <article class="card flex flex-col gap-5 p-5 transition hover:shadow-md md:flex-row md:p-7">
                    
                    <!-- Kiri: Ikon/Tanggal Box -->
                    <div class="flex w-full shrink-0 items-center justify-center gap-3 rounded-xl p-4 text-center md:w-32 md:flex-col md:gap-0 {{ $item->type === 'agenda' ? 'bg-unmaris-blue text-white' : 'bg-yellow-50 text-yellow-700' }}">
                        @if($item->type === 'agenda')
                            <span class="text-sm font-semibold uppercase">{{ $item->start_date->format('M') }}</span>
                            <span class="font-display text-4xl font-extrabold">{{ $item->start_date->format('d') }}</span>
                            <span class="text-sm">{{ $item->start_date->format('Y') }}</span>
                        @else
                            <svg class="mb-2 hidden h-10 w-10 md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>
                            <span class="text-xs font-bold uppercase tracking-wider">Pengumuman</span>
                        @endif
                    </div>

                    <!-- Kanan: Detail -->
                    <div class="flex-1">
                        <div class="mb-2 flex flex-wrap items-center gap-3">
                            <span class="rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-wider {{ $item->type === 'agenda' ? 'bg-blue-50 text-unmaris-blue' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $item->type === 'agenda' ? 'Agenda' : 'Informasi' }}
                            </span>
                            @if($item->type === 'agenda' && $item->location)
                                <span class="flex items-center text-xs text-slate-500">
                                    <svg class="mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    {{ $item->location }}
                                </span>
                            @endif
                        </div>
                        
                        <h2 class="mb-3 font-display text-xl font-bold leading-tight text-slate-900 md:text-2xl">
                            <a href="{{ route('announcements.detail', $item->slug) }}" class="transition hover:text-unmaris-blue">{{ $item->title }}</a>
                        </h2>
                        <p class="mb-4 line-clamp-3 text-sm leading-relaxed text-slate-600">{{ strip_tags($item->content) }}</p>
                        
                        <div class="flex flex-wrap items-center gap-4">
                            <a href="{{ route('announcements.detail', $item->slug) }}" class="flex items-center text-sm font-bold text-unmaris-blue transition hover:text-unmaris-blue/70">
                                Baca Selengkapnya
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                            
                            @if($item->attachment)
                                <a href="{{ asset('storage/'.$item->attachment) }}" target="_blank" rel="noopener" class="flex items-center text-sm font-medium text-slate-500 transition hover:text-slate-900">
                                    <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Unduh Lampiran
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <x-ui.empty-state title="Belum Ada Data"
                    description="Belum ada pengumuman atau agenda yang dipublikasikan.">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </x-ui.empty-state>
            @endforelse
        </div>

        <div class="mt-8 flex justify-center">
            {{ $announcements->links() }}
        </div>
    </div>
</div>
