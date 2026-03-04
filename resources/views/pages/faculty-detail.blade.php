<x-layouts.app :title="$faculty->name . ' - UNMARIS'">
    
    <!-- Hero Section Fakultas -->
    <section class="relative bg-unmaris-blue text-white overflow-hidden py-20 md:py-32">
        @if($faculty->image)
            <div class="absolute inset-0 z-0 opacity-20">
                <img src="{{ asset('storage/'.$faculty->image) }}" alt="{{ $faculty->name }}" class="w-full h-full object-cover">
            </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-unmaris-blue to-transparent z-10"></div>
        
        <div class="container mx-auto px-4 text-center relative z-20">
            <span class="inline-block py-1 px-4 rounded-full bg-unmaris-yellow text-unmaris-blue text-sm font-bold tracking-wider mb-6 uppercase shadow-sm">Profil Fakultas</span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight">{{ $faculty->name }}</h1>
            <p class="text-lg md:text-xl text-gray-200 max-w-3xl mx-auto">{{ $faculty->description }}</p>
        </div>
    </section>

    <!-- Konten Visi Misi & Info -->
    <section class="py-16 bg-white border-b border-gray-100">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <!-- Kiri: Visi & Misi Fakultas -->
                <div class="lg:col-span-2 space-y-12">
                    @if($faculty->vision)
                    <div>
                        <h2 class="text-3xl font-bold text-unmaris-blue mb-6 border-b-4 border-unmaris-yellow inline-block pb-2">Visi Fakultas</h2>
                        <div class="prose prose-lg max-w-none text-gray-700">
                            {!! $faculty->vision !!}
                        </div>
                    </div>
                    @endif

                    @if($faculty->mission)
                    <div>
                        <h2 class="text-3xl font-bold text-unmaris-blue mb-6 border-b-4 border-unmaris-yellow inline-block pb-2">Misi Fakultas</h2>
                        <div class="prose prose-lg max-w-none text-gray-700 prose-ul:list-disc prose-ul:pl-5 prose-li:marker:text-unmaris-yellow">
                            {!! $faculty->mission !!}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Kanan: Sidebar Kontak -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-gray-50 p-8 rounded-3xl shadow-sm border-t-8 border-unmaris-yellow">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Hubungi Fakultas</h3>
                        <ul class="space-y-4">
                            @if($faculty->email)
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-unmaris-blue mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <div><p class="text-sm font-bold text-gray-900">Email Resmi</p><a href="mailto:{{ $faculty->email }}" class="text-unmaris-blue hover:underline">{{ $faculty->email }}</a></div>
                            </li>
                            @endif
                            @if($faculty->phone)
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-unmaris-blue mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <div><p class="text-sm font-bold text-gray-900">Telepon / WA</p><p class="text-gray-600">{{ $faculty->phone }}</p></div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Studi Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-extrabold text-unmaris-blue inline-block border-b-4 border-unmaris-yellow pb-2">Program Studi Kami</h2>
                <p class="text-gray-500 mt-4 text-lg">Pilih jalur masa depanmu melalui program studi berakreditasi tinggi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                @foreach($faculty->studyPrograms as $prodi)
                    <!-- Tambahkan x-data di level card dan wire:key untuk isolasi state yang sempurna -->
                    <div 
                        x-data="{ activeTab: 'karir' }" 
                        wire:key="prodi-{{ $prodi->id }}"
                        class="bg-white rounded-3xl shadow-md border border-gray-100 flex flex-col h-full overflow-hidden group hover:shadow-2xl transition-all duration-300"
                    >
                        <div class="p-8 pb-0">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-2xl font-bold text-gray-900 group-hover:text-unmaris-blue transition-colors">{{ $prodi->name }}</h3>
                                <span class="bg-unmaris-yellow text-unmaris-blue text-xs font-extrabold px-3 py-1 rounded shadow-sm">{{ $prodi->degree }}</span>
                            </div>
                            <div class="flex items-center gap-2 mb-6">
                                <span class="bg-green-100 text-green-800 font-bold text-[10px] px-2 py-0.5 rounded border border-green-200 uppercase">Akreditasi {{ $prodi->accreditation }}</span>
                            </div>
                            <p class="text-gray-600 mb-6 leading-relaxed">{{ $prodi->description }}</p>
                        </div>

                        <!-- Info Tab Dinamis (Visi, Misi, Karir) -->
                        <div class="mt-auto bg-gray-50 p-6 pt-4 border-t border-gray-100">
                            <!-- Navigasi Tab Kecil -->
                            <div class="flex gap-2 mb-4">
                                <button @click="activeTab = 'visi'" :class="activeTab === 'visi' ? 'bg-unmaris-blue text-white shadow-md' : 'bg-white text-gray-500 hover:bg-gray-100'" class="px-3 py-1.5 text-[10px] font-bold rounded-lg transition-all uppercase tracking-tighter">Visi</button>
                                <button @click="activeTab = 'misi'" :class="activeTab === 'misi' ? 'bg-unmaris-blue text-white shadow-md' : 'bg-white text-gray-500 hover:bg-gray-100'" class="px-3 py-1.5 text-[10px] font-bold rounded-lg transition-all uppercase tracking-tighter">Misi</button>
                                <button @click="activeTab = 'karir'" :class="activeTab === 'karir' ? 'bg-unmaris-blue text-white shadow-md' : 'bg-white text-gray-500 hover:bg-gray-100'" class="px-3 py-1.5 text-[10px] font-bold rounded-lg transition-all uppercase tracking-tighter">Prospek Karir</button>
                            </div>

                            <!-- Konten Tab -->
                            <div class="min-h-[140px] prose prose-sm max-w-none text-gray-700 prose-ul:list-disc prose-ul:pl-4 prose-li:marker:text-unmaris-blue">
                                <div x-show="activeTab === 'visi'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2">
                                    <h5 class="font-bold text-unmaris-blue mb-2 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Visi Keilmuan
                                    </h5>
                                    {!! $prodi->vision ?? 'Belum ada data visi.' !!}
                                </div>
                                <div x-show="activeTab === 'misi'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2">
                                    <h5 class="font-bold text-unmaris-blue mb-2 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        Misi Program Studi
                                    </h5>
                                    {!! $prodi->mission ?? 'Belum ada data misi.' !!}
                                </div>
                                <div x-show="activeTab === 'karir'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2">
                                    <h5 class="font-bold text-unmaris-blue mb-2 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        Peluang Kerja Lulusan
                                    </h5>
                                    {!! $prodi->career_prospects ?? 'Belum ada data prospek karir.' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-16 text-center">
                <a href="{{ route('faculties.index') }}" class="inline-flex items-center justify-center px-8 py-3 border-2 border-unmaris-blue font-bold rounded-full text-unmaris-blue hover:bg-unmaris-blue hover:text-white transition-all shadow-md group">
                    <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Lihat Semua Fakultas
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>