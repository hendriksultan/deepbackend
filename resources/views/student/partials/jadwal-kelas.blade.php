{{-- 2. JADWAL KELAS SAYA (ACCORDION STYLE WITH INNER PAGINATION) --}}
    <div id="jadwal-saya" class="mb-12 scroll-mt-32">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h3 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2 flex-wrap">
            {{-- Icon Calendar Days --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 md:w-8 md:h-8 text-green-600 dark:text-green-400">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
            </svg>
            Jadwal Kelas Saya
            
            {{-- Logika Pemisah Hitungan Aktif dan Selesai --}}
            @php
                $jumlahAktif = 0;
                $jumlahSelesai = 0;

                if(isset($activeSchedules)) {
                    $jumlahAktif = $activeSchedules->filter(function($jadwal) {
                        $end = \Carbon\Carbon::parse($jadwal->end);
                        return $jadwal->status !== 'completed' && !$end->isPast();
                    })->count();

                    $jumlahSelesai = $activeSchedules->filter(function($jadwal) {
                        $end = \Carbon\Carbon::parse($jadwal->end);
                        return $jadwal->status === 'completed' || $end->isPast();
                    })->count();
                }
            @endphp

            <div class="flex items-center gap-2 mt-1 md:mt-0">
                @if($jumlahAktif > 0)
                  <span class="bg-green-100 text-green-700 text-xs font-extrabold px-2.5 py-0.5 rounded-full border border-green-200 shadow-sm transform -translate-y-1">
                    {{ $jumlahAktif }} Aktif
                  </span>
                @endif
                @if($jumlahSelesai > 0)
                  <span class="bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 text-xs font-extrabold px-2.5 py-0.5 rounded-full border border-gray-200 dark:border-gray-600 shadow-sm transform -translate-y-1">
                    {{ $jumlahSelesai }} Selesai
                  </span>
                @endif
            </div>
            
          </h3>
          <p class="text-gray-500 dark:text-gray-400 text-xs md:text-sm mt-1">Jadwal belajar bulan ini yang telah ditentukan oleh Admin.</p>
        </div>
      </div>

      {{-- FILTER & GROUPING JADWAL --}}
      @php
        $groupedSchedules = [];
        if(isset($activeSchedules)) {
            $filteredSchedules = $activeSchedules->filter(function($jadwal) {
                $end = \Carbon\Carbon::parse($jadwal->end);
                // Hilang 10 jam setelah jadwal berakhir
                if (\Carbon\Carbon::now()->greaterThan($end->copy()->addHours(10))) {
                    return false; 
                }
                return true; 
            })->values();

            // PENGELOMPOKAN BERDASARKAN PENGAJAR
            if ($filteredSchedules->count() > 0) {
                $groups = $filteredSchedules->groupBy(function($item) {
                    return $item->teacherProfile->user->name ?? 'Asatidz Pengajar';
                });
                
                $idx = 0;
                foreach($groups as $teacherName => $schedules) {
                    $firstSchedule = $schedules->first();
                    $teacherPhoto = $firstSchedule->teacherProfile->photo_url ?? null;
                    
                    $groupedSchedules[] = [
                        'index' => $idx++,
                        'teacher_name' => $teacherName,
                        'teacher_photo' => $teacherPhoto,
                        'schedules' => $schedules->values() // Re-index array untuk Alpine
                    ];
                }
            }
        }
      @endphp

      @if(count($groupedSchedules) > 0)
        
        <div class="flex flex-col gap-6">
          @foreach($groupedSchedules as $group)
          
          {{-- ======================================================== --}}
          {{-- ACCORDION WRAPPER (Per Pengajar) --}}
          {{-- ======================================================== --}}
          {{-- [PERBAIKAN] ALPINE.JS DILETAKKAN DI SINI UNTUK PAGINATION INTERNAL --}}
          <div x-data="{ 
                  expanded: true,
                  currentPage: 1,
                  itemsPerPage: 4, // Menampilkan 4 kartu per halaman
                  get totalPages() {
                      return Math.ceil({{ $group['schedules']->count() }} / this.itemsPerPage);
                  }
               }" 
               class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
              
              {{-- TOMBOL HEADER ACCORDION --}}
              <button @click="expanded = !expanded" 
                      class="w-full flex items-center justify-between p-3 md:p-4 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none"
                      :class="expanded ? 'border-b border-gray-200 dark:border-gray-700' : ''">
                  
                  <div class="flex items-center gap-3 md:gap-4 text-left">
                      <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-white dark:bg-gray-900 flex items-center justify-center text-base font-bold text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-600 overflow-hidden shrink-0 shadow-sm">
                          @if($group['teacher_photo'])
                              <img src="{{ $group['teacher_photo'] }}" alt="{{ $group['teacher_name'] }}" class="w-full h-full object-cover">
                          @else
                              {{ substr($group['teacher_name'], 0, 1) }}
                          @endif
                      </div>
                      <div>
                          <h4 class="text-sm md:text-base font-bold text-gray-900 dark:text-white flex flex-wrap items-center gap-1.5 leading-snug">
                              Kelas Bersama {{ $group['teacher_name'] }}
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-blue-500 hidden sm:block shrink-0">
                                  <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                              </svg>
                          </h4>
                          
                          @php
                              // Menghitung total keseluruhan jadwal bulan ini untuk guru terkait (tanpa terpengaruh filter hide 10 jam)
                              $totalJadwalBulanIni = isset($activeSchedules) ? $activeSchedules->filter(function($j) use ($group) {
                                  return ($j->teacherProfile->user->name ?? 'Asatidz Pengajar') === $group['teacher_name'];
                              })->count() : $group['schedules']->count();
                          @endphp
                          
                          <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-0.5">Total {{ $totalJadwalBulanIni }} Jadwal Bulan Ini</p>
                      </div>
                  </div>

                  <div class="p-1.5 md:p-2 rounded-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 shrink-0">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" 
                           class="w-4 h-4 md:w-5 md:h-5 transition-transform duration-300"
                           :class="expanded ? 'rotate-180' : ''">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                      </svg>
                  </div>
              </button>

              {{-- ISI ACCORDION (KARTU JADWAL) --}}
              <div x-show="expanded" x-collapse>
                  <div class="p-4 md:p-6 bg-white dark:bg-gray-900/50">
                      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                          
                          @foreach($group['schedules'] as $index => $jadwal)
                          @php
                          $now = \Carbon\Carbon::now();
                          $start = \Carbon\Carbon::parse($jadwal->start);
                          $end = \Carbon\Carbon::parse($jadwal->end);
                          
                          $canStartClass = $now->greaterThanOrEqualTo($start->copy()->subMinutes(20));

                          if ($jadwal->status === 'completed' || $end->isPast()) {
                              $status = 'completed';
                              $statusLabel = 'Selesai';
                              $statusColor = 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400 border border-gray-200 dark:border-gray-600';
                          } elseif ($now->between($start, $end)) {
                              $status = 'live';
                              $statusLabel = '🔴 Sedang Berlangsung';
                              $statusColor = 'bg-red-50 text-red-600 animate-pulse dark:bg-red-900/20 dark:text-red-400 border border-red-100 dark:border-red-900';
                          } else {
                              $status = 'upcoming';
                              $statusLabel = 'Akan Datang';
                              $statusColor = 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300 border border-blue-100 dark:border-blue-900';
                          }

                          $googleCalendarLink = "https://www.google.com/calendar/render?action=TEMPLATE&text=" . urlencode($jadwal->title) . "&dates=" . $start->format('Ymd\THis') . "/" . $end->format('Ymd\THis') . "&details=" . urlencode("Kelas bersama " . ($jadwal->teacherProfile->user->name ?? 'Ustadz')) . "&location=" . urlencode($jadwal->booking->method == 'online' ? 'Online Meeting' : ($jadwal->booking->student_address ?? '-')) . "&sf=true&output=xml";
                          
                          $jumlahSantri = 1; 
                          if (!empty($jadwal->booking->group_name)) {
                              $jumlahSantri = \App\Models\Booking::where('group_name', $jadwal->booking->group_name)
                                                  ->where('teacher_profile_id', $jadwal->booking->teacher_profile_id)
                                                  ->where('status', 'active') 
                                                  ->count();
                          }
                          @endphp

                          {{-- KARTU JADWAL INDIVIDU DENGAN X-SHOW UNTUK PAGINATION --}}
                          <div x-show="(currentPage - 1) * itemsPerPage <= {{ $index }} && {{ $index }} < currentPage * itemsPerPage"
                               x-transition:enter="transition ease-out duration-300"
                               x-transition:enter-start="opacity-0 scale-95"
                               x-transition:enter-end="opacity-100 scale-100"
                               style="display: none;"
                               class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md hover:border-green-300 dark:hover:border-green-600 transition-all duration-300 flex flex-col h-full group relative">

                            {{-- STATUS & CALENDAR ICON --}}
                            <div class="flex justify-between items-start mb-4">
                              <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $statusColor }}">
                                {{ $statusLabel }}
                              </span>

                              @if($status !== 'completed')
                              <a href="{{ $googleCalendarLink }}" target="_blank" class="text-gray-400 hover:text-blue-500 dark:hover:text-blue-400 transition bg-gray-50 dark:bg-gray-700 hover:bg-blue-50 dark:hover:bg-gray-600 p-1.5 rounded-md" title="Simpan ke Google Calendar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                              </a>
                              @endif
                            </div>

                            {{-- JUDUL & TANGGAL --}}
                            <div class="mb-4">
                              <div class="flex items-start justify-between gap-3 mb-2">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white leading-tight line-clamp-2" title="{{ $jadwal->title }}">
                                  {{ $jadwal->title }}
                                </h4>
                                
                                <div class="shrink-0 px-2 py-1 rounded bg-indigo-50 dark:bg-indigo-900/40 border border-indigo-100 dark:border-indigo-800/60 text-[10px] font-bold text-indigo-600 dark:text-indigo-300 uppercase flex items-center gap-1 mt-0.5" title="Grup: {{ $jadwal->booking->group_name ?? 'Private' }}">
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                    <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                  </svg>
                                  {{ $jumlahSantri }} <span class="hidden sm:inline">Peserta</span>
                                </div>
                              </div>

                              <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg border border-gray-100 dark:border-gray-700/60">
                                  <p class="text-sm font-medium text-gray-600 dark:text-gray-300 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600 dark:text-green-400 shrink-0">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                    </svg>
                                    {{ $start->translatedFormat('l, d M Y') }}
                                  </p>
                                  <p class="text-sm font-medium text-gray-600 dark:text-gray-300 flex items-center gap-2 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600 dark:text-green-400 shrink-0">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    {{ $start->format('H:i') }} - {{ $end->format('H:i') }} WIB
                                  </p>
                              </div>
                            </div>

                            {{-- INFO: METODE & LOKASI --}}
                            <div class="mb-5 pb-4 border-b border-gray-100 dark:border-gray-700 mt-auto">
                              <div class="flex items-start gap-2">
                                  <div class="px-2.5 py-1 rounded bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-[10px] font-bold text-gray-600 dark:text-gray-300 uppercase shrink-0 mt-0.5">
                                    {{ $jadwal->booking->method == 'online' ? 'ONLINE' : 'OFFLINE' }}
                                  </div>
                                  {{-- [PERBAIKAN] Jika teks alamat panjang, batasi 2 baris agar rapi, buang truncate --}}
                                  <div class="text-xs text-gray-500 dark:text-gray-400 leading-tight line-clamp-2" title="{{ $jadwal->booking->student_address ?? 'Lokasi ditentukan' }}">
                                      {{ $jadwal->booking->method == 'online' ? 'Via Virtual Meeting' : ($jadwal->booking->student_address ?? 'Lokasi ditentukan') }}
                                  </div>
                              </div>
                            </div>

                            {{-- FOOTER: TOMBOL AKSI --}}
                            <div class="mt-2">
                              @if($jadwal->booking->method == 'online')
                                @if($jadwal->meeting_link)
                                    @if($canStartClass)
                                        <a href="{{ route('student.jadwal.join', $jadwal->id) }}" target="_blank" 
                                           onclick="setTimeout(() => { window.location.reload(); }, 1500);"
                                           class="flex items-center justify-center gap-2 w-full py-2.5 {{ $status === 'completed' ? 'bg-green-600 hover:bg-green-700 shadow-green-200' : 'bg-blue-600 hover:bg-blue-700 shadow-blue-200' }} text-white rounded-xl text-xs font-bold transition shadow-lg dark:shadow-none hover:-translate-y-0.5 transform">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $status === 'completed' ? 'Masuk Kembali' : 'Mulai Belajar' }}
                                        </a>
                                    @else
                                        {{-- Tombol DISABLED (Belum waktunya) --}}
                                        <button disabled title="Link akan aktif 20 menit sebelum kelas dimulai" class="w-full py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-center rounded-xl text-xs font-bold cursor-not-allowed border border-gray-200 dark:border-gray-600 flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                            Belum Waktunya (Aktif H-20)
                                        </button>
                                    @endif
                                @else
                                <button disabled class="w-full py-2.5 bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400 rounded-xl text-xs font-bold border border-yellow-100 dark:border-yellow-800 cursor-wait flex items-center justify-center gap-2">
                                  <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                  </svg>
                                  Menunggu Link...
                                </button>
                                @endif
                              @else
                                {{-- TOMBOL OFFLINE --}}
                                <button disabled class="w-full py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-center rounded-xl text-xs font-bold border border-gray-200 dark:border-gray-600 flex items-center justify-center gap-2">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                  </svg>
                                  Belajar Tatap Muka
                                </button>
                              @endif
                            </div>
                          </div>
                          @endforeach
                      </div>
                      
                      {{-- [PERBAIKAN] KONTROL PAGINATION INTERNAL (Di dalam Accordion) --}}
                      <div x-show="totalPages > 1" class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between" style="display: none;">
                          <p class="text-xs text-gray-500 dark:text-gray-400">
                              Menampilkan hal <span x-text="currentPage" class="font-bold text-gray-700 dark:text-gray-300"></span> dari <span x-text="totalPages"></span>
                          </p>
                          <div class="flex gap-2">
                              <button @click="currentPage--" :disabled="currentPage === 1" 
                                      class="p-1.5 rounded-md border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-30 disabled:cursor-not-allowed transition-colors">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                  </svg>
                              </button>
                              <button @click="currentPage++" :disabled="currentPage === totalPages"
                                      class="p-1.5 rounded-md border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-30 disabled:cursor-not-allowed transition-colors">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                  </svg>
                              </button>
                          </div>
                      </div>

                  </div>
              </div>
          </div>
          @endforeach
        </div>

      @else
      {{-- EMPTY STATE --}}
      <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700 text-center">
        <div class="w-16 h-16 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400 dark:text-gray-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
          </svg>
        </div>
        <h4 class="font-bold text-gray-900 dark:text-white">Belum Ada Jadwal</h4>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Jadwal akan muncul di sini setelah Admin atau Asatidz menentukannya.</p>
      </div>
      @endif
    </div>