<x-layouts.app :title="$page->title . ' - UNMARIS'" :description="$page->meta_description">

    <x-ui.page-hero :title="$page->title" eyebrow="Pusat Informasi Akademik" :description="$page->meta_description"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Akademik', 'url' => route('faculties.index')],
            ['label' => $page->title],
        ]" />

    <section class="section-y bg-canvas">
        <div class="container-page">
            <div class="grid gap-6 lg:grid-cols-12 lg:gap-8">
                <div class="lg:col-span-8">
                    @if (! empty($page->content['umum']))
                        <article class="overflow-hidden rounded-3xl border border-line bg-surface shadow-[var(--shadow-soft)]">
                            <div class="h-1.5 w-full bg-unmaris-yellow" aria-hidden="true"></div>
                            <div class="p-6 sm:p-8 md:p-10">
                                <div class="prose-unmaris max-w-none">
                                    {!! $page->content['umum'] !!}
                                </div>
                            </div>
                        </article>
                    @else
                        <x-ui.empty-state title="Konten belum tersedia"
                            description="Halaman penjelasan sistem pembelajaran sedang dalam tahap penyusunan oleh pihak akademik.">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </x-ui.empty-state>
                    @endif

                    <!-- Layanan akademik terkait -->
                    <div class="mt-6 overflow-hidden rounded-3xl border border-line bg-surface shadow-[var(--shadow-soft)]">
                        <div class="flex flex-col gap-5 p-6 md:flex-row md:items-center md:justify-between md:p-8">
                            <div class="max-w-xl">
                                <span class="eyebrow">Layanan Akademik</span>
                                <h2 class="mt-3 heading-3">Dokumen dan informasi pendukung</h2>
                                <p class="mt-2 text-sm leading-relaxed text-body">
                                    Temukan kalender akademik, jadwal kuliah, buku pedoman, hingga dokumen akreditasi
                                    pada Pusat Unduhan. Untuk pertanyaan lain, tim akademik siap membantu Anda.
                                </p>
                            </div>
                            <div class="flex shrink-0 flex-col gap-2.5 sm:flex-row md:flex-col">
                                <a href="{{ route('akademik.unduhan') }}" class="btn-primary">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Pusat Unduhan
                                </a>
                                <a href="{{ route('contact') }}" class="btn-outline">
                                    Hubungi Akademik
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="space-y-5 sm:space-y-6 lg:col-span-4" aria-labelledby="pintasan-akademik">
                    <div class="card p-6">
                        <div class="mb-4 flex items-center gap-3">
                            <span class="divider-yellow" aria-hidden="true"></span>
                            <h2 id="pintasan-akademik" class="heading-3">Pintasan</h2>
                        </div>

                        <nav aria-label="Pintasan akademik">
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('akademik.sistem') }}"
                                        class="focus-navy group flex min-h-14 items-center gap-3 rounded-xl border border-line bg-surface px-3 py-2.5 transition hover:border-unmaris-blue hover:bg-surface-2"
                                        @if (request()->routeIs('akademik.sistem')) aria-current="page" @endif>
                                        <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-unmaris-yellow text-[#1b0f52]">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </span>
                                        <span class="min-w-0 flex-1 text-sm font-bold leading-snug text-ink">Sistem Pembelajaran</span>
                                        <svg class="h-4 w-4 shrink-0 text-line-strong transition group-hover:translate-x-0.5 group-hover:text-brand-ink" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('akademik.unduhan') }}"
                                        class="focus-navy group flex min-h-14 items-center gap-3 rounded-xl border border-line bg-surface px-3 py-2.5 transition hover:border-unmaris-blue hover:bg-surface-2">
                                        <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-unmaris-blue text-unmaris-yellow">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </span>
                                        <span class="min-w-0 flex-1 text-sm font-bold leading-snug text-ink">Pusat Unduhan</span>
                                        <svg class="h-4 w-4 shrink-0 text-line-strong transition group-hover:translate-x-0.5 group-hover:text-brand-ink" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('lppm.publikasi') }}"
                                        class="focus-navy group flex min-h-14 items-center gap-3 rounded-xl border border-line bg-surface px-3 py-2.5 transition hover:border-unmaris-blue hover:bg-surface-2">
                                        <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-surface-2 text-brand-ink">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </span>
                                        <span class="min-w-0 flex-1 text-sm font-bold leading-snug text-ink">Publikasi Ilmiah</span>
                                        <svg class="h-4 w-4 shrink-0 text-line-strong transition group-hover:translate-x-0.5 group-hover:text-brand-ink" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <div class="relative overflow-hidden rounded-3xl bg-navy-deep p-6 text-white shadow-[var(--shadow-soft)] md:p-7">
                        <div class="pointer-events-none absolute inset-0 hero-grid opacity-60" aria-hidden="true"></div>
                        <div class="pointer-events-none absolute -right-10 -top-10 h-32 w-32 rounded-full bg-unmaris-yellow/20 blur-2xl" aria-hidden="true"></div>
                        <div class="relative">
                            <span class="eyebrow-light mb-3">Butuh Bantuan?</span>
                            <h2 class="font-display text-xl font-bold leading-tight text-white">Layanan akademik siap membantu</h2>
                            <p class="mt-2 text-sm leading-relaxed text-white/65">
                                Sampaikan pertanyaan seputar perkuliahan, dokumen, atau layanan fakultas melalui kanal resmi UNMARIS.
                            </p>
                            <a href="{{ route('contact') }}" class="btn-primary mt-5 w-full">
                                Hubungi Kami
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</x-layouts.app>
