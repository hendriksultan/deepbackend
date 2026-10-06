<x-layout>
  <x-slot:title>Program Tahfidz Anak - Deep Quran Academy</x-slot:title>

  {{-- SOLUSI FINAL: Mengunci sumbu X dari Body secara global agar AOS tidak melebarkan layar, tanpa membuat double scrollbar --}}
  <style>
    html,
    body {
      overflow-x: hidden !important;
    }
  </style>

  {{-- 1. HERO SECTION (Kids Focus) --}}
  <section class="relative pt-32 pb-20 md:pt-40 md:pb-32 bg-gradient-to-br from-green-900 via-green-800 to-green-600 overflow-hidden">
    {{-- Background Elements --}}
   <div class="absolute inset-0 opacity-20 mix-blend-overlay" style="background-image: url('{{ asset('arabesque.png') }}');"></div>
    {{-- Fun Blobs for Kids Theme --}}
    <div class="absolute top-20 left-10 w-64 h-64 bg-yellow-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
    <div class="absolute bottom-10 right-10 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>

    <div class="container max-w-7xl mx-auto px-4 md:px-6 relative z-10">
      <div class="flex flex-col md:flex-row items-center gap-12">
        {{-- Text Content --}}
        <div class="w-full md:w-1/2 text-white" data-aos="fade-right">
          <div class="inline-flex items-center gap-2 px-3 py-1 mb-6 bg-green-800/50 border border-green-700 rounded-full backdrop-blur-md">
            <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
            <span class="text-xs font-semibold capitalize tracking-wider text-green-100">Untuk Usia 5 - 15 Tahun</span>
          </div>

          <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
            Siapkan Mahkota Surga <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-500">Sejak Usia Dini</span>
          </h1>

          <p class="text-lg text-green-100/90 mb-8 leading-relaxed font-light">
            Alihkan fokus anak dari gadget ke Al-Qur'an. Metode menghafal yang ceria, tidak menekan, dan membangun karakter Qur'ani sejak masa emas (Golden Age).
          </p>

          <div class="flex flex-col sm:flex-row gap-4">
            <a href="#daftar" class="px-8 py-4 bg-yellow-500 text-green-900 font-bold rounded-full shadow-lg hover:bg-yellow-400 hover:-translate-y-1 transition-all duration-300 text-center">
              Daftarkan Putra/i
            </a>
            <a href="#metode" class="px-8 py-4 bg-transparent border border-white/30 text-white font-semibold rounded-full hover:bg-white/10 hover:border-white transition-all duration-300 text-center">
              Metode Belajar
            </a>
          </div>
        </div>

        {{-- Image Content --}}
        <div class="w-full md:w-1/2 flex justify-center relative" data-aos="fade-left">
          <div class="relative w-full max-w-md aspect-square bg-gradient-to-tr from-green-800 to-green-600 rounded-[2rem] p-2 shadow-2xl border border-white/10">
            {{-- GANTI GAMBAR: Anak kecil (lk/pr) sedang memegang/membaca Quran dengan ceria --}}
            <img src="{{ asset('images/tahfid.webp') }}"
              alt="Tahfidz Anak"
              class="w-full h-full object-cover rounded-[1.8rem] opacity-90 grayscale-[20%] hover:grayscale-0 transition duration-500">

            {{-- Floating Card --}}
            <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-xl flex items-center gap-4 animate-bounce-slow max-w-xs">
              <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                {{-- Icon: Smile/Happy --}}
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div>
                <p class="text-xs text-gray-500">Suasana Belajar</p>
                <p class="font-bold text-gray-800 text-sm">Ceria & Menyenangkan</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- 2. PARENTAL CONCERNS (Problem Agitation) --}}
  <section class="py-16 bg-white">
    <div class="container max-w-6xl mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Kekhawatiran Orang Tua Saat Ini</h2>
        <p class="text-gray-500 max-w-2xl mx-auto">Tantangan mendidik anak di era digital semakin berat. Apakah Anda merasakan hal ini?</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- Point 1: Gadget Addiction --}}
        <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group" data-aos="fade-up" data-aos-delay="0">
          <div class="w-14 h-14 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-red-500 group-hover:text-white transition-colors duration-300">
            {{-- Icon: Device Mobile / Warning --}}
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="font-bold text-xl text-gray-800 mb-3">Kecanduan Gadget</h3>
          <p class="text-sm text-gray-500 leading-relaxed">
            Anak sulit lepas dari HP dan Game Online, sehingga waktu untuk belajar agama dan mengaji semakin habis.
          </p>
        </div>

        {{-- Point 2: Parents Busy --}}
        <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group" data-aos="fade-up" data-aos-delay="100">
          <div class="w-14 h-14 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-orange-500 group-hover:text-white transition-colors duration-300">
            {{-- Icon: Briefcase / Clock --}}
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="font-bold text-xl text-gray-800 mb-3">Orang Tua Sibuk</h3>
          <p class="text-sm text-gray-500 leading-relaxed">
            Ingin mengajari anak mengaji sendiri tapi terkendala kesibukan kerja atau merasa ilmu tajwid belum mumpuni.
          </p>
        </div>

        {{-- Point 3: Wrong Environment --}}
        <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group" data-aos="fade-up" data-aos-delay="200">
          <div class="w-14 h-14 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300">
            {{-- Icon: User Group / Environment --}}
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
          </div>
          <h3 class="font-bold text-xl text-gray-800 mb-3">Pergaulan Bebas</h3>
          <p class="text-sm text-gray-500 leading-relaxed">
            Khawatir anak terpengaruh lingkungan yang kurang baik. Memasukkan anak ke komunitas tahfidz adalah benteng terbaik.
          </p>
        </div>

      </div>
    </div>
  </section>

  {{-- 3. CURRICULUM LEVELS (Kids Friendly) --}}
  <section id="metode" class="py-16 bg-green-50 border-y border-green-100">
    <div class="container max-w-7xl mx-auto px-4">
      <div class="text-center mb-16">
        <span class="text-green-600 font-bold text-xs uppercase tracking-wider px-3 py-1 bg-white rounded-full inline-block mb-4 shadow-sm">Kurikulum Anak</span>
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Belajar Sambil Bermain</h2>
        <p class="text-gray-500 mt-4">Materi disesuaikan dengan usia dan kemampuan motorik anak.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">

        {{-- Level 1: Pra Tahfidz --}}
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative group hover:-translate-y-2 transition duration-300 h-full" data-aos="fade-up" data-aos-delay="0">
          <div class="w-16 h-16 bg-green-600 text-white rounded-2xl flex items-center justify-center text-2xl font-bold mb-6 shadow-lg shadow-green-200 mx-auto md:mx-0">1</div>
          <h3 class="text-xl font-bold text-gray-800 mb-3 text-center md:text-left">Pra-Tahfidz</h3>
          <p class="text-gray-500 text-sm mb-4 text-center md:text-left">Untuk anak yang belum lancar baca.</p>
          <ul class="space-y-3 text-sm text-gray-600 border-t border-gray-100 pt-4">
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Metode Iqra / Tilawati</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Hafalan surah pendek (An-Nas s.d Ad-Dhuha)</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Doa-doa harian & Adab</li>
          </ul>
        </div>

        {{-- Level 2: Juz Amma --}}
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative group hover:-translate-y-2 transition duration-300 h-full" data-aos="fade-up" data-aos-delay="100">
          <div class="w-16 h-16 bg-yellow-400 text-green-900 rounded-2xl flex items-center justify-center text-2xl font-bold mb-6 shadow-lg shadow-yellow-100 mx-auto md:mx-0">2</div>
          <h3 class="text-xl font-bold text-gray-800 mb-3 text-center md:text-left">Tahfidz Juz 30</h3>
          <p class="text-gray-500 text-sm mb-4 text-center md:text-left">Untuk anak yang sudah bisa membaca.</p>
          <ul class="space-y-3 text-sm text-gray-600 border-t border-gray-100 pt-4">
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Target Hafal Juz 30 Mutqin</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Perbaikan Tajwid dasar</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Setoran rutin & Murojaah</li>
          </ul>
        </div>

        {{-- Level 3: Lanjutan --}}
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative group hover:-translate-y-2 transition duration-300 h-full" data-aos="fade-up" data-aos-delay="200">
          <div class="w-16 h-16 bg-green-800 text-white rounded-2xl flex items-center justify-center text-2xl font-bold mb-6 shadow-lg shadow-green-200 mx-auto md:mx-0">3</div>
          <h3 class="text-xl font-bold text-gray-800 mb-3 text-center md:text-left">Tahfidz Lanjutan</h3>
          <p class="text-gray-500 text-sm mb-4 text-center md:text-left">Melanjutkan ke Juz 29, 28, dst.</p>
          <ul class="space-y-3 text-sm text-gray-600 border-t border-gray-100 pt-4">
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Target 1-2 Juz per tahun</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Ujian Tasmi' (Diperdengarkan)</li>
            <li class="flex items-start gap-2"><span class="text-green-500 font-bold">✓</span> Sertifikat kenaikan Juz</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  {{-- 4. HASIL BELAJAR (Output for Parents) --}}
  <section class="py-16 bg-white">
    <div class="container max-w-6xl mx-auto px-4">
      <div class="flex flex-col md:flex-row items-center gap-12">

        {{-- Left Content --}}
        <div class="w-full md:w-1/2" data-aos="fade-right">
          <h2 class="text-3xl font-bold text-gray-900 mb-6">Metode "Ramah Anak"</h2>
          <p class="text-gray-600 mb-8 leading-relaxed">
            Kami memastikan anak tidak merasa tertekan. Guru kami berperan sebagai sahabat yang membimbing dengan kasih sayang.
          </p>

          <div class="space-y-6">
            <div class="flex gap-4">
              <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-gray-800">Talqin (Meniru)</h4>
                <p class="text-sm text-gray-500 mt-1">Guru membacakan ayat berulang-ulang, anak menirukan. Sangat efektif untuk anak yang belum lancar baca.</p>
              </div>
            </div>
            <div class="flex gap-4">
              <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-gray-800">Laporan Berkala</h4>
                <p class="text-sm text-gray-500 mt-1">Orang tua akan mendapat laporan perkembangan hafalan (Mutabaah) melalui WhatsApp/Aplikasi setiap bulan.</p>
              </div>
            </div>
            <div class="flex gap-4">
              <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-gray-800">Apresiasi & Hadiah</h4>
                <p class="text-sm text-gray-500 mt-1">Sistem bintang dan pujian untuk memotivasi anak agar semangat menambah hafalan.</p>
              </div>
            </div>
          </div>
        </div>

        {{-- Right Content (CTA Box) --}}
        <div class="w-full md:w-1/2" data-aos="fade-left">
          <div class="bg-gray-900 rounded-3xl p-8 text-center text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-green-500 rounded-full blur-3xl opacity-20"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-yellow-500 rounded-full blur-3xl opacity-20"></div>

            <h3 class="text-2xl font-bold mb-4 relative z-10">Jadikan Anak Sholeh/ah</h3>
            <p class="text-gray-300 mb-8 text-sm relative z-10">
              "Apabila manusia meninggal dunia, terputuslah amalnya kecuali tiga perkara: ...dan anak sholeh yang mendoakannya."
            </p>

            <div class="flex flex-col gap-3 relative z-10">
              <a href="https://wa.me/6285860913931?text=Halo%20Admin,%20saya%20tertarik%20mendaftarkan%20anak%20saya" target="_blank" class="w-full py-3 bg-green-500 hover:bg-green-400 text-white font-bold rounded-xl transition duration-300 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                </svg>
                Konsultasi dengan Admin
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- 5. PRICING / PAKET BELAJAR (Kids Pricing) --}}
  <section id="daftar" class="py-16 md:py-24 bg-white border-t border-gray-100">
    <div class="container max-w-5xl mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900">Infaq Tahfidz Anak</h2>
        <p class="text-gray-500 mt-2">Pilih metode belajar yang aman dan nyaman untuk buah hati Anda.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- PAKET 1: ONLINE (ZOOM) --}}
        <div class="border border-gray-200 rounded-3xl p-8 hover:border-green-400 transition duration-300 relative overflow-hidden group bg-white shadow-sm" data-aos="fade-right">
          {{-- Badge --}}
          <div class="absolute top-0 right-0 bg-green-100 text-green-800 text-xs font-bold px-4 py-1.5 rounded-bl-2xl uppercase tracking-wider z-10">
            Online
          </div>

          <h3 class="text-xl font-bold text-gray-800">Kelas Anak Online</h3>
          <p class="text-sm text-gray-500 mt-2">Aman belajar dari rumah, orang tua bisa memantau.</p>

          <div class="my-6">
            <span class="text-4xl font-extrabold text-gray-900">Rp 100.000</span>
            <div class="text-xs text-gray-500 font-medium mt-1">Per Anak / Bulan</div>
          </div>

          <ul class="space-y-4 mb-8 text-sm text-gray-600">
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
              </svg>
              <strong>Maksimal 10 Anak</strong> (Kelompok)
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              2x Pertemuan / Minggu
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
              </svg>
              Via Zoom (Hemat Waktu Antar Jemput)
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Metode Menyenangkan
            </li>
          </ul>

          <a href="/login?mode=register" class="block w-full py-3 text-center border-2 border-green-600 text-green-700 font-bold rounded-xl hover:bg-green-50 transition">
            Daftar Online
          </a>
        </div>

        {{-- PAKET 2: OFFLINE / HOME VISIT --}}
        <div class="border-2 border-yellow-400 rounded-3xl p-8 relative bg-yellow-50/20 overflow-hidden" data-aos="fade-left">
          {{-- Badge --}}
          <div class="absolute top-0 right-0 bg-yellow-400 text-green-900 text-xs font-bold px-4 py-1.5 rounded-bl-2xl uppercase tracking-wider z-10">
            Offline / Visit
          </div>

          <h3 class="text-xl font-bold text-gray-800">Kelas Anak Offline</h3>
          <p class="text-sm text-gray-500 mt-2">Guru datang ke rumah atau kumpul di Markaz.</p>

          <div class="my-6">
            <span class="text-4xl font-extrabold text-gray-900">Rp 150.000</span>
            <div class="text-xs text-gray-500 font-medium mt-1">Per Anak / Bulan</div>
          </div>

          <ul class="space-y-4 mb-8 text-sm text-gray-600">
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
              </svg>
              <strong>Maksimal 10 Anak</strong> (Kelompok)
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              4x Pertemuan / Minggu
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
              Tatap Muka Langsung (Fokus Adab)
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Koreksi Bacaan Intensif
            </li>
          </ul>

          <a href="/login?mode=register" class="block w-full py-3 text-center bg-green-600 text-white font-bold rounded-xl shadow-lg hover:bg-green-700 hover:-translate-y-1 transition duration-300">
            Daftar Offline
          </a>
        </div>
      </div>

      {{-- Catatan Kaki --}}
      <div class="mt-8 text-center bg-green-50 p-4 rounded-xl border border-green-100 max-w-2xl mx-auto">
        <p class="text-sm text-gray-600">
          <span class="font-bold text-green-700">Pendaftaran Kolektif:</span> <br>
          Orang tua bisa mendaftarkan 1 anak saja (nanti digabung kelompok lain) atau mendaftarkan grup (minimal 5 anak) untuk membuat kelompok belajar sendiri.
        </p>
      </div>
    </div>
  </section>

  {{-- 6. FAQ SINGKAT (Kids) --}}
  <section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="container max-w-3xl mx-auto px-4" x-data="{ active: null }">
      <h2 class="text-2xl font-bold text-gray-900 text-center mb-8">Pertanyaan Orang Tua</h2>

      <div class="space-y-3">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <button @click="active = (active === 1 ? null : 1)" class="w-full text-left px-6 py-4 font-semibold flex justify-between items-center text-gray-800">
            Usia berapa minimal bisa ikut?
            <span x-text="active === 1 ? '-' : '+'" class="text-xl"></span>
          </button>
          <div x-show="active === 1" class="px-6 pb-4 text-gray-600 text-sm">
            Kami menerima santri mulai usia <strong>4-5 tahun</strong> (minimal sudah bisa bicara lancar). Untuk Online, disarankan usia 6 tahun ke atas agar lebih fokus di depan layar.
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <button @click="active = (active === 2 ? null : 2)" class="w-full text-left px-6 py-4 font-semibold flex justify-between items-center text-gray-800">
            Kalau anak ngambek/tidak mau belajar bagaimana?
            <span x-text="active === 2 ? '-' : '+'" class="text-xl"></span>
          </button>
          <div x-show="active === 2" class="px-6 pb-4 text-gray-600 text-sm">
            Guru kami sudah terlatih menangani <i>mood</i> anak. Pembelajaran tidak akan dipaksakan, diselingi <i>ice breaking</i>, cerita nabi, atau jeda istirahat agar anak kembali ceria.
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <button @click="active = (active === 3 ? null : 3)" class="w-full text-left px-6 py-4 font-semibold flex justify-between items-center text-gray-800">
            Apakah ada ujian kenaikan tingkat?
            <span x-text="active === 3 ? '-' : '+'" class="text-xl"></span>
          </button>
          <div x-show="active === 3" class="px-6 pb-4 text-gray-600 text-sm">
            Ya, ada ujian berkala untuk mengukur kemampuan bacaan dan hafalan. Anak yang lulus akan mendapatkan sertifikat sebagai bentuk apresiasi.
          </div>
        </div>
      </div>
    </div>
  </section>
</x-layout>