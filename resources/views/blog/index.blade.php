<x-layout>
  <main class="w-full bg-white min-h-screen pb-12 md:pb-24">

    {{-- 1. HEADER GELAP --}}
    <div class="w-full bg-green-800 pt-24 pb-16 md:pt-40 md:pb-24 px-4 relative overflow-hidden">
    <div class="absolute inset-0 opacity-20 mix-blend-overlay" style="background-image: url('{{ asset('arabesque.png') }}');"></div>
      <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-green-700 rounded-full blur-3xl opacity-50"></div>
      <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-64 h-64 bg-green-900 rounded-full blur-3xl opacity-50"></div>

      <div class="container max-w-7xl mx-auto text-center relative z-10">
        <span class="text-green-300 font-bold tracking-wider uppercase text-sm mb-3 block">Ruang Inspirasi</span>

        {{-- Judul Dinamis: Berubah sesuai filter yang sedang aktif --}}
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6">
          @if(request('category'))
          Kategori: {{ $categories->where('slug', request('category'))->first()->name ?? 'Artikel' }}
          @elseif(request('author'))
          Tulisan oleh: {{ request('author') }}
          @else
          Kisah & Motivasi Qur'ani
          @endif
        </h1>

        <p class="text-green-50 max-w-2xl mx-auto text-sm md:text-base leading-relaxed">
          Temukan berbagai kisah inspiratif para penghafal Al-Qur'an, tips tajwid, sejarah Islam, dan motivasi spiritual untuk menemani perjalanan hijrahmu.
        </p>
      </div>
    </div>

    {{-- 2. KONTEN UTAMA --}}
    <div class="container max-w-7xl mx-auto px-4 md:px-6 py-8 md:py-16">

      {{-- TAMBAHAN 1: MENU NAVIGASI KATEGORI (Scrollable di HP) --}}
      <div class="flex overflow-x-auto pb-4 mb-8 md:mb-10 gap-3 no-scrollbar border-b border-gray-100">
        {{-- Tombol "Semua Artikel" --}}
        <a href="{{ route('blog.index') }}" class="whitespace-nowrap px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 shadow-sm border {{ !request('category') && !request('author') ? 'bg-green-600 text-white border-green-600' : 'bg-white text-gray-600 border-gray-200 hover:bg-green-50 hover:text-green-700 hover:border-green-200' }}">
          Semua Artikel
        </a>

        {{-- Looping Tombol Kategori dari Database --}}
        @if(isset($categories))
        @foreach($categories as $cat)
        <a href="{{ route('blog.index', ['category' => $cat->slug]) }}" class="whitespace-nowrap px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 shadow-sm border {{ request('category') == $cat->slug ? 'bg-green-600 text-white border-green-600' : 'bg-white text-gray-600 border-gray-200 hover:bg-green-50 hover:text-green-700 hover:border-green-200' }}">
          {{ $cat->name }}
        </a>
        @endforeach
        @endif
      </div>

      {{-- TAMBAHAN 2: BANNER HAPUS FILTER (Muncul jika ada filter aktif) --}}
      @if(request('category') || request('author'))
      <div class="mb-8 flex flex-wrap items-center justify-between gap-4 bg-green-50 border border-green-100 p-4 rounded-xl">
        <span class="text-sm font-medium text-green-800">Menampilkan hasil pencarian filter spesifik.</span>
        <a href="{{ route('blog.index') }}" class="text-sm font-bold text-red-500 hover:text-red-700 flex items-center gap-1 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
          Hapus Filter
        </a>
      </div>
      @endif

      {{-- GRID ARTIKEL --}}
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-x-8 md:gap-y-12">

        @forelse($articles as $article)
        <a href="{{ route('blog.show', $article->slug) }}" class="group flex flex-row md:flex-col gap-4 md:gap-5 items-start">

          {{-- Area Gambar (Thumbnail) --}}
          <div class="relative w-32 sm:w-40 md:w-full shrink-0 aspect-[4/3] md:aspect-[16/10] rounded-xl overflow-hidden bg-gray-100">
            @if($article->thumbnail)
            <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-in-out">
            @else
            <div class="w-full h-full flex items-center justify-center text-gray-300">
              <svg class="w-8 h-8 md:w-12 md:h-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path>
              </svg>
            </div>
            @endif

            {{-- TAMBAHAN 3: LABEL KATEGORI DINAMIS --}}
            <div class="absolute top-2 right-2 md:top-3 md:right-3 text-yellow-400 font-extrabold text-[10px] md:text-sm uppercase tracking-wider drop-shadow-md">
              {{ $article->category ? $article->category->name : 'UMUM' }}
            </div>
          </div>

          {{-- Area Teks --}}
          <div class="flex flex-col flex-1 min-w-0">
            {{-- Judul --}}
            <h2 class="text-[15px] sm:text-base md:text-xl font-bold text-gray-900 mb-1.5 md:mb-2 line-clamp-2 md:line-clamp-3 group-hover:text-green-600 transition-colors leading-snug">
              {{ $article->title }}
            </h2>

            {{-- Meta Data --}}
            <div class="flex items-center flex-wrap text-[11px] md:text-sm text-gray-500 font-medium gap-1 md:gap-1.5 mt-auto">
              {{-- TAMBAHAN 4: NAMA PENULIS SEBAGAI FILTER --}}
              {{-- Tag <object> digunakan agar tag <a> ini tidak bertabrakan dengan tag <a> pembungkus card artikel --}}
              <object>
                <a href="{{ route('blog.index', ['author' => $article->author]) }}" class="font-bold text-gray-700 hover:text-green-600 transition-colors">
                  {{ $article->author }}
                </a>
              </object>
              <span class="mx-0.5 md:mx-1">&bull;</span>

             <span>{{ $article->created_at->translatedFormat('d F Y') }}</span>
              <span class="mx-0.5 md:mx-1">&bull;</span>

              @php
              $wordCount = str_word_count(strip_tags($article->content));
              $readTime = ceil($wordCount / 200) ?: 1;
              @endphp
              <span>{{ $readTime }} min read</span>
            </div>
          </div>
        </a>
        @empty
        {{-- Tampilan Kosong --}}
        <div class="col-span-full flex flex-col items-center justify-center py-16 md:py-24 text-center">
          <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Artikel</h3>
          <p class="text-gray-500 max-w-sm mx-auto">Silakan pilih kategori lain atau hapus filter untuk melihat artikel lainnya.</p>
        </div>
        @endforelse

      </div>

      {{-- Navigasi Halaman (Pagination) --}}
      <div class="mt-12 md:mt-16">
        {{ $articles->links() }}
      </div>

    </div>
  </main>

  {{-- CSS TAMBAHAN: Menyembunyikan scrollbar bawaan browser pada deretan menu kategori di HP --}}
  <style>
    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }

    .no-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>
</x-layout>