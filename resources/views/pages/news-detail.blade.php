<x-layouts.app :title="$news->title . ' - UNMARIS'">
    <!-- JSON-LD Schema untuk Artikel (SEO) -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Article",
      "headline": "{{ $news->title }}",
      "datePublished": "{{ $news->published_at ? $news->published_at->toIso8601String() : '' }}",
      "dateModified": "{{ $news->updated_at->toIso8601String() }}",
      "author": [{
          "@@type": "Organization",
          "name": "Universitas Stella Maris Sumba"
      }],
      "description": "{{ $news->excerpt }}"
    }
    </script>

    <div class="bg-gray-50 min-h-screen py-12">
        <div class="container mx-auto px-4 max-w-4xl">
            
            <!-- Breadcrumbs -->
            <nav class="flex text-sm text-gray-500 mb-8 font-medium bg-white p-4 rounded-xl shadow-sm border border-gray-100" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center hover:text-unmaris-blue transition">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <a href="{{ route('news.index') }}" class="ml-1 md:ml-2 hover:text-unmaris-blue transition">Berita</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 md:ml-2 text-gray-400">{{ $news->category->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            
            <!-- Article Card -->
            <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                
                <!-- Featured Image -->
                @if($news->featured_image)
                    <div class="w-full h-64 md:h-96 bg-gray-200 relative">
                        <img src="{{ asset('storage/'.$news->featured_image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <!-- Fallback if no image -->
                    <div class="w-full h-12 bg-unmaris-blue border-b-4 border-unmaris-yellow"></div>
                @endif

                <div class="p-8 md:p-12">
                    <!-- Meta info -->
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-6">
                        <span class="bg-unmaris-yellow text-unmaris-blue font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wider">
                            {{ $news->category->name }}
                        </span>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <time datetime="{{ $news->published_at }}">{{ $news->published_at ? $news->published_at->format('d F Y') : '-' }}</time>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>Humas UNMARIS</span>
                        </div>
                    </div>
                    
                    <!-- Title -->
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6 leading-tight">
                        {{ $news->title }}
                    </h1>

                    <!-- Share Bar (Top) -->
                    <div class="flex items-center justify-between border-t border-b border-gray-100 py-4 mb-8">
                        <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider hidden sm:block">Bagikan Artikel</span>
                        <div class="flex items-center gap-2">
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-50 text-gray-600 hover:bg-blue-600 hover:text-white transition-colors duration-300" title="Bagikan ke Facebook">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
                            </a>
                            <!-- X / Twitter -->
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($news->title) }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-50 text-gray-600 hover:bg-black hover:text-white transition-colors duration-300" title="Bagikan ke X">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path></svg>
                            </a>
                            <!-- WhatsApp -->
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' - ' . url()->current()) }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-50 text-gray-600 hover:bg-green-500 hover:text-white transition-colors duration-300" title="Bagikan ke WhatsApp">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path></svg>
                            </a>
                            <!-- LinkedIn -->
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($news->title) }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-50 text-gray-600 hover:bg-blue-700 hover:text-white transition-colors duration-300" title="Bagikan ke LinkedIn">
                                <svg class="w-5 h-5" fill="currentColor" stroke="currentColor" stroke-width="0" viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                            </a>
                            <!-- Copy Link -->
                            <button onclick="copyArticleLink()" id="copyLinkBtn" class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-50 text-gray-600 hover:bg-gray-800 hover:text-white transition-colors duration-300" title="Salin Tautan">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Content (Render HTML safely) -->
                    <!-- Kita menggunakan class 'prose' dari tailwindcss/typography (jika ada) atau styling manual -->
                    <div class="prose prose-lg max-w-none prose-a:text-unmaris-blue hover:prose-a:text-unmaris-yellow prose-headings:text-unmaris-blue prose-img:rounded-xl">
                        {!! $news->content !!}
                    </div>

                    <!-- Author Box -->
                    <div class="mt-12 bg-gray-50 rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-center md:items-start gap-6 border-l-4 border-unmaris-yellow">
                        <div class="w-20 h-20 shrink-0 rounded-full bg-white p-1 shadow-sm border border-gray-200">
                            <!-- Avatar Penulis -->
                            <img src="https://ui-avatars.com/api/?name=Humas+Unmaris&background=1B1464&color=FDE01A" alt="Humas UNMARIS" class="w-full h-full rounded-full object-cover">
                        </div>
                        <div class="text-center md:text-left flex-grow">
                            <h4 class="text-lg font-bold text-gray-900">Humas UNMARIS</h4>
                            <p class="text-unmaris-blue font-semibold text-sm mb-2">Departemen Publikasi & Informasi</p>
                            <p class="text-gray-600 text-sm">Tim Hubungan Masyarakat Universitas Stella Maris Sumba bertugas memberikan informasi teraktual, valid, dan resmi seputar kegiatan akademik maupun non-akademik civitas akademika.</p>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Berita Terkait (Related News) -->
            @php
                // Mengambil 2 berita terbaru dari kategori yang sama, mengabaikan berita yang sedang dibaca
                $relatedNews = \App\Models\News::with('category')
                                ->where('category_id', $news->category_id)
                                ->where('id', '!=', $news->id)
                                ->where('is_published', true)
                                ->latest('published_at')
                                ->take(2)
                                ->get();
            @endphp
            
            @if($relatedNews->isNotEmpty())
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-unmaris-blue mb-6 border-b-2 border-unmaris-yellow inline-block pb-2">Berita Terkait</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($relatedNews as $related)
                    <a href="{{ route('news.detail', $related->slug) }}" class="group bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 overflow-hidden flex flex-col sm:flex-row transition">
                        <div class="w-full sm:w-1/3 h-40 sm:h-auto bg-gray-200 overflow-hidden shrink-0">
                            @if($related->featured_image)
                                <img src="{{ asset('storage/'.$related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full bg-unmaris-blue opacity-10"></div>
                            @endif
                        </div>
                        <div class="p-5 flex flex-col justify-center">
                            <span class="text-xs font-bold text-unmaris-yellow uppercase tracking-wider mb-2">{{ $related->category->name }}</span>
                            <h4 class="font-bold text-gray-900 group-hover:text-unmaris-blue transition leading-tight mb-2">
                                {{ Str::limit($related->title, 55) }}
                            </h4>
                            <span class="text-xs text-gray-500 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $related->published_at ? $related->published_at->format('d M Y') : '-' }}
                            </span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Back Button -->
            <div class="mt-8 text-center">
                <a href="{{ route('news.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 hover:text-unmaris-blue transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Indeks Berita
                </a>
            </div>

        </div>
    </div>

    <!-- Script Salin Tautan (Tanpa Alert) -->
    <script>
        function copyArticleLink() {
            var tempInput = document.createElement("input");
            tempInput.value = window.location.href;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            
            // Ubah icon sesaat menjadi tanda centang (✓)
            var btn = document.getElementById('copyLinkBtn');
            var originalContent = btn.innerHTML;
            btn.innerHTML = '<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>';
            
            setTimeout(function() {
                btn.innerHTML = originalContent;
            }, 2000); // Kembali ke icon awal setelah 2 detik
        }
    </script>
</x-layouts.app>