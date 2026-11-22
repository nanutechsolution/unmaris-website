<x-layouts.app title="Jaringan Kemitraan & Kerjasama - UNMARIS"
    description="Daftar instansi, perusahaan, dan universitas yang telah menjalin kerjasama strategis dengan Universitas Stella Maris Sumba.">

    <x-ui.page-hero title="Jaringan Kemitraan" eyebrow="Sinergi & Kolaborasi"
        description="Kami membangun kolaborasi dengan berbagai institusi lintas sektor agar lulusan UNMARIS relevan dengan kebutuhan industri dan masyarakat."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Jaringan Kemitraan'],
        ]">
        <span class="chip">
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
            </svg>
            Kerja Sama Institusi
        </span>
    </x-ui.page-hero>

    <section class="section-y bg-canvas" aria-labelledby="daftar-mitra">
        <div class="container-page">
            @if ($partnersGrouped->isEmpty())
                <x-ui.empty-state title="Daftar mitra belum tersedia"
                    description="Data jaringan kerja sama institusi sedang diperbarui. Silakan hubungi kami untuk informasi kemitraan yang sedang berjalan.">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                    </svg>
                </x-ui.empty-state>

                <div class="mt-6 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('contact') }}" class="btn-primary">Hubungi Tim Kerja Sama</a>
                    <a href="{{ route('profile') }}" class="btn-outline">Profil Universitas</a>
                </div>
            @else
                @php
                    $categoryTitles = [
                        'pemerintah' => 'Pemerintah & Instansi Negara',
                        'kesehatan' => 'Fasilitas Kesehatan & Rumah Sakit',
                        'pendidikan' => 'Institusi Pendidikan Tinggi',
                        'perusahaan' => 'Mitra Industri & Perusahaan',
                        'lainnya' => 'Organisasi & Mitra Strategis Lainnya',
                    ];
                @endphp

                <div class="space-y-14 md:space-y-20">
                    @foreach (['pemerintah', 'kesehatan', 'pendidikan', 'perusahaan', 'lainnya'] as $type)
                        @if ($partnersGrouped->has($type))
                            <section aria-labelledby="mitra-{{ $type }}">
                                <div class="mb-7 flex items-end justify-between gap-4">
                                    <div>
                                        <span class="eyebrow">Kategori Mitra</span>
                                        <h2 id="mitra-{{ $type }}" class="mt-2 heading-2">{{ $categoryTitles[$type] }}</h2>
                                    </div>
                                    <span class="hidden shrink-0 rounded-full border border-line bg-surface px-3 py-1.5 text-[11px] font-bold text-muted sm:inline-flex">
                                        {{ $partnersGrouped[$type]->count() }} mitra
                                    </span>
                                </div>

                                <ul class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                                    @foreach ($partnersGrouped[$type] as $partner)
                                        <li class="group relative flex h-40 flex-col items-center justify-center rounded-2xl border border-line bg-surface p-4 text-center transition duration-300 hover:-translate-y-1 hover:border-unmaris-blue hover:shadow-[var(--shadow-lift)] motion-reduce:transition-none md:h-44">
                                            @if ($partner->website_url)
                                                <a href="{{ $partner->website_url }}" target="_blank" rel="noopener"
                                                    class="absolute inset-0 z-10 rounded-2xl"
                                                    aria-label="Kunjungi situs {{ $partner->name }} (tab baru)"></a>
                                            @endif

                                            <div class="mb-3 flex h-14 w-full items-center justify-center md:h-16">
                                                @if ($partner->logo && Str::startsWith($partner->logo, 'http'))
                                                    <img src="{{ $partner->logo }}" alt="Logo {{ $partner->name }}"
                                                        width="120" height="64" loading="lazy" decoding="async"
                                                        class="max-h-full max-w-full object-contain">
                                                @elseif ($partner->logo)
                                                    <img src="{{ Storage::url($partner->logo) }}" alt="Logo {{ $partner->name }}"
                                                        width="120" height="64" loading="lazy" decoding="async"
                                                        class="max-h-full max-w-full object-contain">
                                                @else
                                                    <span class="grid h-14 w-14 place-items-center rounded-xl bg-unmaris-yellow font-display text-lg font-bold text-[#1b0f52]">
                                                        {{ mb_substr($partner->name, 0, 2) }}
                                                    </span>
                                                @endif
                                            </div>

                                            <h3 class="line-clamp-2 text-[12px] font-bold leading-snug text-body transition group-hover:text-brand-ink md:text-[13px]">
                                                {{ $partner->name }}
                                            </h3>

                                            @if ($partner->website_url)
                                                <span class="mt-1 inline-flex items-center gap-1 text-[10px] font-bold text-muted transition group-hover:text-brand-ink">
                                                    Kunjungi
                                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </section>
                        @endif
                    @endforeach
                </div>
            @endif

            <div class="relative mt-14 overflow-hidden rounded-3xl bg-unmaris-yellow p-8 text-[#1b0f52] md:mt-20 md:p-12">
                <div class="pointer-events-none absolute inset-0 pattern-dots-navy opacity-60" aria-hidden="true"></div>
                <div class="pointer-events-none absolute -right-16 -top-16 h-56 w-56 rounded-full bg-white/30 blur-3xl" aria-hidden="true"></div>
                <div class="relative flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                    <div class="max-w-2xl">
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.2em] opacity-70">Peluang Kolaborasi</p>
                        <h2 class="mt-2 font-display text-3xl font-bold leading-[1.05] tracking-tight md:text-4xl">
                            Tertarik menjadi mitra UNMARIS?
                        </h2>
                        <p class="mt-3 text-sm font-medium leading-relaxed opacity-80 md:text-base">
                            Kami membuka ruang kolaborasi di bidang riset, magang mahasiswa, penyaluran tenaga kerja,
                            hingga pengabdian kepada masyarakat.
                        </p>
                    </div>
                    <a href="{{ route('contact') }}"
                        class="inline-flex min-h-12 shrink-0 items-center justify-center gap-2 rounded-full bg-[#1b0f52] px-6 text-sm font-bold text-white transition hover:bg-[#28166f]">
                        Hubungi Tim Kerja Sama
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
