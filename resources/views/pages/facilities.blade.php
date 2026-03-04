<x-layouts.app title="Fasilitas Kampus - UNMARIS">

    <!-- Header Section -->
    <section class="bg-unmaris-blue text-white py-16 md:py-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="absolute right-0 top-0 h-full w-1/2" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                <polygon points="0,100 100,0 100,100" />
            </svg>
        </div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 border-b-4 border-unmaris-yellow inline-block pb-2">Fasilitas Kampus</h1>
            <p class="text-lg md:text-xl text-gray-200 max-w-3xl mx-auto mt-4">Lingkungan belajar yang kondusif, modern, dan inovatif untuk mendukung pengembangan potensi mahasiswa secara maksimal.</p>
        </div>
    </section>

    <!-- Galeri Fasilitas -->
    <section class="py-16 md:py-24 bg-gray-50 relative -mt-8 z-20 rounded-t-3xl">
        <div class="container mx-auto px-4 max-w-7xl">

            @if(isset($facilities) && $facilities->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                @foreach($facilities as $facility)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group flex flex-col h-full transform hover:-translate-y-2">
                    <!-- Image Container -->
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($facility->image) }}" alt="{{ $facility->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent opacity-60 group-hover:opacity-80 transition-opacity"></div>
                        <div class="absolute bottom-0 left-0 p-6 w-full">
                            <h3 class="text-2xl font-bold text-white leading-tight group-hover:text-unmaris-yellow transition-colors">{{ $facility->name }}</h3>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 md:p-8 flex-grow flex flex-col">
                        <p class="text-gray-600 leading-relaxed">{{ $facility->description ?? 'Fasilitas terpadu untuk menunjang aktivitas akademik dan non-akademik civitas akademika UNMARIS.' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <!-- Kosong -->
            <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Data Fasilitas</h3>
                <p class="text-gray-500">Data galeri fasilitas kampus sedang diperbarui oleh tim admin.</p>
            </div>
            @endif  

        </div>
    </section>

</x-layouts.app>