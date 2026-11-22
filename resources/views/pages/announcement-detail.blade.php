@php
    $isAgenda = $announcement->type === 'agenda';
    $plainContent = \Illuminate\Support\Str::squish(strip_tags(preg_replace('/<\/(p|h[1-6]|li|div|blockquote)>|<br\s*\/?>/i', ' ', $announcement->content ?? '')));
    $metaDescription = \Illuminate\Support\Str::limit($plainContent, 155);
    $attachmentExists = $announcement->attachment
        ? \Illuminate\Support\Facades\Storage::disk('public')->exists($announcement->attachment)
        : false;
@endphp

<x-layouts.app :title="$announcement->title . ' - UNMARIS'" :description="$metaDescription">

    <x-ui.page-hero :title="$announcement->title" :eyebrow="$isAgenda ? 'Agenda Acara' : 'Pengumuman Resmi'"
        :description="$metaDescription"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Pengumuman & Agenda', 'url' => route('announcements.index')],
            ['label' => Str::limit($announcement->title, 40)],
        ]">
        <span class="chip">
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <time datetime="{{ $announcement->start_date->toDateString() }}">
                {{ $announcement->start_date->copy()->locale('id')->translatedFormat('d F Y') }}
            </time>
            @if ($announcement->end_date && $announcement->end_date->ne($announcement->start_date))
                <span aria-hidden="true">–</span>
                <time datetime="{{ $announcement->end_date->toDateString() }}">
                    {{ $announcement->end_date->copy()->locale('id')->translatedFormat('d F Y') }}
                </time>
            @endif
        </span>

        @if ($isAgenda && $announcement->location)
            <span class="chip">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ $announcement->location }}
            </span>
        @endif
    </x-ui.page-hero>

    <section class="section-y bg-canvas">
        <div class="container-page">
            <div class="grid gap-6 lg:grid-cols-12 lg:gap-8">
                <article class="overflow-hidden rounded-3xl border border-line bg-surface shadow-[var(--shadow-soft)] lg:col-span-8">
                    <div class="h-1.5 w-full {{ $isAgenda ? 'bg-unmaris-blue' : 'bg-unmaris-yellow' }}" aria-hidden="true"></div>
                    <div class="p-6 sm:p-8 md:p-10">
                        <div class="mb-6 flex flex-wrap items-center gap-2.5">
                            <span class="rounded-full border px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-[0.08em] {{ $isAgenda ? 'border-unmaris-blue/30 bg-unmaris-blue/10 text-brand-ink' : 'border-unmaris-yellow/60 bg-unmaris-yellow/20 text-brand-ink' }}">
                                {{ $isAgenda ? 'Agenda Acara' : 'Pengumuman' }}
                            </span>
                            @if ($isAgenda)
                                <span class="text-[11px] font-semibold text-muted">
                                    {{ $announcement->start_date->copy()->locale('id')->translatedFormat('l, d F Y') }}
                                </span>
                            @endif
                        </div>

                        <div class="prose-unmaris max-w-none">
                            {!! $announcement->content !!}
                        </div>

                        @if ($announcement->attachment)
                            <div class="mt-10 rounded-2xl border border-dashed border-line-strong bg-surface-2/60 p-5 sm:p-6">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="flex items-start gap-3">
                                        <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-unmaris-yellow text-[#1b0f52]">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </span>
                                        <div>
                                            <h2 class="text-base font-bold text-ink">Lampiran Dokumen</h2>
                                            <p class="mt-0.5 text-[13px] leading-relaxed text-body">
                                                Unduh lampiran untuk melihat informasi lebih lengkap.
                                            </p>
                                        </div>
                                    </div>

                                    @if ($attachmentExists)
                                        <a href="{{ asset('storage/' . $announcement->attachment) }}" target="_blank" rel="noopener" download
                                            class="btn-navy shrink-0">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Unduh Lampiran
                                        </a>
                                    @else
                                        <span class="inline-flex min-h-11 shrink-0 items-center justify-center rounded-full border border-line bg-surface px-4 text-[12px] font-bold text-muted"
                                            title="Berkas lampiran belum tersedia di server">
                                            Berkas belum tersedia
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </article>

                <aside class="space-y-5 lg:col-span-4">
                    <div class="card p-6">
                        <span class="eyebrow">Informasi Acara</span>
                        <h2 class="mt-3 heading-3">Detail {{ $isAgenda ? 'Agenda' : 'Pengumuman' }}</h2>

                        <dl class="mt-5 space-y-4 text-sm">
                            <div>
                                <dt class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Tanggal</dt>
                                <dd class="mt-1 font-semibold text-ink">
                                    {{ $announcement->start_date->copy()->locale('id')->translatedFormat('d F Y') }}
                                    @if ($announcement->end_date && $announcement->end_date->ne($announcement->start_date))
                                        <span class="block text-[13px] font-medium text-body">
                                            s.d. {{ $announcement->end_date->copy()->locale('id')->translatedFormat('d F Y') }}
                                        </span>
                                    @endif
                                </dd>
                            </div>

                            @if ($isAgenda && $announcement->location)
                                <div>
                                    <dt class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Lokasi</dt>
                                    <dd class="mt-1 font-semibold text-ink">{{ $announcement->location }}</dd>
                                </div>
                            @endif

                            <div>
                                <dt class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Kategori</dt>
                                <dd class="mt-1 font-semibold text-ink">{{ $isAgenda ? 'Agenda Acara' : 'Pengumuman' }}</dd>
                            </div>
                        </dl>

                        <a href="{{ route('announcements.index') }}" class="btn-outline mt-6 w-full">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Semua Pengumuman
                        </a>
                    </div>

                    <div class="relative overflow-hidden rounded-3xl bg-navy-deep p-6 text-white shadow-[var(--shadow-soft)]">
                        <div class="pointer-events-none absolute inset-0 hero-grid opacity-60" aria-hidden="true"></div>
                        <div class="pointer-events-none absolute -right-10 -top-10 h-32 w-32 rounded-full bg-unmaris-yellow/20 blur-2xl" aria-hidden="true"></div>
                        <div class="relative">
                            <span class="eyebrow-light mb-3">Butuh Bantuan?</span>
                            <h2 class="font-display text-xl font-bold leading-tight text-white">Hubungi kami</h2>
                            <p class="mt-2 text-sm leading-relaxed text-white/65">
                                Sampaikan pertanyaan seputar pengumuman atau agenda melalui kanal resmi UNMARIS.
                            </p>
                            <a href="{{ route('contact') }}" class="btn-primary mt-5 w-full">Hubungi Kami</a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</x-layouts.app>
