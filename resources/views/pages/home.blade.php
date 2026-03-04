<x-layouts.app title="Beranda - Universitas Stella Maris Sumba">

    <!-- Hero Section -->
    <section class="relative bg-unmaris-blue text-white overflow-hidden">
        <!-- Background Pattern / Overlay -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon fill="currentColor" points="0,100 100,0 100,100" />
            </svg>
        </div>

        <div class="container mx-auto px-4 py-24 md:py-32 relative z-10 flex flex-col md:flex-row items-center">
            <div class="w-full md:w-3/5 text-center md:text-left md:pr-10">
                <span class="inline-block py-1 px-3 rounded-full bg-unmaris-yellow text-unmaris-blue text-sm font-bold tracking-wider mb-6 uppercase">Penerimaan Mahasiswa Baru Buka!</span>
                <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">
                    Membangun Masa Depan<br>
                    <span class="text-unmaris-yellow">Dari Sumba Untuk Dunia</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-200 mb-10 max-w-2xl mx-auto md:mx-0">
                    Bergabunglah dengan Universitas Stella Maris Sumba (UNMARIS). Bersama mengukir prestasi, membentuk karakter unggul, dan siap menghadapi tantangan global.
                </p>
                <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                    <a href="https://pmb.unmaris.ac.id" target="_blank" class="bg-unmaris-yellow text-unmaris-blue px-8 py-4 rounded-full font-bold text-lg hover:bg-yellow-400 transition shadow-lg text-center">
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('profile') }}" class="bg-transparent border-2 border-unmaris-yellow text-unmaris-yellow px-8 py-4 rounded-full font-bold text-lg hover:bg-unmaris-yellow hover:text-unmaris-blue transition text-center">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            <div class="w-full md:w-2/5 mt-16 md:mt-0 hidden md:block">
                <!-- Ilustrasi Hero / Foto Kampus -->
                <div class="relative">
                    <div class="absolute inset-0 bg-unmaris-yellow rounded-full blur-3xl opacity-20 transform -translate-x-10 translate-y-10"></div>
                    <img src="{{ asset('images/logo-unmaris.png') }}" alt="Mahasiswa UNMARIS" class="rounded-2xl shadow-2xl relative z-10 border-4 border-white object-cover aspect-square">
                </div>
            </div>
        </div>
    </section>

    <!-- Highlight / Keunggulan Section -->
    <section class="py-16 bg-white relative -mt-10 z-20">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Highlight 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-xl border-t-4 border-unmaris-blue transform transition hover:-translate-y-2">
                    <div class="w-14 h-14 bg-blue-50 text-unmaris-blue rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Kurikulum Relevan</h3>
                    <p class="text-gray-600">Disusun bersama praktisi dan ahli untuk memastikan lulusan siap kerja di era digital.</p>
                </div>
                <!-- Highlight 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-xl border-t-4 border-unmaris-yellow transform transition hover:-translate-y-2">
                    <div class="w-14 h-14 bg-yellow-50 text-unmaris-yellow rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Fasilitas Memadai</h3>
                    <p class="text-gray-600">Lingkungan kampus yang kondusif dengan fasilitas pendukung akademik yang terus dikembangkan.</p>
                </div>
                <!-- Highlight 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-xl border-t-4 border-unmaris-blue transform transition hover:-translate-y-2">
                    <div class="w-14 h-14 bg-blue-50 text-unmaris-blue rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Pendidikan Karakter</h3>
                    <p class="text-gray-600">Fokus pada integritas, etika, dan kepemimpinan untuk mencetak agen perubahan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="flex justify-between items-end mb-12 border-b-2 border-gray-200 pb-4">
                <div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-unmaris-blue">Berita & Publikasi</h2>
                    <p class="text-gray-600 mt-2">Kabar terbaru dari kampus peradaban UNMARIS.</p>
                </div>
                <a href="{{ route('news.index') }}" class="hidden md:inline-flex items-center text-unmaris-blue font-bold hover:text-unmaris-yellow transition">
                    Lihat Semua Berita <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($latestNews as $item)
                <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 flex flex-col h-full">
                    <a href="{{ route('news.detail', $item->slug) }}" class="block relative overflow-hidden group">
                        <!-- Image Placeholder -->
                        <div class="h-56 bg-gray-200 w-full object-cover transform transition duration-500 group-hover:scale-110 flex items-center justify-center">
                            @if($item->featured_image)
                            <img src="{{ asset('storage/'.$item->featured_image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                            @else
                            <span class="text-gray-400 font-medium">No Image</span>
                            @endif
                        </div>
                        <div class="absolute top-4 left-4">
                            <span class="bg-unmaris-yellow text-unmaris-blue text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow">
                                {{ $item->category->name }}
                            </span>
                        </div>
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex items-center text-xs text-gray-500 mb-3">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $item->published_at->format('d M Y') }}
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-900 leading-tight">
                            <a href="{{ route('news.detail', $item->slug) }}" class="hover:text-unmaris-blue transition">
                                {{ Str::limit($item->title, 60) }}
                            </a>
                        </h3>
                        <p class="text-gray-600 text-sm mb-6 flex-grow">
                            {{ Str::limit($item->excerpt, 100) }}
                        </p>
                        <a href="{{ route('news.detail', $item->slug) }}" class="inline-flex items-center text-sm font-bold text-unmaris-blue hover:text-unmaris-yellow transition mt-auto">
                            Baca selengkapnya
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </article>
                @empty
                <div class="col-span-3 text-center py-12 bg-white rounded-2xl border border-gray-100">
                    <p class="text-gray-500">Belum ada berita yang dipublikasikan.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-8 text-center md:hidden">
                <a href="{{ route('news.index') }}" class="inline-block border-2 border-unmaris-blue text-unmaris-blue px-6 py-2 rounded-full font-bold hover:bg-unmaris-blue hover:text-white transition">
                    Lihat Semua Berita
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>