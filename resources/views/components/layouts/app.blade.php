<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Universitas Stella Maris Sumba - UNMARIS' }}</title>

    <!-- icon -->
    <link rel="icon" href="{{ asset('images/logo-unmaris.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap">

    <!-- Basic SEO -->
    <meta name="description" content="{{ $description ?? 'Universitas Stella Maris Sumba, mencetak generasi unggul, berkarakter, dan berdaya saing global di Nusa Tenggara Timur.' }}">
    <meta name="keywords" content="Universitas di Sumba, Kampus Sumba, Stella Maris Sumba, Kuliah di Sumba, UNMARIS">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="author" content="Universitas Stella Maris Sumba">

    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph (Facebook, WhatsApp, LinkedIn) -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? 'Universitas Stella Maris Sumba' }}">
    <meta property="og:description" content="{{ $description ?? 'Universitas Stella Maris Sumba - Pendidikan Unggul di NTT.' }}">
    <meta property="og:image" content="{{ $ogImage ?? asset('images/logo-unmaris.png') }}">
    <meta property="og:site_name" content="Universitas Stella Maris Sumba">
    <meta property="og:locale" content="id_ID">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? 'Universitas Stella Maris Sumba' }}">
    <meta name="twitter:description" content="{{ $description ?? 'Universitas Stella Maris Sumba - Pendidikan Unggul di NTT.' }}">
    <meta name="twitter:image" content="{{ $ogImage ?? asset('images/logo-unmaris.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "CollegeOrUniversity",
            "name": "Universitas Stella Maris Sumba",
            "alternateName": "UNMARIS",
            "url": "{{ url('/') }}",
            "logo": "{{ asset('images/logo-unmaris.png') }}"
        }
    </script>
</head>

<body class="flex min-h-screen flex-col bg-slate-50 font-sans text-slate-700 antialiased">
    <a href="#konten-utama" class="skip-link">Lewati ke konten utama</a>

    @php
        $contactPage = \App\Models\Page::where('slug', 'kontak')->first();
        $contactAddress = data_get($contactPage?->content ?? [], 'alamat') ?: 'Jl. Pendidikan No. 1, Tambolaka, Sumba Barat Daya, NTT';
        $contactEmail = data_get($contactPage?->content ?? [], 'email') ?: 'info@unmarissumba.ac.id';
        $contactPhone = data_get($contactPage?->content ?? [], 'telepon') ?: '(0387) 2524016';
    @endphp

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-50" x-data="{ mobileOpen: false, scrolled: false }"
        @scroll.window="scrolled = window.scrollY > 12"
        @keydown.escape.window="mobileOpen = false"
        x-effect="document.documentElement.style.overflow = mobileOpen ? 'hidden' : ''">

        <!-- Main bar -->
        <div class="transition-all duration-300"
            :class="scrolled ? 'bg-unmaris-blue/95 shadow-lg backdrop-blur-md' : 'bg-unmaris-blue'">
            <nav class="container-page flex items-center justify-between gap-4 py-3" aria-label="Navigasi utama">
                <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-3">
                    <span class="grid h-11 w-11 place-items-center rounded-full bg-white p-1 shadow-inner">
                        <img src="{{ asset('images/logo-unmaris.png') }}" alt="Logo UNMARIS" class="h-full w-auto"
                            onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=U+M&background=1B1464&color=FDE01A';">
                    </span>
                    <span class="leading-tight">
                        <span class="block font-display text-lg font-extrabold tracking-tight text-unmaris-yellow">UNMARIS</span>
                        <span class="block text-[9px] font-semibold uppercase tracking-[0.08em] text-white/70 max-[420px]:hidden min-[640px]:text-[10px] min-[640px]:tracking-[0.16em]">Universitas Stella Maris Sumba</span>
                    </span>
                </a>

                <!-- Desktop navigation -->
                <div class="hidden items-center gap-0.5 xl:flex">
                    @php $berandaAktif = request()->routeIs('home'); @endphp
                    <a href="{{ route('home') }}" class="nav-link {{ $berandaAktif ? 'nav-link-active' : '' }}" @if ($berandaAktif) aria-current="page" @endif>Beranda</a>

                    <x-ui.nav-menu label="Tentang" :active="request()->routeIs('profile', 'facilities.*', 'partnerships.*')">
                        <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') ? 'nav-item-active' : '' }}">Profil &amp; Pimpinan</a>
                        <a href="{{ route('facilities.index') }}" class="nav-item {{ request()->routeIs('facilities.*') ? 'nav-item-active' : '' }}">Fasilitas Kampus</a>
                        <a href="{{ route('partnerships.index') }}" class="nav-item {{ request()->routeIs('partnerships.*') ? 'nav-item-active' : '' }}">Jaringan Kemitraan</a>
                    </x-ui.nav-menu>

                    <x-ui.nav-menu label="Akademik" :active="request()->routeIs('faculties.*', 'prodi.*', 'akademik.*')">
                        <a href="{{ route('faculties.index') }}" class="nav-item {{ request()->routeIs('faculties.*', 'prodi.*') ? 'nav-item-active' : '' }}">Fakultas &amp; Program Studi</a>
                        <a href="{{ route('akademik.sistem') }}" class="nav-item {{ request()->routeIs('akademik.sistem') ? 'nav-item-active' : '' }}">Sistem Pembelajaran</a>
                        <a href="{{ route('akademik.unduhan') }}" class="nav-item {{ request()->routeIs('akademik.unduhan') ? 'nav-item-active' : '' }}">Pusat Unduhan</a>
                    </x-ui.nav-menu>

                    <x-ui.nav-menu label="Kemahasiswaan" :active="request()->routeIs('scholarships.*', 'organizations.*', 'kemahasiswaan.*')">
                        <a href="{{ route('scholarships.index') }}" class="nav-item {{ request()->routeIs('scholarships.*') ? 'nav-item-active' : '' }}">Informasi Beasiswa</a>
                        <a href="{{ route('organizations.index') }}" class="nav-item {{ request()->routeIs('organizations.*') ? 'nav-item-active' : '' }}">Organisasi Mahasiswa</a>
                    </x-ui.nav-menu>

                    <x-ui.nav-menu label="Media" :active="request()->routeIs('news.*', 'announcements.*')">
                        <a href="{{ route('news.index') }}" class="nav-item {{ request()->routeIs('news.*') ? 'nav-item-active' : '' }}">Berita Kampus</a>
                        <a href="{{ route('announcements.index') }}" class="nav-item {{ request()->routeIs('announcements.*') ? 'nav-item-active' : '' }}">Pengumuman &amp; Agenda</a>
                    </x-ui.nav-menu>

                    <x-ui.nav-menu label="Kontak" :active="request()->routeIs('contact', 'complaint.*')">
                        <a href="{{ route('contact') }}" class="nav-item {{ request()->routeIs('contact') ? 'nav-item-active' : '' }}">Hubungi Kami</a>
                        <a href="{{ route('complaint.index') }}" class="nav-item {{ request()->routeIs('complaint.*') ? 'nav-item-active' : '' }}">Pengaduan</a>
                    </x-ui.nav-menu>
                </div>

                <div class="flex items-center gap-2">
                    <a href="https://pmb.unmarissumba.ac.id" target="_blank" rel="noopener"
                        class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 whitespace-nowrap rounded-full bg-unmaris-yellow px-3 py-2.5 text-[10px] font-extrabold uppercase tracking-widest text-unmaris-blue shadow-md transition hover:bg-yellow-300 min-[640px]:px-5 min-[640px]:text-[11px]">
                        <span class="min-[640px]:hidden">PMB</span>
                        <span class="hidden min-[640px]:inline">Daftar PMB</span>
                    </a>

                    <button type="button" @click="mobileOpen = true" :aria-expanded="mobileOpen" aria-controls="menu-seluler"
                        class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-lg text-white transition hover:bg-white/10 xl:hidden"
                        aria-label="Buka menu navigasi">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </nav>
        </div>

        <!-- Mobile drawer -->
        <div x-show="mobileOpen" x-cloak class="xl:hidden">
            <div class="fixed inset-0 z-[55] bg-slate-950/60 backdrop-blur-sm" @click="mobileOpen = false" aria-hidden="true"></div>

            <div id="menu-seluler" role="dialog" aria-modal="true" aria-label="Menu navigasi seluler"
                class="fixed inset-y-0 right-0 z-[60] flex w-full max-w-sm flex-col bg-unmaris-blue shadow-2xl"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full">

                <div class="flex items-center justify-between border-b border-white/10 px-5 py-4">
                    <span class="flex items-center gap-3">
                        <span class="grid h-9 w-9 place-items-center rounded-full bg-white p-1">
                            <img src="{{ asset('images/logo-unmaris.png') }}" alt="" class="h-full w-auto">
                        </span>
                        <span class="font-display text-sm font-extrabold text-unmaris-yellow">UNMARIS</span>
                    </span>
                    <button type="button" @click="mobileOpen = false"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-lg text-white transition hover:bg-white/10"
                        aria-label="Tutup menu">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <nav class="flex-1 overflow-y-auto px-4 py-5" aria-label="Navigasi seluler">
                    <a href="{{ route('home') }}" class="mb-1 block rounded-xl border-b-2 border-transparent px-4 py-3 text-sm font-bold text-white transition hover:bg-white/10 {{ request()->routeIs('home') ? 'border-unmaris-yellow bg-white/12' : '' }}" @if (request()->routeIs('home')) aria-current="page" @endif>Beranda</a>

                    @php
                        $mobileGroups = [
                            ['label' => 'Tentang Kami', 'active' => request()->routeIs('profile', 'facilities.*', 'partnerships.*'), 'links' => [
                                ['label' => 'Profil & Pimpinan', 'route' => 'profile'],
                                ['label' => 'Fasilitas Kampus', 'route' => 'facilities.index'],
                                ['label' => 'Jaringan Kemitraan', 'route' => 'partnerships.index'],
                            ]],
                            ['label' => 'Akademik', 'active' => request()->routeIs('faculties.*', 'prodi.*', 'akademik.*'), 'links' => [
                                ['label' => 'Fakultas & Program Studi', 'route' => 'faculties.index'],
                                ['label' => 'Sistem Pembelajaran', 'route' => 'akademik.sistem'],
                                ['label' => 'Pusat Unduhan', 'route' => 'akademik.unduhan'],
                            ]],
                            ['label' => 'Kemahasiswaan', 'active' => request()->routeIs('scholarships.*', 'organizations.*', 'kemahasiswaan.*'), 'links' => [
                                ['label' => 'Informasi Beasiswa', 'route' => 'scholarships.index'],
                                ['label' => 'Organisasi Mahasiswa', 'route' => 'organizations.index'],
                            ]],
                            ['label' => 'Media & Informasi', 'active' => request()->routeIs('news.*', 'announcements.*'), 'links' => [
                                ['label' => 'Berita Kampus', 'route' => 'news.index'],
                                ['label' => 'Pengumuman & Agenda', 'route' => 'announcements.index'],
                            ]],
                            ['label' => 'Kontak', 'active' => request()->routeIs('contact', 'complaint.*'), 'links' => [
                                ['label' => 'Hubungi Kami', 'route' => 'contact'],
                                ['label' => 'Pengaduan', 'route' => 'complaint.index'],
                            ]],
                        ];
                    @endphp

                    @foreach ($mobileGroups as $group)
                        <details class="group rounded-xl">
                            <summary class="flex cursor-pointer list-none items-center justify-between rounded-xl border-b-2 border-transparent px-4 py-3 text-sm font-bold text-white transition hover:bg-white/10 {{ $group['active'] ? 'border-unmaris-yellow bg-white/12' : '' }}">
                                <span>{{ $group['label'] }}</span>
                                <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </summary>
                            <div class="mb-1 space-y-0.5 pb-1 pl-3">
                                @foreach ($group['links'] as $link)
                                    @php $subAktif = request()->routeIs($link['route']); @endphp
                                    <a href="{{ route($link['route']) }}"
                                        class="block rounded-lg border-b-2 px-4 py-3 text-sm transition hover:bg-white/10 {{ $subAktif ? 'border-unmaris-yellow bg-white/12 font-semibold text-white' : 'border-transparent font-semibold text-slate-300 hover:text-white' }}"
                                        @if ($subAktif) aria-current="page" @endif>
                                        {{ $link['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </details>
                    @endforeach
                </nav>

                <div class="border-t border-white/10 p-4">
                    <a href="https://pmb.unmarissumba.ac.id" target="_blank" rel="noopener"
                        class="flex w-full items-center justify-center rounded-xl bg-unmaris-yellow px-6 py-3.5 text-sm font-extrabold uppercase tracking-wider text-unmaris-blue shadow-lg transition hover:bg-yellow-300">
                        Daftar Mahasiswa Baru
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main id="konten-utama" tabindex="-1" class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="relative mt-auto overflow-hidden border-t-[6px] border-unmaris-blue bg-slate-900 text-slate-300">
        <div class="pointer-events-none absolute inset-0 opacity-[0.04]" aria-hidden="true">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon fill="currentColor" points="100,100 0,0 100,0" />
            </svg>
        </div>

        <div class="container-page relative z-10 py-14 md:py-16">
            <div class="grid grid-cols-1 gap-10 md:grid-cols-2 xl:grid-cols-4 xl:gap-8">

                <!-- Identitas -->
                <div>
                    <div class="mb-5 flex items-center gap-3">
                        <span class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-white p-1">
                            <img src="{{ asset('images/logo-unmaris.png') }}" alt="Logo UNMARIS" class="h-full w-auto"
                                onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=U+M&background=1B1464&color=FDE01A';">
                        </span>
                        <span class="font-display text-lg font-extrabold leading-tight text-unmaris-yellow">Universitas Stella Maris<br>Sumba</span>
                    </div>
                    <p class="mb-6 text-sm leading-relaxed text-slate-400">Membangun peradaban Sumba dan kawasan Timur Indonesia melalui pendidikan tinggi yang berkualitas, berkarakter, dan berdaya saing global.</p>
                    <div class="flex gap-3">
                        <a href="#" aria-label="Facebook UNMARIS" class="grid h-11 w-11 place-items-center rounded-full bg-slate-800 text-slate-400 transition hover:bg-unmaris-yellow hover:text-unmaris-blue">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" aria-label="Instagram UNMARIS" class="grid h-11 w-11 place-items-center rounded-full bg-slate-800 text-slate-400 transition hover:bg-unmaris-yellow hover:text-unmaris-blue">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Akademik -->
                <div>
                    <h4 class="mb-5 border-b-2 border-slate-700 pb-2 text-sm font-bold uppercase tracking-widest text-white">Akademik &amp; PMB</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('faculties.index') }}" class="footer-link">Fakultas &amp; Program Studi</a></li>
                        <li><a href="{{ route('akademik.sistem') }}" class="footer-link">Sistem Pembelajaran</a></li>
                        <li><a href="{{ route('akademik.unduhan') }}" class="footer-link">Pusat Unduhan</a></li>
                        <li><a href="{{ route('lppm.profil') }}" class="footer-link">Profil LPPM</a></li>
                        <li><a href="{{ route('lppm.publikasi') }}" class="footer-link">Publikasi Ilmiah</a></li>
                        <li><a href="https://pmb.unmarissumba.ac.id" target="_blank" rel="noopener" class="inline-flex min-h-11 items-center font-bold text-unmaris-yellow transition hover:text-white">Pendaftaran Mahasiswa Baru</a></li>
                    </ul>
                </div>

                <!-- Layanan -->
                <div>
                    <h4 class="mb-5 border-b-2 border-slate-700 pb-2 text-sm font-bold uppercase tracking-widest text-white">Layanan &amp; Informasi</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('complaint.index') }}" class="footer-link">Pengaduan &amp; Aspirasi</a></li>
                        <li><a href="{{ route('facilities.index') }}" class="footer-link">Fasilitas Kampus</a></li>
                        <li><a href="{{ route('scholarships.index') }}" class="footer-link">Informasi Beasiswa</a></li>
                        <li><a href="{{ route('organizations.index') }}" class="footer-link">Organisasi Mahasiswa</a></li>
                        <li><a href="{{ route('kemahasiswaan.statistik') }}" class="footer-link">Statistik Mahasiswa</a></li>
                        <li><a href="{{ route('news.index') }}" class="footer-link">Berita &amp; Artikel</a></li>
                        <li><a href="{{ route('announcements.index') }}" class="footer-link">Pengumuman &amp; Agenda</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="mb-5 border-b-2 border-slate-700 pb-2 text-sm font-bold uppercase tracking-widest text-white">Kontak Kami</h4>
                    <ul class="space-y-4 text-sm text-slate-400">
                        <li class="flex items-start gap-3">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $contactAddress }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="h-5 w-5 shrink-0 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <a href="mailto:{{ $contactEmail }}" class="footer-link">{{ $contactEmail }}</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="h-5 w-5 shrink-0 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>{{ $contactPhone }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-slate-800 pt-8 text-xs text-slate-500 md:flex-row">
                <p>&copy; {{ date('Y') }} Universitas Stella Maris Sumba (UNMARIS). Hak cipta dilindungi.</p>
                <div class="flex flex-wrap items-center justify-center gap-x-5 gap-y-2">
                    <a href="{{ route('contact') }}" class="footer-meta-link">Hubungi Kami</a>
                    <a href="#" class="footer-meta-link">Kebijakan Privasi</a>
                    <a href="#" class="footer-meta-link">Syarat &amp; Ketentuan</a>
                    <a href="#konten-utama" class="footer-link gap-1.5 font-semibold">
                        Kembali ke atas
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bantuan WhatsApp -->
    <div x-data="{ waOpen: false, showTooltip: false }"
        x-init="setTimeout(() => showTooltip = true, 4000); setTimeout(() => showTooltip = false, 14000)"
        class="fixed bottom-6 right-6 z-[100] flex flex-col items-end">

        <div role="dialog" aria-label="Bantuan WhatsApp" x-show="showTooltip && !waOpen"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-3"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute bottom-2.5 right-full mr-4 cursor-pointer rounded-2xl border border-slate-100 bg-white px-5 py-3 text-sm font-bold text-slate-800 shadow-2xl transition-colors hover:bg-slate-50"
            @click="waOpen = true; showTooltip = false" style="display: none;">
            <div class="flex items-center gap-2">
                <span class="text-xl" aria-hidden="true">👋</span> Ada yang bisa dibantu?
            </div>
            <div class="absolute -right-2 top-1/2 h-4 w-4 -translate-y-1/2 rotate-45 rounded-sm border-r border-t border-slate-100 bg-white"></div>
        </div>

        <div role="dialog" aria-modal="true" aria-label="Menu kontak WhatsApp UNMARIS" x-show="waOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            @click.away="waOpen = false" style="display: none;"
            class="mb-4 w-[280px] origin-bottom-right overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-2xl md:w-80">

            <div class="relative overflow-hidden bg-[#25D366] p-5 text-white">
                <div class="absolute -right-4 -top-4 h-16 w-16 rounded-full bg-white/20 blur-xl"></div>
                <div class="relative z-10 flex items-center gap-3">
                    <div class="grid h-10 w-10 shrink-0 place-items-center rounded-full border border-white/30 bg-white/20 backdrop-blur-md">
                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold">Halo! Ada yang bisa dibantu?</h4>
                        <p class="mt-0.5 text-[10px] text-green-50">Tim kami akan segera merespons Anda.</p>
                    </div>
                </div>
            </div>

            <div class="space-y-3 bg-slate-50 p-5">
                <a aria-label="Chat WhatsApp dengan Admin Pendaftaran PMB"
                    href="https://wa.me/6281216156883?text=Halo%20Admin%20PMB%20UNMARIS,%20saya%20ingin%20bertanya%20seputar%20informasi%20pendaftaran%20mahasiswa%20baru."
                    target="_blank" rel="noopener"
                    class="group flex items-center gap-3 rounded-xl border border-slate-100 bg-white p-3 transition hover:-translate-y-0.5 hover:shadow-lg">
                    <div class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-blue-50 text-unmaris-blue shadow-sm transition-colors group-hover:bg-[#25D366] group-hover:text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <h5 class="text-sm font-bold text-slate-900 transition-colors group-hover:text-unmaris-blue">Admin Pendaftaran (PMB)</h5>
                        <p class="text-[10px] text-slate-500">Info pendaftaran &amp; beasiswa</p>
                    </div>
                </a>

                <a aria-label="Chat WhatsApp dengan Admin Akademik"
                    href="https://wa.me/6285239803210?text=Halo%20Admin%20Akademik%20UNMARIS,%20saya%20ingin%20bertanya%20seputar%20perkuliahan%20dan%20fakultas."
                    target="_blank" rel="noopener"
                    class="group flex items-center gap-3 rounded-xl border border-slate-100 bg-white p-3 transition hover:-translate-y-0.5 hover:shadow-lg">
                    <div class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-yellow-50 text-yellow-600 shadow-sm transition-colors group-hover:bg-[#25D366] group-hover:text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <h5 class="text-sm font-bold text-slate-900 transition-colors group-hover:text-unmaris-blue">Admin Akademik</h5>
                        <p class="text-[10px] text-slate-500">Info jadwal &amp; sistem kuliah</p>
                    </div>
                </a>
            </div>
        </div>

        <button type="button" aria-label="Buka chat WhatsApp bantuan UNMARIS" title="Hubungi kami via WhatsApp"
            :aria-expanded="waOpen"
            @click="waOpen = !waOpen; showTooltip = false"
            class="relative grid h-14 w-14 place-items-center rounded-full bg-[#25D366] text-white shadow-[0_10px_30px_rgba(37,211,102,0.4)] transition-all duration-300 hover:scale-110 hover:bg-[#20bd5a] md:h-16 md:w-16">
            <span class="absolute right-0 top-0 flex h-4 w-4 md:h-5 md:w-5" x-show="! waOpen">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex h-4 w-4 rounded-full border-2 border-white bg-red-500 md:h-5 md:w-5"></span>
            </span>

            <svg x-show="! waOpen" class="relative z-10 h-8 w-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>

            <svg x-show="waOpen" style="display: none;" class="relative z-10 h-7 w-7" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    @livewireScripts
    @stack('scripts')
</body>

</html>
