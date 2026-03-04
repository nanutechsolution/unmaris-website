<x-layouts.app title="Fakultas & Program Studi - UNMARIS">
    
    <!-- Hero Section (Premium Minimalist) -->
    <section class="bg-unmaris-blue text-white py-20 md:py-32 relative overflow-hidden">
        <!-- Background Pattern & Glow -->
        <div class="absolute inset-0 opacity-5">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                <path d="M0 0 L100 0 L100 100 L0 100 Z" />
            </svg>
        </div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-unmaris-yellow rounded-full blur-[120px] opacity-20 pointer-events-none z-0"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-blue-400 rounded-full blur-[100px] opacity-20 pointer-events-none z-0"></div>

        <div class="container mx-auto px-4 sm:px-6 relative z-10 text-center max-w-4xl">
            <span class="text-unmaris-yellow font-black tracking-[0.3em] uppercase text-[10px] md:text-xs mb-4 md:mb-6 block">Jalur Pendidikan & Keilmuan</span>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black mb-6 tracking-tighter leading-tight">Fakultas & <span class="text-unmaris-yellow">Prodi</span></h1>
            <p class="text-gray-300 text-base md:text-lg lg:text-xl leading-relaxed font-medium">Temukan program studi pilihanmu di Universitas Stella Maris Sumba. Kami menawarkan berbagai disiplin ilmu yang dirancang untuk memenuhi kebutuhan industri dan tantangan global masa kini.</p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-16 md:py-24 bg-gray-50 min-h-screen relative -mt-10 z-20 rounded-t-[3rem] shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 max-w-7xl">
            
            @if($faculties->isEmpty())
                <div class="text-center py-20 md:py-32 bg-white rounded-[3rem] border border-gray-100 shadow-sm">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Data Belum Tersedia</h3>
                    <p class="text-gray-500 font-medium">Saat ini belum ada data fakultas yang dipublikasikan ke dalam sistem.</p>
                </div>
            @else
                <div class="space-y-12 md:space-y-20">
                    @foreach($faculties as $faculty)
                        <!-- Card Fakultas (Horizontal Split Layout) -->
                        <div class="bg-white rounded-[2.5rem] shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden flex flex-col lg:flex-row group">
                            
                            <!-- Bagian Kiri: Gambar Fakultas -->
                            <div class="lg:w-5/12 xl:w-4/12 relative h-64 sm:h-80 lg:h-auto overflow-hidden bg-unmaris-blue shrink-0">
                                @if($faculty->image)
                                    <img src="{{ asset('storage/'.$faculty->image) }}" alt="{{ $faculty->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-1000">
                                @else
                                    <!-- Placeholder Pattern jika gambar kosong -->
                                    <div class="w-full h-full flex items-center justify-center opacity-30 bg-gradient-to-br from-unmaris-blue to-blue-900">
                                        <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                @endif
                                
                                <!-- Overlay Gradien Bawah & Badge -->
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/20 to-transparent opacity-80"></div>
                                
                                <div class="absolute bottom-6 left-6 md:bottom-8 md:left-8 text-white z-10">
                                    <span class="inline-flex items-center bg-unmaris-yellow text-unmaris-blue text-[10px] md:text-xs font-black px-4 py-2 rounded-full uppercase tracking-widest shadow-lg">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        {{ $faculty->studyPrograms->count() }} Program Studi
                                    </span>
                                </div>
                            </div>

                            <!-- Bagian Kanan: Konten Informasi -->
                            <div class="lg:w-7/12 xl:w-8/12 p-6 sm:p-8 md:p-12 flex flex-col justify-between relative">
                                <div>
                                    <a href="{{ route('faculties.detail', $faculty->slug) }}" class="inline-block mb-4 md:mb-6 outline-none group/title">
                                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-gray-900 group-hover/title:text-unmaris-blue transition-colors duration-300 leading-tight tracking-tighter">{{ $faculty->name }}</h2>
                                    </a>
                                    
                                    @if($faculty->description)
                                        <p class="text-gray-500 mb-8 md:mb-12 line-clamp-3 leading-relaxed text-sm md:text-base lg:text-lg font-medium">
                                            {{ $faculty->description }}
                                        </p>
                                    @endif

                                    <!-- Daftar Program Studi (Grid Layout yang Rapi) -->
                                    <div class="mb-8">
                                        <h3 class="text-[10px] md:text-xs font-black text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-4">
                                            <span>Pilihan Program Studi</span>
                                            <div class="h-px flex-grow bg-gray-100"></div>
                                        </h3>
                                        
                                        @if($faculty->studyPrograms->isEmpty())
                                            <div class="bg-gray-50 border border-dashed border-gray-200 rounded-2xl p-6 text-center">
                                                <p class="text-gray-500 italic text-sm font-medium">Belum ada program studi di fakultas ini.</p>
                                            </div>
                                        @else
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                @foreach($faculty->studyPrograms as $prodi)
                                                    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-4 flex items-start gap-4 hover:border-unmaris-yellow hover:shadow-md transition-all cursor-default group/prodi">
                                                        <div class="w-12 h-12 shrink-0 rounded-xl bg-blue-50 text-unmaris-blue flex items-center justify-center font-black text-sm group-hover/prodi:bg-unmaris-yellow transition-colors">
                                                            {{ $prodi->degree }}
                                                        </div>
                                                        <div class="flex-grow pt-0.5">
                                                            <h4 class="font-extrabold text-gray-900 text-sm md:text-base leading-snug mb-2 group-hover/prodi:text-unmaris-blue transition-colors">{{ $prodi->name }}</h4>
                                                            <div class="flex items-center">
                                                                <span class="inline-flex items-center text-[9px] md:text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-lg border {{ in_array($prodi->accreditation, ['Unggul', 'A']) ? 'bg-green-50 text-green-700 border-green-200' : (in_array($prodi->accreditation, ['Baik Sekali', 'B']) ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : 'bg-blue-50 text-blue-700 border-blue-200') }}">
                                                                    Akreditasi {{ $prodi->accreditation }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-end">
                                    <a href="{{ route('faculties.detail', $faculty->slug) }}" class="inline-flex items-center text-unmaris-blue font-black text-xs md:text-sm uppercase tracking-widest hover:text-unmaris-yellow transition group/btn">
                                        Eksplorasi Fakultas
                                        <span class="w-10 h-10 ml-4 rounded-full bg-blue-50 flex items-center justify-center group-hover/btn:bg-unmaris-yellow group-hover/btn:text-unmaris-blue transition-colors shadow-sm">
                                            <svg class="w-5 h-5 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
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
    <section class="relative bg-unmaris-blue text-white py-20 md:py-24 overflow-hidden border-t-8 border-unmaris-yellow">
        <!-- Dekorasi Background -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon fill="currentColor" points="100,100 0,0 100,0"/>
            </svg>
        </div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-unmaris-yellow rounded-full blur-[150px] opacity-20 pointer-events-none z-0"></div>

        <div class="container mx-auto px-4 text-center relative z-10 max-w-4xl">
            <span class="inline-block py-1.5 px-5 rounded-full bg-white/10 border border-white/20 text-white text-[10px] md:text-xs font-bold tracking-widest uppercase mb-6 shadow-sm backdrop-blur-sm">Langkah Selanjutnya</span>
            <h2 class="text-3xl md:text-5xl lg:text-6xl font-black mb-6 leading-tight">Sudah Menemukan<br>Program Studimu?</h2>
            <p class="text-lg md:text-xl text-gray-300 mb-10 max-w-2xl mx-auto font-medium">Mari wujudkan cita-cita masa depanmu bersama kampus peradaban, Universitas Stella Maris Sumba.</p>
            
            <div class="flex justify-center">
                <a href="https://pmb.unmaris.ac.id" target="_blank" class="inline-flex items-center justify-center bg-unmaris-yellow text-unmaris-blue font-black text-sm md:text-lg uppercase tracking-wider px-8 md:px-12 py-4 md:py-5 rounded-full hover:bg-white hover:scale-105 transition-all transform shadow-[0_10px_40px_rgba(253,224,26,0.3)]">
                    Daftar Mahasiswa Baru
                    <svg class="w-5 h-5 md:w-6 md:h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>