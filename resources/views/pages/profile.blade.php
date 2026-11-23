<x-layouts.app :title="$page->title . ' - UNMARIS'" :description="$page->meta_description">

    @php
        $hasSambutan = filled($page->content['sambutan'] ?? null);
        $hasVisi = filled($page->content['visi'] ?? null);
        $hasMisi = filled($page->content['misi'] ?? null);
        $hasTujuan = filled($page->content['tujuan'] ?? null);
        $hasKasih = filled($page->content['ciri_khas_kasih'] ?? null);
        $hasSasaran = filled($page->content['sasaran_strategi'] ?? null);
        $hasSejarah = filled($page->content['sejarah'] ?? null);
        $hasStruktur = filled($page->content['struktur_organisasi'] ?? null);
        $hasLeaders = isset($leaders) && $leaders->count() > 0;
        $rektor = $hasLeaders ? $leaders->first() : null;
        $navItems = array_values(array_filter([
            $hasSambutan ? ['id' => 'sambutan', 'label' => 'Sambutan'] : null,
            ($hasVisi || $hasMisi) ? ['id' => 'visi-misi', 'label' => 'Visi & Misi'] : null,
            $hasTujuan ? ['id' => 'tujuan', 'label' => 'Tujuan'] : null,
            $hasKasih ? ['id' => 'ciri-khas', 'label' => 'Ciri Khas KASIH'] : null,
            $hasSasaran ? ['id' => 'sasaran', 'label' => 'Sasaran & Strategi'] : null,
            $hasSejarah ? ['id' => 'sejarah', 'label' => 'Sejarah'] : null,
            ['id' => 'galeri', 'label' => 'Galeri Kampus'],
            ['id' => 'struktur', 'label' => 'Struktur Organisasi'],
            $hasLeaders ? ['id' => 'pimpinan', 'label' => 'Jajaran Pimpinan'] : null,
        ]));
    @endphp

    <x-ui.page-hero :title="$page->title" eyebrow="Tentang Kami" :description="$page->meta_description"
        image="{{ asset('images/campus/depan-1600.jpg') }}"
        image-srcset="{{ asset('images/campus/depan-480.webp') }} 480w, {{ asset('images/campus/depan-960.webp') }} 960w, {{ asset('images/campus/depan-1600.webp') }} 1600w"
        image-alt="Gedung utama Universitas Stella Maris Sumba tampak depan"
        image-position="40% 40%"
        :image-width="1600" :image-height="1066"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => $page->title],
        ]" />

    <section class="section-y bg-canvas">
        <div class="container-page">
            <div class="grid gap-8 lg:grid-cols-12 lg:gap-10">
                <!-- Daftar isi -->
                <aside class="lg:col-span-3" aria-labelledby="daftar-isi-profil">
                    <div class="lg:sticky lg:top-24">
                        <div class="card p-5">
                            <div class="mb-3 flex items-center gap-3">
                                <span class="divider-yellow" aria-hidden="true"></span>
                                <h2 id="daftar-isi-profil" class="text-[11px] font-extrabold uppercase tracking-[0.16em] text-ink">Daftar Isi</h2>
                            </div>

                            <nav aria-label="Bagian profil universitas">
                                <ol class="space-y-1">
                                    @foreach ($navItems as $item)
                                        <li>
                                            <a href="#{{ $item['id'] }}"
                                                class="focus-navy group flex min-h-11 items-center gap-2.5 rounded-xl px-3 text-[13px] font-semibold text-body transition hover:bg-surface-2 hover:text-brand-ink">
                                                <span class="font-display text-[11px] font-bold tabular-nums text-line-strong transition group-hover:text-brand-ink">
                                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                                </span>
                                                {{ $item['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ol>
                            </nav>
                        </div>

                        <div class="relative mt-5 hidden overflow-hidden rounded-3xl bg-navy-deep p-5 text-white lg:block">
                            <div class="pointer-events-none absolute inset-0 hero-grid opacity-60" aria-hidden="true"></div>
                            <div class="relative">
                                <p class="text-[10px] font-extrabold uppercase tracking-[0.18em] text-unmaris-yellow">Kampus Peradaban</p>
                                <p class="mt-2 text-sm leading-relaxed text-white/70">
                                    Universitas Stella Maris Sumba tumbuh dari Sumba dan terbuka untuk dunia.
                                </p>
                                <a href="{{ route('contact') }}" class="btn-primary btn-sm mt-4 w-full">Hubungi Kami</a>
                            </div>
                        </div>
                    </div>
                </aside>

                <div class="space-y-6 lg:col-span-9 lg:space-y-8">
                    @if ($hasSambutan)
                        <section id="sambutan" aria-labelledby="sambutan-heading" class="scroll-mt-28">
                            <article class="overflow-hidden rounded-3xl border border-line bg-surface shadow-[var(--shadow-soft)]">
                                <div class="grid grid-cols-1 sm:grid-cols-[15rem_1fr]">
                                    <div class="relative flex min-h-56 items-center justify-center overflow-hidden bg-navy-deep p-6 sm:min-h-full">
                                        <div class="pointer-events-none absolute inset-0 hero-grid opacity-60" aria-hidden="true"></div>
                                        <div class="pointer-events-none absolute -right-10 -top-10 h-32 w-32 rounded-full bg-unmaris-yellow/20 blur-2xl" aria-hidden="true"></div>

                                        @if ($rektor && $rektor->image)
                                            <img src="{{ Storage::url($rektor->image) }}" alt="Foto {{ $rektor->name }}"
                                                width="240" height="240" loading="lazy"
                                                class="relative h-40 w-40 rounded-2xl border-4 border-white/15 object-cover shadow-xl">
                                        @else
                                            <div class="relative text-center">
                                                <span class="mx-auto grid h-24 w-24 place-items-center rounded-full bg-unmaris-yellow font-display text-3xl font-bold text-[#1b0f52]">
                                                    U
                                                </span>
                                                <p class="mt-4 text-[9px] font-extrabold uppercase tracking-[0.2em] text-unmaris-yellow">UNMARIS</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="p-6 sm:p-8 md:p-10">
                                        <span class="eyebrow">Sambutan Pimpinan</span>
                                        <h2 id="sambutan-heading" class="mt-3 heading-3">Sambutan Plt. Rektor</h2>

                                        <blockquote class="mt-5 border-l-4 border-unmaris-yellow pl-4">
                                            <div class="prose-unmaris text-base italic leading-relaxed text-body md:text-lg">
                                                {!! $page->content['sambutan'] !!}
                                            </div>
                                        </blockquote>

                                        <div class="mt-6 flex items-center gap-3 border-t border-line pt-5">
                                            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-unmaris-yellow font-display text-sm font-bold text-[#1b0f52]" aria-hidden="true">
                                                {{ $rektor ? mb_substr($rektor->name, 0, 1) : 'U' }}
                                            </span>
                                            <div>
                                                <p class="text-sm font-bold text-ink">{{ $rektor ? $rektor->name : 'Pimpinan Universitas Stella Maris Sumba' }}</p>
                                                @if ($rektor && $rektor->position)
                                                    <p class="text-[11px] font-semibold uppercase tracking-[0.1em] text-muted">{{ $rektor->position }}</p>
                                                @else
                                                    <p class="text-[11px] font-semibold uppercase tracking-[0.1em] text-muted">Universitas Stella Maris Sumba</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </section>
                    @endif

                    @if ($hasVisi || $hasMisi)
                        <section id="visi-misi" aria-labelledby="visi-misi-heading" class="scroll-mt-28">
                            <div class="mb-5 flex items-center gap-3">
                                <span class="divider-yellow" aria-hidden="true"></span>
                                <h2 id="visi-misi-heading" class="heading-2">Visi &amp; Misi</h2>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">
                                @if ($hasVisi)
                                    <article class="relative overflow-hidden rounded-3xl bg-navy-deep p-6 text-white shadow-[var(--shadow-soft)] md:p-8">
                                        <div class="pointer-events-none absolute inset-0 hero-grid opacity-60" aria-hidden="true"></div>
                                        <div class="pointer-events-none absolute -right-10 -top-10 h-36 w-36 rounded-full bg-unmaris-yellow/20 blur-2xl" aria-hidden="true"></div>
                                        <div class="relative">
                                            <span class="eyebrow-light">Arah Institusi</span>
                                            <h3 class="mt-3 font-display text-2xl font-bold text-unmaris-yellow">Visi</h3>
                                            <div class="mt-4 text-base leading-relaxed text-white/85">
                                                {!! $page->content['visi'] !!}
                                            </div>
                                        </div>
                                    </article>
                                @endif

                                @if ($hasMisi)
                                    <article class="rounded-3xl border border-line border-l-4 border-l-unmaris-yellow bg-surface p-6 shadow-[var(--shadow-soft)] md:p-8">
                                        <span class="eyebrow">Langkah Strategis</span>
                                        <h3 class="mt-3 heading-3">Misi</h3>
                                        <div class="prose-unmaris mt-4 text-sm">
                                            {!! $page->content['misi'] !!}
                                        </div>
                                    </article>
                                @endif
                            </div>
                        </section>
                    @endif

                    @if ($hasTujuan)
                        <section id="tujuan" aria-labelledby="tujuan-heading" class="scroll-mt-28">
                            <article class="rounded-3xl border border-line bg-surface p-6 shadow-[var(--shadow-soft)] md:p-8">
                                <div class="mb-5 flex items-center gap-3">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-unmaris-yellow text-[#1b0f52]">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                    <h2 id="tujuan-heading" class="heading-2">Tujuan Institusi</h2>
                                </div>
                                <div class="prose-unmaris text-sm md:text-base">
                                    {!! $page->content['tujuan'] !!}
                                </div>
                            </article>
                        </section>
                    @endif

                    @if ($hasKasih)
                        <section id="ciri-khas" aria-labelledby="ciri-khas-heading" class="scroll-mt-28">
                            <article class="overflow-hidden rounded-3xl border border-line bg-surface shadow-[var(--shadow-soft)]">
                                <div class="border-b border-line bg-unmaris-yellow/15 px-6 py-5 md:px-8">
                                    <span class="eyebrow">Identitas Lulusan</span>
                                    <h2 id="ciri-khas-heading" class="mt-2 heading-2">Ciri Khas &ldquo;KASIH&rdquo;</h2>
                                </div>
                                <div class="p-6 md:p-8">
                                    <div class="prose-unmaris text-sm [&_li>strong]:text-base [&_li>strong]:text-brand-ink md:text-base">
                                        {!! $page->content['ciri_khas_kasih'] !!}
                                    </div>
                                </div>
                            </article>
                        </section>
                    @endif

                    @if ($hasSasaran)
                        <section id="sasaran" aria-labelledby="sasaran-heading" class="scroll-mt-28">
                            <article class="relative overflow-hidden rounded-3xl bg-unmaris-blue p-6 text-white shadow-[var(--shadow-soft)] md:p-8">
                                <div class="pointer-events-none absolute inset-0 pattern-dots-light opacity-40" aria-hidden="true"></div>
                                <div class="pointer-events-none absolute -right-16 -top-16 h-48 w-48 rounded-full bg-unmaris-yellow/20 blur-2xl" aria-hidden="true"></div>
                                <div class="relative">
                                    <span class="eyebrow-light">Rencana Kerja</span>
                                    <h2 id="sasaran-heading" class="mt-2 font-display text-2xl font-bold text-unmaris-yellow md:text-3xl">Sasaran &amp; Strategi</h2>
                                    <div class="mt-4 text-sm leading-relaxed text-white/85 md:text-base [&_li]:mb-2 [&_ol]:list-decimal [&_ol]:pl-5 [&_ul]:list-disc [&_ul]:pl-5">
                                        {!! $page->content['sasaran_strategi'] !!}
                                    </div>
                                </div>
                            </article>
                        </section>
                    @endif

                    @if ($hasSejarah)
                        <section id="sejarah" aria-labelledby="sejarah-heading" class="scroll-mt-28">
                            <article class="rounded-3xl border border-line bg-surface p-6 shadow-[var(--shadow-soft)] md:p-8">
                                <div class="mb-4 flex items-center gap-3">
                                    <span class="divider-yellow" aria-hidden="true"></span>
                                    <h2 id="sejarah-heading" class="heading-2">Sejarah Singkat</h2>
                                </div>
                                <div class="prose-unmaris text-sm md:text-base">
                                    {!! $page->content['sejarah'] !!}
                                </div>
                            </article>
                        </section>
                    @endif

                    <section id="galeri" aria-labelledby="galeri-heading" class="scroll-mt-28">
                        <div class="mb-5 flex items-center gap-3">
                            <span class="divider-yellow" aria-hidden="true"></span>
                            <h2 id="galeri-heading" class="heading-2">Galeri Kampus</h2>
                        </div>

                        <figure class="overflow-hidden rounded-3xl border border-line bg-surface shadow-[var(--shadow-soft)]">
                            <picture>
                                <source type="image/webp"
                                    srcset="{{ asset('images/campus/samping-480.webp') }} 480w, {{ asset('images/campus/samping-960.webp') }} 960w, {{ asset('images/campus/samping-1600.webp') }} 1600w"
                                    sizes="(min-width: 1024px) 66vw, 100vw">
                                <img src="{{ asset('images/campus/samping-1600.jpg') }}"
                                    alt="Gedung perkuliahan UNMARIS empat lantai tampak samping"
                                    width="1600" height="874" loading="lazy" decoding="async"
                                    class="w-full object-cover" style="aspect-ratio: 1600 / 874;">
                            </picture>
                            <figcaption class="flex flex-col gap-1 border-t border-line px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                                <span class="text-sm font-semibold text-ink">Gedung perkuliahan empat lantai di Kampus UNMARIS Tambolaka.</span>
                                <span class="text-[11px] font-extrabold uppercase tracking-[0.1em] text-muted">Dokumentasi UNMARIS</span>
                            </figcaption>
                        </figure>
                    </section>

                    <section id="struktur" aria-labelledby="struktur-heading" class="scroll-mt-28">
                        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <span class="eyebrow">Tata Kelola</span>
                                <h2 id="struktur-heading" class="mt-2 heading-2">Struktur Organisasi</h2>
                            </div>
                            @if ($hasStruktur)
                                <a href="{{ Storage::url($page->content['struktur_organisasi']) }}" target="_blank" rel="noopener" class="btn-outline btn-sm self-start sm:self-auto">
                                    Buka ukuran penuh
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            @endif
                        </div>

                        @if ($hasStruktur)
                            <div class="overflow-hidden rounded-3xl border border-line bg-surface-2 p-2 shadow-[var(--shadow-soft)] sm:p-4">
                                <div class="overflow-x-auto rounded-2xl bg-surface">
                                    <img src="{{ Storage::url($page->content['struktur_organisasi']) }}"
                                        alt="Bagan struktur organisasi Universitas Stella Maris Sumba"
                                        width="1600" height="1000" loading="lazy"
                                        class="h-auto w-full min-w-[640px]">
                                </div>
                            </div>
                            <p class="mt-3 text-center text-[11px] text-muted sm:hidden">Geser gambar ke samping untuk melihat bagan secara lengkap.</p>
                        @else
                            <x-ui.empty-state title="Bagan organisasi belum diunggah"
                                description="Bagan struktur organisasi universitas belum dipublikasikan. Silakan periksa kembali secara berkala atau hubungi kami untuk informasi tata kelola.">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </x-ui.empty-state>
                        @endif
                    </section>

                    @if ($hasLeaders)
                        <section id="pimpinan" aria-labelledby="pimpinan-heading" class="scroll-mt-28">
                            <div class="mb-6">
                                <span class="eyebrow">Kepemimpinan</span>
                                <h2 id="pimpinan-heading" class="mt-2 heading-2">Jajaran Pimpinan</h2>
                                <p class="mt-2 max-w-2xl text-sm leading-relaxed text-body">
                                    Pimpinan Universitas Stella Maris Sumba yang berdedikasi membangun generasi penerus bangsa.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach ($leaders as $leader)
                                    <article class="flex h-full flex-col items-center rounded-3xl border border-line bg-surface p-6 text-center shadow-[var(--shadow-soft)]">
                                        @if ($leader->image)
                                            <img src="{{ Storage::url($leader->image) }}" alt="Foto {{ $leader->name }}"
                                                width="160" height="160" loading="lazy"
                                                class="h-28 w-28 rounded-full border-4 border-unmaris-yellow object-cover shadow-md">
                                        @else
                                            <span class="grid h-28 w-28 place-items-center rounded-full bg-unmaris-yellow font-display text-3xl font-bold text-[#1b0f52]">
                                                {{ mb_substr($leader->name, 0, 1) }}
                                            </span>
                                        @endif

                                        <h3 class="mt-5 font-display text-lg font-bold leading-snug text-ink">{{ $leader->name }}</h3>
                                        @if ($leader->position)
                                            <p class="mt-1 text-[11px] font-extrabold uppercase tracking-[0.1em] text-brand-ink">{{ $leader->position }}</p>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
