<x-layouts.app title="500 Kesalahan Server - UNMARIS" description="Maaf, server kami sedang mengalami gangguan.">
    
    <section class="relative min-h-[75vh] flex items-center justify-center py-16 md:py-24 bg-gray-50 overflow-hidden">
        
        <!-- Aksen Latar Belakang Geometris -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-[20%] -right-[10%] w-[50%] h-[70%] bg-red-600 opacity-[0.03] rounded-full blur-3xl"></div>
            <div class="absolute -bottom-[20%] -left-[10%] w-[40%] h-[60%] bg-unmaris-yellow opacity-[0.05] rounded-full blur-3xl"></div>
            
            <!-- Pola Grid Halus -->
            <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(#1B1464 1px, transparent 1px); background-size: 30px 30px;"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 text-center">
            <div class="max-w-2xl mx-auto flex flex-col items-center">
                
                <!-- Animasi Ilustrasi 500 -->
                <div class="relative mb-8 transform transition-transform duration-700 hover:scale-105">
                    <h1 class="text-[120px] md:text-[180px] font-black leading-none text-transparent bg-clip-text bg-gradient-to-br from-gray-700 to-gray-900 drop-shadow-sm select-none">
                        500
                    </h1>
                    
                    <!-- Lingkaran Kuning Dekoratif -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-3/4 h-3/4 bg-unmaris-yellow rounded-full mix-blend-multiply blur-2xl opacity-40 animate-pulse z-[-1]"></div>
                    
                    <!-- Ikon Roda Gigi / Server Error (Kecil di pojok angka) -->
                    <div class="absolute top-10 right-0 md:-right-8 animate-[spin_6s_linear_infinite]">
                        <svg class="w-12 h-12 md:w-16 md:h-16 text-red-500 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Pesan Error -->
                <span class="inline-block py-1 px-3 border border-red-200 text-red-600 bg-red-50 rounded-full text-[10px] md:text-xs font-bold tracking-widest uppercase mb-4">Waduh, Gangguan Teknis!</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Kesalahan Server Internal</h2>
                <p class="text-gray-500 text-lg md:text-xl mb-10 leading-relaxed font-medium">
                    Maaf, server kami sedang mengalami kendala teknis. Tim IT kami sedang berusaha memperbaikinya secepat mungkin. Silakan coba beberapa saat lagi.
                </p>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full justify-center">
                    <button onclick="window.location.reload()" class="w-full sm:w-auto inline-flex justify-center items-center bg-unmaris-blue text-white px-8 py-3.5 md:py-4 rounded-full font-black text-xs md:text-sm uppercase tracking-widest hover:bg-unmaris-yellow hover:text-unmaris-blue hover:scale-105 transition-all shadow-lg group">
                        <svg class="w-4 h-4 mr-2 transform group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Muat Ulang Halaman
                    </button>
                    
                    <a href="{{ url('/') }}" class="w-full sm:w-auto inline-flex justify-center items-center bg-white border-2 border-gray-200 text-gray-700 px-8 py-3.5 md:py-4 rounded-full font-bold text-xs md:text-sm uppercase tracking-widest hover:border-unmaris-blue hover:text-unmaris-blue transition-all">
                        Kembali ke Beranda
                    </a>
                </div>

            </div>
        </div>
    </section>

</x-layouts.app>