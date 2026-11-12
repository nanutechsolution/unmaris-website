@php
    $prodiCount = $faculty->studyPrograms->count();
    $degrees = $faculty->studyPrograms->pluck('degree')->filter()->unique()->sort()->implode(' / ');
    $phoneLink = preg_replace('/[^0-9+]/', '', $faculty->phone ?? '');
    $emailParts = array_pad(explode('@', (string) $faculty->email, 2), 2, null);
    $metaDescription = \Illuminate\Support\Str::limit(strip_tags($faculty->description ?? ''), 155);
@endphp

<x-layouts.app
    :title="$faculty->name . ' - Fakultas UNMARIS'"
    :description="$metaDescription ?: 'Profil fakultas, program studi, struktur organisasi, dan dokumen resmi ' . $faculty->name . ' Universitas Stella Maris Sumba.'"
>
    <!-- Hero Fakultas -->
    <section class="relative overflow-hidden bg-unmaris-blue text-white">
        @if($faculty->image)
            <img src="{{ asset('storage/'.$faculty->image) }}" alt="{{ $faculty->name }}" class="absolute inset-0 h-full w-full object-cover opacity-25">
        @endif
        <div class="absolute inset-0 bg-gradient-to-b from-unmaris-blue/90 via-unmaris-blue/95 to-unmaris-blue"></div>
        <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-unmaris-yellow opacity-20 blur-[100px]"></div>
        <div class="absolute -bottom-24 -left-24 h-64 w-64 rounded-full bg-blue-400 opacity-20 blur-[100px]"></div>

        <div class="container relative z-10 mx-auto max-w-6xl px-4 pb-12 pt-6 sm:px-6 md:pb-20 md:pt-10">
            <!-- Breadcrumb -->
            <nav aria-label="Breadcrumb" class="text-[11px] font-semibold text-blue-200 sm:text-xs">
                <ol class="flex flex-wrap items-center gap-1.5">
                    <li><a href="{{ route('home') }}" class="transition hover:text-unmaris-yellow">Beranda</a></li>
                    <li aria-hidden="true" class="text-white/30">/</li>
                    <li><a href="{{ route('faculties.index') }}" class="transition hover:text-unmaris-yellow">Fakultas</a></li>
                    <li aria-hidden="true" class="text-white/30">/</li>
                    <li aria-current="page" class="text-white">{{ $faculty->name }}</li>
                </ol>
            </nav>

            <span class="mt-6 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.18em] text-unmaris-yellow backdrop-blur-sm sm:mt-8 sm:text-xs">
                <span class="h-1.5 w-1.5 rounded-full bg-unmaris-yellow"></span>
                Profil Fakultas
            </span>

            <h1 class="mt-4 max-w-4xl text-3xl font-black leading-tight tracking-tight sm:text-4xl md:text-5xl lg:text-6xl">
                {{ $faculty->name }}
            </h1>

            @if($faculty->description)
                <p class="mt-4 max-w-3xl text-sm leading-relaxed text-blue-100 sm:text-base md:text-lg">
                    {{ $faculty->description }}
                </p>
            @endif

            <div class="mt-6 flex flex-wrap gap-2 sm:mt-8">
                <span class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/10 px-3 py-2 text-xs font-bold text-white backdrop-blur-sm sm:text-sm">
                    <svg class="h-4 w-4 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    {{ $prodiCount }} Program Studi
                </span>

                @if($degrees)
                    <span class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/10 px-3 py-2 text-xs font-bold text-white backdrop-blur-sm sm:text-sm">
                        <svg class="h-4 w-4 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Jenjang {{ $degrees }}
                    </span>
                @endif
            </div>
        </div>
    </section>

    <!-- Kartu Informasi Singkat -->
    <section class="relative z-20 bg-gray-50">
        <div class="container mx-auto max-w-6xl px-4 sm:px-6">
            <div class="-mt-6 grid grid-cols-2 gap-3 sm:-mt-8 sm:grid-cols-3 sm:gap-4">
                <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-lg shadow-gray-200/60 sm:p-5">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-unmaris-blue">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Program Studi</p>
                            <p class="text-xl font-black leading-tight text-gray-900">{{ $prodiCount }}</p>
                        </div>
                    </div>
                </div>

                @if($faculty->email)
                    <a href="mailto:{{ $faculty->email }}" class="group rounded-2xl border border-gray-100 bg-white p-4 shadow-lg shadow-gray-200/60 transition hover:border-unmaris-yellow hover:shadow-xl sm:p-5">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-yellow-50 text-yellow-600 transition group-hover:bg-unmaris-yellow group-hover:text-unmaris-blue">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Email</p>
                                <p class="break-words text-[13px] font-bold leading-snug text-gray-900 sm:text-sm">
                                    @if($emailParts[1]){{ $emailParts[0] }}@<wbr>{{ $emailParts[1] }}@else{{ $faculty->email }}@endif
                                </p>
                            </div>
                        </div>
                    </a>
                @endif

                @if($faculty->phone)
                    <a href="tel:{{ $phoneLink }}" class="group col-span-2 rounded-2xl border border-gray-100 bg-white p-4 shadow-lg shadow-gray-200/60 transition hover:border-unmaris-yellow hover:shadow-xl sm:col-span-1 sm:p-5">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-600 transition group-hover:bg-unmaris-yellow group-hover:text-unmaris-blue">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Telepon / WA</p>
                                <p class="break-words text-[13px] font-bold leading-snug text-gray-900 sm:text-sm">{{ $faculty->phone }}</p>
                            </div>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </section>

    <!-- Visi, Misi & Kontak -->
    <section class="bg-gray-50 py-10 md:py-16">
        <div class="container mx-auto max-w-6xl px-4 sm:px-6">
            <div class="grid gap-6 lg:grid-cols-3 lg:gap-8">
                <div class="space-y-5 sm:space-y-6 lg:col-span-2">
                    @if($faculty->vision)
                        <article class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
                            <div class="border-l-4 border-unmaris-yellow p-5 sm:p-7 md:p-8">
                                <div class="mb-4 flex items-center gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-unmaris-blue">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </span>
                                    <h2 class="text-xl font-black text-unmaris-blue sm:text-2xl">Visi Fakultas</h2>
                                </div>
                                <div class="text-sm leading-relaxed text-gray-700 sm:text-base [&_a]:text-unmaris-blue [&_a]:underline [&_li]:mb-1.5 [&_ol]:list-decimal [&_ol]:pl-5 [&_p]:mb-3 [&_strong]:font-bold [&_strong]:text-gray-900 [&_ul]:list-disc [&_ul]:pl-5">
                                    {!! $faculty->vision !!}
                                </div>
                            </div>
                        </article>
                    @endif

                    @if($faculty->mission)
                        <article class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
                            <div class="border-l-4 border-unmaris-blue p-5 sm:p-7 md:p-8">
                                <div class="mb-4 flex items-center gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-yellow-50 text-yellow-600">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </span>
                                    <h2 class="text-xl font-black text-unmaris-blue sm:text-2xl">Misi Fakultas</h2>
                                </div>
                                <div class="text-sm leading-relaxed text-gray-700 sm:text-base [&_a]:text-unmaris-blue [&_a]:underline [&_li]:mb-1.5 [&_ol]:list-decimal [&_ol]:pl-5 [&_p]:mb-3 [&_strong]:font-bold [&_strong]:text-gray-900 [&_ul]:list-disc [&_ul]:pl-5">
                                    {!! $faculty->mission !!}
                                </div>
                            </div>
                        </article>
                    @endif
                </div>

                <aside class="space-y-5 sm:space-y-6">
                    @if($faculty->email || $faculty->phone)
                        <div class="rounded-3xl bg-unmaris-blue p-5 text-white shadow-lg sm:p-6 md:p-7">
                            <h2 class="text-lg font-black sm:text-xl">Hubungi Fakultas</h2>
                            <p class="mt-1 text-xs leading-relaxed text-blue-200">Silakan hubungi kami untuk informasi akademik dan layanan fakultas.</p>

                            <ul class="mt-5 space-y-2.5">
                                @if($faculty->email)
                                    <li>
                                        <a href="mailto:{{ $faculty->email }}" class="flex items-start gap-3 rounded-2xl bg-white/5 p-3 transition hover:bg-white/10">
                                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="min-w-0">
                                                <span class="block text-[10px] font-black uppercase tracking-widest text-blue-300">Email Resmi</span>
                                                <span class="mt-0.5 block break-all text-sm font-semibold">{{ $faculty->email }}</span>
                                            </span>
                                        </a>
                                    </li>
                                @endif

                                @if($faculty->phone)
                                    <li>
                                        <a href="tel:{{ $phoneLink }}" class="flex items-start gap-3 rounded-2xl bg-white/5 p-3 transition hover:bg-white/10">
                                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            <span class="min-w-0">
                                                <span class="block text-[10px] font-black uppercase tracking-widest text-blue-300">Telepon / WhatsApp</span>
                                                <span class="mt-0.5 block break-words text-sm font-semibold">{{ $faculty->phone }}</span>
                                            </span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif

                    <div class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-unmaris-blue/60">Penerimaan Mahasiswa Baru</p>
                        <h3 class="mt-2 text-lg font-black leading-tight text-gray-900">Tertarik bergabung?</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-500">Daftarkan dirimu dan mulai perjalanan akademik bersama {{ $faculty->name }}.</p>
                        <a href="https://pmb.unmarissumba.ac.id" target="_blank" rel="noopener" class="mt-4 inline-flex min-h-[44px] w-full items-center justify-center gap-2 rounded-xl bg-unmaris-blue px-4 py-3 text-sm font-bold text-white transition hover:bg-unmaris-yellow hover:text-unmaris-blue focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-unmaris-yellow focus-visible:ring-offset-2">
                            Daftar PMB
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- Struktur Organisasi Fakultas -->
    @if($faculty->struktur_organisasi)
        <section class="bg-white py-10 md:py-16">
            <div class="container mx-auto max-w-6xl px-4 sm:px-6">
                <div class="mb-5 flex flex-col gap-3 sm:mb-7 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-unmaris-blue/60">Tata Kelola</p>
                        <h2 class="mt-1 text-2xl font-black tracking-tight text-unmaris-blue sm:text-3xl md:text-4xl">Struktur Organisasi</h2>
                        <p class="mt-2 max-w-2xl text-sm leading-relaxed text-gray-500">Bagan struktur organisasi {{ $faculty->name }}.</p>
                    </div>
                    <a href="{{ asset('storage/'.$faculty->struktur_organisasi) }}" target="_blank" rel="noopener" class="inline-flex min-h-[40px] items-center justify-center gap-2 self-start rounded-full border border-gray-200 bg-white px-4 py-2 text-xs font-bold text-unmaris-blue transition hover:border-unmaris-blue hover:bg-gray-50 sm:self-auto">
                        Buka ukuran penuh
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                </div>

                <div class="overflow-hidden rounded-3xl border border-gray-100 bg-gray-50 p-2 shadow-sm sm:p-4">
                    <div class="overflow-x-auto rounded-2xl bg-white">
                        <img src="{{ asset('storage/'.$faculty->struktur_organisasi) }}" alt="Bagan Struktur Organisasi {{ $faculty->name }}" loading="lazy" class="h-auto w-full min-w-[640px]">
                    </div>
                </div>
                <p class="mt-3 text-center text-[11px] text-gray-400 sm:hidden">Geser gambar ke samping untuk melihat bagan secara lengkap.</p>
            </div>
        </section>
    @endif

    <!-- Dokumen Fakultas -->
    @if($faculty->document_path)
        <section class="bg-white pb-10 md:pb-16">
            <div class="container mx-auto max-w-6xl px-4 sm:px-6">
                <div class="rounded-3xl border border-gray-100 bg-gray-50 p-5 shadow-sm sm:p-6 md:p-8">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-500 sm:h-16 sm:w-16">
                            <svg class="h-7 w-7 sm:h-8 sm:w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </span>

                        <div class="min-w-0 flex-grow">
                            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Dokumen Resmi (PDF)</p>
                            <h2 class="mt-1 text-lg font-black leading-snug text-gray-900 sm:text-xl">
                                {{ $faculty->document_title ?: 'Dokumen Struktur Organisasi dan Tata Kelola (SOTK)' }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">{{ $faculty->name }}</p>
                        </div>

                        <a href="{{ asset('storage/'.$faculty->document_path) }}" target="_blank" rel="noopener" download class="inline-flex min-h-[46px] w-full shrink-0 items-center justify-center gap-2 rounded-xl bg-unmaris-blue px-5 py-3 text-sm font-bold text-white transition hover:bg-unmaris-yellow hover:text-unmaris-blue focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-unmaris-yellow focus-visible:ring-offset-2 sm:w-auto">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Unduh Dokumen
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Program Studi -->
    <section class="bg-white py-10 md:py-16">
        <div class="container mx-auto max-w-6xl px-4 sm:px-6">
            <div class="mb-6 flex flex-col gap-4 sm:mb-8 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-unmaris-blue/60">Pilihan Studi</p>
                    <h2 class="mt-1 text-2xl font-black tracking-tight text-unmaris-blue sm:text-3xl md:text-4xl">Program Studi</h2>
                    <p class="mt-2 text-sm leading-relaxed text-gray-500 sm:text-base">Pilih program studi yang paling sesuai dengan minat dan rencana kariermu.</p>
                </div>
                <span class="inline-flex w-fit items-center gap-2 rounded-full bg-blue-50 px-3 py-1.5 text-xs font-black text-unmaris-blue sm:text-sm">
                    <span class="h-1.5 w-1.5 rounded-full bg-unmaris-blue"></span>
                    {{ $prodiCount }} Program Studi
                </span>
            </div>

            @if($faculty->studyPrograms->isEmpty())
                <div class="rounded-3xl border border-dashed border-gray-200 bg-gray-50 px-5 py-14 text-center sm:py-16">
                    <span class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-gray-300 shadow-sm">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </span>
                    <h3 class="text-lg font-black text-gray-800">Belum ada program studi</h3>
                    <p class="mt-1 text-sm text-gray-500">Informasi program studi untuk fakultas ini belum tersedia.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-5 lg:grid-cols-2 lg:gap-6">
                    @foreach($faculty->studyPrograms as $prodi)
                        <article x-data="{ tab: 'visi' }" class="flex h-full flex-col overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm transition-shadow duration-300 hover:shadow-xl">
                            <div class="p-5 sm:p-6">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="inline-flex items-center rounded-lg bg-blue-50 px-2.5 py-1 text-[11px] font-black uppercase tracking-wide text-unmaris-blue">
                                        {{ $prodi->degree }}
                                    </span>
                                    <span class="inline-flex items-center rounded-lg border px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide {{ in_array($prodi->accreditation, ['Unggul', 'A']) ? 'border-green-200 bg-green-50 text-green-700' : (in_array($prodi->accreditation, ['Baik Sekali', 'B']) ? 'border-yellow-200 bg-yellow-50 text-yellow-700' : 'border-blue-200 bg-blue-50 text-blue-700') }}">
                                        Akreditasi {{ $prodi->accreditation }}
                                    </span>
                                </div>

                                <h3 class="mt-3 text-lg font-black leading-snug text-gray-900 sm:text-xl">
                                    <a href="{{ route('prodi.detail', [$faculty->slug, $prodi->slug]) }}" class="transition hover:text-unmaris-blue focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-unmaris-yellow rounded focus-visible:ring-offset-2">{{ $prodi->name }}</a>
                                </h3>

                                @if($prodi->description)
                                    <p class="mt-2 text-sm leading-relaxed text-gray-500">{{ $prodi->description }}</p>
                                @endif
                            </div>

                            <div class="mt-auto border-t border-gray-100 bg-gray-50/80">
                                <div class="grid grid-cols-4 gap-1 p-2" role="tablist" aria-label="Informasi {{ $prodi->name }}">
                                    <button type="button" role="tab" id="tab-visi-{{ $prodi->id }}" aria-controls="panel-visi-{{ $prodi->id }}" @click="tab = 'visi'" :aria-selected="tab === 'visi'" :class="tab === 'visi' ? 'bg-unmaris-blue text-white shadow-sm' : 'text-gray-500 hover:bg-white hover:text-unmaris-blue'" class="min-h-[42px] rounded-xl px-1 py-2 text-[11px] font-black uppercase tracking-wide transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-unmaris-yellow sm:text-xs">
                                        Visi
                                    </button>
                                    <button type="button" role="tab" id="tab-misi-{{ $prodi->id }}" aria-controls="panel-misi-{{ $prodi->id }}" @click="tab = 'misi'" :aria-selected="tab === 'misi'" :class="tab === 'misi' ? 'bg-unmaris-blue text-white shadow-sm' : 'text-gray-500 hover:bg-white hover:text-unmaris-blue'" class="min-h-[42px] rounded-xl px-1 py-2 text-[11px] font-black uppercase tracking-wide transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-unmaris-yellow sm:text-xs">
                                        Misi
                                    </button>
                                    <button type="button" role="tab" id="tab-tujuan-{{ $prodi->id }}" aria-controls="panel-tujuan-{{ $prodi->id }}" @click="tab = 'tujuan'" :aria-selected="tab === 'tujuan'" :class="tab === 'tujuan' ? 'bg-unmaris-blue text-white shadow-sm' : 'text-gray-500 hover:bg-white hover:text-unmaris-blue'" class="min-h-[42px] rounded-xl px-1 py-2 text-[11px] font-black uppercase tracking-wide transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-unmaris-yellow sm:text-xs">
                                        Tujuan
                                    </button>
                                    <button type="button" role="tab" id="tab-karir-{{ $prodi->id }}" aria-controls="panel-karir-{{ $prodi->id }}" @click="tab = 'karir'" :aria-selected="tab === 'karir'" :class="tab === 'karir' ? 'bg-unmaris-blue text-white shadow-sm' : 'text-gray-500 hover:bg-white hover:text-unmaris-blue'" class="min-h-[42px] rounded-xl px-1 py-2 text-[11px] font-black uppercase tracking-wide transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-unmaris-yellow sm:text-xs">
                                        Karir
                                    </button>
                                </div>

                                <div class="min-h-[120px] px-4 pb-5 pt-1 sm:px-5">
                                    <div x-show="tab === 'visi'" x-cloak role="tabpanel" id="panel-visi-{{ $prodi->id }}" aria-labelledby="tab-visi-{{ $prodi->id }}" class="text-sm leading-relaxed text-gray-700 [&_a]:text-unmaris-blue [&_a]:underline [&_li]:mb-1.5 [&_ol]:list-decimal [&_ol]:pl-5 [&_p]:mb-2 [&_strong]:font-bold [&_ul]:list-disc [&_ul]:pl-5">
                                        @if($prodi->vision)
                                            {!! $prodi->vision !!}
                                        @else
                                            <p class="text-xs italic text-gray-400">Belum ada data visi.</p>
                                        @endif
                                    </div>

                                    <div x-show="tab === 'misi'" x-cloak role="tabpanel" id="panel-misi-{{ $prodi->id }}" aria-labelledby="tab-misi-{{ $prodi->id }}" class="text-sm leading-relaxed text-gray-700 [&_a]:text-unmaris-blue [&_a]:underline [&_li]:mb-1.5 [&_ol]:list-decimal [&_ol]:pl-5 [&_p]:mb-2 [&_strong]:font-bold [&_ul]:list-disc [&_ul]:pl-5">
                                        @if($prodi->mission)
                                            {!! $prodi->mission !!}
                                        @else
                                            <p class="text-xs italic text-gray-400">Belum ada data misi.</p>
                                        @endif
                                    </div>

                                    <div x-show="tab === 'tujuan'" x-cloak role="tabpanel" id="panel-tujuan-{{ $prodi->id }}" aria-labelledby="tab-tujuan-{{ $prodi->id }}" class="text-sm leading-relaxed text-gray-700 [&_a]:text-unmaris-blue [&_a]:underline [&_li]:mb-1.5 [&_ol]:list-decimal [&_ol]:pl-5 [&_p]:mb-2 [&_strong]:font-bold [&_ul]:list-disc [&_ul]:pl-5">
                                        @if($prodi->tujuan)
                                            {!! $prodi->tujuan !!}
                                        @else
                                            <p class="text-xs italic text-gray-400">Belum ada data tujuan program studi.</p>
                                        @endif
                                    </div>

                                    <div x-show="tab === 'karir'" x-cloak role="tabpanel" id="panel-karir-{{ $prodi->id }}" aria-labelledby="tab-karir-{{ $prodi->id }}" class="text-sm leading-relaxed text-gray-700 [&_a]:text-unmaris-blue [&_a]:underline [&_li]:mb-1.5 [&_ol]:list-decimal [&_ol]:pl-5 [&_p]:mb-2 [&_strong]:font-bold [&_ul]:list-disc [&_ul]:pl-5">
                                        @if($prodi->career_prospects)
                                            {!! $prodi->career_prospects !!}
                                        @else
                                            <p class="text-xs italic text-gray-400">Belum ada data prospek karir.</p>
                                        @endif
                                    </div>
                                </div>

                                <a href="{{ route('prodi.detail', [$faculty->slug, $prodi->slug]) }}" class="group flex items-center justify-between gap-2 border-t border-gray-200/80 bg-white px-4 py-3 text-sm font-bold text-unmaris-blue transition hover:bg-unmaris-blue hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-unmaris-yellow sm:px-5">
                                    <span>Lihat Profil Lengkap</span>
                                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif

            <div class="mt-8 text-center sm:mt-10">
                <a href="{{ route('faculties.index') }}" class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-full border border-gray-200 bg-white px-5 py-2.5 text-sm font-bold text-unmaris-blue transition hover:border-unmaris-blue hover:bg-gray-50">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Lihat Semua Fakultas
                </a>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="relative overflow-hidden bg-unmaris-blue py-14 text-white md:py-20">
        <div class="absolute inset-0 opacity-10" aria-hidden="true">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon fill="currentColor" points="100,100 0,0 100,0" />
            </svg>
        </div>
        <div class="absolute left-1/2 top-1/2 h-[500px] w-[500px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-unmaris-yellow opacity-20 blur-[130px]" aria-hidden="true"></div>

        <div class="container relative z-10 mx-auto max-w-4xl px-4 text-center sm:px-6">
            <span class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-white backdrop-blur-sm sm:text-xs">Langkah Selanjutnya</span>
            <h2 class="mt-4 text-2xl font-black leading-tight tracking-tight sm:text-3xl md:text-5xl">
                Siap bergabung dengan <span class="text-unmaris-yellow">{{ $faculty->name }}</span>?
            </h2>
            <p class="mx-auto mt-3 max-w-2xl text-sm leading-relaxed text-blue-100 sm:text-base md:text-lg">Wujudkan cita-citamu bersama Universitas Stella Maris Sumba.</p>

            <div class="mt-7 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <a href="https://pmb.unmarissumba.ac.id" target="_blank" rel="noopener" class="inline-flex min-h-[48px] w-full items-center justify-center gap-2 rounded-full bg-unmaris-yellow px-7 py-3.5 text-sm font-black uppercase tracking-wide text-unmaris-blue transition hover:bg-white sm:w-auto sm:text-base">
                    Daftar Mahasiswa Baru
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
                <a href="{{ route('faculties.index') }}" class="inline-flex min-h-[48px] w-full items-center justify-center rounded-full border border-white/25 px-7 py-3.5 text-sm font-bold text-white transition hover:bg-white/10 sm:w-auto sm:text-base">
                    Jelajahi Fakultas Lain
                </a>
            </div>
        </div>
    </section>
</x-layouts.app>
