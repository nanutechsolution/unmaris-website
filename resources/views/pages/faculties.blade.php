<x-layouts.app title="Fakultas & Program Studi - UNMARIS">
    
    <x-ui.page-hero title="Fakultas & Program Studi" eyebrow="Jalur Pendidikan & Keilmuan"
        description="Temukan program studi pilihanmu di Universitas Stella Maris Sumba. Kami menawarkan berbagai disiplin ilmu yang dirancang untuk memenuhi kebutuhan industri dan tantangan global masa kini."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Fakultas & Program Studi'],
        ]" />

    <!-- Content Section -->
    <section class="section-y bg-slate-50">
        <div class="container-page">
            
            @if($faculties->isEmpty())
                <x-ui.empty-state title="Data Belum Tersedia"
                    description="Saat ini belum ada data fakultas yang dipublikasikan ke dalam sistem.">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </x-ui.empty-state>
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
                                                    <a href="{{ route('prodi.detail', [$faculty->slug, $prodi->slug]) }}" class="bg-white border border-gray-100 shadow-sm rounded-2xl p-4 flex items-start gap-4 hover:border-unmaris-yellow hover:shadow-md transition-all group/prodi focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-unmaris-yellow">
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
                                                    </a>
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
    <section class="relative overflow-hidden border-t-[6px] border-unmaris-yellow bg-unmaris-blue py-16 text-white md:py-24">
        <div class="pointer-events-none absolute inset-0 opacity-[0.07]" aria-hidden="true">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon fill="currentColor" points="100,100 0,0 100,0" />
            </svg>
        </div>
        <div class="pointer-events-none absolute left-1/2 top-1/2 h-[420px] w-[420px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-unmaris-yellow opacity-20 blur-[110px] md:h-[700px] md:w-[700px] md:blur-[150px]" aria-hidden="true"></div>

        <div class="container-page relative z-10">
            <div class="mx-auto max-w-3xl text-center">
                <span class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-[10px] font-extrabold uppercase tracking-widest text-white backdrop-blur-sm md:text-xs">
                    Langkah Selanjutnya
                </span>
                <h2 class="text-balance text-3xl font-extrabold leading-tight text-white sm:text-4xl md:text-5xl">
                    Sudah Menemukan Program Studimu?
                </h2>
                <p class="mx-auto mt-5 max-w-2xl text-sm leading-relaxed text-slate-300 md:text-base lg:text-lg">
                    Mari wujudkan cita-cita masa depanmu bersama kampus peradaban, Universitas Stella Maris Sumba.
                </p>

                <div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <a href="https://pmb.unmarissumba.ac.id" target="_blank" rel="noopener" class="btn-primary w-full sm:w-auto">
                        Daftar Mahasiswa Baru
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>