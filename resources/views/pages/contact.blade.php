<x-layouts.app :title="$page->title . ' - UNMARIS'" :description="$page->meta_description">
    
    <!-- Header Section -->
    <section class="bg-unmaris-blue text-white py-16 md:py-24 relative overflow-hidden">
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 border-b-4 border-unmaris-yellow inline-block pb-2">{{ $page->title }}</h1>
            <p class="text-lg text-gray-200 max-w-2xl mx-auto mt-4">{{ $page->meta_description }}</p>
        </div>
    </section>

    <section class="py-16 md:py-24 bg-gray-50 relative -mt-10 z-20 rounded-t-3xl">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-col lg:flex-row gap-12">
                
                <!-- Kiri: Informasi Kontak & Maps Dinamis -->
                <div class="w-full lg:w-5/12 space-y-8">
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h2 class="text-2xl font-bold text-unmaris-blue mb-6">Informasi Kontak</h2>
                        
                        <div class="space-y-6">
                            <!-- Alamat -->
                            @if(!empty($page->content['alamat']))
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-blue-50 text-unmaris-blue rounded-xl flex items-center justify-center shrink-0 mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Alamat Kampus</h4>
                                    <p class="text-gray-600 mt-1">{{ $page->content['alamat'] }}</p>
                                </div>
                            </div>
                            @endif

                            <!-- Email -->
                            @if(!empty($page->content['email']))
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-blue-50 text-unmaris-blue rounded-xl flex items-center justify-center shrink-0 mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Email Resmi</h4>
                                    <a href="mailto:{{ $page->content['email'] }}" class="text-unmaris-blue hover:text-unmaris-yellow font-medium mt-1 inline-block transition">{{ $page->content['email'] }}</a>
                                </div>
                            </div>
                            @endif

                            <!-- Telepon -->
                            @if(!empty($page->content['telepon']))
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-blue-50 text-unmaris-blue rounded-xl flex items-center justify-center shrink-0 mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Telepon / WhatsApp</h4>
                                    <p class="text-gray-600 mt-1">{{ $page->content['telepon'] }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Google Maps Iframe Dinamis -->
                    @if(!empty($page->content['peta_embed']))
                    <div class="bg-white p-2 rounded-3xl shadow-sm border border-gray-100 h-64 overflow-hidden relative group">
                        <iframe src="{{ $page->content['peta_embed'] }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="rounded-2xl grayscale group-hover:grayscale-0 transition duration-500"></iframe>
                    </div>
                    @endif
                </div>

                <!-- Kanan: Livewire Form (Tetap Sama) -->
                <div class="w-full lg:w-7/12">
                    <div class="bg-white p-8 md:p-10 rounded-3xl shadow-lg border-t-8 border-unmaris-yellow">
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Kirim Pesan</h2>
                        <p class="text-gray-500 mb-8 font-medium">Isi formulir di bawah ini dengan lengkap. Staf kami akan membalas pesan Anda dalam 1x24 jam kerja.</p>
                        
                        <!-- Memanggil komponen Livewire Form -->
                        <livewire:contact-form />
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-layouts.app>