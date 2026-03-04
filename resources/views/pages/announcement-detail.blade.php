<x-layouts.app :title="$announcement->title . ' - UNMARIS'">

    <div class="bg-gray-50 min-h-screen py-12">
        <div class="container mx-auto px-4 max-w-4xl">

            <!-- Breadcrumbs Navigasi -->
            <nav class="flex text-sm text-gray-500 mb-8 font-medium bg-white p-4 rounded-xl shadow-sm border border-gray-100" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center hover:text-unmaris-blue transition">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('announcements.index') }}" class="ml-1 md:ml-2 hover:text-unmaris-blue transition">Pengumuman & Agenda</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 md:ml-2 text-gray-400">{{ Str::limit($announcement->title, 30) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Kotak Artikel Pengumuman -->
            <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                <!-- Garis Warna Pembeda (Biru untuk Agenda, Kuning untuk Pengumuman) -->
                <div class="w-full h-3 bg-{{ $announcement->type === 'agenda' ? 'unmaris-blue' : 'unmaris-yellow' }}"></div>

                <div class="p-8 md:p-12">
                    <!-- Informasi Meta (Tipe, Tanggal, Lokasi) -->
                    <div class="flex flex-wrap items-center gap-4 text-sm mb-6">
                        <!-- Tipe Badge -->
                        <span class="{{ $announcement->type === 'agenda' ? 'bg-blue-50 text-unmaris-blue' : 'bg-yellow-50 text-yellow-700' }} font-bold px-4 py-1.5 rounded-full text-xs uppercase tracking-wider">
                            {{ ucfirst($announcement->type) }}
                        </span>

                        <!-- Tanggal -->
                        <div class="flex items-center font-medium text-gray-700 bg-gray-50 px-3 py-1.5 rounded-full">
                            <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <time datetime="{{ $announcement->start_date }}">{{ $announcement->start_date->format('d F Y') }}</time>
                            @if($announcement->end_date)
                            <span class="mx-1">-</span>
                            <time datetime="{{ $announcement->end_date }}">{{ $announcement->end_date->format('d F Y') }}</time>
                            @endif
                        </div>

                        <!-- Lokasi (Hanya muncul jika tipenya agenda dan ada isinya) -->
                        @if($announcement->type === 'agenda' && $announcement->location)
                        <div class="flex items-center font-medium text-gray-700 bg-gray-50 px-3 py-1.5 rounded-full">
                            <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            {{ $announcement->location }}
                        </div>
                        @endif
                    </div>

                    <!-- Judul Utama -->
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 leading-tight">
                        {{ $announcement->title }}
                    </h1>

                    <!-- Isi Konten (Diambil dari RichEditor) -->
                    <div class="prose prose-lg max-w-none prose-a:text-unmaris-blue hover:prose-a:text-unmaris-yellow prose-headings:text-unmaris-blue prose-img:rounded-xl">
                        {!! $announcement->content !!}
                    </div>

                    <!-- Kotak Unduh Lampiran Dokumen (Muncul jika ada lampiran) -->
                    @if($announcement->attachment)
                    <div class="mt-12 p-6 md:p-8 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300 flex flex-col sm:flex-row items-center justify-between gap-6 hover:border-unmaris-blue transition-colors duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center shadow-sm text-red-500 mr-5 shrink-0">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">Lampiran Dokumen Resmi</h4>
                                <p class="text-sm text-gray-500 mt-1">Unduh file lampiran untuk melihat informasi lebih detail.</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/'.$announcement->attachment) }}" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-unmaris-blue text-white font-bold rounded-full hover:bg-opacity-90 transition shadow-md whitespace-nowrap">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Unduh File
                        </a>
                    </div>
                    @endif
                </div>
            </article>

            <!-- Tombol Kembali -->
            <div class="mt-8 text-center">
                <a href="{{ route('announcements.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 hover:text-unmaris-blue transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Indeks Pengumuman
                </a>
            </div>

        </div>
    </div>
</x-layouts.app>