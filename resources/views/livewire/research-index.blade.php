<div class="bg-canvas pb-16 md:pb-24">
    <x-ui.page-hero title="Direktori Publikasi Ilmiah" eyebrow="Lembaga Penelitian & Pengabdian Masyarakat"
        description="Kumpulan jurnal, artikel riset, buku, dan laporan pengabdian masyarakat hasil karya sivitas akademika Universitas Stella Maris Sumba."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'LPPM', 'url' => route('lppm.profil')],
            ['label' => 'Publikasi Ilmiah'],
        ]" />

    <div class="container-page">
        <!-- Panel filter -->
        <section aria-labelledby="filter-publikasi"
            class="relative z-30 -mt-8 rounded-3xl border border-line bg-surface p-4 shadow-[var(--shadow-lift)] md:-mt-10 md:p-5">
            <h2 id="filter-publikasi" class="sr-only">Filter dan pencarian publikasi</h2>

            <div class="flex flex-col gap-4">
                <div class="hide-scrollbar -mx-1 flex min-w-0 snap-x items-center gap-2 overflow-x-auto px-1 pb-1">
                    @foreach (['semua' => 'Semua Karya', 'jurnal' => 'Jurnal Ilmiah', 'pengabdian' => 'Pengabdian', 'buku' => 'Buku', 'hki' => 'HKI'] as $key => $label)
                        <button type="button" wire:click="setTab('{{ $key }}')" wire:key="tab-{{ $key }}"
                            aria-pressed="{{ $activeTab === $key ? 'true' : 'false' }}"
                            class="focus-navy inline-flex min-h-11 shrink-0 snap-start items-center justify-center rounded-full px-4 text-[13px] font-bold transition {{ $activeTab === $key ? 'bg-unmaris-blue text-white shadow-[0_10px_20px_-12px_rgba(40,22,111,0.9)]' : 'border border-line-strong bg-surface text-body hover:border-unmaris-blue hover:text-brand-ink' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                <div class="flex flex-col gap-2 border-t border-line pt-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-[11px] font-semibold text-muted">Cari berdasarkan judul atau nama penulis.</p>

                    <div class="relative w-full min-w-0 sm:w-80">
                        <label for="pencarian-publikasi" class="sr-only">Cari judul atau nama penulis</label>
                        <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-muted" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />
                        </svg>
                        <input id="pencarian-publikasi" wire:model.live.debounce.400ms="search" type="search"
                            placeholder="Cari judul atau penulis…" autocomplete="off"
                            class="form-input min-h-11 rounded-full py-2.5 pl-11 pr-4">
                    </div>
                </div>
            </div>
        </section>

        <!-- Status pemuatan -->
        <div wire:loading wire:target="setTab, search" class="flex flex-col items-center justify-center py-12" role="status" aria-live="polite">
            <span class="h-10 w-10 animate-spin rounded-full border-[3px] border-line border-t-unmaris-blue motion-reduce:animate-none" aria-hidden="true"></span>
            <p class="mt-3 text-sm font-semibold text-body">Memuat publikasi…</p>
        </div>

        <div wire:loading.remove wire:target="setTab, search">
            <div class="mt-8 flex flex-wrap items-center justify-between gap-3">
                <p class="text-[13px] font-medium text-body" role="status" aria-live="polite">
                    Menampilkan <span class="font-bold text-ink">{{ $publications->total() }}</span> publikasi
                    @if ($search)
                        untuk pencarian <span class="font-bold text-ink">&ldquo;{{ $search }}&rdquo;</span>
                    @endif
                </p>

                @if ($search || $activeTab !== 'semua')
                    <button type="button" wire:click="setTab('semua'); $set('search', '')" class="btn-ghost btn-sm">
                        Atur ulang filter
                    </button>
                @endif
            </div>

            <div class="mt-5 space-y-5">
                @forelse ($publications as $pub)
                    @php
                        $typeStyles = [
                            'jurnal' => ['label' => 'Jurnal', 'accent' => 'border-l-unmaris-blue', 'badge' => 'bg-unmaris-blue/10 text-brand-ink border-unmaris-blue/30'],
                            'pengabdian' => ['label' => 'Pengabdian', 'accent' => 'border-l-leaf', 'badge' => 'bg-leaf/10 text-leaf border-leaf/30'],
                            'buku' => ['label' => 'Buku', 'accent' => 'border-l-unmaris-yellow', 'badge' => 'bg-unmaris-yellow/20 text-brand-ink border-unmaris-yellow/60'],
                            'hki' => ['label' => 'HKI', 'accent' => 'border-l-ember', 'badge' => 'bg-ember/10 text-ember border-ember/30'],
                        ];
                        $style = $typeStyles[$pub->type] ?? ['label' => strtoupper($pub->type), 'accent' => 'border-l-line-strong', 'badge' => 'bg-surface-2 text-body border-line'];
                    @endphp

                    <article wire:key="pub-{{ $pub->id }}"
                        class="group flex flex-col gap-5 rounded-3xl border border-line border-l-4 bg-surface p-5 shadow-[var(--shadow-soft)] transition duration-300 hover:border-line-strong hover:shadow-[var(--shadow-lift)] motion-reduce:transition-none md:flex-row md:gap-7 md:p-7 {{ $style['accent'] }}">
                        <div class="shrink-0 md:w-40">
                            <span class="inline-flex items-center rounded-full border px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-[0.08em] {{ $style['badge'] }}">
                                {{ $style['label'] }}
                            </span>
                            @if ($pub->publication_date)
                                <p class="mt-2 text-[11px] font-semibold text-muted md:mt-3">
                                    {{ $pub->publication_date->copy()->locale('id')->translatedFormat('d F Y') }}
                                </p>
                            @endif
                        </div>

                        <div class="min-w-0 flex-grow">
                            <h2 class="font-display text-xl font-bold leading-snug text-ink transition group-hover:text-brand-ink md:text-2xl">
                                {{ $pub->title }}
                            </h2>

                            @if ($pub->author)
                                <p class="mt-2 flex items-start gap-1.5 text-[13px] font-bold text-brand-ink">
                                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-unmaris-yellow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ $pub->author }}
                                </p>
                            @endif

                            @if ($pub->abstract)
                                <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-body md:line-clamp-4">
                                    {{ $pub->abstract }}
                                </p>
                            @endif

                            <div class="mt-5 flex flex-wrap gap-2.5">
                                @if ($pub->link_url)
                                    <a href="{{ $pub->link_url }}" target="_blank" rel="noopener" class="btn-outline btn-sm">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        Kunjungi Tautan
                                    </a>
                                @endif

                                @if ($pub->file_path)
                                    <a href="{{ asset('storage/' . $pub->file_path) }}" target="_blank" rel="noopener" class="btn-primary btn-sm">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Unduh Dokumen
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <x-ui.empty-state
                        :title="$search || $activeTab !== 'semua' ? 'Publikasi tidak ditemukan' : 'Belum ada publikasi'"
                        :description="$search || $activeTab !== 'semua'
                            ? 'Coba gunakan kata kunci lain atau pilih kategori yang berbeda.'
                            : 'Publikasi sivitas akademika belum dipublikasikan. Silakan periksa kembali secara berkala.'">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </x-ui.empty-state>

                    @if ($search || $activeTab !== 'semua')
                        <div class="mt-6 flex justify-center">
                            <button type="button" wire:click="setTab('semua'); $set('search', '')" class="btn-navy">Lihat semua publikasi</button>
                        </div>
                    @endif
                @endforelse
            </div>

            @if ($publications->hasPages())
                <div class="news-pagination mt-10 flex justify-center">
                    {{ $publications->links() }}
                </div>
            @endif
        </div>

        <aside class="mt-12 grid gap-4 sm:grid-cols-2" aria-label="Informasi LPPM">
            <div class="rounded-2xl border border-line bg-surface p-5">
                <span class="eyebrow">Tentang LPPM</span>
                <h2 class="mt-2 text-base font-bold text-ink">Lembaga Penelitian dan Pengabdian kepada Masyarakat</h2>
                <p class="mt-2 text-[13px] leading-relaxed text-body">
                    LPPM mengoordinasikan kegiatan penelitian dan pengabdian dosen serta mahasiswa UNMARIS.
                </p>
                <a href="{{ route('lppm.profil') }}" class="link-arrow mt-4 inline-flex text-[12px] font-bold text-brand-ink">
                    Profil LPPM
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
            <div class="rounded-2xl border border-line bg-surface p-5">
                <span class="eyebrow">Kolaborasi</span>
                <h2 class="mt-2 text-base font-bold text-ink">Ingin berkolaborasi atau mengusulkan publikasi?</h2>
                <p class="mt-2 text-[13px] leading-relaxed text-body">
                    Hubungi LPPM melalui kanal resmi UNMARIS untuk informasi kerja sama penelitian dan pengabdian.
                </p>
                <a href="{{ route('contact') }}" class="link-arrow mt-4 inline-flex text-[12px] font-bold text-brand-ink">
                    Hubungi Kami
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </aside>
    </div>
</div>
