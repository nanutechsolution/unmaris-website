<x-layouts.app title="Fakultas & Program Studi - UNMARIS"
    description="Jelajahi fakultas dan program studi Universitas Stella Maris Sumba, lengkap dengan informasi akreditasi setiap program.">

    <x-ui.page-hero title="Fakultas & Program Studi" eyebrow="Jalur Pendidikan & Keilmuan"
        description="Temukan program studi pilihanmu di Universitas Stella Maris Sumba. Kami menawarkan berbagai disiplin ilmu yang dirancang untuk menjawab kebutuhan industri dan tantangan global."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Fakultas & Program Studi'],
        ]" />

    <section class="section-y bg-canvas">
        <div class="container-page">
            @if ($faculties->isEmpty())
                <x-ui.empty-state title="Data belum tersedia"
                    description="Saat ini belum ada data fakultas yang dipublikasikan ke dalam sistem.">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </x-ui.empty-state>
            @else
                @php
                    $totalProdi = $faculties->sum(fn ($f) => $f->studyPrograms->count());
                @endphp

                <div class="mb-10 grid grid-cols-2 gap-4 border-b border-line pb-8 sm:grid-cols-3 md:mb-14 md:gap-8">
                    <div>
                        <p class="font-display text-4xl font-bold leading-none text-ink md:text-5xl">{{ $faculties->count() }}</p>
                        <p class="mt-2 text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Fakultas</p>
                    </div>
                    <div>
                        <p class="font-display text-4xl font-bold leading-none text-ink md:text-5xl">{{ $totalProdi }}</p>
                        <p class="mt-2 text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Program Studi</p>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <p class="font-display text-4xl font-bold leading-none text-ink md:text-5xl">
                            {{ $faculties->sum(fn ($f) => $f->studyPrograms->whereNotNull('accreditation')->where('accreditation', '!=', '')->count()) }}
                        </p>
                        <p class="mt-2 text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Prodi Terakreditasi</p>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                    @foreach ($faculties as $faculty)
                        <article class="group flex h-full flex-col overflow-hidden rounded-[2rem] border border-line bg-surface shadow-[var(--shadow-soft)]">
                            <div class="relative overflow-hidden bg-navy-deep px-6 py-7 text-white md:px-8">
                                <div class="pointer-events-none absolute inset-0 hero-grid opacity-60" aria-hidden="true"></div>
                                <div class="pointer-events-none absolute -right-12 -top-12 h-40 w-40 rounded-full bg-unmaris-yellow/15 blur-2xl" aria-hidden="true"></div>

                                <div class="relative flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-unmaris-yellow">
                                            Fakultas {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                        </p>
                                        <h2 class="mt-2 font-display text-2xl font-bold leading-tight text-white md:text-3xl">
                                            <a href="{{ route('faculties.detail', $faculty->slug) }}" class="focus-navy rounded transition-colors hover:text-unmaris-yellow">
                                                {{ $faculty->name }}
                                            </a>
                                        </h2>
                                    </div>
                                    <span class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-white/10 text-unmaris-yellow ring-1 ring-white/15">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0v7m-4-4l4 4 4-4" />
                                        </svg>
                                    </span>
                                </div>

                                <div class="relative mt-5 flex flex-wrap items-center gap-2">
                                    <span class="chip-yellow">{{ $faculty->studyPrograms->count() }} Program Studi</span>
                                    @if ($faculty->phone)
                                        <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-white/60">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            {{ $faculty->phone }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex flex-1 flex-col p-6 md:p-8">
                                @if ($faculty->description)
                                    <p class="line-clamp-3 text-sm leading-relaxed text-body">
                                        {{ $faculty->description }}
                                    </p>
                                @endif

                                <div class="mt-6">
                                    <h3 class="mb-3 flex items-center gap-3 text-[10px] font-extrabold uppercase tracking-[0.16em] text-muted">
                                        Program Studi
                                        <span class="h-px flex-1 bg-line" aria-hidden="true"></span>
                                    </h3>

                                    @if ($faculty->studyPrograms->isEmpty())
                                        <p class="rounded-2xl border border-dashed border-line-strong bg-surface-2 px-4 py-5 text-center text-xs font-medium text-muted">
                                            Belum ada program studi pada fakultas ini.
                                        </p>
                                    @else
                                        <ul class="space-y-2">
                                            @foreach ($faculty->studyPrograms as $prodi)
                                                @php
                                                    $accr = $prodi->accreditation;
                                                    $accrClass = in_array($accr, ['Unggul', 'A'], true)
                                                        ? 'border-leaf/30 bg-leaf/10 text-leaf'
                                                        : (in_array($accr, ['Baik Sekali', 'B'], true)
                                                            ? 'border-unmaris-yellow/60 bg-unmaris-yellow/20 text-brand-ink'
                                                            : 'border-line bg-surface-2 text-body');
                                                @endphp
                                                <li>
                                                    <a href="{{ route('prodi.detail', [$faculty->slug, $prodi->slug]) }}"
                                                        class="focus-navy group/prodi flex min-h-14 items-center gap-3 rounded-xl border border-line bg-surface px-3 py-2.5 transition hover:border-unmaris-blue hover:bg-surface-2">
                                                        <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-unmaris-blue font-display text-[11px] font-bold text-unmaris-yellow">
                                                            {{ $prodi->degree }}
                                                        </span>
                                                        <span class="min-w-0 flex-1 text-sm font-bold leading-snug text-ink transition group-hover/prodi:text-brand-ink">
                                                            {{ $prodi->name }}
                                                        </span>
                                                        @if ($accr)
                                                            <span class="shrink-0 rounded-full border px-2 py-1 text-[9px] font-extrabold uppercase tracking-[0.06em] {{ $accrClass }}">
                                                                {{ $accr }}
                                                            </span>
                                                        @endif
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>

                                <div class="mt-auto flex items-center justify-between gap-3 border-t border-line pt-5 md:mt-7">
                                    <a href="{{ route('faculties.detail', $faculty->slug) }}" class="link-arrow">
                                        Profil fakultas
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </a>
                                    <span class="text-[10px] font-bold uppercase tracking-[0.12em] text-muted">UNMARIS</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="relative overflow-hidden bg-unmaris-yellow text-[#1b0f52]" aria-labelledby="cta-prodi">
        <div class="pointer-events-none absolute inset-0 pattern-dots-navy opacity-60" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/30 blur-3xl" aria-hidden="true"></div>

        <div class="container-page relative z-10 flex flex-col gap-7 py-14 md:flex-row md:items-center md:justify-between md:py-16">
            <div class="max-w-2xl">
                <p class="mb-2 text-[10px] font-extrabold uppercase tracking-[0.2em] opacity-70">Langkah selanjutnya</p>
                <h2 id="cta-prodi" class="font-display text-3xl font-bold leading-[1.05] tracking-tight md:text-4xl">
                    Sudah menemukan program studimu?
                </h2>
                <p class="mt-3 text-sm font-medium leading-relaxed opacity-80 md:text-base">
                    Mari wujudkan cita-cita masa depanmu bersama kampus peradaban, Universitas Stella Maris Sumba.
                </p>
            </div>
            <div class="flex flex-col gap-2.5 sm:flex-row md:shrink-0">
                <a href="https://pmb.unmaris.ac.id" target="_blank" rel="noopener"
                    class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-[#1b0f52] px-6 text-sm font-bold text-white transition hover:bg-[#28166f]">
                    Daftar Mahasiswa Baru
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
                <a href="{{ route('contact') }}"
                    class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-[#1b0f52]/30 px-6 text-sm font-bold text-[#1b0f52] transition hover:border-[#1b0f52] hover:bg-[#1b0f52]/5">
                    Tanya Admin
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
