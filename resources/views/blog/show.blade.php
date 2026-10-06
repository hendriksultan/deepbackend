<x-layout>
  {{-- ======================================================== --}}
  {{-- [BARU] INJEKSI META TAGS KHUSUS UNTUK ARTIKEL INI --}}
  {{-- ======================================================== --}}
  <x-slot name="meta">
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($finalContent ?? $article->content)), 100) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">
    
    @if($article->thumbnail)
    <meta property="og:image" content="{{ asset('storage/' . $article->thumbnail) }}">
    {{-- Memastikan platform membaca versi HTTPS --}}
    <meta property="og:image:secure_url" content="{{ secure_asset('storage/' . $article->thumbnail) }}">
    
    <meta name="twitter:card" content="summary_large_image">
    {{-- Menambahkan judul khusus untuk Twitter --}}
    <meta name="twitter:title" content="{{ $article->title }}">
    <meta name="twitter:image" content="{{ asset('storage/' . $article->thumbnail) }}">
    @endif
</x-slot>

  {{-- CSS Khusus agar hasil ketikan dari Rich Editor Filament rapi --}}
  <style>
    /* Agar scroll ke anchor link (Daftar Isi) meluncur halus */
    html {
      scroll-behavior: smooth;
      scroll-padding-top: 120px;
      /* Jarak aman agar judul tidak tertutup Header saat di-klik */
    }

    .blog-content h1,
    .blog-content h2,
    .blog-content h3 {
      font-weight: 700;
      margin-top: 2rem;
      margin-bottom: 1rem;
      color: #111827;
      line-height: 1.3;
    }

    .blog-content h2 {
      font-size: 1.5rem;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid #f3f4f6;
      /* Garis bawah halus untuk H2 */
    }

    .blog-content h3 {
      font-size: 1.25rem;
    }

    .blog-content p {
      margin-bottom: 1.25rem;
      line-height: 1.8;
      color: #374151;
      font-size: 1.05rem;
    }

    .blog-content ul {
      list-style-type: disc;
      padding-left: 1.5rem;
      margin-bottom: 1.25rem;
      color: #374151;
    }

    .blog-content ol {
      list-style-type: decimal;
      padding-left: 1.5rem;
      margin-bottom: 1.25rem;
      color: #374151;
    }

    .blog-content li {
      margin-bottom: 0.5rem;
    }

    .blog-content a {
      color: #16a34a;
      text-decoration: none;
      font-weight: 600;
    }

    .blog-content a:hover {
      text-decoration: underline;
    }

    .blog-content blockquote {
      border-left: 4px solid #16a34a;
      padding-left: 1.25rem;
      font-style: italic;
      color: #4b5563;
      margin: 2rem 0;
      background: #f0fdf4;
      padding: 1rem 1rem 1rem 1.5rem;
      border-radius: 0 0.5rem 0.5rem 0;
    }

    .blog-content img {
      border-radius: 0.75rem;
      margin: 2rem auto;
      max-width: 100%;
      height: auto;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .blog-content strong,
    .blog-content b {
      color: #111827;
    }
  </style>

  <main class="w-full min-h-screen bg-white pb-16 md:pb-24">

    {{-- HEADER BREADCRUMB REVISI --}}
    <div class="w-full bg-green-800 pt-32 pb-12 relative">
      {{-- [PERBAIKAN 1] Tambahkan pointer-events-none agar overlay ini tidak memblokir klik --}}
      <div class="absolute inset-0 opacity-20 mix-blend-overlay pointer-events-none" style="background-image: url('{{ asset('arabesque.png') }}');"></div>
      
      {{-- [PERBAIKAN 2] Tambahkan relative dan z-10 agar konten naik ke layer paling atas --}}
      <div class="container max-w-7xl mx-auto px-4 md:px-6 relative z-10">
        <nav class="flex text-sm text-green-100/80 font-medium" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-2 md:space-x-3">
            <li class="inline-flex items-center">
              <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
            </li>
            <li>
              <div class="flex items-center"><span class="mx-2">/</span>
                <a href="{{ route('blog.index') }}" class="hover:text-white transition-colors">Artikel</a>
              </div>
            </li>
            <li aria-current="page">
              <div class="flex items-center"><span class="mx-2">/</span>
                <span class="text-white line-clamp-1 truncate max-w-[150px] md:max-w-xs">{{ $article->title }}</span>
              </div>
            </li>
          </ol>
        </nav>
      </div>
    </div>

    {{-- KONTEN UTAMA & SIDEBAR --}}
    <div class="container max-w-7xl mx-auto px-4 md:px-6 pt-8 md:pt-12">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-12">

        {{-- KOLOM KIRI (70%): ISI ARTIKEL --}}
        {{-- UBAH: mb-12 menjadi mb-4, dan pb-10 menjadi pb-4 (khusus mobile) --}}
        <article class="lg:col-span-8 lg:pr-10 xl:pr-14 lg:border-r border-gray-200 mb-4 lg:mb-0 pb-4 lg:pb-10">

          {{-- Judul dan Meta --}}
          <h1 class="text-3xl md:text-4xl lg:text-[2.5rem] font-extrabold text-gray-900 leading-tight mb-6">
            {{ $article->title }}
          </h1>

          <div class="flex items-center justify-between border-y border-gray-100 py-4 mb-8">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-green-100 text-green-700 rounded-full flex items-center justify-center font-bold text-lg">
                {{ substr($article->author, 0, 1) }}
              </div>
              <div>
                {{-- Nama Author Link --}}
                <a href="{{ route('blog.index', ['author' => $article->author]) }}" class="text-sm font-bold text-gray-800 hover:text-green-600 transition-colors block">
                  {{ $article->author }}
                </a>
                <div class="flex items-center text-[11px] md:text-xs text-gray-500 gap-2 mt-0.5">
                  <span>{{ $article->created_at->translatedFormat('d F Y') }}</span>
                  <span class="w-1 h-1 rounded-full bg-gray-300"></span>

                  @php
                  $wordCount = str_word_count(strip_tags($article->content));
                  $readTime = ceil($wordCount / 200) ?: 1;
                  @endphp
                  <span>{{ $readTime }} min read</span>
                </div>
              </div>
            </div>

            {{-- Tombol Share (Atas) --}}
            <div class="hidden sm:flex gap-2">
              <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link disalin!')" class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-full transition-colors" title="Salin Link">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
              </button>
            </div>
          </div>

          {{-- Gambar Cover Artikel --}}
          @if($article->thumbnail)
          <div class="w-full aspect-video rounded-2xl overflow-hidden mb-10 shadow-md">
            <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
          </div>
          @endif

          {{-- [PENTING] Isi Teks Artikel (Menggunakan $finalContent agar Iklan Muncul) --}}
          <div class="blog-content">
            {!! $finalContent ?? $article->content !!}
            {{-- Fallback ke content asli jika finalContent belum ada (untuk jaga-jaga) --}}
          </div>

          {{-- ======================================================== --}}
          {{-- FITUR SHARE & ARTIKEL LAINNYA DI BAWAH KONTEN --}}
          {{-- ======================================================== --}}

          {{-- 1. Bagian Share Artikel --}}
          <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center gap-3">
            <span class="text-base font-bold text-gray-800">Bagikan artikel ini:</span>
            <div class="flex items-center gap-3">
              {{-- WhatsApp --}}
              <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' - Baca selengkapnya di: ' . request()->url()) }}" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-full bg-[#25D366] text-white hover:-translate-y-1 transition-transform shadow-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" />
                </svg>
              </a>
              {{-- Facebook --}}
              <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-full bg-[#1877F2] text-white hover:-translate-y-1 transition-transform shadow-sm">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                </svg>
              </a>
              {{-- Twitter / X --}}
              <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->url()) }}" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-900 text-white hover:-translate-y-1 transition-transform shadow-sm">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                </svg>
              </a>
              {{-- LinkedIn --}}
              <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($article->title) }}" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-full bg-[#0A66C2] text-white hover:-translate-y-1 transition-transform shadow-sm">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                </svg>
              </a>
            </div>
          </div>
          {{-- 2. Bagian Artikel Lainnya --}}
          {{-- [REVISI] Jarak diperkecil untuk mobile (mt-8 pt-6), normal di desktop (md:mt-12 md:pt-10) --}}
          <div class="mt-8 pt-6 md:mt-8 md:pt-10 border-t border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-6 lg:mb-6 border-l-4 border-green-500 pl-3">Artikel Lainnya</h3>

            {{-- [REVISI] Gap antar artikel diperkecil di mobile (gap-y-6) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-y-6 md:gap-y-8 md:gap-x-8">
             @foreach($relatedArticles as $lainnya)
              <a href="{{ route('blog.show', $lainnya->slug) }}" class="group flex flex-row md:flex-col items-start gap-4 md:gap-4 transition-all duration-300">

                <div class="relative w-28 sm:w-32 md:w-full shrink-0 aspect-[16/10] bg-gray-100 rounded-xl overflow-hidden">
                  @if($lainnya->thumbnail)
                  <img src="{{ asset('storage/' . $lainnya->thumbnail) }}" alt="{{ $lainnya->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                  @else
                  <div class="w-full h-full flex items-center justify-center text-gray-300">
                    <svg class="w-8 h-8 opacity-50" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                  @endif

                  <div class="absolute bottom-2 right-2 bg-black/50 backdrop-blur-sm text-white text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">
                    {{ $article->category ? $article->category->name : 'UMUM' }}
                  </div>
                </div>

                <div class="flex flex-col min-w-0 flex-1">
                  <h4 class="text-[15px] md:text-lg font-bold text-gray-900 line-clamp-2 group-hover:text-green-600 transition-colors mb-1.5 leading-snug">
                    {{ $lainnya->title }}
                  </h4>

                  <div class="flex items-center text-[11px] md:text-sm text-gray-500 font-medium gap-1.5">
                    <span>{{ $lainnya->created_at->translatedFormat('d M Y') }}</span>
                    <span>&bull;</span>
                    @php
                    $wordCountL = str_word_count(strip_tags($lainnya->content));
                    $readTimeL = ceil($wordCountL / 200) ?: 1;
                    @endphp
                    <span>{{ $readTimeL }} min read</span>
                  </div>
                </div>
              </a>
              @endforeach
            </div>
          </div>
        </article>

        {{-- KOLOM KANAN (30%): SIDEBAR STICKY --}}
        {{-- [REVISI] space-y-6 (mobile) agar elemen sidebar tidak terlalu jauh --}}
        <aside class="lg:col-span-4 lg:pl-10 xl:pl-14 space-y-6 lg:space-y-10 lg:sticky lg:top-28 lg:self-start">


          {{-- 2. Banner Promo Internal --}}
          {{-- Tambahkan mb-8 (untuk mobile) dan lg:mb-0 (agar tidak merusak space-y sidebar di desktop) --}}
          <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden group mb-8 lg:mb-8">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <h3 class="font-bold text-xl mb-2">Pendaftaran Santri Baru Dibuka!</h3>
            <p class="text-green-50 text-sm mb-5 leading-relaxed">Bergabunglah bersama ribuan santri lainnya menghafal Al-Qur'an dengan metode sanad bersertifikat.</p>
            <a href="/login?mode=register" class="inline-block bg-white text-green-700 font-bold text-sm px-5 py-2.5 rounded-xl shadow-md hover:bg-gray-50 transition-colors">
              Daftar Sekarang
            </a>
          </div>



          {{-- 3. Daftar Artikel Terbaru (Sidebar) --}}
          <div>
            <h3 class="text-lg font-bold text-gray-900 mb-6 lg:mb-6 border-l-4 border-green-500 pl-3">Artikel Terbaru</h3>
            {{-- [REVISI] space-y-4 (mobile) agar list artikel lebih rapat --}}
            <div class="space-y-4 lg:space-y-5">
              @foreach($recentArticles as $recent)
              <a href="{{ route('blog.show', $recent->slug) }}" class="flex items-center gap-4 group">
                <div class="w-20 h-16 lg:w-24 lg:h-20 shrink-0 rounded-lg overflow-hidden bg-gray-100 shadow-sm">
                  @if($recent->thumbnail)
                  <img src="{{ asset('storage/' . $recent->thumbnail) }}" alt="{{ $recent->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                  @else
                  <svg class="w-8 h-8 mx-auto mt-6 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path>
                  </svg>
                  @endif
                </div>
                <div>
                  <h4 class="text-sm font-bold text-gray-800 line-clamp-2 leading-snug group-hover:text-green-600 transition-colors mb-1">
                    {{ $recent->title }}
                  </h4>
                  <p class="text-[11px] font-medium text-gray-500">{{ $recent->created_at->translatedFormat('d M Y') }}</p>
                </div>
              </a>
              @endforeach
            </div>
          </div>

          {{-- Slider Banner Sidebar --}}
          @if(isset($sidebarBanner))
          {!! $sidebarBanner !!}
          @endif


        </aside>

      </div>
    </div>
  </main>

  {{-- ======================================================== --}}
  {{-- TAMBAHAN: FLOATING POPUP BANNER (FIXED SHADOW CORNER) --}}
  {{-- ======================================================== --}}
  <div x-data="{ showPromo: false }"
    x-init="setTimeout(() => showPromo = true, 1000)"
    x-show="showPromo"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 translate-x-10 md:translate-x-0 md:translate-y-10"
    x-transition:enter-end="opacity-100 translate-x-0 md:translate-y-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-x-0 md:translate-y-0"
    x-transition:leave-end="opacity-0 translate-x-10 md:translate-x-0 md:translate-y-10"
    class="fixed z-[100] right-0 top-1/2 transform -translate-y-1/2 w-10 sm:w-12 md:right-auto md:top-auto md:bottom-6 md:left-1/2 md:-translate-x-1/2 md:translate-y-0 md:w-auto md:max-w-xl"
    style="display: none;">

    {{-- Tombol Close --}}
    <button @click="showPromo = false" class="absolute -top-2 -left-3 md:-top-3 md:-left-3 z-20 w-6 h-6 md:w-8 md:h-8 bg-white text-gray-500 border border-gray-200 rounded-full flex items-center justify-center shadow-md hover:scale-105 hover:text-gray-800 transition-all focus:outline-none">
      <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </button>

    {{-- Isi Banner (Link Pendaftaran) --}}
    {{-- PERBAIKAN: Bayangan (Shadow) dipindah ke sini agar mengikuti bentuk rounded --}}
    <a href="/login?mode=register" class="group relative flex flex-col md:flex-row items-center bg-gradient-to-b md:bg-gradient-to-r from-[#023e32] to-[#046b55] rounded-l-lg md:rounded-lg overflow-hidden transition-all duration-300 shadow-[-5px_10px_30px_rgba(0,0,0,0.2)] md:shadow-[0_10px_30px_rgba(0,0,0,0.25)] hover:shadow-[-5px_15px_40px_rgba(4,107,85,0.3)] md:hover:shadow-[0_15px_40px_rgba(4,107,85,0.3)]">

      {{-- Area Gambar Kiri / Atas --}}
      <div class="relative w-full h-12 md:w-28 md:h-20 shrink-0 bg-[#022c23] flex items-center justify-center overflow-hidden border-b md:border-b-0 md:border-r border-[#046b55]/50">
        <svg class="w-6 h-6 md:w-10 md:h-10 text-green-500/40" fill="currentColor" viewBox="0 0 24 24">
          <path d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1zM21 18.5c-1.1-.35-2.3-.5-3.5-.5-1.7 0-4.15.65-5.5 1.5V8c1.35-.85 3.8-1.5 5.5-1.5 1.2 0 2.4.15 3.5.5v11.5z"></path>
        </svg>
      </div>

      {{-- Area Teks --}}
      {{-- PERUBAHAN MOBILE: py-4 menjadi py-8 (jarak atas-bawah memanjang), px-1 menjadi px-2 (jarak kiri-kanan melebar) --}}
      <div class="flex-1 py-8 px-2 md:py-3 md:px-5 relative z-10 flex flex-col justify-center items-center text-center md:text-left">

        <span class="block md:hidden text-white font-bold text-[11px] sm:text-xs leading-relaxed tracking-wider rotate-180" style="writing-mode: vertical-rl;">
          Mau lancar membaca Al-Qur'an bersanad? <span class="text-green-300 mt-1">Daftar sekarang!</span>
        </span>

        <h4 class="hidden md:block text-white font-bold text-base leading-snug">
          Mau lancar membaca Al-Qur'an bersanad? <br>
          <span class="text-green-300">Daftar sekarang!</span>
        </h4>
      </div>

      {{-- Area Tombol Panah --}}
      <div class="pb-3 md:pb-0 md:pr-5 relative z-10 shrink-0 mt-2 md:mt-0">
        <div class="w-6 h-6 md:w-9 md:h-9 bg-white rounded-full flex items-center justify-center group-hover:translate-y-1 md:group-hover:translate-y-0 md:group-hover:translate-x-1 transition-transform shadow-sm">
          <svg class="w-3.5 h-3.5 md:w-5 md:h-5 text-[#046b55] rotate-90 md:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
          </svg>
        </div>
      </div>
    </a>
  </div>

</x-layout>