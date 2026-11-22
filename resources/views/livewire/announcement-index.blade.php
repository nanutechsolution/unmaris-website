<div class="bg-canvas pb-16 md:pb-24">
    <x-ui.page-hero title="Pengumuman & Agenda" eyebrow="Papan Informasi Resmi"
        description="Papan informasi resmi terkait agenda akademik, seminar, beasiswa, dan kegiatan kampus UNMARIS."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Pengumuman & Agenda'],
        ]" />

    <div class="container-page">
        <!-- Panel filter -->
        <section aria-labelledby="filter-pengumuman"
            class="relative z-30 -mt-8 rounded-3xl border border-line bg-surface p-4 shadow-[var(--shadow-lift)] md:-mt-10 md:p-5">
            <h2 id="filter-pengumuman" class="sr-only">Filter pengumuman dan agenda</h2>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="hide-scrollbar -mx-1 flex min-w-0 items-center gap-2 overflow-x-auto px-1 pb-1">
                    @foreach (['semua' => 'Semua Info', 'pengumuman' => 'Pengumuman', 'agenda' => 'Agenda Acara'] as $key => $label)
                        <button type="button" wire:click="setTab('{{ $key }}')" wire:key="tab-{{ $key }}"
                            aria-pressed="{{ $activeTab === $key ? 'true' : 'false' }}"
                            class="focus-navy inline-flex min-h-11 shrink-0 items-center justify-center rounded-full px-4 text-[13px] font-bold transition {{ $activeTab === $key ? 'bg-unmaris-blue text-white shadow-[0_10px_20px_-12px_rgba(40,22,111,0.9)]' : 'border border-line-strong bg-surface text-body hover:border-unmaris-blue hover:text-brand-ink' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                <p class="text-[11px] font-semibold text-muted">
                    Informasi resmi dari Universitas Stella Maris Sumba.
                </p>
            </div>
        </section>

        <!-- Status pemuatan -->
        <div wire:loading wire:target="setTab" class="flex flex-col items-center justify-center py-12" role="status" aria-live="polite">
            <span class="h-10 w-10 animate-spin rounded-full border-[3px] border-line border-t-unmaris-blue motion-reduce:animate-none" aria-hidden="true"></span>
            <p class="mt-3 text-sm font-semibold text-body">Memuat informasi…</p>
        </div>

        <div wire:loading.remove wire:target="setTab">
            <div class="mt-8 flex flex-wrap items-center justify-between gap-3">
                <p class="text-[13px] font-medium text-body" role="status" aria-live="polite">
                    Menampilkan <span class="font-bold text-ink">{{ $announcements->total() }}</span> informasi
                    @if ($activeTab !== 'semua')
                        pada kategori <span class="font-bold text-ink">{{ $activeTab === 'agenda' ? 'Agenda Acara' : 'Pengumuman' }}</span>
                    @endif
                </p>
            </div>

            <div class="mt-5 space-y-5">
                @forelse ($announcements as $item)
                    @php
                        $isAgenda = $item->type === 'agenda';
                    @endphp
                    <article wire:key="announcement-{{ $item->id }}"
                        class="group flex flex-col gap-5 rounded-3xl border border-line bg-surface p-5 shadow-[var(--shadow-soft)] transition duration-300 hover:border-line-strong hover:shadow-[var(--shadow-lift)] motion-reduce:transition-none md:flex-row md:p-7">
                        <!-- Kotak tanggal / ikon -->
                        <div class="flex w-full shrink-0 items-center justify-center gap-3 rounded-2xl p-4 text-center md:w-32 md:flex-col md:gap-0 {{ $isAgenda ? 'bg-navy-deep text-white' : 'bg-unmaris-yellow text-[#1b0f52]' }}">
                            @if ($isAgenda)
                                <span class="text-[11px] font-extrabold uppercase tracking-[0.12em]">{{ $item->start_date->copy()->locale('id')->translatedFormat('M') }}</span>
                                <span class="font-display text-4xl font-bold leading-none">{{ $item->start_date->format('d') }}</span>
                                <span class="text-[11px] font-semibold">{{ $item->start_date->format('Y') }}</span>
                            @else
                                <svg class="hidden h-9 w-9 md:block" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                </svg>
                                <span class="text-[11px] font-extrabold uppercase tracking-[0.1em]">Pengumuman</span>
                                <span class="text-[11px] font-semibold opacity-70">{{ $item->start_date->copy()->locale('id')->translatedFormat('d M Y') }}</span>
                            @endif
                        </div>

                        <!-- Detail -->
                        <div class="min-w-0 flex-1">
                            <div class="mb-2 flex flex-wrap items-center gap-2.5">
                                <span class="rounded-full border px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-[0.08em] {{ $isAgenda ? 'border-unmaris-blue/30 bg-unmaris-blue/10 text-brand-ink' : 'border-unmaris-yellow/60 bg-unmaris-yellow/20 text-brand-ink' }}">
                                    {{ $isAgenda ? 'Agenda' : 'Informasi' }}
                                </span>
                                @if ($isAgenda && $item->location)
                                    <span class="inline-flex items-center gap-1 text-[11px] font-medium text-muted">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $item->location }}
                                    </span>
                                @endif
                            </div>

                            <h2 class="font-display text-xl font-bold leading-tight text-ink transition group-hover:text-brand-ink md:text-2xl">
                                <a href="{{ route('announcements.detail', $item->slug) }}" class="focus-navy">
                                    {{ $item->title }}
                                </a>
                            </h2>

                            <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-body">
                                {{ Str::limit(Str::squish(strip_tags(preg_replace('/<\/(p|h[1-6]|li|div|blockquote)>|<br\s*\/?>/i', ' ', $item->content))), 220) }}
                            </p>

                            <div class="mt-4 flex flex-wrap items-center gap-4">
                                <a href="{{ route('announcements.detail', $item->slug) }}"
                                    class="focus-navy inline-flex min-h-11 items-center gap-1.5 text-[13px] font-bold text-brand-ink transition hover:text-unmaris-blue">
                                    Baca selengkapnya
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>

                                @if ($item->attachment)
                                    <a href="{{ asset('storage/' . $item->attachment) }}" target="_blank" rel="noopener"
                                        class="focus-navy inline-flex min-h-11 items-center gap-1.5 text-[12px] font-semibold text-muted transition hover:text-brand-ink">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Unduh lampiran
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <x-ui.empty-state
                        :title="$activeTab === 'semua' ? 'Belum ada pengumuman atau agenda' : 'Tidak ada informasi pada kategori ini'"
                        :description="$activeTab === 'semua'
                            ? 'Belum ada pengumuman atau agenda yang dipublikasikan. Silakan periksa kembali secara berkala.'
                            : 'Coba pilih kategori lain untuk melihat informasi yang tersedia.'">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </x-ui.empty-state>

                    @if ($activeTab !== 'semua')
                        <div class="mt-6 flex justify-center">
                            <button type="button" wire:click="setTab('semua')" class="btn-navy">Lihat semua informasi</button>
                        </div>
                    @endif
                @endforelse
            </div>

            @if ($announcements->hasPages())
                <div class="news-pagination mt-10 flex justify-center">
                    {{ $announcements->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
