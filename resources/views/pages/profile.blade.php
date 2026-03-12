<x-layouts.app :title="$page->title . ' - UNMARIS'" :description="$page->meta_description">
    
    <!-- Header Section Dinamis -->
    <section class="bg-unmaris-blue text-white py-16 md:py-24 relative overflow-hidden">
        <!-- Aksen Geometris -->
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

    <!-- Content Section (Menggunakan Key Spesifik dari JSON/Array) -->
    <section class="py-16 md:py-20 bg-white border-b border-gray-100">
        <div class="container mx-auto px-4 max-w-4xl">
            
            <!-- Sambutan Rektor -->
            @if(!empty($page->content['sambutan']))
            @php
                // Mengambil data Rektor (Pimpinan urutan pertama) secara otomatis
                $rektor = isset($leaders) && $leaders->count() > 0 ? $leaders->first() : null;
            @endphp
            <div class="flex flex-col md:flex-row gap-8 items-center mb-16 bg-gray-50 p-8 md:p-10 rounded-3xl border-t-4 border-unmaris-yellow shadow-sm">
                <div class="w-full md:w-1/3 flex justify-center">
                    <div class="w-48 h-48 bg-gray-200 rounded-full overflow-hidden border-4 border-unmaris-blue shadow-lg relative">
                        <!-- Tampilkan foto rektor dari modul Pimpinan jika ada -->
                        @if($rektor && $rektor->image)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($rektor->image) }}" alt="{{ $rektor->name }}" class="w-full h-full object-cover">
                        @else
                            <!-- Placeholder jika tidak ada foto -->
                            <div class="absolute inset-0 flex items-center justify-center bg-unmaris-blue/10">
                                 <svg class="w-20 h-20 text-unmaris-blue opacity-20" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="w-full md:w-2/3">
                    <h2 class="text-2xl font-bold text-unmaris-blue mb-4 flex items-center gap-2">
                        Sambutan Plt. Rektor
                    </h2>
                    <div class="text-gray-600 mb-4 italic text-lg leading-relaxed">
                        "{!! strip_tags($page->content['sambutan']) !!}"
                    </div>
                    <!-- Menampilkan nama rektor secara dinamis dari modul Pimpinan -->
                    <p class="font-bold text-gray-900">- {{ $rektor ? $rektor->name : 'Rektor Universitas Stella Maris Sumba' }}</p>
                </div>
            </div>
            @endif

            <!-- Visi & Misi -->
            <div class="mb-16">
                <div class="text-center md:text-left mb-8">
                    <h2 class="text-3xl font-bold text-unmaris-blue border-b-4 border-unmaris-yellow inline-block pb-2">Visi & Misi</h2>
                </div>

                @if(!empty($page->content['visi']))
                <div class="bg-unmaris-blue text-white p-8 md:p-10 rounded-3xl shadow-lg mb-8 relative overflow-hidden transform transition hover:-translate-y-1">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-unmaris-yellow rounded-full opacity-20 blur-2xl"></div>
                    <h3 class="text-2xl font-bold mb-4 text-unmaris-yellow flex items-center gap-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Visi
                    </h3>
                    <div class="text-gray-100 text-lg md:text-xl leading-relaxed font-medium">
                        {!! strip_tags($page->content['visi']) !!}
                    </div>
                </div>
                @endif

                @if(!empty($page->content['misi']))
                <div class="bg-gray-50 p-8 md:p-10 rounded-3xl shadow-sm border border-gray-100 border-l-8 border-unmaris-yellow transform transition hover:-translate-y-1">
                    <h3 class="text-2xl font-bold mb-6 text-unmaris-blue flex items-center gap-3">
                        <svg class="w-8 h-8 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Misi
                    </h3>
                    <div class="text-gray-700 text-lg space-y-3 pl-5 [&>ul]:list-disc [&>ul]:space-y-3 marker:text-unmaris-yellow marker:font-bold">
                        {!! $page->content['misi'] !!}
                    </div>
                </div>
                @endif
            </div>

            <!-- Tujuan Institusi -->
            @if(!empty($page->content['tujuan']))
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-unmaris-blue mb-6 border-b-4 border-unmaris-yellow inline-block pb-2">Tujuan Institusi</h2>
                <!-- Styling khusus untuk list bersarang (ol > li > ol > li) -->
                <div class="text-gray-700 text-lg leading-relaxed space-y-4 [&>ol]:list-decimal [&>ol]:pl-5 [&>ol>li]:mb-4 [&>ol>li>ol]:list-[lower-alpha] [&>ol>li>ol]:pl-6 [&>ol>li>ol>li]:mt-2 [&>p]:mb-4 marker:font-bold marker:text-unmaris-blue">
                    {!! $page->content['tujuan'] !!}
                </div>
            </div>
            @endif

            <!-- Ciri Khas "KASIH" -->
            @if(!empty($page->content['ciri_khas_kasih']))
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-unmaris-blue mb-6 border-b-4 border-unmaris-yellow inline-block pb-2">Ciri Khas "KASIH"</h2>
                <div class="bg-gray-50 p-8 md:p-10 rounded-3xl shadow-sm border border-gray-100 border-l-8 border-unmaris-blue transform transition hover:-translate-y-1">
                    <div class="text-gray-700 text-lg space-y-4 pl-2 [&>ul]:space-y-4 [&>ul>li>strong]:text-unmaris-blue [&>ul>li>strong]:text-xl [&>ul>li>strong]:mr-2">
                        {!! $page->content['ciri_khas_kasih'] !!}
                    </div>
                </div>
            </div>
            @endif

            <!-- Sasaran & Strategi -->
            @if(!empty($page->content['sasaran_strategi']))
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-unmaris-blue mb-6 border-b-4 border-unmaris-yellow inline-block pb-2">Sasaran & Strategi</h2>
                <div class="bg-unmaris-blue text-white p-8 md:p-10 rounded-3xl shadow-lg relative overflow-hidden transform transition hover:-translate-y-1">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-unmaris-yellow rounded-full opacity-10 blur-2xl"></div>
                    <div class="text-gray-100 text-lg space-y-3 pl-5 [&>ul]:list-disc [&>ul]:space-y-4 marker:text-unmaris-yellow">
                        {!! $page->content['sasaran_strategi'] !!}
                    </div>
                </div>
            </div>
            @endif

            <!-- Sejarah Singkat -->
            @if(!empty($page->content['sejarah']))
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-unmaris-blue mb-6 border-b-4 border-unmaris-yellow inline-block pb-2">Sejarah Singkat</h2>
                <div class="text-gray-700 text-lg leading-relaxed space-y-6 [&>p]:mb-4 [&>h2]:text-2xl [&>h2]:font-bold [&>h2]:text-unmaris-blue [&>h2]:mt-8 [&>h2]:mb-4 [&>h3]:text-xl [&>h3]:font-bold [&>h3]:text-gray-800">
                    {!! $page->content['sejarah'] !!}
                </div>
            </div>
            @endif

            <!-- BAGAN STRUKTUR ORGANISASI (Dari JSON Content Page) -->
            <div class="mb-10">
                <h2 class="text-3xl font-bold text-unmaris-blue mb-6 border-b-4 border-unmaris-yellow inline-block pb-2">Struktur Organisasi</h2>
                <div class="bg-gray-50 p-4 md:p-8 rounded-3xl shadow-sm border border-gray-100 flex justify-center items-center min-h-[300px]">
                    @if(!empty($page->content['struktur_organisasi']))
                        <!-- Jika Admin sudah upload gambar bagan organisasi -->
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($page->content['struktur_organisasi']) }}" alt="Bagan Struktur Organisasi UNMARIS" class="max-w-full h-auto rounded-xl shadow-sm">
                    @else
                        <!-- Placeholder jika Admin belum upload gambar -->
                        <div class="text-center py-10">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <p class="text-gray-500 font-medium">Bagan Struktur Organisasi belum diunggah.</p>
                            <p class="text-sm text-gray-400 mt-2">Gambar bagan dapat diperbarui melalui panel admin.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </section>

    <!-- Section Struktur Kepemimpinan Dinamis (Diambil dari Model Leader) -->
    @if(isset($leaders) && $leaders->count() > 0)
    <section class="py-16 md:py-24 bg-gray-50">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-unmaris-blue inline-block border-b-4 border-unmaris-yellow pb-2">Jajaran Pimpinan</h2>
                <p class="text-gray-500 mt-4 text-lg">Pimpinan Universitas Stella Maris Sumba yang berdedikasi tinggi membangun generasi penerus bangsa.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center justify-center">
                @foreach($leaders as $index => $leader)
                    <!-- Highlight untuk urutan pertama (Rektor) -->
                    <div class="{{ $index === 0 ? 'md:col-span-3 flex justify-center mb-10' : 'flex justify-center' }}">
                        <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-2xl border-t-4 {{ $index === 0 ? 'border-unmaris-blue w-full max-w-lg' : 'border-unmaris-yellow w-full max-w-sm' }} transition-all duration-300 transform hover:-translate-y-2 group">
                            
                            <!-- Foto Pimpinan dengan Efek Glow -->
                            <div class="{{ $index === 0 ? 'w-44 h-44' : 'w-32 h-32' }} mx-auto mb-6 relative">
                                <div class="absolute inset-0 bg-unmaris-blue rounded-full blur-lg opacity-10 group-hover:opacity-20 transition duration-300 transform translate-y-3"></div>
                                
                                @if($leader->image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($leader->image) }}" alt="{{ $leader->name }}" class="w-full h-full rounded-full border-4 border-white object-cover shadow-md relative z-10" onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($leader->name) }}&background=f3f4f6&color=1B1464&size=256';">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($leader->name) }}&background=f3f4f6&color=1B1464&size=256" alt="{{ $leader->name }}" class="w-full h-full rounded-full border-4 border-white object-cover shadow-md relative z-10">
                                @endif
                            </div>

                            <!-- Detail Pimpinan -->
                            <h4 class="font-bold text-gray-900 {{ $index === 0 ? 'text-2xl mb-2' : 'text-xl mb-1' }}">{{ $leader->name }}</h4>
                            
                            @if($index === 0)
                                <p class="text-unmaris-blue font-bold mt-3 bg-unmaris-yellow bg-opacity-30 inline-block px-6 py-2 rounded-full text-sm tracking-widest uppercase shadow-sm">
                                    {{ $leader->position }}
                                </p>
                            @else
                                <p class="text-unmaris-blue font-semibold mt-2">{{ $leader->position }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</x-layouts.app>