<x-layouts.app title="404 Halaman Tidak Ditemukan - UNMARIS" description="Maaf, halaman yang Anda cari tidak dapat ditemukan.">
    
    <section class="relative min-h-[75vh] flex items-center justify-center py-16 md:py-24 bg-gray-50 overflow-hidden">
        
        <!-- Aksen Latar Belakang Geometris -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-[20%] -right-[10%] w-[50%] h-[70%] bg-unmaris-blue opacity-[0.03] rounded-full blur-3xl"></div>
            <div class="absolute -bottom-[20%] -left-[10%] w-[40%] h-[60%] bg-unmaris-yellow opacity-[0.05] rounded-full blur-3xl"></div>
            
            <!-- Pola Grid Halus -->
            <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(#1B1464 1px, transparent 1px); background-size: 30px 30px;"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 text-center">
            <div class="max-w-2xl mx-auto flex flex-col items-center">
                
                <!-- Animasi Ilustrasi 404 -->
                <div class="relative mb-8 transform transition-transform duration-700 hover:scale-105">
                    <h1 class="text-[120px] md:text-[180px] font-black leading-none text-transparent bg-clip-text bg-gradient-to-br from-unmaris-blue to-blue-800 drop-shadow-sm select-none">
                        404
                    </h1>
                    
                    <!-- Lingkaran Kuning Dekoratif -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-3/4 h-3/4 bg-unmaris-yellow rounded-full mix-blend-multiply blur-2xl opacity-40 animate-pulse z-[-1]"></div>
                    
                    <!-- Ikon Planet / Tersesat (Kecil di pojok angka 4) -->
                    <div class="absolute top-10 right-0 md:-right-8 animate-[bounce_4s_infinite]">
                        <svg class="w-12 h-12 md:w-16 md:h-16 text-unmaris-yellow drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Pesan Error -->
                <span class="inline-block py-1 px-3 border border-unmaris-yellow text-unmaris-blue bg-unmaris-yellow/10 rounded-full text-[10px] md:text-xs font-bold tracking-widest uppercase mb-4">Waduh, Tersesat!</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Halaman Tidak Ditemukan</h2>
                <p class="text-gray-500 text-lg md:text-xl mb-10 leading-relaxed font-medium">
                    Maaf, halaman yang Anda cari mungkin telah dipindahkan, dihapus, namanya berubah, atau untuk sementara tidak tersedia.
                </p>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full justify-center">
                    <a href="{{ url('/') }}" class="w-full sm:w-auto inline-flex justify-center items-center bg-unmaris-blue text-white px-8 py-3.5 md:py-4 rounded-full font-black text-xs md:text-sm uppercase tracking-widest hover:bg-unmaris-yellow hover:text-unmaris-blue hover:scale-105 transition-all shadow-lg group">
                        <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Beranda
                    </a>
                    
                    <a href="{{ url('/kontak') }}" class="w-full sm:w-auto inline-flex justify-center items-center bg-white border-2 border-gray-200 text-gray-700 px-8 py-3.5 md:py-4 rounded-full font-bold text-xs md:text-sm uppercase tracking-widest hover:border-unmaris-blue hover:text-unmaris-blue transition-all">
                        Hubungi Kampus
                    </a>
                </div>

            </div>
        </div>
    </section>

</x-layouts.app>