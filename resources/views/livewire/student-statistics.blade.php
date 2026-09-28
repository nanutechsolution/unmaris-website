<div x-on:document:student-statistics-drill="$wire.drillDown($event.detail.code, $event.detail.name)">
    <!-- Header -->
    <section class="bg-unmaris-blue text-white py-14 md:py-20 relative overflow-hidden border-b-8 border-unmaris-yellow">
        <div class="absolute inset-0 opacity-10">
            <svg class="absolute right-0 top-0 h-full w-1/2" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                <polygon points="0,100 100,0 100,100" />
            </svg>
        </div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <span class="inline-block py-1.5 px-4 rounded-full bg-white/10 border border-white/20 text-[10px] md:text-xs font-bold tracking-widest uppercase backdrop-blur-sm">Promosi Kampus Berbasis Data</span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black mb-4 tracking-tighter mt-4">GIS <span class="text-unmaris-yellow">Statistik Mahasiswa</span></h1>
            <p class="text-sm md:text-lg text-gray-200 max-w-3xl mx-auto font-medium">Jelajahi persebaran mahasiswa Universitas Stella Maris Sumba berdasarkan wilayah. Data disajikan secara agregat dan tidak memuat nama, NIM, NIK, maupun data pribadi lainnya.</p>
        </div>
    </section>

    <!-- Konten -->
    <section class="py-10 md:py-16 bg-gray-50 min-h-screen relative -mt-8 z-20 rounded-t-3xl md:rounded-t-[3rem]">
        <div class="container mx-auto px-4 max-w-7xl space-y-6">

            <!-- Kontrol -->
            <div class="bg-white rounded-2xl md:rounded-[2rem] border border-gray-100 shadow-sm p-5 md:p-7">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
                    <div class="min-w-0">
                        <p class="text-[10px] font-black tracking-widest uppercase text-unmaris-blue">Wilayah ditampilkan</p>
                        <nav class="flex flex-wrap items-center gap-2 mt-2 text-sm font-bold" aria-label="Navigasi wilayah">
                            <button wire:click="resetToRoot" class="text-unmaris-blue hover:underline {{ $canGoBack ? '' : 'cursor-default' }}">Indonesia</button>
                            @foreach($crumbs as $crumb)
                                <span class="text-gray-300" aria-hidden="true">/</span>
                                <span class="text-gray-600 truncate">{{ $crumb['name'] }}</span>
                            @endforeach
                            <span class="text-gray-300" aria-hidden="true">/</span>
                            <span class="text-unmaris-blue uppercase tracking-wide">{{ $current['level'] }}</span>
                        </nav>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        @if($canGoBack)
                            <button wire:click="back" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-unmaris-blue text-white text-xs font-black uppercase tracking-widest hover:bg-unmaris-blue/90 transition">
                                <span aria-hidden="true">←</span> Kembali
                            </button>
                        @endif

                        <div class="flex items-center gap-1 p-1 bg-gray-100 rounded-full" role="group" aria-label="Filter status mahasiswa">
                            <button wire:click="setStatus('aktif')" class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest transition {{ $status === 'aktif' ? 'bg-unmaris-blue text-white' : 'text-gray-500 hover:text-unmaris-blue' }}" aria-pressed="{{ $status === 'aktif' ? 'true' : 'false' }}">Aktif</button>
                            <button wire:click="setStatus('semua')" class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest transition {{ $status === 'semua' ? 'bg-unmaris-yellow text-unmaris-blue' : 'text-gray-500 hover:text-unmaris-blue' }}" aria-pressed="{{ $status === 'semua' ? 'true' : 'false' }}">Semua</button>
                        </div>
                    </div>
                </div>
            </div>

            @if($error)
                <!-- Error state -->
                <div class="bg-white rounded-2xl md:rounded-[2rem] border border-red-100 p-10 md:p-16 text-center" role="alert">
                    <div class="w-16 h-16 mx-auto rounded-full bg-red-50 flex items-center justify-center mb-5">
                        <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.74-3L13.74 4a2 2 0 00-3.48 0L3.34 16a2 2 0 001.73 3z" /></svg>
                    </div>
                    <h2 class="text-xl md:text-2xl font-black text-gray-900">Statistik tidak dapat dimuat</h2>
                    <p class="text-sm text-gray-500 mt-3 max-w-md mx-auto">{{ $error }}</p>
                    <button wire:click="retry" class="mt-6 px-8 py-3 bg-unmaris-yellow text-unmaris-blue font-black rounded-full shadow-md hover:shadow-lg hover:scale-105 transition-all uppercase tracking-widest text-sm">Coba lagi</button>
                </div>

            @elseif($loading)
                <!-- Loading state -->
                <div class="bg-white rounded-2xl md:rounded-[2rem] border border-gray-100 p-12 md:p-20 text-center" aria-live="polite" aria-busy="true">
                    <div class="w-14 h-14 mx-auto rounded-full border-4 border-unmaris-blue/20 border-t-unmaris-blue animate-spin mb-5"></div>
                    <p class="font-black text-gray-900">Memuat statistik wilayah…</p>
                </div>

            @else
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                    <!-- Peta -->
                    <div class="xl:col-span-2 bg-white rounded-2xl md:rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
                        <div class="p-5 md:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div>
                                <h2 class="font-black text-lg md:text-xl text-unmaris-blue">Peta Persebaran</h2>
                                <p class="text-xs text-gray-500 mt-1">{{ $current['name'] }} · {{ ucfirst($current['level']) }}</p>
                            </div>
                            <div class="flex flex-wrap items-center gap-2" role="group" aria-label="Mode peta">
                                <button type="button" data-gis-mode="marker" class="gis-mode-button is-active">● Marker</button>
                                <button type="button" data-gis-mode="heat" class="gis-mode-button" disabled title="Segera hadir">🔥 Heatmap</button>
                                <button type="button" data-gis-mode="region" class="gis-mode-button">🗺️ Wilayah</button>
                            </div>
                        </div>

                        <div wire:ignore class="relative p-3 md:p-6">
                            <div
                                id="student-statistics-map"
                                data-stats="{{ json_encode([
                                    'rows' => $rows,
                                    'level' => $current['level'],
                                    'parent' => $current['code'],
                                    'parentName' => $current['name'],
                                    'breadcrumbs' => $stack,
                                    'nextLevel' => $nextLevel,
                                    'mode' => 'marker',
                                    'bands' => $markerBands,
                                ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG) }}"
                                class="h-[360px] md:h-[520px] rounded-2xl overflow-hidden relative z-0 border border-gray-200"
                            ></div>
                            <div id="student-statistics-loading" style="display:none" class="absolute inset-0 m-3 md:m-6 rounded-2xl bg-white/70 backdrop-blur-[2px] z-[1000] flex items-center justify-center pointer-events-none">
                                <div class="flex items-center gap-3 rounded-full bg-white px-5 py-3 shadow-lg border border-gray-100 text-xs font-bold text-unmaris-blue">
                                    <span class="w-4 h-4 rounded-full border-2 border-unmaris-blue/20 border-t-unmaris-blue animate-spin"></span>
                                    Memuat peta…
                                </div>
                            </div>
                        </div>

                        <div class="px-5 md:px-6 pb-5 md:pb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-[11px] text-gray-500">
                                <span class="font-bold uppercase tracking-wider text-gray-400">Jumlah mahasiswa · klik marker untuk detail</span>
                                <div id="student-statistics-legend" class="flex flex-wrap items-center gap-x-3 gap-y-2" aria-label="Legenda jumlah mahasiswa"></div>
                            </div>
                            <span class="text-[11px] text-gray-400">Sumber batas wilayah: GeoJSON administratif</span>
                        </div>
                    </div>

                    <!-- Top wilayah -->
                    <div class="bg-white rounded-2xl md:rounded-[2rem] border border-gray-100 shadow-sm p-5 md:p-7">
                        <h2 class="font-black text-lg md:text-xl text-unmaris-blue">Top Wilayah</h2>
                        <p class="text-xs text-gray-500 mt-1">Diurutkan dari jumlah mahasiswa terbanyak</p>

                        <ol class="mt-5 space-y-3" aria-label="Daftar wilayah dengan jumlah mahasiswa terbanyak">
                            @forelse($topRows as $index => $row)
                                <li class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition">
                                    <span class="shrink-0 w-7 h-7 rounded-full bg-unmaris-blue text-white text-xs font-black flex items-center justify-center">{{ $index + 1 }}</span>
                                    <div class="min-w-0 flex-1">
                                        <p class="font-bold text-sm truncate" title="{{ $row['name'] }}">{{ $row['name'] }}</p>
                                        <p class="text-xs text-gray-500">{{ number_format($row['jumlah_mahasiswa'], 0, ',', '.') }} mahasiswa</p>
                                    </div>
                                    @if($nextLevel)
                                        <button wire:click="drillDown('{{ $row['code'] }}')" class="shrink-0 text-xs font-black text-unmaris-blue hover:text-unmaris-yellow transition" aria-label="Lihat wilayah {{ $row['name'] }}">Lihat</button>
                                    @endif
                                </li>
                            @empty
                                <li class="text-sm text-gray-500 py-10 text-center bg-gray-50 rounded-xl">
                                    Belum ada data untuk wilayah ini.
                                </li>
                            @endforelse
                        </ol>

                        @if(count($rows) > count($topRows))
                            <p class="text-[11px] text-gray-400 mt-4">Menampilkan {{ count($topRows) }} teratas dari {{ number_format(count($rows)) }} wilayah.</p>
                        @endif
                    </div>
                </div>

                <!-- Footer meta -->
                <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs text-gray-500">
                    <p>Total wilayah ditampilkan: <strong class="text-unmaris-blue">{{ number_format(count($rows)) }}</strong></p>
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
            ]);
        </script>
    @endpush
</div>
