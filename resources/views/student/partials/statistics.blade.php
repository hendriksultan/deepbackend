 {{-- 1. STATISTIK CARDS --}}
    <div class="grid grid-cols-2 gap-3 md:gap-6 mb-8 md:mb-10">
      {{-- Card 1: Kelas Terdaftar --}}
      <div class="bg-white dark:bg-gray-800 rounded-[20px] p-4 md:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:-translate-y-1 hover:shadow-md transition-all duration-300">
        <div class="absolute right-0 top-0 w-16 h-16 md:w-32 md:h-32 bg-green-50 dark:bg-white/5 rounded-bl-[2rem] md:rounded-bl-[4rem] -mr-2 -mt-2 transition-transform duration-500 group-hover:scale-110"></div>
        <div class="flex items-center gap-3 md:gap-5 relative z-10">
          {{-- 2. KOTAK IKON (KIRI) --}}
          <div class="w-10 h-10 md:w-16 md:h-16 bg-green-50 dark:bg-gray-700 text-green-600 dark:text-green-400 rounded-xl md:rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-green-100 dark:group-hover:bg-gray-600 transition-colors duration-300 flex-shrink-0">
            <svg class="w-5 h-5 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
          </div>
          <div class="min-w-0">
            <p class="text-gray-500 dark:text-gray-400 text-[10px] md:text-sm font-bold uppercase tracking-wide mb-0.5">Kelas</p>
            <h3 class="text-xl md:text-4xl font-bold text-gray-800 dark:text-white truncate">{{ $myBookings->count() }}</h3>
          </div>
        </div>
      </div>

      {{-- Card 2: Total Kehadiran (Dibuat bisa diklik) --}}
      <a href="{{ route('student.riwayat-presensi') }}" class="block bg-white dark:bg-gray-800 rounded-[20px] p-4 md:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:-translate-y-1 hover:shadow-md transition-all duration-300">
        <div class="absolute right-0 top-0 w-16 h-16 md:w-32 md:h-32 bg-blue-50 dark:bg-white/5 rounded-bl-[2rem] md:rounded-bl-[4rem] -mr-2 -mt-2 transition-transform duration-500 group-hover:scale-110"></div>
        <div class="flex items-center gap-3 md:gap-5 relative z-10">
          
          {{-- KOTAK IKON (KIRI) - Tema Biru --}}
          <div class="w-10 h-10 md:w-16 md:h-16 bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 rounded-xl md:rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-blue-100 dark:group-hover:bg-gray-600 transition-colors duration-300 flex-shrink-0">
            <svg class="w-5 h-5 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
          </div>
          
          <div class="min-w-0 flex-1">
            <p class="text-gray-500 dark:text-gray-400 text-[10px] md:text-sm font-bold uppercase tracking-wide mb-0.5">Kehadiran</p>
            
            <div class="flex items-baseline gap-2">
                <h3 class="text-xl md:text-4xl font-bold text-gray-800 dark:text-white truncate leading-none">{{ $totalKehadiran ?? 0 }}</h3>
                <span class="text-[10px] md:text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-1.5 md:px-2 py-0.5 rounded uppercase tracking-wider">Total</span>
            </div>
            
            <p class="text-[10px] md:text-xs text-gray-400 dark:text-gray-500 mt-1 md:mt-1.5 line-clamp-1">
                <strong class="text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/30 px-1 py-0.5 rounded">{{ $kehadiranBulanIni ?? 0 }} Hadir</strong> di bulan ini
            </p>
          </div>

          {{-- Panah penunjuk agar santri tahu ini bisa diklik --}}
          <div class="hidden md:flex flex-shrink-0 text-gray-300 dark:text-gray-600 group-hover:text-blue-500 dark:group-hover:text-blue-400 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
          </div>
          
        </div>
      </a>
    </div>