<x-student-layout>
  <div class="container max-w-5xl mx-auto pt-2 pb-12 md:pt-0 px-4">

    {{-- Header Section --}}
    <div class="text-center mb-10 md:mb-12">
      <h1 class="text-3xl font-bold text-gray-800 dark:text-white transition-colors">Al-Qur'an Digital</h1>
      <p class="text-gray-500 dark:text-gray-400 mt-2 transition-colors">Baca dan tadabburi Al-Qur'an setiap hari.</p>

      {{-- Search Bar --}}
      <div class="relative max-w-xl mx-auto mt-6">
        <input type="text"
          id="searchSurat"
          placeholder="Cari nama surat, nomor, atau arti..."
          class="w-full px-6 py-3.5 md:py-4 border border-gray-200 dark:border-gray-800 rounded-full focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-center bg-white dark:bg-[#151c27] text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 shadow-sm transition-all duration-300">
      </div>

      <p class="mt-3 text-[11px] md:text-xs text-gray-400 dark:text-gray-500 font-medium">
        Contoh: "Al-Fatihah", "1", atau "Pembukaan"
      </p>

      {{-- Indikator Statistik --}}
      <div class="mt-5 flex flex-wrap items-center justify-center gap-5 md:gap-8 text-xs md:text-sm font-semibold text-gray-600 dark:text-gray-300">
        <div class="flex items-center gap-2">
          <span class="w-2 h-2 md:w-2.5 md:h-2.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
          <span>114 Surat</span>
        </div>
        <div class="flex items-center gap-2">
          <span class="w-2 h-2 md:w-2.5 md:h-2.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)]"></span>
          <span>6.236 Ayat</span>
        </div>
        <div class="flex items-center gap-2">
          <span class="w-2 h-2 md:w-2.5 md:h-2.5 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.5)]"></span>
          <span>30 Juz</span>
        </div>
      </div>
    </div>

    {{-- Grid Daftar Surat (Layout Ramping ala eQuran) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="suratContainer">
      @foreach($surat as $s)
      {{--
        [PERBAIKAN UI] 
        - Padding dirampingkan menjadi p-4 (semua sisi sama rata)
        - min-h diturunkan menjadi 80px agar kotak tidak terlalu tinggi
      --}}
      <a href="{{ route('quran.show', $s['nomor']) }}"
        class="surat-item block bg-white dark:bg-[#121824] p-4 rounded-2xl border border-gray-200/80 dark:border-gray-800/80 hover:shadow-md hover:border-emerald-400 dark:hover:border-emerald-600/50 transition-all duration-300 group relative overflow-hidden flex flex-col justify-center min-h-[85px]">

        <div class="absolute inset-0 bg-emerald-50/50 dark:bg-emerald-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

        <div class="flex items-center justify-between relative z-10 w-full">
          <div class="flex items-center gap-3.5">
            {{-- Lingkaran Nomor: Diperkecil menjadi w-9 h-9 agar tidak dominan --}}
            <div class="w-9 h-9 shrink-0 border-[1.5px] border-emerald-500/40 dark:border-emerald-600/50 text-emerald-600 dark:text-emerald-500 rounded-full flex items-center justify-center font-bold text-xs group-hover:bg-emerald-500 group-hover:border-emerald-500 group-hover:text-white transition-all duration-300">
              <span class="search-nomor">{{ $s['nomor'] }}</span>
            </div>

            <div class="flex flex-col justify-center">
              {{-- [PERBAIKAN] Class "search-judul" ditambahkan untuk target filter --}}
              <h3 class="search-judul font-bold text-gray-800 dark:text-gray-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors text-sm md:text-[15px] leading-tight">
                {{ $s['namaLatin'] }}
              </h3>

              <p class="search-arti text-[11px] md:text-xs text-gray-500 dark:text-gray-400 mt-1 mb-1.5 line-clamp-1">
                {{ $s['arti'] }}
              </p>

              <div class="flex items-center gap-1.5">
                <span class="inline-flex items-center gap-1 px-2 py-[2px] rounded-full border border-gray-200 dark:border-gray-700/60 text-[9px] font-semibold text-gray-500 dark:text-gray-400 bg-gray-50/50 dark:bg-[#1a2332]">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-2.5 h-2.5 opacity-70">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                  </svg>
                  {{ $s['tempatTurun'] }}
                </span>

                <span class="inline-flex items-center gap-1 px-2 py-[2px] rounded-full border border-gray-200 dark:border-gray-700/60 text-[9px] font-semibold text-gray-500 dark:text-gray-400 bg-gray-50/50 dark:bg-[#1a2332]">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-2.5 h-2.5 opacity-70">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                  </svg>
                  {{ $s['jumlahAyat'] }}
                </span>
              </div>
            </div>
          </div>

          {{-- Teks Arab --}}
          <div class="text-[1.3rem] md:text-[1.4rem] font-arab text-emerald-700 dark:text-emerald-500 group-hover:text-emerald-800 dark:group-hover:text-emerald-400 transition-colors ml-2 shrink-0">
            {{ $s['nama'] }}
          </div>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</x-student-layout>