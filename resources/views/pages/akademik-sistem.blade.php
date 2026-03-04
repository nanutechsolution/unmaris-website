<x-layouts.app :title="$page->title . ' - UNMARIS'" :description="$page->meta_description">

    <!-- Header Section -->
    <section class="bg-unmaris-blue text-white py-16 md:py-24 relative overflow-hidden">
        <!-- Elemen Dekoratif -->
        <div class="absolute inset-0 opacity-10">
            <svg class="absolute right-0 top-0 h-full w-1/2" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                <polygon points="0,100 100,0 100,100" />
            </svg>
        </div>
        
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 border-b-4 border-unmaris-yellow inline-block pb-2">{{ $page->title }}</h1>
            <p class="text-lg text-gray-200 max-w-2xl mx-auto mt-4">{{ $page->meta_description }}</p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-16 md:py-24 bg-white border-b border-gray-100 relative -mt-8 z-20 rounded-t-3xl">
        <div class="container mx-auto px-4 max-w-4xl">
            
            @if(!empty($page->content['umum']))
                <div class="bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-gray-100">
                    <!-- 
                        Class prose Tailwind akan otomatis mempercantik konten HTML dari database 
                    -->
                    <div class="prose prose-lg max-w-none text-gray-700
                                prose-headings:text-unmaris-blue prose-headings:font-bold
                                prose-h2:border-b-2 prose-h2:border-unmaris-yellow prose-h2:inline-block prose-h2:pb-2 prose-h2:mt-10 prose-h2:mb-6
                                prose-h3:text-2xl prose-h3:mt-8 prose-h3:mb-4
                                prose-p:leading-relaxed prose-p:mb-6
                                prose-a:text-unmaris-blue hover:prose-a:text-unmaris-yellow
                                prose-ul:list-disc prose-ul:pl-6 prose-li:marker:text-unmaris-yellow prose-li:font-medium
                                prose-img:rounded-2xl prose-img:shadow-md">
                        {!! $page->content['umum'] !!}
                    </div>
                </div>
            @else
                <!-- Tampilan kosong jika konten umum belum diisi oleh Admin -->
                <div class="text-center py-20 bg-gray-50 rounded-3xl border border-gray-200 shadow-sm">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <h3 class="text-2xl font-bold text-gray-700">Konten Belum Tersedia</h3>
                    <p class="text-gray-500 mt-2">Halaman sistem pembelajaran sedang dalam tahap penyusunan.</p>
                </div>
            @endif
            
            <!-- Quick Links / CTA E-Learning Box -->
            <div class="mt-12 bg-gray-50 rounded-3xl p-8 md:p-10 flex flex-col md:flex-row items-center justify-between gap-8 border-l-8 border-unmaris-yellow shadow-sm hover:shadow-md transition-shadow">
                <div class="text-center md:text-left">
                    <h4 class="text-2xl font-bold text-unmaris-blue mb-2">Akses E-Learning UNMARIS</h4>
                    <p class="text-gray-600 text-lg">Masuk ke portal pembelajaran daring terpadu untuk mengakses materi, kuis, dan tugas mata kuliah Anda.</p>
                </div>
                <!-- Ganti href dengan URL portal e-learning kampus Anda nantinya -->
                <a href="#" class="shrink-0 bg-unmaris-blue text-white px-8 py-4 rounded-full font-bold hover:bg-unmaris-yellow hover:text-unmaris-blue transition-colors shadow-lg text-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    Login Mahasiswa
                </a>
            </div>

        </div>
    </section>
</x-layouts.app>