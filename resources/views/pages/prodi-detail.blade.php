@php
    $phoneLink = preg_replace('/[^0-9+]/', '', $faculty->phone ?? '');
    $emailParts = array_pad(explode('@', (string) $faculty->email, 2), 2, null);
    $otherProdis = $otherProdis ?? collect();
    $edomReports = $prodi->edomReports ?? collect();
    $plainDescription = trim(strip_tags($prodi->description ?? ''));
    $metaDescription = \Illuminate\Support\Str::limit(
        $plainDescription !== '' ? $plainDescription : strip_tags($prodi->vision ?? ''),
        155
    );
    $prodiHasContent = filled($prodi->vision)
        || filled($prodi->mission)
        || filled($prodi->tujuan)
        || filled($prodi->career_prospects)
        || $edomReports->isNotEmpty();
    $accreditation = $prodi->accreditation;
    $accrClass = in_array($accreditation, ['Unggul', 'A'], true)
        ? 'border-leaf/30 bg-leaf/10 text-leaf'
        : (in_array($accreditation, ['Baik Sekali', 'B'], true)
            ? 'border-unmaris-yellow/60 bg-unmaris-yellow/20 text-brand-ink'
            : 'border-line bg-surface-2 text-body');
    $accrDot = in_array($accreditation, ['Unggul', 'A'], true)
        ? 'bg-leaf'
        : (in_array($accreditation, ['Baik Sekali', 'B'], true) ? 'bg-unmaris-yellow' : 'bg-muted');
    $sections = [
        [
            'label' => 'Visi',
            'title' => 'Visi Program Studi',
            'content' => $prodi->vision,
            'empty' => 'Belum ada data visi program studi.',
            'accent' => 'border-unmaris-yellow',
            'iconBg' => 'bg-unmaris-yellow text-[#1b0f52]',
            'iconPath' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
        ],
        [
            'label' => 'Misi',
            'title' => 'Misi Program Studi',
            'content' => $prodi->mission,
            'empty' => 'Belum ada data misi program studi.',
            'accent' => 'border-unmaris-blue',
            'iconBg' => 'bg-surface-2 text-brand-ink',
            'iconPath' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
        ],
        [
            'label' => 'Tujuan',
            'title' => 'Tujuan Program Studi',
            'content' => $prodi->tujuan,
            'empty' => 'Belum ada data tujuan program studi.',
            'accent' => 'border-leaf',
            'iconBg' => 'bg-leaf/10 text-leaf',
            'iconPath' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
    ];
@endphp

<x-layouts.app
    :title="$prodi->name . ' (' . $prodi->degree . ') - ' . $faculty->name . ' | UNMARIS'"
    :description="$metaDescription ?: 'Profil program studi ' . $prodi->name . ' ' . $faculty->name . ' Universitas Stella Maris Sumba: visi, misi, tujuan, dan prospek karir.'"
    :ogImage="$faculty->image ? asset('storage/' . $faculty->image) : null"
>
    @if ($prodi->description || $prodi->vision)
        <script type="application/ld+json">
            {!! json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'EducationalOccupationalProgram',
                'name' => $prodi->name,
                'description' => \Illuminate\Support\Str::limit($plainDescription ?: strip_tags($prodi->vision ?? ''), 300),
                'educationalCredentialAwarded' => $prodi->degree,
                'provider' => [
                    '@type' => 'CollegeOrUniversity',
                    'name' => 'Universitas Stella Maris Sumba',
                    'department' => $faculty->name,
                ],
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
        </script>
    @endif

    <x-ui.page-hero :title="$prodi->name" :eyebrow="'Program Studi · ' . $faculty->name" :description="$prodi->description"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Fakultas & Program Studi', 'url' => route('faculties.index')],
            ['label' => $faculty->name, 'url' => route('faculties.detail', $faculty->slug)],
            ['label' => $prodi->name],
        ]">
        <span class="chip">
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0121 16.5M12 14v7m-6.16-10.922A12.083 12.083 0 003 16.5" />
            </svg>
            Jenjang {{ $prodi->degree }}
        </span>
        @if ($accreditation)
            <span class="chip">
                <span class="h-1.5 w-1.5 rounded-full {{ $accrDot }}"></span>
                Akreditasi {{ $accreditation }}
            </span>
        @endif
        <a href="{{ route('faculties.detail', $faculty->slug) }}"
            class="focus-navy inline-flex min-h-11 items-center gap-2 rounded-full border border-line-strong bg-surface px-4 text-[12px] font-bold text-brand-ink transition hover:border-unmaris-blue hover:bg-unmaris-blue hover:text-white">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            Fakultas induk
        </a>
    </x-ui.page-hero>

    <!-- Informasi singkat -->
    <section class="relative z-20 bg-canvas" aria-label="Informasi singkat program studi">
        <div class="container-page -mt-7 md:-mt-9">
            <div class="grid gap-3 sm:grid-cols-3 sm:gap-4">
                <div class="flex items-center gap-3 rounded-2xl border border-line bg-surface p-4 shadow-[var(--shadow-soft)] sm:p-5">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-unmaris-yellow text-[#1b0f52]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0v7m-4-4l4 4 4-4" />
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Jenjang</p>
                        <p class="font-display text-xl font-bold leading-tight text-ink">{{ $prodi->degree }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 rounded-2xl border border-line bg-surface p-4 shadow-[var(--shadow-soft)] sm:p-5">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-surface-2 text-brand-ink">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Akreditasi</p>
                        @if ($accreditation)
                            <p class="break-words font-display text-xl font-bold leading-tight text-ink">{{ $accreditation }}</p>
                        @else
                            <p class="text-[13px] font-bold text-muted">Belum tersedia</p>
                        @endif
                    </div>
                </div>

                <a href="{{ route('faculties.detail', $faculty->slug) }}"
                    class="focus-navy group flex min-w-0 items-center gap-3 rounded-2xl border border-line bg-surface p-4 shadow-[var(--shadow-soft)] transition hover:border-unmaris-blue sm:p-5">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-surface-2 text-brand-ink transition group-hover:bg-unmaris-blue group-hover:text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Fakultas Induk</p>
                        <p class="truncate text-[13px] font-bold leading-snug text-ink">{{ $faculty->name }}</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Konten prodi & sidebar -->
    <section class="section-y bg-canvas">
        <div class="container-page">
            <div class="grid gap-6 lg:grid-cols-3 lg:gap-8">
                <div class="space-y-5 sm:space-y-6 lg:col-span-2">
                    @foreach ($sections as $section)
                        <article class="overflow-hidden rounded-3xl border border-line bg-surface shadow-[var(--shadow-soft)]">
                            <div class="border-l-4 {{ $section['accent'] }} p-5 sm:p-7 md:p-8">
                                <div class="mb-4 flex items-center gap-3">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl {{ $section['iconBg'] }}">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $section['iconPath'] }}" />
                                        </svg>
                                    </span>
                                    <h2 class="heading-3">{{ $section['title'] }}</h2>
                                </div>
                                @if ($section['content'])
                                    <div class="prose-unmaris text-sm sm:text-base">
                                        {!! $section['content'] !!}
                                    </div>
                                @else
                                    <p class="text-sm italic text-muted">{{ $section['empty'] }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach

                    @if ($prodi->career_prospects)
                        <article class="overflow-hidden rounded-3xl border border-line bg-surface shadow-[var(--shadow-soft)]">
                            <div class="border-l-4 border-unmaris-blue p-5 sm:p-7 md:p-8">
                                <div class="mb-4 flex items-center gap-3">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-unmaris-blue text-unmaris-yellow">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </span>
                                    <h2 class="heading-3">Prospek Karir Lulusan</h2>
                                </div>
                                <div class="prose-unmaris text-sm sm:text-base">
                                    {!! $prodi->career_prospects !!}
                                </div>
                            </div>
                        </article>
                    @endif

                    @if ($edomReports->isNotEmpty())
                        <article class="overflow-hidden rounded-3xl border border-line bg-surface shadow-[var(--shadow-soft)]">
                            <div class="border-l-4 border-unmaris-yellow p-5 sm:p-7 md:p-8">
                                <div class="mb-4 flex items-center gap-3">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-unmaris-yellow text-[#1b0f52]">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </span>
                                    <div>
                                        <h2 class="heading-3">Evaluasi Dosen oleh Mahasiswa (EDOM)</h2>
                                        <p class="mt-1 text-sm leading-relaxed text-body">Riwayat laporan evaluasi dosen program studi {{ $prodi->name }}.</p>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    @foreach ($edomReports as $report)
                                        <div class="flex flex-col gap-3 rounded-2xl border border-line bg-surface-2/60 p-4 sm:flex-row sm:items-center">
                                            <div class="min-w-0 flex-grow">
                                                <p class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">
                                                    {{ $report->period_label ?: 'Dokumen Resmi (PDF)' }}
                                                </p>
                                                <h3 class="mt-1 text-base font-bold leading-snug text-ink">
                                                    {{ $report->title }}
                                                </h3>
                                                @if ($report->description)
                                                    <p class="mt-1 text-sm leading-relaxed text-body">{{ $report->description }}</p>
                                                @endif
                                            </div>

                                            <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank" rel="noopener" download
                                                class="btn-navy btn-sm w-full shrink-0 sm:w-auto">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                Unduh
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </article>
                    @endif

                    @if (! $prodiHasContent)
                        <x-ui.empty-state title="Informasi prodi belum lengkap"
                            description="Visi, misi, tujuan, dan prospek karir program studi ini belum tersedia. Silakan hubungi fakultas untuk informasi lebih lanjut.">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </x-ui.empty-state>
                    @endif
                </div>

                <aside class="space-y-5 sm:space-y-6">
                    @if ($faculty->email || $faculty->phone)
                        <div class="relative overflow-hidden rounded-3xl bg-navy-deep p-6 text-white shadow-[var(--shadow-soft)] md:p-7">
                            <div class="pointer-events-none absolute inset-0 hero-grid opacity-60" aria-hidden="true"></div>
                            <div class="pointer-events-none absolute -right-10 -top-10 h-32 w-32 rounded-full bg-unmaris-yellow/20 blur-2xl" aria-hidden="true"></div>
                            <div class="relative">
                                <h2 class="font-display text-xl font-bold text-white">Hubungi Fakultas</h2>
                                <p class="mt-1.5 text-xs leading-relaxed text-white/60">
                                    Untuk informasi akademik program studi {{ $prodi->name }}, silakan hubungi fakultas.
                                </p>

                                <ul class="mt-5 space-y-2.5">
                                    @if ($faculty->email)
                                        <li>
                                            <a href="mailto:{{ $faculty->email }}"
                                                class="focus-navy flex items-start gap-3 rounded-2xl bg-white/5 p-3 transition hover:bg-white/10">
                                                <svg class="mt-0.5 h-5 w-5 shrink-0 text-unmaris-yellow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <span class="min-w-0">
                                                    <span class="block text-[9px] font-extrabold uppercase tracking-[0.14em] text-white/45">Email Resmi</span>
                                                    <span class="mt-0.5 block break-all text-sm font-semibold text-white">
                                                        @if ($emailParts[1]){{ $emailParts[0] }}@<wbr>{{ $emailParts[1] }}@else{{ $faculty->email }}@endif
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif

                                    @if ($faculty->phone)
                                        <li>
                                            <a href="tel:{{ $phoneLink }}"
                                                class="focus-navy flex items-start gap-3 rounded-2xl bg-white/5 p-3 transition hover:bg-white/10">
                                                <svg class="mt-0.5 h-5 w-5 shrink-0 text-unmaris-yellow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                <span class="min-w-0">
                                                    <span class="block text-[9px] font-extrabold uppercase tracking-[0.14em] text-white/45">Telepon / WhatsApp</span>
                                                    <span class="mt-0.5 block break-words text-sm font-semibold text-white">{{ $faculty->phone }}</span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>

                                <a href="{{ route('faculties.detail', $faculty->slug) }}"
                                    class="focus-navy mt-4 inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-full border border-white/20 px-4 text-sm font-bold text-white transition hover:bg-white/10">
                                    Lihat Profil Fakultas
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endif

                    @if ($otherProdis->isNotEmpty())
                        <div class="card p-6">
                            <p class="eyebrow">Pilihan Lain</p>
                            <h2 class="mt-3 heading-3">Program Studi di {{ $faculty->name }}</h2>

                            <ul class="mt-4 space-y-2">
                                @foreach ($otherProdis as $other)
                                    @php
                                        $otherAccr = $other->accreditation;
                                        $otherAccrClass = in_array($otherAccr, ['Unggul', 'A'], true)
                                            ? 'border-leaf/30 bg-leaf/10 text-leaf'
                                            : (in_array($otherAccr, ['Baik Sekali', 'B'], true)
                                                ? 'border-unmaris-yellow/60 bg-unmaris-yellow/20 text-brand-ink'
                                                : 'border-line bg-surface-2 text-body');
                                    @endphp
                                    <li>
                                        <a href="{{ route('prodi.detail', [$faculty->slug, $other->slug]) }}"
                                            class="focus-navy group flex min-h-14 items-center gap-3 rounded-xl border border-line bg-surface px-3 py-2.5 transition hover:border-unmaris-blue hover:bg-surface-2">
                                            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-unmaris-blue font-display text-[11px] font-bold text-unmaris-yellow">
                                                {{ $other->degree }}
                                            </span>
                                            <span class="min-w-0 flex-1">
                                                <span class="block text-sm font-bold leading-snug text-ink transition group-hover:text-brand-ink">{{ $other->name }}</span>
                                                @if ($otherAccr)
                                                    <span class="mt-1 inline-block rounded-full border px-2 py-0.5 text-[9px] font-extrabold uppercase tracking-[0.06em] {{ $otherAccrClass }}">
                                                        {{ $otherAccr }}
                                                    </span>
                                                @endif
                                            </span>
                                            <svg class="h-4 w-4 shrink-0 text-line-strong transition group-hover:translate-x-0.5 group-hover:text-brand-ink" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card p-6">
                        <p class="eyebrow">Penerimaan Mahasiswa Baru</p>
                        <h2 class="mt-3 heading-3">Tertarik bergabung?</h2>
                        <p class="mt-2 text-sm leading-relaxed text-body">
                            Daftarkan dirimu dan mulai perjalanan akademik di {{ $prodi->name }}.
                        </p>
                        <a href="https://pmb.unmarissumba.ac.id" target="_blank" rel="noopener" class="btn-primary mt-4 w-full">
                            Daftar PMB
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </aside>
            </div>

            <div class="mt-8 text-center sm:mt-10">
                <a href="{{ route('faculties.detail', $faculty->slug) }}" class="btn-outline">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke {{ $faculty->name }}
                </a>
            </div>
        </div>
    </section>

    <!-- Ajakan PMB -->
    <section class="relative overflow-hidden bg-unmaris-yellow text-[#1b0f52]" aria-labelledby="cta-prodi">
        <div class="pointer-events-none absolute inset-0 pattern-dots-navy opacity-60" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/30 blur-3xl" aria-hidden="true"></div>
        <div class="container-page relative z-10 flex flex-col gap-7 py-14 md:flex-row md:items-center md:justify-between md:py-16">
            <div class="max-w-2xl">
                <p class="mb-2 text-[10px] font-extrabold uppercase tracking-[0.2em] opacity-70">Langkah selanjutnya</p>
                <h2 id="cta-prodi" class="font-display text-3xl font-bold leading-[1.05] tracking-tight md:text-4xl">
                    Siap kuliah di {{ $prodi->name }}?
                </h2>
                <p class="mt-3 text-sm font-medium leading-relaxed opacity-80 md:text-base">
                    Wujudkan cita-citamu bersama Universitas Stella Maris Sumba.
                </p>
            </div>
            <div class="flex flex-col gap-2.5 sm:flex-row md:shrink-0">
                <a href="https://pmb.unmarissumba.ac.id" target="_blank" rel="noopener"
                    class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-[#1b0f52] px-6 text-sm font-bold text-white transition hover:bg-[#28166f]">
                    Daftar Mahasiswa Baru
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
                <a href="{{ route('faculties.detail', $faculty->slug) }}"
                    class="inline-flex min-h-12 items-center justify-center rounded-full border border-[#1b0f52]/30 px-6 text-sm font-bold text-[#1b0f52] transition hover:border-[#1b0f52] hover:bg-[#1b0f52]/5">
                    Lihat Fakultas
                </a>
            </div>
        </div>
    </section>
</x-layouts.app>
