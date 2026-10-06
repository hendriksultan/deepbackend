<x-student-layout>
  <div class="container max-w-4xl mx-auto pt-2 pb-8 md:pt-0 px-4"
    x-data="{ 
            qori: '05', 
            showTransliteration: true, 
            showTranslation: true,
            fullAudio: @js($detail['audioFull']),
            mainPlaying: false,

            {{-- STATE UNTUK MODAL TAFSIR --}}
            tafsirModalOpen: false,
            tafsirAyat: null,
            tafsirArab: '',
            tafsirText: '',
            tafsirCache: null,
            isLoadingTafsir: false,

            {{-- [PERBAIKAN] MENGUNCI SCROLL BODY SAAT MODAL TERBUKA --}}
            init() {
                this.$watch('tafsirModalOpen', value => {
                    if (value) {
                        document.body.classList.add('overflow-hidden');
                    } else {
                        document.body.classList.remove('overflow-hidden');
                    }
                });
            },

            {{-- FUNGSI MENGAMBIL DATA TAFSIR --}}
            async fetchTafsir(ayatNum, arabText) {
                this.tafsirAyat = ayatNum;
                this.tafsirArab = arabText;
                this.tafsirModalOpen = true;
                this.isLoadingTafsir = true;

                // Ambil data dari API eQuran jika belum ada di cache
                if (!this.tafsirCache) {
                    try {
                        let res = await fetch('https://equran.id/api/v2/tafsir/{{ $detail['nomor'] }}');
                        let data = await res.json();
                        this.tafsirCache = data.data.tafsir;
                    } catch (e) {
                        this.tafsirText = 'Gagal mengambil data tafsir. Pastikan koneksi internet Anda stabil.';
                        this.isLoadingTafsir = false;
                        return;
                    }
                }

                // Cari tafsir berdasarkan nomor ayat
                let found = this.tafsirCache.find(t => t.ayat == ayatNum);
                this.tafsirText = found ? found.teks : 'Tafsir tidak tersedia.';
                this.isLoadingTafsir = false;
            }
        }">

    {{-- ========================================== --}}
    {{-- HEADER SURAT (Versi Ramping & Proporsional) --}}
    {{-- ========================================== --}}
    <div class="bg-gradient-to-r from-emerald-700 to-green-600 dark:from-emerald-800 dark:to-green-900 rounded-[2rem] py-6 px-4 md:py-8 md:px-8 text-white text-center mb-6 shadow-xl relative overflow-hidden transition-all">
      <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/arabesque.png')]"></div>

      <div class="relative z-10 flex flex-col items-center justify-center">
        {{-- Teks Arab diperkecil dan jarak bawah dikurangi --}}
        <h1 class="text-4xl md:text-5xl font-arab mb-2 drop-shadow-md">{{ $detail['nama'] }}</h1>

        {{-- Teks Latin diperkecil agar seimbang --}}
        <h2 class="text-xl md:text-2xl font-bold tracking-wide">{{ $detail['namaLatin'] }}</h2>

        <p class="text-emerald-100 text-xs md:text-sm mt-1 opacity-90 tracking-widest uppercase font-semibold">
          {{ $detail['arti'] }} • {{ $detail['jumlahAyat'] }} Ayat • {{ $detail['tempatTurun'] }}
        </p>

        <audio x-ref="mainAudio" @play="mainPlaying = true" @pause="mainPlaying = false" @ended="mainPlaying = false" :src="fullAudio[qori]" class="hidden"></audio>

        {{-- Jarak tombol ditarik lebih ke atas (mt-8 menjadi mt-5) --}}
        <div class="mt-5 flex justify-center gap-3">
          <a href="{{ route('quran.index') }}" class="px-5 py-2 md:py-2.5 bg-white/10 hover:bg-white/20 rounded-full text-xs md:text-sm font-bold backdrop-blur-md transition border border-white/20 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
          </a>
          <a href="{{ route('quran.tafsir', $detail['nomor']) }}" class="px-5 py-2 md:py-2.5 bg-yellow-400 text-emerald-900 hover:bg-yellow-300 rounded-full text-xs md:text-sm font-extrabold transition shadow-lg flex items-center gap-2 transform hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
            </svg>
            Tafsir Full
          </a>
        </div>
      </div>
    </div>

    {{-- Sticky Control Bar --}}
    <div class="sticky top-[70px] md:top-20 z-30 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl px-5 py-4 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] border border-gray-200/50 dark:border-gray-800 mb-8 flex flex-wrap items-center justify-between gap-y-4 gap-x-6">

      <div class="flex items-center gap-3 flex-grow md:flex-grow-0">
        <label for="qoriSelect" class="text-xs md:text-sm font-extrabold text-gray-700 dark:text-gray-300">Qari:</label>
        <div class="relative w-full md:w-56">
          <select id="qoriSelect" x-model="qori" class="w-full appearance-none bg-gray-100 dark:bg-gray-800 border border-transparent dark:border-gray-700 text-gray-800 dark:text-gray-200 py-2 pl-4 pr-10 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs md:text-sm font-semibold cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-700">
            <option value="01">Abdullah Al-Juhany</option>
            <option value="02">Abdul Muhsin Al-Qasim</option>
            <option value="03">Abdurrahman as-Sudais</option>
            <option value="04">Ibrahim Al-Dossari</option>
            <option value="05">Misyari Rasyid Al-Afasi</option>
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="flex items-center gap-4 md:gap-6 justify-between w-full md:w-auto">
        <div class="flex items-center gap-4">
          <label class="relative inline-flex items-center cursor-pointer group">
            <input type="checkbox" x-model="showTransliteration" class="sr-only peer">
            <div class="w-9 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-500"></div>
            <span class="ml-2 text-xs md:text-sm font-bold text-gray-600 dark:text-gray-400 group-hover:text-emerald-600 transition-colors">Latin</span>
          </label>
          <label class="relative inline-flex items-center cursor-pointer group">
            <input type="checkbox" x-model="showTranslation" class="sr-only peer">
            <div class="w-9 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-500"></div>
            <span class="ml-2 text-xs md:text-sm font-bold text-gray-600 dark:text-gray-400 group-hover:text-emerald-600 transition-colors">Terjemahan</span>
          </label>
        </div>

        <button @click="mainPlaying ? $refs.mainAudio.pause() : $refs.mainAudio.play()"
          class="flex items-center gap-2 px-4 py-2 rounded-full font-bold text-xs md:text-sm transition-all shadow-sm"
          :class="mainPlaying ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100'">
          <svg x-show="!mainPlaying" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M8 5v14l11-7z" />
          </svg>
          <svg x-show="mainPlaying" x-cloak class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" />
          </svg>
          <span x-text="mainPlaying ? 'Pause Audio' : 'Play Audio Full'" class="hidden sm:inline"></span>
          <span x-show="!mainPlaying" class="sm:hidden">Play</span>
          <span x-show="mainPlaying" class="sm:hidden" x-cloak>Pause</span>
        </button>
      </div>
    </div>

    {{-- Bismillah --}}
    @if($detail['nomor'] != 1 && $detail['nomor'] != 9)
    <div class="text-center mb-12">
      <p class="text-4xl md:text-5xl font-arab text-gray-800 dark:text-gray-200 transition-colors drop-shadow-sm">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</p>
    </div>
    @endif

    {{-- ========================================== --}}
    {{-- DAFTAR AYAT --}}
    {{-- ========================================== --}}
    <div class="space-y-6">
      @foreach($detail['ayat'] as $ayat)
      <div id="ayat-{{ $ayat['nomorAyat'] }}"
        x-data="{ 
            ayatAudio: @js($ayat['audio']), 
            playing: false,
            copied: false,
            copyText() {
                let txt = `${this.$refs.arabText.innerText}\n\n${this.$refs.latinText ? this.$refs.latinText.innerText : ''}\n\n${this.$refs.indoText ? this.$refs.indoText.innerText : ''}`;
                navigator.clipboard.writeText(txt.trim()).then(() => {
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                });
            }
        }"
        class="bg-white dark:bg-gray-800/90 p-5 md:p-8 rounded-[2rem] border border-gray-100 dark:border-gray-800 hover:border-emerald-200 dark:hover:border-emerald-800 transition duration-300 shadow-sm relative group target:ring-2 target:ring-emerald-400">

        <div class="flex items-center gap-3 mb-6">
          <span class="w-10 h-10 border-2 border-emerald-500/30 text-emerald-600 dark:text-emerald-400 rounded-full flex items-center justify-center text-sm font-extrabold shrink-0">
            {{ $ayat['nomorAyat'] }}
          </span>

          <div class="flex items-center gap-1">
            {{-- 1. Play Audio Ayat --}}
            <audio x-ref="player" @play="playing = true" @pause="playing = false" @ended="playing = false" :src="ayatAudio[qori]"></audio>
            <button @click="playing ? $refs.player.pause() : $refs.player.play()" class="p-2 text-gray-400 hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors" title="Putar Audio Ayat">
              <svg x-show="!playing" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <svg x-show="playing" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </button>

            {{-- 2. TAFSIR (TOMBOL POPUP MODAL) --}}
            <button @click="fetchTafsir({{ $ayat['nomorAyat'] }}, $refs.arabText.innerText)" class="p-2 text-gray-400 hover:text-blue-500 dark:hover:text-blue-400 transition-colors" title="Lihat Tafsir Ayat">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path>
              </svg>
            </button>

            {{-- 3. Copy Teks --}}
            <button @click="copyText()" class="p-2 text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors relative" title="Salin Teks">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
              </svg>
              <span x-show="copied" x-cloak x-transition class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-[10px] font-bold px-2 py-1 rounded shadow-lg">Disalin!</span>
            </button>

            {{-- 4. Bookmark --}}
            @php $isBookmarked = in_array($ayat['nomorAyat'], $bookmarks ?? []); @endphp
            <button onclick="toggleBookmark({{ $detail['nomor'] }}, {{ $ayat['nomorAyat'] }}, this)" class="p-2 transition-colors focus:outline-none" title="Tandai Terakhir Baca">
              <svg class="w-5 h-5 {{ $isBookmarked ? 'text-yellow-500 fill-current' : 'text-gray-400 hover:text-yellow-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
              </svg>
            </button>
          </div>
        </div>

        <div class="text-right mb-8">
          <p x-ref="arabText" class="font-arab text-[2rem] md:text-[2.75rem] text-gray-900 dark:text-gray-50 leading-[4.5rem] md:leading-[5.5rem] tracking-wide" dir="rtl">
            {{ $ayat['teksArab'] }}
          </p>
        </div>

        <div class="text-left space-y-3">
          <div x-show="showTransliteration" x-transition x-cloak>
            <p x-ref="latinText" class="text-emerald-600 dark:text-emerald-400 text-sm md:text-base font-semibold mb-1">
              {!! $ayat['teksLatin'] !!}
            </p>
          </div>

          <div x-show="showTranslation" x-transition x-cloak>
            <p x-ref="indoText" class="text-gray-600 dark:text-gray-300 text-sm md:text-base leading-relaxed">
              {{ $ayat['teksIndonesia'] }}
            </p>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    {{-- Navigasi Surat Berikutnya --}}
    @if(isset($detail['suratSelanjutnya']) && $detail['suratSelanjutnya'])
    <div class="mt-12 text-center md:text-right">
      <a href="{{ route('quran.show', $detail['suratSelanjutnya']['nomor']) }}" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-full hover:bg-emerald-600 dark:hover:bg-emerald-500 hover:text-white transition-all shadow-xl font-bold text-sm w-full md:w-auto">
        <span>Surat Selanjutnya: <strong>{{ $detail['suratSelanjutnya']['namaLatin'] }}</strong></span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
        </svg>
      </a>
    </div>
    @endif

    {{-- ========================================== --}}
    {{-- POPUP MODAL TAFSIR (Desain Mengambang Persis eQuran) --}}
    {{-- ========================================== --}}
    <div x-show="tafsirModalOpen"
      style="display: none; z-index: 99999;"
      {{-- [PERBAIKAN] Class items-center untuk membuat modal selalu di tengah di semua ukuran layar --}}
      class="fixed inset-0 flex items-center justify-center p-4 sm:p-6 bg-gray-900/80 backdrop-blur-sm transition-opacity"
      @keydown.escape.window="tafsirModalOpen = false">

      {{-- Card Modal --}}
      <div x-show="tafsirModalOpen"
        @click.away="tafsirModalOpen = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        {{-- [PERBAIKAN] Menghapus rounded-t-[2rem] dan memaksa rounded-[1.5rem] di semua sisi --}}
        class="bg-white dark:bg-[#121824] w-full max-w-3xl max-h-[85vh] rounded-[1.5rem] shadow-2xl flex flex-col overflow-hidden border border-gray-100 dark:border-gray-800/60 relative">

        {{-- Header Modal --}}
        <div class="px-5 py-4 md:px-6 md:py-5 border-b border-gray-100 dark:border-gray-800/60 flex justify-between items-center bg-white dark:bg-[#121824] z-10 shrink-0">
          <div class="flex items-center gap-3 md:gap-4">
            {{-- Icon Buku Biru --}}
            <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-md shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 md:w-6 md:h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
              </svg>
            </div>
            <div class="flex flex-col">
              <h3 class="text-base md:text-xl font-bold text-gray-900 dark:text-white leading-tight">
                Tafsir {{ $detail['namaLatin'] }} <span class="md:hidden">Ayat <span x-text="tafsirAyat"></span></span>
              </h3>
              {{-- Badge Surat & Ayat --}}
              <div class="flex items-center gap-2 mt-1">
                <span class="px-2.5 py-0.5 bg-gray-100 dark:bg-[#1f2937] text-gray-600 dark:text-gray-300 text-[10px] md:text-xs font-bold rounded-full">{{ $detail['namaLatin'] }}</span>
                <span class="hidden md:inline-flex px-2.5 py-0.5 bg-gray-100 dark:bg-[#1f2937] text-gray-600 dark:text-gray-300 text-[10px] md:text-xs font-bold rounded-full" x-text="'Ayat ' + tafsirAyat"></span>
              </div>
            </div>
          </div>

          {{-- Tombol Silang (X) --}}
          <button @click="tafsirModalOpen = false" class="p-2 text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors focus:outline-none shrink-0 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>

        {{-- Body Modal (Scrollable dengan Scrollbar Estetik) --}}
        <div class="p-5 md:p-8 overflow-y-auto flex-1 bg-white dark:bg-[#121824] scroll-smooth [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full">

          {{-- Kotak Teks Arab (Mirip eQuran) --}}
          <div class="bg-gray-50 dark:bg-[#1a2332] border border-gray-200/60 dark:border-gray-800/80 p-5 md:p-6 rounded-2xl mb-6 shadow-sm">
            <p class="font-arab text-2xl md:text-4xl text-gray-900 dark:text-white text-right leading-[4rem] md:leading-[5rem]" dir="rtl" x-text="tafsirArab"></p>
          </div>

          {{-- Loading Spinner --}}
          <div x-show="isLoadingTafsir" class="py-12 flex flex-col items-center justify-center">
            <svg class="animate-spin h-8 w-8 text-blue-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm text-gray-500 font-medium">Mengambil Tafsir Kemenag RI...</span>
          </div>

          {{-- Konten Tafsir Aktual --}}
          <div x-show="!isLoadingTafsir" class="text-gray-700 dark:text-gray-300 text-sm md:text-base text-justify leading-relaxed">
            <p class="whitespace-pre-line" x-text="tafsirText"></p>
          </div>

        </div>

        {{-- [BARU] Footer Modal (Tombol Tutup Bawah) --}}
        <div class="p-4 border-t border-gray-100 dark:border-gray-800/60 bg-gray-50 dark:bg-[#121824] flex justify-end shrink-0">
          <button @click="tafsirModalOpen = false" class="px-5 py-2 text-sm font-bold bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-transparent dark:border dark:border-gray-600 dark:hover:bg-gray-800 dark:text-white rounded-full transition-colors focus:outline-none">
            Tutup
          </button>
        </div>
      </div>
    </div>
  </div>


</x-student-layout>