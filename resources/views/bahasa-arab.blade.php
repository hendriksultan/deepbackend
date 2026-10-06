<x-layout>
  <x-slot name="title">Kelas Bahasa Arab Pemula - Deep Quran Academy</x-slot>

  {{-- 1. HERO SECTION --}}
  {{-- [Sudah ada overflow-hidden bawaan, jadi aman dari animasi AOS] --}}
  <section class="relative pt-32 pb-20 md:pt-40 md:pb-32 bg-gradient-to-br from-green-900 via-green-800 to-green-600 overflow-hidden">
    {{-- Background Elements --}}
    <div class="absolute inset-0 opacity-20 mix-blend-overlay" style="background-image: url('{{ asset('arabesque.png') }}');"></div>
    <div class="absolute top-20 left-0 w-80 h-80 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>

    <div class="container max-w-7xl mx-auto px-4 md:px-6 relative z-10">
      <div class="flex flex-col md:flex-row items-center gap-12">
        {{-- Text Content --}}
        <div class="w-full md:w-1/2 text-white" data-aos="fade-right">
          <div class="inline-flex items-center gap-2 px-3 py-1 mb-6 bg-green-800/50 border border-green-700 rounded-full backdrop-blur-md">
            <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
            <span class="text-xs font-semibold capitalize tracking-wider text-green-100">Pemula (Nol) s.d Lanjutan</span>
          </div>

          <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
            Pegang Kunci <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-500">Memahami Al-Qur'an</span>
          </h1>

          <p class="text-lg text-green-100/90 mb-8 leading-relaxed font-light">
            Belajar Bahasa Arab tidak sesulit yang dibayangkan. Mulai dari nol, pahami kosakata dasar, hingga mampu menerjemahkan ayat dan percakapan ringan.
          </p>

          <div class="flex flex-col sm:flex-row gap-4">
            <a href="#daftar" class="px-8 py-4 bg-yellow-500 text-green-900 font-bold rounded-full shadow-lg hover:bg-yellow-400 hover:-translate-y-1 transition-all duration-300 text-center">
              Daftar Kelas
            </a>
            <a href="#kurikulum" class="px-8 py-4 bg-transparent border border-white/30 text-white font-semibold rounded-full hover:bg-white/10 hover:border-white transition-all duration-300 text-center">
              Lihat Materi
            </a>
          </div>
        </div>

        {{-- Image Content --}}
        <div class="w-full md:w-1/2 flex justify-center relative" data-aos="fade-left">
          <div class="relative w-full max-w-md aspect-square bg-gradient-to-tr from-green-800 to-green-600 rounded-[2rem] p-2 shadow-2xl border border-white/10">
            {{-- Gambar: Buku Bahasa Arab / Suasana Belajar --}}
            <img src="{{ asset('images/arab.webp') }}"
              alt="Belajar Bahasa Arab"
              class="w-full h-full object-cover rounded-[1.8rem] opacity-90 grayscale-[20%] hover:grayscale-0 transition duration-500">

            {{-- Floating Card --}}
            <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-xl flex items-center gap-4 animate-bounce-slow max-w-xs">
              <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                </svg>
              </div>
              <div>
                <p class="text-xs text-gray-500">Target Utama</p>
                <p class="font-bold text-gray-800 text-sm">Faham Arti Bacaan Shalat</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- 2. PROBLEM AGITATION --}}
  <section class="py-16 bg-white">
    <div class="container max-w-6xl mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Mengapa Banyak yang Gagal?</h2>
        <p class="text-gray-500 max-w-2xl mx-auto">Bahasa Arab sering dianggap "momok" karena metode yang kurang tepat bagi pemula.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Point 1 --}}
        <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group" data-aos="fade-up" data-aos-delay="0">
          <div class="w-14 h-14 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-red-500 group-hover:text-white transition-colors duration-300">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
          </div>
          <h3 class="font-bold text-xl text-gray-800 mb-3">Terjebak Rumus</h3>
          <p class="text-sm text-gray-500 leading-relaxed">
            Langsung disuguhi rumus Nahwu (Tata Bahasa) yang rumit di awal, sehingga merasa pusing sebelum merasakan manisnya bahasa.
          </p>
        </div>

        {{-- Point 2 --}}
        <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group" data-aos="fade-up" data-aos-delay="100">
          <div class="w-14 h-14 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-orange-500 group-hover:text-white transition-colors duration-300">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
          </div>
          <h3 class="font-bold text-xl text-gray-800 mb-3">Minim Praktik</h3>
          <p class="text-sm text-gray-500 leading-relaxed">
            Hanya menghafal teori tapi tidak pernah dipraktikkan untuk membaca, mendengar (Istima'), atau berbicara (Kalam).
          </p>
        </div>

        {{-- Point 3 --}}
        <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group" data-aos="fade-up" data-aos-delay="200">
          <div class="w-14 h-14 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
          </div>
          <h3 class="font-bold text-xl text-gray-800 mb-3">Tidak Punya Partner</h3>
          <p class="text-sm text-gray-500 leading-relaxed">
            Bahasa adalah kebiasaan. Tanpa lingkungan atau teman untuk berlatih (Lawan Bicara), kemampuan bahasa akan cepat hilang.
          </p>
        </div>
      </div>
    </div>
  </section>

  {{-- 3. CURRICULUM LEVELS --}}
  <section id="kurikulum" class="py-16 bg-green-50 border-y border-green-100">
    <div class="container max-w-7xl mx-auto px-4">
      <div class="text-center mb-16">
        <span class="text-green-600 font-bold text-xs uppercase tracking-wider px-3 py-1 bg-white rounded-full inline-block mb-4 shadow-sm">Roadmap Belajar</span>
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tahapan Penguasaan</h2>
        <p class="text-gray-500 mt-4">Kami menggunakan metode yang ramah otak, bertahap dari yang termudah.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
        {{-- Level 1 --}}
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative group hover:-translate-y-2 transition duration-300 h-full" data-aos="fade-up" data-aos-delay="0">
          <div class="w-16 h-16 bg-green-600 text-white rounded-2xl flex items-center justify-center text-2xl font-bold mb-6 shadow-lg shadow-green-200 mx-auto md:mx-0">1</div>
          <h3 class="text-xl font-bold text-gray-800 mb-3 text-center md:text-left">Kelas Pemula (Dasar)</h3>
          <p class="text-gray-500 text-sm mb-4 text-center md:text-left">Untuk yang belum pernah belajar sama sekali.</p>
          <ul class="space-y-3 text-sm text-gray-600 border-t border-gray-100 pt-4">
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Penguasaan Kosakata Harian</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Perkenalan Diri (Ta'aruf)</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Kata Tunjuk & Kata Ganti Dasar</li>
          </ul>
        </div>

        {{-- Level 2 --}}
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative group hover:-translate-y-2 transition duration-300 h-full" data-aos="fade-up" data-aos-delay="100">
          <div class="w-16 h-16 bg-yellow-400 text-green-900 rounded-2xl flex items-center justify-center text-2xl font-bold mb-6 shadow-lg shadow-yellow-100 mx-auto md:mx-0">2</div>
          <h3 class="text-xl font-bold text-gray-800 mb-3 text-center md:text-left">Kelas Menengah</h3>
          <p class="text-gray-500 text-sm mb-4 text-center md:text-left">Mulai masuk ke susunan kalimat.</p>
          <ul class="space-y-3 text-sm text-gray-600 border-t border-gray-100 pt-4">
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Kalimat Ismiyah & Fi'liyah</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Percakapan Harian (Hiwar)</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Latihan Membaca Teks Pendek</li>
          </ul>
        </div>

        {{-- Level 3 --}}
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative group hover:-translate-y-2 transition duration-300 h-full" data-aos="fade-up" data-aos-delay="200">
          <div class="w-16 h-16 bg-green-800 text-white rounded-2xl flex items-center justify-center text-2xl font-bold mb-6 shadow-lg shadow-green-200 mx-auto md:mx-0">3</div>
          <h3 class="text-xl font-bold text-gray-800 mb-3 text-center md:text-left">Kelas Lanjutan</h3>
          <p class="text-gray-500 text-sm mb-4 text-center md:text-left">Fokus pada terjemah Al-Qur'an.</p>
          <ul class="space-y-3 text-sm text-gray-600 border-t border-gray-100 pt-4">
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Bedah Ayat & Hadits Pilihan</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Dasar Nahwu Sharaf Terapan</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Memahami Bacaan Shalat</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  {{-- 4. HASIL BELAJAR (Output) --}}
  {{-- [PERBAIKAN]: Tambah overflow-x-hidden --}}
  <section class="py-16 bg-white overflow-x-hidden">
    <div class="container max-w-6xl mx-auto px-4">
      <div class="flex flex-col md:flex-row items-center gap-12">
        <div class="w-full md:w-1/2" data-aos="fade-right">
          <h2 class="text-3xl font-bold text-gray-900 mb-6">Manfaat Belajar Bahasa Arab</h2>
          <p class="text-gray-600 mb-8 leading-relaxed">
            Bahasa Arab bukan sekadar alat komunikasi, tapi kunci untuk membuka gudang ilmu Islam dan menikmati keindahan Al-Qur'an.
          </p>

          <div class="space-y-6">
            <div class="flex gap-4">
              <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-gray-800">Shalat Lebih Khusyu'</h4>
                <p class="text-sm text-gray-500 mt-1">Mengerti apa yang dibaca saat berdiri, ruku', dan sujud, sehingga hati lebih hadir saat beribadah.</p>
              </div>
            </div>
            <div class="flex gap-4">
              <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-gray-800">Akrab dengan Al-Qur'an</h4>
                <p class="text-sm text-gray-500 mt-1">Tidak lagi sekadar membaca bunyi, tapi mulai menangkap pesan dan makna yang terkandung di dalamnya.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="w-full md:w-1/2" data-aos="fade-left">
          <div class="bg-gray-900 rounded-3xl p-8 text-center text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-green-500 rounded-full blur-3xl opacity-20"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-yellow-500 rounded-full blur-3xl opacity-20"></div>

            <h3 class="text-2xl font-bold mb-4 relative z-10">Mulai dari Kata Pertama</h3>
            <p class="text-gray-300 mb-8 text-sm relative z-10">
              "Pelajarilah bahasa Arab, karena sesungguhnya ia adalah bagian dari agama kalian." (Umar bin Khattab RA)
            </p>

            <div class="flex flex-col gap-3 relative z-10">
              <a href="https://wa.me/6285860913931?text=Halo%20Admin,%20saya%20tertarik%20program%20Bahasa%20Arab" target="_blank" class="w-full py-3 bg-green-500 hover:bg-green-400 text-white font-bold rounded-xl transition duration-300 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                </svg>
                Konsultasi dengan Admin
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

 {{-- 5. PRICING (Standardized) - Bahasa Arab --}}
  <section id="daftar" class="py-16 md:py-24 bg-white border-t border-gray-100 overflow-x-hidden">
    <div class="container max-w-6xl mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900">Infaq Kelas Bahasa Arab</h2>
        <p class="text-gray-500 mt-2">Pilih metode belajar bahasa Arab yang paling pas untuk Anda.</p>
      </div>

      {{-- Grid diubah menjadi lg:grid-cols-3 agar memuat 3 paket --}}
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        {{-- PAKET 1: ONLINE --}}
        <div class="border border-gray-200 rounded-3xl p-8 hover:border-green-400 transition duration-300 relative overflow-hidden group bg-white shadow-sm" data-aos="fade-up" data-aos-delay="0">
          <div class="absolute top-0 right-0 bg-green-100 text-green-800 text-xs font-bold px-4 py-1.5 rounded-bl-2xl uppercase tracking-wider z-10">
            Online
          </div>

          <h3 class="text-xl font-bold text-gray-800">Kelas Online</h3>
          <p class="text-sm text-gray-500 mt-2">Belajar interaktif dari rumah via Zoom.</p>

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
              8x Pertemuan / Bulan
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
              </svg>
              Materi PDF & Modul
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Praktik Percakapan (Hiwar)
            </li>
          </ul>

          <a href="/login?mode=register" class="block w-full py-3 text-center border-2 border-green-600 text-green-700 font-bold rounded-xl hover:bg-green-50 active:scale-95 transition-all duration-200">
            Daftar Online
          </a>
        </div>

        {{-- PAKET 2: OFFLINE --}}
        <div class="border-2 border-yellow-400 rounded-3xl p-8 relative bg-yellow-50/20 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
          <div class="absolute top-0 right-0 bg-yellow-400 text-green-900 text-xs font-bold px-4 py-1.5 rounded-bl-2xl uppercase tracking-wider z-10">
            Offline / Visit
          </div>

          <h3 class="text-xl font-bold text-gray-800">Kelas Offline</h3>
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
              8x Pertemuan / Bulan
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
              </svg>
              Bedah Buku & Praktik
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Koreksi Langsung (Talaqqi)
            </li>
          </ul>

          <a href="/login?mode=register" class="block w-full py-3 text-center bg-green-600 text-white font-bold rounded-xl shadow-lg hover:bg-green-700 hover:-translate-y-1 active:scale-95 transition-all duration-300">
            Daftar Offline
          </a>
        </div>

        {{-- PAKET 3: KELAS PRIVATE --}}
        <div class="border border-gray-200 rounded-3xl p-8 hover:border-blue-400 transition duration-300 relative overflow-hidden group bg-white shadow-sm" data-aos="fade-up" data-aos-delay="200">
          <div class="absolute top-0 right-0 bg-blue-100 text-blue-800 text-xs font-bold px-4 py-1.5 rounded-bl-2xl uppercase tracking-wider z-10">
            Private / 1-on-1
          </div>

          <h3 class="text-xl font-bold text-gray-800">Kelas Private</h3>
          <p class="text-sm text-gray-500 mt-2">Belajar bahasa Arab intensif 1 Guru 1 Murid.</p>

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
              Materi & Kurikulum Custom
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
              Waktu Belajar Fleksibel
            </li>
          </ul>

          <a href="https://wa.me/6281564977591" target="_blank"
            class="block w-full py-3 text-center border-2 border-blue-600 text-blue-700 font-bold rounded-xl hover:bg-blue-50 active:bg-blue-100 active:scale-95 transition-all duration-200">
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

  {{-- 6. FAQ --}}
  <section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="container max-w-3xl mx-auto px-4" x-data="{ active: null }">
      <h2 class="text-2xl font-bold text-gray-900 text-center mb-8">Pertanyaan Umum</h2>

      <div class="space-y-3">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <button @click="active = (active === 1 ? null : 1)" class="w-full text-left px-6 py-4 font-semibold flex justify-between items-center text-gray-800">
            Apakah memakai kitab tertentu?
            <span x-text="active === 1 ? '-' : '+'" class="text-xl"></span>
          </button>
          <div x-show="active === 1" class="px-6 pb-4 text-gray-600 text-sm">
            Ya, kami menggunakan kitab panduan standar pemula seperti <i>Durusul Lughah</i> atau <i>Al-Arabiyah Bayna Yadaik</i> (tergantung kesepakatan kelompok dan level).
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <button @click="active = (active === 2 ? null : 2)" class="w-full text-left px-6 py-4 font-semibold flex justify-between items-center text-gray-800">
            Saya belum bisa baca huruf Arab, apa bisa ikut?
            <span x-text="active === 2 ? '-' : '+'" class="text-xl"></span>
          </button>
          <div x-show="active === 2" class="px-6 pb-4 text-gray-600 text-sm">
            Sebaiknya Anda mengambil <a href="{{ route('program.kelas-iqra') }}" class="text-green-600 underline">Kelas Iqra</a> terlebih dahulu untuk melancarkan bacaan dasar, karena materi Bahasa Arab akan banyak menggunakan tulisan Arab gundul/berharakat.
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <button @click="active = (active === 3 ? null : 3)" class="w-full text-left px-6 py-4 font-semibold flex justify-between items-center text-gray-800">
            Apakah diajarkan percakapan (Muhadatsah)?
            <span x-text="active === 3 ? '-' : '+'" class="text-xl"></span>
          </button>
          <div x-show="active === 3" class="px-6 pb-4 text-gray-600 text-sm">
            Tentu. Di setiap pertemuan akan ada sesi praktik percakapan ringan agar lidah terbiasa melafalkan kalimat Arab, bukan hanya teori tata bahasa.
          </div>
        </div>
      </div>
    </div>
  </section>
</x-layout>