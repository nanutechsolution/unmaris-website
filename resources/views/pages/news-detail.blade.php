<x-layouts.app :title="$news->title . ' - UNMARIS'" :description="$news->excerpt">
    <!-- JSON-LD Schema untuk Artikel (SEO) -->
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

    <!-- Reading Progress Bar -->
    <div class="fixed top-0 left-0 w-full h-1.5 z-[60] pointer-events-none">
        <div id="progress-bar" class="h-full bg-unmaris-yellow w-0 transition-all duration-150 shadow-[0_0_10px_rgba(253,224,26,0.8)]"></div>
    </div>

    <div class="bg-white min-h-screen pb-24">
        <!-- Header Hero -->
        <header class="bg-unmaris-blue text-white pt-16 pb-32 relative overflow-hidden">
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

                <h1 class="text-4xl md:text-7xl font-black mb-10 leading-[1.05] tracking-tighter drop-shadow-sm">
                    {{ $news->title }}
                </h1>

                <div class="flex flex-wrap justify-center items-center gap-6 text-xs font-bold uppercase tracking-widest text-gray-400">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-unmaris-yellow flex items-center justify-center text-unmaris-blue font-black shadow-lg">U</div>
                        <span class="text-white">Humas UNMARIS</span>
                    </div>
                    <div class="h-4 w-px bg-white/20 hidden md:block"></div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-unmaris-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-300">{{ $news->published_at ? $news->published_at->format('M d, Y') : '-' }}</span>
                    </div>
                    <div class="h-4 w-px bg-white/20 hidden md:block"></div>
                    <div class="flex items-center gap-2">
                        @php
                        $wordCount = str_word_count(strip_tags($news->content));
                        $readTime = ceil($wordCount / 200) ?: 1;
                        @endphp
                        <span class="text-unmaris-yellow">{{ $readTime }} MIN READ</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="container mx-auto px-4 max-w-7xl -mt-20 relative z-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                <!-- Sisi Kiri: Artikel Utama -->
                <div class="lg:col-span-8">
                    <article class="bg-white rounded-[3rem] shadow-2xl border border-gray-50 overflow-hidden">
                        <!-- Featured Image -->
                        <div class="aspect-video w-full overflow-hidden relative group">
                            @if($news->featured_image)
                            <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                            @else
                            <div class="w-full h-full bg-unmaris-blue/5 flex items-center justify-center">
                                <svg class="w-24 h-24 text-unmaris-blue/10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif
                        </div>

                        <div class="p-8 md:p-16 lg:p-20">
                            <!-- Intro Excerpt -->
                            <div class="text-2xl md:text-3xl font-black text-gray-900 mb-16 leading-relaxed border-l-8 border-unmaris-yellow pl-10 italic tracking-tight">
                                "{{ $news->excerpt }}"
                            </div>

                            <!-- Content Body -->
                            <div class="prose prose-lg md:prose-2xl max-w-none prose-img:rounded-[2rem] prose-headings:text-unmaris-blue prose-headings:font-black prose-a:text-unmaris-blue hover:prose-a:text-unmaris-yellow prose-li:marker:text-unmaris-yellow font-medium text-gray-700 leading-relaxed">
                                {!! $news->content !!}
                            </div>

                            <!-- Share Bar -->
                            <div class="mt-20 pt-10 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-8">
                                <div class="flex items-center gap-4 lg:gap-6">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Bagikan:</span>
                                    <div class="flex gap-2 lg:gap-3">
                                        <!-- Facebook -->
                                        <button class="w-11 h-11 lg:w-12 lg:h-12 rounded-2xl flex items-center justify-center bg-gray-50 text-gray-400 hover:bg-[#1877F2] hover:text-white transition-all shadow-sm hover:shadow-xl hover:-translate-y-1">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                            </svg>
                                        </button>
                                        <!-- X / Twitter -->
                                        <button onclick="window.share('x')" class="w-11 h-11 lg:w-12 lg:h-12 rounded-2xl flex items-center justify-center bg-gray-50 text-gray-400 hover:bg-black hover:text-white transition-all shadow-sm hover:shadow-xl hover:-translate-y-1">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.045 4.126H5.078z" />
                                            </svg>
                                        </button>
                                        <!-- WhatsApp -->
                                        <button onclick="window.share('whatsapp')" class="w-11 h-11 lg:w-12 lg:h-12 rounded-2xl flex items-center justify-center bg-gray-50 text-gray-400 hover:bg-[#25D366] hover:text-white transition-all shadow-sm hover:shadow-xl hover:-translate-y-1">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                            </svg>
                                        </button>
                                        <!-- Copy Link -->
                                        <button onclick="window.share('copy')" id="copyLinkBtn" class="w-11 h-11 lg:w-12 lg:h-12 rounded-2xl flex items-center justify-center bg-gray-50 text-gray-400 hover:bg-unmaris-blue hover:text-white transition-all shadow-sm hover:shadow-xl hover:-translate-y-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 text-[10px] font-black text-gray-400 bg-gray-50 px-6 py-3 rounded-full uppercase tracking-widest border border-gray-100">
                                    <span>{{ number_format($news->views) }} VIEWS</span>
                                    <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                                    <span>{{ number_format($news->shares) }} SHARES</span>
                                </div>
                            </div>

                            <!-- Author Box -->
                            <div class="mt-16 bg-gray-50 rounded-3xl p-8 lg:p-12 flex flex-col md:flex-row items-center md:items-start gap-8 border-l-8 border-unmaris-yellow shadow-sm">
                                <div class="w-24 h-24 shrink-0 rounded-full bg-white p-1 shadow-md border border-gray-200">
                                    <img src="https://ui-avatars.com/api/?name=Humas+Unmaris&background=1B1464&color=FDE01A&size=200" alt="Humas UNMARIS" class="w-full h-full rounded-full object-cover">
                                </div>
                                <div class="text-center md:text-left flex-grow">
                                    <span class="text-[10px] font-black text-unmaris-blue uppercase tracking-widest mb-2 block">Diterbitkan Oleh</span>
                                    <h4 class="text-2xl font-black text-gray-900 mb-1">Humas UNMARIS</h4>
                                    <p class="text-unmaris-blue font-bold text-sm mb-4">Departemen Publikasi & Informasi Strategis</p>
                                    <p class="text-gray-600 text-base leading-relaxed">Tim Hubungan Masyarakat Universitas Stella Maris Sumba berkomitmen untuk menyajikan informasi akademik, riset, dan prestasi mahasiswa yang akurat dan inspiratif.</p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Sisi Kanan: Sidebar -->
                <aside class="lg:col-span-4 space-y-12">
                    <div class="sticky top-28">
                        <!-- Artikel Terkait -->
                        <div class="flex items-center gap-4 mb-10">
                            <h2 class="text-xl font-black text-gray-900 uppercase tracking-tighter border-b-2 border-unmaris-yellow pb-1">Related</h2>
                            <div class="h-px flex-grow bg-gray-100"></div>
                        </div>

                        <div class="space-y-10">
                            @forelse($relatedNews as $rel)
                            <article class="group flex gap-5">
                                <div class="w-20 h-20 shrink-0 rounded-2xl overflow-hidden shadow-sm">
                                    @if($rel->featured_image)
                                    <img src="{{ Storage::url($rel->featured_image) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center"><svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg></div>
                                    @endif
                                </div>
                                <div class="flex flex-col justify-center">
                                    <span class="text-[8px] font-black text-unmaris-blue uppercase mb-1 tracking-widest">{{ $rel->category->name }}</span>
                                    <h4 class="text-sm font-bold text-gray-900 leading-snug group-hover:text-unmaris-blue transition-colors">
                                        <a href="{{ route('news.detail', $rel->slug) }}">{{ Str::limit($rel->title, 50) }}</a>
                                    </h4>
                                </div>
                            </article>
                            @empty
                            <p class="text-gray-400 text-sm italic">Belum ada berita terkait.</p>
                            @endforelse
                        </div>

                        <!-- CTA Subscribe -->
                        <div class="mt-16 bg-gray-900 rounded-[3rem] p-10 text-white relative overflow-hidden shadow-2xl">
                            <div class="absolute -right-6 -top-6 w-32 h-32 bg-unmaris-yellow/10 rounded-full blur-3xl"></div>
                            <h3 class="text-2xl font-black mb-4 relative z-10 leading-tight">Be part of our story.</h3>
                            <p class="text-white/40 text-sm mb-8 relative z-10 font-medium">Dapatkan berita akademik terhangat langsung di inbox Anda.</p>
                            <a href="{{ route('contact') }}" class="inline-block w-full text-center bg-unmaris-yellow text-unmaris-blue py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-white transition-all shadow-lg">Subscribe Now</a>
                        </div>

                        <!-- Back Button -->
                        <div class="mt-10 text-center">
                            <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 text-xs font-black text-gray-400 hover:text-unmaris-blue uppercase tracking-[0.2em] transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Hub
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        /**
         * Inisialisasi fungsi share ke dalam global window secara eksplisit.
         * Ini menjamin fungsi tersedia meskipun halaman dimuat melalui Livewire wire:navigate.
         */
        window.initNewsScripts = function() {
            // Logika Reading Progress Bar
            const handleScroll = function() {
                let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                let scrolled = (winScroll / height) * 100;
                const bar = document.getElementById("progress-bar");
                if (bar) bar.style.width = scrolled + "%";
            };
            window.addEventListener('scroll', handleScroll);

            // Fungsi Share
            window.share = function(platform) {
                const url = encodeURIComponent(window.location.href);
                const titleText = {
                    !!json_encode($news - > title) !!
                };
                const title = encodeURIComponent(titleText);
                let shareUrl = '';

                switch (platform) {
                    case 'facebook':
                        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                        break;
                    case 'whatsapp':
                        shareUrl = `https://api.whatsapp.com/send?text=${title}%20${url}`;
                        break;
                    case 'x':
                        shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                        break;
                    case 'copy':
                        const tempInput = document.createElement("input");
                        tempInput.value = window.location.href;
                        document.body.appendChild(tempInput);
                        tempInput.select();
                        document.execCommand("copy");
                        document.body.removeChild(tempInput);

                        const btn = document.getElementById('copyLinkBtn');
                        if (btn) {
                            const originalIcon = btn.innerHTML;
                            btn.innerHTML = '<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>';
                            setTimeout(() => {
                                btn.innerHTML = originalIcon;
                            }, 2000);
                        }
                        break;
                }

                if (shareUrl) {
                    window.open(shareUrl, '_blank', 'noopener,noreferrer');
                }

                // AJAX: Mencatat statistik share
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (csrfToken) {
                    fetch("{{ route('news.share.increment', $news->id) }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    }).catch(err => console.warn('Gagal mencatat statistik share:', err));
                }
            };
        };

        // Jalankan saat load awal
        window.initNewsScripts();

        // Jalankan ulang saat navigasi Livewire (PENTING untuk perbaikan error Anda)
        document.addEventListener('livewire:navigated', () => {
            window.initNewsScripts();
        });
    </script>
    @endpush
</x-layouts.app>