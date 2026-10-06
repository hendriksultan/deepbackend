<x-student-layout>
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-2 md:pt-6 pb-12">
    <div class=" hidden md:block mb-6 md:mb-8">
      {{-- PERBAIKAN: Menggunakan route 'student.dashboard' --}}
      <a href="{{ route('student.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 md:px-5 md:py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-[10px] md:text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 hover:border-green-200 dark:hover:border-green-900 transition-all duration-300 shadow-sm group">
        <svg class="w-3 h-3 md:w-4 md:h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali
      </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-[20px] shadow-xl shadow-gray-200/50 dark:shadow-none overflow-hidden border border-gray-100 dark:border-gray-700">

      {{-- Header Profile (Cover Background) --}}
      <div class="h-48 md:h-64 bg-gradient-to-r from-green-600 to-emerald-800 relative">
        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/arabesque.png')]"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
      </div>

      <div class="px-6 md:px-10 pb-10">
        <div class="relative flex flex-col md:flex-row items-center md:items-end -mt-20 md:-mt-24 mb-8 gap-6 text-center md:text-left">

          {{-- Foto Profil / Avatar --}}
          <div class="relative group">
            <div class="w-32 h-32 md:w-48 md:h-48 rounded-[20px] bg-white dark:bg-gray-800 p-2 shadow-2xl z-10 rotate-3 group-hover:rotate-0 transition-transform duration-300">
              <div class="w-full h-full bg-green-50 dark:bg-gray-900 rounded-[20px] flex items-center justify-center overflow-hidden border border-green-100 dark:border-gray-700">
                @if($guru->photo_url)
                <img src="{{ $guru->photo_url }}"
                  alt="{{ $guru->user->name }}"
                  class="w-full h-full object-cover">
                @else
                <span class="text-2xl font-bold text-green-700 dark:text-green-400">
                  {{ substr($guru->user->name, 0, 1) }}
                </span>
                @endif
              </div>
            </div>
            @if($guru->user->is_verified)
            <div class="absolute -bottom-2 -right-2 bg-white dark:bg-gray-800 p-1.5 rounded-full shadow-md" title="Verified Teacher">
              <img width="24" height="24" src="https://img.icons8.com/fluency/48/verified-account--v1.png" alt="verified" />
            </div>
            @endif
          </div>

          {{-- Nama & Info Utama (Sudah Disesuaikan) --}}
          <div class="flex-1 pt-12 md:pt-16 pb-2 md:pb-6">
            <h1 class="text-lg md:text-2xl font-extrabold text-gray-900 dark:text-white mb-1.5 leading-snug md:leading-relaxed flex flex-wrap items-center justify-center md:justify-start gap-x-2 gap-y-1">
              {{ $guru->user->name }}
            </h1>
            <p class="text-green-600 dark:text-green-400 font-bold text-[11px] md:text-base tracking-wide uppercase opacity-90 text-center md:text-left">
              {{ $guru->specialization }}
            </p>
          </div>

          {{-- Tombol Booking Besar & Status Kuota --}}
          <div class="w-full md:w-72 mt-4 md:mt-0 flex flex-col gap-3">

            {{-- Indikator Kuota --}}
            <div class="flex items-center justify-between md:justify-end gap-2 text-xs md:text-sm font-medium">
              <span class="text-gray-500 dark:text-gray-400">Kuota Tersedia:</span>
              @if($guru->is_full)
              <span class="text-red-600 bg-red-100 px-2 py-0.5 rounded text-[10px] md:text-xs font-bold">PENUH</span>
              @else
              <span class="text-green-600 bg-green-100 px-2 py-0.5 rounded text-[10px] md:text-xs font-bold">{{ $guru->remaining_quota }} Kursi</span>
              @endif
            </div>

            @if($guru->is_full)
            <button disabled class="w-full py-3.5 bg-gray-200 dark:bg-gray-700 text-gray-400 dark:text-gray-500 text-sm md:text-base font-bold rounded-2xl cursor-not-allowed text-center shadow-inner">
              Pendaftaran Ditutup
            </button>
            @else
            <a href="{{ route('booking.create', $guru->id) }}" class="flex items-center justify-center gap-2 w-full py-3.5 bg-green-600 hover:bg-green-700 text-white text-sm md:text-base font-bold rounded-2xl shadow-lg shadow-green-600/30 hover:shadow-green-600/50 hover:-translate-y-1 transition-all duration-300 text-center group">
              {{-- Icon User Plus --}}
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:scale-110">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
              </svg>
              <span>Daftar Sekarang</span>
            </a>
            @endif
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">

          {{-- Kolom Kiri: Sidebar Info --}}
          <div class="space-y-6">

            {{-- Kotak Info Kelas --}}
            <div class="bg-gray-50 dark:bg-gray-700/30 p-5 md:p-6 rounded-[20px] border border-gray-100 dark:border-gray-700/50">
              <h3 class="text-xs md:text-sm font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-5 md:mb-6">Detail Kelas</h3>

              <div class="space-y-4 md:space-y-5">
                {{-- Metode --}}
                <div class="flex items-start gap-3 md:gap-4">
                  <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-white dark:bg-gray-800 text-blue-500 flex items-center justify-center shadow-sm border border-gray-100 dark:border-gray-700 flex-shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-[10px] md:text-xs text-gray-500 dark:text-gray-400 font-medium mb-0.5">Metode Belajar</p>
                    <p class="font-bold text-gray-800 dark:text-white capitalize text-base md:text-lg">{{ $guru->method }}</p>
                  </div>
                </div>

                {{-- Program --}}
                <div class="flex items-start gap-3 md:gap-4">
                  <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-white dark:bg-gray-800 text-purple-500 flex items-center justify-center shadow-sm border border-gray-100 dark:border-gray-700 flex-shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-[10px] md:text-xs text-gray-500 dark:text-gray-400 font-medium mb-0.5">Kategori</p>
                    <p class="font-bold text-gray-800 dark:text-white text-base md:text-lg capitalize">
                      @if(!empty($guru->program_type))
                      {{ str_replace('_', ' ', $guru->program_type) }}
                      @elseif(!empty($guru->specialization))
                      {{ str_replace('_', ' ', $guru->specialization) }}
                      @else
                      Umum
                      @endif
                    </p>
                  </div>
                </div>

                {{-- Program Spesialisasi --}}
                <div class="flex items-start gap-3 md:gap-4">
                  <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-white dark:bg-gray-800 text-emerald-500 flex items-center justify-center shadow-sm border border-gray-100 dark:border-gray-700 flex-shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                  </div>

                  <div class="flex-1 min-w-0">
                    <p class="text-[10px] md:text-xs text-gray-500 dark:text-gray-400 font-medium mb-1.5">Program Spesialisasi</p>

                    <div class="flex flex-wrap gap-1.5">
                      @if($guru->teaching_levels && is_array($guru->teaching_levels))
                      @foreach($guru->teaching_levels as $level)
                      @php
                      $levelColor = match($level) {
                      'iqra' => 'bg-emerald-50 text-emerald-600 border-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800',
                      'tahsin' => 'bg-blue-50 text-blue-600 border-blue-200 dark:bg-blue-900/20 dark:text-blue-300 dark:border-blue-800',
                      'tahfidz' => 'bg-amber-50 text-amber-600 border-amber-200 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800',
                      'sanad' => 'bg-purple-50 text-purple-600 border-purple-200 dark:bg-purple-900/20 dark:text-purple-400 dark:border-purple-800',
                      'bahasa' => 'bg-indigo-50 text-indigo-600 border-indigo-200 dark:bg-indigo-900/20 dark:text-indigo-400 dark:border-indigo-800',
                      default => 'bg-gray-50 text-gray-600 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600',
                      };

                      $levelLabel = match($level) {
                      'iqra' => 'Iqra',
                      'tahsin' => 'Tahsin',
                      'tahfidz' => 'Tahfidz',
                      'sanad' => 'Sanad',
                      'bahasa' => 'Bahasa Arab',
                      default => ucfirst(str_replace('_', ' ', $level)),
                      };
                      @endphp

                      <span class="inline-flex w-fit px-2 py-0.5 text-[9px] md:text-[11px] font-bold rounded-md border {{ $levelColor }} whitespace-nowrap">
                        {{ $levelLabel }}
                      </span>
                      @endforeach
                      @else
                      <span class="inline-flex w-fit px-2 py-0.5 text-[9px] md:text-[11px] font-medium rounded-md border bg-gray-50 text-gray-500 border-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700 whitespace-nowrap">
                        Belum Ditentukan
                      </span>
                      @endif
                    </div>
                  </div>
                </div>

              </div>
            </div>

            {{-- Jadwal Mengajar --}}
            <div class="bg-white dark:bg-gray-800 p-5 md:p-6 rounded-[20px] border border-gray-100 dark:border-gray-700 shadow-sm">
              <h3 class="text-xs md:text-sm font-bold text-gray-800 dark:text-white uppercase tracking-widest mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Jadwal Mengajar
              </h3>

              @php
              $uniqueSchedules = $guru->schedules
              ->sortBy('start')
              ->unique(function ($item) {
              return $item->start->format('Y-m-d H:i') . $item->title;
              });
              @endphp

              @if($uniqueSchedules->count() > 0)
              <div class="space-y-3">
                @foreach($uniqueSchedules as $jadwal)
                <div class="flex items-center gap-3 p-2.5 md:p-3 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-100 dark:border-gray-700/50">
                  {{-- Tanggal --}}
                  <div class="bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-400 p-2 rounded-lg font-bold text-center min-w-[45px] md:min-w-[50px]">
                    <div class="text-[9px] md:text-[10px] uppercase tracking-wide">{{ $jadwal->start->format('M') }}</div>
                    <div class="text-base md:text-lg leading-none mt-0.5">{{ $jadwal->start->format('d') }}</div>
                  </div>

                  {{-- Detail --}}
                  <div>
                    <h4 class="font-bold text-gray-800 dark:text-white text-xs md:text-sm line-clamp-1">{{ $jadwal->title }}</h4>
                    <p class="text-[10px] md:text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-0.5">
                      <svg class="w-3 h-3 md:w-3.5 md:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                      {{ $jadwal->start->format('H:i') }} - {{ $jadwal->end->format('H:i') }}
                    </p>
                  </div>
                </div>
                @endforeach
              </div>
              @else
              {{-- Tampilan Kosong --}}
              <div class="text-center py-5 md:py-6 border-2 border-dashed border-gray-100 dark:border-gray-700 rounded-xl">
                <p class="text-gray-400 text-xs md:text-sm italic">Belum ada jadwal tersedia.</p>
              </div>
              @endif
            </div>

          </div>

          {{-- Kolom Kanan: Bio Lengkap --}}
          <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 p-6 md:p-8 rounded-[20px] shadow-sm border border-gray-100 dark:border-gray-700 min-h-[300px] md:min-h-[400px]">
              <h3 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white mb-5 md:mb-6 flex items-center gap-2">
                <span class="w-1.5 h-6 md:w-2 md:h-8 bg-green-500 rounded-full inline-block"></span>
                Tentang Pengajar
              </h3>

              <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed md:leading-loose text-sm md:text-base">
                @if(!empty($guru->bio))
                {!! nl2br(e($guru->bio)) !!}
                @else
                <div class="flex flex-col items-center justify-center py-8 md:py-10 opacity-50">
                  <svg class="w-12 h-12 md:w-16 md:h-16 text-gray-300 mb-3 md:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <p class="italic text-xs md:text-sm">Belum ada deskripsi lengkap.</p>
                </div>
                @endif
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</x-student-layout>