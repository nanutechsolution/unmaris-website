<x-layouts.app :title="$page->title . ' - UNMARIS'" :description="$page->meta_description">

    <!-- Header Section (Mobile First & Premium) -->
    <section class="bg-unmaris-blue text-white py-16 md:py-24 lg:py-32 relative overflow-hidden border-b-8 border-unmaris-yellow">
        <!-- Elemen Dekoratif -->
        <div class="absolute inset-0 opacity-10">
            <svg class="absolute right-0 top-0 h-full w-full md:w-1/2" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                <polygon points="0,100 100,0 100,100" />
            </svg>
        </div>
        <div class="absolute -top-24 -left-24 w-64 h-64 md:w-96 md:h-96 bg-unmaris-yellow rounded-full blur-[80px] md:blur-[120px] opacity-20 z-0 pointer-events-none"></div>
        
        <div class="container mx-auto px-4 text-center relative z-10">
            <span class="inline-block py-1 px-3 md:py-1.5 md:px-4 rounded-full bg-white/10 border border-white/20 text-white text-[10px] md:text-xs font-bold tracking-widest uppercase mb-4 md:mb-6 shadow-sm backdrop-blur-sm">Pusat Informasi Akademik</span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black mb-4 md:mb-6 leading-tight tracking-tighter">{{ $page->title }}</h1>
            <p class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-200 max-w-3xl mx-auto mt-2 md:mt-4 font-medium px-2 leading-relaxed">{{ $page->meta_description }}</p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-12 md:py-20 lg:py-24 bg-gray-50 min-h-screen relative -mt-8 md:-mt-10 z-20 rounded-t-3xl md:rounded-t-[3rem] shadow-sm">
        <div class="container mx-auto px-4 max-w-4xl">
            
            @if(!empty($page->content['umum']))
                <div class="bg-white p-6 sm:p-8 md:p-12 lg:p-14 rounded-2xl md:rounded-[2.5rem] shadow-lg border border-gray-100">
                    <!-- 
                        Penyesuaian Ekstrem Rich Text:
                        Menggunakan target dinamis [&_tag] untuk memastikan semua format HTML dari admin 
                        ter-render rapi dan konsisten (Bullet point, angka, tabel, dll)
                    -->
                    <div class="text-gray-700 text-base sm:text-lg md:text-xl leading-relaxed
                                [&_p]:mb-6
                                [&_ul]:list-disc [&_ul]:pl-6 [&_ul]:mb-6 [&_ul]:space-y-2 marker:[&_ul]:text-unmaris-yellow marker:[&_ul]:text-xl
                                [&_ol]:list-decimal [&_ol]:pl-6 [&_ol]:mb-6 [&_ol]:space-y-2 marker:[&_ol]:text-unmaris-blue marker:[&_ol]:font-bold
                                [&_h2]:text-2xl sm:[&_h2]:text-3xl [&_h2]:font-black [&_h2]:text-unmaris-blue [&_h2]:border-b-4 [&_h2]:border-unmaris-yellow [&_h2]:inline-block [&_h2]:pb-2 [&_h2]:mt-10 [&_h2]:mb-6
                                [&_h3]:text-xl sm:[&_h3]:text-2xl [&_h3]:font-bold [&_h3]:text-unmaris-blue [&_h3]:mt-8 [&_h3]:mb-4
                                [&_h4]:text-lg sm:[&_h4]:text-xl [&_h4]:font-bold [&_h4]:text-gray-900 [&_h4]:mt-6 [&_h4]:mb-3
                                [&_strong]:text-unmaris-blue [&_strong]:font-extrabold
                                [&_a]:text-unmaris-blue [&_a]:font-bold [&_a]:underline hover:[&_a]:text-unmaris-yellow [&_a]:transition-colors
                                [&_blockquote]:border-l-4 [&_blockquote]:border-unmaris-yellow [&_blockquote]:bg-gray-50 [&_blockquote]:py-4 [&_blockquote]:px-6 [&_blockquote]:rounded-r-2xl [&_blockquote]:italic [&_blockquote]:text-gray-600 [&_blockquote]:mb-6
                                [&_img]:rounded-2xl [&_img]:shadow-md [&_img]:mx-auto [&_img]:mb-6 [&_img]:max-w-full
                                [&_table]:w-full [&_table]:border-collapse [&_table]:rounded-xl [&_table]:overflow-hidden [&_table]:mb-6 
                                [&_th]:bg-unmaris-blue [&_th]:text-white [&_th]:p-4 [&_th]:text-left 
                                [&_td]:p-4 [&_td]:border-b [&_td]:border-gray-200 hover:[&_tr]:bg-gray-50">
                        {!! $page->content['umum'] !!}
                    </div>
                </div>
            @else
                <!-- Tampilan kosong jika konten umum belum diisi oleh Admin -->
                <div class="text-center py-20 bg-white rounded-[2rem] border border-gray-100 shadow-sm px-4">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-black text-gray-800">Konten Belum Tersedia</h3>
                    <p class="text-gray-500 mt-2 text-sm md:text-base max-w-md mx-auto">Halaman penjelasan sistem pembelajaran sedang dalam tahap penyusunan oleh pihak akademik.</p>
                </div>
            @endif
            
            <!-- Quick Links / CTA E-Learning Box -->
            <div class="mt-10 md:mt-16 bg-white rounded-2xl md:rounded-[2.5rem] p-6 sm:p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-6 md:gap-10 border border-gray-100 border-l-8 border-l-unmaris-yellow shadow-md hover:shadow-xl transition-all duration-300 group">
                <div class="text-center md:text-left w-full">
                    <h4 class="text-2xl sm:text-3xl font-black text-unmaris-blue mb-3">Akses E-Learning UNMARIS</h4>
                    <p class="text-gray-600 text-sm sm:text-base leading-relaxed">Masuk ke portal pembelajaran daring terpadu untuk mengakses materi perkuliahan, mengikuti kuis, dan mengumpulkan tugas mata kuliah Anda secara digital.</p>
                </div>
                <!-- Ganti href dengan URL portal e-learning kampus Anda nantinya -->
                <a href="https://elearning.unmarissumba.ac.id" target="_blank" class="w-full md:w-auto shrink-0 flex items-center justify-center bg-unmaris-blue text-white px-8 md:px-10 py-4 rounded-full font-bold uppercase tracking-widest text-xs md:text-sm hover:bg-unmaris-yellow hover:text-unmaris-blue transition-all shadow-lg group-hover:scale-105">
                    <svg class="w-5 h-5 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Login Mahasiswa
                </a>
            </div>

        </div>
    </section>
</x-layouts.app>