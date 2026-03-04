<x-layouts.app title="Informasi Beasiswa - UNMARIS" description="Daftar peluang beasiswa dan bantuan biaya pendidikan untuk mahasiswa Universitas Stella Maris Sumba.">

    <!-- Header Section (Elegan & Memotivasi) -->
    <section class="bg-unmaris-blue text-white py-16 md:py-24 relative overflow-hidden border-b-8 border-unmaris-yellow">
        <!-- Pattern Dekoratif -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                <polygon points="0,100 100,0 100,100" />
            </svg>
        </div>
        <div class="absolute top-1/2 right-0 -translate-y-1/2 w-64 h-64 bg-unmaris-yellow rounded-full blur-[100px] opacity-20 z-0 pointer-events-none"></div>
        
        <div class="container mx-auto px-4 text-center relative z-10">
            <span class="inline-block py-1.5 px-4 rounded-full bg-white/10 border border-white/20 text-white text-[10px] md:text-xs font-bold tracking-widest uppercase mb-4 md:mb-6 shadow-sm backdrop-blur-sm">Layanan Kemahasiswaan</span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black mb-4 md:mb-6 leading-tight tracking-tighter">Peluang <span class="text-unmaris-yellow">Beasiswa</span></h1>
            <p class="text-sm sm:text-base md:text-lg text-gray-200 max-w-3xl mx-auto font-medium px-2 leading-relaxed">Universitas Stella Maris Sumba berkomitmen agar tidak ada mahasiswa yang putus asa meraih cita-cita karena kendala biaya. Temukan program bantuan yang sesuai untuk Anda.</p>
        </div>
    </section>

    <!-- Konten Utama: Daftar Beasiswa -->
    <section class="py-12 md:py-20 bg-gray-50 min-h-screen relative -mt-8 md:-mt-10 z-20 rounded-t-3xl md:rounded-t-[3rem] shadow-sm">
        <div class="container mx-auto px-4 max-w-5xl">
            
            @if($scholarships->isEmpty())
                <div class="text-center py-20 bg-white rounded-[2rem] border border-gray-100 shadow-sm px-4">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zm0 0v7"></path></svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-black text-gray-800">Informasi Belum Tersedia</h3>
                    <p class="text-gray-500 mt-2 text-sm md:text-base max-w-md mx-auto">Saat ini belum ada informasi pendaftaran beasiswa yang dipublikasikan.</p>
                </div>
            @else
                <div class="space-y-8 md:space-y-12">
                    @foreach($scholarships as $scholarship)
                        <!-- Card Beasiswa Menggunakan Alpine.js untuk fitur Toggle/Accordion Persyaratan -->
                        <div x-data="{ expanded: false }" class="bg-white rounded-2xl md:rounded-[2rem] shadow-md border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 {{ $scholarship->is_open ? 'border-l-8 border-l-green-500' : 'border-l-8 border-l-gray-300 opacity-80' }}">
                            
                            <div class="p-6 md:p-8 lg:p-10">
                                <div class="flex flex-col md:flex-row justify-between md:items-start gap-4 mb-6">
                                    <div class="flex-grow">
                                        <div class="flex flex-wrap items-center gap-2 mb-3">
                                            <span class="text-[10px] md:text-xs font-black text-unmaris-blue uppercase tracking-widest bg-blue-50 px-3 py-1 rounded-lg">
                                                {{ $scholarship->provider }}
                                            </span>
                                            
                                            <!-- Status Badge -->
                                            @if($scholarship->is_open)
                                                <span class="inline-flex items-center text-[10px] md:text-xs font-bold text-green-700 bg-green-100 px-3 py-1 rounded-lg border border-green-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5 animate-pulse"></span> Pendaftaran Buka
                                                </span>
                                            @else
                                                <span class="inline-flex items-center text-[10px] md:text-xs font-bold text-red-700 bg-red-100 px-3 py-1 rounded-lg border border-red-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span> Pendaftaran Tutup
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <h2 class="text-2xl md:text-3xl font-black text-gray-900 leading-tight mb-2">{{ $scholarship->title }}</h2>
                                    </div>

                                    <!-- Tanggal Tutup Box -->
                                    @if($scholarship->end_date)
                                    <div class="shrink-0 bg-gray-50 border border-gray-200 rounded-xl p-3 text-center min-w-[120px]">
                                        <span class="block text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">Batas Akhir</span>
                                        <span class="block text-sm md:text-base font-black text-unmaris-blue">{{ $scholarship->end_date->format('d M Y') }}</span>
                                    </div>
                                    @endif
                                </div>

                                <p class="text-gray-600 text-sm md:text-base leading-relaxed mb-8">
                                    {{ $scholarship->description }}
                                </p>

                                <div class="flex flex-col sm:flex-row gap-4 items-center justify-between border-t border-gray-100 pt-6">
                                    <!-- Tombol Expand Detail -->
                                    <button @click="expanded = !expanded" class="w-full sm:w-auto flex items-center justify-center text-unmaris-blue font-bold text-xs md:text-sm hover:text-unmaris-yellow transition-colors group">
                                        <span x-text="expanded ? 'Tutup Detail Persyaratan' : 'Lihat Cakupan & Persyaratan'"></span>
                                        <svg :class="{'transform rotate-180': expanded}" class="w-4 h-4 ml-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>

                                    <!-- Tombol Daftar (Hanya aktif jika masih buka) -->
                                    @if($scholarship->is_open && $scholarship->registration_url)
                                        <a href="{{ $scholarship->registration_url }}" target="_blank" class="w-full sm:w-auto text-center px-8 py-3 bg-unmaris-yellow text-unmaris-blue font-black rounded-full shadow-md hover:shadow-lg hover:scale-105 transition-all text-xs md:text-sm uppercase tracking-widest">
                                            Daftar Sekarang
                                        </a>
                                    @elseif(!$scholarship->is_open)
                                        <span class="w-full sm:w-auto text-center px-8 py-3 bg-gray-200 text-gray-500 font-bold rounded-full text-xs md:text-sm uppercase tracking-widest cursor-not-allowed">
                                            Sudah Berakhir
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Expandable Area (Fasilitas & Syarat) -->
                            <div x-show="expanded" x-collapse style="display: none;" class="bg-gray-50 border-t border-gray-200 p-6 md:p-8 lg:p-10">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <!-- Fasilitas/Manfaat -->
                                    @if($scholarship->benefits)
                                    <div>
                                        <h4 class="text-base font-black text-unmaris-blue mb-4 flex items-center">
                                            <div class="w-8 h-8 rounded-lg bg-yellow-100 text-unmaris-yellow flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            Cakupan Beasiswa
                                        </h4>
                                        <div class="text-sm text-gray-700 leading-relaxed [&_ul]:list-disc [&_ul]:pl-5 [&_ul]:space-y-2 marker:[&_ul]:text-green-500">
                                            {!! $scholarship->benefits !!}
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Persyaratan -->
                                    @if($scholarship->requirements)
                                    <div>
                                        <h4 class="text-base font-black text-unmaris-blue mb-4 flex items-center">
                                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-unmaris-blue flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            Persyaratan Utama
                                        </h4>
                                        <div class="text-sm text-gray-700 leading-relaxed [&_ul]:list-disc [&_ul]:pl-5 [&_ul]:space-y-2 marker:[&_ul]:text-unmaris-blue">
                                            {!! $scholarship->requirements !!}
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </section>
</x-layouts.app>