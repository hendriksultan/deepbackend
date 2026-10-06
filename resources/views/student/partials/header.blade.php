{{-- ========================================================= --}}
  {{-- HEADER SECTION (RESPONSIVE) WITH DAILY QUOTE --}}
{{-- ========================================================= --}}
  @php
      // [BARU] Kumpulan Hadits untuk Daily Quote
      $inspirations = [
          [
              'text' => 'Barangsiapa menempuh suatu jalan untuk menuntut ilmu, maka Allah akan mudahkan baginya jalan menuju surga.',
              'source' => 'HR. Muslim'
          ],
          [
              'text' => 'Sebaik-baik kalian adalah orang yang mempelajari Al-Qur\'an dan mengajarkannya.',
              'source' => 'HR. Bukhari'
          ],
          [
              'text' => 'Barangsiapa yang Allah kehendaki kebaikan baginya, maka Allah akan memahamkannya dalam urusan agama.',
              'source' => 'HR. Bukhari & Muslim'
          ],
          [
              'text' => 'Ikatlah ilmu dengan dengan menulisnya.',
              'source' => 'Silsilah Ash-Shahihah'
          ],
          [
              'text' => 'Sesungguhnya malaikat meletakkan sayapnya bagi penuntut ilmu karena ridha dengan apa yang ia lakukan.',
              'source' => 'HR. Tirmidzi'
          ],
          [
              'text' => 'Ilmu itu lebih baik daripada harta. Ilmu menjaga engkau dan engkau menjaga harta.',
              'source' => 'Ali bin Abi Thalib'
          ],
          [
              'text' => 'Barangsiapa yang keluar dalam rangka menuntut ilmu, maka ia berada di jalan Allah sampai ia kembali.',
              'source' => 'HR. Tirmidzi'
          ]
      ];

      // Algoritma modulo agar berganti setiap hari
      $dayOfYear = date('z'); 
      $quoteIndex = $dayOfYear % count($inspirations);
      $dailyQuote = $inspirations[$quoteIndex];
  @endphp

  <div class="relative -mt-16 pb-32 pt-16 md:pb-32 md:pt-24 overflow-hidden shadow-xl rounded-b-[2.5rem] md:rounded-b-[4rem] lg:rounded-b-[6rem]"
    x-data="{
           masehi: '',
           hijriah: '',
           init() {
               const date = new Date();
               this.masehi = new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }).format(date);
               
               const koreksiHari = -1; 
               const hijriDate = new Date(date);
               hijriDate.setDate(hijriDate.getDate() + koreksiHari);
               
               try {
                   let formatter = new Intl.DateTimeFormat('en-US-u-ca-islamic', { day: 'numeric', month: 'numeric', year: 'numeric' });
                   let parts = formatter.formatToParts(hijriDate);
                   
                   let d = parts.find(p => p.type === 'day').value;
                   let m = parseInt(parts.find(p => p.type === 'month').value) - 1;
                   let y = parts.find(p => p.type === 'year').value.replace(/\D/g, '');
                   
                   let namaBulan = ['Muharram', 'Safar', 'Rabiul Awal', 'Rabiul Akhir', 'Jumadil Awal', 'Jumadil Akhir', 'Rajab', 'Sya\'ban', 'Ramadan', 'Syawal', 'Dzulqa\'dah', 'Dzulhijjah'];
                   
                   this.hijriah = `${d} ${namaBulan[m]} ${y} H`;
               } catch(e) {
                   let fallback = new Intl.DateTimeFormat('id-ID-u-ca-islamic', { day: 'numeric', month: 'long', year: 'numeric' }).format(hijriDate);
                   this.hijriah = fallback.replace(/ AH| H/gi, '') + ' H';
               }
           }
       }">

    {{-- 1. BACKGROUND IMAGE --}}
    <div class="absolute inset-0">
      <img src="{{ asset('masjid.png') }}"
        alt="Background Mosque"
        class="w-full h-full object-cover object-center" />
    </div>

    {{-- 2. GRADIENT OVERLAY --}}
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/50 to-gray-900/95"></div>

    {{-- 3. TEXTURE PATTERN --}}
    <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/arabesque.png')]"></div>

    {{-- ========================================================= --}}
    {{-- WIDGET KALENDER DESKTOP --}}
    {{-- ========================================================= --}}
    <div class="absolute top-24 left-4 md:top-24 md:left-8 lg:left-12 hidden sm:flex flex-col items-start gap-1 text-left group z-20">
      <div class="flex items-center gap-2 bg-black/30 backdrop-blur-md px-3 py-1.5 rounded-r-xl rounded-tl-xl border border-white/10 shadow-sm transition-transform group-hover:translate-x-1">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 md:w-4 md:h-4 text-white/80">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
        </svg>
        <span x-text="masehi" class="font-medium text-white/90 text-xs md:text-sm tracking-wide"></span>
      </div>
      <span class="px-2 text-[9px] md:text-[10px] text-white/50 uppercase tracking-widest font-bold">Masehi</span>
    </div>

    <div class="absolute top-24 right-4 md:top-28 md:right-8 lg:right-12 hidden sm:flex flex-col items-end gap-1 text-right group z-20">
      <div class="flex items-center gap-2 bg-black/30 backdrop-blur-md px-3 py-1.5 rounded-l-xl rounded-tr-xl border border-white/10 shadow-sm transition-transform group-hover:-translate-x-1">
        <span x-text="hijriah" class="font-bold text-emerald-400 text-xs md:text-sm tracking-wide"></span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 md:w-4 md:h-4 text-emerald-400">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
        </svg>
      </div>
      <span class="px-2 text-[9px] md:text-[10px] text-emerald-400/60 uppercase tracking-widest font-bold">Hijriah</span>
    </div>

    {{-- KONTEN HEADER UTAMA (TENGAH) --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center flex flex-col items-center justify-center h-full pt-4 md:pt-0">

      {{-- KALENDER VERSI MOBILE --}}
      <div class="flex sm:hidden items-center justify-center gap-2 mb-6 bg-black/40 backdrop-blur-md px-4 py-2 rounded-full border border-white/10 shadow-lg mx-auto w-max">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-emerald-400 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
        </svg>
        <span x-text="hijriah" class="font-bold text-emerald-400 text-xs tracking-wide whitespace-nowrap"></span>
        <span class="text-white/30 text-xs px-1">|</span>
        <span x-text="masehi" class="text-white/80 text-xs font-medium whitespace-nowrap"></span>
      </div>

      {{-- Ucapan Selamat Datang --}}
      <h2 class="text-lg md:text-2xl font-medium text-white mb-2 tracking-wide font-sans flex items-center justify-center gap-2 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 md:w-8 md:h-8 text-emerald-400 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
        </svg>
        Ahlan Wa Sahlan,
      </h2>

      {{-- Nama User --}}
      <h1 class="text-[24px] md:text-5xl lg:text-4xl font-extrabold text-white tracking-tight mb-5 drop-shadow-2xl px-2 break-words w-full">
        {{ $user->name }}
      </h1>

      {{-- [PERUBAHAN FINAL]: Quote Hadits Berganti Tiap Hari (Production Safe) --}}
      <div class="max-w-2xl mx-auto px-4 w-full mt-2">
        <p class="text-white text-sm md:text-lg font-medium leading-relaxed italic drop-shadow-md">
          "{{ $dailyQuote['text'] }}"
        </p>
        <div class="flex items-center justify-center gap-3 mt-4">
          <span class="h-[1px] w-8 md:w-12 bg-emerald-400"></span>
          <span class="text-emerald-400 text-[10px] md:text-xs font-bold uppercase tracking-[0.2em] whitespace-nowrap drop-shadow-md">{{ $dailyQuote['source'] }}</span>
          <span class="h-[1px] w-8 md:w-12 bg-emerald-400"></span>
        </div>
      </div>

    </div>
  </div>