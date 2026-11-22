<div class="bg-canvas pb-16 md:pb-24">
    <x-ui.page-hero title="Pusat Unduhan Akademik" eyebrow="Dokumen Resmi"
        description="Akses dan unduh dokumen penting Universitas Stella Maris Sumba, mulai dari kalender akademik, jadwal kuliah, buku pedoman, kurikulum, hingga dokumen akreditasi."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Pusat Unduhan'],
        ]" />

    <div class="container-page">

        <!-- Panel filter & pencarian -->
        <section aria-labelledby="filter-dokumen"
            class="relative z-30 -mt-8 rounded-3xl border border-line bg-surface p-4 shadow-[var(--shadow-lift)] md:-mt-10 md:p-5">
            <h2 id="filter-dokumen" class="sr-only">Filter dan pencarian dokumen</h2>

            <div class="flex flex-col gap-4">
                <div class="hide-scrollbar -mx-1 flex w-full min-w-0 snap-x items-center gap-2 overflow-x-auto px-1 pb-1">
                    @foreach ($categories as $key => $label)
                        <button type="button" wire:click="setTab('{{ $key }}')" wire:key="tab-{{ $key }}"
                            aria-pressed="{{ $activeTab === $key ? 'true' : 'false' }}"
                            class="focus-navy inline-flex min-h-11 shrink-0 snap-start items-center justify-center rounded-full px-4 text-[13px] font-bold transition {{ $activeTab === $key ? 'bg-unmaris-blue text-white shadow-[0_10px_20px_-12px_rgba(40,22,111,0.9)]' : 'border border-line-strong bg-surface text-body hover:border-unmaris-blue hover:text-brand-ink' }}">
                            {{ $label }}
                            @if ($key === $arsipTab)
                                <svg class="ml-1.5 h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            @endif
                        </button>
                    @endforeach
                </div>

                <div class="flex flex-col gap-2 border-t border-line pt-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-[11px] font-semibold text-muted">
                        Pilih kategori atau cari langsung judul dokumen.
                    </p>

                    <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">
                        <div class="relative min-w-0 flex-1 sm:w-72 lg:w-80">
                            <label for="pencarian-dokumen" class="sr-only">Cari dokumen</label>
                            <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-muted" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />
                            </svg>
                            <input id="pencarian-dokumen" wire:model.live.debounce.300ms="search" type="search"
                                placeholder="Cari judul, nomor SK, atau prodi…" autocomplete="off"
                                class="form-input min-h-11 rounded-full py-2.5 pl-11 pr-4">
                        </div>

                        <div class="shrink-0">
                            <label for="sort-dokumen" class="sr-only">Urutan dokumen</label>
                            <select id="sort-dokumen" wire:model.live="sort"
                                class="form-input min-h-11 w-full rounded-full py-2.5 pl-4 pr-9 text-[13px] font-bold sm:w-44">
                                <option value="terbaru">Terbaru</option>
                                <option value="nama_az">Nama A–Z</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if ($activeTab !== $arsipTab)
            <!-- Pintasan arsip STMIK -->
            <aside class="mt-6 rounded-2xl border border-unmaris-yellow/60 bg-unmaris-yellow/15 p-4 md:p-5" aria-label="Arsip akreditasi institusi lama">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-start gap-3">
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-unmaris-yellow text-[#1b0f52]">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-bold text-ink">Arsip SK Akreditasi Sekolah Tinggi</p>
                            <p class="mt-0.5 text-[13px] leading-relaxed text-body">
                                Mencari bukti akreditasi lama masa {{ $singkatanInstitusiLama }}? Dokumen era sekolah tinggi tersedia di tab arsip.
                            </p>
                        </div>
                    </div>
                    <button type="button" wire:click="setTab('{{ $arsipTab }}')"
                        class="focus-navy inline-flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-full border border-[#1b0f52]/25 bg-surface px-4 text-[12px] font-bold text-brand-ink transition hover:border-unmaris-blue hover:bg-unmaris-blue hover:text-white">
                        Lihat arsip STMIK
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </button>
                </div>
            </aside>
        @else
            <!-- Keterangan tab arsip -->
            <div class="mt-6 rounded-2xl border border-unmaris-yellow/60 bg-unmaris-yellow/15 p-4 text-sm leading-relaxed text-body md:p-5">
                <p class="font-bold text-ink">Arsip {{ $singkatanInstitusiLama }}</p>
                <p class="mt-1">
                    Dokumen di bawah diterbitkan saat institusi masih bernama {{ $namaInstitusiLama }} dan tidak lagi menjadi
                    akreditasi yang berlaku. Arsip ini tetap ditampilkan sebagai bukti bagi lulusan periode tersebut, misalnya
                    untuk pendaftaran CPNS, melanjutkan studi, atau verifikasi ijazah.
                </p>
            </div>
        @endif

        @if ($activeTab === 'akreditasi')
            <p class="mt-5 text-sm leading-relaxed text-body">
                Menampilkan dokumen akreditasi Universitas Stella Maris Sumba yang masih berlaku. Dokumen yang sudah
                kedaluwarsa tersedia di tab
                <button type="button" wire:click="setTab('{{ $arsipTab }}')"
                    class="focus-navy rounded font-bold text-brand-ink underline decoration-unmaris-yellow decoration-2 underline-offset-2 transition hover:text-unmaris-blue">
                    Arsip {{ $singkatanInstitusiLama }}
                </button>.
            </p>
        @endif

        <!-- Status pemuatan -->
        <div wire:loading wire:target="setTab, search, sort" class="flex flex-col items-center justify-center py-12" role="status" aria-live="polite">
            <span class="h-10 w-10 animate-spin rounded-full border-[3px] border-line border-t-unmaris-blue motion-reduce:animate-none" aria-hidden="true"></span>
            <p class="mt-3 text-sm font-semibold text-body">Memuat dokumen…</p>
        </div>

        <div wire:loading.remove wire:target="setTab, search, sort">
            <!-- Ringkasan hasil -->
            <div class="mt-8 flex flex-wrap items-center justify-between gap-3">
                <p class="text-[13px] font-medium text-body" role="status" aria-live="polite">
                    Menampilkan <span class="font-bold text-ink">{{ $documents->total() }}</span> dokumen
                    @if ($activeTab !== 'semua' && isset($categories[$activeTab]))
                        pada kategori <span class="font-bold text-ink">{{ $categories[$activeTab] }}</span>
                    @endif
                    @if ($search)
                        untuk pencarian <span class="font-bold text-ink">&ldquo;{{ $search }}&rdquo;</span>
                    @endif
                </p>

                @if ($search || $activeTab !== 'semua' || $sort !== 'terbaru')
                    <button type="button" wire:click="resetFilters"
                        class="btn-ghost btn-sm">
                        Atur ulang filter
                    </button>
                @endif
            </div>

            <!-- Daftar dokumen -->
            <div class="mt-5 grid grid-cols-1 gap-5 md:grid-cols-2 md:gap-6 lg:grid-cols-3">
                @forelse ($documents as $doc)
                    @php
                        $fileExt = strtoupper(pathinfo($doc->file_path ?? '', PATHINFO_EXTENSION)) ?: 'FILE';
                        $fileSizeBytes = $fileSizes[$doc->file_path] ?? null;
                        $fileSizeLabel = $fileSizeBytes
                            ? number_format(round($fileSizeBytes / 1048576, 1), 1) . ' MB'
                            : null;
                        $arsip = $doc->adalahArsip();
                        $namaInstitusiDokumen = $doc->institusi === \App\Models\Document::INSTITUSI_SEKOLAH_TINGGI
                            ? ($doc->nama_institusi_lama ?: $namaInstitusiLama)
                            : null;
                        $adaMetadataAkreditasi = $doc->category === 'akreditasi'
                            && (filled($doc->lembaga_akreditasi) || filled($doc->peringkat) || filled($doc->berlaku_sampai));
                    @endphp

                    <article wire:key="doc-{{ $doc->id }}"
                        class="group flex h-full flex-col overflow-hidden rounded-3xl border border-line bg-surface transition duration-300 hover:-translate-y-1 hover:border-line-strong hover:shadow-[var(--shadow-lift)] motion-reduce:transition-none">
                        <div class="flex items-start gap-3 border-b border-line p-5">
                            <span class="relative grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-unmaris-yellow text-[#1b0f52]">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <span class="absolute -bottom-1.5 -right-1.5 rounded-md bg-[#1b0f52] px-1.5 py-0.5 text-[8px] font-extrabold uppercase tracking-[0.04em] text-unmaris-yellow">
                                    {{ $fileExt }}
                                </span>
                            </span>

                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <span class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-brand-ink">
                                        {{ ucwords(str_replace('_', ' ', $doc->category)) }}
                                    </span>
                                    @if ($arsip)
                                        <span class="rounded-full border border-unmaris-yellow/60 bg-unmaris-yellow/20 px-2 py-0.5 text-[9px] font-extrabold uppercase tracking-[0.06em] text-brand-ink"
                                            title="{{ $namaInstitusiLama }}">
                                            Arsip STMIK
                                        </span>
                                    @endif
                                </div>
                                <h3 class="mt-1.5 break-words font-display text-lg font-bold leading-snug text-ink">
                                    {{ $doc->title }}
                                </h3>
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col p-5">
                            @if ($doc->description)
                                <p class="line-clamp-3 text-[13px] leading-relaxed text-body">
                                    {{ Str::limit($doc->description, 140) }}
                                </p>
                            @else
                                <p class="text-[13px] italic text-muted">Tanpa keterangan tambahan.</p>
                            @endif

                            @if ($adaMetadataAkreditasi)
                                <dl class="mt-4 space-y-1.5 rounded-2xl border border-line bg-surface-2/60 p-3.5 text-[12px] leading-relaxed">
                                    @if (filled($namaInstitusiDokumen))
                                        <div class="flex flex-wrap gap-x-1.5">
                                            <dt class="font-bold text-ink">Institusi saat terbit:</dt>
                                            <dd class="min-w-0 break-words text-body">{{ $namaInstitusiDokumen }}</dd>
                                        </div>
                                    @endif
                                    @if (filled($doc->lembaga_akreditasi))
                                        <div class="flex flex-wrap gap-x-1.5">
                                            <dt class="font-bold text-ink">Lembaga:</dt>
                                            <dd class="text-body">{{ $doc->lembaga_akreditasi }}</dd>
                                        </div>
                                    @endif
                                    @if (filled($doc->peringkat))
                                        <div class="flex flex-wrap gap-x-1.5">
                                            <dt class="font-bold text-ink">Peringkat:</dt>
                                            <dd class="text-body">{{ $doc->peringkat }}</dd>
                                        </div>
                                    @endif
                                    @if ($doc->studyProgram)
                                        <div class="flex flex-wrap gap-x-1.5">
                                            <dt class="font-bold text-ink">Program studi:</dt>
                                            <dd class="text-body">{{ $doc->studyProgram->name }}</dd>
                                        </div>
                                    @endif
                                    @if (filled($doc->nomor_sk))
                                        <div class="flex flex-wrap gap-x-1.5">
                                            <dt class="font-bold text-ink">Nomor SK:</dt>
                                            <dd class="break-words text-body">{{ $doc->nomor_sk }}</dd>
                                        </div>
                                    @endif
                                    @if ($doc->berlaku_mulai && $doc->berlaku_sampai)
                                        <div class="flex flex-wrap gap-x-1.5">
                                            <dt class="font-bold text-ink">Masa berlaku:</dt>
                                            <dd class="text-body">
                                                {{ $doc->berlaku_mulai->copy()->locale('id')->translatedFormat('d F Y') }}
                                                s.d.
                                                {{ $doc->berlaku_sampai->copy()->locale('id')->translatedFormat('d F Y') }}
                                            </dd>
                                        </div>
                                    @elseif ($doc->berlaku_sampai)
                                        <div class="flex flex-wrap gap-x-1.5">
                                            <dt class="font-bold text-ink">Masa berlaku:</dt>
                                            <dd class="text-body">
                                                Berlaku sampai {{ $doc->berlaku_sampai->copy()->locale('id')->translatedFormat('d F Y') }}
                                            </dd>
                                        </div>
                                    @endif
                                </dl>
                            @endif

                            <div class="mt-auto flex flex-wrap items-end justify-between gap-3 border-t border-line pt-4 {{ $doc->description || $adaMetadataAkreditasi ? 'mt-5' : '' }}">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-[11px] font-semibold text-muted">
                                        Diperbarui {{ $doc->updated_at->copy()->locale('id')->translatedFormat('d M Y') }}
                                    </span>
                                    @if ($fileSizeLabel)
                                        <span class="text-[11px] font-medium text-muted">{{ $fileExt }} · {{ $fileSizeLabel }}</span>
                                    @endif
                                </div>

                                @if ($fileSizeBytes)
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" rel="noopener" download
                                        aria-label="Unduh {{ $doc->title }}"
                                        class="focus-navy inline-flex min-h-11 items-center justify-center gap-2 rounded-full bg-unmaris-blue px-4 text-[12px] font-bold text-white transition hover:bg-unmaris-yellow hover:text-[#1b0f52]">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Unduh
                                    </a>
                                @else
                                    <span class="inline-flex min-h-11 items-center justify-center gap-2 rounded-full border border-dashed border-line-strong px-4 text-[11px] font-bold text-muted"
                                        title="Berkas dokumen belum tersedia di server">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19a2 2 0 01-1.73-3L10.27 4a2 2 0 013.46 0l6.93 12a2 2 0 01-1.73 3H5.07z" />
                                        </svg>
                                        Berkas belum tersedia
                                    </span>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full">
                        <x-ui.empty-state
                            :title="$activeTab === $arsipTab ? 'Belum ada arsip ' . $singkatanInstitusiLama : 'Tidak ada dokumen ditemukan'"
                            :description="$activeTab === $arsipTab
                                ? 'Arsip akan tampil di sini setelah dokumen akreditasi lama ditambahkan melalui panel admin.'
                                : 'Coba gunakan kata kunci pencarian lain atau pilih kategori yang berbeda.'">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </x-ui.empty-state>

                        <div class="mt-6 flex flex-wrap justify-center gap-3">
                            <button type="button" wire:click="resetFilters" class="btn-navy">Lihat semua dokumen</button>
                            @if ($search)
                                <button type="button" wire:click="$set('search', '')" class="btn-outline">Hapus pencarian</button>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($documents->hasPages())
                <div class="news-pagination mt-10 flex justify-center">
                    {{ $documents->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
