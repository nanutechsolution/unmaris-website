<x-layouts.app title="Jaringan Kemitraan & Kerjasama - UNMARIS" description="Daftar instansi, perusahaan, dan universitas yang telah menjalin kerjasama strategis dengan Universitas Stella Maris Sumba.">

    <!-- Header Section (Premium & Clean) -->
    <section class="bg-unmaris-blue text-white py-16 md:py-24 relative overflow-hidden border-b-8 border-unmaris-yellow">
        <!-- Elemen Dekoratif Netwroking -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                <polygon points="0,100 100,0 100,100" />
            </svg>
        </div>
        
        <!-- Ornamen Lingkaran -->
        <div class="absolute top-1/2 left-0 -translate-y-1/2 w-64 h-64 bg-unmaris-yellow rounded-full blur-[100px] opacity-20 z-0 pointer-events-none"></div>
        <div class="absolute top-0 right-10 w-48 h-48 bg-blue-400 rounded-full blur-[80px] opacity-20 z-0 pointer-events-none"></div>
        
        <div class="container mx-auto px-4 text-center relative z-10">
            <span class="inline-block py-1.5 px-4 rounded-full bg-white/10 border border-white/20 text-white text-[10px] md:text-xs font-bold tracking-widest uppercase mb-6 shadow-sm backdrop-blur-sm">Sinergi & Kolaborasi Global</span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black mb-6 leading-tight tracking-tighter">Jaringan <span class="text-unmaris-yellow">Kemitraan</span></h1>
            <p class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-200 max-w-3xl mx-auto font-medium px-2 leading-relaxed">Kami bangga dapat berkolaborasi dengan berbagai institusi terkemuka lintas sektor untuk memastikan lulusan UNMARIS relevan dengan kebutuhan industri dan masyarakat luas.</p>
        </div>
    </section>

    <!-- Konten Utama: Daftar Mitra -->
    <section class="py-16 md:py-24 bg-gray-50 min-h-screen relative -mt-8 md:-mt-10 z-20 rounded-t-3xl md:rounded-t-[3rem] shadow-sm">
        <div class="container mx-auto px-4 max-w-6xl">
            
            @if($partnersGrouped->isEmpty())
                <div class="text-center py-20 bg-white rounded-[2rem] border border-gray-100 shadow-sm px-4">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"></path></svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-black text-gray-800">Data Mitra Belum Tersedia</h3>
                    <p class="text-gray-500 mt-2 text-sm md:text-base max-w-md mx-auto">Daftar jaringan kerjasama institusi sedang dalam proses pembaruan data.</p>
                </div>
            @else
                
                <div class="space-y-16 md:space-y-24">
                    <!-- Helper Teks Kategori untuk Mapping -->
                    @php
                        $categoryTitles = [
                            'pemerintah' => 'Pemerintah & Instansi Negara',
                            'kesehatan' => 'Fasilitas Kesehatan & Rumah Sakit',
                            'pendidikan' => 'Institusi Pendidikan Tinggi',
                            'perusahaan' => 'Mitra Industri & Perusahaan',
                            'lainnya' => 'Organisasi & Mitra Strategis Lainnya'
                        ];
                    @endphp

                    <!-- Looping Group Kategori -->
                    @foreach(['pemerintah', 'kesehatan', 'pendidikan', 'perusahaan', 'lainnya'] as $type)
                        @if($partnersGrouped->has($type))
                            <div class="category-section">
                                <!-- Judul Kategori -->
                                <div class="text-center md:text-left mb-8 md:mb-10">
                                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 inline-block border-b-4 border-unmaris-yellow pb-2">
                                        {{ $categoryTitles[$type] }}
                                    </h2>
                                </div>

                                <!-- Grid Logo Mitra -->
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">
                                    @foreach($partnersGrouped[$type] as $partner)
                                        <div class="group bg-white p-4 md:p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-unmaris-yellow transition-all duration-300 flex flex-col items-center justify-center text-center relative h-40 md:h-48">
                                            
                                            <!-- Link Wrapper (Jika website tersedia) -->
                                            @if($partner->website_url)
                                                <a href="{{ $partner->website_url }}" target="_blank" class="absolute inset-0 z-10" aria-label="Kunjungi website {{ $partner->name }}"></a>
                                            @endif
                                            
                                            <!-- Logo -->
                                            <div class="w-full h-16 md:h-20 flex items-center justify-center mb-4">
                                                @if(Str::startsWith($partner->logo, 'http'))
                                                    <!-- Kondisi jika menggunakan seeder link UI Avatars -->
                                                    <img src="{{ $partner->logo }}" alt="{{ $partner->name }}" class="max-h-full max-w-full object-contain grayscale group-hover:grayscale-0 transition-all duration-500 transform group-hover:scale-110">
                                                @else
                                                    <!-- Kondisi upload file nyata -->
                                                    <img src="{{ asset('storage/'.$partner->logo) }}" alt="{{ $partner->name }}" class="max-h-full max-w-full object-contain grayscale group-hover:grayscale-0 transition-all duration-500 transform group-hover:scale-110">
                                                @endif
                                            </div>

                                            <!-- Nama Mitra (Muncul Halus saat Hover) -->
                                            <h3 class="text-xs md:text-sm font-bold text-gray-600 group-hover:text-unmaris-blue transition-colors line-clamp-2 px-1">
                                                {{ $partner->name }}
                                            </h3>

                                            <!-- Indikator Link -->
                                            @if($partner->website_url)
                                                <div class="absolute top-3 right-3 text-gray-300 group-hover:text-unmaris-yellow transition-colors opacity-0 group-hover:opacity-100">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

            @endif

            <!-- Ajakan Kerjasama Box -->
            <div class="mt-20 md:mt-32 bg-white rounded-2xl md:rounded-[3rem] p-8 md:p-16 text-center border border-gray-100 shadow-xl relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-50"></div>
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-unmaris-yellow/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-unmaris-blue text-white rounded-2xl flex items-center justify-center mx-auto mb-6 md:mb-8 shadow-lg transform group-hover:rotate-12 transition-transform duration-500">
                        <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"></path></svg>
                    </div>
                    <h3 class="text-2xl md:text-4xl font-black text-unmaris-blue mb-4">Tertarik Menjadi Mitra UNMARIS?</h3>
                    <p class="text-gray-600 text-sm md:text-lg max-w-2xl mx-auto mb-8 md:mb-10 leading-relaxed">Universitas Stella Maris Sumba membuka pintu seluas-luasnya untuk inisiatif kolaborasi di bidang riset, penyaluran tenaga kerja, magang mahasiswa, hingga pengabdian masyarakat.</p>
                    
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center bg-unmaris-yellow text-unmaris-blue font-black text-xs md:text-sm px-8 py-4 rounded-full uppercase tracking-widest hover:bg-unmaris-blue hover:text-white transition-colors shadow-lg">
                        Hubungi Tim Kerjasama
                        <svg class="w-4 h-4 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>

        </div>
    </section>

</x-layouts.app>