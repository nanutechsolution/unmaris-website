<div x-on:document:student-statistics-drill="$wire.drillDown($event.detail.code, $event.detail.name)">
    <x-ui.page-hero title="GIS Statistik Mahasiswa" eyebrow="Promosi Kampus Berbasis Data"
        description="Jelajahi persebaran mahasiswa Universitas Stella Maris Sumba berdasarkan wilayah. Data disajikan secara agregat dan tidak memuat nama, NIM, NIK, maupun data pribadi lainnya."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Kemahasiswaan', 'url' => route('scholarships.index')],
            ['label' => 'Statistik Mahasiswa'],
        ]" />

    <section class="section-y bg-canvas">
        <div class="container-page space-y-6">
            <!-- Kontrol wilayah -->
            <section aria-labelledby="kontrol-wilayah"
                class="rounded-3xl border border-line bg-surface p-5 shadow-[var(--shadow-soft)] md:p-6">
                <h2 id="kontrol-wilayah" class="sr-only">Kontrol wilayah dan status mahasiswa</h2>

                <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                    <div class="min-w-0">
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Wilayah ditampilkan</p>
                        <nav class="mt-2 flex flex-wrap items-center gap-2 text-sm font-bold" aria-label="Navigasi wilayah">
                            <button type="button" wire:click="resetToRoot"
                                class="focus-navy rounded text-brand-ink underline decoration-unmaris-yellow decoration-2 underline-offset-2 transition hover:text-unmaris-blue">
                                Indonesia
                            </button>
                            @foreach ($crumbs as $crumb)
                                <span class="text-line-strong" aria-hidden="true">/</span>
                                <span class="max-w-40 truncate text-body">{{ $crumb['name'] }}</span>
                            @endforeach
                            <span class="text-line-strong" aria-hidden="true">/</span>
                            <span class="rounded-full bg-unmaris-yellow/20 px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-[0.08em] text-brand-ink">
                                {{ $current['level'] }}
                            </span>
                        </nav>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        @if ($canGoBack)
                            <button type="button" wire:click="back"
                                class="focus-navy inline-flex min-h-11 items-center gap-2 rounded-full bg-unmaris-blue px-4 text-[12px] font-bold text-white transition hover:bg-navy-soft">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Kembali
                            </button>
                        @endif

                        <div class="flex items-center gap-1 rounded-full border border-line bg-surface-2 p-1" role="group" aria-label="Filter status mahasiswa">
                            <button type="button" wire:click="setStatus('aktif')"
                                class="focus-navy min-h-9 rounded-full px-4 text-[11px] font-extrabold uppercase tracking-[0.06em] transition {{ $status === 'aktif' ? 'bg-unmaris-blue text-white' : 'text-body hover:text-brand-ink' }}"
                                aria-pressed="{{ $status === 'aktif' ? 'true' : 'false' }}">Aktif</button>
                            <button type="button" wire:click="setStatus('semua')"
                                class="focus-navy min-h-9 rounded-full px-4 text-[11px] font-extrabold uppercase tracking-[0.06em] transition {{ $status === 'semua' ? 'bg-unmaris-yellow text-[#1b0f52]' : 'text-body hover:text-brand-ink' }}"
                                aria-pressed="{{ $status === 'semua' ? 'true' : 'false' }}">Semua</button>
                        </div>
                    </div>
                </div>
            </section>

            @if ($error)
                <div class="rounded-3xl border border-ember/30 bg-surface p-8 text-center shadow-[var(--shadow-soft)] md:p-12" role="alert">
                    <span class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-ember/10 text-ember">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.74-3L13.74 4a2 2 0 00-3.48 0L3.34 16a2 2 0 001.73 3z" />
                        </svg>
                    </span>
                    <h2 class="mt-4 heading-3">Statistik tidak dapat dimuat</h2>
                    <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-body">{{ $error }}</p>
                    <button type="button" wire:click="retry" class="btn-primary mt-6">Coba lagi</button>
                </div>
            @elseif ($loading)
                <div class="rounded-3xl border border-line bg-surface p-12 text-center shadow-[var(--shadow-soft)] md:p-20" aria-live="polite" aria-busy="true">
                    <span class="mx-auto block h-12 w-12 animate-spin rounded-full border-4 border-line border-t-unmaris-blue motion-reduce:animate-none" aria-hidden="true"></span>
                    <p class="mt-4 text-sm font-bold text-ink">Memuat statistik wilayah…</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                    <!-- Peta -->
                    <div class="overflow-hidden rounded-3xl border border-line bg-surface shadow-[var(--shadow-soft)] xl:col-span-2">
                        <div class="flex flex-col gap-3 border-b border-line p-5 sm:flex-row sm:items-center sm:justify-between md:p-6">
                            <div>
                                <h2 class="heading-3">Peta Persebaran</h2>
                                <p class="mt-1 text-[12px] text-muted">{{ $current['name'] }} · {{ ucfirst($current['level']) }}</p>
                            </div>
                            <div class="flex flex-wrap items-center gap-2" role="group" aria-label="Mode peta">
                                <button type="button" data-gis-reset class="gis-mode-button">Reset Tampilan</button>
                                <button type="button" data-gis-mode="marker" class="gis-mode-button is-active">● Marker</button>
                                <button type="button" data-gis-mode="heat" class="gis-mode-button" disabled title="Segera hadir">🔥 Heatmap</button>
                                <button type="button" data-gis-mode="region" class="gis-mode-button">🗺️ Wilayah</button>
                            </div>
                        </div>

                        <div wire:ignore class="relative p-3 md:p-6">
                            <div id="student-statistics-map"
                                data-stats="{{ json_encode([
                                    'rows' => $rows,
                                    'level' => $current['level'],
                                    'parent' => $current['code'],
                                    'parentName' => $current['name'],
                                    'breadcrumbs' => $stack,
                                    'nextLevel' => $nextLevel,
                                    'mode' => 'marker',
                                    'status' => $status,
                                    'bands' => $markerBands,
                                ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG) }}"
                                class="relative z-0 h-[360px] overflow-hidden rounded-2xl border border-line md:h-[520px]"></div>

                            <div id="student-statistics-no-data" aria-hidden="true" style="display:none"
                                class="pointer-events-none absolute inset-0 z-[999] m-3 flex flex-col items-center justify-center gap-3 rounded-2xl bg-surface/85 backdrop-blur-[1px] md:m-6">
                                <div class="rounded-2xl border border-line bg-surface px-7 py-6 text-center shadow-[var(--shadow-soft)]">
                                    <p class="font-display text-base font-bold text-ink">Tidak ada data pada filter ini</p>
                                    <p class="mt-1 text-[12px] text-muted">Coba ganti status filter atau wilayah untuk melihat persebaran mahasiswa.</p>
                                </div>
                            </div>

                            <div id="student-statistics-loading" style="display:none"
                                class="pointer-events-none absolute inset-0 z-[1000] m-3 flex items-center justify-center rounded-2xl bg-surface/70 backdrop-blur-[2px] md:m-6">
                                <div class="flex items-center gap-3 rounded-full border border-line bg-surface px-5 py-3 text-[11px] font-bold text-brand-ink shadow-[var(--shadow-soft)]">
                                    <span class="h-4 w-4 animate-spin rounded-full border-2 border-line border-t-unmaris-blue motion-reduce:animate-none"></span>
                                    Memuat peta…
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 border-t border-line px-5 py-4 sm:flex-row sm:items-center sm:justify-between md:px-6">
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-[11px] text-muted">
                                <span class="font-bold uppercase tracking-[0.08em]">Jumlah mahasiswa · klik marker untuk detail</span>
                                <div id="student-statistics-legend" class="flex flex-wrap items-center gap-x-3 gap-y-2" aria-label="Legenda jumlah mahasiswa"></div>
                            </div>
                            <span class="text-[10px] text-muted">Sumber batas wilayah: GeoJSON administratif</span>
                        </div>
                    </div>

                    <!-- Top wilayah -->
                    <div class="rounded-3xl border border-line bg-surface p-5 shadow-[var(--shadow-soft)] md:p-6">
                        <span class="eyebrow">Peringkat Wilayah</span>
                        <h2 class="mt-2 heading-3">Top Wilayah</h2>
                        <p class="mt-1 text-[12px] text-muted">Diurutkan dari jumlah mahasiswa terbanyak.</p>

                        <ol class="mt-5 space-y-2" aria-label="Daftar wilayah dengan jumlah mahasiswa terbanyak">
                            @forelse ($topRows as $index => $row)
                                <li class="flex items-center gap-3 rounded-xl border border-transparent p-2.5 transition hover:border-line hover:bg-surface-2">
                                    <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-unmaris-blue text-[11px] font-extrabold text-white">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-[13px] font-bold text-ink" title="{{ $row['name'] }}">{{ $row['name'] }}</p>
                                        <p class="text-[11px] text-muted">{{ number_format($row['jumlah_mahasiswa'], 0, ',', '.') }} mahasiswa</p>
                                    </div>
                                    @if ($nextLevel)
                                        <button type="button" wire:click="drillDown('{{ $row['code'] }}')"
                                            class="focus-navy min-h-9 shrink-0 rounded-full px-2.5 text-[11px] font-bold text-brand-ink transition hover:bg-unmaris-yellow/20"
                                            aria-label="Lihat wilayah {{ $row['name'] }}">Lihat</button>
                                    @endif
                                </li>
                            @empty
                                <li class="rounded-2xl border border-dashed border-line-strong bg-surface-2/60 px-4 py-8 text-center text-[13px] text-muted">
                                    Belum ada data untuk wilayah ini.
                                </li>
                            @endforelse
                        </ol>

                        @if (count($rows) > count($topRows))
                            <p class="mt-4 text-[11px] text-muted">
                                Menampilkan {{ count($topRows) }} teratas dari {{ number_format(count($rows)) }} wilayah.
                            </p>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col gap-2 rounded-2xl border border-line bg-surface px-5 py-4 text-[11px] text-muted sm:flex-row sm:items-center sm:justify-between">
                    <p>Total wilayah ditampilkan: <strong class="text-brand-ink">{{ number_format(count($rows)) }}</strong></p>
                    <p>{{ $meta['generated_at'] ?? 'Diperbarui secara berkala' }} · Data agregat dari SIAKAD</p>
                </div>
            @endif
        </div>
    </section>

    @push('scripts')
        <script>
            window.studentStatisticsInitial = @js([
                'rows' => $rows,
                'level' => $current['level'],
                'parent' => $current['code'],
                'nextLevel' => $nextLevel,
                'status' => $status,
            ]);
        </script>
    @endpush
</div>
