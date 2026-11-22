<x-layouts.app title="Fasilitas Kampus - UNMARIS"
    description="Lingkungan belajar yang kondusif dan inovatif di Universitas Stella Maris Sumba untuk mendukung pengembangan potensi mahasiswa.">

    <x-ui.page-hero title="Fasilitas Kampus" eyebrow="Lingkungan Belajar"
        description="Lingkungan belajar yang kondusif, modern, dan inovatif untuk mendukung pengembangan potensi mahasiswa secara maksimal."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Fasilitas Kampus'],
        ]">
        <span class="chip">
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            Sarana &amp; Prasarana
        </span>
        <a href="{{ route('contact') }}"
            class="focus-navy inline-flex min-h-11 items-center gap-2 rounded-full border border-line-strong bg-surface px-4 text-[12px] font-bold text-brand-ink transition hover:border-unmaris-blue hover:bg-unmaris-blue hover:text-white">
            Tanya Fasilitas
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </a>
    </x-ui.page-hero>

    <section class="section-y bg-canvas" aria-labelledby="galeri-fasilitas">
        <div class="container-page">
            @if (isset($facilities) && $facilities->count() > 0)
                <x-ui.section-heading eyebrow="Galeri Kampus" title="Fasilitas yang tersedia"
                    description="Sarana dan prasarana yang menunjang kegiatan akademik maupun non-akademik civitas akademika UNMARIS." />

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($facilities as $facility)
                        <article class="group flex h-full flex-col overflow-hidden rounded-3xl border border-line bg-surface shadow-[var(--shadow-soft)] transition duration-300 hover:-translate-y-1 hover:shadow-[var(--shadow-lift)] motion-reduce:transition-none">
                            <div class="relative aspect-[4/3] overflow-hidden bg-navy-deep">
                                @if ($facility->image)
                                    <img src="{{ Storage::url($facility->image) }}"
                                        alt="Fasilitas {{ $facility->name }} Universitas Stella Maris Sumba"
                                        width="640" height="480" loading="lazy" decoding="async"
                                        class="h-full w-full object-cover transition duration-700 group-hover:scale-105 motion-reduce:transition-none">
                                @else
                                    <div class="grid h-full w-full place-items-center">
                                        <div class="pointer-events-none absolute inset-0 hero-grid opacity-60" aria-hidden="true"></div>
                                        <span class="relative grid h-16 w-16 place-items-center rounded-2xl bg-unmaris-yellow text-[#1b0f52]">
                                            <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-1 flex-col p-6">
                                <h2 class="font-display text-xl font-bold leading-snug text-ink">{{ $facility->name }}</h2>
                                <div class="mt-3 h-1 w-10 rounded-full bg-unmaris-yellow" aria-hidden="true"></div>
                                <p class="mt-3 text-sm leading-relaxed text-body">
                                    {{ $facility->description ?? 'Sarana penunjang aktivitas akademik dan non-akademik civitas akademika UNMARIS.' }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <x-ui.empty-state title="Galeri fasilitas belum tersedia"
                    description="Data fasilitas kampus sedang diperbarui oleh tim admin. Silakan kembali lagi nanti atau hubungi kami untuk informasi sarana dan prasarana.">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z" />
                    </svg>
                </x-ui.empty-state>

                <div class="mt-6 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('contact') }}" class="btn-primary">Hubungi Kami</a>
                    <a href="{{ route('faculties.index') }}" class="btn-outline">Lihat Fakultas &amp; Prodi</a>
                </div>
            @endif
        </div>
    </section>

    <section class="border-t border-line bg-surface" aria-labelledby="dukungan-fasilitas">
        <div class="container-page grid gap-8 py-14 md:grid-cols-2 md:items-center md:py-16">
            <div>
                <span class="eyebrow">Lingkungan Belajar</span>
                <h2 id="dukungan-fasilitas" class="mt-3 heading-2">Ruang tumbuh untuk setiap mahasiswa</h2>
                <p class="mt-4 max-w-xl text-sm leading-relaxed text-body md:text-base">
                    UNMARIS menyiapkan lingkungan kampus yang mendukung perkuliahan, diskusi, dan kegiatan
                    kemahasiswaan. Untuk informasi rinci mengenai sarana yang tersedia, silakan hubungi
                    bagian akademik atau kunjungi kampus secara langsung.
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('profile') }}" class="btn-navy">Profil Universitas</a>
                    <a href="{{ route('organizations.index') }}" class="btn-outline">Organisasi Mahasiswa</a>
                </div>
            </div>

            <ul class="grid gap-4 sm:grid-cols-2">
                @foreach ([
                    ['title' => 'Ruang Kuliah', 'text' => 'Ruang kelas untuk kegiatan perkuliahan tatap muka.', 'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0v7'],
                    ['title' => 'Laboratorium', 'text' => 'Sarana praktik pendukung pembelajaran program studi.', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
                    ['title' => 'Perpustakaan', 'text' => 'Akses bahan pustaka dan referensi akademik.', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                    ['title' => 'Kegiatan Mahasiswa', 'text' => 'Ruang berkegiatan bagi organisasi dan komunitas mahasiswa.', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                ] as $item)
                    <li class="rounded-2xl border border-line bg-surface-2/60 p-5">
                        <span class="grid h-10 w-10 place-items-center rounded-xl bg-unmaris-yellow text-[#1b0f52]">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                            </svg>
                        </span>
                        <h3 class="mt-4 text-sm font-bold text-ink">{{ $item['title'] }}</h3>
                        <p class="mt-1 text-[13px] leading-relaxed text-body">{{ $item['text'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
</x-layouts.app>
