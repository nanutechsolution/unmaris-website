<x-layouts.app :title="$page->title . ' - UNMARIS'" :description="$page->meta_description">

    <x-ui.page-hero :title="$page->title" eyebrow="Pusat Informasi Akademik"
        :description="$page->meta_description"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Akademik', 'url' => route('faculties.index')],
            ['label' => $page->title],
        ]" />

    <!-- Content Section -->
    <section class="section-y bg-slate-50">
        <div class="container-page max-w-4xl">
            
            @if(!empty($page->content['umum']))
                <div class="card p-6 sm:p-8 md:p-12 lg:p-14">
                    <div class="prose-unmaris">
                        {!! $page->content['umum'] !!}
                    </div>
                </div>
            @else
                <x-ui.empty-state title="Konten Belum Tersedia"
                    description="Halaman penjelasan sistem pembelajaran sedang dalam tahap penyusunan oleh pihak akademik.">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </x-ui.empty-state>
            @endif
            
            <!-- Quick Links / CTA E-Learning Box -->
            <div class="card mt-10 flex flex-col items-center justify-between gap-6 border-l-4 border-l-unmaris-yellow p-6 md:mt-14 md:flex-row md:p-10">
                <div class="w-full text-center md:text-left">
                    <h2 class="heading-3 mb-3">Akses E-Learning UNMARIS</h2>
                    <p class="text-sm leading-relaxed text-slate-600 md:text-base">Masuk ke portal pembelajaran daring terpadu untuk mengakses materi perkuliahan, mengikuti kuis, dan mengumpulkan tugas mata kuliah Anda secara digital.</p>
                </div>
                <!-- Ganti href dengan URL portal e-learning kampus Anda nantinya -->
                <a href="#" class="btn-navy w-full shrink-0 md:w-auto">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Login Mahasiswa
                </a>
            </div>

        </div>
    </section>
</x-layouts.app>