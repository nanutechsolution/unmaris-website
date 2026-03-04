<x-layouts.app :title="$news->title . ' - UNMARIS'" :description="$news->excerpt">
    <!-- JSON-LD Schema untuk Artikel (SEO) -->
    <!-- Menggunakan @@ agar Blade tidak menganggapnya sebagai directive PHP -->
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "Article",
            "headline": "{{ addslashes($news->title) }}",
            "datePublished": "{{ $news->published_at ? $news->published_at->toIso8601String() : '' }}",
            "dateModified": "{{ $news->updated_at->toIso8601String() }}",
            "author": [{
                "@@type": "Organization",
                "name": "Universitas Stella Maris Sumba"
            }],
            "description": "{{ addslashes($news->excerpt) }}",
            "image": "{{ $news->featured_image ? Storage::url($news->featured_image) : asset('images/logo-unmaris.png') }}"
        }
    </script>

    <!-- Reading Progress Bar (Menggunakan Alpine.js Native) -->
    <!-- Menggunakan x-on:scroll alih-alih @scroll untuk menghindari konflik Blade -->
    <div class="fixed top-0 left-0 w-full h-1.5 z-[60] pointer-events-none"
         x-data="{ scrollProgress: 0 }"
         x-on:scroll.window="
            let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            scrollProgress = (winScroll / height) * 100;
         ">
        <div class="h-full bg-unmaris-yellow transition-all duration-150 shadow-[0_0_10px_rgba(253,224,26,0.8)]"
             :style="`width: ${scrollProgress}%`"></div>
    </div>

    <div class="bg-gray-50 min-h-screen pb-24">
        <!-- Header Hero -->
        <header class="bg-unmaris-blue text-white pt-16 pb-32 relative overflow-hidden border-b-8 border-unmaris-yellow">
            <div class="absolute inset-0 opacity-10">
                <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                    <path d="M0 0 L100 0 L100 100 L0 100 Z" />
                </svg>
            </div>

            <div class="container mx-auto px-4 relative z-10 max-w-5xl text-center">
                <!-- Breadcrumbs -->
                <nav class="flex justify-center text-[10px] font-black uppercase tracking-[0.3em] text-unmaris-yellow mb-8 gap-2">
                    <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                    <span class="opacity-30">/</span>
                    <a href="{{ route('news.index') }}" class="hover:text-white transition">Berita</a>
                    <span class="opacity-30">/</span>
                    <span class="text-white">{{ $news->category->name }}</span>
                </nav>

                <h1 class="text-4xl md:text-6xl lg:text-7xl font-black mb-10 leading-[1.1] tracking-tighter drop-shadow-sm">
                    {{ $news->title }}
                </h1>

                <div class="flex flex-wrap justify-center items-center gap-6 text-xs font-bold uppercase tracking-widest text-gray-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-unmaris-yellow flex items-center justify-center text-unmaris-blue font-black shadow-lg">U</div>
                        <span class="text-white">Humas UNMARIS</span>
                    </div>
                    <div class="h-4 w-px bg-white/20 hidden md:block"></div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-100">{{ $news->published_at ? $news->published_at->format('d F Y') : '-' }}</span>
                    </div>
                    <div class="h-4 w-px bg-white/20 hidden md:block"></div>
                    <div class="flex items-center gap-2">
                        @php
                        $wordCount = str_word_count(strip_tags($news->content));
                        $readTime = ceil($wordCount / 200) ?: 1;
                        @endphp
                        <span class="text-unmaris-yellow">{{ $readTime }} MENIT MEMBACA</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="container mx-auto px-4 max-w-7xl -mt-20 relative z-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                <!-- Sisi Kiri: Artikel Utama -->
                <div class="lg:col-span-8">
                    <article class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
                        <!-- Featured Image -->
                        <div class="aspect-video w-full overflow-hidden relative group border-b-4 border-unmaris-yellow">
                            @if($news->featured_image)
                            <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                            @else
                            <div class="w-full h-full bg-gray-50 flex items-center justify-center">
                                <svg class="w-24 h-24 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif
                        </div>

                        <div class="p-8 md:p-12 lg:p-16">
                            <!-- Intro Excerpt -->
                            <div class="text-xl md:text-2xl font-bold text-gray-800 mb-12 leading-relaxed border-l-4 border-unmaris-yellow pl-6 md:pl-8 italic">
                                "{{ $news->excerpt }}"
                            </div>

                            <!-- Content Body -->
                            <div class="prose prose-lg md:prose-xl max-w-none text-gray-700 
                                        prose-img:rounded-2xl prose-img:shadow-md 
                                        prose-headings:text-unmaris-blue prose-headings:font-black 
                                        prose-a:text-unmaris-blue hover:prose-a:text-unmaris-yellow 
                                        prose-li:marker:text-unmaris-yellow prose-blockquote:border-l-unmaris-blue">
                                {!! $news->content !!}
                            </div>

                            <!-- Share Bar -->
                            <div class="mt-16 pt-8 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6">
                                <div class="flex items-center gap-4">
                                    <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Bagikan Artikel Ini:</span>
                                    
                                    <!-- Logika Share Alpine.js -->
                                    <div class="flex gap-2" x-data="{
                                        shareArticle(platform) {
                                            const url = encodeURIComponent(window.location.href);
                                            const title = encodeURIComponent('{{ addslashes($news->title) }}');
                                            let shareUrl = '';

                                            if (platform === 'facebook') shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                                            if (platform === 'whatsapp') shareUrl = `https://api.whatsapp.com/send?text=${title}%20${url}`;
                                            if (platform === 'x') shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;

                                            if (platform === 'copy') {
                                                const tempInput = document.createElement('input');
                                                tempInput.value = window.location.href;
                                                document.body.appendChild(tempInput);
                                                tempInput.select();
                                                document.execCommand('copy');
                                                document.body.removeChild(tempInput);

                                                const btn = document.getElementById('copyLinkBtn');
                                                if (btn) {
                                                    const originalIcon = btn.innerHTML;
                                                    btn.innerHTML = '<svg class=\'w-5 h-5 text-green-500\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'3\' viewBox=\'0 0 24 24\'><path d=\'M5 13l4 4L19 7\'></path></svg>';
                                                    setTimeout(() => { btn.innerHTML = originalIcon; }, 2000);
                                                }
                                            } else if (shareUrl) {
                                                window.open(shareUrl, '_blank', 'noopener,noreferrer');
                                            }

                                            // AJAX: Mencatat statistik share
                                            const csrfToken = document.querySelector('meta[name=\'csrf-token\']');
                                            if (csrfToken) {
                                                fetch('{{ route('news.share.increment', $news->id) }}', {
                                                    method: 'POST',
                                                    headers: {
                                                        'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                                                        'Content-Type': 'application/json',
                                                        'Accept': 'application/json'
                                                    }
                                                }).catch(err => console.warn('Share stat error:', err));
                                            }
                                        }
                                    }">
                                        <!-- Facebook -->
                                        <!-- Menggunakan x-on:click untuk menghindari konflik Blade -->
                                        <button x-on:click="shareArticle('facebook')" type="button" class="w-10 h-10 rounded-xl flex items-center justify-center bg-gray-50 text-gray-500 hover:bg-[#1877F2] hover:text-white transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                        </button>
                                        <!-- X / Twitter -->
                                        <button x-on:click="shareArticle('x')" type="button" class="w-10 h-10 rounded-xl flex items-center justify-center bg-gray-50 text-gray-500 hover:bg-black hover:text-white transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.045 4.126H5.078z"/></svg>
                                        </button>
                                        <!-- WhatsApp -->
                                        <button x-on:click="shareArticle('whatsapp')" type="button" class="w-10 h-10 rounded-xl flex items-center justify-center bg-gray-50 text-gray-500 hover:bg-[#25D366] hover:text-white transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                        </button>
                                        <!-- Copy Link -->
                                        <button x-on:click="shareArticle('copy')" id="copyLinkBtn" type="button" class="w-10 h-10 rounded-xl flex items-center justify-center bg-gray-50 text-gray-500 hover:bg-unmaris-blue hover:text-white transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4 text-[10px] font-bold text-gray-500 bg-gray-50 px-5 py-2.5 rounded-full uppercase tracking-widest border border-gray-100 shadow-inner">
                                    <span>{{ number_format($news->views) }} TAYANGAN</span>
                                    <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                                    <span>{{ number_format($news->shares) }} DIBAGIKAN</span>
                                </div>
                            </div>

                            <!-- Author Box -->
                            <div class="mt-12 bg-blue-50/50 rounded-[2rem] p-8 flex flex-col md:flex-row items-center md:items-start gap-6 border border-blue-100">
                                <div class="w-20 h-20 shrink-0 rounded-full bg-white p-1 shadow-sm border border-gray-200">
                                    <img src="https://ui-avatars.com/api/?name=Humas+Unmaris&background=1B1464&color=FDE01A&size=200" alt="Humas UNMARIS" class="w-full h-full rounded-full object-cover">
                                </div>
                                <div class="text-center md:text-left flex-grow">
                                    <span class="text-[10px] font-black text-unmaris-blue uppercase tracking-widest mb-1.5 block">Dipublikasikan Oleh</span>
                                    <h4 class="text-xl font-black text-gray-900 mb-1">Humas UNMARIS</h4>
                                    <p class="text-unmaris-blue font-bold text-xs mb-3">Departemen Publikasi & Informasi Strategis</p>
                                    <p class="text-gray-600 text-sm leading-relaxed">Tim Hubungan Masyarakat Universitas Stella Maris Sumba berkomitmen untuk menyajikan informasi akademik, riset, dan prestasi institusi secara akurat, edukatif, dan transparan.</p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Sisi Kanan: Sidebar -->
                <aside class="lg:col-span-4 space-y-12">
                    <div class="sticky top-28">
                        <!-- Artikel Terkait -->
                        <div class="flex items-center gap-4 mb-8">
                            <h2 class="text-lg font-black text-gray-900 uppercase tracking-tighter border-b-2 border-unmaris-yellow pb-1">Berita Terkait</h2>
                            <div class="h-px flex-grow bg-gray-200"></div>
                        </div>

                        <div class="space-y-6">
                            @forelse($relatedNews as $rel)
                                <article class="group flex gap-4 bg-white p-3 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="w-20 h-20 shrink-0 rounded-xl overflow-hidden relative">
                                        @if($rel->featured_image)
                                            <img src="{{ Storage::url($rel->featured_image) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        @else
                                            <div class="w-full h-full bg-gray-50 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-unmaris-blue/0 group-hover:bg-unmaris-blue/10 transition-colors"></div>
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <span class="text-[8px] font-black text-unmaris-blue uppercase mb-1 tracking-widest">{{ $rel->category->name }}</span>
                                        <h4 class="text-sm font-bold text-gray-900 leading-snug group-hover:text-unmaris-blue transition-colors">
                                            <a href="{{ route('news.detail', $rel->slug) }}">{{ Str::limit($rel->title, 50) }}</a>
                                        </h4>
                                    </div>
                                </article>
                            @empty
                                <div class="bg-white p-6 rounded-2xl border border-gray-100 text-center">
                                    <p class="text-gray-500 text-sm font-medium italic">Belum ada berita terkait di kategori ini.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Back Button -->
                        <div class="mt-10 text-center md:text-left">
                            <a href="{{ route('news.index') }}" class="inline-flex items-center justify-center w-full bg-white border border-gray-200 text-gray-700 px-6 py-4 rounded-2xl font-bold text-sm hover:bg-gray-50 hover:text-unmaris-blue transition-all shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Kembali ke Daftar Berita
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-layouts.app>