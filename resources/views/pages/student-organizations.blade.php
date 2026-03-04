<x-layouts.app title="Organisasi Mahasiswa & UKM - UNMARIS" description="Kenali berbagai Badan Eksekutif Mahasiswa (BEM), HMPS, dan Unit Kegiatan Mahasiswa (UKM) di Universitas Stella Maris Sumba.">

    <!-- Header Section (Energik & Dinamis) -->
    <section class="bg-unmaris-blue text-white py-16 md:py-24 relative overflow-hidden border-b-8 border-unmaris-yellow">
        <!-- Pattern Dekoratif -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                <polygon points="100,100 0,0 100,0" />
            </svg>
        </div>
        <div class="absolute top-0 right-10 w-64 h-64 bg-unmaris-yellow rounded-full blur-[100px] opacity-20 z-0 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-blue-400 rounded-full blur-[80px] opacity-20 z-0 pointer-events-none"></div>
        
        <div class="container mx-auto px-4 text-center relative z-10">
            <span class="inline-block py-1.5 px-4 rounded-full bg-white/10 border border-white/20 text-white text-[10px] md:text-xs font-bold tracking-widest uppercase mb-4 md:mb-6 shadow-sm backdrop-blur-sm">Kehidupan Kampus</span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black mb-4 md:mb-6 leading-tight tracking-tighter">Organisasi <span class="text-unmaris-yellow">Mahasiswa</span></h1>
            <p class="text-sm sm:text-base md:text-lg text-gray-200 max-w-3xl mx-auto font-medium px-2 leading-relaxed">Lebih dari sekadar ruang kuliah. UNMARIS menyediakan wadah bagi mahasiswa untuk mengembangkan jiwa kepemimpinan, bakat, dan kreativitas melalui berbagai organisasi kemahasiswaan.</p>
        </div>
    </section>

    <!-- Konten Utama: Daftar Organisasi -->
    <section class="py-16 md:py-24 bg-gray-50 min-h-screen relative -mt-8 md:-mt-10 z-20 rounded-t-3xl md:rounded-t-[3rem] shadow-sm">
        <div class="container mx-auto px-4 max-w-7xl">
            
            @if($organizationsGrouped->isEmpty())
                <div class="text-center py-20 bg-white rounded-[2rem] border border-gray-100 shadow-sm px-4">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-black text-gray-800">Data Organisasi Belum Tersedia</h3>
                    <p class="text-gray-500 mt-2 text-sm md:text-base max-w-md mx-auto">Informasi profil BEM, HMPS, dan UKM sedang dalam tahap pembaruan data.</p>
                </div>
            @else
                
                <div class="space-y-20 md:space-y-28">
                    <!-- Helper Array untuk Konfigurasi Kategori -->
                    @php
                        $categoryConfig = [
                            'bem_dpm' => [
                                'title' => 'Lembaga Eksekutif & Legislatif',
                                'subtitle' => 'Organisasi tertinggi mahasiswa tingkat Universitas dan Fakultas.',
                                'color' => 'blue', // Untuk variasi warna border
                            ],
                            'hmps' => [
                                'title' => 'Himpunan Mahasiswa Program Studi',
                                'subtitle' => 'Wadah pengembangan keilmuan spesifik sesuai jurusan mahasiswa.',
                                'color' => 'yellow',
                            ],
                            'ukm' => [
                                'title' => 'Unit Kegiatan Mahasiswa (UKM)',
                                'subtitle' => 'Tempat berkumpulnya mahasiswa dengan minat, bakat, dan hobi yang sama.',
                                'color' => 'green',
                            ]
                        ];
                    @endphp

                    <!-- Looping Group Kategori -->
                    @foreach(['bem_dpm', 'hmps', 'ukm'] as $type)
                        @if($organizationsGrouped->has($type))
                            <div class="category-section">
                                <!-- Judul Kategori -->
                                <div class="text-center mb-10 md:mb-12">
                                    <h2 class="text-2xl md:text-4xl font-black text-gray-900 inline-block border-b-4 border-unmaris-yellow pb-2 mb-3">
                                        {{ $categoryConfig[$type]['title'] }}
                                    </h2>
                                    <p class="text-gray-500 text-sm md:text-base font-medium">{{ $categoryConfig[$type]['subtitle'] }}</p>
                                </div>

                                <!-- Grid Kartu Organisasi -->
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                                    @foreach($organizationsGrouped[$type] as $org)
                                        <div class="bg-white rounded-[2rem] p-6 md:p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 flex flex-col h-full group border-t-4 {{ $type === 'bem_dpm' ? 'border-t-unmaris-blue' : ($type === 'hmps' ? 'border-t-unmaris-yellow' : 'border-t-green-500') }}">
                                            
                                            <!-- Header Card: Logo & Nama -->
                                            <div class="flex items-start gap-4 mb-6">
                                                <!-- Logo -->
                                                <div class="w-16 h-16 md:w-20 md:h-20 shrink-0 bg-gray-50 rounded-2xl flex items-center justify-center p-2 border border-gray-100 group-hover:border-unmaris-yellow transition-colors overflow-hidden">
                                                    @if($org->logo)
                                                        @if(Str::startsWith($org->logo, 'http'))
                                                            <img src="{{ $org->logo }}" alt="Logo {{ $org->name }}" class="w-full h-full object-contain">
                                                        @else
                                                            <img src="{{ asset('storage/'.$org->logo) }}" alt="Logo {{ $org->name }}" class="w-full h-full object-contain transform group-hover:scale-110 transition duration-500">
                                                        @endif
                                                    @else
                                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                    @endif
                                                </div>
                                                
                                                <!-- Nama Org -->
                                                <div class="flex-grow pt-1">
                                                    <h3 class="text-lg md:text-xl font-bold text-gray-900 leading-tight group-hover:text-unmaris-blue transition-colors">
                                                        {{ $org->name }}
                                                    </h3>
                                                    @if($org->leader_name)
                                                        <span class="inline-block mt-2 text-[10px] md:text-xs font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-md">
                                                            Ketua: {{ $org->leader_name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Deskripsi -->
                                            <p class="text-gray-600 text-sm leading-relaxed flex-grow mb-6">
                                                {{ $org->description }}
                                            </p>

                                            <!-- Tautan Sosial Media Bawah -->
                                            @if($org->social_media_link)
                                                <div class="mt-auto pt-4 border-t border-gray-100">
                                                    <a href="{{ $org->social_media_link }}" target="_blank" class="inline-flex items-center text-xs font-bold text-unmaris-blue hover:text-unmaris-yellow transition-colors group/link">
                                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                                        Kunjungi Profil Media Sosial
                                                        <svg class="w-3.5 h-3.5 ml-1 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                                    </a>
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
        </div>
    </section>

</x-layouts.app>