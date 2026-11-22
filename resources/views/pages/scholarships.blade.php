<x-layouts.app title="Informasi Beasiswa - UNMARIS"
    description="Daftar peluang beasiswa dan bantuan biaya pendidikan untuk mahasiswa Universitas Stella Maris Sumba.">

    <x-ui.page-hero title="Peluang Beasiswa" eyebrow="Layanan Kemahasiswaan"
        description="Universitas Stella Maris Sumba berkomitmen agar kendala biaya tidak menghalangi mahasiswa meraih cita-cita. Temukan program bantuan yang sesuai untuk Anda."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Beasiswa'],
        ]">
        <span class="chip">
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0121 16.5M12 14v7m-6.16-10.922A12.083 12.083 0 003 16.5" />
            </svg>
            Bantuan Biaya Pendidikan
        </span>
    </x-ui.page-hero>

    <section class="section-y bg-canvas" aria-labelledby="daftar-beasiswa">
        <div class="container-page">
            @if ($scholarships->isEmpty())
                <x-ui.empty-state title="Informasi beasiswa belum tersedia"
                    description="Saat ini belum ada program beasiswa yang dipublikasikan. Silakan periksa kembali secara berkala atau hubungi bagian kemahasiswaan untuk informasi terbaru.">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0v7" />
                    </svg>
                </x-ui.empty-state>

                <div class="mt-6 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('contact') }}" class="btn-primary">Hubungi Kemahasiswaan</a>
                    <a href="{{ route('announcements.index') }}" class="btn-outline">Lihat Pengumuman</a>
                </div>
            @else
                <div class="space-y-6 md:space-y-8">
                    @foreach ($scholarships as $scholarship)
                        <article x-data="{ expanded: false }"
                            class="overflow-hidden rounded-3xl border border-line bg-surface shadow-[var(--shadow-soft)] transition duration-300 hover:shadow-[var(--shadow-lift)]">
                            <div class="border-l-4 {{ $scholarship->is_open ? 'border-l-leaf' : 'border-l-line-strong' }} p-6 md:p-8">
                                <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                                    <div class="min-w-0 flex-grow">
                                        <div class="mb-3 flex flex-wrap items-center gap-2">
                                            <span class="rounded-full bg-unmaris-yellow/20 px-3 py-1 text-[10px] font-extrabold uppercase tracking-[0.1em] text-brand-ink">
                                                {{ $scholarship->provider }}
                                            </span>

                                            @if ($scholarship->is_open)
                                                <span class="inline-flex items-center rounded-full border border-leaf/30 bg-leaf/10 px-3 py-1 text-[10px] font-bold text-leaf">
                                                    <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-leaf"></span>
                                                    Pendaftaran Buka
                                                </span>
                                            @else
                                                <span class="inline-flex items-center rounded-full border border-line bg-surface-2 px-3 py-1 text-[10px] font-bold text-muted">
                                                    <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-muted"></span>
                                                    Pendaftaran Tutup
                                                </span>
                                            @endif
                                        </div>

                                        <h2 class="font-display text-2xl font-bold leading-tight text-ink md:text-3xl">
                                            {{ $scholarship->title }}
                                        </h2>
                                    </div>

                                    @if ($scholarship->end_date)
                                        <div class="shrink-0 rounded-2xl border border-line bg-surface-2 px-4 py-3 text-center md:min-w-32">
                                            <span class="block text-[10px] font-extrabold uppercase tracking-[0.12em] text-muted">Batas Akhir</span>
                                            <span class="mt-1 block font-display text-base font-bold text-brand-ink">
                                                {{ $scholarship->end_date->copy()->locale('id')->translatedFormat('d M Y') }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                @if ($scholarship->description)
                                    <p class="mt-4 text-sm leading-relaxed text-body md:text-base">
                                        {{ $scholarship->description }}
                                    </p>
                                @endif

                                <div class="mt-6 flex flex-col items-stretch gap-3 border-t border-line pt-5 sm:flex-row sm:items-center sm:justify-between">
                                    @if ($scholarship->benefits || $scholarship->requirements)
                                        <button type="button" @click="expanded = !expanded" :aria-expanded="expanded"
                                            class="focus-navy inline-flex min-h-11 items-center justify-center gap-2 rounded-full text-[13px] font-bold text-brand-ink transition hover:text-unmaris-blue">
                                            <span x-text="expanded ? 'Tutup detail persyaratan' : 'Lihat cakupan & persyaratan'"></span>
                                            <svg :class="{ 'rotate-180': expanded }" class="h-4 w-4 transition-transform duration-300 motion-reduce:transition-none" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                    @endif

                                    @if ($scholarship->is_open && $scholarship->registration_url)
                                        <a href="{{ $scholarship->registration_url }}" target="_blank" rel="noopener"
                                            class="btn-primary">
                                            Daftar Sekarang
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </a>
                                    @elseif (! $scholarship->is_open)
                                        <span class="inline-flex min-h-11 items-center justify-center rounded-full border border-line bg-surface-2 px-5 text-[12px] font-bold uppercase tracking-[0.06em] text-muted">
                                            Sudah Berakhir
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div x-show="expanded" x-collapse x-cloak class="border-t border-line bg-surface-2/60 p-6 md:p-8">
                                <div class="grid grid-cols-1 gap-7 md:grid-cols-2">
                                    @if ($scholarship->benefits)
                                        <div>
                                            <div class="mb-4 flex items-center gap-3">
                                                <span class="grid h-9 w-9 place-items-center rounded-lg bg-unmaris-yellow text-[#1b0f52]">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </span>
                                                <h3 class="text-base font-bold text-ink">Cakupan Beasiswa</h3>
                                            </div>
                                            <div class="prose-unmaris text-sm [&_li]:mb-1.5 [&_ul]:list-disc [&_ul]:pl-5">
                                                {!! $scholarship->benefits !!}
                                            </div>
                                        </div>
                                    @endif

                                    @if ($scholarship->requirements)
                                        <div>
                                            <div class="mb-4 flex items-center gap-3">
                                                <span class="grid h-9 w-9 place-items-center rounded-lg bg-unmaris-blue text-unmaris-yellow">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </span>
                                                <h3 class="text-base font-bold text-ink">Persyaratan Utama</h3>
                                            </div>
                                            <div class="prose-unmaris text-sm [&_li]:mb-1.5 [&_ul]:list-disc [&_ul]:pl-5">
                                                {!! $scholarship->requirements !!}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif

            <div class="mt-12 grid gap-4 sm:grid-cols-3">
                @foreach ([
                    ['title' => 'Cek pengumuman resmi', 'text' => 'Informasi pembukaan dan penutupan beasiswa diumumkan melalui kanal resmi kampus.', 'href' => route('announcements.index'), 'label' => 'Pengumuman'],
                    ['title' => 'Konsultasi kemahasiswaan', 'text' => 'Sampaikan pertanyaan mengenai persyaratan dan proses pendaftaran beasiswa.', 'href' => route('contact'), 'label' => 'Hubungi Kami'],
                    ['title' => 'Layanan akademik', 'text' => 'Akses dokumen akademik dan informasi perkuliahan melalui Pusat Unduhan.', 'href' => route('akademik.unduhan'), 'label' => 'Pusat Unduhan'],
                ] as $item)
                    <a href="{{ $item['href'] }}"
                        class="focus-navy group flex h-full flex-col rounded-2xl border border-line bg-surface p-5 transition hover:-translate-y-1 hover:border-unmaris-blue hover:shadow-[var(--shadow-lift)] motion-reduce:transition-none">
                        <span class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">{{ $item['label'] }}</span>
                        <h3 class="mt-2 text-sm font-bold leading-snug text-ink">{{ $item['title'] }}</h3>
                        <p class="mt-2 flex-1 text-[13px] leading-relaxed text-body">{{ $item['text'] }}</p>
                        <span class="mt-4 inline-flex items-center gap-1.5 text-[12px] font-bold text-brand-ink">
                            Selengkapnya
                            <svg class="h-3.5 w-3.5 transition group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
