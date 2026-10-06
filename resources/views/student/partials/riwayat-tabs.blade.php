@php
          // =========================================================================
          // [PERBAIKAN] 1. AMBIL SEMUA DATA PROGRAM SISWA SAAT INI DARI TABEL BOOKING
          // =========================================================================
          $activePrograms = \App\Models\Booking::where('user_id', Auth::id())
              ->whereIn('status', ['active', 'approved'])
              ->pluck('program_type')
              ->map(fn($item) => strtolower($item))
              ->toArray();

          // Fungsi helper agar pencarian kata kunci lebih mudah dan mendukung multi-kelas
          $hasProgram = function($keyword) use ($activePrograms) {
              foreach ($activePrograms as $prog) {
                  if (str_contains($prog, $keyword)) return true;
              }
              return false;
          };

          // 2. TENTUKAN TAB DEFAULT SECARA DINAMIS
          $defaultTab = 'ujian'; // Fallback tab
          if ($hasProgram('tahfidz') || empty($activePrograms)) {
              $defaultTab = 'hafalan';
          } elseif ($hasProgram('tahsin') || $hasProgram('sanad')) {
              $defaultTab = 'tahsin';
          } elseif ($hasProgram('iqra')) {
              $defaultTab = 'iqra';
          } elseif ($hasProgram('bahasa')) {
              $defaultTab = 'bahasa';
          }
        @endphp

{{-- 3. MASUKKAN DEFAULT TAB KE ALPINE.JS --}}
        {{-- PERBAIKAN: Menambahkan relative z-0 agar tidak tumpang tindih dengan fixed element --}}
        <div class="lg:col-span-2 relative z-0" x-data="{ activeTab: '{{ $defaultTab }}' }">

          <div class="bg-white dark:bg-gray-800 rounded-[20px] shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden min-h-[400px]">

            {{-- HEADER CARD DENGAN TAB NAVIGASI --}}
            <div class="px-4 md:px-8 py-4 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">

              {{-- Container Tab --}}
              <div class="flex items-center gap-1 bg-gray-100 dark:bg-gray-700/50 p-1 rounded-xl w-full sm:w-auto overflow-x-auto [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">

                {{-- TAB 1: HAFALAN --}}
                @if($hasProgram('tahfidz') || empty($activePrograms))
                <button @click="activeTab = 'hafalan'"
                  :class="activeTab === 'hafalan' ? 'bg-white dark:bg-gray-600 text-emerald-600 dark:text-emerald-300 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                  class="shrink-0 whitespace-nowrap px-3 md:px-4 py-2 rounded-lg text-sm font-bold transition-all duration-200 focus:outline-none flex items-center gap-2 group">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:scale-110">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                  </svg>
                  <span>Hafalan</span>
                </button>
                @endif

                {{-- TAB 2: TAHSIN --}}
                @if($hasProgram('tahsin') || $hasProgram('sanad') || empty($activePrograms))
                <button @click="activeTab = 'tahsin'"
                  :class="activeTab === 'tahsin' ? 'bg-white dark:bg-gray-600 text-emerald-600 dark:text-emerald-300 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                  class="shrink-0 whitespace-nowrap px-3 md:px-4 py-2 rounded-lg text-sm font-bold transition-all duration-200 focus:outline-none flex items-center gap-2 group">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:scale-110">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                  </svg>
                  <span>Tahsin</span>
                </button>
                @endif

                {{-- TAB 3: IQRA --}}
                @if($hasProgram('iqra') || empty($activePrograms))
                <button @click="activeTab = 'iqra'"
                  :class="activeTab === 'iqra' ? 'bg-white dark:bg-gray-600 text-emerald-600 dark:text-emerald-300 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                  class="shrink-0 whitespace-nowrap px-3 md:px-4 py-2 rounded-lg text-sm font-bold transition-all duration-200 focus:outline-none flex items-center gap-2 group">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:scale-110">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                  </svg>
                  <span>Iqra</span>
                </button>
                @endif

                {{-- TAB 5: BAHASA ARAB --}}
                @if($hasProgram('bahasa') || empty($activePrograms))
                <button @click="activeTab = 'bahasa'"
                  :class="activeTab === 'bahasa' ? 'bg-white dark:bg-gray-600 text-emerald-600 dark:text-emerald-300 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                  class="shrink-0 whitespace-nowrap px-3 md:px-4 py-2 rounded-lg text-sm font-bold transition-all duration-200 focus:outline-none flex items-center gap-2 group">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:scale-110">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                  </svg>
                  <span>B. Arab</span>
                </button>
                @endif

                {{-- TAB 4: UJIAN (Selalu Muncul) --}}
                <button @click="activeTab = 'ujian'"
                  :class="activeTab === 'ujian' ? 'bg-white dark:bg-gray-600 text-emerald-600 dark:text-emerald-300 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                  class="shrink-0 whitespace-nowrap px-3 md:px-4 py-2 rounded-lg text-sm font-bold transition-all duration-200 focus:outline-none flex items-center gap-2 group">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:scale-110">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                  </svg>
                  <span>Ujian</span>
                </button>

                {{-- TAB 6: TUGAS --}}
                @if(isset($availableTugas) && $availableTugas->count() > 0)
                <button @click="activeTab = 'tugas'"
                  :class="activeTab === 'tugas' ? 'bg-white dark:bg-gray-600 text-blue-600 dark:text-blue-300 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                  class="shrink-0 whitespace-nowrap px-3 md:px-4 py-2 rounded-lg text-sm font-bold transition-all duration-200 focus:outline-none flex items-center gap-2 group">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:scale-110">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                  </svg>
                  <span>Tugas <span class="ml-1 bg-red-100 text-red-600 px-1.5 py-0.5 rounded-full text-[10px]">{{ $availableTugas->count() }}</span></span>
                </button>
                @endif

              </div>
            </div>

           {{-- KONTEN TAB 1: HAFALAN (Hanya Bulan Ini) --}}
            <div x-show="activeTab === 'hafalan'" x-transition:enter="transition ease-out duration-300">
              
              @php
                  // [LOGIKA FILTER] Hanya ambil data yang bulannya sama dengan bulan sekarang
                  $riwayatSetoranBulanIni = $riwayatSetoran->filter(function($item) {
                      $tanggal = \Carbon\Carbon::parse($item->tanggal);
                      return $tanggal->isCurrentMonth(); 
                  });
              @endphp

              @if($riwayatSetoranBulanIni->isEmpty())
              <div class="py-20 text-center px-4 flex flex-col items-center justify-center h-full">
                <div class="w-16 h-16 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400 dark:text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                  </svg>
                </div>
                <h4 class="text-gray-900 dark:text-white font-bold text-sm">Belum Ada Setoran di Bulan Ini</h4>
                <p class="text-gray-500 text-xs mt-1">Data setoran bulan lalu otomatis diarsipkan oleh sistem.</p>
              </div>
              @else
              
              <div class="overflow-x-auto">
                {{-- [PERBAIKAN] Header Tabel (Transparan di Mode Gelap) --}}
                <div class="px-6 py-4 bg-green-50/30 dark:bg-transparent border-b border-green-100 dark:border-gray-700">
                    <h5 class="text-xs font-bold text-green-700 dark:text-green-400 uppercase tracking-widest flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        Riwayat Setoran: {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    </h5>
                </div>

                <table class="w-full text-left min-w-[600px]">
                  <thead>
                    {{-- [PERBAIKAN] Baris Judul Kolom (Tanpa opacity di Mode Gelap) --}}
                    <tr class="bg-gray-50/30 dark:bg-transparent text-gray-500 dark:text-gray-400 text-[10px] uppercase tracking-wider border-b border-gray-100 dark:border-gray-700">
                      <th class="px-6 py-4 font-semibold">Tanggal & Pengajar</th>
                      <th class="px-6 py-4 font-semibold">Surah & Ayat</th>
                      <th class="px-6 py-4 font-semibold text-center">Predikat</th>
                      <th class="px-6 py-4 font-semibold">Catatan Ustadz</th>
                    </tr>
                  </thead>
                  
                  {{-- [PERBAIKAN] Garis pembatas (Solid Mode Gelap) --}}
                  <tbody class="divide-y divide-gray-50 dark:divide-gray-700 text-sm">
                    @foreach($riwayatSetoranBulanIni as $setoran)
                    {{-- [PERBAIKAN] Efek Hover --}}
                    <tr class="hover:bg-green-50/50 dark:hover:bg-gray-800 transition-colors">
                      <td class="px-6 py-4">
                        <div class="flex flex-col">
                          <span class="text-gray-800 dark:text-gray-300 font-bold">{{ \Carbon\Carbon::parse($setoran->tanggal)->translatedFormat('d M Y') }}</span>
                          <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $setoran->booking->teacherProfile->user->name ?? 'Admin' }}
                          </span>
                        </div>
                      </td>
                      <td class="px-6 py-4">
                        <div class="flex flex-col">
                          <span class="font-bold text-gray-800 dark:text-gray-200">{{ $setoran->surah }}</span>
                          <span class="text-[11px] text-gray-400">Ayat {{ $setoran->ayat_awal }} - {{ $setoran->ayat_akhir }}</span>
                        </div>
                      </td>
                      <td class="px-6 py-4 text-center">
                        {{-- [PERBAIKAN] Warna lencana (badge) solid untuk Mode Gelap --}}
                        @php
                        $colorHafalan = strtolower($setoran->nilai) == 'lancar' 
                            ? 'bg-green-100 text-green-700 border-green-200 dark:bg-green-900 dark:text-green-300 dark:border-green-800' 
                            : 'bg-yellow-100 text-yellow-700 border-yellow-200 dark:bg-yellow-900 dark:text-yellow-300 dark:border-yellow-800';
                        @endphp
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold border {{ $colorHafalan }}">
                          {{ ucfirst($setoran->nilai) }}
                        </span>
                      </td>
                      <td class="px-6 py-4">
                        <div x-data="{ expanded: false }" class="min-w-[180px] max-w-[250px]">
                          <div x-show="!expanded">
                            <p class="text-gray-500 text-xs italic inline">"{{ Str::limit($setoran->catatan, 35) }}"</p>
                            @if(strlen($setoran->catatan) > 35)
                            <button @click="expanded = true" class="text-green-500 font-bold text-xs ml-1 hover:underline focus:outline-none">Lihat</button>
                            @endif
                          </div>
                          @if(strlen($setoran->catatan) > 35)
                          {{-- [PERBAIKAN] Latar belakang kotak detail catatan solid Mode Gelap --}}
                          <div x-show="expanded" x-cloak class="mt-1 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700 cursor-pointer" @click="expanded = false">
                            <p class="text-gray-700 dark:text-gray-300 text-xs italic">"{{ $setoran->catatan }}"</p>
                            <div class="mt-2 text-right"><span class="text-[10px] text-green-500 font-bold uppercase">Tutup</span></div>
                          </div>
                          @endif
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              @endif
            </div>

            {{-- KONTEN TAB 2: TAHSIN (Hanya Bulan Ini) --}}
            <div x-show="activeTab === 'tahsin'" x-cloak x-transition:enter="transition ease-out duration-300">
              
              @php
                  // [LOGIKA FILTER] Hanya ambil data yang bulannya sama dengan bulan sekarang
                  $riwayatTahsinBulanIni = $riwayatTahsin->filter(function($item) {
                      $tanggal = \Carbon\Carbon::parse($item->tanggal);
                      return $tanggal->isCurrentMonth(); 
                  });
              @endphp

              @if($riwayatTahsinBulanIni->isEmpty())
              <div class="py-20 text-center px-4 flex flex-col items-center justify-center h-full">
                {{-- [PERBAIKAN] Background icon Mode Gelap solid --}}
                <div class="w-16 h-16 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400 dark:text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                  </svg>
                </div>
                <h4 class="text-gray-900 dark:text-white font-bold text-sm">Belum Ada Data Tahsin di Bulan Ini</h4>
                <p class="text-gray-500 text-xs mt-1">Data tahsin bulan lalu otomatis diarsipkan oleh sistem.</p>
              </div>
              @else
              
              <div class="overflow-x-auto">
                {{-- [PERBAIKAN] Header Tabel (Transparan di Mode Gelap dengan Aksen Biru) --}}
                <div class="px-6 py-4 bg-blue-50/30 dark:bg-transparent border-b border-blue-100 dark:border-gray-700">
                    <h5 class="text-xs font-bold text-blue-700 dark:text-blue-400 uppercase tracking-widest flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        Riwayat Tahsin: {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    </h5>
                </div>

                <table class="w-full text-left min-w-[600px]">
                  <thead>
                    {{-- [PERBAIKAN] Baris Judul Kolom (Transparan di Mode Gelap) --}}
                    <tr class="bg-gray-50/30 dark:bg-transparent text-gray-500 dark:text-gray-400 text-[10px] uppercase tracking-wider border-b border-gray-100 dark:border-gray-700">
                      <th class="px-6 py-4 font-semibold">Tanggal & Pengajar</th>
                      <th class="px-6 py-4 font-semibold">Materi / Jilid</th>
                      <th class="px-6 py-4 font-semibold text-center">Nilai</th>
                      <th class="px-6 py-4 font-semibold">Koreksi Tajwid</th>
                    </tr>
                  </thead>
                  
                  {{-- [PERBAIKAN] Garis pembatas (Solid Mode Gelap) --}}
                  <tbody class="divide-y divide-gray-50 dark:divide-gray-700 text-sm">
                    @foreach($riwayatTahsinBulanIni as $tahsin)
                    {{-- [PERBAIKAN] Efek Hover Aksen Biru --}}
                    <tr class="hover:bg-blue-50/50 dark:hover:bg-gray-800 transition-colors">
                      <td class="px-6 py-4">
                        <div class="flex flex-col">
                          <span class="text-gray-800 dark:text-gray-300 font-bold">{{ \Carbon\Carbon::parse($tahsin->tanggal)->translatedFormat('d M Y') }}</span>
                          <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $tahsin->booking->teacherProfile->user->name ?? 'Admin' }}
                          </span>
                        </div>
                      </td>
                      <td class="px-6 py-4">
                        <div class="flex flex-col">
                          <span class="font-bold text-gray-800 dark:text-gray-200">{{ $tahsin->jilid }}</span>
                          <span class="text-[11px] text-gray-400">
                            @if($tahsin->jilid == 'Al-Quran')
                            {{ $tahsin->surah }} : {{ $tahsin->ayat }}
                            @else
                            Halaman {{ $tahsin->halaman }}
                            @endif
                          </span>
                        </div>
                      </td>
                      <td class="px-6 py-4 text-center">
                        {{-- [PERBAIKAN] Warna Lencana solid untuk Mode Gelap --}}
                        @php
                        $colorClass = match ($tahsin->nilai) {
                        'A', 'Mumtaz' => 'bg-green-100 text-green-700 border-green-200 dark:bg-green-900 dark:text-green-300 dark:border-green-800',
                        'B', 'Jayyid Jiddan', 'Jayyid' => 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900 dark:text-blue-300 dark:border-blue-800',
                        'C', 'Maqbul' => 'bg-yellow-100 text-yellow-700 border-yellow-200 dark:bg-yellow-900 dark:text-yellow-300 dark:border-yellow-800',
                        'D' => 'bg-red-100 text-red-700 border-red-200 dark:bg-red-900 dark:text-red-300 dark:border-red-800',
                        default => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
                        };
                        @endphp
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold border {{ $colorClass }}">
                          {{ $tahsin->nilai }}
                        </span>
                      </td>
                      <td class="px-6 py-4">
                        <div x-data="{ expanded: false }" class="min-w-[180px] max-w-[250px]">
                          <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-red-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div class="flex-1">
                              <div x-show="!expanded">
                                <p class="text-gray-600 dark:text-gray-400 text-xs leading-relaxed inline">{{ Str::limit($tahsin->catatan_tajwid, 40) }}</p>
                                @if(strlen($tahsin->catatan_tajwid) > 40)
                                <button @click="expanded = true" class="text-blue-500 font-bold text-xs ml-1 hover:underline focus:outline-none">...baca</button>
                                @endif
                              </div>
                              @if(strlen($tahsin->catatan_tajwid) > 40)
                              {{-- [PERBAIKAN] Latar kotak detail disesuaikan dengan Dark Mode (abu gelap alih-alih merah terang) --}}
                              <div x-show="expanded" x-cloak class="mt-2 p-2 bg-red-50 dark:bg-gray-800 rounded-lg border border-red-100 dark:border-gray-700 cursor-pointer" @click="expanded = false">
                                <p class="text-gray-800 dark:text-gray-300 text-xs leading-relaxed">{{ $tahsin->catatan_tajwid }}</p>
                                <div class="mt-2 text-right"><span class="text-[10px] text-blue-500 font-bold uppercase">Sembunyikan</span></div>
                              </div>
                              @endif
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              @endif
            </div>

           {{-- KONTEN TAB 3: IQRA (Hanya Bulan Ini) --}}
            <div x-show="activeTab === 'iqra'" x-cloak x-transition:enter="transition ease-out duration-300">
              
              @php
                  // [LOGIKA FILTER] Hanya ambil data yang bulannya sama dengan bulan sekarang
                  $riwayatIqraBulanIni = $riwayatIqra->filter(function($item) {
                      $tanggal = \Carbon\Carbon::parse($item->tanggal);
                      return $tanggal->isCurrentMonth(); 
                  });
              @endphp

              @if($riwayatIqraBulanIni->isEmpty())
              <div class="py-20 text-center px-4 flex flex-col items-center justify-center h-full">
                <div class="w-16 h-16 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400 dark:text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                  </svg>
                </div>
                <h4 class="text-gray-900 dark:text-white font-bold text-sm">Belum Ada Evaluasi di Bulan Ini</h4>
                <p class="text-gray-500 text-xs mt-1">Data evaluasi bulan lalu otomatis diarsipkan oleh sistem.</p>
              </div>
              @else
              
              <div class="overflow-x-auto">
                <div class="px-6 py-4 bg-emerald-50/30 dark:bg-transparent border-b border-emerald-100 dark:border-gray-700">
                    <h5 class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        Riwayat Evaluasi: {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    </h5>
                </div>
                
                <table class="w-full text-left min-w-[600px]">
                  <thead>
                    <tr class="bg-gray-50/30 dark:bg-transparent text-gray-500 dark:text-gray-400 text-[10px] uppercase tracking-wider border-b border-gray-100 dark:border-gray-700">
                      <th class="px-6 py-4 font-semibold">Tanggal & Pengajar</th>
                      <th class="px-6 py-4 font-semibold">Jilid & Halaman</th>
                      <th class="px-6 py-4 font-semibold text-center">Nilai</th>
                      <th class="px-6 py-4 font-semibold">Catatan Guru</th>
                    </tr>
                  </thead>
                  
                  {{-- [PERBAIKAN KUNCI] Mengganti dark:divide-gray-700/50 menjadi dark:divide-gray-700 solid --}}
                  <tbody class="divide-y divide-gray-50 dark:divide-gray-700 text-sm">
                    @foreach($riwayatIqraBulanIni as $iqra)
                    <tr class="hover:bg-emerald-50/50 dark:hover:bg-gray-800 transition-colors">
                      <td class="px-6 py-4">
                        <div class="flex flex-col">
                          <span class="text-gray-800 dark:text-gray-300 font-bold">{{ \Carbon\Carbon::parse($iqra->tanggal)->translatedFormat('d M Y') }}</span>
                          <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1">
                            {{ $iqra->booking->teacherProfile->user->name ?? 'Admin' }}
                          </span>
                        </div>
                      </td>
                      <td class="px-6 py-4">
                        <div class="flex flex-col">
                          <span class="font-bold text-gray-800 dark:text-gray-200">Jilid {{ $iqra->jilid }}</span>
                          <span class="text-[11px] text-gray-400">Halaman {{ $iqra->halaman }}</span>
                        </div>
                      </td>
                      <td class="px-6 py-4 text-center">
                        @php
                        // [PERBAIKAN KUNCI] Menghapus opacity pada warna badge nilai
                        $colorIqra = match ($iqra->nilai) {
                        'A' => 'bg-green-100 text-green-700 border-green-200 dark:bg-green-900 dark:text-green-300 dark:border-green-800',
                        'B' => 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900 dark:text-blue-300 dark:border-blue-800',
                        'C' => 'bg-yellow-100 text-yellow-700 border-yellow-200 dark:bg-yellow-900 dark:text-yellow-300 dark:border-yellow-800',
                        'D' => 'bg-red-100 text-red-700 border-red-200 dark:bg-red-900 dark:text-red-300 dark:border-red-800',
                        default => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
                        };
                        @endphp
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold border {{ $colorIqra }}">
                          {{ $iqra->nilai }}
                        </span>
                      </td>
                      <td class="px-6 py-4">
                        <div x-data="{ expanded: false }" class="min-w-[180px] max-w-[250px]">
                          <div x-show="!expanded">
                            <p class="text-gray-500 text-xs italic inline">"{{ Str::limit($iqra->catatan_guru, 35) }}"</p>
                            @if(strlen($iqra->catatan_guru) > 35)
                            <button @click="expanded = true" class="text-emerald-500 font-bold text-xs ml-1 hover:underline focus:outline-none">Lihat</button>
                            @endif
                          </div>
                          @if(strlen($iqra->catatan_guru) > 35)
                          {{-- [PERBAIKAN KUNCI] Menghapus opacity pada card catatan (dark:bg-gray-800) --}}
                          <div x-show="expanded" x-cloak class="mt-1 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700 cursor-pointer" @click="expanded = false">
                            <p class="text-gray-700 dark:text-gray-300 text-xs italic">"{{ $iqra->catatan_guru }}"</p>
                            <div class="mt-2 text-right"><span class="text-[10px] text-emerald-500 font-bold uppercase">Tutup</span></div>
                          </div>
                          @endif
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              @endif
            </div>

           {{-- KONTEN TAB 5: BAHASA ARAB --}}
            <div x-show="activeTab === 'bahasa'" x-cloak x-transition:enter="transition ease-out duration-300">
              
              {{-- [LOGIKA AMAN] Filter langsung disisipkan ke dalam fungsi pengecekan bawaan asli --}}
              @if(!isset($riwayatBahasa) || $riwayatBahasa->filter(function($item) { return \Carbon\Carbon::parse($item->tanggal)->isCurrentMonth(); })->isEmpty())
              <div class="py-20 text-center px-4 flex flex-col items-center justify-center h-full">
                {{-- Background icon Solid Dark Mode --}}
                <div class="w-16 h-16 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400 dark:text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                  </svg>
                </div>
                <h4 class="text-gray-900 dark:text-white font-bold text-sm">Belum Ada Evaluasi di Bulan Ini</h4>
                <p class="text-gray-500 text-xs mt-1">Data evaluasi bulan lalu otomatis diarsipkan oleh sistem.</p>
              </div>
              @else
              
              <div class="overflow-x-auto">
                <div class="px-6 py-4 bg-indigo-50/30 dark:bg-transparent border-b border-indigo-100 dark:border-gray-700">
                    <h5 class="text-xs font-bold text-indigo-700 dark:text-indigo-400 uppercase tracking-widest flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                        </span>
                        Riwayat Bahasa Arab: {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    </h5>
                </div>

                <table class="w-full text-left min-w-[600px]">
                  <thead>
                    <tr class="bg-gray-50/30 dark:bg-transparent text-gray-500 dark:text-gray-400 text-[10px] uppercase tracking-wider border-b border-gray-100 dark:border-gray-700">
                      <th class="px-6 py-4 font-semibold">Tanggal & Pengajar</th>
                      <th class="px-6 py-4 font-semibold">Topik Materi</th>
                      <th class="px-6 py-4 font-semibold text-center">Detail Nilai</th>
                      <th class="px-6 py-4 font-semibold">Catatan Guru</th>
                    </tr>
                  </thead>
                  
                  <tbody class="divide-y divide-gray-50 dark:divide-gray-700 text-sm">
                    {{-- [LOGIKA AMAN] Filter juga disisipkan langsung ke dalam Looping bawaan asli --}}
                    @foreach($riwayatBahasa->filter(function($item) { return \Carbon\Carbon::parse($item->tanggal)->isCurrentMonth(); }) as $bahasa)
                    <tr class="hover:bg-indigo-50/30 dark:hover:bg-gray-800 transition-colors">
                      <td class="px-6 py-4">
                        <div class="flex flex-col">
                          {{-- Kode Asli --}}
                          <span class="text-gray-800 dark:text-gray-300 font-bold">{{ \Carbon\Carbon::parse($bahasa->tanggal)->format('d M Y') }}</span>
                          <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $bahasa->booking->teacherProfile->user->name ?? 'Ustadz' }}
                          </span>
                        </div>
                      </td>
                      <td class="px-6 py-4">
                        {{-- Kode Asli --}}
                        <span class="font-bold text-gray-800 dark:text-gray-200">{{ $bahasa->topik_materi }}</span>
                      </td>
                      <td class="px-6 py-4">
                        <div class="flex flex-col gap-1 text-xs">
                          <div class="flex justify-between gap-4">
                            <span class="text-gray-500 dark:text-gray-400">Kosakata:</span>
                            {{-- Kode Asli + penambahan warna dark: --}}
                            <span class="font-bold {{ $bahasa->nilai_kosakata == 'A' ? 'text-green-600 dark:text-green-400' : 'text-indigo-600 dark:text-indigo-400' }}">{{ $bahasa->nilai_kosakata ?? '-' }}</span>
                          </div>
                          <div class="flex justify-between gap-4">
                            <span class="text-gray-500 dark:text-gray-400">Tata Bahasa:</span>
                            <span class="font-bold {{ $bahasa->nilai_tata_bahasa == 'A' ? 'text-green-600 dark:text-green-400' : 'text-indigo-600 dark:text-indigo-400' }}">{{ $bahasa->nilai_tata_bahasa ?? '-' }}</span>
                          </div>
                          <div class="flex justify-between gap-4">
                            <span class="text-gray-500 dark:text-gray-400">Percakapan:</span>
                            <span class="font-bold {{ $bahasa->nilai_percakapan == 'A' ? 'text-green-600 dark:text-green-400' : 'text-indigo-600 dark:text-indigo-400' }}">{{ $bahasa->nilai_percakapan ?? '-' }}</span>
                          </div>
                        </div>
                      </td>
                      <td class="px-6 py-4">
                        <div x-data="{ expanded: false }" class="min-w-[180px] max-w-[250px]">
                          <div x-show="!expanded">
                            {{-- Logika Str::limit dan strlen kembali menggunakan bawaan asli 100% --}}
                            <p class="text-gray-500 text-xs italic inline">"{{ Str::limit($bahasa->catatan_guru, 35) }}"</p>
                            @if(strlen($bahasa->catatan_guru) > 35)
                            <button @click="expanded = true" class="text-indigo-500 font-bold text-xs ml-1 hover:underline focus:outline-none">Lihat</button>
                            @endif
                          </div>
                          @if(strlen($bahasa->catatan_guru) > 35)
                          {{-- Background Solid Dark Mode untuk catatan --}}
                          <div x-show="expanded" x-cloak class="mt-1 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700 cursor-pointer" @click="expanded = false">
                            <p class="text-gray-700 dark:text-gray-300 text-xs italic">"{{ $bahasa->catatan_guru }}"</p>
                            <div class="mt-2 text-right"><span class="text-[10px] text-indigo-500 font-bold uppercase">Tutup</span></div>
                          </div>
                          @endif
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              @endif
            </div>

            {{-- KONTEN TAB 4: UJIAN / KUIS --}}
            <div x-show="activeTab === 'ujian'" x-cloak x-transition:enter="transition ease-out duration-300">

              @if(!isset($activeSchedules) || $activeSchedules->count() == 0)
              <div class="py-20 text-center px-4 flex flex-col items-center justify-center h-full">
                <div class="w-16 h-16 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mb-4 text-gray-400 dark:text-gray-500">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                  </svg>
                </div>
                <h4 class="text-gray-900 dark:text-white font-bold text-sm">Belum Ada Jadwal Kelas</h4>
                <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">Ujian baru akan tersedia setelah Anda memiliki jadwal kelas yang dikonfirmasi oleh Admin atau Ustadz.</p>
              </div>

              @elseif($availableExams->isEmpty())
              <div class="py-20 text-center px-4 flex flex-col items-center justify-center h-full">
                <div class="w-16 h-16 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mb-4">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-emerald-500 dark:text-emerald-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                  </svg>
                </div>
                <h4 class="text-gray-900 dark:text-white font-bold text-sm">Belum Ada Ujian</h4>
                <p class="text-xs text-gray-500 mt-1">Daftar ujian atau kuis dari pengajar akan muncul di sini.</p>
              </div>

              @else
              <div class="grid grid-cols-1 gap-4 p-6">
                @foreach($availableExams as $exam)
                @php
                $score = $myAttempts[$exam->id] ?? null;
                $isDone = $score !== null;
                @endphp

                <div class="border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 p-5 rounded-xl flex flex-col md:flex-row items-center justify-between gap-4 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition duration-200">
                  <div class="flex items-start gap-4 w-full md:w-auto">
                    <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-300 font-bold text-lg shrink-0">?</div>
                    <div>
                      <h4 class="text-base font-bold text-gray-800 dark:text-white line-clamp-1" title="{{ $exam->title }}">
                        {{ $exam->title }}
                      </h4>

                      <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5 flex flex-wrap gap-3">
                        <span class="flex items-center gap-1 bg-gray-50 dark:bg-gray-700/50 px-2 py-0.5 rounded-md">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 text-green-600 dark:text-green-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                          </svg>
                          {{ $exam->duration_minutes }} Menit
                        </span>

                        <span class="flex items-center gap-1 bg-gray-50 dark:bg-gray-700/50 px-2 py-0.5 rounded-md">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 text-green-600 dark:text-green-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                          </svg>
                          {{ $exam->questions->count() }} Soal
                        </span>

                        <span class="flex items-center gap-1 bg-gray-50 dark:bg-gray-700/50 px-2 py-0.5 rounded-md">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 text-green-600 dark:text-green-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                          </svg>
                          {{ $exam->teacherProfile->user->name ?? 'Admin' }}
                        </span>
                      </p>
                    </div>
                  </div>

                  <div class="w-full md:w-auto flex justify-end">
                    @if($isDone)
                    <div class="text-center bg-green-50 dark:bg-green-900/20 px-4 py-2 rounded-xl border border-green-100 dark:border-green-800">
                      <span class="text-[10px] font-bold text-green-600 dark:text-green-400 uppercase tracking-wide">Nilai Anda</span>
                      <div class="text-2xl font-extrabold text-green-700 dark:text-green-300 leading-none mt-1">{{ $score }}</div>
                    </div>
                    @else
                    <a href="{{ route('student.exam.show', $exam->id) }}"
                      onclick="event.preventDefault(); 
                      const url = this.getAttribute('href');
                      Swal.fire({
                          title: 'Siap Mengerjakan?',
                          text: 'Waktu berjalan setelah klik Mulai.',
                          icon: 'question',
                          width: 400,
                          padding: '1rem',
                          showCancelButton: true,
                          confirmButtonColor: '#10b981',
                          cancelButtonColor: '#6b7280',
                          confirmButtonText: 'Ya, Mulai!',
                          cancelButtonText: 'Batal',
                          customClass: {
                              title: 'text-lg font-bold',
                              htmlContainer: 'text-xs',
                              confirmButton: 'text-xs px-3 py-1',
                              cancelButton: 'text-xs px-3 py-1'
                          },
                          background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#fff',
                          color: document.documentElement.classList.contains('dark') ? '#fff' : '#000'
                      }).then((result) => {
                          if (result.isConfirmed) {
                              window.location.href = url;
                          }
                      });"
                      class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-green-200 dark:shadow-none transition transform hover:-translate-y-0.5 w-full md:w-auto">
                      Mulai Kerjakan
                    </a>
                    @endif
                  </div>
                </div>
                @endforeach
              </div>
              @endif

            </div>

            {{-- ========================================================= --}}
            {{-- [BARU] KONTEN TAB 6: TUGAS (Hanya Muncul Jika Ada Data) --}}
            {{-- ========================================================= --}}
            @if(isset($availableTugas) && $availableTugas->count() > 0)
            <div x-show="activeTab === 'tugas'" x-cloak x-transition:enter="transition ease-out duration-300">
              <div class="grid grid-cols-1 gap-4 p-6">
                @foreach($availableTugas as $tugas)
                
                {{-- Deteksi Status Keterlambatan --}}
                @php
                  $isLate = \Carbon\Carbon::now()->isAfter($tugas->deadline);
                  
                  // Cek apakah santri sudah mengumpulkan tugas ini
                  $hasSubmitted = \App\Models\TaskSubmission::where('task_id', $tugas->id)
                      ->where('user_id', Auth::id())
                      ->exists();
                @endphp

                {{-- PERBAIKAN: Menyesuaikan Border & Background agar menyatu dengan tema Dark/Light LMS --}}
                <div class="border border-gray-100 dark:border-gray-700/50 bg-white dark:bg-gray-800 p-5 rounded-xl flex flex-col md:flex-row items-center justify-between gap-4 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition duration-200">
                  
                  <div class="flex items-start gap-4 w-full md:w-auto">
                    {{-- Ikon Bulat Kotak --}}
                    <div class="w-12 h-12 rounded-xl {{ $isLate && !$hasSubmitted ? 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400' : 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' }} flex items-center justify-center shrink-0">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                      <h4 class="text-base font-bold text-gray-800 dark:text-white line-clamp-1" title="{{ $tugas->title }}">{{ $tugas->title }}</h4>
                      <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ Str::limit($tugas->description, 80) }}</p>
                      
                      <div class="flex items-center gap-3 mt-2">
                          <span class="text-[11px] font-medium px-2 py-0.5 rounded-md flex items-center gap-1 {{ $isLate && !$hasSubmitted ? 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400 border border-red-100 dark:border-red-900/30' : 'bg-gray-50 text-gray-600 dark:bg-gray-700/50 dark:text-gray-400 border border-gray-100 dark:border-gray-600' }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Tenggat: {{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y, H:i') }}
                          </span>
                          <span class="text-[11px] text-gray-500 dark:text-gray-400 flex items-center gap-1">
                              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path></svg>
                              Oleh: {{ $tugas->teacherProfile->user->name ?? 'Pengajar' }}
                          </span>
                      </div>
                    </div>
                  </div>

                  <div class="w-full md:w-auto flex justify-end shrink-0">
                    <a href="{{ route('student.task.show', $tugas->id) }}" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 font-bold text-sm rounded-xl shadow-sm transition transform hover:-translate-y-0.5 w-full md:w-auto {{ $hasSubmitted ? 'bg-green-50 hover:bg-green-100 text-green-700 dark:bg-green-900/20 dark:text-green-400 dark:hover:bg-green-900/40 border border-green-200 dark:border-green-800' : 'bg-blue-600 hover:bg-blue-700 text-white shadow-blue-200 dark:shadow-none' }}">
                      {{ $hasSubmitted ? 'Lihat Tugas' : 'Kumpulkan Tugas' }}
                    </a>
                  </div>

                </div>
                @endforeach
              </div>
            </div>
            @endif

          </div>
        </div>