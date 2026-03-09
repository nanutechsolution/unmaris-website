<x-layouts.app :title="$news->title . ' - UNMARIS'" :description="$news->excerpt" :ogImage="$news->featured_image ? url(Storage::url($news->featured_image)) : url('images/logo-unmaris.png')">
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
            "image": "{{ $news->featured_image ? url(Storage::url($news->featured_image)) : url('images/logo-unmaris.png') }}"
        }
    </script>

    <!-- Reading Progress Bar -->
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
        <!-- Header Hero (Diperbesar padding bawahnya untuk efek overlap) -->
        <header class="bg-unmaris-blue text-white pt-16 pb-40 md:pb-48 relative overflow-hidden border-b-8 border-unmaris-yellow">
            <div class="absolute inset-0 opacity-10">
                <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                    <path d="M0 0 L100 0 L100 100 L0 100 Z" />
                </svg>
            </div>
            <!-- Glow background untuk kesan elegan -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-unmaris-yellow rounded-full blur-[150px] opacity-10 pointer-events-none"></div>

            <div class="container mx-auto px-4 relative z-10 max-w-5xl text-center">
                <!-- Breadcrumbs -->
                <nav class="flex justify-center text-[10px] font-black uppercase tracking-[0.3em] text-unmaris-yellow mb-8 gap-2">
                    <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                    <span class="opacity-30">/</span>
                    <a href="{{ route('news.index') }}" class="hover:text-white transition">Berita</a>
                    <span class="opacity-30">/</span>
                    <span class="text-white">{{ $news->category->name }}</span>
                </nav>

                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-black mb-8 md:mb-10 leading-[1.2] md:leading-[1.1] tracking-tighter drop-shadow-lg px-2">
                    {{ $news->title }}
                </h1>

                <div class="flex flex-wrap justify-center items-center gap-4 md:gap-6 text-[10px] md:text-xs font-bold uppercase tracking-widest text-gray-300">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-unmaris-yellow flex items-center justify-center text-unmaris-blue font-black shadow-lg border-2 border-white/10">U</div>
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

        <!-- Margin negatif ditarik lebih ekstrim (-mt-28 md:-mt-32) -->
        <div class="container mx-auto px-4 max-w-7xl -mt-28 md:-mt-32 relative z-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 md:gap-12">

                <!-- Sisi Kiri: Artikel Utama -->
                <div class="lg:col-span-8">
                    <article class="bg-white rounded-[2rem] md:rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.08)] border border-gray-100/50 overflow-hidden transform transition-transform duration-500 hover:-translate-y-1">
                        
                        <!-- Gambar Sampul (Lebih premium dengan gradient yang diperbaiki) -->
                        <div class="aspect-video w-full overflow-hidden relative group bg-gray-100">
                            @if($news->featured_image)
                                <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-unmaris-blue">
                                    <svg class="w-20 h-20 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <!-- Gradient lebih pekat untuk menjamin estetika walau gambar terang -->
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/40 via-gray-900/10 to-transparent pointer-events-none"></div>
                        </div>

                        <div class="p-6 sm:p-8 md:p-12 lg:p-16">
                            <!-- Intro Excerpt -->
                            <div class="text-lg md:text-xl lg:text-2xl font-bold text-gray-800 mb-10 leading-relaxed border-l-[6px] border-unmaris-yellow pl-6 md:pl-8 italic text-justify md:text-left">
                                "{{ $news->excerpt }}"
                            </div>

                            <!-- Video Pendukung (Tampil Jika Ada) -->
                            @if($news->video_url)
                                @php
                                    $rawUrl = $news->video_url;
                                    $embedUrl = $rawUrl;
                                    $videoType = 'youtube'; // Default

                                    if (str_contains($rawUrl, 'youtube.com/watch?v=')) {
                                        $embedUrl = str_replace('watch?v=', 'embed/', $rawUrl);
                                        $embedUrl = explode('&', $embedUrl)[0];
                                    } elseif (str_contains($rawUrl, 'youtu.be/')) {
                                        $embedUrl = str_replace('youtu.be/', 'www.youtube.com/embed/', $rawUrl);
                                        $embedUrl = explode('?', $embedUrl)[0];
                                    } elseif (str_contains($rawUrl, 'tiktok.com')) {
                                        $videoType = 'tiktok';
                                        preg_match('/video\/(\d+)/', $rawUrl, $matches);
                                        if (isset($matches[1])) {
                                            $embedUrl = 'https://www.tiktok.com/embed/v2/' . $matches[1];
                                        }
                                    } elseif (str_contains($rawUrl, 'facebook.com') || str_contains($rawUrl, 'fb.watch')) {
                                        $videoType = 'facebook';
                                        $embedUrl = 'https://www.facebook.com/plugins/video.php?href=' . urlencode($rawUrl) . '&show_text=false&width=auto';
                                    }
                                @endphp
                                
                                <div class="mb-10 rounded-2xl md:rounded-3xl overflow-hidden shadow-xl border border-gray-100 relative {{ $videoType === 'tiktok' ? 'max-w-sm mx-auto' : '' }}">
                                    <div class="absolute top-0 left-0 bg-unmaris-yellow text-unmaris-blue text-[9px] md:text-[10px] font-black px-4 py-1.5 rounded-br-2xl z-10 uppercase tracking-widest shadow-sm">
                                        Liputan Media
                                    </div>
                                    <div class="w-full bg-black {{ $videoType === 'tiktok' ? 'aspect-[9/16]' : 'aspect-video' }}">
                                        <iframe class="w-full h-full" src="{{ $embedUrl }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </div>
                                </div>
                            @endif

                            <!-- Content Body (Penambahan Fitur DROP CAP Editorial) -->
                            <div class="text-gray-700 text-base md:text-lg leading-relaxed text-justify md:text-left
                                        [&>p:first-of-type]:first-letter:text-6xl md:[&>p:first-of-type]:first-letter:text-7xl [&>p:first-of-type]:first-letter:font-black [&>p:first-of-type]:first-letter:text-unmaris-blue [&>p:first-of-type]:first-letter:float-left [&>p:first-of-type]:first-letter:mr-4 [&>p:first-of-type]:first-letter:leading-[0.8] [&>p:first-of-type]:first-letter:pt-2
                                        [&_p]:mb-6
                                        [&_ul]:list-disc [&_ul]:pl-6 [&_ul]:mb-6 [&_ul]:space-y-2 marker:[&_ul]:text-unmaris-yellow marker:[&_ul]:text-xl
                                        [&_ol]:list-decimal [&_ol]:pl-6 [&_ol]:mb-6 [&_ol]:space-y-2 marker:[&_ol]:text-unmaris-blue marker:[&_ol]:font-bold
                                        [&_h2]:text-2xl sm:[&_h2]:text-3xl [&_h2]:font-black [&_h2]:text-unmaris-blue [&_h2]:mt-10 [&_h2]:mb-6
                                        [&_h3]:text-xl sm:[&_h3]:text-2xl [&_h3]:font-bold [&_h3]:text-unmaris-blue [&_h3]:mt-8 [&_h3]:mb-4
                                        [&_strong]:text-gray-900 [&_strong]:font-extrabold
                                        [&_a]:text-unmaris-blue [&_a]:font-bold [&_a]:underline hover:[&_a]:text-unmaris-yellow [&_a]:transition-colors
                                        [&_blockquote]:border-l-4 [&_blockquote]:border-unmaris-yellow [&_blockquote]:bg-gray-50 [&_blockquote]:py-6 [&_blockquote]:px-6 md:[&_blockquote]:px-8 [&_blockquote]:rounded-r-2xl [&_blockquote]:italic [&_blockquote]:text-gray-600 [&_blockquote]:mb-8 [&_blockquote]:shadow-sm
                                        [&_img]:rounded-2xl [&_img]:shadow-md [&_img]:mx-auto [&_img]:my-8 [&_img]:max-w-full
                                        [&_table]:w-full [&_table]:border-collapse [&_table]:rounded-xl [&_table]:overflow-hidden [&_table]:mb-6 
                                        [&_th]:bg-unmaris-blue [&_th]:text-white [&_th]:p-3 [&_th]:text-left 
                                        [&_td]:p-3 [&_td]:border-b [&_td]:border-gray-200 hover:[&_tr]:bg-gray-50">
                                {!! $news->content !!}
                            </div>

                            <!-- Menampilkan Tagar (Tags) -->
                            @if(isset($news->tags) && $news->tags->count() > 0)
                            <div class="mt-12 flex flex-wrap items-center gap-2">
                                <span class="text-[10px] md:text-xs font-black text-gray-400 mr-2 uppercase tracking-widest">Topik Terkait:</span>
                                @foreach($news->tags as $tag)
                                    <a href="{{ route('news.index', ['tag' => $tag->name]) }}" class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-200 text-gray-600 hover:bg-unmaris-yellow hover:text-unmaris-blue hover:border-unmaris-yellow rounded-xl text-[10px] md:text-xs font-bold uppercase tracking-widest transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                            @endif

                            <!-- Share Bar (Premium dengan UX yang dipertingkatkan) -->
                            <div class="mt-16 relative overflow-hidden bg-gradient-to-br from-blue-50/50 to-gray-50 rounded-[2rem] p-6 md:p-8 border border-blue-100/50 shadow-sm flex flex-col md:flex-row items-center justify-between gap-8">
                                <div class="absolute -left-10 -top-10 w-32 h-32 bg-unmaris-yellow/20 rounded-full blur-2xl pointer-events-none"></div>

                                <div class="text-center md:text-left relative z-10">
                                    <h4 class="text-lg md:text-xl font-black text-unmaris-blue mb-1">Bagikan Artikel Ini</h4>
                                    <p class="text-xs md:text-sm text-gray-500 font-medium">Bantu sebarkan maklumat ini ke jaringan anda.</p>
                                    
                                    <div class="flex items-center justify-center md:justify-start gap-4 text-[9px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest mt-4">
                                        <span class="flex items-center text-unmaris-blue/70">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            {{ number_format($news->views) }} Tayangan
                                        </span>
                                        <div class="w-1.5 h-1.5 bg-gray-300 rounded-full"></div>
                                        <span class="flex items-center text-unmaris-blue/70">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                                            {{ number_format($news->shares) }} Dibagikan
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Logika Share Alpine.js dengan State yang diperbaiki -->
                                <div class="flex flex-wrap justify-center gap-3 relative z-10 w-full md:w-auto" x-data="{
                                    copied: false,
                                    copyText: 'Salin',
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

                                            // UX Update: Guna Alpine State berbanding manipulasi DOM terus
                                            this.copied = true;
                                            this.copyText = 'Tersalin!';
                                            setTimeout(() => { 
                                                this.copied = false;
                                                this.copyText = 'Salin'; 
                                            }, 2500);
                                        } else if (shareUrl) {
                                            window.open(shareUrl, '_blank', 'noopener,noreferrer');
                                        }

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
                                    <button x-on:click="shareArticle('facebook')" type="button" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-white text-[#1877F2] hover:bg-[#1877F2] hover:text-white font-bold text-sm transition-all shadow-sm hover:shadow-md hover:-translate-y-1 border border-gray-100"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg><span class="hidden lg:block">Facebook</span></button>
                                    <button x-on:click="shareArticle('x')" type="button" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-white text-black hover:bg-black hover:text-white font-bold text-sm transition-all shadow-sm hover:shadow-md hover:-translate-y-1 border border-gray-100"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.045 4.126H5.078z"/></svg><span class="hidden lg:block">X</span></button>
                                    <button x-on:click="shareArticle('whatsapp')" type="button" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-white text-[#25D366] hover:bg-[#25D366] hover:text-white font-bold text-sm transition-all shadow-sm hover:shadow-md hover:-translate-y-1 border border-gray-100"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg><span class="hidden lg:block">WhatsApp</span></button>
                                    <button x-on:click="shareArticle('copy')" type="button" :class="copied ? 'bg-green-500 text-white border-green-500 hover:bg-green-600' : 'bg-white text-gray-600 border-gray-100 hover:bg-unmaris-blue hover:text-white'" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-3 rounded-xl font-bold text-sm transition-all shadow-sm hover:shadow-md hover:-translate-y-1 border">
                                        <svg x-show="!copied" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                        <svg x-show="copied" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                        <span x-text="copyText" class="hidden lg:block">Salin</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Author Box -->
                            <div class="mt-12 bg-gray-50 rounded-[2rem] p-6 md:p-8 flex flex-col md:flex-row items-center md:items-start gap-6 border border-gray-200">
                                <div class="w-16 h-16 md:w-20 md:h-20 shrink-0 rounded-full bg-white p-1 shadow-sm border border-gray-200">
                                    <img src="https://ui-avatars.com/api/?name=Humas+Unmaris&background=1B1464&color=FDE01A&size=200" alt="Humas UNMARIS" class="w-full h-full rounded-full object-cover">
                                </div>
                                <div class="text-center md:text-left flex-grow">
                                    <span class="text-[9px] md:text-[10px] font-black text-unmaris-blue uppercase tracking-widest mb-1.5 block">Ditulis Oleh</span>
                                    <h4 class="text-lg md:text-xl font-black text-gray-900 mb-1">Humas UNMARIS</h4>
                                    <p class="text-gray-500 font-bold text-[10px] md:text-xs mb-3">Departemen Publikasi & Informasi</p>
                                    <p class="text-gray-600 text-xs md:text-sm leading-relaxed">Berkomitmen menyajikan maklumat akademik, riset, dan prestasi institusi secara tepat dan telus.</p>
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
                                    <div class="w-20 h-20 shrink-0 rounded-xl overflow-hidden relative bg-gray-50">
                                        @if($rel->featured_image)
                                            <img src="{{ Storage::url($rel->featured_image) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                        
                                        <!-- Indikator Video -->
                                        @if($rel->video_url)
                                            <div class="absolute inset-0 flex items-center justify-center z-10 pointer-events-none">
                                                <div class="w-7 h-7 bg-white/40 backdrop-blur-md rounded-full flex items-center justify-center text-white border border-white/50 shadow-sm">
                                                    <svg class="w-3 h-3 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <div class="absolute inset-0 bg-unmaris-blue/0 group-hover:bg-unmaris-blue/10 transition-colors pointer-events-none"></div>
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <span class="text-[8px] font-black text-unmaris-blue uppercase mb-1 tracking-widest">{{ $rel->category->name }}</span>
                                        <h4 class="text-xs md:text-sm font-bold text-gray-900 leading-snug group-hover:text-unmaris-blue transition-colors">
                                            <a href="{{ route('news.detail', $rel->slug) }}">{{ Str::limit($rel->title, 50) }}</a>
                                        </h4>
                                    </div>
                                </article>
                            @empty
                                <div class="bg-gray-50 p-6 rounded-2xl border border-dashed border-gray-200 text-center">
                                    <p class="text-gray-400 text-xs font-medium uppercase tracking-widest">Belum ada berita terkait</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Back Button -->
                        <div class="mt-10">
                            <a href="{{ route('news.index') }}" class="inline-flex items-center justify-center w-full bg-white border border-gray-200 text-gray-600 px-6 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-unmaris-blue hover:text-white transition-all shadow-sm group">
                                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Indeks Berita
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-layouts.app>