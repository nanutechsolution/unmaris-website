<x-layouts.app title="Organisasi Mahasiswa & UKM - UNMARIS"
    description="Kenali berbagai Badan Eksekutif Mahasiswa (BEM), HMPS, dan Unit Kegiatan Mahasiswa (UKM) di Universitas Stella Maris Sumba.">

    <x-ui.page-hero title="Organisasi Mahasiswa" eyebrow="Kehidupan Kampus"
        description="UNMARIS menyediakan wadah bagi mahasiswa untuk mengembangkan jiwa kepemimpinan, bakat, dan kreativitas melalui organisasi kemahasiswaan."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Organisasi Mahasiswa'],
        ]">
        <span class="chip">
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Kemahasiswaan
        </span>
    </x-ui.page-hero>

    <section class="section-y bg-canvas" aria-labelledby="daftar-organisasi">
        <div class="container-page">
            @if ($organizationsGrouped->isEmpty())
                <x-ui.empty-state title="Data organisasi belum tersedia"
                    description="Informasi profil BEM, HMPS, dan UKM sedang dalam tahap pembaruan. Silakan hubungi bagian kemahasiswaan untuk informasi organisasi yang aktif.">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </x-ui.empty-state>

                <div class="mt-8 grid gap-4 md:grid-cols-3">
                    @foreach ([
                        ['title' => 'BEM & DPM', 'text' => 'Lembaga eksekutif dan legislatif mahasiswa tingkat universitas.', 'icon' => 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3'],
                        ['title' => 'HMPS', 'text' => 'Himpunan mahasiswa program studi sebagai wadah pengembangan keilmuan.', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                        ['title' => 'UKM', 'text' => 'Unit kegiatan mahasiswa untuk minat, bakat, dan hobi bersama.', 'icon' => 'M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z'],
                    ] as $item)
                        <div class="rounded-2xl border border-line bg-surface p-5">
                            <span class="grid h-10 w-10 place-items-center rounded-xl bg-unmaris-yellow text-[#1b0f52]">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                </svg>
                            </span>
                            <h2 class="mt-4 text-sm font-bold text-ink">{{ $item['title'] }}</h2>
                            <p class="mt-1.5 text-[13px] leading-relaxed text-body">{{ $item['text'] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('contact') }}" class="btn-primary">Hubungi Kemahasiswaan</a>
                    <a href="{{ route('scholarships.index') }}" class="btn-outline">Informasi Beasiswa</a>
                </div>
            @else
                @php
                    $categoryConfig = [
                        'bem_dpm' => [
                            'title' => 'Lembaga Eksekutif & Legislatif',
                            'subtitle' => 'Organisasi tertinggi mahasiswa tingkat universitas dan fakultas.',
                            'accent' => 'border-t-unmaris-blue',
                        ],
                        'hmps' => [
                            'title' => 'Himpunan Mahasiswa Program Studi',
                            'subtitle' => 'Wadah pengembangan keilmuan sesuai program studi mahasiswa.',
                            'accent' => 'border-t-unmaris-yellow',
                        ],
                        'ukm' => [
                            'title' => 'Unit Kegiatan Mahasiswa (UKM)',
                            'subtitle' => 'Tempat berkumpulnya mahasiswa dengan minat, bakat, dan hobi yang sama.',
                            'accent' => 'border-t-leaf',
                        ],
                    ];
                @endphp

                <div class="space-y-14 md:space-y-20">
                    @foreach (['bem_dpm', 'hmps', 'ukm'] as $type)
                        @if ($organizationsGrouped->has($type))
                            <section aria-labelledby="organisasi-{{ $type }}">
                                <div class="mb-8 text-center">
                                    <span class="eyebrow">Kategori Organisasi</span>
                                    <h2 id="organisasi-{{ $type }}" class="mt-2 heading-2">{{ $categoryConfig[$type]['title'] }}</h2>
                                    <p class="mt-2 text-sm text-body">{{ $categoryConfig[$type]['subtitle'] }}</p>
                                    <div class="mx-auto mt-4 divider-yellow"></div>
                                </div>

                                <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
                                    @foreach ($organizationsGrouped[$type] as $org)
                                        <article class="group flex h-full flex-col overflow-hidden rounded-3xl border border-line border-t-4 bg-surface shadow-[var(--shadow-soft)] transition duration-300 hover:-translate-y-1 hover:shadow-[var(--shadow-lift)] motion-reduce:transition-none {{ $categoryConfig[$type]['accent'] }}">
                                            <div class="flex flex-1 flex-col p-6">
                                                <div class="mb-5 flex items-start gap-4">
                                                    <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-line bg-surface-2 p-2">
                                                        @if ($org->logo)
                                                            @if (Str::startsWith($org->logo, 'http'))
                                                                <img src="{{ $org->logo }}" alt="Logo {{ $org->name }}"
                                                                    width="64" height="64" loading="lazy" decoding="async"
                                                                    class="h-full w-full object-contain">
                                                            @else
                                                                <img src="{{ Storage::url($org->logo) }}" alt="Logo {{ $org->name }}"
                                                                    width="64" height="64" loading="lazy" decoding="async"
                                                                    class="h-full w-full object-contain">
                                                            @endif
                                                        @else
                                                            <span class="grid h-full w-full place-items-center rounded-xl bg-unmaris-yellow font-display text-lg font-bold text-[#1b0f52]">
                                                                {{ mb_substr($org->name, 0, 2) }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="min-w-0 flex-grow pt-1">
                                                        <h3 class="font-display text-lg font-bold leading-tight text-ink transition group-hover:text-brand-ink">
                                                            {{ $org->name }}
                                                        </h3>
                                                        @if ($org->leader_name)
                                                            <span class="mt-2 inline-block rounded-md bg-surface-2 px-2.5 py-1 text-[10px] font-bold text-muted">
                                                                Ketua: {{ $org->leader_name }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if ($org->description)
                                                    <p class="flex-grow text-sm leading-relaxed text-body">{{ $org->description }}</p>
                                                @else
                                                    <p class="flex-grow text-sm italic text-muted">Deskripsi organisasi belum tersedia.</p>
                                                @endif

                                                @if ($org->social_media_link)
                                                    <div class="mt-5 border-t border-line pt-4">
                                                        <a href="{{ $org->social_media_link }}" target="_blank" rel="noopener"
                                                            class="focus-navy inline-flex min-h-11 items-center gap-2 text-xs font-bold text-brand-ink transition hover:text-unmaris-blue">
                                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                                            </svg>
                                                            Kunjungi media sosial
                                                            <svg class="h-3.5 w-3.5 transition group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
