@php
    $prodiCount = $faculty->studyPrograms->count();
    $degrees = $faculty->studyPrograms->pluck('degree')->filter()->unique()->sort()->implode(' / ');
    $phoneLink = preg_replace('/[^0-9+]/', '', $faculty->phone ?? '');
    $emailParts = array_pad(explode('@', (string) $faculty->email, 2), 2, null);
    $metaDescription = \Illuminate\Support\Str::limit(strip_tags($faculty->description ?? ''), 155);
    $accreditedCount = $faculty->studyPrograms->whereNotNull('accreditation')->where('accreditation', '!=', '')->count();
@endphp

<x-layouts.app
    :title="$faculty->name . ' - Fakultas UNMARIS'"
    :description="$metaDescription ?: 'Profil fakultas, program studi, struktur organisasi, dan dokumen resmi ' . $faculty->name . ' Universitas Stella Maris Sumba.'"
>
    <x-ui.page-hero :title="$faculty->name" eyebrow="Profil Fakultas" :description="$faculty->description"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Fakultas & Program Studi', 'url' => route('faculties.index')],
            ['label' => $faculty->name],
        ]">
        <span class="chip">
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            {{ $prodiCount }} Program Studi
        </span>
        @if ($degrees)
            <span class="chip">Jenjang {{ $degrees }}</span>
        @endif
        @if ($accreditedCount > 0)
            <span class="chip">
                <span class="h-1.5 w-1.5 rounded-full bg-leaf"></span>
                {{ $accreditedCount }} Prodi Terakreditasi
            </span>
        @endif
    </x-ui.page-hero>

    <!-- Info singkat -->
    <section class="relative z-20 bg-canvas" aria-label="Informasi singkat fakultas">
        <div class="container-page -mt-7 md:-mt-9">
            <div class="grid gap-3 sm:grid-cols-3 sm:gap-4">
                <div class="flex items-center gap-3 rounded-2xl border border-line bg-surface p-4 shadow-[var(--shadow-soft)] sm:p-5">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-unmaris-yellow text-[#1b0f52]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Program Studi</p>
                        <p class="font-display text-xl font-bold leading-tight text-ink">{{ $prodiCount }}</p>
                    </div>
                </div>

                @if ($faculty->email)
                    <a href="mailto:{{ $faculty->email }}"
                        class="focus-navy group flex min-w-0 items-center gap-3 rounded-2xl border border-line bg-surface p-4 shadow-[var(--shadow-soft)] transition hover:border-unmaris-blue sm:p-5">
                        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-surface-2 text-brand-ink transition group-hover:bg-unmaris-blue group-hover:text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Email</p>
                            <p class="truncate text-[13px] font-bold text-ink">
                                @if ($emailParts[1]){{ $emailParts[0] }}@<wbr>{{ $emailParts[1] }}@else{{ $faculty->email }}@endif
                            </p>
                        </div>
                    </a>
                @endif

                @if ($faculty->phone)
                    <a href="tel:{{ $phoneLink }}"
                        class="focus-navy group flex min-w-0 items-center gap-3 rounded-2xl border border-line bg-surface p-4 shadow-[var(--shadow-soft)] transition hover:border-unmaris-blue sm:p-5">
                        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-surface-2 text-brand-ink transition group-hover:bg-unmaris-blue group-hover:text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Telepon / WA</p>
                            <p class="truncate text-[13px] font-bold text-ink">{{ $faculty->phone }}</p>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </section>

    <!-- Visi, misi, dan kontak -->
    <section class="section-y bg-canvas">
        <div class="container-page">
            <div class="grid gap-6 lg:grid-cols-3 lg:gap-8">
                <div class="space-y-6 lg:col-span-2">
                    @if ($faculty->vision)
                        <article class="overflow-hidden rounded-3xl border border-line bg-surface shadow-[var(--shadow-soft)]">
                            <div class="border-l-4 border-unmaris-yellow p-6 sm:p-8">
                                <div class="mb-4 flex items-center gap-3">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-unmaris-yellow text-[#1b0f52]">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </span>
                                    <h2 class="heading-3">Visi Fakultas</h2>
                                </div>
                                <div class="prose-unmaris text-sm sm:text-base">
                                    {!! $faculty->vision !!}
                                </div>
                            </div>
                        </article>
                    @endif

                    @if ($faculty->mission)
                        <article class="overflow-hidden rounded-3xl border border-line bg-surface shadow-[var(--shadow-soft)]">
                            <div class="border-l-4 border-unmaris-blue p-6 sm:p-8">
                                <div class="mb-4 flex items-center gap-3">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-surface-2 text-brand-ink">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </span>
                                    <h2 class="heading-3">Misi Fakultas</h2>
                                </div>
                                <div class="prose-unmaris text-sm sm:text-base">
                                    {!! $faculty->mission !!}
                                </div>
                            </div>
                        </article>
                    @endif

                    @if (! $faculty->vision && ! $faculty->mission)
                        <x-ui.empty-state title="Profil fakultas belum lengkap"
                            description="Visi dan misi fakultas belum dipublikasikan. Silakan hubungi fakultas untuk informasi lebih lanjut." />
                    @endif
                </div>

                <aside class="space-y-5 sm:space-y-6">
                    @if ($faculty->email || $faculty->phone)
                        <div class="relative overflow-hidden rounded-3xl bg-navy-deep p-6 text-white shadow-[var(--shadow-soft)] md:p-7">
                            <div class="pointer-events-none absolute inset-0 hero-grid opacity-60" aria-hidden="true"></div>
                            <div class="relative">
                                <h2 class="font-display text-xl font-bold text-white">Hubungi Fakultas</h2>
                                <p class="mt-1.5 text-xs leading-relaxed text-white/60">
                                    Silakan hubungi kami untuk informasi akademik dan layanan fakultas.
                                </p>

                                <ul class="mt-5 space-y-2.5">
                                    @if ($faculty->email)
                                        <li>
                                            <a href="mailto:{{ $faculty->email }}" class="focus-navy flex items-start gap-3 rounded-2xl bg-white/5 p-3 transition hover:bg-white/10">
                                                <svg class="mt-0.5 h-5 w-5 shrink-0 text-unmaris-yellow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <span class="min-w-0">
                                                    <span class="block text-[9px] font-extrabold uppercase tracking-[0.14em] text-white/45">Email Resmi</span>
                                                    <span class="mt-0.5 block break-all text-sm font-semibold text-white">{{ $faculty->email }}</span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif

                                    @if ($faculty->phone)
                                        <li>
                                            <a href="tel:{{ $phoneLink }}" class="focus-navy flex items-start gap-3 rounded-2xl bg-white/5 p-3 transition hover:bg-white/10">
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
                            </div>
                        </div>
                    @endif

                    <div class="card p-6">
                        <p class="eyebrow">Penerimaan Mahasiswa Baru</p>
                        <h2 class="mt-3 heading-3">Tertarik bergabung?</h2>
                        <p class="mt-2 text-sm leading-relaxed text-body">
                            Daftarkan dirimu dan mulai perjalanan akademik bersama {{ $faculty->name }}.
                        </p>
                        <a href="https://pmb.unmarissumba.ac.id" target="_blank" rel="noopener" class="btn-primary mt-4 w-full">
                            Daftar PMB
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- Struktur organisasi -->
    @if ($faculty->struktur_organisasi)
        <section class="border-y border-line bg-surface py-14 md:py-20" aria-labelledby="struktur-heading">
            <div class="container-page">
                <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div class="max-w-2xl">
                        <span class="eyebrow mb-3">Tata Kelola</span>
                        <h2 id="struktur-heading" class="heading-2">Struktur Organisasi</h2>
                        <p class="mt-3 text-sm leading-relaxed text-body">Bagan struktur organisasi {{ $faculty->name }}.</p>
                    </div>
                    <a href="{{ asset('storage/' . $faculty->struktur_organisasi) }}" target="_blank" rel="noopener" class="btn-outline btn-sm self-start sm:self-auto">
                        Buka ukuran penuh
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>

                <div class="overflow-hidden rounded-3xl border border-line bg-surface-2 p-2 shadow-[var(--shadow-soft)] sm:p-4">
                    <div class="overflow-x-auto rounded-2xl bg-surface">
                        <img src="{{ asset('storage/' . $faculty->struktur_organisasi) }}"
                            alt="Bagan struktur organisasi {{ $faculty->name }}" width="1600" height="1000" loading="lazy"
                            class="h-auto w-full min-w-[640px]">
                    </div>
                </div>
                <p class="mt-3 text-center text-[11px] text-muted sm:hidden">Geser gambar ke samping untuk melihat bagan secara lengkap.</p>
            </div>
        </section>
    @endif

    <!-- Dokumen fakultas -->
    @if ($faculty->document_path)
        <section class="bg-canvas py-12 md:py-16" aria-labelledby="dokumen-heading">
            <div class="container-page">
                <div class="rounded-3xl border border-line bg-surface p-6 shadow-[var(--shadow-soft)] md:p-8">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                        <span class="grid h-14 w-14 shrink-0 place-items-center rounded-2xl bg-unmaris-yellow text-[#1b0f52] sm:h-16 sm:w-16">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </span>

                        <div class="min-w-0 flex-grow">
                            <p class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Dokumen Resmi (PDF)</p>
                            <h2 id="dokumen-heading" class="mt-1 font-display text-lg font-bold leading-snug text-ink sm:text-xl">
                                {{ $faculty->document_title ?: 'Dokumen Struktur Organisasi dan Tata Kelola (SOTK)' }}
                            </h2>
                            <p class="mt-1 text-sm text-muted">{{ $faculty->name }}</p>
                        </div>

                        <a href="{{ asset('storage/' . $faculty->document_path) }}" target="_blank" rel="noopener" download class="btn-navy w-full shrink-0 sm:w-auto">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh Dokumen
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Program studi -->
    <section class="border-t border-line bg-canvas py-14 md:py-20" aria-labelledby="program-studi-heading">
        <div class="container-page">
            <div class="mb-8 flex flex-col gap-4 sm:mb-10 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <span class="eyebrow mb-3">Pilihan Studi</span>
                    <h2 id="program-studi-heading" class="heading-2">Program Studi</h2>
                    <p class="mt-3 text-sm leading-relaxed text-body md:text-base">
                        Pilih program studi yang paling sesuai dengan minat dan rencana kariermu.
                    </p>
                </div>
                <span class="chip self-start lg:self-auto">
                    <span class="h-1.5 w-1.5 rounded-full bg-unmaris-yellow"></span>
                    {{ $prodiCount }} Program Studi
                </span>
            </div>

            @if ($faculty->studyPrograms->isEmpty())
                <x-ui.empty-state title="Belum ada program studi"
                    description="Informasi program studi untuk fakultas ini belum tersedia." />
            @else
                <div class="grid grid-cols-1 gap-5 lg:grid-cols-2 lg:gap-6">
                    @foreach ($faculty->studyPrograms as $prodi)
                        @php
                            $accr = $prodi->accreditation;
                            $accrClass = in_array($accr, ['Unggul', 'A'], true)
                                ? 'border-leaf/30 bg-leaf/10 text-leaf'
                                : (in_array($accr, ['Baik Sekali', 'B'], true)
                                    ? 'border-unmaris-yellow/60 bg-unmaris-yellow/20 text-brand-ink'
                                    : 'border-line bg-surface-2 text-body');
                        @endphp
                        <article x-data="{ tab: 'visi' }"
                            class="flex h-full flex-col overflow-hidden rounded-3xl border border-line bg-surface shadow-[var(--shadow-soft)]">
                            <div class="p-6">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="rounded-lg bg-unmaris-blue px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-[0.08em] text-unmaris-yellow">
                                        {{ $prodi->degree }}
                                    </span>
                                    @if ($accr)
                                        <span class="rounded-lg border px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-[0.08em] {{ $accrClass }}">
                                            Akreditasi {{ $accr }}
                                        </span>
                                    @endif
                                </div>

                                <h3 class="mt-3 font-display text-lg font-bold leading-snug text-ink sm:text-xl">
                                    <a href="{{ route('prodi.detail', [$faculty->slug, $prodi->slug]) }}" class="focus-navy rounded transition hover:text-brand-ink">
                                        {{ $prodi->name }}
                                    </a>
                                </h3>

                                @if ($prodi->description)
                                    <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-body">{{ $prodi->description }}</p>
                                @endif
                            </div>

                            <div class="mt-auto border-t border-line bg-surface-2/60">
                                <div class="grid grid-cols-4 gap-1 p-2" role="tablist" aria-label="Informasi {{ $prodi->name }}">
                                    @foreach (['visi' => 'Visi', 'misi' => 'Misi', 'tujuan' => 'Tujuan', 'karir' => 'Karir'] as $tabKey => $tabLabel)
                                        <button type="button" role="tab" id="tab-{{ $tabKey }}-{{ $prodi->id }}"
                                            aria-controls="panel-{{ $tabKey }}-{{ $prodi->id }}"
                                            @click="tab = '{{ $tabKey }}'" :aria-selected="tab === '{{ $tabKey }}'"
                                            :class="tab === '{{ $tabKey }}' ? 'bg-unmaris-blue text-white shadow-sm' : 'text-body hover:bg-surface hover:text-brand-ink'"
                                            class="min-h-11 rounded-xl px-1 py-2 text-[11px] font-extrabold uppercase tracking-[0.06em] transition-colors focus-navy">
                                            {{ $tabLabel }}
                                        </button>
                                    @endforeach
                                </div>

                                <div class="min-h-[130px] px-4 pb-5 pt-1 sm:px-5">
                                    @foreach (['visi' => $prodi->vision, 'misi' => $prodi->mission, 'tujuan' => $prodi->tujuan, 'karir' => $prodi->career_prospects] as $key => $content)
                                        <div x-show="tab === '{{ $key }}'" x-cloak role="tabpanel"
                                            id="panel-{{ $key }}-{{ $prodi->id }}" aria-labelledby="tab-{{ $key }}-{{ $prodi->id }}"
                                            class="prose-unmaris text-sm">
                                            @if ($content)
                                                {!! $content !!}
                                            @else
                                                <p class="text-xs italic text-muted">Belum ada data {{ $key === 'karir' ? 'prospek karir' : $key }}.</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <a href="{{ route('prodi.detail', [$faculty->slug, $prodi->slug]) }}"
                                    class="focus-navy group flex min-h-12 items-center justify-between gap-2 border-t border-line bg-surface px-4 py-3 text-sm font-bold text-brand-ink transition hover:bg-unmaris-blue hover:text-white sm:px-5">
                                    <span>Lihat profil lengkap</span>
                                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif

            <div class="mt-9 text-center">
                <a href="{{ route('faculties.index') }}" class="btn-outline">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7l-7-7 7-7" />
                    </svg>
                    Lihat semua fakultas
                </a>
            </div>
        </div>
    </section>

    <!-- Ajakan PMB -->
    <section class="relative overflow-hidden bg-unmaris-yellow text-[#1b0f52]" aria-labelledby="cta-fakultas">
        <div class="pointer-events-none absolute inset-0 pattern-dots-navy opacity-60" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/30 blur-3xl" aria-hidden="true"></div>
        <div class="container-page relative z-10 flex flex-col gap-7 py-14 md:flex-row md:items-center md:justify-between md:py-16">
            <div class="max-w-2xl">
                <p class="mb-2 text-[10px] font-extrabold uppercase tracking-[0.2em] opacity-70">Langkah selanjutnya</p>
                <h2 id="cta-fakultas" class="font-display text-3xl font-bold leading-[1.05] tracking-tight md:text-4xl">
                    Siap bergabung dengan {{ $faculty->name }}?
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
                <a href="{{ route('faculties.index') }}"
                    class="inline-flex min-h-12 items-center justify-center rounded-full border border-[#1b0f52]/30 px-6 text-sm font-bold text-[#1b0f52] transition hover:border-[#1b0f52] hover:bg-[#1b0f52]/5">
                    Jelajahi fakultas lain
                </a>
            </div>
        </div>
    </section>
</x-layouts.app>
