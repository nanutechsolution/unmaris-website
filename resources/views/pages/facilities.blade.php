<x-layouts.app title="Fasilitas Kampus - UNMARIS">

    <x-ui.page-hero title="Fasilitas Kampus" eyebrow="Lingkungan Belajar"
        description="Lingkungan belajar yang kondusif, modern, dan inovatif untuk mendukung pengembangan potensi mahasiswa secara maksimal."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Fasilitas Kampus'],
        ]" />

    <!-- Galeri Fasilitas -->
    <section class="section-y bg-slate-50">
        <div class="container-page">

            @if(isset($facilities) && $facilities->count() > 0)
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 md:gap-7">
                @foreach($facilities as $facility)
                <article class="card card-hover group flex h-full flex-col overflow-hidden">
                    <div class="relative h-60 overflow-hidden">
                        @if($facility->image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($facility->image) }}"
                            alt="{{ $facility->name }}" loading="lazy"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">
                        @else
                        <div class="flex h-full w-full items-center justify-center bg-unmaris-blue/5 text-unmaris-blue/30">
                            <svg class="h-14 w-14" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z" />
                            </svg>
                        </div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/85 to-transparent"></div>
                        <h2 class="absolute bottom-0 left-0 w-full p-6 font-display text-xl font-bold leading-tight text-white transition-colors group-hover:text-unmaris-yellow">
                            {{ $facility->name }}
                        </h2>
                    </div>

                    <div class="flex flex-1 flex-col p-6">
                        <p class="text-sm leading-relaxed text-slate-600 md:text-base">
                            {{ $facility->description ?? 'Fasilitas terpadu untuk menunjang aktivitas akademik dan non-akademik civitas akademika UNMARIS.' }}
                        </p>
                    </div>
                </article>
                @endforeach
            </div>
            @else
            <x-ui.empty-state title="Belum Ada Data Fasilitas"
                description="Data galeri fasilitas kampus sedang diperbarui oleh tim admin.">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z" />
                </svg>
            </x-ui.empty-state>
            @endif

        </div>
    </section>

</x-layouts.app>