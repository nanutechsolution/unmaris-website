<div class="min-h-screen bg-slate-50 pb-20">
    <x-ui.page-hero title="Pusat Unduhan Akademik" eyebrow="Dokumen Resmi"
        description="Akses dan unduh dokumen penting Universitas Stella Maris Sumba, mulai dari Kalender Akademik, Jadwal Kuliah, Buku Pedoman, kurikulum, hingga dokumen akreditasi."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Akademik', 'url' => route('faculties.index')],
            ['label' => 'Pusat Unduhan'],
        ]" />

    <div class="container-page py-10 md:py-14">

        @if($activeTab !== $arsipTab)
        <!-- Pintasan ke tab arsip dokumen sekolah tinggi -->
        <div class="mb-10">
            <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <p class="font-bold text-amber-900 text-sm">Arsip SK Akreditasi Sekolah Tinggi</p>
                    <p class="text-amber-800/90 text-sm mt-0.5">Mencari bukti akreditasi lama masa STMIK Stella Maris Sumba? Dokumen era Sekolah Tinggi disediakan di sini.</p>
                </div>
                <button type="button" wire:click="setTab('{{ $arsipTab }}')" class="inline-flex items-center justify-center min-h-[44px] px-5 py-2 rounded-full bg-amber-800 text-white font-bold text-sm hover:bg-amber-700 transition-colors">Lihat arsip STMIK</button>
            </div>
        </div>
        @endif

        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-10 flex flex-col md:flex-row justify-between items-center gap-4 sticky top-20 z-30">
            <!-- Tabs -->
            <div class="relative flex overflow-x-auto w-full md:w-auto pb-2 md:pb-0 hide-scrollbar gap-2"
                 x-data="{ canScroll: false, cekScroll() { return this.$el.scrollWidth > this.$el.clientWidth && (this.$el.scrollLeft + this.$el.clientWidth) < this.$el.scrollWidth; } }"
                 x-init="$nextTick(() => { this.canScroll = this.cekScroll(); })"
                 x-on:scroll="$nextTick(() => { this.canScroll = this.cekScroll(); })">
                @foreach($categories as $key => $label)
                <button
                    wire:click="setTab('{{ $key }}')"
                    aria-pressed="{{ $activeTab === $key ? 'true' : 'false' }}"
                    class="whitespace-nowrap px-5 py-2 min-h-[44px] rounded-full font-bold text-sm transition
    {{ $activeTab === $key
        ? 'bg-unmaris-blue text-white'
        : 'bg-gray-100 text-gray-600 hover:bg-gray-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-unmaris-yellow focus-visible:ring-offset-2' }}">

                    {{ $label }}

                </button>

                @endforeach
                <div x-show="canScroll" class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-r from-white to-transparent" aria-hidden="true"></div>
            </div>

            <!-- Search -->
            <div class="w-full md:w-72 relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari judul, nomor SK, atau prodi..." aria-label="Cari dokumen" class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-unmaris-yellow focus:border-transparent text-base min-h-[44px]">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        @if($activeTab === $arsipTab)
        <!-- Keterangan Tab Arsip -->
        <div class="mb-8 rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-900">
            <p class="font-bold mb-1">Arsip {{ $singkatanInstitusiLama }}</p>
            <p>Dokumen di bawah diterbitkan saat institusi masih bernama {{ $namaInstitusiLama }} dan tidak lagi menjadi akreditasi yang berlaku. Arsip ini tetap ditampilkan sebagai bukti bagi lulusan periode tersebut, misalnya untuk pendaftaran CPNS, melanjutkan studi, atau verifikasi ijazah.</p>
        </div>
        @elseif($activeTab === 'akreditasi')
        <!-- Keterangan Tab Akreditasi -->
        <p class="mb-8 text-sm text-gray-600">
            Menampilkan dokumen akreditasi Universitas Stella Maris Sumba yang masih berlaku. Dokumen yang sudah kedaluwarsa tersedia di tab
            <button type="button" wire:click="setTab('{{ $arsipTab }}')" class="font-bold text-unmaris-blue underline underline-offset-2">Arsip {{ $singkatanInstitusiLama }}</button>.
        </p>
        @endif

        <!-- Loading State -->
        <div wire:loading wire:target="setTab, search" class="w-full text-center py-10" role="status" aria-live="polite">
            <div class="inline-block animate-spin rounded-full h-10 w-10 border-t-4 border-b-4 border-unmaris-blue"></div>
            <p class="mt-2 text-gray-500 font-medium">Memuat dokumen...</p>
        </div>

        <!-- Sorting -->
        <div class="mb-6 flex justify-end">
            <div class="w-full md:w-56">
                <label for="sort-dokumen" class="sr-only">Urutan dokumen</label>
                <select id="sort-dokumen" wire:model.live="sort" class="w-full min-h-[44px] rounded-full border border-gray-200 bg-white px-4 py-2 text-sm font-bold text-gray-700 focus:outline-none focus:ring-2 focus:ring-unmaris-yellow focus:border-transparent">
                    <option value="terbaru">Terbaru</option>
                    <option value="nama_az">Nama A–Z</option>
                </select>
            </div>
        </div>

        <!-- Grid Dokumen -->
        <div wire:loading.remove wire:target="setTab, search" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($documents as $doc)
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition-shadow border border-gray-100 flex flex-col h-full border-t-4 {{ $doc->category === 'kalender_akademik' ? 'border-red-500' : ($doc->category === 'jadwal_kuliah' ? 'border-blue-500' : 'border-unmaris-yellow') }}">

                <div class="flex items-start gap-4 mb-4">
                    <!-- Icon berdasarkan ekstensi tipe file yang diunggah -->
                    @php
                        $fileExt = strtoupper(pathinfo($doc->file_path ?? '', PATHINFO_EXTENSION));
                        $fileIconBg = match ($fileExt) {
                            'DOCX' => 'bg-blue-600',
                            'XLSX' => 'bg-green-600',
                            default => 'bg-red-500',
                        };
                        $fileSizeBytes = $fileSizes[$doc->file_path] ?? null;
                        $fileSizeLabel = $fileSizeBytes
                            ? number_format(round($fileSizeBytes / 1048576, 1), 1).' MB'
                            : null;
                    @endphp
                    <div class="w-12 h-12 shrink-0 rounded-xl flex items-center justify-center {{ $fileIconBg }} text-white">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        @php
                            $arsip = $doc->adalahArsip();
                            $namaInstitusiDokumen = $doc->institusi === \App\Models\Document::INSTITUSI_SEKOLAH_TINGGI
                                ? ($doc->nama_institusi_lama ?: $namaInstitusiLama)
                                : null;
                        @endphp
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block mb-1">
                            {{ ucwords(str_replace('_', ' ', $doc->category)) }}
                            @if($arsip)
                            <span class="ml-1 rounded bg-amber-100 px-1.5 py-0.5 text-[10px] font-bold text-amber-800 normal-case tracking-normal" title="{{ $namaInstitusiLama }}">Arsip STMIK</span>
                            @endif
                        </span>
                        <h3 class="text-lg font-bold text-gray-900 leading-tight break-words">{{ $doc->title }}</h3>
                    </div>
                </div>

                @if($doc->description)
                <p class="text-gray-600 text-sm mb-6 flex-grow">{{ Str::limit($doc->description, 80) }}</p>
                @else
                <div class="flex-grow mb-6"></div>
                @endif

                @if($doc->category === 'akreditasi' && (filled($doc->lembaga_akreditasi) || filled($doc->peringkat) || filled($doc->berlaku_sampai)))
                <div class="mb-6 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                    <dl class="space-y-1">
                        @if(filled($namaInstitusiDokumen))
                        <div class="flex flex-wrap gap-x-2">
                            <dt class="font-bold text-gray-900">Institusi Saat Terbit:</dt>
                            <dd class="break-words min-w-0">{{ $namaInstitusiDokumen }}</dd>
                        </div>
                        @endif
                        @if(filled($doc->lembaga_akreditasi))
                        <div class="flex flex-wrap gap-x-2">
                            <dt class="font-bold text-gray-900">Lembaga:</dt>
                            <dd>{{ $doc->lembaga_akreditasi }}</dd>
                        </div>
                        @endif
                        @if(filled($doc->peringkat))
                        <div class="flex flex-wrap gap-x-2">
                            <dt class="font-bold text-gray-900">Peringkat:</dt>
                            <dd>{{ $doc->peringkat }}</dd>
                        </div>
                        @endif
                        @if($doc->studyProgram)
                        <div class="flex flex-wrap gap-x-2">
                            <dt class="font-bold text-gray-900">Program Studi:</dt>
                            <dd>{{ $doc->studyProgram->name }}</dd>
                        </div>
                        @endif
                        @if(filled($doc->nomor_sk))
                        <div class="flex flex-wrap gap-x-2">
                            <dt class="font-bold text-gray-900">Nomor SK:</dt>
                            <dd>{{ $doc->nomor_sk }}</dd>
                        </div>
                        @endif
                        @if($doc->berlaku_mulai && $doc->berlaku_sampai)
                        <div class="flex flex-wrap gap-x-2">
                            <dt class="font-bold text-gray-900">Masa Berlaku:</dt>
                            <dd>
                                {{ $doc->berlaku_mulai->copy()->locale('id')->translatedFormat('d F Y') }}
                                s.d.
                                {{ $doc->berlaku_sampai->copy()->locale('id')->translatedFormat('d F Y') }}
                            </dd>
                        </div>
                        @elseif($doc->berlaku_sampai)
                        <div class="flex flex-wrap gap-x-2">
                            <dt class="font-bold text-gray-900">Masa Berlaku:</dt>
                            <dd>
                                Berlaku sampai
                                {{ $doc->berlaku_sampai->copy()->locale('id')->translatedFormat('d F Y') }}
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>
                @endif

                <div class="mt-auto pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex flex-col gap-1">
                        <span class="text-xs text-gray-500 font-medium">Diperbarui: {{ $doc->updated_at->copy()->locale('id')->translatedFormat('d M Y') }}</span>
                        @if($fileSizeLabel)
                        <span class="text-xs text-gray-400 font-medium">{{ $fileExt }} · {{ $fileSizeLabel }}</span>
                        @endif
                    </div>

                    <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" rel="noopener" download aria-label="Unduh {{ $doc->title }}" class="inline-flex items-center justify-center min-h-[44px] text-sm font-bold text-white bg-unmaris-blue hover:bg-unmaris-yellow hover:text-unmaris-blue px-4 py-2 rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Unduh
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                <x-ui.empty-state
                    :title="$activeTab === $arsipTab ? 'Belum ada arsip ' . $singkatanInstitusiLama : 'Tidak ada dokumen ditemukan'"
                    :description="$activeTab === $arsipTab
                        ? 'Arsip akan tampil di sini setelah dokumen akreditasi lama ditambahkan melalui panel admin.'
                        : 'Coba gunakan kata kunci pencarian lain atau pilih kategori yang berbeda.'">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </x-ui.empty-state>

                <div class="mt-6 flex flex-wrap justify-center gap-3">
                    <button type="button" wire:click="setTab('semua')" class="btn-navy">Lihat semua dokumen</button>
                    <button type="button" wire:click="$set('search', '')" class="btn-outline">Hapus pencarian</button>
                </div>
            </div>
            @endforelse
        </div>

        <div class="mt-8 flex flex-col items-center gap-3">
            @if($documents->total() > 0)
            <p class="text-sm font-medium text-slate-500">{{ $documents->total() }} dokumen ditemukan</p>
            @endif
            {{ $documents->links() }}
        </div>
    </div>

</div>