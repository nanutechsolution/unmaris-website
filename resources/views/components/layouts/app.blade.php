@php
    $contactPage = \App\Models\Page::where('slug', 'kontak')->first();
    $contactAddress = data_get($contactPage?->content ?? [], 'alamat') ?: 'Jl. Pendidikan No. 1, Tambolaka, Sumba Barat Daya, NTT';
    $contactEmail = data_get($contactPage?->content ?? [], 'email') ?: 'info@unmarissumba.ac.id';
    $contactPhone = data_get($contactPage?->content ?? [], 'telepon') ?: '(0387) 2524016';
    $contactPhoneLink = preg_replace('/[^0-9+]/', '', $contactPhone);

    $navGroups = [
        [
            'label' => 'Tentang',
            'active' => request()->routeIs('profile', 'facilities.*', 'partnerships.*'),
            'links' => [
                ['label' => 'Profil & Pimpinan', 'route' => 'profile'],
                ['label' => 'Fasilitas Kampus', 'route' => 'facilities.index'],
                ['label' => 'Jaringan Kemitraan', 'route' => 'partnerships.index'],
            ],
        ],
        [
            'label' => 'Akademik',
            'active' => request()->routeIs('faculties.*', 'prodi.*', 'akademik.*', 'lppm.*'),
            'links' => [
                ['label' => 'Fakultas & Program Studi', 'route' => 'faculties.index'],
                ['label' => 'Sistem Pembelajaran', 'route' => 'akademik.sistem'],
                ['label' => 'Pusat Unduhan', 'route' => 'akademik.unduhan'],
                ['label' => 'Penelitian & Pengabdian', 'route' => 'lppm.profil'],
                ['label' => 'Publikasi Ilmiah', 'route' => 'lppm.publikasi'],
            ],
        ],
        [
            'label' => 'Kemahasiswaan',
            'active' => request()->routeIs('scholarships.*', 'organizations.*', 'kemahasiswaan.*'),
            'links' => [
                ['label' => 'Informasi Beasiswa', 'route' => 'scholarships.index'],
                ['label' => 'Organisasi Mahasiswa', 'route' => 'organizations.index'],
                ['label' => 'Statistik Mahasiswa', 'route' => 'kemahasiswaan.statistik'],
            ],
        ],
        [
            'label' => 'Media',
            'active' => request()->routeIs('news.*', 'announcements.*'),
            'links' => [
                ['label' => 'Berita Kampus', 'route' => 'news.index'],
                ['label' => 'Pengumuman & Agenda', 'route' => 'announcements.index'],
            ],
        ],
        [
            'label' => 'Kontak',
            'active' => request()->routeIs('contact', 'complaint.*'),
            'links' => [
                ['label' => 'Hubungi Kami', 'route' => 'contact'],
                ['label' => 'Pengaduan & Aspirasi', 'route' => 'complaint.index'],
            ],
        ],
    ];

    $searchLinks = [
        ['label' => 'Beranda', 'url' => route('home'), 'keywords' => 'awal depan utama beranda'],
        ['label' => 'Profil & Pimpinan', 'url' => route('profile'), 'keywords' => 'tentang sejarah visi misi rektor sambutan pimpinan'],
        ['label' => 'Fasilitas Kampus', 'url' => route('facilities.index'), 'keywords' => 'gedung laboratorium perpustakaan sarana prasarana'],
        ['label' => 'Jaringan Kemitraan', 'url' => route('partnerships.index'), 'keywords' => 'mitra kerja sama industri institusi'],
        ['label' => 'Fakultas & Program Studi', 'url' => route('faculties.index'), 'keywords' => 'jurusan prodi fakultas akademik kuliah'],
        ['label' => 'Sistem Pembelajaran', 'url' => route('akademik.sistem'), 'keywords' => 'kurikulum pembelajaran akademik dosen'],
        ['label' => 'Pusat Unduhan', 'url' => route('akademik.unduhan'), 'keywords' => 'dokumen unduh kalender akademik pedoman akreditasi'],
        ['label' => 'Penelitian & Pengabdian', 'url' => route('lppm.profil'), 'keywords' => 'lppm riset penelitian pengabdian masyarakat'],
        ['label' => 'Publikasi Ilmiah', 'url' => route('lppm.publikasi'), 'keywords' => 'jurnal publikasi ilmiah penelitian'],
        ['label' => 'Informasi Beasiswa', 'url' => route('scholarships.index'), 'keywords' => 'beasiswa bantuan biaya kuliah keringanan'],
        ['label' => 'Organisasi Mahasiswa', 'url' => route('organizations.index'), 'keywords' => 'bem hmj ukm organisasi kemahasiswaan'],
        ['label' => 'Statistik Mahasiswa', 'url' => route('kemahasiswaan.statistik'), 'keywords' => 'data statistik jumlah mahasiswa peta sebaran'],
        ['label' => 'Berita Kampus', 'url' => route('news.index'), 'keywords' => 'berita artikel kabar informasi terbaru'],
        ['label' => 'Pengumuman & Agenda', 'url' => route('announcements.index'), 'keywords' => 'pengumuman agenda acara jadwal kegiatan'],
        ['label' => 'Hubungi Kami', 'url' => route('contact'), 'keywords' => 'kontak alamat telepon email lokasi'],
        ['label' => 'Pengaduan & Aspirasi', 'url' => route('complaint.index'), 'keywords' => 'pengaduan aspirasi laporan keluhan'],
    ];
@endphp
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        (function () {
            try {
                var saved = localStorage.getItem('unmaris-theme');
                var dark = saved ? saved === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (dark) document.documentElement.classList.add('dark');
            } catch (error) { /* penyimpanan tidak tersedia */ }
        })();
        window.unmarisHeader = function (links) {
            return {
                links: links || [],
                mobileOpen: false,
                searchOpen: false,
                scrolled: false,
                query: '',
                get filteredLinks() {
                    var q = this.query.trim().toLowerCase();
                    if (!q) return this.links.slice(0, 6);
                    return this.links.filter(function (link) {
                        return (link.label + ' ' + link.keywords).toLowerCase().indexOf(q) !== -1;
                    }).slice(0, 8);
                },
                openSearch: function () {
                    this.mobileOpen = false;
                    this.searchOpen = true;
                    var dialog = this.$refs.searchDialog;
                    if (dialog && !dialog.open) dialog.showModal();
                    this.$nextTick(function () {
                        if (this.$refs.searchInput) this.$refs.searchInput.focus();
                    }.bind(this));
                },
                closeSearch: function () {
                    if (this.$refs.searchDialog) this.$refs.searchDialog.close();
                },
                closeMobile: function () {
                    this.mobileOpen = false;
                    var button = this.$refs.menuButton;
                    if (button) button.focus();
                }
            };
        };
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Universitas Stella Maris Sumba - UNMARIS' }}</title>

    <link rel="icon" href="{{ asset('images/logo-unmaris.png') }}" type="image/png">
    <meta name="theme-color" content="#1B0F52">

    <link rel="preload" href="{{ asset('fonts/public-sans-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('fonts/bricolage-grotesque-latin.woff2') }}" as="font" type="font/woff2" crossorigin>

    <meta name="description" content="{{ $description ?? 'Universitas Stella Maris Sumba, mencetak generasi unggul, berkarakter, dan berdaya saing global di Nusa Tenggara Timur.' }}">
    <meta name="keywords" content="Universitas di Sumba, Kampus Sumba, Stella Maris Sumba, Kuliah di Sumba, UNMARIS">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="author" content="Universitas Stella Maris Sumba">

    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? 'Universitas Stella Maris Sumba' }}">
    <meta property="og:description" content="{{ $description ?? 'Universitas Stella Maris Sumba - Pendidikan Unggul di NTT.' }}">
    <meta property="og:image" content="{{ $ogImage ?? asset('images/logo-unmaris.png') }}">
    <meta property="og:site_name" content="Universitas Stella Maris Sumba">
    <meta property="og:locale" content="id_ID">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

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

<body x-data="unmarisHeader(@js($searchLinks))"
    x-effect="document.documentElement.style.overflow = (mobileOpen || searchOpen) ? 'hidden' : ''"
    @scroll.window.passive="scrolled = window.scrollY > 8"
    @keydown.window="if ((event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k') { event.preventDefault(); openSearch(); }"
    class="flex min-h-screen flex-col bg-canvas font-sans text-body antialiased">

    <a href="#konten-utama" class="skip-link">Lewati ke konten utama</a>

    <!-- Bilah informasi cepat -->
    <div :inert="mobileOpen" class="hidden border-b border-[#d9c000] bg-unmaris-yellow text-[#1b0f52] md:block">
        <div class="container-page flex h-9 items-center justify-between gap-6 text-[11px] font-semibold">
            <p class="flex min-w-0 items-center gap-2">
                <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="truncate" title="{{ $contactAddress }}">{{ $contactAddress }}</span>
            </p>
            <div class="flex shrink-0 items-center gap-5">
                <a href="tel:{{ $contactPhoneLink }}" class="inline-flex items-center gap-2 font-bold underline-offset-4 hover:underline">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    {{ $contactPhone }}
                </a>
                <a href="mailto:{{ $contactEmail }}" class="hidden items-center gap-2 underline-offset-4 hover:underline lg:inline-flex">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    {{ $contactEmail }}
                </a>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header :inert="mobileOpen"
        class="sticky top-0 z-50 border-b border-white/10 bg-[#1b0f52]/95 backdrop-blur-md transition-shadow duration-300"
        :class="scrolled ? 'shadow-[0_16px_40px_-24px_rgba(0,0,0,0.75)]' : ''">
        <nav class="container-page flex h-[70px] items-center justify-between gap-4" aria-label="Navigasi utama">
            <a href="{{ route('home') }}" class="group flex shrink-0 items-center gap-3 rounded-xl py-1">
                <span class="grid h-11 w-11 place-items-center rounded-xl bg-white p-1 shadow-[0_6px_18px_-8px_rgba(0,0,0,0.6)] ring-1 ring-white/20 transition group-hover:ring-unmaris-yellow/60">
                    <img src="{{ asset('images/logo-unmaris.png') }}" alt="Logo Universitas Stella Maris Sumba" width="40" height="40" class="h-full w-full object-contain">
                </span>
                <span class="leading-none">
                    <span class="block font-display text-[22px] font-bold tracking-[-0.03em] text-unmaris-yellow">UNMARIS</span>
                    <span class="mt-1 block text-[8.5px] font-bold uppercase tracking-[0.14em] text-white/55 max-[380px]:hidden">Stella Maris Sumba</span>
                </span>
            </a>

            <div class="hidden items-center gap-0.5 xl:flex">
                @php $berandaAktif = request()->routeIs('home'); @endphp
                <a href="{{ route('home') }}" class="nav-link {{ $berandaAktif ? 'nav-link-active' : '' }}" @if ($berandaAktif) aria-current="page" @endif>Beranda</a>

                @foreach ($navGroups as $group)
                    <x-ui.nav-menu :label="$group['label']" :active="$group['active']">
                        @foreach ($group['links'] as $link)
                            @php $subAktif = request()->routeIs($link['route']); @endphp
                            <a href="{{ route($link['route']) }}" class="nav-item {{ $subAktif ? 'nav-item-active' : '' }}"
                                @if ($subAktif) aria-current="page" @endif>
                                {{ $link['label'] }}
                            </a>
                        @endforeach
                    </x-ui.nav-menu>
                @endforeach
            </div>

            <div class="flex items-center gap-1.5 sm:gap-2">
                <button type="button" @click="openSearch()" aria-haspopup="dialog" aria-controls="dialog-pencarian"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-full px-3 text-sm font-semibold text-white/80 transition hover:bg-white/10 hover:text-unmaris-yellow lg:px-4"
                    aria-label="Buka pencarian situs">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />
                    </svg>
                    <span class="hidden lg:inline">Cari</span>
                    <kbd class="hidden rounded-md border border-white/20 bg-white/10 px-1.5 py-0.5 font-sans text-[10px] font-bold text-white/60 xl:inline">Ctrl K</kbd>
                </button>

                <button type="button" data-theme-toggle
                    class="inline-flex h-11 w-11 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-unmaris-yellow"
                    aria-label="Aktifkan mode gelap" aria-pressed="false" title="Ganti mode terang atau gelap">
                    <svg class="block h-5 w-5 dark:hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                    </svg>
                    <svg class="hidden h-5 w-5 dark:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="12" r="4" />
                        <path stroke-linecap="round" d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3l1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3l1.42-1.42" />
                    </svg>
                </button>

                <a href="https://pmb.unmaris.ac.id" target="_blank" rel="noopener"
                    class="hidden min-h-11 shrink-0 items-center justify-center gap-2 whitespace-nowrap rounded-full bg-unmaris-yellow px-4 text-[11px] font-extrabold uppercase tracking-[0.08em] text-[#1b0f52] shadow-[0_8px_20px_-10px_rgba(245,217,0,0.8)] transition hover:bg-yellow-deep sm:inline-flex sm:px-5">
                    <span class="sm:hidden">PMB</span>
                    <span class="hidden sm:inline">Daftar PMB</span>
                    <svg class="hidden h-4 w-4 sm:block" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>

                <button type="button" x-ref="menuButton" @click="mobileOpen = true; $nextTick(() => $refs.mobileClose.focus())"
                    :aria-expanded="mobileOpen" aria-controls="menu-seluler"
                    class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full text-white transition hover:bg-white/10 xl:hidden"
                    aria-label="Buka menu navigasi">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h10" />
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    <!-- Dialog pencarian -->
    <dialog id="dialog-pencarian" x-ref="searchDialog" @close="searchOpen = false"
        @click="if ($event.target === $refs.searchDialog) closeSearch()"
        aria-labelledby="judul-pencarian"
        class="m-0 mt-[6vh] w-[calc(100%-2rem)] max-w-2xl rounded-3xl border border-line bg-surface p-0 text-body shadow-2xl backdrop:bg-[#0b0720]/75 backdrop:backdrop-blur-sm sm:mx-auto">
        <div class="border-b border-line px-5 py-4 sm:px-6">
            <div class="mb-3 flex items-center justify-between gap-4">
                <h2 id="judul-pencarian" class="flex items-center gap-2 text-sm font-extrabold uppercase tracking-[0.14em] text-brand-ink">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />
                    </svg>
                    Pencarian situs
                </h2>
                <button type="button" @click="closeSearch()"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-full text-muted transition hover:bg-surface-2 hover:text-ink"
                    aria-label="Tutup pencarian">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('news.index') }}" method="GET" role="search" class="flex items-center gap-2">
                <div class="relative flex-1">
                    <label for="pencarian-situs" class="sr-only">Cari berita dan informasi</label>
                    <svg class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-muted" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />
                    </svg>
                    <input id="pencarian-situs" name="search" type="search" x-ref="searchInput" x-model="query"
                        autocomplete="off" placeholder="Cari berita, pengumuman, atau halaman…"
                        class="form-input pl-11 text-base" aria-describedby="petunjuk-pencarian">
                </div>
                <button type="submit" class="btn-primary shrink-0 px-5">Cari</button>
            </form>
            <p id="petunjuk-pencarian" class="mt-2 text-[11px] text-muted">
                Tekan Enter untuk mencari di berita kampus, atau pilih pintasan di bawah.
            </p>
        </div>

        <div class="max-h-[52vh] overflow-y-auto p-3 sm:p-4">
            <p class="px-2 pb-2 text-[10px] font-extrabold uppercase tracking-[0.16em] text-muted"
                x-text="query.trim() ? 'Halaman yang cocok' : 'Pintasan populer'"></p>

            <template x-for="link in filteredLinks" :key="link.url">
                <a :href="link.url" @click="closeSearch()"
                    class="group flex min-h-12 items-center justify-between gap-3 rounded-xl px-3 py-2.5 transition hover:bg-surface-2">
                    <span class="flex items-center gap-3">
                        <span class="grid h-8 w-8 place-items-center rounded-lg bg-unmaris-yellow/15 text-brand-ink">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                        <span class="text-sm font-semibold text-ink" x-text="link.label"></span>
                    </span>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-muted">Buka</span>
                </a>
            </template>

            <div x-show="filteredLinks.length === 0" class="px-3 py-8 text-center" style="display: none;">
                <p class="text-sm font-semibold text-ink">Tidak ada halaman yang cocok.</p>
                <p class="mt-1 text-xs text-muted">Tekan Enter untuk mencari “<span x-text="query"></span>” di berita kampus.</p>
            </div>
        </div>
    </dialog>

    <!-- Menu seluler -->
    <div x-show="mobileOpen" x-cloak class="xl:hidden">
        <div class="fixed inset-0 z-[80] bg-[#0b0720]/70 backdrop-blur-sm" @click="closeMobile()" aria-hidden="true"></div>

        <div id="menu-seluler" role="dialog" aria-modal="true" aria-label="Menu navigasi seluler"
            class="fixed inset-y-0 right-0 z-[90] flex w-full max-w-[420px] flex-col bg-canvas shadow-2xl"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full">

            <div class="flex items-center justify-between border-b border-line px-5 py-4">
                <span class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-white p-1 ring-1 ring-line">
                        <img src="{{ asset('images/logo-unmaris.png') }}" alt="" width="36" height="36" class="h-full w-full object-contain">
                    </span>
                    <span class="leading-tight">
                        <span class="block font-display text-lg font-bold text-brand-ink">UNMARIS</span>
                        <span class="block text-[9px] font-bold uppercase tracking-[0.14em] text-muted">Stella Maris Sumba</span>
                    </span>
                </span>
                <button type="button" x-ref="mobileClose" @click="closeMobile()"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-full text-ink transition hover:bg-surface-2"
                    aria-label="Tutup menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto px-4 py-5" aria-label="Navigasi seluler">
                <a href="{{ route('home') }}"
                    class="mb-1 flex min-h-12 items-center justify-between rounded-xl px-4 py-3 font-display text-lg font-bold {{ request()->routeIs('home') ? 'bg-unmaris-yellow text-[#1b0f52]' : 'text-ink hover:bg-surface-2' }}"
                    @if (request()->routeIs('home')) aria-current="page" @endif>
                    Beranda
                </a>

                @foreach ($navGroups as $group)
                    <details class="group border-b border-line/70 last:border-0">
                        <summary class="flex min-h-12 cursor-pointer list-none items-center justify-between rounded-xl px-4 py-3 font-display text-lg font-bold text-ink transition hover:bg-surface-2 {{ $group['active'] ? 'text-brand-ink' : '' }}">
                            <span>{{ $group['label'] }}</span>
                            <svg class="h-4 w-4 shrink-0 text-muted transition-transform group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="mb-2 space-y-0.5 pb-1 pl-3">
                            @foreach ($group['links'] as $link)
                                @php $subAktif = request()->routeIs($link['route']); @endphp
                                <a href="{{ route($link['route']) }}"
                                    class="flex min-h-11 items-center rounded-lg px-4 py-2.5 text-sm font-semibold transition {{ $subAktif ? 'bg-surface-2 text-brand-ink' : 'text-body hover:bg-surface-2 hover:text-ink' }}"
                                    @if ($subAktif) aria-current="page" @endif>
                                    {{ $link['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </details>
                @endforeach

                <div class="mt-5 rounded-2xl border border-line bg-surface p-4">
                    <p class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-muted">Layanan cepat</p>
                    <div class="mt-3 space-y-1">
                        <a href="tel:{{ $contactPhoneLink }}" class="flex min-h-11 items-center gap-3 rounded-lg text-sm font-semibold text-body hover:text-brand-ink">
                            <svg class="h-4 w-4 text-brand-ink" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $contactPhone }}
                        </a>
                        <a href="mailto:{{ $contactEmail }}" class="flex min-h-11 items-center gap-3 rounded-lg text-sm font-semibold text-body hover:text-brand-ink">
                            <svg class="h-4 w-4 shrink-0 text-brand-ink" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="truncate">{{ $contactEmail }}</span>
                        </a>
                    </div>
                </div>
            </nav>

            <div class="border-t border-line bg-surface p-4">
                <a href="https://pmb.unmaris.ac.id" target="_blank" rel="noopener"
                    class="flex min-h-12 w-full items-center justify-center gap-2 rounded-full bg-unmaris-yellow px-6 text-sm font-extrabold uppercase tracking-wider text-[#1b0f52] shadow-lg transition hover:bg-yellow-deep">
                    Daftar Mahasiswa Baru
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Konten utama -->
    <main id="konten-utama" tabindex="-1" :inert="mobileOpen" class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer :inert="mobileOpen" class="mt-auto">
        <!-- Ajakan PMB -->
        <section class="relative overflow-hidden bg-unmaris-yellow text-[#1b0f52]" aria-labelledby="cta-pmb-footer">
            <div class="pointer-events-none absolute inset-0 opacity-[0.16]" aria-hidden="true">
                <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <polygon fill="currentColor" points="100,100 0,0 100,0" />
                </svg>
            </div>
            <div class="container-page relative z-10 flex flex-col gap-6 py-10 md:flex-row md:items-center md:justify-between md:py-12">
                <div class="max-w-2xl">
                    <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.2em] text-[#1b0f52]/70">Penerimaan Mahasiswa Baru</p>
                    <h2 id="cta-pmb-footer" class="font-display text-3xl font-bold leading-[1.05] tracking-tight md:text-4xl">
                        Mulai langkahmu di UNMARIS. Bangun masa depan dari Sumba.
                    </h2>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row md:shrink-0">
                    <a href="https://pmb.unmaris.ac.id" target="_blank" rel="noopener"
                        class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-[#1b0f52] px-6 text-sm font-bold text-white transition hover:bg-[#28166f]">
                        Daftar Sekarang
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                    <a href="{{ route('contact') }}"
                        class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-[#1b0f52]/30 px-6 text-sm font-bold text-[#1b0f52] transition hover:border-[#1b0f52] hover:bg-[#1b0f52]/5">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </section>

        <div class="relative overflow-hidden bg-[#100a2e] text-white/70">
            <div class="pointer-events-none absolute inset-0 opacity-[0.05]" aria-hidden="true">
                <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <polygon fill="currentColor" points="0,100 100,0 100,100" />
                </svg>
            </div>

            <div class="container-page relative z-10 pb-8 pt-14 md:pt-16">
                <div class="grid grid-cols-1 gap-10 md:grid-cols-2 xl:grid-cols-[1.4fr_1fr_1fr_1.2fr] xl:gap-10">
                    <div>
                        <a href="{{ route('home') }}" class="mb-5 inline-flex items-center gap-3 rounded-xl">
                            <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-white p-1">
                                <img src="{{ asset('images/logo-unmaris.png') }}" alt="Logo Universitas Stella Maris Sumba" width="48" height="48" class="h-full w-full object-contain">
                            </span>
                            <span class="font-display text-xl font-bold leading-tight text-unmaris-yellow">Universitas Stella Maris<br>Sumba</span>
                        </a>
                        <p class="mb-6 max-w-sm text-sm leading-relaxed text-white/60">
                            Membangun peradaban Sumba dan kawasan Timur Indonesia melalui pendidikan tinggi yang berkualitas, berkarakter, dan berdaya saing global.
                        </p>
                        <div class="flex flex-wrap gap-x-5 gap-y-2 text-sm">
                            <a href="{{ route('profile') }}" class="footer-link">Tentang UNMARIS</a>
                            <a href="{{ route('news.index') }}" class="footer-link">Berita Kampus</a>
                            <a href="{{ route('announcements.index') }}" class="footer-link">Pengumuman</a>
                        </div>
                    </div>

                    <div>
                        <h3 class="footer-heading">Akademik</h3>
                        <ul class="space-y-1">
                            <li><a href="{{ route('faculties.index') }}" class="footer-link">Fakultas &amp; Program Studi</a></li>
                            <li><a href="{{ route('akademik.sistem') }}" class="footer-link">Sistem Pembelajaran</a></li>
                            <li><a href="{{ route('akademik.unduhan') }}" class="footer-link">Pusat Unduhan</a></li>
                            <li><a href="{{ route('lppm.profil') }}" class="footer-link">Penelitian &amp; Pengabdian</a></li>
                            <li><a href="{{ route('lppm.publikasi') }}" class="footer-link">Publikasi Ilmiah</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="footer-heading">Layanan</h3>
                        <ul class="space-y-1">
                            <li><a href="{{ route('complaint.index') }}" class="footer-link">Pengaduan &amp; Aspirasi</a></li>
                            <li><a href="{{ route('facilities.index') }}" class="footer-link">Fasilitas Kampus</a></li>
                            <li><a href="{{ route('scholarships.index') }}" class="footer-link">Informasi Beasiswa</a></li>
                            <li><a href="{{ route('organizations.index') }}" class="footer-link">Organisasi Mahasiswa</a></li>
                            <li><a href="{{ route('kemahasiswaan.statistik') }}" class="footer-link">Statistik Mahasiswa</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="footer-heading">Kontak</h3>
                        <address class="space-y-4 text-sm not-italic text-white/65">
                            <p class="flex items-start gap-3">
                                <svg class="mt-0.5 h-5 w-5 shrink-0 text-unmaris-yellow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $contactAddress }}</span>
                            </p>
                            <p class="flex items-center gap-3">
                                <svg class="h-5 w-5 shrink-0 text-unmaris-yellow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <a href="mailto:{{ $contactEmail }}" class="footer-link">{{ $contactEmail }}</a>
                            </p>
                            <p class="flex items-center gap-3">
                                <svg class="h-5 w-5 shrink-0 text-unmaris-yellow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <a href="tel:{{ $contactPhoneLink }}" class="footer-link">{{ $contactPhone }}</a>
                            </p>
                        </address>
                        <a href="https://pmb.unmaris.ac.id" target="_blank" rel="noopener"
                            class="mt-5 inline-flex min-h-11 items-center gap-2 text-sm font-bold text-unmaris-yellow transition hover:text-white">
                            Portal PMB UNMARIS
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H8m9 0v9" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="mt-12 flex flex-col items-center justify-between gap-3 border-t border-white/10 pt-6 text-xs text-white/45 md:flex-row">
                    <p>&copy; {{ date('Y') }} Universitas Stella Maris Sumba (UNMARIS). Hak cipta dilindungi.</p>
                    <div class="flex flex-wrap items-center justify-center gap-x-5 gap-y-1">
                        <a href="{{ route('contact') }}" class="footer-link text-xs">Hubungi Kami</a>
                        <a href="{{ route('complaint.index') }}" class="footer-link text-xs">Pengaduan</a>
                        <a href="#konten-utama" class="inline-flex min-h-11 items-center gap-1.5 text-xs font-semibold text-white/60 transition hover:text-unmaris-yellow">
                            Kembali ke atas
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bantuan WhatsApp -->
    <div x-data="{ waOpen: false, showTooltip: false }"
        x-init="setTimeout(() => showTooltip = true, 5000); setTimeout(() => showTooltip = false, 15000)"
        :inert="mobileOpen" x-show="!mobileOpen"
        class="fixed bottom-5 right-4 z-[100] flex flex-col items-end sm:bottom-6 sm:right-6">

        <div role="dialog" aria-label="Bantuan WhatsApp" x-show="showTooltip && !waOpen" x-cloak
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-3"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute bottom-2 right-full mr-3 cursor-pointer rounded-2xl border border-line bg-surface px-4 py-3 text-sm font-bold text-ink shadow-2xl transition-colors hover:bg-surface-2">
            <button type="button" @click="waOpen = true; showTooltip = false" class="flex items-center gap-2 text-left">
                <span class="text-lg" aria-hidden="true">👋</span> Ada yang bisa dibantu?
            </button>
            <span class="absolute -right-1.5 top-1/2 h-3 w-3 -translate-y-1/2 rotate-45 border-r border-t border-line bg-surface" aria-hidden="true"></span>
        </div>

        <div role="dialog" aria-modal="true" aria-label="Menu kontak WhatsApp UNMARIS" x-show="waOpen" x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            @click.away="waOpen = false"
            class="mb-3 w-[min(320px,calc(100vw-2rem))] origin-bottom-right overflow-hidden rounded-2xl border border-line bg-surface shadow-2xl">

            <div class="relative overflow-hidden bg-[#100a2e] p-5 text-white">
                <div class="absolute -right-4 -top-4 h-16 w-16 rounded-full bg-unmaris-yellow/20 blur-xl"></div>
                <div class="relative z-10 flex items-center gap-3">
                    <div class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-unmaris-yellow text-[#1b0f52]">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-display text-base font-bold text-white">Halo! Ada yang bisa dibantu?</h2>
                        <p class="mt-0.5 text-[11px] text-white/60">Tim kami akan segera merespons Anda.</p>
                    </div>
                </div>
            </div>

            <div class="space-y-2 bg-surface p-3">
                <a aria-label="Chat WhatsApp dengan Admin Pendaftaran PMB"
                    href="https://wa.me/6281216156883?text=Halo%20Admin%20PMB%20UNMARIS,%20saya%20ingin%20bertanya%20seputar%20informasi%20pendaftaran%20mahasiswa%20baru."
                    target="_blank" rel="noopener"
                    class="group flex min-h-14 items-center gap-3 rounded-xl border border-line p-3 transition hover:border-line-strong hover:bg-surface-2">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-unmaris-yellow/15 text-brand-ink transition-colors group-hover:bg-[#25D366] group-hover:text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </span>
                    <span>
                        <span class="block text-sm font-bold text-ink">Admin Pendaftaran (PMB)</span>
                        <span class="block text-[10px] text-muted">Info pendaftaran &amp; beasiswa</span>
                    </span>
                </a>

                <a aria-label="Chat WhatsApp dengan Admin Akademik"
                    href="https://wa.me/6285239803210?text=Halo%20Admin%20Akademik%20UNMARIS,%20saya%20ingin%20bertanya%20seputar%20perkuliahan%20dan%20fakultas."
                    target="_blank" rel="noopener"
                    class="group flex min-h-14 items-center gap-3 rounded-xl border border-line p-3 transition hover:border-line-strong hover:bg-surface-2">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-unmaris-blue/10 text-brand-ink transition-colors group-hover:bg-[#25D366] group-hover:text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </span>
                    <span>
                        <span class="block text-sm font-bold text-ink">Admin Akademik</span>
                        <span class="block text-[10px] text-muted">Info jadwal &amp; sistem kuliah</span>
                    </span>
                </a>
            </div>
        </div>

        <button type="button" aria-label="Buka chat WhatsApp bantuan UNMARIS" title="Hubungi kami via WhatsApp"
            :aria-expanded="waOpen" @click="waOpen = !waOpen; showTooltip = false"
            class="relative grid h-14 w-14 place-items-center rounded-full bg-[#25D366] text-white shadow-[0_12px_34px_rgba(37,211,102,0.4)] transition duration-300 hover:scale-105 hover:bg-[#20bd5a] focus-visible:outline focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#1b0f52] md:h-15 md:w-15">
            <span class="absolute right-0 top-0 flex h-4 w-4" x-show="! waOpen">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex h-4 w-4 rounded-full border-2 border-white bg-red-500"></span>
            </span>

            <svg x-show="! waOpen" class="relative z-10 h-7 w-7" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>

            <svg x-show="waOpen" x-cloak class="relative z-10 h-6 w-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    @livewireScripts
    <script>
        (function () {
            var root = document.documentElement;
            var toggles = document.querySelectorAll('[data-theme-toggle]');

            function sync() {
                var dark = root.classList.contains('dark');
                toggles.forEach(function (button) {
                    button.setAttribute('aria-pressed', dark ? 'true' : 'false');
                    button.setAttribute('aria-label', dark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap');
                });
            }

            toggles.forEach(function (button) {
                button.addEventListener('click', function () {
                    var dark = root.classList.toggle('dark');
                    try { localStorage.setItem('unmaris-theme', dark ? 'dark' : 'light'); } catch (error) { /* abaikan */ }
                    sync();
                });
            });

            document.addEventListener('livewire:navigated', sync);
            sync();
        })();
    </script>
    @stack('scripts')
</body>

</html>
