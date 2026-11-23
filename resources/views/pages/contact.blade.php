@php
    $alamat = $page->content['alamat'] ?? null;
    $email = $page->content['email'] ?? null;
    $telepon = $page->content['telepon'] ?? null;
    $peta = $page->content['peta_embed'] ?? null;
    $teleponLink = preg_replace('/[^0-9+]/', '', $telepon ?? '');
@endphp

<x-layouts.app :title="$page->title . ' - UNMARIS'" :description="$page->meta_description">

    <x-ui.page-hero :title="$page->title" eyebrow="Hubungi Kami" :description="$page->meta_description"
        image="{{ asset('images/campus/samping-1600.jpg') }}"
        image-srcset="{{ asset('images/campus/samping-480.webp') }} 480w, {{ asset('images/campus/samping-960.webp') }} 960w, {{ asset('images/campus/samping-1600.webp') }} 1600w"
        image-alt="Gedung perkuliahan UNMARIS empat lantai tampak samping"
        :image-width="1600" :image-height="874"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => $page->title],
        ]">
        <span class="chip">
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            Kanal Resmi
        </span>
    </x-ui.page-hero>

    <section class="section-y bg-canvas">
        <div class="container-page">
            <div class="grid gap-6 lg:grid-cols-12 lg:gap-8">
                <!-- Informasi kontak -->
                <div class="space-y-5 lg:col-span-5">
                    <div class="rounded-3xl border border-line bg-surface p-6 shadow-[var(--shadow-soft)] md:p-7">
                        <span class="eyebrow">Informasi Kontak</span>
                        <h2 class="mt-3 heading-3">Hubungi UNMARIS</h2>
                        <p class="mt-2 text-sm leading-relaxed text-body">
                            Sampaikan pertanyaan seputar akademik, kemahasiswaan, atau layanan kampus melalui kanal resmi berikut.
                        </p>

                        <ul class="mt-6 space-y-3">
                            @if ($alamat)
                                <li class="flex items-start gap-3 rounded-2xl border border-line bg-surface-2/60 p-4">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-unmaris-yellow text-[#1b0f52]">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Alamat Kampus</p>
                                        <p class="mt-1 text-sm font-semibold leading-relaxed text-ink">{{ $alamat }}</p>
                                    </div>
                                </li>
                            @endif

                            @if ($email)
                                <li>
                                    <a href="mailto:{{ $email }}"
                                        class="focus-navy group flex items-start gap-3 rounded-2xl border border-line bg-surface-2/60 p-4 transition hover:border-unmaris-blue">
                                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-unmaris-blue text-unmaris-yellow">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </span>
                                        <span class="min-w-0">
                                            <span class="block text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Email Resmi</span>
                                            <span class="mt-1 block break-all text-sm font-semibold text-brand-ink group-hover:underline">{{ $email }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endif

                            @if ($telepon)
                                <li>
                                    <a href="tel:{{ $teleponLink }}"
                                        class="focus-navy group flex items-start gap-3 rounded-2xl border border-line bg-surface-2/60 p-4 transition hover:border-unmaris-blue">
                                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-surface text-brand-ink ring-1 ring-line">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </span>
                                        <span class="min-w-0">
                                            <span class="block text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Telepon / WhatsApp</span>
                                            <span class="mt-1 block break-words text-sm font-semibold text-brand-ink group-hover:underline">{{ $telepon }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                        </ul>

                        <div class="mt-6 flex flex-col gap-2 border-t border-line pt-5 sm:flex-row">
                            <a href="{{ route('complaint.index') }}" class="btn-outline btn-sm flex-1">Kirim Pengaduan</a>
                            <a href="{{ route('akademik.unduhan') }}" class="btn-ghost btn-sm flex-1">Pusat Unduhan</a>
                        </div>
                    </div>

                    @if ($peta)
                        <div class="overflow-hidden rounded-3xl border border-line bg-surface p-2 shadow-[var(--shadow-soft)]">
                            <div class="h-64 overflow-hidden rounded-2xl md:h-72">
                                <iframe src="{{ $peta }}" title="Peta lokasi kampus Universitas Stella Maris Sumba"
                                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade" class="h-full w-full"></iframe>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Formulir -->
                <div class="lg:col-span-7">
                    <div class="overflow-hidden rounded-3xl border border-line bg-surface shadow-[var(--shadow-soft)]">
                        <div class="h-1.5 w-full bg-unmaris-yellow" aria-hidden="true"></div>
                        <div class="p-6 sm:p-8 md:p-10">
                            <span class="eyebrow">Formulir Kontak</span>
                            <h2 class="mt-3 heading-2">Kirim pesan</h2>
                            <p class="mt-2 text-sm leading-relaxed text-body">
                                Isi formulir dengan lengkap. Staf kami akan membalas pesan Anda dalam 1x24 jam kerja.
                            </p>

                            <div class="mt-7">
                                <livewire:contact-form />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
