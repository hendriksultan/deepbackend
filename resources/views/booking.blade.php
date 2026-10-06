@php
// LOGIKA LAYOUT:
$isLoggedIn = Auth::check();
$layout = $isLoggedIn ? 'student-layout' : 'layout';

$containerClass = $isLoggedIn
// LOGGED IN (User):
// Ubah 'pt-4' jadi 'pt-2' (lebih rapat) di mobile.
? 'max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-2 pb-12 md:pt-6'

// GUEST (Tamu/Public):
// Perbaikan: Ubah 'pt-32' menjadi 'pt-20' (Mobile) dan 'md:pt-32' (Desktop).
// pt-20 (80px) sudah cukup untuk memberi jarak dari header di HP tanpa terlalu kosong.
: 'max-w-6xl mx-auto px-4 md:px-6 pt-20 pb-20 md:pt-32';
@endphp
<x-dynamic-component :component="$layout">

  {{-- HEADER KHUSUS TAMU (Hanya muncul jika belum login) --}}
  @if(!$isLoggedIn)
  <div class="bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 sticky top-0 z-40 shadow-sm transition-colors duration-300">
    <div class="max-w-6xl mx-auto px-4 md:px-6 h-16 flex items-center justify-between">
      <a href="/" class="group flex items-center gap-3 text-gray-500 dark:text-gray-400 hover:text-green-700 dark:hover:text-green-400 transition font-medium text-sm">
        <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center group-hover:bg-green-100 dark:group-hover:bg-green-900/50 transition">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
        </div>
        Kembali ke Beranda
      </a>
      <span class="text-xs font-bold text-gray-800 dark:text-white tracking-widest uppercase">Pendaftaran Kelas</span>
    </div>
  </div>
  @endif

  <div class="{{ $containerClass }}">

    {{-- TOMBOL KEMBALI USER LOGIN --}}
    @if($isLoggedIn)
    <div class="hidden md:block mb-6 md:mb-8">
      <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 px-4 py-2 md:px-5 md:py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs md:text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 hover:border-green-200 dark:hover:border-green-900 transition-all duration-300 shadow-sm group">
        <svg class="w-3 h-3 md:w-4 md:h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali
      </a>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-[20px] shadow-xl shadow-gray-200/50 dark:shadow-none overflow-hidden flex flex-col lg:flex-row border border-gray-100 dark:border-gray-700 transition-colors duration-300">

      {{-- BAGIAN KIRI (INFO GURU) --}}
      <div class="w-full lg:w-2/5 bg-gradient-to-br from-green-800 to-emerald-900 text-white p-8 md:p-10 flex flex-col relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/arabesque.png')]"></div>

        <div class="relative z-10">
          {{-- BADGE METODE (Dinamis) --}}
          <span class="inline-block px-4 py-1.5 {{ $teacher->method == 'offline' ? 'bg-orange-500/20 border-orange-400/30 text-orange-100' : 'bg-blue-500/20 border-blue-400/30 text-blue-100' }} backdrop-blur-md rounded-full text-[10px] font-bold tracking-widest uppercase mb-6 border shadow-sm">
            Metode: {{ ucfirst($teacher->method) }} {{ $teacher->method == 'offline' ? '(Guru Datang)' : '(Via Zoom)' }}
          </span>

          <h2 class="text-3xl md:text-3xl font-bold mb-3 leading-tight">{{ $teacher->user->name }}</h2>

          <div class="flex flex-wrap gap-2 mb-6">
            <span class="text-green-100 text-xs font-bold bg-white/10 border border-white/10 px-3 py-1 rounded-lg uppercase tracking-wide">{{ $teacher->specialization }}</span>
            @if($teacher->is_full)
            <span class="text-red-100 bg-red-500/20 border border-red-500/30 px-3 py-1 rounded-lg text-xs font-bold uppercase">Kuota Penuh</span>
            @else
            <span class="text-green-100 bg-green-500/20 border border-green-500/30 px-3 py-1 rounded-lg text-xs font-bold uppercase">Sisa {{ $teacher->remaining_quota }} Kursi</span>
            @endif
          </div>

          {{-- ========================================================= --}}
          {{-- [BARU] INDIKATOR LEVEL (Ditambahkan agar sinkron dengan Dashboard) --}}
          {{-- ========================================================= --}}
          <div class="mb-8 p-4 bg-black/10 rounded-2xl border border-white/5 backdrop-blur-sm">
            <p class="text-[10px] text-green-200/70 uppercase font-bold tracking-widest mb-2">Mengajar Jenjang:</p>
            <div class="flex flex-wrap gap-1.5">
              @if($teacher->teaching_levels && is_array($teacher->teaching_levels))
              @foreach($teacher->teaching_levels as $level)
              @php
              $cleanLevel = explode(' (', $level)[0];
              @endphp
              <span class="px-2 py-1 bg-white/10 border border-white/20 text-white text-[10px] font-bold rounded shadow-sm">
                {{ $cleanLevel }}
              </span>
              @endforeach
              @else
              <span class="px-2 py-1 bg-white/10 border border-white/20 text-white text-[10px] font-bold rounded shadow-sm">Semua Jenjang</span>
              @endif
            </div>

            {{-- Pesan Peringatan Sinkronisasi Level (Opsional, hanya jika user sudah login) --}}
            @if(Auth::check() && Auth::user()->role === 'student' && Auth::user()->student_level)
            @php
            $userLevel = Auth::user()->student_level;
            $isMatch = $teacher->teaching_levels && in_array($userLevel, $teacher->teaching_levels);
            @endphp

            @if($isMatch)
            <p class="text-xs text-green-300 mt-3 flex items-center gap-1.5">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Sesuai dengan level Anda!
            </p>
            @else
            <p class="text-[11px] text-yellow-300/90 mt-3 flex items-start gap-1.5 leading-snug">
              <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
              </svg>
              Guru ini mungkin tidak mengajar level Anda ({{ explode(' (', $userLevel)[0] }}). Lanjut jika Anda yakin.
            </p>
            @endif
            @endif
          </div>
          {{-- ========================================================= --}}

          {{-- LIST JADWAL --}}
          <div class="bg-black/20 backdrop-blur-sm rounded-2xl p-5 border border-white/10 mb-8">
            <h3 class="text-sm font-bold text-white/90 uppercase tracking-widest mb-4 flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              Jadwal Tersedia
            </h3>

            @if($teacher->relationLoaded('schedules') && $teacher->schedules->count() > 0)
            <div class="space-y-3 max-h-[250px] overflow-y-auto pr-2 custom-scrollbar">

              {{-- Filter Unique Date --}}
              @foreach($teacher->schedules->sortBy('start')->unique(fn($item) => $item->start->format('Y-m-d')) as $jadwal)

              <div class="flex items-center gap-3 p-3 bg-white/5 rounded-xl hover:bg-white/10 transition border border-white/5">
                <div class="bg-white/10 text-white p-2 rounded-lg font-bold text-center min-w-[45px]">
                  <div class="text-[10px] uppercase opacity-70">{{ $jadwal->start->format('M') }}</div>
                  <div class="text-lg leading-none">{{ $jadwal->start->format('d') }}</div>
                </div>
                <div>
                  <div class="text-white text-xs font-bold">{{ $jadwal->title }}</div>
                  <div class="text-white/60 text-[10px] mt-0.5">
                    Mulai: {{ $jadwal->start->format('H:i') }} WIB
                  </div>
                </div>
              </div>
              @endforeach

            </div>
            @else
            <p class="text-white/50 text-xs italic">Belum ada jadwal yang ditentukan. Waktu bisa didiskusikan.</p>
            @endif
          </div>

          {{-- INFO TAMBAHAN --}}
          <div class="space-y-4 text-sm border-t border-white/10 pt-6">
            @if($teacher->method == 'offline')
            {{-- METODE: OFFLINE (HOME VISIT) --}}
            <div class="flex items-start gap-4">
              <div class="p-2 bg-orange-500/20 rounded-lg text-orange-100 shrink-0">
                {{-- Icon Home Modern --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
              </div>
              <div>
                <p class="font-bold text-white text-base">Home Visit</p>
                <p class="text-orange-100/70 text-xs mt-0.5">Guru akan datang mengajar di rumah Anda.</p>
              </div>
            </div>
            @else
            {{-- METODE: ONLINE --}}
            <div class="flex items-start gap-4">
              <div class="p-2 bg-blue-500/20 rounded-lg text-blue-100 shrink-0">
                {{-- Icon Video Camera --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>
              </div>
              <div>
                <p class="font-bold text-white text-base">Kelas Online</p>
                <p class="text-blue-100/70 text-xs mt-0.5">Belajar via Zoom/Google Meet.</p>
              </div>
            </div>
            @endif
          </div>

        </div>
      </div>

      {{-- BAGIAN KANAN (FORMULIR) --}}
      <div class="w-full lg:w-3/5 p-8 md:p-12 bg-white dark:bg-gray-800 relative">
        <div class="relative z-10">
          <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Lengkapi Data Diri</h3>
          <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">Data ini akan dikirimkan ke pengajar untuk konfirmasi.</p>

          @if(session('success'))
          <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 p-4 rounded-xl mb-6 flex items-start gap-3">
            <svg class="w-5 h-5 mt-0.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
          </div>
          @endif

          @if($teacher->is_full)
          <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-6 rounded-2xl text-center">
            <div class="inline-flex bg-red-100 dark:bg-red-800 p-3 rounded-full text-red-600 dark:text-red-200 mb-4">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
              </svg>
            </div>
            <h3 class="text-lg font-bold text-red-800 dark:text-red-400 mb-1">Mohon Maaf, Kuota Penuh</h3>
            <a href="{{ route('student.teachers.index') }}" class="inline-block mt-4 px-6 py-2 bg-red-600 text-white text-sm font-bold rounded-lg hover:bg-red-700 transition">Cari Pengajar Lain</a>
          </div>
          @else

          <form action="{{ route('booking.store', $teacher->id) }}" method="POST" class="space-y-6" x-data="{ loading: false }" @submit="loading = true">
            @csrf

            <input type="hidden" name="method" value="{{ $teacher->method }}">

            @if(Auth::check())
            <div class="p-5 bg-gray-50 dark:bg-gray-700/30 rounded-2xl border border-gray-100 dark:border-gray-700 flex items-center gap-4 transition-colors">
              <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-700 dark:text-green-300 font-bold border border-green-200 dark:border-green-800 text-lg shrink-0">
                {{ substr(Auth::user()->name, 0, 1) }}
              </div>
              <div class="flex-grow">
                <p class="text-[10px] text-gray-400 dark:text-gray-500 uppercase font-bold tracking-wider mb-0.5">Mendaftar Sebagai:</p>
                <p class="font-bold text-gray-900 dark:text-white text-base">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
              </div>
              <input type="hidden" name="student_name" value="{{ Auth::user()->name }}">
              <input type="hidden" name="email" value="{{ Auth::user()->email }}">
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-2">Nama Lengkap</label>
                <input type="text" name="student_name" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white px-4 py-3 text-sm focus:ring-2 focus:ring-green-500" placeholder="Nama Santri">
              </div>
              <div>
                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-2">Email</label>
                <input type="email" name="email" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white px-4 py-3 text-sm focus:ring-2 focus:ring-green-500" placeholder="email@contoh.com">
              </div>
            </div>
            @endif

            <div>
              <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-2">Nomor WhatsApp</label>
              <div class="relative">
                {{-- Icon Phone --}}
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                  </svg>
                </div>
                <input type="text" name="whatsapp" required class="w-full pl-11 rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 outline-none transition" placeholder="Contoh: 0812xxxx">
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-2">Program Pilihan</label>
              <div class="relative">
                <select name="program_type" class="w-full appearance-none rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white px-4 py-3 text-sm cursor-pointer focus:ring-2 focus:ring-green-500 outline-none transition">
                  <option value="iqra">Program Iqra</option>
                  <option value="tahsin">Tahsin (Perbaikan Bacaan)</option>
                  <option value="tahfidz">Tahfidz (Hafalan)</option>
                  <option value="sanad">Program Sanad</option>
                  <option value="bahasa">Program Bahasa Arab</option>
                </select>
                {{-- Icon Chevron Down --}}
                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                  </svg>
                </div>
              </div>
            </div>

            {{-- [LOGIKA BARU] INPUT ALAMAT KHUSUS OFFLINE --}}
            @if($teacher->method === 'offline')
            <div class="bg-orange-50 dark:bg-orange-900/10 p-5 rounded-xl border border-orange-200 dark:border-orange-800/50 animate-fade-in-up">
              <div class="flex items-center gap-3 mb-3">
                {{-- Icon Map Pin --}}
                <div class="text-orange-600 dark:text-orange-400">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 md:w-6 md:h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                  </svg>
                </div>

                <h4 class="font-bold text-orange-800 dark:text-orange-400">Lokasi Belajar (Wajib Diisi)</h4>
              </div>

              <div class="space-y-4">
                <div>
                  <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-2">Alamat Lengkap Rumah</label>
                  <textarea name="student_address" rows="3" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500" placeholder="Nama Jalan, Nomor Rumah, RT/RW, Patokan..."></textarea>
                </div>

                <div>
                  <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-2">Link Google Maps (Opsional)</label>
                  <input type="url" name="maps_link" class="w-full rounded-xl border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500" placeholder="https://maps.app.goo.gl/...">
                </div>
              </div>
            </div>
            @endif

           <div class="pt-4 md:pt-6">
              <button type="submit" :disabled="loading" class="w-full py-3.5 md:py-4 px-6 bg-green-600 hover:bg-green-700 text-white text-sm md:text-base font-bold rounded-xl shadow-lg shadow-green-600/30 hover:shadow-green-600/50 transition-all duration-300 transform active:scale-[0.98] flex justify-center items-center gap-2.5 md:gap-3 disabled:opacity-70 disabled:cursor-not-allowed">
                
                {{-- Kondisi Normal (Belum diklik) --}}
                <span x-show="!loading" class="flex items-center gap-2">
                  <span>{{ $teacher->method == 'offline' ? 'Jadwalkan Kunjungan' : 'Daftar Kelas Sekarang' }}</span>
                  <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                  </svg>
                </span>

                {{-- Kondisi Loading (Sedang diproses) --}}
                <span x-show="loading" class="flex items-center gap-2" style="display: none;">
                  {{-- Ikon Spinner Animasi Berputar --}}
                  <svg class="animate-spin h-4 w-4 md:h-5 md:w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  <span>Sedang Memproses...</span>
                </span>

              </button>
            </div>
          </form>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-dynamic-component>