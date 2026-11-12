@php
    $phoneLink = preg_replace('/[^0-9+]/', '', $faculty->phone ?? '');
    $emailParts = array_pad(explode('@', (string) $faculty->email, 2), 2, null);
    $otherProdis = $otherProdis ?? collect();
    $plainDescription = trim(strip_tags($prodi->description ?? ''));
    $metaDescription = \Illuminate\Support\Str::limit(
        $plainDescription !== '' ? $plainDescription : strip_tags($prodi->vision ?? ''),
        155
    );
    $richText = 'text-sm leading-relaxed text-gray-700 sm:text-base [&_a]:text-unmaris-blue [&_a]:underline [&_li]:mb-1.5 [&_ol]:list-decimal [&_ol]:pl-5 [&_p]:mb-3 [&_strong]:font-bold [&_strong]:text-gray-900 [&_ul]:list-disc [&_ul]:pl-5';
    $prodiHasContent = filled($prodi->vision)
        || filled($prodi->mission)
        || filled($prodi->tujuan)
        || filled($prodi->career_prospects)
        || filled($prodi->edom_path);
    $sections = [
        [
            'label' => 'Visi',
            'title' => 'Visi Program Studi',
            'content' => $prodi->vision,
            'empty' => 'Belum ada data visi program studi.',
            'accent' => 'border-unmaris-yellow',
            'iconBg' => 'bg-blue-50 text-unmaris-blue',
            'iconPath' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
        ],
        [
            'label' => 'Misi',
            'title' => 'Misi Program Studi',
            'content' => $prodi->mission,
            'empty' => 'Belum ada data misi program studi.',
            'accent' => 'border-unmaris-blue',
            'iconBg' => 'bg-yellow-50 text-yellow-600',
            'iconPath' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
        ],
        [
            'label' => 'Tujuan',
            'title' => 'Tujuan Program Studi',
            'content' => $prodi->tujuan,
            'empty' => 'Belum ada data tujuan program studi.',
            'accent' => 'border-emerald-400',
            'iconBg' => 'bg-emerald-50 text-emerald-600',
            'iconPath' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
    ];
@endphp

<x-layouts.app
    :title="$prodi->name . ' (' . $prodi->degree . ') - ' . $faculty->name . ' | UNMARIS'"
    :description="$metaDescription ?: 'Profil program studi ' . $prodi->name . ' ' . $faculty->name . ' Universitas Stella Maris Sumba: visi, misi, tujuan, dan prospek karir.'"
    :ogImage="$faculty->image ? asset('storage/' . $faculty->image) : null"
>
    @if($prodi->description || $prodi->vision)
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

    <!-- Hero Program Studi -->
    <section class="relative overflow-hidden bg-unmaris-blue text-white">
        @if($faculty->image)
            <img src="{{ asset('storage/'.$faculty->image) }}" alt="{{ $faculty->name }}" class="absolute inset-0 h-full w-full object-cover opacity-20">
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
                    <li><a href="{{ route('faculties.detail', $faculty->slug) }}" class="transition hover:text-unmaris-yellow">{{ $faculty->name }}</a></li>
                    <li aria-hidden="true" class="text-white/30">/</li>
                    <li aria-current="page" class="text-white">{{ $prodi->name }}</li>
                </ol>
            </nav>

            <div class="mt-6 flex flex-wrap items-center gap-2 sm:mt-8">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.18em] text-unmaris-yellow backdrop-blur-sm sm:text-xs">
                    <span class="h-1.5 w-1.5 rounded-full bg-unmaris-yellow"></span>
                    Program Studi
                </span>
                <span class="inline-flex items-center rounded-full bg-unmaris-yellow px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.18em] text-unmaris-blue sm:text-xs">
                    Jenjang {{ $prodi->degree }}
                </span>
            </div>

            <h1 class="mt-4 max-w-4xl text-3xl font-black leading-tight tracking-tight sm:text-4xl md:text-5xl lg:text-6xl">
                {{ $prodi->name }}
            </h1>

            @if($prodi->description)
                <p class="mt-4 max-w-3xl text-sm leading-relaxed text-blue-100 sm:text-base md:text-lg">
                    {{ $prodi->description }}
                </p>
            @endif

            <div class="mt-6 flex flex-wrap gap-2 sm:mt-8">
                <a href="{{ route('faculties.detail', $faculty->slug) }}" class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/10 px-3 py-2 text-xs font-bold text-white backdrop-blur-sm transition hover:bg-white/20 sm:text-sm">
                    <svg class="h-4 w-4 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    {{ $faculty->name }}
                </a>
                @if($prodi->accreditation)
                    <span class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/10 px-3 py-2 text-xs font-bold text-white backdrop-blur-sm sm:text-sm">
                        <svg class="h-4 w-4 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Akreditasi {{ $prodi->accreditation }}
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0121 16.5M12 14v7m-6.16-10.922A12.083 12.083 0 003 16.5"></path>
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Jenjang</p>
                            <p class="text-base font-black leading-tight text-gray-900 sm:text-lg">{{ $prodi->degree }}</p>
                        </div>
                    </div>
                </div>

                @if($prodi->accreditation)
                    <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-lg shadow-gray-200/60 sm:p-5">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-yellow-50 text-yellow-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Akreditasi</p>
                                <p class="break-words text-base font-black leading-tight text-gray-900 sm:text-lg">{{ $prodi->accreditation }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <a href="{{ route('faculties.detail', $faculty->slug) }}" class="group rounded-2xl border border-gray-100 bg-white p-4 shadow-lg shadow-gray-200/60 transition hover:border-unmaris-yellow hover:shadow-xl sm:p-5 {{ $prodi->accreditation ? 'col-span-2 sm:col-span-1' : 'col-span-2 sm:col-span-2' }}">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 transition group-hover:bg-unmaris-yellow group-hover:text-unmaris-blue">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Fakultas Induk</p>
                            <p class="break-words text-[13px] font-bold leading-snug text-gray-900 sm:text-sm">{{ $faculty->name }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Konten Prodi & Sidebar -->
    <section class="bg-gray-50 py-10 md:py-16">
        <div class="container mx-auto max-w-6xl px-4 sm:px-6">
            <div class="grid gap-6 lg:grid-cols-3 lg:gap-8">
                <div class="space-y-5 sm:space-y-6 lg:col-span-2">
                    @foreach($sections as $section)
                        <article class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
                            <div class="border-l-4 {{ $section['accent'] }} p-5 sm:p-7 md:p-8">
                                <div class="mb-4 flex items-center gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $section['iconBg'] }}">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $section['iconPath'] }}"></path>
                                        </svg>
                                    </span>
                                    <h2 class="text-xl font-black text-unmaris-blue sm:text-2xl">{{ $section['title'] }}</h2>
                                </div>
                                @if($section['content'])
                                    <div class="{{ $richText }}">
                                        {!! $section['content'] !!}
                                    </div>
                                @else
                                    <p class="text-sm italic text-gray-400">{{ $section['empty'] }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach

                    @if($prodi->career_prospects)
                        <article class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
                            <div class="border-l-4 border-purple-400 p-5 sm:p-7 md:p-8">
                                <div class="mb-4 flex items-center gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </span>
                                    <h2 class="text-xl font-black text-unmaris-blue sm:text-2xl">Prospek Karir Lulusan</h2>
                                </div>
                                <div class="{{ $richText }}">
                                    {!! $prodi->career_prospects !!}
                                </div>
                            </div>
                        </article>
                    @endif

                    @if($prodi->edom_path)
                        <article class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
                            <div class="border-l-4 border-red-400 p-5 sm:p-7 md:p-8">
                                <div class="mb-4 flex items-center gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-500">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </span>
                                    <h2 class="text-xl font-black text-unmaris-blue sm:text-2xl">Evaluasi Dosen oleh Mahasiswa (EDOM)</h2>
                                </div>

                                <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                                    <div class="min-w-0 flex-grow">
                                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Dokumen Resmi (PDF)</p>
                                        <h3 class="mt-1 text-base font-bold leading-snug text-gray-900 sm:text-lg">
                                            {{ $prodi->edom_title ?: 'Laporan Evaluasi Dosen oleh Mahasiswa (EDOM)' }}
                                        </h3>
                                        @if($prodi->edom_description)
                                            <p class="mt-1 text-sm leading-relaxed text-gray-500">{{ $prodi->edom_description }}</p>
                                        @endif
                                    </div>

                                    <a href="{{ asset('storage/'.$prodi->edom_path) }}" target="_blank" rel="noopener" download class="inline-flex min-h-[46px] w-full shrink-0 items-center justify-center gap-2 rounded-xl bg-unmaris-blue px-5 py-3 text-sm font-bold text-white transition hover:bg-unmaris-yellow hover:text-unmaris-blue focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-unmaris-yellow focus-visible:ring-offset-2 sm:w-auto">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Unduh Dokumen
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endif

                    @if(! $prodiHasContent)
                        <div class="rounded-3xl border border-dashed border-gray-200 bg-white px-5 py-14 text-center sm:py-16">
                            <span class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-50 text-gray-300">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </span>
                            <h2 class="text-lg font-black text-gray-800">Informasi prodi belum lengkap</h2>
                            <p class="mx-auto mt-1 max-w-md text-sm text-gray-500">Visi, misi, tujuan, dan prospek karir program studi ini belum tersedia. Silakan hubungi fakultas untuk informasi lebih lanjut.</p>
                        </div>
                    @endif
                </div>

                <aside class="space-y-5 sm:space-y-6">
                    @if($faculty->email || $faculty->phone)
                        <div class="rounded-3xl bg-unmaris-blue p-5 text-white shadow-lg sm:p-6 md:p-7">
                            <h2 class="text-lg font-black sm:text-xl">Hubungi Fakultas</h2>
                            <p class="mt-1 text-xs leading-relaxed text-blue-200">Untuk informasi akademik program studi {{ $prodi->name }}, silakan hubungi fakultas.</p>

                            <ul class="mt-5 space-y-2.5">
                                @if($faculty->email)
                                    <li>
                                        <a href="mailto:{{ $faculty->email }}" class="flex items-start gap-3 rounded-2xl bg-white/5 p-3 transition hover:bg-white/10">
                                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="min-w-0">
                                                <span class="block text-[10px] font-black uppercase tracking-widest text-blue-300">Email Resmi</span>
                                                <span class="mt-0.5 block break-words text-sm font-semibold">@if($emailParts[1]){{ $emailParts[0] }}@<wbr>{{ $emailParts[1] }}@else{{ $faculty->email }}@endif</span>
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

                            <a href="{{ route('faculties.detail', $faculty->slug) }}" class="mt-4 inline-flex min-h-[44px] w-full items-center justify-center gap-2 rounded-xl border border-white/20 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-unmaris-yellow">
                                Lihat Profil Fakultas
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    @endif

                    @if($otherProdis->isNotEmpty())
                        <div class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
                            <p class="text-[10px] font-black uppercase tracking-[0.18em] text-unmaris-blue/60">Pilihan Lain</p>
                            <h2 class="mt-1 text-lg font-black text-gray-900">Program Studi di {{ $faculty->name }}</h2>

                            <ul class="mt-4 space-y-2">
                                @foreach($otherProdis as $other)
                                    <li>
                                        <a href="{{ route('prodi.detail', [$faculty->slug, $other->slug]) }}" class="group flex items-center gap-3 rounded-2xl border border-gray-100 bg-gray-50/70 p-3 transition hover:border-unmaris-yellow hover:bg-white">
                                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-[11px] font-black text-unmaris-blue shadow-sm">{{ $other->degree }}</span>
                                            <span class="min-w-0 flex-1">
                                                <span class="block text-sm font-bold leading-snug text-gray-900">{{ $other->name }}</span>
                                                @if($other->accreditation)
                                                    <span class="block text-[11px] font-semibold text-gray-400">Akreditasi {{ $other->accreditation }}</span>
                                                @endif
                                            </span>
                                            <svg class="h-4 w-4 shrink-0 text-gray-300 transition group-hover:translate-x-0.5 group-hover:text-unmaris-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-unmaris-blue/60">Penerimaan Mahasiswa Baru</p>
                        <h2 class="mt-2 text-lg font-black leading-tight text-gray-900">Tertarik bergabung?</h2>
                        <p class="mt-2 text-sm leading-relaxed text-gray-500">Daftarkan dirimu dan mulai perjalanan akademik di {{ $prodi->name }}.</p>
                        <a href="https://pmb.unmarissumba.ac.id" target="_blank" rel="noopener" class="mt-4 inline-flex min-h-[44px] w-full items-center justify-center gap-2 rounded-xl bg-unmaris-blue px-4 py-3 text-sm font-bold text-white transition hover:bg-unmaris-yellow hover:text-unmaris-blue focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-unmaris-yellow focus-visible:ring-offset-2">
                            Daftar PMB
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </aside>
            </div>

            <div class="mt-8 text-center sm:mt-10">
                <a href="{{ route('faculties.detail', $faculty->slug) }}" class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-full border border-gray-200 bg-white px-5 py-2.5 text-sm font-bold text-unmaris-blue transition hover:border-unmaris-blue hover:bg-gray-50">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke {{ $faculty->name }}
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
                Siap kuliah di <span class="text-unmaris-yellow">{{ $prodi->name }}</span>?
            </h2>
            <p class="mx-auto mt-3 max-w-2xl text-sm leading-relaxed text-blue-100 sm:text-base md:text-lg">Wujudkan cita-citamu bersama Universitas Stella Maris Sumba.</p>

            <div class="mt-7 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <a href="https://pmb.unmarissumba.ac.id" target="_blank" rel="noopener" class="inline-flex min-h-[48px] w-full items-center justify-center gap-2 rounded-full bg-unmaris-yellow px-7 py-3.5 text-sm font-black uppercase tracking-wide text-unmaris-blue transition hover:bg-white sm:w-auto sm:text-base">
                    Daftar Mahasiswa Baru
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
                <a href="{{ route('faculties.detail', $faculty->slug) }}" class="inline-flex min-h-[48px] w-full items-center justify-center rounded-full border border-white/25 px-7 py-3.5 text-sm font-bold text-white transition hover:bg-white/10 sm:w-auto sm:text-base">
                    Lihat Fakultas
                </a>
            </div>
        </div>
    </section>
</x-layouts.app>
