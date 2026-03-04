<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Header Section -->
    <section class="bg-unmaris-blue text-white py-16 mb-12 relative overflow-hidden">
        <!-- Aksen Latar Belakang -->
        <div class="absolute inset-0 opacity-10">
            <svg class="absolute right-0 top-0 h-full w-1/2" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                <polygon points="0,100 100,0 100,100" />
            </svg>
        </div>

        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 border-b-4 border-unmaris-yellow inline-block pb-2">Publikasi & Berita</h1>
            <p class="text-lg text-gray-200 max-w-2xl mx-auto mt-4">Pusat informasi resmi, prestasi mahasiswa, dan kabar terkini dari civitas akademika Universitas Stella Maris Sumba.</p>
        </div>
    </section>

    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Grid Berita -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @forelse($news as $item)
            <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-100 flex flex-col h-full group">
                <a href="{{ route('news.detail', $item->slug) }}" class="block relative overflow-hidden">
                    <!-- Label Kategori (Absolute) -->
                    <div class="absolute top-4 left-4 z-20">
                        <span class="bg-unmaris-yellow text-unmaris-blue text-xs font-bold px-3 py-1 rounded-sm uppercase tracking-wider shadow-md">
                            {{ $item->category->name ?? 'Umum' }}
                        </span>
                    </div>

                    <!-- Image Container -->
                    <div class="h-60 bg-gray-200 w-full relative overflow-hidden">
                        @if($item->featured_image)
                        <img src="{{  Storage::url($item->featured_image) }}"
                            alt="{{ $item->title }}"
                            class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110"
                            onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=UNMARIS&background=1B1464&color=FDE01A&size=512';">
                        @else
                        <!-- Placeholder jika tidak ada gambar -->
                        <div class="w-full h-full flex items-center justify-center bg-unmaris-blue opacity-10 transform transition-transform duration-700 group-hover:scale-110">
                            <svg class="w-16 h-16 text-unmaris-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 8H20"></path>
                            </svg>
                        </div>
                        @endif
                        <!-- Overlay Gradasi Gelap di bawah gambar -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                </a>

                <div class="p-6 flex flex-col flex-grow">
                    <!-- Tanggal Publikasi -->
                    <div class="flex items-center text-xs text-gray-500 mb-3 font-medium">
                        <svg class="w-4 h-4 mr-1.5 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $item->published_at ? $item->published_at->format('d F Y') : '-' }}
                    </div>

                    <!-- Judul -->
                    <h2 class="text-xl font-bold mb-3 text-gray-900 leading-tight group-hover:text-unmaris-blue transition-colors duration-200">
                        <a href="{{ route('news.detail', $item->slug) }}" class="focus:outline-none">
                            {{ Str::limit($item->title, 65) }}
                        </a>
                    </h2>

                    <!-- Kutipan Singkat -->
                    <p class="text-gray-600 text-sm mb-6 flex-grow line-clamp-3">
                        {{ $item->excerpt }}
                    </p>

                    <!-- Link Baca Selengkapnya -->
                    <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                        <div class="flex items-center text-xs text-gray-500 font-semibold">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Humas UNMARIS
                        </div>
                        <a href="{{ route('news.detail', $item->slug) }}" class="inline-flex items-center text-sm font-bold text-unmaris-blue hover:text-unmaris-yellow transition-colors duration-200">
                            Selengkapnya
                            <svg class="w-4 h-4 ml-1 transform transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <!-- Tampilan Jika Tidak Ada Berita -->
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-50 mb-6 text-unmaris-blue">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 8H20"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum ada berita dipublikasikan</h3>
                <p class="text-gray-500">Silakan cek kembali nanti untuk mendapatkan informasi terbaru dari UNMARIS.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination (Sudah bawaan Tailwind dari Laravel) -->
        <div class="mt-8 flex justify-center">
            {{ $news->links() }}
        </div>
    </div>
</div>