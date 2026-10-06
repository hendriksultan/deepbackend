@php
    // Cek mandiri apakah user ini santri Iqra (dari jadwal kelas atau dari level akunnya)
    $isIqraStudent = \App\Models\Booking::where('user_id', Auth::id())
        ->whereIn('status', ['active', 'approved'])
        ->where('program_type', 'like', '%iqra%')
        ->exists() || str_contains(strtolower(auth()->user()->student_level ?? ''), 'iqra');

    // UNTUK TESTING: Hapus tanda // di bawah ini jika ingin memunculkan paksa tabnya
    // $isIqraStudent = true; 
@endphp
    {{-- 4. TAB SYSTEM (Updated with Quran Tab) --}}
    <div x-data="{ activeTab: 'rekomendasi' }" class="mb-12">

      {{-- TAB NAVIGATION --}}
      <div class="flex md:justify-center mb-8 overflow-x-auto hide-scrollbar pb-2 -mx-4 px-4 md:mx-0 md:px-0">
        <div class="bg-gray-100 dark:bg-gray-800 p-1.5 rounded-2xl inline-flex gap-2 border border-gray-200 dark:border-gray-700 shadow-inner flex-nowrap min-w-max">

          {{-- TAB 1: REKOMENDASI --}}
          <button @click="activeTab = 'rekomendasi'"
            :class="activeTab === 'rekomendasi' ? 'bg-white dark:bg-gray-700 text-green-600 dark:text-green-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
            class="px-4 md:px-5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-all duration-300 flex items-center gap-2 whitespace-nowrap group">
            {{-- Icon Sparkles (Pengganti ✨) --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:scale-110">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
            </svg>
            <span>Rekomendasi</span>
          </button>

          {{-- TAB 2: AL-QURAN --}}
          <button @click="activeTab = 'quran'"
            :class="activeTab === 'quran' ? 'bg-white dark:bg-gray-700 text-green-600 dark:text-green-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
            class="px-4 md:px-5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-all duration-300 flex items-center gap-2 whitespace-nowrap group">
            {{-- Icon Book Open (Pengganti 📖) --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:scale-110">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
            </svg>
            <span>Al-Qur'an</span>
          </button>

          {{-- TAB 3: INFO BIAYA --}}
          <button @click="activeTab = 'biaya'"
            :class="activeTab === 'biaya' ? 'bg-white dark:bg-gray-700 text-green-600 dark:text-green-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
            class="px-4 md:px-5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-all duration-300 flex items-center gap-2 whitespace-nowrap group">
            {{-- Icon Banknotes (Pengganti 💰) --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:scale-110">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
            </svg>
            <span>Info Biaya</span>
          </button>

          {{-- TAB 4: MATERI --}}
          <button @click="activeTab = 'materi'"
            :class="activeTab === 'materi' ? 'bg-white dark:bg-gray-700 text-green-600 dark:text-green-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
            class="px-4 md:px-5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-all duration-300 flex items-center gap-2 whitespace-nowrap group">
            {{-- Icon Folder Open (Pengganti 📚) --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:scale-110">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h4.375L12 6h7.5A2.25 2.25 0 0 1 21.75 8.25v1.5m-16.5 0h16.5" />
            </svg>
            <span>Materi</span>
          </button>

       {{-- TOMBOL MENUJU HALAMAN FUN GAME (HIJAIYAH) --}}
          @if($isIqraStudent)
           <a href="{{ route('student.hijaiyah') }}"
             class="px-4 md:px-5 py-2.5 rounded-xl text-xs md:text-sm font-bold bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white shadow-lg shadow-pink-200 dark:shadow-none transition-all duration-300 flex items-center gap-2 whitespace-nowrap hover:-translate-y-1">
             
             {{-- Icon Roket (Rocket Launch) --}}
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5 animate-bounce">
               <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.45c.019-.104.039-.208.06-.311m-2.259 3.398c-1.012-1.012-1.428-2.48-1.285-3.905m1.285 3.905c1.012-1.012 1.428-2.48 1.285-3.905M9.631 8.41c1.013-1.012 2.48-1.428 3.905-1.285m-3.905 1.285c-1.012-1.012-2.48-1.428-3.905-1.285" />
             </svg>
             
             <span>Mulai Petualangan!</span>
           </a>
           @endif


        </div>
      </div>

      {{-- CONTENT 1: REKOMENDASI GURU --}}
      <div x-show="activeTab === 'rekomendasi'"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0">

        {{-- [Auto Slider Script untuk Rekomendasi] --}}
        <div x-data="{
                activeSlide: 0,
                interval: null,
                startAutoSlide() {
                    this.interval = setInterval(() => {
                        const slider = this.$refs.slider;
                        if (slider) {
                            if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 10) {
                                slider.scrollTo({ left: 0, behavior: 'smooth' });
                            } else {
                                slider.scrollBy({ left: 300, behavior: 'smooth' });
                            }
                        }
                    }, 3000);
                },
                stopAutoSlide() { clearInterval(this.interval); }
            }" x-init="startAutoSlide()" @mouseenter="stopAutoSlide()" @mouseleave="startAutoSlide()" @touchstart="stopAutoSlide()" @touchend="startAutoSlide()">

          <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4">
            <div>
              <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2">Rekomendasi Pengajar</h2>
              <p class="text-gray-500 dark:text-gray-400 text-xs md:text-sm mt-1">
                Pengajar <strong class="text-green-600 dark:text-green-400">{{ auth()->user()->gender == 'L' ? 'Ikhwan' : 'Akhwat' }}</strong> terbaik yang sesuai dengan level <strong class="text-green-600 dark:text-green-400 border-b border-emerald-300 border-dashed pb-0.5">{{ explode(' (', auth()->user()->student_level ?? 'Pemula')[0] }}</strong> Anda.
              </p>
            </div>
          </div>

          {{-- Cek apakah ada data guru yang dikirim dari Controller --}}
          @if($rekomendasiGuru->isNotEmpty())

          {{-- JIKA ADA DATA: TAMPILKAN SLIDER --}}
          <div x-ref="slider" class="flex overflow-x-auto pb-8 gap-4 px-4 -mx-4 md:mx-0 md:px-0 snap-x snap-mandatory hide-scrollbar scroll-smooth">

            @foreach($rekomendasiGuru as $guru)
            <div class="relative flex-none w-72 md:w-80 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-[20px] overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col h-full group snap-center">

              {{-- Header Card: Foto & Badge --}}
              <div class="p-6 flex-grow flex flex-col">
                <div class="flex justify-between items-start mb-5">
                  {{-- Foto Profil --}}
                  <div class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-green-50 dark:bg-gray-700 flex items-center justify-center text-green-700 dark:text-green-400 font-bold text-2xl md:text-[20px] shadow-inner border border-green-100 dark:border-gray-600 overflow-hidden flex-shrink-0">
                    @if($guru->photo_url)
                    <img src="{{ $guru->photo_url }}" alt="{{ $guru->user->name }}" class="w-full h-full object-cover">
                    @else
                    {{ substr($guru->user->name ?? 'U', 0, 1) }}
                    @endif
                  </div>

                  {{-- Badge Metode --}}
                  <span class="px-2.5 py-1 text-[10px] font-bold uppercase rounded-xl border tracking-wide {{ $guru->method == 'online' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 border-blue-100 dark:border-blue-800' : 'bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 border-orange-100 dark:border-orange-800' }}">
                    {{ $guru->method }}
                  </span>
                </div>
                {{-- Info Nama & Bio --}}
                <div class="flex items-center gap-1.5 mb-0.5">
                  <h3 class="font-bold text-gray-900 dark:text-white text-base md:text-lg line-clamp-1 group-hover:text-green-600 transition-colors">{{ $guru->user->name ?? 'Nama Guru' }}</h3>
                  @if($guru->user->is_verified ?? false)
                  <img width="16" height="16" src="https://img.icons8.com/fluency/48/verified-account--v1.png" alt="verified" />
                  @endif
                </div>
                
                {{-- Tambahan Specialization --}}
                <p class="text-green-600 dark:text-green-400 text-[9px] md:text-[10px] font-bold uppercase tracking-wider mb-2 md:mb-3 line-clamp-1">
                  {{ $guru->specialization ?? 'Pengajar Al-Qur\'an' }}
                </p>
                <p class="text-gray-500 dark:text-gray-400 text-sm line-clamp-2 leading-relaxed opacity-90 mb-3">{{ Str::limit($guru->bio, 80) }}</p>

                {{-- Indikator Level Mengajar --}}
                <div class="mt-auto pt-2">
                  <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1.5">Program:</p>
                  <div class="flex flex-wrap gap-1.5">
                    @if($guru->teaching_levels && is_array($guru->teaching_levels))
                    @php
                    $allowedPrograms = ['iqra', 'tahsin', 'tahfidz', 'sanad', 'bahasa'];
                    $validLevels = array_filter($guru->teaching_levels, fn($l) => in_array($l, $allowedPrograms));
                    $validLevels = array_values($validLevels);
                    @endphp

                    @if(count($validLevels) > 0)
                    @foreach(array_slice($validLevels, 0, 2) as $level)
                    @php
                    $levelColor = match($level) {
                    'iqra' => 'bg-emerald-50 text-emerald-600 border-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800',
                    'tahsin' => 'bg-blue-50 text-blue-600 border-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
                    'tahfidz' => 'bg-amber-50 text-amber-600 border-amber-100 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800',
                    'sanad' => 'bg-purple-50 text-purple-600 border-purple-100 dark:bg-purple-900/30 dark:text-purple-400 dark:border-purple-800',
                    'bahasa' => 'bg-indigo-50 text-indigo-600 border-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-400 dark:border-indigo-800',
                    };

                    $levelLabel = match($level) {
                    'iqra' => 'Iqra',
                    'tahsin' => 'Tahsin',
                    'tahfidz' => 'Tahfidz',
                    'sanad' => 'Sanad',
                    'bahasa' => 'Bahasa',
                    };
                    @endphp
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded border {{ $levelColor }}">
                      {{ $levelLabel }}
                    </span>
                    @endforeach

                    @if(count($validLevels) > 2)
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded border bg-gray-50 text-gray-500 border-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700">
                      +{{ count($validLevels) - 2 }}
                    </span>
                    @endif
                    @else
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded border bg-gray-50 text-gray-400 border-gray-200 dark:bg-gray-800 dark:border-gray-700">Belum Ditentukan</span>
                    @endif
                    @else
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded border bg-gray-50 text-gray-400 border-gray-200 dark:bg-gray-800 dark:border-gray-700">Belum Ditentukan</span>
                    @endif
                  </div>
                </div>

              </div>

              {{-- Footer Card --}}
              <div class="p-5 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700 mt-auto">
                <div class="flex justify-between items-center mb-3">
                  <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Ketersediaan:</span>
                  @if($guru->is_full)
                  <span class="px-2 py-1 rounded bg-red-100 text-red-700 text-[10px] font-bold uppercase border border-red-200">Penuh</span>
                  @else
                  <span class="px-2 py-1 rounded bg-green-100 text-green-700 text-[10px] font-bold uppercase border border-green-200">Sisa {{ $guru->remaining_quota }} Santri</span>
                  @endif
                </div>
                <div class="grid grid-cols-2 gap-2">
                  <a href="{{ route('student.teachers.show', $guru->id) }}" class="py-2.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-center rounded-xl text-sm font-bold border border-gray-200 dark:border-gray-600 hover:bg-gray-50 transition">Detail</a>
                  @if(!$guru->is_full)
                  <a href="{{ route('booking.create', $guru->id) }}" class="py-2.5 bg-green-600 text-white text-center rounded-xl text-sm font-bold hover:bg-green-700 shadow-md shadow-green-200 dark:shadow-none transition">Daftar</a>
                  @else
                  <button disabled class="py-2.5 bg-gray-200 text-gray-400 text-center rounded-xl text-sm font-bold cursor-not-allowed">Tutup</button>
                  @endif
                </div>
              </div>
            </div>
            @endforeach

            {{-- Tombol Lihat Semua (Slider) --}}
            <div class="flex-none w-32 flex items-center justify-center snap-center">
              <a href="{{ route('student.teachers.index') }}" class="flex flex-col items-center gap-3 text-gray-400 hover:text-green-600 transition p-4 group">
                <div class="w-14 h-14 rounded-full bg-white dark:bg-gray-800 shadow-sm flex items-center justify-center border border-gray-100 dark:border-gray-700 group-hover:scale-110 transition-transform duration-300">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                  </svg>
                </div>
                <span class="text-xs font-bold text-center">Lihat<br>Semua</span>
              </a>
            </div>
          </div>

          @else

          {{-- JIKA DATA KOSONG: TAMPILKAN EMPTY STATE --}}
          <div class="bg-white dark:bg-gray-800 p-8 rounded-[20px] border border-dashed border-gray-200 dark:border-gray-700 text-center transition-colors duration-300">
            {{-- Icon Container --}}
            <div class="w-16 h-16 bg-emerald-50 dark:bg-emerald-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-emerald-500 dark:text-emerald-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
              </svg>
            </div>

            <h4 class="font-bold text-gray-900 dark:text-white mb-1">Pengajar Sedang Dialokasikan</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 max-w-sm mx-auto mb-6">
              Saat ini kuota pengajar <strong>{{ auth()->user()->gender == 'L' ? 'Ikhwan' : 'Akhwat' }}</strong> untuk level <strong>{{ explode(' (', auth()->user()->student_level ?? 'Anda')[0] }}</strong> sedang penuh atau dalam persiapan.
            </p>

            <a href="{{ route('student.teachers.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-lg shadow-emerald-600/20 transition-all hover:-translate-y-0.5">
              Lihat Seluruh Katalog Pengajar
            </a>
          </div>

          @endif
        </div>
      </div>

      {{-- [BARU] CONTENT 2: AL-QURAN (UI/UX yang Disempurnakan) --}}
      <div x-show="activeTab === 'quran'" x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0">

        <div class="bg-white dark:bg-[#121824] rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-gray-800/60 transition-colors">

          {{-- Banner Utama (Dinamis: Pengingat Markah vs Default) --}}
          <div class="bg-gradient-to-br from-emerald-600 to-teal-800 dark:from-emerald-800 dark:to-teal-900 rounded-[1.5rem] p-6 md:p-8 text-white relative overflow-hidden mb-8 group shadow-lg">

            {{-- Efek Ornamen Latar Belakang --}}
            <div class="absolute right-0 top-0 opacity-10 transition-transform duration-700 group-hover:scale-110 group-hover:-rotate-3 origin-top-right">
              <svg class="w-48 h-48 md:w-64 md:h-64 -mt-10 -mr-10" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z" />
              </svg>
            </div>

            {{-- Gradient overlay untuk tekstur --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>

            <div class="relative z-10">
              @if(isset($lastReadData) && $lastReadData)
              {{-- Jika ADA Markah --}}
              <div class="flex items-center gap-2 mb-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-yellow-400 text-emerald-900 text-[10px] md:text-xs font-extrabold uppercase tracking-wide shadow-sm">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                    <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0 1 11.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 0 1-1.085.67L12 18.089l-7.165 3.583A.75.75 0 0 1 3.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93Z" clip-rule="evenodd" />
                  </svg>
                  Sambung Bacaan
                </span>
              </div>
              <h3 class="text-2xl md:text-3xl font-bold mb-2 tracking-tight">Surah {{ $lastReadData['surat_nama'] }}</h3>
              <p class="text-emerald-100 text-sm md:text-base mb-6 font-medium">Terakhir ditandai pada ayat {{ $lastReadData['ayat'] }}.</p>

              <a href="{{ route('quran.show', $lastReadData['surat_nomor']) }}#ayat-{{ $lastReadData['ayat'] }}"
                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-emerald-700 font-bold rounded-xl hover:bg-yellow-50 hover:text-emerald-800 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"></path>
                </svg>
                Lanjutkan Membaca
              </a>

              @else
              {{-- Jika BELUM ADA Markah (Default) --}}
              <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-white border border-white/30 text-[10px] md:text-xs font-extrabold uppercase tracking-wide">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"></path>
                  </svg>
                  Al-Quran Digital
                </span>
              </div>
              <h3 class="text-2xl md:text-3xl font-bold mb-2 tracking-tight">Tilawah Harian</h3>
              <p class="text-emerald-100 text-sm md:text-base mb-6 font-medium">Mulai bacaan Al-Qur'an Anda hari ini untuk meraih keberkahan.</p>

              <a href="{{ route('quran.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-emerald-700 font-bold rounded-xl hover:bg-emerald-50 hover:text-emerald-800 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 w-full sm:w-auto">
                Mulai Membaca <span aria-hidden="true">→</span>
              </a>
              @endif
            </div>
          </div>

          {{-- Section Label Pintasan --}}
          <div class="mb-4 flex items-center justify-between">
            <h4 class="font-bold text-gray-800 dark:text-white text-sm md:text-base">Surah Pilihan</h4>
            <a href="{{ route('quran.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 flex items-center gap-1 group">
              Lihat Semua
              <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>

          {{-- Grid Pintasan Surat (Lebih Elegan) --}}
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Al-Kahfi --}}
            <a href="{{ route('quran.show', 18) }}" class="flex items-center justify-between p-4 md:p-5 rounded-2xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-[#1a2332] hover:border-emerald-500/50 hover:shadow-md transition-all duration-300 group">
              <div class="flex items-center gap-4">
                <div class="w-11 h-11 rounded-full bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-extrabold text-sm border border-emerald-100 dark:border-emerald-800/50 group-hover:scale-110 transition-transform">18</div>
                <div>
                  <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 transition-colors">Al-Kahfi</h4>
                  <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Sunnah Jumat</p>
                </div>
              </div>
              <div class="text-2xl font-arab text-gray-300 dark:text-gray-600 group-hover:text-emerald-500/50 transition-colors">الكهف</div>
            </a>

            {{-- Yasin --}}
            <a href="{{ route('quran.show', 36) }}" class="flex items-center justify-between p-4 md:p-5 rounded-2xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-[#1a2332] hover:border-blue-500/50 hover:shadow-md transition-all duration-300 group">
              <div class="flex items-center gap-4">
                <div class="w-11 h-11 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-extrabold text-sm border border-blue-100 dark:border-blue-800/50 group-hover:scale-110 transition-transform">36</div>
                <div>
                  <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors">Yasin</h4>
                  <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Harian</p>
                </div>
              </div>
              <div class="text-2xl font-arab text-gray-300 dark:text-gray-600 group-hover:text-blue-500/50 transition-colors">يس</div>
            </a>

            {{-- Al-Mulk --}}
            <a href="{{ route('quran.show', 67) }}" class="flex items-center justify-between p-4 md:p-5 rounded-2xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-[#1a2332] hover:border-amber-500/50 hover:shadow-md transition-all duration-300 group">
              <div class="flex items-center gap-4">
                <div class="w-11 h-11 rounded-full bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400 font-extrabold text-sm border border-amber-100 dark:border-amber-800/50 group-hover:scale-110 transition-transform">67</div>
                <div>
                  <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-amber-600 transition-colors">Al-Mulk</h4>
                  <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Sebelum Tidur</p>
                </div>
              </div>
              <div class="text-2xl font-arab text-gray-300 dark:text-gray-600 group-hover:text-amber-500/50 transition-colors">الملك</div>
            </a>
          </div>

        </div>
      </div>

      {{-- CONTENT 3: INFO BIAYA (Tetap Sama) --}}
      <div x-show="activeTab === 'biaya'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
        {{-- [Paste Kode Info Biaya Disini] --}}
        <div class="relative bg-white dark:bg-gray-800 rounded-[20px] p-6 md:p-8 shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden group hover:shadow-md transition-all duration-500">
          {{-- Isi sama seperti sebelumnya --}}
          <div class="absolute top-0 right-0 p-8 opacity-5 dark:opacity-10 transition-transform duration-700 group-hover:rotate-12 group-hover:scale-110">
            <svg class="w-32 h-32 md:w-64 md:h-64 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.35 0 .81.91 1.17 2.67 1.51 2.38.46 4.19 1.56 4.19 3.98 0 1.8-1.31 2.87-3.13 3.18z" />
            </svg>
          </div>

          <div class="relative z-10">
            <div class="mb-8">
              <h3 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2 mb-4">
                <span class="bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 p-2 rounded-xl">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </span>
                Ketentuan & Komitmen Infaq
              </h3>

              <div class="prose prose-sm dark:prose-invert text-gray-600 dark:text-gray-300 max-w-none">
                <p class="leading-relaxed mb-4 text-xs md:text-sm">
                  Demi keberlangsungan operasional dakwah dan kenyamanan proses belajar mengajar, kami menetapkan nilai infaq bulanan yang terjangkau. Seluruh dana infaq yang masuk dikelola secara amanah untuk keperluan berikut:
                </p>

                <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 list-none pl-0 mb-6 text-xs md:text-sm">
                  <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Kafalah (Mukafaah) Asatidz.</span>
                  </li>
                  <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Pengembangan kurikulum.</span>
                  </li>
                  <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Pemeliharaan sistem IT & Server.</span>
                  </li>
                  <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Program sosial & beasiswa.</span>
                  </li>
                </ul>

                <p class="text-xs text-gray-500 dark:text-gray-400 italic bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg border-l-4 border-blue-400">
                  "Harta tidak akan berkurang karena sedekah. Dan seorang hamba yang pemaaf pasti akan Allah tambahkan kewibawaan baginya." (HR. Muslim)
                </p>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="flex items-center gap-4 p-5 rounded-2xl border border-blue-100 dark:border-gray-700 bg-blue-50/50 dark:bg-gray-700/30 hover:bg-blue-50 dark:hover:bg-gray-700/50 hover:scale-[1.01] transition-all duration-300">
                <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-white dark:bg-gray-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shadow-sm flex-shrink-0">
                  <svg class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                  </svg>
                </div>
                <div>
                  <p class="text-[10px] md:text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-1">Program Online</p>
                  <p class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">Rp 100.000 <span class="text-xs font-normal text-gray-500 dark:text-gray-400">/bln</span></p>
                  <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 line-clamp-1">Belajar via Zoom/Gmeet, hemat waktu.</p>
                </div>
              </div>

              <div class="flex items-center gap-4 p-5 rounded-2xl border border-orange-100 dark:border-gray-700 bg-orange-50/50 dark:bg-gray-700/30 hover:bg-orange-50 dark:hover:bg-gray-700/50 hover:scale-[1.01] transition-all duration-300">
                <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-white dark:bg-gray-800 flex items-center justify-center text-orange-600 dark:text-orange-400 shadow-sm flex-shrink-0">
                  <svg class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                  </svg>
                </div>
                <div>
                  <p class="text-[10px] md:text-xs font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wider mb-1">Program Offline</p>
                  <p class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">Rp 150.000 <span class="text-xs font-normal text-gray-500 dark:text-gray-400">/bln</span></p>
                  <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 line-clamp-1">Guru datang ke rumah (Home Visit).</p>
                </div>
              </div>
            </div>

            <div class="mt-6 text-center">
              <p class="text-[10px] md:text-xs text-gray-400 dark:text-gray-500">
                *Tagihan akan muncul otomatis di dashboard setiap awal bulan. Pembayaran via transfer Bank.
              </p>
            </div>
          </div>
        </div>
      </div>

     {{-- CONTENT 4: MATERI BELAJAR --}}
      <div x-show="activeTab === 'materi'" x-cloak 
           x-data="{ 
               search: '', 
               filter: 'all',
               {{-- State untuk mengontrol guru mana yang sedang dibuka (null = tertutup semua) --}}
               openTeacher: null 
           }" 
           x-transition:enter="transition ease-out duration-300" 
           x-transition:enter-start="opacity-0 translate-y-2" 
           x-transition:enter-end="opacity-100 translate-y-0">

        <div class="mb-6 flex flex-col md:flex-row md:items-end justify-between gap-4">
          <div>
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2">Repository Materi</h2>
            <p class="text-gray-500 dark:text-gray-400 text-xs md:text-sm mt-1">Akses rekaman video, dokumen, slide, dan audio pembelajaran per pengajar.</p>
          </div>

          {{-- AREA SEARCH & FILTER (Hanya tampil jika ada materi) --}}
          @if($materials->isNotEmpty())
          <div class="flex flex-row gap-2 sm:gap-3 items-center">
            
            {{-- Kotak Pencarian --}}
            <div class="flex items-center flex-1 sm:w-64 h-10 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-3 focus-within:ring-2 focus-within:ring-green-500 focus-within:border-green-500 transition-all overflow-hidden shadow-sm">
              <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
              <input x-model="search" type="text" placeholder="Cari materi..." class="w-full h-full bg-transparent border-none outline-none focus:outline-none focus:ring-0 text-sm ml-2 text-gray-700 dark:text-white placeholder-gray-400 p-0 m-0">
            </div>
            
            {{-- Dropdown Filter Tipe --}}
            <select x-model="filter" class="flex-none w-[105px] sm:w-auto h-10 px-2 sm:px-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:text-white transition-all cursor-pointer outline-none shadow-sm">
              <option value="all">Semua</option>
              <option value="video">Video</option>
              <option value="document">PDF</option>
              <option value="audio">Audio</option>
              <option value="slide">Slide PPT</option> {{-- <--- TAMBAHAN OPSI SLIDE --}}
            </select>
          </div>
          @endif
        </div>

        {{-- ========================================================== --}}
        {{-- [PERBAIKAN LOGIKA] PRIORITAS BERDASARKAN ISI MATERI        --}}
        {{-- ========================================================== --}}

        {{-- KONDISI 1: JIKA MATERI TERSEDIA (PRIORITAS UTAMA MESKI JADWAL HABIS) --}}
        @if($materials->isNotEmpty())
        @php
            $completedMaterialIds = auth()->check() ? auth()->user()->completedMaterials()->pluck('study_materials.id')->toArray() : [];
            
            // MENGELOMPOKKAN MATERI BERDASARKAN GURU
            $groupedMaterials = $materials->groupBy(function($item) {
                return $item->teacherProfile && $item->teacherProfile->user 
                    ? $item->teacherProfile->user->name 
                    : 'Materi Umum';
            });
        @endphp

        <div class="space-y-4">
            @foreach($groupedMaterials as $teacherName => $group)
            @php 
                $slug = \Illuminate\Support\Str::slug($teacherName); 
            @endphp
            
            <div class="border border-gray-100 dark:border-gray-700 rounded-[20px] overflow-hidden bg-white dark:bg-gray-800 shadow-sm transition-all duration-300">
                
               {{-- HEADER GURU --}}
                <button @click="openTeacher === '{{ $slug }}' ? openTeacher = null : openTeacher = '{{ $slug }}'"
                        class="w-full flex items-center justify-between p-3 md:p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors cursor-pointer outline-none focus:outline-none">
                    
                    <div class="flex items-center gap-3 md:gap-4 text-left">
                        {{-- Ukuran kotak ikon --}}
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 flex items-center justify-center flex-shrink-0 shadow-sm border border-green-200 dark:border-green-800">
                            {{-- Ukuran SVG --}}
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        
                        <div>
                            {{-- [PERBAIKAN] Menghapus line-clamp-1 dan menambahkan flex-wrap --}}
                            <h3 class="text-sm md:text-base font-bold text-gray-800 dark:text-white flex flex-wrap items-center gap-1.5 leading-snug">
                                Kelas Bersama {{ $teacherName }}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-blue-500 hidden sm:block shrink-0">
                                  <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                </svg>
                            </h3>
                            <p class="text-[11px] md:text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ $group->count() }} Materi Tersedia
                            </p>
                        </div>
                    </div>

                    {{-- Ikon panah (chevron) --}}
                    <div class="text-gray-400 transition-transform duration-300 flex-shrink-0 ml-2" :class="openTeacher === '{{ $slug }}' ? 'rotate-180' : ''">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </button>

                {{-- ISI MATERI --}}
                <div x-show="openTeacher === '{{ $slug }}'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 -translate-y-4 max-h-0"
                     x-transition:enter-end="opacity-100 translate-y-0 max-h-[5000px]"
                     class="p-4 md:p-6 bg-gray-50 dark:bg-gray-900 border-t border-gray-100 dark:border-gray-700"
                     style="display: none;">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        @foreach($group as $material)
                        <div x-data="{ 
                                isCompleted: {{ in_array($material->id, $completedMaterialIds) ? 'true' : 'false' }},
                                isProcessing: false,
                                markCompleted() {
                                    if(!this.isCompleted) {
                                        this.isProcessing = true;
                                        this.isCompleted = true;
                                        fetch('{{ route('student.material.toggle') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            },
                                            body: JSON.stringify({ material_id: {{ $material->id }} })
                                        })
                                        .finally(() => { this.isProcessing = false; });
                                    }
                                }
                             }" 
                             x-show="(filter === 'all' || filter === '{{ $material->type }}') && '{{ strtolower(addslashes($material->title)) }}'.includes(search.toLowerCase())"
                             x-transition:enter="transition ease-out duration-300"
                             class="relative bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300"
                             :class="isCompleted ? 'border-green-300 dark:border-green-700 bg-green-50 dark:bg-gray-800' : ''">

                            <div class="flex items-start gap-4">
                                {{-- WARNA DAN ICON BERDASARKAN TIPE MATERI --}}
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors shadow-sm border border-gray-100 dark:border-gray-700"
                                     :class="isCompleted ? 'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-400' : '{{ $material->type === 'video' ? 'bg-red-50 text-red-500 dark:bg-red-900/50' : ($material->type === 'audio' ? 'bg-orange-100 text-orange-600 dark:bg-orange-900/50' : ($material->type === 'slide' ? 'bg-purple-50 text-purple-500 dark:bg-purple-900/50' : 'bg-blue-50 text-blue-500 dark:bg-blue-900/50')) }}'">
                                    @if($material->type === 'video')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @elseif($material->type === 'audio')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                                    @elseif($material->type === 'slide')
                                        {{-- Icon untuk Presentasi PPT --}}
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="mb-2 flex flex-wrap items-center gap-2">
                                        @if($material->program_type === 'online')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300 border border-blue-200 dark:border-blue-700">Online</span>
                                        @elseif($material->program_type === 'offline')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-orange-100 text-orange-600 dark:bg-orange-900 dark:text-orange-300 border border-orange-200 dark:border-orange-700">Offline</span>
                                        @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">Umum</span>
                                        @endif

                                        @if($material->group_name)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-indigo-100 text-indigo-600 dark:bg-indigo-900 dark:text-gray-300 border border-indigo-200 dark:border-gray-600">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            {{ $material->group_name }}
                                        </span>
                                        @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                                            Lintas Kelas
                                        </span>
                                        @endif

                                        <span class="text-[10px] font-medium text-gray-400 dark:text-gray-500 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ \Carbon\Carbon::parse($material->created_at)->isoFormat('D MMM YYYY') }}
                                        </span>
                                    </div>

                                    <h4 class="font-bold text-gray-800 dark:text-white line-clamp-1" title="{{ $material->title }}">{{ $material->title }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $material->description ?? 'Tidak ada deskripsi.' }}</p>
                                    
                                    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                                        <div class="flex-1 min-w-[200px]">
                                            @if($material->type === 'video')
                                            <a href="{{ $material->video_url }}" target="_blank" @click="markCompleted()" class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 bg-red-50 hover:bg-red-100 dark:bg-red-900/50 dark:hover:bg-red-900 px-3 py-1.5 rounded-lg border border-red-200 dark:border-red-800 shadow-sm transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                                                <span>Tonton Video</span>
                                            </a>
                                            @elseif($material->type === 'audio')
                                            <audio controls class="w-full h-10 outline-none rounded-lg" @play="markCompleted()" preload="metadata">
                                                <source src="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url($material->file_path) }}">
                                                Browser Anda tidak mendukung pemutar audio.
                                            </audio>
                                            @elseif($material->type === 'slide')
                                            {{-- TOMBOL BUKA SLIDE --}}
                                            @php
                                                $slideUrl = urlencode(\Illuminate\Support\Facades\Storage::disk('s3')->url($material->file_path));
                                            @endphp
                                            <a href="https://view.officeapps.live.com/op/view.aspx?src={{ $slideUrl }}" target="_blank" @click="markCompleted()" class="inline-flex items-center gap-1.5 text-xs font-bold text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 bg-purple-50 hover:bg-purple-100 dark:bg-purple-900/50 dark:hover:bg-purple-900 px-3 py-1.5 rounded-lg border border-purple-200 dark:border-purple-800 shadow-sm transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                                                <span>Lihat Slide</span>
                                            </a>
                                            @else
                                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url($material->file_path) }}" target="_blank" @click="markCompleted()" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/50 dark:hover:bg-blue-900 px-3 py-1.5 rounded-lg border border-blue-200 dark:border-blue-800 shadow-sm transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                <span>Buka PDF</span>
                                            </a>
                                            @endif
                                        </div>

                                        <div x-show="isCompleted" 
                                             x-transition:enter="transition ease-out duration-300"
                                             x-transition:enter-start="opacity-0 scale-90"
                                             x-transition:enter-end="opacity-100 scale-100"
                                             class="flex-shrink-0 inline-flex items-center gap-1.5 text-[10px] font-bold px-2.5 py-1.5 rounded-lg bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300 border border-green-200 dark:border-green-800 shadow-sm select-none" style="display: none;">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            <span>Selesai</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            @endforeach
        </div>

        {{-- KONDISI 2: JIKA TIDAK ADA MATERI TAPI ADA JADWAL AKTIF --}}
        @elseif(isset($activeSchedules) && $activeSchedules->count() > 0)
        <div class="bg-white dark:bg-gray-800 p-8 rounded-[20px] border border-dashed border-gray-200 dark:border-gray-700 text-center transition-colors duration-300 shadow-sm">
          <div class="w-16 h-16 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400 dark:text-gray-500">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h4.375L12 6h7.5A2.25 2.25 0 0 1 21.75 8.25v1.5m-16.5 0h16.5" />
            </svg>
          </div>
          <h4 class="font-bold text-gray-900 dark:text-white">Belum Ada Materi</h4>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Materi akan muncul sesuai program dan guru Anda.</p>
        </div>

        {{-- KONDISI 3: JIKA TIDAK ADA JADWAL DAN TIDAK ADA MATERI --}}
        @else
        <div class="bg-white dark:bg-gray-800 p-8 rounded-[20px] border border-dashed border-gray-200 dark:border-gray-700 text-center transition-colors duration-300 shadow-sm">
          <div class="w-16 h-16 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400 dark:text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
            </svg>
          </div>
          <h4 class="font-bold text-gray-900 dark:text-white">Akses Terkunci</h4>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Materi pembelajaran akan tersedia setelah Anda memiliki jadwal kelas yang aktif.</p>
        </div>
        @endif

      </div>

    
      </div>