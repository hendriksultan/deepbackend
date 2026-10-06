{{-- ========================================================================= --}}
  {{-- ⭐ POPUP ONBOARDING SIMPEL (UPDATE PROGRAM) ⭐ --}}
{{-- ========================================================================= --}}

  {{-- Cek: Role student DAN student_level masih NULL --}}
  @if(auth()->user()->role === 'student' && is_null(auth()->user()->student_level))

  <div x-data="{ selectedLevel: null }">
    {{-- KUNCI UTAMA: Teleportasi elemen ini agar keluar dari kurungan layout dan pindah ke body terluar --}}
    <template x-teleport="body">
        
        <div class="fixed inset-0 flex items-center justify-center p-4 sm:p-6"
        style="z-index: 999999;" {{-- Z-Index absolut --}}
        x-cloak>

        {{-- Backdrop Gelap (Blur) --}}
        <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity"></div>

        {{-- Modal Card --}}
        <div class="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none] bg-white dark:bg-gray-800 rounded-[20px] shadow-2xl p-8 md:p-10 transform transition-all animate-fade-in-up border border-gray-100 dark:border-gray-700">

            {{-- Header Simpel --}}
            <div class="text-center mb-8 mt-2">
            <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white mb-3">
                Ahlan Wa Sahlan, {{ explode(' ', auth()->user()->name)[0] }}! 👋
            </h2>
            <p class="text-gray-600 dark:text-gray-300 text-base max-w-lg mx-auto">
                Untuk mendapatkan rekomendasi Ustadz/Ustadzah terbaik, program apa yang ingin Anda pelajari?
            </p>
            </div>

            <form action="{{ route('student.save_level') }}" method="POST">
            @csrf

            {{-- Grid Pilihan (2 Kolom) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-5 mb-8">

                {{-- Opsi 1: Iqra --}}
                <label class="cursor-pointer relative">
                <input type="radio" name="student_level" value="iqra" x-model="selectedLevel" class="peer sr-only" required>
                <div class="w-full h-full p-4 md:p-5 rounded-2xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-emerald-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/10 transition-all text-center peer-checked:border-emerald-600 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/30 group">

                    <div class="w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center bg-gray-50 dark:bg-gray-700 text-gray-400 group-hover:scale-110 group-hover:text-emerald-500 transition-all duration-300 peer-checked:bg-gradient-to-br peer-checked:from-emerald-400 peer-checked:to-emerald-600 peer-checked:text-white peer-checked:shadow-md">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    </div>

                    <h4 class="font-bold text-gray-800 dark:text-white text-lg peer-checked:text-emerald-700 dark:peer-checked:text-emerald-400">Program Iqra</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Belum kenal huruf atau masih terbata-bata</p>
                </div>
                </label>

                {{-- Opsi 2: Tahsin --}}
                <label class="cursor-pointer relative">
                <input type="radio" name="student_level" value="tahsin" x-model="selectedLevel" class="peer sr-only">
                <div class="w-full h-full p-4 md:p-5 rounded-2xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-emerald-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/10 transition-all text-center peer-checked:border-emerald-600 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/30 group">

                    <div class="w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center bg-gray-50 dark:bg-gray-700 text-gray-400 group-hover:scale-110 group-hover:text-emerald-500 transition-all duration-300 peer-checked:bg-gradient-to-br peer-checked:from-emerald-400 peer-checked:to-emerald-600 peer-checked:text-white peer-checked:shadow-md">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                    </svg>
                    </div>

                    <h4 class="font-bold text-gray-800 dark:text-white text-lg peer-checked:text-emerald-700 dark:peer-checked:text-emerald-400">Program Tahsin</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Lancar membaca, fokus perbaikan Tajwid</p>
                </div>
                </label>

                {{-- Opsi 3: Tahfidz --}}
                <label class="cursor-pointer relative">
                <input type="radio" name="student_level" value="tahfidz" x-model="selectedLevel" class="peer sr-only">
                <div class="w-full h-full p-4 md:p-5 rounded-2xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-emerald-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/10 transition-all text-center peer-checked:border-emerald-600 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/30 group">

                    <div class="w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center bg-gray-50 dark:bg-gray-700 text-gray-400 group-hover:scale-110 group-hover:text-emerald-500 transition-all duration-300 peer-checked:bg-gradient-to-br peer-checked:from-emerald-400 peer-checked:to-emerald-600 peer-checked:text-white peer-checked:shadow-md">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    </div>

                    <h4 class="font-bold text-gray-800 dark:text-white text-lg peer-checked:text-emerald-700 dark:peer-checked:text-emerald-400">Program Tahfidz</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Fokus menambah dan menjaga hafalan Al-Qur'an</p>
                </div>
                </label>

                {{-- Opsi 4: Sanad --}}
                <label class="cursor-pointer relative">
                <input type="radio" name="student_level" value="sanad" x-model="selectedLevel" class="peer sr-only">
                <div class="w-full h-full p-4 md:p-5 rounded-2xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-emerald-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/10 transition-all text-center peer-checked:border-emerald-600 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/30 group">

                    <div class="w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center bg-gray-50 dark:bg-gray-700 text-gray-400 group-hover:scale-110 group-hover:text-emerald-500 transition-all duration-300 peer-checked:bg-gradient-to-br peer-checked:from-emerald-400 peer-checked:to-emerald-600 peer-checked:text-white peer-checked:shadow-md">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    </div>

                    <h4 class="font-bold text-gray-800 dark:text-white text-lg peer-checked:text-emerald-700 dark:peer-checked:text-emerald-400">Program Sanad</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pengambilan sanad bacaan bersambung</p>
                </div>
                </label>

                {{-- Opsi 5: Bahasa Arab (Lebar Penuh) --}}
                <label class="cursor-pointer relative sm:col-span-2">
                <input type="radio" name="student_level" value="bahasa" x-model="selectedLevel" class="peer sr-only">
                <div class="w-full h-full p-4 md:p-5 rounded-2xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-emerald-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/10 transition-all text-center peer-checked:border-emerald-600 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/30 group">

                    <div class="w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center bg-gray-50 dark:bg-gray-700 text-gray-400 group-hover:scale-110 group-hover:text-emerald-500 transition-all duration-300 peer-checked:bg-gradient-to-br peer-checked:from-emerald-400 peer-checked:to-emerald-600 peer-checked:text-white peer-checked:shadow-md">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                    </svg>
                    </div>

                    <h4 class="font-bold text-gray-800 dark:text-white text-lg peer-checked:text-emerald-700 dark:peer-checked:text-emerald-400">Bahasa Arab</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Mempelajari tata bahasa, kosakata, dan percakapan</p>
                </div>
                </label>

            </div>

            {{-- Tombol Submit --}}
            <button type="submit"
                :disabled="!selectedLevel"
                :class="!selectedLevel ? 'bg-gray-200 text-gray-400 dark:bg-gray-700 dark:text-gray-500 cursor-not-allowed' : 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-xl shadow-emerald-200/50 dark:shadow-none transform hover:-translate-y-0.5'"
                class="w-full py-4 rounded-xl font-extrabold text-base transition-all flex items-center justify-center gap-2">
                Mulai Cari Pengajar
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </button>
            </form>
        </div>
        </div>
    </template>
  </div>
  @endif


  {{-- Animasi Fade In Up --}}
  <style>
    .animate-fade-in-up {
      animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px) scale(0.98);
      }

      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }
  </style>