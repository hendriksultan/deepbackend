<x-student-layout>
  {{-- CSS untuk menyembunyikan scrollbar tapi tetap bisa di-scroll --}}
  <!--<style>
    .hide-scrollbar::-webkit-scrollbar {
      display: none;
    }

    .hide-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    [x-cloak] {
      display: none !important;
    }
  </style>-->

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
  {{-- CONTAINER UTAMA (OFFSET CONTENT) --}}
  {{-- Tambahkan md:pb-8 agar di laptop jarak bawahnya kecil --}}
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 md:-mt-12 relative z-20">

    {{-- ========================================================================= --}}
    {{-- ⭐ NOTIFIKASI FLASH MESSAGE (AUTO CLOSE 5 DETIK) ⭐ --}}
    {{-- ========================================================================= --}}

    @if(session('success'))
    {{-- Tambahan: x-init="setTimeout(() => show = false, 5000)" --}}
    <div x-data="{ show: true }"
      x-show="show"
      x-init="setTimeout(() => show = false, 5000)"
      x-transition.duration.500ms
      class="mb-6 bg-green-50 dark:bg-green-900/40 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-5 py-4 rounded-[20px] shadow-lg flex items-start gap-3 relative z-50">

      <div class="bg-green-100 dark:bg-green-800 p-2 rounded-full shrink-0">
        <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
      </div>
      <div class="pt-1 flex-1">
        <h4 class="font-bold text-lg">Alhamdulillah!</h4>
        <p>{{ session('success') }}</p>
        {{-- Progress bar animasi durasi (Opsional, pemanis visual) --}}
        <div class="mt-2 h-1 w-full bg-green-200 dark:bg-green-800 rounded-full overflow-hidden">
          <div class="h-full bg-green-500 transition-all duration-[5000ms] ease-linear w-0" x-init="$nextTick(() => $el.style.width = '100%')"></div>
        </div>
      </div>
      <button @click="show = false" class="absolute top-4 right-4 text-green-500 hover:text-green-700 dark:hover:text-green-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }"
      x-show="show"
      x-init="setTimeout(() => show = false, 5000)"
      x-transition.duration.500ms
      class="mb-6 bg-red-50 dark:bg-red-900/40 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-5 py-4 rounded-[20px] shadow-lg flex items-start gap-3 relative z-50">

      <div class="bg-red-100 dark:bg-red-800 p-2 rounded-full shrink-0">
        <svg class="w-6 h-6 text-red-600 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
      <div class="pt-1 flex-1">
        <h4 class="font-bold text-lg">Mohon Maaf</h4>
        <p>{{ session('error') }}</p>
        {{-- Progress bar animasi --}}
        <div class="mt-2 h-1 w-full bg-red-200 dark:bg-red-800 rounded-full overflow-hidden">
          <div class="h-full bg-red-500 transition-all duration-[5000ms] ease-linear w-0" x-init="$nextTick(() => $el.style.width = '100%')"></div>
        </div>
      </div>
      <button @click="show = false" class="absolute top-4 right-4 text-red-500 hover:text-red-700 dark:hover:text-red-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
    @endif
   {{-- ⭐ BANNER INFAQ (100% PURE INLINE CSS - ANTI ERROR HOSTING) ⭐ --}}
    {{-- ========================================================================= --}}
    @if(isset($tagihanInfaq) && $tagihanInfaq)
    
    @php
        // Logika Warna Berdasarkan Status
        $bgColor = $tagihanInfaq->status === 'rejected' ? '#fef2f2' : '#fffbeb';
        $borderColor = $tagihanInfaq->status === 'rejected' ? '#fecaca' : '#fde68a';
        $iconColor = $tagihanInfaq->status === 'rejected' ? '#ef4444' : '#f59e0b';
        $btnColor = $tagihanInfaq->status === 'rejected' ? '#dc2626' : '#f59e0b';
    @endphp

    <div style="background-color: {{ $bgColor }}; border: 1px solid {{ $borderColor }}; border-radius: 1.5rem; padding: 2rem; position: relative; overflow: hidden; margin-bottom: 2.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); font-family: ui-sans-serif, system-ui, sans-serif;">

      {{-- Ikon Background Transparan --}}
      <div style="position: absolute; right: -1rem; top: -1rem; opacity: 0.1; color: {{ $iconColor }};">
        <svg style="width: 10rem; height: 10rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
        </svg>
      </div>

      {{-- Container Utama Split Kiri Kanan --}}
      <div style="display: flex; flex-wrap: wrap; gap: 2.5rem; position: relative; z-index: 10; align-items: stretch;">
        
        {{-- ========================================== --}}
        {{-- KOLOM KIRI: EDUKASI & INFORMASI --}}
        {{-- ========================================== --}}
        <div style="flex: 1 1 55%; min-width: 280px; display: flex; flex-direction: column;">

          {{-- Header: Ikon & Judul --}}
          <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; align-items: flex-start;">
            <div style="width: 4rem; height: 4rem; background-color: #ffffff; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: {{ $iconColor }}; border: 1px solid {{ $borderColor }}; box-shadow: 0 1px 2px rgba(0,0,0,0.05); flex-shrink: 0;">
              <svg style="width: 2rem; height: 2rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"></path>
              </svg>
            </div>

            <div style="flex: 1;">
              <h3 style="font-size: 1.125rem; font-weight: 700; color: #111827; margin-top: 0; margin-bottom: 0.5rem; line-height: 1.4;">
                Pemberitahuan Infaq Operasional ({{ $tagihanInfaq->periode_bulan }})
              </h3>
              <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                @if($tagihanInfaq->status === 'unpaid')
                <span style="padding: 0.25rem 0.75rem; background-color: #fee2e2; color: #dc2626; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; border-radius: 9999px; letter-spacing: 0.05em;">Belum Ditunaikan</span>
                @elseif($tagihanInfaq->status === 'pending')
                <span style="padding: 0.25rem 0.75rem; background-color: #dbeafe; color: #2563eb; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; border-radius: 9999px; letter-spacing: 0.05em;">Menunggu Konfirmasi</span>
                @elseif($tagihanInfaq->status === 'rejected')
                <span style="padding: 0.25rem 0.75rem; background-color: #dc2626; color: #ffffff; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; border-radius: 9999px; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.25rem;">
                  <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg> DITOLAK
                </span>
                @endif
              </div>
            </div>
          </div>

          @if($tagihanInfaq->status === 'rejected')
          <div style="background-color: #ffffff; padding: 1rem; border-radius: 1rem; border-left: 4px solid #ef4444; margin-bottom: 1.5rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <p style="font-size: 0.875rem; font-weight: 700; color: #b91c1c; margin: 0 0 0.25rem 0;">Catatan Admin:</p>
            <p style="font-size: 0.875rem; color: #374151; font-style: italic; margin: 0;">"{{ $tagihanInfaq->catatan_admin ?? 'Afwan, bukti transfer tidak terbaca/tidak valid. Mohon berkenan untuk mengunggah ulang.' }}"</p>
          </div>
          @else
          
          {{-- Deskripsi --}}
          <p style="font-size: 0.9375rem; color: #374151; margin-top: 0; margin-bottom: 1.25rem; line-height: 1.6;">
            Demi keberlangsungan operasional dakwah dan kenyamanan proses belajar mengajar, seluruh dana infaq yang masuk akan dikelola secara amanah untuk keperluan:
          </p>
          
          {{-- List Keperluan --}}
          <div style="display: flex; flex-wrap: wrap; gap: 0.75rem 0; margin-bottom: 1.5rem;">
            <div style="width: 50%; min-width: 200px; display: flex; align-items: center; gap: 0.5rem;">
              <div style="width: 1.25rem; height: 1.25rem; border-radius: 9999px; background-color: #dcfce7; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 0.875rem; height: 0.875rem; color: #16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
              </div>
              <span style="font-size: 0.875rem; color: #1f2937;">Kafalah (Mukafaah) Asatidz</span>
            </div>
            <div style="width: 50%; min-width: 200px; display: flex; align-items: center; gap: 0.5rem;">
              <div style="width: 1.25rem; height: 1.25rem; border-radius: 9999px; background-color: #dcfce7; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 0.875rem; height: 0.875rem; color: #16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
              </div>
              <span style="font-size: 0.875rem; color: #1f2937;">Pengembangan Kurikulum</span>
            </div>
            <div style="width: 50%; min-width: 200px; display: flex; align-items: center; gap: 0.5rem;">
              <div style="width: 1.25rem; height: 1.25rem; border-radius: 9999px; background-color: #dcfce7; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 0.875rem; height: 0.875rem; color: #16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
              </div>
              <span style="font-size: 0.875rem; color: #1f2937;">Pemeliharaan IT & Server</span>
            </div>
            <div style="width: 50%; min-width: 200px; display: flex; align-items: center; gap: 0.5rem;">
              <div style="width: 1.25rem; height: 1.25rem; border-radius: 9999px; background-color: #dcfce7; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 0.875rem; height: 0.875rem; color: #16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
              </div>
              <span style="font-size: 0.875rem; color: #1f2937;">Program Sosial & Beasiswa</span>
            </div>
          </div>

          {{-- Kutipan Hadits --}}
          <div style="background-color: rgba(255, 255, 255, 0.6); padding: 1rem; border-radius: 1rem; border: 1px solid rgba(253, 230, 138, 0.5);">
            <p style="font-size: 0.875rem; color: #4b5563; font-style: italic; line-height: 1.6; margin: 0;">
              "Harta tidak akan berkurang karena sedekah. Dan seorang hamba yang pemaaf pasti akan Allah tambahkan kewibawaan baginya." 
              <span style="font-weight: 700; color: #1f2937; margin-left: 0.25rem;">(HR. Muslim)</span>
            </p>
          </div>
          @endif

        </div>

        {{-- ========================================== --}}
        {{-- KOLOM KANAN: EKSEKUSI PEMBAYARAN --}}
        {{-- ========================================== --}}
        <div style="flex: 1 1 35%; min-width: 280px; display: flex; flex-direction: column;">
          
          {{-- Kartu Putih Utama --}}
          <div style="background-color: #ffffff; border-radius: 1.5rem; border: 1px solid #f3f4f6; box-shadow: 0 10px 25px -5px rgba(120, 53, 15, 0.05); padding: 1.5rem; display: flex; flex-direction: column; height: 100%;">
            
            {{-- Nominal --}}
            <div style="text-align: center; margin-bottom: 1.5rem;">
              <p style="font-size: 0.75rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 0.5rem 0;">Nilai Partisipasi</p>
              <div style="font-size: 2.25rem; font-weight: 900; color: #111827; display: flex; align-items: baseline; justify-content: center; gap: 0.25rem;">
                <span style="font-size: 1.25rem; color: #9ca3af;">Rp</span> {{ number_format($tagihanInfaq->nominal, 0, ',', '.') }}
              </div>
            </div>

            @if($tagihanInfaq->status === 'unpaid' || $tagihanInfaq->status === 'rejected')
            
            {{-- Area QRIS --}}
            <div style="background-color: #f9fafb; border-radius: 1rem; padding: 1rem; display: flex; flex-direction: column; align-items: center; border: 1px solid #f3f4f6; margin-bottom: 1.5rem;">
                <h4 style="font-size: 0.75rem; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 0.75rem 0;">Scan QRIS</h4>
                <div style="background-color: #ffffff; padding: 0.5rem; border-radius: 0.75rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                    <img src="{{ asset('images/dqa-qris.png') }}" alt="QRIS Infaq" style="width: 140px; height: auto; object-fit: contain;">
                </div>
                <p style="font-size: 0.65rem; color: #6b7280; text-align: center; margin: 0.75rem 0 0 0; max-width: 200px;">
                    Gopay, OVO, Dana, LinkAja & M-Banking.
                </p>
            </div>

            {{-- Form Upload Konfirmasi --}}
            <form action="{{ route('infaq.upload', $tagihanInfaq->id) }}" method="POST" enctype="multipart/form-data" 
              onsubmit="document.getElementById('btn-upload-{{ $tagihanInfaq->id }}').disabled = true; document.getElementById('btn-upload-{{ $tagihanInfaq->id }}').style.opacity = '0.5'; document.getElementById('btn-upload-{{ $tagihanInfaq->id }}').style.cursor = 'not-allowed'; document.getElementById('btn-text-{{ $tagihanInfaq->id }}').innerText = 'Mengirim...';"
              style="margin-top: auto; display: flex; flex-direction: column;">
              @csrf
              
              <input type="file" name="bukti_transfer" accept=".jpg,.jpeg,.png" required
                style="display: block; width: 100%; font-size: 0.75rem; color: #4b5563; margin-bottom: 0.75rem; padding: 0.5rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; background-color: #f9fafb; cursor: pointer; box-sizing: border-box;">

              <button id="btn-upload-{{ $tagihanInfaq->id }}" type="submit" style="width: 100%; padding: 0.75rem; background-color: {{ $btnColor }}; color: #ffffff; font-size: 0.875rem; font-weight: 700; border-radius: 0.75rem; border: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: background-color 0.2s;">
                <span id="btn-text-{{ $tagihanInfaq->id }}">{{ $tagihanInfaq->status === 'rejected' ? 'Upload Ulang Bukti' : 'Kirim Bukti Pembayaran' }}</span>
                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                </svg>
              </button>
            </form>
            
            @elseif($tagihanInfaq->status === 'pending')
            <div style="background-color: #eff6ff; border-radius: 1rem; border: 1px solid #bfdbfe; padding: 1.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; height: 100%; min-height: 200px;">
              <div style="position: relative; margin-bottom: 1rem;">
                <svg style="width: 3rem; height: 3rem; color: #bfdbfe; animation: spin 1s linear infinite;" fill="none" viewBox="0 0 24 24">
                  <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="15 85"></circle>
                </svg>
                <svg style="width: 1.5rem; height: 1.5rem; color: #2563eb; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
              </div>
              <span style="font-size: 1.125rem; font-weight: 700; color: #1d4ed8; margin-bottom: 0.5rem;">Verifikasi Admin</span>
              <span style="font-size: 0.875rem; color: #2563eb;">
                Jazakumullah Khairan. Bukti transfer Anda sedang kami proses.
              </span>
            </div>
            @endif

          </div>
        </div>

      </div>
    </div>
    @endif

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

   {{-- 3. GRID RIWAYAT & STATUS (Responsive Stack) --}}
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">

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

          {{-- KONTEN TAB 3: IQRA (Semua Riwayat dengan Paginasi) --}}
            <div x-show="activeTab === 'iqra'" x-cloak x-transition:enter="transition ease-out duration-300">
                
                @if($riwayatIqra->isEmpty())
                <div class="py-20 text-center px-4 flex flex-col items-center justify-center h-full">
                    <div class="w-16 h-16 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400 dark:text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <h4 class="text-gray-900 dark:text-white font-bold text-sm">Belum Ada Riwayat Evaluasi</h4>
                    <p class="text-gray-500 text-xs mt-1">Data evaluasi Iqra akan muncul di sini setelah sesi selesai.</p>
                </div>
                @else
                
                <div class="overflow-x-auto">
                    <div class="px-6 py-4 bg-emerald-50/30 dark:bg-transparent border-b border-emerald-100 dark:border-gray-700">
                        <h5 class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest flex items-center gap-2">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            Semua Riwayat Evaluasi
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
                        
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-700 text-sm">
                            @foreach($riwayatIqra as $iqra)
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
                    
                    {{-- [PERBAIKAN: PAGINASI MANUAL TANPA FILE LANG] --}}
                    @if($riwayatIqra->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex items-center justify-between">
                        
                        {{-- Tombol Sebelumnya --}}
                        @if ($riwayatIqra->onFirstPage())
                            <span class="px-4 py-2 text-xs font-bold text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed dark:bg-gray-800 dark:border-gray-700 dark:text-gray-500">
                                &laquo; Sebelumnya
                            </span>
                        @else
                            <a href="{{ $riwayatIqra->previousPageUrl() }}" class="px-4 py-2 text-xs font-bold text-emerald-700 bg-white border border-gray-300 rounded-lg hover:bg-emerald-50 shadow-sm transition-all active:scale-95 dark:bg-[#1a2332] dark:border-gray-600 dark:text-emerald-400 dark:hover:bg-gray-800">
                                &laquo; Sebelumnya
                            </a>
                        @endif
            
                        {{-- Keterangan Halaman (Opsional, agar terlihat elegan) --}}
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 hidden sm:block">
                            Halaman <span class="font-bold text-gray-700 dark:text-gray-300">{{ $riwayatIqra->currentPage() }}</span> dari <span class="font-bold text-gray-700 dark:text-gray-300">{{ $riwayatIqra->lastPage() }}</span>
                        </span>
            
                        {{-- Tombol Berikutnya --}}
                        @if ($riwayatIqra->hasMorePages())
                            <a href="{{ $riwayatIqra->nextPageUrl() }}" class="px-4 py-2 text-xs font-bold text-emerald-700 bg-white border border-gray-300 rounded-lg hover:bg-emerald-50 shadow-sm transition-all active:scale-95 dark:bg-[#1a2332] dark:border-gray-600 dark:text-emerald-400 dark:hover:bg-gray-800">
                                Berikutnya &raquo;
                            </a>
                        @else
                            <span class="px-4 py-2 text-xs font-bold text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed dark:bg-gray-800 dark:border-gray-700 dark:text-gray-500">
                                Berikutnya &raquo;
                            </span>
                        @endif
            
                    </div>
                    @endif
            
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

     {{-- STATUS PENDAFTARAN --}}
      <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-[20px] shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden sticky top-6">

          {{-- HEADER --}}
          <div class="px-6 py-6 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
            <div class="p-1.5 bg-green-50 dark:bg-green-900/30 rounded-lg text-green-600 dark:text-green-400">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
              </svg>
            </div>
            <h3 class="font-bold text-gray-800 dark:text-white text-lg">Status Pendaftaran</h3>
          </div>

          {{-- LIST STATUS --}}
          <div class="divide-y divide-gray-50 dark:divide-gray-700">
            @forelse($myBookings as $booking)
            
            @php
              // ====================================================================
              // LOGIKA PROGRAM GRATIS DARI DATABASE
              // ====================================================================
              $isGratis = $booking->is_free; 
            @endphp

            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition duration-200">

             {{-- Info Guru --}}
              <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-700 dark:text-green-300 font-bold text-lg border border-green-200 dark:border-green-800 shrink-0 overflow-hidden">
                  @if($booking->teacherProfile->photo_url ?? false)
                    <img src="{{ $booking->teacherProfile->photo_url }}" alt="{{ $booking->teacherProfile->user->name ?? 'Guru' }}" class="w-full h-full object-cover">
                  @else
                    {{ substr($booking->teacherProfile->user->name ?? 'G', 0, 1) }}
                  @endif
                </div>
                
                <div class="min-w-0">
                  <h4 class="font-bold text-gray-800 dark:text-white text-sm md:text-base line-clamp-1">{{ $booking->teacherProfile->user->name ?? 'Guru' }}</h4>
                  <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 font-medium flex items-center gap-1">
                    <span>Program:</span>
                    <span class="px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-[10px] font-bold uppercase">{{ ucfirst($booking->program_type) }}</span>
                  </p>
                </div>
              </div>

              {{-- Status Box --}}
              <div class="mb-5">
                @if($booking->status == 'pending')

                  @if($isGratis)
                  {{-- 1. STATUS: PENDAFTARAN GRATIS --}}
                  <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-2xl text-center">
                    <span class="flex items-center justify-center gap-1.5 text-emerald-700 dark:text-emerald-400 text-xs font-extrabold uppercase tracking-wide">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      Bebas Biaya Pendaftaran
                    </span>
                    <p class="text-[10px] text-gray-500 mt-2">Program ini tidak memungut biaya awal. Silakan klik konfirmasi di bawah untuk lanjut.</p>
                  </div>
                  @else
                  {{-- 2. STATUS: MENUNGGU PEMBAYARAN (BERBAYAR) --}}
                  <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-100 dark:border-yellow-800 rounded-2xl text-center">
                    <span class="flex items-center justify-center gap-1.5 text-yellow-700 dark:text-yellow-400 text-xs font-extrabold uppercase mb-2 tracking-wide">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                      </svg>
                      Menunggu Pembayaran
                    </span>
                    <div class="text-xs text-gray-500 dark:text-gray-400 pt-3 border-t border-yellow-200 dark:border-yellow-800/50 flex flex-col gap-1">
                      <span class="mb-0.5">Biaya Pendaftaran:</span>
                      <span class="font-extrabold text-gray-900 dark:text-white text-lg mb-1.5">Rp 50.000</span>
                      <span>Silakan Transfer ke Muamalat:</span>
                      <span class="font-mono font-bold text-gray-800 dark:text-gray-200 text-sm tracking-wider">1610055206</span>
                    </div>
                  </div>
                  @endif

                @elseif($booking->status == 'verifying')
                {{-- STATUS: VERIFIKASI --}}
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-2xl text-center">
                  <span class="flex items-center justify-center gap-1.5 text-blue-700 dark:text-blue-400 text-xs font-extrabold uppercase tracking-wide">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    Sedang Diverifikasi
                  </span>
                </div>

                @elseif($booking->status == 'active')
                {{-- STATUS: AKTIF --}}
                <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800 rounded-2xl text-center">
                  <span class="flex items-center justify-center gap-1.5 text-green-700 dark:text-green-400 text-xs font-extrabold uppercase tracking-wide">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                    Kelas Aktif
                  </span>
                </div>

                @else
                {{-- STATUS: DITOLAK --}}
                <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-2xl text-center">
                  <span class="flex items-center justify-center gap-1.5 text-red-700 dark:text-red-400 text-xs font-extrabold uppercase tracking-wide">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Ditolak
                  </span>
                </div>
                @endif
              </div>

              {{-- AKSI FORM --}}
              @if($booking->status == 'pending')
                @if($isGratis)
                  {{-- TOMBOL UNTUK PROGRAM GRATIS (TANPA UPLOAD FILE) --}}
                  <form action="{{ route('booking.confirm_free', $booking->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                      Konfirmasi Ikut Program
                    </button>
                  </form>
                @else
                  {{-- FORM UPLOAD UNTUK PROGRAM BERBAYAR --}}
                  <form action="{{ route('booking.upload', $booking->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="block mb-2 text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">Upload Bukti Transfer</label>
                    <input type="file" name="payment_proof" accept=".jpg,.jpeg,.png" required class="block w-full text-xs text-gray-500 file:mr-2 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-gray-100 dark:file:bg-gray-700 dark:file:text-gray-200 file:text-gray-600 cursor-pointer bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 transition">
                    <button type="submit" class="w-full mt-3 py-2.5 bg-gray-900 dark:bg-gray-700 text-white text-xs font-bold rounded-xl hover:bg-black dark:hover:bg-gray-600 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                      </svg>
                      Kirim Bukti
                    </button>
                  </form>
                @endif
              @endif
            </div>
            @empty
            {{-- Empty State --}}
            <div class="py-12 px-6 text-center">
              <div class="w-16 h-16 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400 dark:text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 0 0-.491 6.347A48.627 48.627 0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.905 59.905 0 0 1 12 3.493a59.902 59.902 0 0 1 10.499 5.216 50.59 50.59 0 0 0-2.658.813m-15.482 0A50.697 50.697 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                </svg>
              </div>
              <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Belum ada kelas yang didaftar.</p>
              <a href="{{ route('student.teachers.index') }}" class="text-green-600 dark:text-green-400 text-xs font-bold hover:underline mt-2 inline-flex items-center gap-1">
                Cari Guru Sekarang
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
              </a>
            </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>

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

      {{-- [BARU] CONTENT 2: AL-QURAN (UI/UX yang Disempurnakan - Mobile Touchable) --}}
<div x-show="activeTab === 'quran'" x-cloak
  x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="opacity-0 translate-y-4"
  x-transition:enter-end="opacity-100 translate-y-0">

  <div class="bg-white dark:bg-[#121824] rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-gray-800/60 transition-colors">

    {{-- Banner Utama (Dinamis: Pengingat Markah vs Default) --}}
    {{-- UX Note: Tambahkan cursor-pointer jika seluruh banner ingin dibuat bisa diklik di masa depan --}}
    <div class="bg-gradient-to-br from-emerald-600 to-teal-800 dark:from-emerald-800 dark:to-teal-900 rounded-[1.5rem] p-6 md:p-8 text-white relative overflow-hidden mb-8 group shadow-lg transition-transform duration-150 [webkit-tap-highlight-color:transparent]">

      {{-- Efek Ornamen Latar Belakang --}}
      <div class="absolute right-0 top-0 opacity-10 transition-transform duration-700 group-hover:scale-110 group-hover:-rotate-3 origin-top-right pointer-events-none">
        <svg class="w-48 h-48 md:w-64 md:h-64 -mt-10 -mr-10" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z" />
        </svg>
      </div>

      {{-- Gradient overlay untuk tekstur --}}
      <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent pointer-events-none"></div>

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

        {{-- Touchable Button Lanjutkan --}}
        <a href="{{ route('quran.show', $lastReadData['surat_nomor']) }}#ayat-{{ $lastReadData['ayat'] }}"
          class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-emerald-700 font-bold rounded-xl transition-all shadow-md active:scale-95 active:bg-yellow-50 transform hover:-translate-y-0.5 [webkit-tap-highlight-color:transparent] cursor-pointer">
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

        {{-- Touchable Button Mulai --}}
        <a href="{{ route('quran.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-emerald-700 font-bold rounded-xl transition-all shadow-md active:scale-95 active:bg-emerald-50 transform hover:-translate-y-0.5 w-full sm:w-auto [webkit-tap-highlight-color:transparent] cursor-pointer">
          Mulai Membaca <span aria-hidden="true">→</span>
        </a>
        @endif
      </div>
    </div>

    {{-- Section Label Pintasan --}}
    <div class="mb-4 flex items-center justify-between">
      <h4 class="font-bold text-gray-800 dark:text-white text-sm md:text-base">Surah Pilihan</h4>
      {{-- Touchable Link "Lihat Semua" --}}
      <a href="{{ route('quran.index') }}" class="text-xs font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1 group active:text-emerald-800 dark:active:text-emerald-300 [webkit-tap-highlight-color:transparent] p-1 -m-1 cursor-pointer">
        Lihat Semua
        <svg class="w-3 h-3 transition-transform group-hover:translate-x-1 group-active:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
      </a>
    </div>

    {{-- Grid Pintasan Surat (Touchable Cards) --}}
    {{-- Menambahkan utility class khusus mobile pada parent untuk mematikan default tap highlight --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 [webkit-tap-highlight-color:transparent]">
      {{-- Al-Kahfi --}}
      <a href="{{ route('quran.show', 18) }}" class="flex items-center justify-between p-4 md:p-5 rounded-2xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-[#1a2332] hover:border-emerald-500/50 hover:shadow-md transition-all duration-300 group active:scale-[0.97] active:bg-gray-50 dark:active:bg-[#1f293a] active:border-gray-200 dark:active:border-gray-700 cursor-pointer">
        <div class="flex items-center gap-4 pointer-events-none">
          <div class="w-11 h-11 rounded-full bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-extrabold text-sm border border-emerald-100 dark:border-emerald-800/50 transition-transform">18</div>
          <div>
            <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 transition-colors">Al-Kahfi</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Sunnah Jumat</p>
          </div>
        </div>
        <div class="text-2xl font-arab text-gray-300 dark:text-gray-600 transition-colors pointer-events-none">الكهف</div>
      </a>

      {{-- Yasin --}}
      <a href="{{ route('quran.show', 36) }}" class="flex items-center justify-between p-4 md:p-5 rounded-2xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-[#1a2332] hover:border-blue-500/50 hover:shadow-md transition-all duration-300 group active:scale-[0.97] active:bg-gray-50 dark:active:bg-[#1f293a] active:border-gray-200 dark:active:border-gray-700 cursor-pointer">
        <div class="flex items-center gap-4 pointer-events-none">
          <div class="w-11 h-11 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-extrabold text-sm border border-blue-100 dark:border-blue-800/50 transition-transform">36</div>
          <div>
            <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors">Yasin</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Harian</p>
          </div>
        </div>
        <div class="text-2xl font-arab text-gray-300 dark:text-gray-600 transition-colors pointer-events-none">يس</div>
      </a>

      {{-- Al-Mulk --}}
      <a href="{{ route('quran.show', 67) }}" class="flex items-center justify-between p-4 md:p-5 rounded-2xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-[#1a2332] hover:border-amber-500/50 hover:shadow-md transition-all duration-300 group active:scale-[0.97] active:bg-gray-50 dark:active:bg-[#1f293a] active:border-gray-200 dark:active:border-gray-700 cursor-pointer">
        <div class="flex items-center gap-4 pointer-events-none">
          <div class="w-11 h-11 rounded-full bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400 font-extrabold text-sm border border-amber-100 dark:border-amber-800/50 transition-transform">67</div>
          <div>
            <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-amber-600 transition-colors">Al-Mulk</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Sebelum Tidur</p>
          </div>
        </div>
        <div class="text-2xl font-arab text-gray-300 dark:text-gray-600 transition-colors pointer-events-none">الملك</div>
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
  {{-- ========================================== --}}
{{-- FLOATING AI CHAT WIDGET (EMERALD EDITION)  --}}
{{-- ========================================== --}}

<style>
  /* Scrollbar Custom */
  .chat-scrollbar::-webkit-scrollbar { width: 5px; }
  .chat-scrollbar::-webkit-scrollbar-track { background: transparent; }
  .chat-scrollbar::-webkit-scrollbar-thumb { background-color: #6ee7b7; border-radius: 10px; }
  .dark .chat-scrollbar::-webkit-scrollbar-thumb { background-color: #065f46; }
  .chat-scrollbar::-webkit-inner-spin-button,
  .chat-scrollbar::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }

  /* Perbaikan Responsivitas Mobile & Desktop */
  @media (max-width: 767px) {
      .chat-box-mobile-custom {
          position: fixed !important;
          inset: auto !important; /* Reset inset-0 */
          bottom: 5rem !important; /* Beri jarak di atas navbar bawah */
          right: 1rem !important;
          left: 1rem !important;
          width: auto !important;
          height: 70vh !important; /* Jangan full screen agar user tidak bingung */
          border-radius: 1.5rem !important;
          z-index: 9999 !important; /* Pastikan di atas segalanya */
      }
  }

  @media (min-width: 768px) {
      .chat-box-desktop-override {
          position: absolute !important;
          inset: auto !important;
          bottom: 4rem !important; 
          right: 0 !important; 
          width: 400px !important;
          height: 500px !important;
          max-height: 80vh !important;
          border-radius: 1rem !important; 
          z-index: 50 !important;
      }
  }
</style>

{{-- SCRIPT DIPISAH AGAR TIDAK MERUSAK HTML --}}
<script>
  function formatAiMessage(text) {
    if (!text) return '';
    let safeText = text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    let urlRegex = /(https?:\/\/[^\s]+)/g;
    return safeText.replace(urlRegex, '<a href="$1" target="_blank" class="text-emerald-600 dark:text-emerald-400 font-bold underline hover:opacity-75" title="Buka link di tab baru">$1</a>');
  }
</script>

<div x-data="{ 
          isOpen: false,
          query: '', 
          isLoading: false,
          messages: [], 
          
          scrollToBottom() {
              setTimeout(() => {
                  let chatBox = document.getElementById('ai-chat-response-box');
                  if(chatBox) chatBox.scrollTop = chatBox.scrollHeight;
              }, 100);
          },

          askAi() {
              if(!this.query.trim()) return;
              
              let currentQuery = this.query.trim();
              this.messages.push({ role: 'user', text: currentQuery });
              
              this.query = '';
              this.isLoading = true;
              this.scrollToBottom();
              
              fetch('{{ route('ai.ask') }}', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  },
                  body: JSON.stringify({ message: currentQuery })
              })
              .then(res => res.json())
              .then(data => {
                  if(data.success) {
                      this.messages.push({ role: 'ai', text: data.reply.trim() });
                  } else {
                      this.messages.push({ role: 'ai', text: 'Terjadi kesalahan: ' + data.error });
                  }
              })
              .catch(err => {
                  this.messages.push({ role: 'ai', text: 'Gagal menghubungi server AI. Pastikan internet stabil.' });
              })
              .finally(() => {
                  this.isLoading = false;
                  this.scrollToBottom();
              });
          }
      }"
  @click.outside="isOpen = false"
  class="fixed bottom-20 md:bottom-6 right-4 md:right-6 z-[60] font-sans">

  {{-- TOMBOL MENGAMBANG --}}
  <button @click="isOpen = !isOpen"
    class="bg-emerald-600 hover:bg-emerald-700 text-white p-4 rounded-full shadow-2xl transition-all duration-300 transform hover:scale-110 focus:outline-none flex items-center justify-center relative">
    <svg x-show="!isOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
    </svg>
    <svg x-show="isOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
    </svg>
    <span x-show="!isOpen" class="absolute top-0 right-0 block h-3 w-3 rounded-full bg-red-500 ring-2 ring-white animate-pulse"></span>
  </button>

  {{-- KOTAK CHAT UTAMA --}}
  <div x-show="isOpen"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-8 scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
    x-transition:leave-end="opacity-0 translate-y-8 scale-95"
    
    class="bg-white dark:bg-gray-800 shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col chat-box-mobile-custom chat-box-desktop-override origin-bottom-right">

    {{-- Header Kotak Chat --}}
    <div class="shrink-0 bg-gradient-to-r from-emerald-600 to-emerald-800 p-4 text-white flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="bg-white/20 p-2 rounded-lg">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
        </div>
        <div>
          <h3 class="font-bold text-sm">Asisten Cerdas</h3>
          <p class="text-[11px] text-emerald-100 opacity-90">Deep Quran Academy</p>
        </div>
      </div>
      
      {{-- Tombol Close Khusus HP --}}
      <button @click="isOpen = false" class="md:hidden p-2 bg-white/10 hover:bg-white/20 rounded-full transition-colors focus:outline-none">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>

    {{-- Area Scrollable (History Chat) --}}
    <div id="ai-chat-response-box" class="p-4 flex-1 overflow-y-auto chat-scrollbar bg-gray-50/50 dark:bg-gray-800/50 flex flex-col gap-4">

      {{-- Pesan Pembuka (Default) --}}
      <div x-show="messages.length === 0" class="text-center py-8 my-auto">
        <img src="https://cdn-icons-png.flaticon.com/512/8943/8943377.png" alt="AI Robot" class="w-16 h-16 mx-auto mb-3 opacity-80 mix-blend-multiply dark:mix-blend-normal">
        <p class="text-sm text-gray-500 dark:text-gray-400">Halo! Ada yang bisa saya bantu terkait aplikasi ini?</p>
      </div>

      {{-- Looping Pesan --}}
      <template x-for="(msg, index) in messages" :key="index">
        <div class="flex w-full" :class="msg.role === 'user' ? 'justify-end' : 'justify-start'">

          {{-- Gelembung Chat AI (Kiri) --}}
          <div x-show="msg.role === 'ai'"
            x-html="formatAiMessage(msg.text)"
            class="max-w-[85%] bg-white dark:bg-gray-700 px-3.5 py-2.5 rounded-2xl rounded-tl-none shadow-sm border border-transparent dark:border-gray-600 text-[13px] text-gray-700 dark:text-gray-200 whitespace-pre-line leading-snug break-words"></div>

          {{-- Gelembung Chat User (Kanan) --}}
          <div x-show="msg.role === 'user'"
            x-html="formatAiMessage(msg.text)"
            class="max-w-[85%] bg-emerald-600 px-3.5 py-2.5 rounded-2xl rounded-tr-none shadow-sm text-[13px] text-white whitespace-pre-line leading-snug break-words"></div>

        </div>
      </template>

      {{-- Status Loading --}}
      <div x-show="isLoading" class="flex w-full justify-start">
        <div class="max-w-[85%] bg-white dark:bg-gray-700 p-4 rounded-2xl rounded-tl-none shadow-sm border border-transparent dark:border-gray-600 flex items-center space-x-2">
          <div class="w-2 h-2 bg-emerald-500 rounded-full animate-bounce" style="animation-delay: -0.3s"></div>
          <div class="w-2 h-2 bg-emerald-500 rounded-full animate-bounce" style="animation-delay: -0.15s"></div>
          <div class="w-2 h-2 bg-emerald-500 rounded-full animate-bounce"></div>
        </div>
      </div>

    </div>

    {{-- Area Input Pertanyaan --}}
    <div class="shrink-0 p-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 pb-safe">
      <div class="relative flex items-end gap-2">

        <textarea
          x-model="query"
          @keydown.enter.prevent="askAi()"
          rows="1"
          class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl py-3 px-4 text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 resize-none max-h-24 overflow-y-auto"
          placeholder="Ketik pesan..."
          style="min-height: 44px;"
          x-on:input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"></textarea>

        <button @click="askAi()" :disabled="isLoading || !query.trim()"
          class="flex-shrink-0 w-11 h-11 bg-emerald-600 text-white rounded-full flex items-center justify-center hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors shadow-sm mb-0.5">
          <svg class="w-5 h-5 transform translate-x-[-1px] translate-y-[1px] rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
          </svg>
        </button>
      </div>
      <p class="text-[10px] text-gray-400 text-center mt-2 px-4 pb-2 md:pb-0">AI dapat membuat kesalahan. Selalu periksa informasi penting.</p>
    </div>

  </div>
</div>

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

</x-student-layout>