<x-layout>
  <x-slot:title>Program Tahfidz Dewasa - Deep Quran Academy</x-slot:title>

  {{-- SOLUSI FINAL: Mengunci sumbu X dari Body secara global agar AOS tidak melebarkan layar, tanpa membuat double scrollbar --}}
  <style>
    html,
    body {
      overflow-x: hidden !important;
    }
  </style>

  {{-- 1. HERO SECTION (Specific for Tahfidz) --}}
  <section class="relative pt-32 pb-20 md:pt-40 md:pb-32 bg-gradient-to-br from-green-900 via-green-800 to-green-600 overflow-hidden">
    {{-- Background Elements --}}
   <div class="absolute inset-0 opacity-20 mix-blend-overlay" style="background-image: url('{{ asset('arabesque.png') }}');"></div>
    {{-- Blob position adjusted for variety --}}
    <div class="absolute top-20 left-0 w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-green-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>

    <div class="container max-w-7xl mx-auto px-4 md:px-6 relative z-10">
      <div class="flex flex-col md:flex-row items-center gap-12">
        {{-- Text Content --}}
        <div class="w-full md:w-1/2 text-white" data-aos="fade-right">
          <div class="inline-flex items-center gap-2 px-3 py-1 mb-6 bg-green-800/50 border border-green-700 rounded-full backdrop-blur-md">
            <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
            <span class="text-xs font-semibold capitalize tracking-wider text-green-100">Program Hafalan Dewasa</span>
          </div>

          <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
            Wujudkan Mimpi Menjadi <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-500">Penghafal Al-Qur'an</span>
          </h1>

          <p class="text-lg text-green-100/90 mb-8 leading-relaxed font-light">
            Tidak ada kata terlambat. Metode menghafal khusus usia dewasa yang santai, fleksibel, dan fokus pada penguatan hafalan (Murojaah) tanpa beban target yang memberatkan.
          </p>

          <div class="flex flex-col sm:flex-row gap-4">
            {{-- Tombol 1: Mulai Menghafal --}}
            <a href="#daftar"
              class="px-8 py-4 bg-yellow-500 text-green-900 font-bold rounded-full shadow-lg text-center
              transition-all duration-300
              hover:bg-yellow-400 hover:shadow-xl hover:-translate-y-1 
              active:bg-yellow-600 active:shadow-none active:translate-y-0 active:scale-95">
              Mulai Menghafal
            </a>

            {{-- Tombol 2: Lihat Metode --}}
            <a href="#metode"
              class="px-8 py-4 bg-transparent border border-white/30 text-white font-semibold rounded-full text-center 
              transition-all duration-300
              hover:bg-white/10 hover:border-white 
              active:bg-white/20 active:border-white active:scale-95">
              Lihat Metode
            </a>
          </div>
        </div>

        {{-- Image Content --}}
        <div class="w-full md:w-1/2 flex justify-center relative" data-aos="fade-left">
          <div class="relative w-full max-w-md aspect-square bg-gradient-to-tr from-green-800 to-green-600 rounded-[2rem] p-2 shadow-2xl border border-white/10">
            {{-- GANTI GAMBAR: Orang dewasa sedang menghafal/memegang Quran --}}
            <img src="{{ asset('images/tahsin.webp') }}"
              alt="Tahfidz Dewasa"
              class="w-full h-full object-cover rounded-[1.8rem] opacity-90 grayscale-[20%] hover:grayscale-0 transition duration-500">

            {{-- Floating Card --}}
            <div class="absolute -bottom-6 -right-6 bg-white p-4 rounded-xl shadow-xl flex items-center gap-4 animate-bounce-slow max-w-xs">
              <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
              </div>
              <div>
                <p class="text-xs text-gray-500">Target Fleksibel</p>
                <p class="font-bold text-gray-800 text-sm">Setoran Semampunya</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- 2. PROBLEM AGITATION (Specific to Memorization) --}}
  <section class="py-16 bg-white">
    <div class="container max-w-6xl mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Tantangan Menghafal di Usia Dewasa</h2>
        <p class="text-gray-500 max-w-2xl mx-auto">Kami mengerti bahwa menghafal di usia dewasa memiliki tantangan tersendiri dibandingkan anak-anak.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- Point 1: Daya Ingat --}}
        <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group" data-aos="fade-up" data-aos-delay="0">
          <div class="w-14 h-14 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-red-500 group-hover:text-white transition-colors duration-300">
            {{-- Icon: Brain / Memory Fade --}}
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
          </div>
          <h3 class="font-bold text-xl text-gray-800 mb-3">Merasa "Faktor U"</h3>
          <p class="text-sm text-gray-500 leading-relaxed">
            Merasa daya ingat sudah menurun, sulit menangkap hafalan baru, dan mudah lupa hafalan lama (cepat masuk, cepat keluar).
          </p>
        </div>

        {{-- Point 2: Waktu --}}
        <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group" data-aos="fade-up" data-aos-delay="100">
          <div class="w-14 h-14 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-orange-500 group-hover:text-white transition-colors duration-300">
            {{-- Icon: Clock / Busy --}}
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h3 class="font-bold text-xl text-gray-800 mb-3">Sulit Istiqomah</h3>
          <p class="text-sm text-gray-500 leading-relaxed">
            Kesibukan kerja dan urusan rumah tangga membuat jadwal setoran sering bolong-bolong, akhirnya motivasi hilang di tengah jalan.
          </p>
        </div>

        {{-- Point 3: Target Beban --}}
        <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group" data-aos="fade-up" data-aos-delay="200">
          <div class="w-14 h-14 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300">
            {{-- Icon: Scale / Balance --}}
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
            </svg>
          </div>
          <h3 class="font-bold text-xl text-gray-800 mb-3">Terbebani Target</h3>
          <p class="text-sm text-gray-500 leading-relaxed">
            Trauma dengan metode menghafal anak-anak yang menuntut setoran banyak setiap hari. Anda butuh ritme yang lebih santai namun pasti.
          </p>
        </div>

      </div>
    </div>
  </section>

  {{-- 3. CURRICULUM LEVELS (Tahfidz Levels) --}}
  <section id="metode" class="py-16 bg-green-50 border-y border-green-100">
    <div class="container max-w-7xl mx-auto px-4">
      <div class="text-center mb-16">
        <span class="text-green-600 font-bold text-xs uppercase tracking-wider px-3 py-1 bg-white rounded-full inline-block mb-4 shadow-sm">Roadmap Hafalan</span>
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Pilihan Program Hafalan</h2>
        <p class="text-gray-500 mt-4">Pilih target hafalan sesuai kemampuan dan kebutuhan ibadah Anda.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">

        {{-- Level 1: Juz Amma --}}
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative group hover:-translate-y-2 transition duration-300 h-full" data-aos="fade-up" data-aos-delay="0">
          <div class="w-16 h-16 bg-green-600 text-white rounded-2xl flex items-center justify-center text-2xl font-bold mb-6 shadow-lg shadow-green-200 mx-auto md:mx-0">1</div>
          <h3 class="text-xl font-bold text-gray-800 mb-3 text-center md:text-left">Program Juz 30</h3>
          <p class="text-gray-500 text-sm mb-4 text-center md:text-left">Target awal untuk menyempurnakan shalat.</p>
          <ul class="space-y-3 text-sm text-gray-600 border-t border-gray-100 pt-4">
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Menghafal An-Naba s.d. An-Nas</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Fokus pada kualitas bacaan (Tahsin)</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Tadabbur makna ayat pendek</li>
          </ul>
        </div>

        {{-- Level 2: Surah Pilihan --}}
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative group hover:-translate-y-2 transition duration-300 h-full" data-aos="fade-up" data-aos-delay="100">
          <div class="w-16 h-16 bg-yellow-400 text-green-900 rounded-2xl flex items-center justify-center text-2xl font-bold mb-6 shadow-lg shadow-yellow-100 mx-auto md:mx-0">2</div>
          <h3 class="text-xl font-bold text-gray-800 mb-3 text-center md:text-left">Surah Pilihan</h3>
          <p class="text-gray-500 text-sm mb-4 text-center md:text-left">Menghafal surah-surah populer (Fadhilah).</p>
          <ul class="space-y-3 text-sm text-gray-600 border-t border-gray-100 pt-4">
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Al-Mulk, Yasin, Al-Waqiah, Al-Kahfi</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Ar-Rahman & As-Sajdah</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Memahami keutamaan surah</li>
          </ul>
        </div>

        {{-- Level 3: 30 Juz --}}
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative group hover:-translate-y-2 transition duration-300 h-full" data-aos="fade-up" data-aos-delay="200">
          <div class="w-16 h-16 bg-green-800 text-white rounded-2xl flex items-center justify-center text-2xl font-bold mb-6 shadow-lg shadow-green-200 mx-auto md:mx-0">3</div>
          <h3 class="text-xl font-bold text-gray-800 mb-3 text-center md:text-left">Program 30 Juz</h3>
          <p class="text-gray-500 text-sm mb-4 text-center md:text-left">Lanjutan bagi yang sudah memiliki dasar kuat.</p>
          <ul class="space-y-3 text-sm text-gray-600 border-t border-gray-100 pt-4">
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Target Ziyadah (Tambah) harian</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Sistem Murojaah (Ulang) terpola</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Ujian per Juz (Tasmi')</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  {{-- 4. HASIL BELAJAR (Output) --}}
  <section class="py-16 bg-white">
    <div class="container max-w-6xl mx-auto px-4">
      <div class="flex flex-col md:flex-row items-center gap-12">

        {{-- Left Content --}}
        <div class="w-full md:w-1/2" data-aos="fade-right">
          <h2 class="text-3xl font-bold text-gray-900 mb-6">Metode Menghafal Kami</h2>
          <p class="text-gray-600 mb-8 leading-relaxed">
            Kami tidak menggunakan metode "kebut semalam". Kami menggunakan pendekatan yang ramah otak dewasa, mengutamakan pemahaman dan pengulangan.
          </p>

          <div class="space-y-6">
            <div class="flex gap-4">
              <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-gray-800">Tikrar (Repetisi)</h4>
                <p class="text-sm text-gray-500 mt-1">Teknik pengulangan ayat minimal 20-40x sebelum berpindah, agar hafalan menempel kuat di ingatan jangka panjang.</p>
              </div>
            </div>
            <div class="flex gap-4">
              <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-gray-800">Fahm (Pemahaman)</h4>
                <p class="text-sm text-gray-500 mt-1">Menghafal sambil memahami arti per kata. Jauh lebih mudah menghafal apa yang kita mengerti maknanya.</p>
              </div>
            </div>
            <div class="flex gap-4">
              <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-gray-800">Kunci Murojaah</h4>
                <p class="text-sm text-gray-500 mt-1">Guru akan membuatkan jadwal "Murojaah" pribadi agar hafalan lama tidak hilang saat menambah hafalan baru.</p>
              </div>
            </div>
          </div>
        </div>

        {{-- Right Content (CTA Box) --}}
        <div class="w-full md:w-1/2" data-aos="fade-left">
          <div class="bg-gray-900 rounded-3xl p-8 text-center text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-green-500 rounded-full blur-3xl opacity-20"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-yellow-500 rounded-full blur-3xl opacity-20"></div>

            <h3 class="text-2xl font-bold mb-4 relative z-10">Mulai Satu Ayat Hari Ini</h3>
            <p class="text-gray-300 mb-8 text-sm relative z-10">
              "Sebaik-baik kalian adalah yang mempelajari Al-Qur'an dan mengajarkannya." <br> Konsultasikan program hafalan yang cocok untuk kesibukan Anda.
            </p>

            <div class="flex flex-col gap-3 relative z-10">
              <a href="https://wa.me/6285860913931?text=Halo%20Admin,%20saya%20tertarik%20program%20Tahfidz%20Dewasa" target="_blank" class="w-full py-3 bg-green-500 text-white font-bold rounded-xl flex items-center justify-center gap-2 
       transition-all duration-300
       hover:bg-green-400 
       active:bg-green-600 active:scale-95">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                </svg>
                Konsultasi via WhatsApp
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- 5. PRICING / PAKET BELAJAR (Tahfidz Version) --}}
  <section id="daftar" class="py-16 md:py-24 bg-white border-t border-gray-100">
    <div class="container max-w-6xl mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900">Infaq Program Tahfidz</h2>
        <p class="text-gray-500 mt-2">Pilih metode setoran hafalan yang paling cocok untuk Anda.</p>
      </div>

      {{-- [DIPERBARUI] Grid diubah menjadi lg:grid-cols-3 agar memuat 3 kotak --}}
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        {{-- PAKET 1: ONLINE (ZOOM) --}}
        <div class="border border-gray-200 rounded-3xl p-8 hover:border-green-400 transition duration-300 relative overflow-hidden group bg-white shadow-sm" data-aos="fade-up" data-aos-delay="0">
          {{-- Badge --}}
          <div class="absolute top-0 right-0 bg-green-100 text-green-800 text-xs font-bold px-4 py-1.5 rounded-bl-2xl uppercase tracking-wider z-10">
            Online
          </div>

          <h3 class="text-xl font-bold text-gray-800">Halaqah Online</h3>
          <p class="text-sm text-gray-500 mt-2">Menghafal dari rumah via Zoom/GMeet.</p>

          <div class="my-6">
            <span class="text-4xl font-extrabold text-gray-900">Rp 100.000</span>
            <div class="text-xs text-gray-500 font-medium mt-1">Per Peserta / Bulan</div>
          </div>

          <ul class="space-y-4 mb-8 text-sm text-gray-600">
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
              </svg>
              <strong>Maksimal 10 Peserta</strong> (Kelompok)
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              4-8x Pertemuan / Bulan
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
              </svg>
              Interaktif Video Call
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Setoran Hafalan & Murojaah
            </li>
          </ul>

          <a href="/login?mode=register"
            class="block w-full py-3 text-center border-2 border-green-600 text-green-700 font-bold rounded-xl 
          transition-all duration-200
          hover:bg-green-50 hover:text-green-800
          active:bg-green-100 active:text-green-900 active:border-green-800 active:scale-95">
            Daftar Online
          </a>
        </div>

        {{-- PAKET 2: OFFLINE / HOME VISIT --}}
        <div class="border-2 border-yellow-400 rounded-3xl p-8 relative bg-yellow-50/20 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
          {{-- Badge --}}
          <div class="absolute top-0 right-0 bg-yellow-400 text-green-900 text-xs font-bold px-4 py-1.5 rounded-bl-2xl uppercase tracking-wider z-10">
            Offline / Visit
          </div>

          <h3 class="text-xl font-bold text-gray-800">Halaqah Offline</h3>
          <p class="text-sm text-gray-500 mt-2">Guru datang ke lokasi kelompok / markaz.</p>

          <div class="my-6">
            <span class="text-4xl font-extrabold text-gray-900">Rp 150.000</span>
            <div class="text-xs text-gray-500 font-medium mt-1">Per Peserta / Bulan</div>
          </div>

          <ul class="space-y-4 mb-8 text-sm text-gray-600">
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
              </svg>
              <strong>Maksimal 10 Peserta</strong> (Kelompok)
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              4-8x Pertemuan / Bulan
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
              Tatap Muka Langsung (Talaqqi)
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Koreksi Bacaan Lebih Detail
            </li>
          </ul>

          <a href="/login?mode=register"
            class="block w-full py-3 text-center bg-green-600 text-white font-bold rounded-xl shadow-lg 
          transition-all duration-300
          hover:bg-green-700 hover:shadow-xl hover:-translate-y-1 
          active:bg-green-800 active:shadow-none active:translate-y-0 active:scale-95">
            Daftar Offline
          </a>
        </div>

        {{-- [BARU] PAKET 3: KELAS PRIVATE --}}
        <div class="border border-gray-200 rounded-3xl p-8 hover:border-blue-400 transition duration-300 relative overflow-hidden group bg-white shadow-sm" data-aos="fade-up" data-aos-delay="200">
          {{-- Badge --}}
          <div class="absolute top-0 right-0 bg-blue-100 text-blue-800 text-xs font-bold px-4 py-1.5 rounded-bl-2xl uppercase tracking-wider z-10">
            Private / 1-on-1
          </div>

          <h3 class="text-xl font-bold text-gray-800">Kelas Private</h3>
          <p class="text-sm text-gray-500 mt-2">Setoran hafalan 1 Guru 1 Murid secara privat.</p>

          <div class="my-6">
            <span class="text-2xl font-extrabold text-gray-900 leading-tight">Diskusikan <br>dengan kami</span>
            <div class="text-xs text-gray-500 font-medium mt-2">Biaya & Jadwal Fleksibel</div>
          </div>

          <ul class="space-y-4 mb-8 text-sm text-gray-600">
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              <strong>1 Guru 1 Murid</strong> (Fokus Penuh)
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              Target Hafalan Custom
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
              </svg>
              Bisa Online maupun Offline
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Waktu Setoran Fleksibel
            </li>
          </ul>

          <a href="https://wa.me/6281564977591" target="_blank"
            class="block w-full py-3 text-center border-2 border-blue-600 text-blue-700 font-bold rounded-xl 
          transition-all duration-200
          hover:bg-blue-50 hover:text-blue-800
          active:bg-blue-100 active:text-blue-900 active:border-blue-800 active:scale-95">
            Konsultasi Sekarang
          </a>
        </div>

      </div>

      {{-- Catatan Kaki --}}
      <div class="mt-12 text-center bg-green-50 p-4 rounded-xl border border-green-100 max-w-3xl mx-auto">
        <p class="text-sm text-gray-600">
          <span class="font-bold text-green-700">Info Pembentukan Kelompok:</span> <br>
          Anda bisa mendaftar sendiri (kami yang carikan kelompok) atau mendaftar kolektif bersama teman/keluarga (minimal 5 orang) untuk membentuk 1 kelompok khusus.
        </p>
      </div>
    </div>
  </section>

  {{-- 6. FAQ SINGKAT --}}
  <section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="container max-w-3xl mx-auto px-4" x-data="{ active: null }">
      <h2 class="text-2xl font-bold text-gray-900 text-center mb-8">Pertanyaan Umum</h2>

      <div class="space-y-3">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <button @click="active = (active === 1 ? null : 1)" class="w-full text-left px-6 py-4 font-semibold flex justify-between items-center text-gray-800">
            Apakah harus lancar baca dulu?
            <span x-text="active === 1 ? '-' : '+'" class="text-xl"></span>
          </button>
          <div x-show="active === 1" class="px-6 pb-4 text-gray-600 text-sm">
            Idealnya iya, agar hafalan tidak salah panjang-pendeknya. Jika bacaan masih terbata-bata, kami sarankan mengambil program <a href="{{ route('program.tahsin-dewasa') }}" class="text-green-600 underline">Tahsin Dewasa</a> terlebih dahulu atau program <i>bundling</i> (Tahsin + Tahfidz).
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <button @click="active = (active === 2 ? null : 2)" class="w-full text-left px-6 py-4 font-semibold flex justify-between items-center text-gray-800">
            Apakah wajib hafal 30 Juz?
            <span x-text="active === 2 ? '-' : '+'" class="text-xl"></span>
          </button>
          <div x-show="active === 2" class="px-6 pb-4 text-gray-600 text-sm">
            Tidak wajib. Untuk program dewasa, kami sangat fleksibel. Anda bisa menargetkan Juz 30 saja, atau surah-surah pilihan (Al-Mulk, Yasin, Al-Kahfi) sesuai kebutuhan ibadah harian.
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <button @click="active = (active === 3 ? null : 3)" class="w-full text-left px-6 py-4 font-semibold flex justify-between items-center text-gray-800">
            Metode belajarnya Online atau Offline?
            <span x-text="active === 3 ? '-' : '+'" class="text-xl"></span>
          </button>
          <div x-show="active === 3" class="px-6 pb-4 text-gray-600 text-sm">
            Bisa keduanya. Online via Zoom/GMeet (sangat populer untuk pekerja) atau Offline (Home Visit) jika domisili Anda terjangkau oleh guru kami.
          </div>
        </div>
      </div>
    </div>
  </section>

  </div> {{-- PENUTUP MASTER WRAPPER --}}
</x-layout>