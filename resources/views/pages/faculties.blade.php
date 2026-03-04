<x-layouts.app title="Fakultas & Program Studi - UNMARIS">
    
    <!-- Header Section -->
    <section class="bg-unmaris-blue text-white py-20 relative overflow-hidden">
        <!-- Aksen Dekoratif -->
        <div class="absolute inset-0 opacity-10">
            <svg class="absolute right-0 top-0 h-full w-1/2" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                <polygon points="0,100 100,0 100,100" />
            </svg>
        </div>

        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 border-b-4 border-unmaris-yellow inline-block pb-2">Fakultas & Program Studi</h1>
            <p class="text-lg md:text-xl text-gray-200 max-w-3xl mx-auto">Temukan program studi pilihanmu di Universitas Stella Maris Sumba. Kami menawarkan berbagai disiplin ilmu yang dirancang khusus untuk memenuhi kebutuhan industri dan tantangan global masa kini.</p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-20 bg-gray-50 min-h-screen relative -mt-8 z-20 rounded-t-3xl">
        <div class="container mx-auto px-4 max-w-6xl">
            
            @if($faculties->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Data Belum Tersedia</h3>
                    <p class="text-gray-500 text-lg">Saat ini belum ada data fakultas yang diunggah ke dalam sistem.</p>
                </div>
            @else
                <div class="space-y-16">
                    @foreach($faculties as $faculty)
                        <!-- Card Fakultas (Horizontal Split Layout) -->
                        <div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-gray-100 overflow-hidden flex flex-col lg:flex-row group">
                            
                            <!-- Bagian Kiri: Gambar Fakultas -->
                            <div class="lg:w-5/12 relative h-72 lg:h-auto overflow-hidden bg-unmaris-blue shrink-0">
                                @if($faculty->image)
                                    <img src="{{ asset('storage/'.$faculty->image) }}" alt="{{ $faculty->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                                @else
                                    <!-- Placeholder Pattern jika gambar kosong -->
                                    <div class="w-full h-full flex items-center justify-center opacity-30 bg-gradient-to-br from-unmaris-blue to-blue-900">
                                        <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                @endif
                                
                                <!-- Overlay Gradien Bawah -->
                                <div class="absolute inset-0 bg-gradient-to-t from-unmaris-blue/90 via-unmaris-blue/20 to-transparent"></div>
                                
                                <!-- Badge Jumlah Prodi -->
                                <div class="absolute bottom-6 left-6 text-white">
                                    <span class="inline-flex items-center bg-unmaris-yellow text-unmaris-blue text-xs font-bold px-4 py-2 rounded-full uppercase tracking-wider shadow-md">
                                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/></svg>
                                        {{ $faculty->studyPrograms->count() }} Program Studi
                                    </span>
                                </div>
                            </div>

                            <!-- Bagian Kanan: Konten Informasi -->
                            <div class="lg:w-7/12 p-8 md:p-10 flex flex-col justify-between">
                                <div>
                                    <a href="{{ route('faculties.detail', $faculty->slug) }}" class="inline-block mb-4 outline-none">
                                        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 group-hover:text-unmaris-blue transition-colors duration-300 leading-tight">{{ $faculty->name }}</h2>
                                    </a>
                                    
                                    @if($faculty->description)
                                        <p class="text-gray-600 mb-8 line-clamp-3 leading-relaxed text-lg">
                                            {{ $faculty->description }}
                                        </p>
                                    @endif

                                    <!-- Daftar Program Studi (Chips Layout) -->
                                    <div class="mb-8">
                                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">Pilihan Program Studi</h3>
                                        
                                        @if($faculty->studyPrograms->isEmpty())
                                            <p class="text-gray-500 italic text-sm">Belum ada program studi di fakultas ini.</p>
                                        @else
                                            <div class="flex flex-wrap gap-3">
                                                @foreach($faculty->studyPrograms as $prodi)
                                                    <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 flex items-center gap-3 hover:border-unmaris-blue hover:shadow-sm transition cursor-default group/prodi">
                                                        <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-unmaris-blue font-extrabold text-sm border border-gray-100 group-hover/prodi:bg-unmaris-blue group-hover/prodi:text-white transition-colors">
                                                            {{ $prodi->degree }}
                                                        </div>
                                                        <div>
                                                            <h4 class="font-bold text-gray-900 text-sm md:text-base leading-tight">{{ $prodi->name }}</h4>
                                                            <span class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider">
                                                                Akreditasi: 
                                                                <span class="{{ in_array($prodi->accreditation, ['Unggul', 'A']) ? 'text-green-600' : (in_array($prodi->accreditation, ['Baik Sekali', 'B']) ? 'text-yellow-600' : 'text-blue-600') }}">
                                                                    {{ $prodi->accreditation }}
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Button (Bawah Kanan) -->
                                <div class="mt-4 pt-6 border-t border-gray-100 flex items-center justify-end">
                                    <a href="{{ route('faculties.detail', $faculty->slug) }}" class="inline-flex items-center text-unmaris-blue font-bold text-lg hover:text-unmaris-yellow transition group/btn">
                                        Selengkapnya
                                        <span class="w-10 h-10 ml-3 rounded-full bg-blue-50 flex items-center justify-center group-hover/btn:bg-unmaris-yellow group-hover/btn:text-unmaris-blue transition-colors">
                                            <svg class="w-5 h-5 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="relative bg-unmaris-blue text-white py-20 overflow-hidden border-t-8 border-unmaris-yellow">
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon fill="currentColor" points="100,100 0,0 100,0"/>
            </svg>
        </div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-3xl md:text-4xl font-extrabold mb-6">Sudah Menemukan Program Studimu?</h2>
            <p class="text-xl text-gray-200 mb-10 max-w-2xl mx-auto">Mari wujudkan cita-cita masa depanmu bersama kampus peradaban, Universitas Stella Maris Sumba.</p>
            <a href="https://pmb.unmaris.ac.id" target="_blank" class="inline-flex items-center justify-center bg-unmaris-yellow text-unmaris-blue font-extrabold text-lg px-10 py-4 rounded-full hover:bg-yellow-400 hover:scale-105 transition transform shadow-xl">
                Daftar Mahasiswa Baru
                <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </a>
        </div>
    </section>

</x-layouts.app>