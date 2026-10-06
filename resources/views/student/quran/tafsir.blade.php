<x-student-layout>
  <div class="container max-w-5xl mx-auto pt-2 pb-8 md:pt-0 px-4">

    {{-- Breadcrumb / Link Kembali --}}
    <div class="mb-6">
      <a href="{{ route('quran.show', $tafsir['nomor']) }}"
        class="inline-flex items-center gap-2 px-4 py-2 text-green-700 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/30 rounded-xl transition-all duration-300 font-semibold group w-fit">
        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Surat {{ $tafsir['namaLatin'] }}
      </a>
    </div>

    {{-- Kartu Utama Tafsir --}}
    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 transition-all duration-300">

      {{-- Header Tafsir --}}
      <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2 transition-colors">
        Tafsir {{ $tafsir['namaLatin'] }}
      </h1>
      <p class="text-gray-500 dark:text-gray-400 mb-8 border-b border-gray-100 dark:border-gray-700 pb-4 transition-colors">
        Sumber: Kemenag RI
      </p>

      {{-- List Tafsir Per Ayat --}}
      <div class="space-y-8">
        @foreach($tafsir['tafsir'] as $t)
        <div class="group">
          {{-- Header Ayat --}}
          <h3 class="text-lg font-bold text-green-700 dark:text-green-400 mb-3 flex items-center gap-2 transition-colors">
            <span class="w-8 h-8 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full flex items-center justify-center text-xs shadow-sm border border-green-200 dark:border-green-800/50">
              {{ $t['ayat'] }}
            </span>
            Tafsir Ayat {{ $t['ayat'] }}
          </h3>

          {{-- Isi Tafsir --}}
          <div class="pl-2 md:pl-10 border-l-2 border-gray-100 dark:border-gray-700 group-hover:border-green-200 dark:group-hover:border-green-800 transition-colors">
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-justify text-base">
              {{ $t['teks'] }}
            </p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</x-student-layout>