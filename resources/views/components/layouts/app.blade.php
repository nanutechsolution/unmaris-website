<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Universitas Stella Maris Sumba - UNMARIS' }}</title>
    
    <!-- Basic SEO Meta Tags -->
    <meta name="description" content="{{ $description ?? 'Universitas Stella Maris Sumba, mencetak generasi unggul, berkarakter, dan berdaya saing global di Nusa Tenggara Timur.' }}">
    <meta name="keywords" content="Universitas di Sumba, Kampus Sumba, Stella Maris Sumba, Kuliah di Sumba, UNMARIS">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? 'Universitas Stella Maris Sumba' }}">
    <meta property="og:description" content="{{ $description ?? 'Universitas Stella Maris Sumba - Pendidikan Unggul di NTT.' }}">
    <meta property="og:image" content="{{ $ogImage ?? asset('images/default-og.jpg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased flex flex-col min-h-screen">

    <!-- Header / Navbar (Mobile-First dengan Alpine.js) -->
    <!-- Alpine.js (x-data) mengatur status menu seluler terbuka/tertutup -->
    <header class="bg-unmaris-blue text-white sticky top-0 z-50 shadow-md border-b-4 border-unmaris-yellow" x-data="{ mobileMenuOpen: false }">
        <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
            
            <!-- Kiri: Logo & Nama Kampus -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 relative z-20">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center p-1 shadow-inner">
                    <!-- Ganti dengan path logo asli Anda -->
                    <img src="{{ asset('images/logo-unmaris.png') }}" alt="Logo UNMARIS" class="w-full h-auto" onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=U+M&background=1B1464&color=FDE01A';">
                </div>
                <span class="text-xl md:text-2xl font-bold tracking-tight text-unmaris-yellow">
                    UNMARIS
                </span>
            </a>

            <!-- Kanan: Tombol Hamburger (Hanya Tampil di Mobile) -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="lg:hidden text-white hover:text-unmaris-yellow focus:outline-none relative z-20 transition-colors" aria-label="Toggle menu">
                <!-- Icon Menu (Garis Tiga) -->
                <svg x-show="!mobileMenuOpen" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <!-- Icon Close (Silang) -->
                <svg x-show="mobileMenuOpen" style="display: none;" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Kanan: Menu Desktop (Sembunyi di Mobile, Tampil di Layar Besar lg) -->
            <div class="hidden lg:flex space-x-1 lg:space-x-6 items-center text-sm font-medium">
                <a href="{{ route('home') }}" class="px-2 py-2 hover:text-unmaris-yellow transition {{ request()->routeIs('home') ? 'text-unmaris-yellow border-b-2 border-unmaris-yellow' : '' }}">Beranda</a>
                
                <a href="{{ route('profile') }}" class="px-2 py-2 hover:text-unmaris-yellow transition {{ request()->routeIs('profile') ? 'text-unmaris-yellow border-b-2 border-unmaris-yellow' : '' }}">Profil</a>
                
                <a href="{{ route('faculties.index') }}" class="px-2 py-2 hover:text-unmaris-yellow transition {{ request()->routeIs('faculties.*') ? 'text-unmaris-yellow border-b-2 border-unmaris-yellow' : '' }}">Fakultas & Prodi</a>
                
                <!-- Dropdown Akademik -->
                <div class="relative" x-data="{ openAkademik: false }" @mouseenter="openAkademik = true" @mouseleave="openAkademik = false">
                    <button class="flex items-center px-2 py-2 hover:text-unmaris-yellow transition {{ request()->is('akademik/*') ? 'text-unmaris-yellow' : '' }}">
                        Akademik 
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <!-- Isi Dropdown Akademik -->
                    <div x-show="openAkademik" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute top-full left-0 w-56 bg-white rounded-xl shadow-xl py-2 text-gray-800 border-t-4 border-unmaris-yellow overflow-hidden" style="display: none;">
                        <a href="{{ route('akademik.sistem') }}" class="block px-5 py-2.5 hover:bg-gray-50 hover:text-unmaris-blue transition font-medium">Sistem Pembelajaran</a>
                        <a href="{{ route('akademik.unduhan') }}" class="block px-5 py-2.5 hover:bg-gray-50 hover:text-unmaris-blue transition font-medium">Pusat Unduhan (Dokumen)</a>
                    </div>
                </div>

                <!-- Dropdown Informasi -->
                <div class="relative" x-data="{ openInfo: false }" @mouseenter="openInfo = true" @mouseleave="openInfo = false">
                    <button class="flex items-center px-2 py-2 hover:text-unmaris-yellow transition {{ request()->routeIs('news.*') || request()->routeIs('announcements.*') ? 'text-unmaris-yellow' : '' }}">
                        Informasi 
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <!-- Isi Dropdown Informasi -->
                    <div x-show="openInfo" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute top-full left-0 w-56 bg-white rounded-xl shadow-xl py-2 text-gray-800 border-t-4 border-unmaris-yellow overflow-hidden" style="display: none;">
                        <a href="{{ route('news.index') }}" class="block px-5 py-2.5 hover:bg-gray-50 hover:text-unmaris-blue transition font-medium">Berita & Publikasi</a>
                        <a href="{{ route('announcements.index') }}" class="block px-5 py-2.5 hover:bg-gray-50 hover:text-unmaris-blue transition font-medium">Pengumuman & Agenda</a>
                    </div>
                </div>

                <a href="{{ route('contact') }}" class="px-2 py-2 hover:text-unmaris-yellow transition {{ request()->routeIs('contact') ? 'text-unmaris-yellow border-b-2 border-unmaris-yellow' : '' }}">Hubungi Kami</a>
                
                <!-- CTA PMB -->
                <div class="pl-2">
                    <a href="https://pmb.unmaris.ac.id" target="_blank" class="inline-flex items-center justify-center bg-unmaris-yellow text-unmaris-blue px-6 py-2.5 rounded-full font-bold hover:bg-yellow-400 hover:scale-105 transition-all shadow-md">
                        Daftar PMB
                    </a>
                </div>
            </div>
        </nav>

        <!-- Menu Mobile (Tampil Dropdown di Layar Kecil) -->
        <div x-show="mobileMenuOpen" 
             x-collapse
             class="lg:hidden bg-unmaris-blue border-t border-blue-900/50 shadow-inner" style="display: none;">
            <div class="container mx-auto px-4 py-4 space-y-1 font-medium">
                <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl hover:bg-blue-900/50 hover:text-unmaris-yellow transition {{ request()->routeIs('home') ? 'bg-blue-900/50 text-unmaris-yellow' : '' }}">Beranda</a>
                
                <a href="{{ route('profile') }}" class="block px-4 py-3 rounded-xl hover:bg-blue-900/50 hover:text-unmaris-yellow transition {{ request()->routeIs('profile') ? 'bg-blue-900/50 text-unmaris-yellow' : '' }}">Profil Universitas</a>
                
                <a href="{{ route('faculties.index') }}" class="block px-4 py-3 rounded-xl hover:bg-blue-900/50 hover:text-unmaris-yellow transition {{ request()->routeIs('faculties.*') ? 'bg-blue-900/50 text-unmaris-yellow' : '' }}">Fakultas & Prodi</a>
                
                <!-- Mobile Dropdown Akademik -->
                <div x-data="{ openAkademikMobile: false }" class="space-y-1">
                    <button @click="openAkademikMobile = !openAkademikMobile" class="w-full flex justify-between items-center px-4 py-3 rounded-xl hover:bg-blue-900/50 hover:text-unmaris-yellow focus:outline-none transition {{ request()->is('akademik/*') ? 'text-unmaris-yellow' : '' }}">
                        <span>Akademik</span>
                        <svg :class="{'transform rotate-180': openAkademikMobile}" class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openAkademikMobile" x-collapse class="pl-4 pr-2 space-y-1" style="display: none;">
                        <a href="{{ route('akademik.sistem') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-blue-900/50 rounded-lg">Sistem Pembelajaran</a>
                        <a href="{{ route('akademik.unduhan') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-blue-900/50 rounded-lg">Pusat Unduhan Akademik</a>
                    </div>
                </div>

                <!-- Mobile Dropdown Informasi -->
                <div x-data="{ openInfoMobile: false }" class="space-y-1">
                    <button @click="openInfoMobile = !openInfoMobile" class="w-full flex justify-between items-center px-4 py-3 rounded-xl hover:bg-blue-900/50 hover:text-unmaris-yellow focus:outline-none transition {{ request()->routeIs('news.*') || request()->routeIs('announcements.*') ? 'text-unmaris-yellow' : '' }}">
                        <span>Informasi</span>
                        <svg :class="{'transform rotate-180': openInfoMobile}" class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openInfoMobile" x-collapse class="pl-4 pr-2 space-y-1" style="display: none;">
                        <a href="{{ route('news.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-blue-900/50 rounded-lg">Berita & Publikasi</a>
                        <a href="{{ route('announcements.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-blue-900/50 rounded-lg">Pengumuman & Agenda</a>
                    </div>
                </div>

                <a href="{{ route('contact') }}" class="block px-4 py-3 rounded-xl hover:bg-blue-900/50 hover:text-unmaris-yellow transition {{ request()->routeIs('contact') ? 'bg-blue-900/50 text-unmaris-yellow' : '' }}">Hubungi Kami</a>
                
                <div class="pt-6 pb-4">
                    <a href="https://pmb.unmaris.ac.id" target="_blank" class="block w-full text-center bg-unmaris-yellow text-unmaris-blue px-6 py-3.5 rounded-xl font-bold hover:bg-yellow-400 transition shadow-lg text-lg">
                        Daftar Mahasiswa Baru
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12 md:py-16 mt-auto border-t-[6px] border-unmaris-blue relative overflow-hidden">
        <!-- Footer Pattern -->
        <div class="absolute inset-0 opacity-5 pointer-events-none">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon fill="currentColor" points="100,100 0,0 100,0"/>
            </svg>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8">
                
                <!-- Kolom 1: Tentang Kampus -->
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center p-1">
                            <img src="{{ asset('images/logo-unmaris.png') }}" alt="Logo UNMARIS" class="w-full h-auto" onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=U+M&background=1B1464&color=FDE01A';">
                        </div>
                        <h3 class="text-xl font-bold text-unmaris-yellow leading-tight">Universitas Stella Maris<br>Sumba</h3>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed mb-6">Membangun peradaban Sumba dan kawasan Timur Indonesia melalui pendidikan tinggi berkualitas, berkarakter, dan berdaya saing global.</p>
                    <div class="flex space-x-4">
                        <!-- Social Media Links (Opsional) -->
                        <a href="#" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-unmaris-yellow hover:text-unmaris-blue transition"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-unmaris-yellow hover:text-unmaris-blue transition"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                    </div>
                </div>

                <!-- Kolom 2: Tautan Akademik -->
                <div class="lg:col-span-1">
                    <h4 class="text-white font-bold mb-6 text-lg border-b-2 border-gray-700 inline-block pb-2">Informasi Akademik</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('faculties.index') }}" class="text-gray-400 hover:text-unmaris-yellow hover:translate-x-1 inline-block transition transform duration-200">Fakultas & Program Studi</a></li>
                        <li><a href="{{ route('akademik.sistem') }}" class="text-gray-400 hover:text-unmaris-yellow hover:translate-x-1 inline-block transition transform duration-200">Sistem Pembelajaran</a></li>
                        <li><a href="{{ route('akademik.unduhan') }}" class="text-gray-400 hover:text-unmaris-yellow hover:translate-x-1 inline-block transition transform duration-200">Kalender & Jadwal Kuliah</a></li>
                        <li><a href="https://pmb.unmaris.ac.id" target="_blank" class="text-gray-400 hover:text-unmaris-yellow hover:translate-x-1 inline-block transition transform duration-200">Pendaftaran (PMB)</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Tautan Publikasi -->
                <div class="lg:col-span-1">
                    <h4 class="text-white font-bold mb-6 text-lg border-b-2 border-gray-700 inline-block pb-2">Publikasi Kampus</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('profile') }}" class="text-gray-400 hover:text-unmaris-yellow hover:translate-x-1 inline-block transition transform duration-200">Profil Universitas</a></li>
                        <li><a href="{{ route('news.index') }}" class="text-gray-400 hover:text-unmaris-yellow hover:translate-x-1 inline-block transition transform duration-200">Berita & Artikel</a></li>
                        <li><a href="{{ route('announcements.index') }}" class="text-gray-400 hover:text-unmaris-yellow hover:translate-x-1 inline-block transition transform duration-200">Pengumuman Resmi</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-unmaris-yellow hover:translate-x-1 inline-block transition transform duration-200">Hubungi Kami / Layanan</a></li>
                    </ul>
                </div>

                <!-- Kolom 4: Kontak Cepat -->
                <div class="lg:col-span-1">
                    <h4 class="text-white font-bold mb-6 text-lg border-b-2 border-gray-700 inline-block pb-2">Kontak Kami</h4>
                    <ul class="space-y-4 text-sm text-gray-400">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-unmaris-yellow mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Jl. Pendidikan No. 1, Tambolaka,<br>Sumba Barat Daya, NTT</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-unmaris-yellow mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <a href="mailto:info@unmaris.ac.id" class="hover:text-unmaris-yellow transition">info@unmaris.ac.id</a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-unmaris-yellow mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>0812-3456-7890</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500 gap-4">
                <p>&copy; {{ date('Y') }} Universitas Stella Maris Sumba (UNMARIS). Hak Cipta Dilindungi.</p>
                <div class="flex space-x-4">
                    <a href="#" class="hover:text-white transition">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>