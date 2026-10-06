<x-layout>
  <x-slot:title>Program Pra-Sanad (Tuhfatul Athfal) - Deep Quran Academy</x-slot:title>

  {{-- SOLUSI FINAL: Mengunci sumbu X dari Body secara global agar AOS tidak melebarkan layar, tanpa membuat double scrollbar --}}
  <style>
    html,
    body {
      overflow-x: hidden !important;
    }
  </style>

  {{-- 1. HERO SECTION (Academic / Kitab Focus) --}}
  <section class="relative pt-32 pb-20 md:pt-40 md:pb-32 bg-gradient-to-br from-green-900 via-green-800 to-green-600 overflow-hidden">
    {{-- Background Elements --}}
   <div class="absolute inset-0 opacity-20 mix-blend-overlay" style="background-image: url('{{ asset('arabesque.png') }}');"></div>
    {{-- Ornament --}}
    <div class="absolute top-0 right-0 w-96 h-96 bg-yellow-600 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-green-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>

    <div class="container max-w-7xl mx-auto px-4 md:px-6 relative z-10">
      <div class="flex flex-col md:flex-row items-center gap-12">
        {{-- Text Content --}}
        <div class="w-full md:w-1/2 text-white" data-aos="fade-right">
          <div class="inline-flex items-center gap-2 px-3 py-1 mb-6 bg-green-800/50 border border-green-700 rounded-full backdrop-blur-md">
            <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span>
            <span class="text-xs font-semibold capitalize tracking-wider text-green-100">Level Menengah (Intermediate)</span>
          </div>

          <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
            Gerbang Menuju <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-500">Sanad Al-Qur'an</span>
          </h1>

          <p class="text-lg text-green-100/90 mb-8 leading-relaxed font-light">
            Kuasai landasan teori tajwid melalui bedah kitab <strong>Matan Tuhfatul Athfal</strong>. Hafalkan baitnya, pahami maknanya, dan praktikkan dalam bacaan.
          </p>

          <div class="flex flex-col sm:flex-row gap-4">
            <a href="#daftar" class="px-8 py-4 bg-yellow-500 text-green-900 font-bold rounded-full shadow-lg hover:bg-yellow-400 hover:-translate-y-1 transition-all duration-300 text-center">
              Daftar Pra-Sanad
            </a>
            <a href="#kurikulum" class="px-8 py-4 bg-transparent border border-white/30 text-white font-semibold rounded-full hover:bg-white/10 hover:border-white transition-all duration-300 text-center">
              Lihat Silabus
            </a>
          </div>
        </div>

        {{-- Image Content --}}
        <div class="w-full md:w-1/2 flex justify-center relative" data-aos="fade-left">
          <div class="relative w-full max-w-md aspect-square bg-gradient-to-tr from-green-800 to-green-600 rounded-[2rem] p-2 shadow-2xl border border-white/10">
            {{-- GANTI GAMBAR: Seseorang sedang memegang Kitab Kuning / Al-Quran dengan fokus --}}
            <img src="https://images.pexels.com/photos/8164396/pexels-photo-8164396.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
              alt="Belajar Tuhfatul Athfal"
              class="w-full h-full object-cover rounded-[1.8rem] opacity-90 grayscale-[20%] hover:grayscale-0 transition duration-500">

            {{-- Floating Card --}}
            <div class="absolute -bottom-6 -right-6 bg-white p-4 rounded-xl shadow-xl flex items-center gap-4 animate-bounce-slow max-w-xs">
              <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                {{-- Icon: Book / Kitab --}}
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
              </div>
              <div>
                <p class="text-xs text-gray-500">Kitab Acuan</p>
                <p class="font-bold text-gray-800 text-sm">Tuhfatul Athfal</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- 2. WHY THIS PROGRAM? --}}
  <section class="py-16 bg-white">
    <div class="container max-w-6xl mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Mengapa Perlu Belajar Matan?</h2>
        <p class="text-gray-500 max-w-2xl mx-auto">Banyak yang bisa membaca Al-Qur'an, tapi tidak tahu alasan (dalil) kenapa dibaca demikian. Program ini adalah jawabannya.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- Point 1 --}}
        <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group" data-aos="fade-up" data-aos-delay="0">
          <div class="w-14 h-14 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
            {{-- Icon: Academic Cap / Theory --}}
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
              <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
            </svg>
          </div>
          <h3 class="font-bold text-xl text-gray-800 mb-3">Pondasi Ilmu Tajwid</h3>
          <p class="text-sm text-gray-500 leading-relaxed">
            Tuhfatul Athfal adalah kitab dasar yang wajib dikuasai sebelum melangkah ke kitab yang lebih tinggi (Al-Jazariyah).
          </p>
        </div>

        {{-- Point 2 --}}
        <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group" data-aos="fade-up" data-aos-delay="100">
          <div class="w-14 h-14 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-yellow-500 group-hover:text-white transition-colors duration-300">
            {{-- Icon: Lightning / Quick Recall --}}
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
          <h3 class="font-bold text-xl text-gray-800 mb-3">Mudah Mengingat Hukum</h3>
          <p class="text-sm text-gray-500 leading-relaxed">
            Dengan menghafal bait syair (nazham), Anda akan lebih mudah mengingat hukum-hukum tajwid saat sedang membaca Al-Qur'an.
          </p>
        </div>

        {{-- Point 3 --}}
        <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group" data-aos="fade-up" data-aos-delay="200">
          <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
            {{-- Icon: Certificate / Sanad --}}
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h3 class="font-bold text-xl text-gray-800 mb-3">Syarat Mengambil Sanad</h3>
          <p class="text-sm text-gray-500 leading-relaxed">
            Hafal Tuhfatul Athfal seringkali menjadi syarat mutlak bagi guru-guru bersanad sebelum memberikan ijazah sanad kepada muridnya.
          </p>
        </div>

      </div>
    </div>
  </section>

  {{-- 3. SILABUS / MATERI BAHASAN (Specific to Tuhfatul Athfal) --}}
  <section id="kurikulum" class="py-16 bg-green-50 border-y border-green-100">
    <div class="container max-w-7xl mx-auto px-4">
      <div class="text-center mb-16">
        <span class="text-green-600 font-bold text-xs uppercase tracking-wider px-3 py-1 bg-white rounded-full inline-block mb-4 shadow-sm">Bedah Kitab</span>
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Silabus Tuhfatul Athfal</h2>
        <p class="text-gray-500 mt-4">Mengkaji 61 bait syair karya Syeikh Sulaiman Al-Jamzuri.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative">

        {{-- Column 1 --}}
        <div class="space-y-6">
          <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex gap-4 items-start" data-aos="fade-up" data-aos-delay="0">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold flex-shrink-0">1</div>
            <div>
              <h4 class="font-bold text-gray-800">Mukaddimah</h4>
              <p class="text-sm text-gray-500 mt-1">Membahas biografi penulis, adab penuntut ilmu, dan pengantar ilmu tajwid.</p>
            </div>
          </div>

          <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex gap-4 items-start" data-aos="fade-up" data-aos-delay="100">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold flex-shrink-0">2</div>
            <div>
              <h4 class="font-bold text-gray-800">Nun Sukun & Tanwin</h4>
              <p class="text-sm text-gray-500 mt-1">Membahas hukum Izhar, Idgham (Bighunnah/Bilaghunnah), Iqlab, dan Ikhfa Haqiqi secara mendalam.</p>
            </div>
          </div>

          <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex gap-4 items-start" data-aos="fade-up" data-aos-delay="200">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold flex-shrink-0">3</div>
            <div>
              <h4 class="font-bold text-gray-800">Mim & Nun Bertasydid</h4>
              <p class="text-sm text-gray-500 mt-1">Membahas hukum Ghunnah Musyaddadah dan hukum Mim Sukun (Ikhfa Syafawi, Idgham Mimi, Izhar Syafawi).</p>
            </div>
          </div>
        </div>

        {{-- Column 2 --}}
        <div class="space-y-6">
          <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex gap-4 items-start" data-aos="fade-up" data-aos-delay="300">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold flex-shrink-0">4</div>
            <div>
              <h4 class="font-bold text-gray-800">Lam Ta'rif & Lam Fi'il</h4>
              <p class="text-sm text-gray-500 mt-1">Membedakan Al-Syamsiyah dan Al-Qamariyah, serta cara membaca Lam pada kata kerja.</p>
            </div>
          </div>

          <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex gap-4 items-start" data-aos="fade-up" data-aos-delay="400">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold flex-shrink-0">5</div>
            <div>
              <h4 class="font-bold text-gray-800">Aqsamul Mad (Pembagian Mad)</h4>
              <p class="text-sm text-gray-500 mt-1">Bab terpanjang dan terpenting. Membahas Mad Asli dan berbagai jenis Mad Far'i beserta kadar panjangnya.</p>
            </div>
          </div>

          <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex gap-4 items-start" data-aos="fade-up" data-aos-delay="500">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold flex-shrink-0">6</div>
            <div>
              <h4 class="font-bold text-gray-800">Khatimah (Penutup)</h4>
              <p class="text-sm text-gray-500 mt-1">Pembagian harakat (Maratibul Ghunnah) dan doa penutup dari penyusun kitab.</p>
            </div>
          </div>
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
          <h2 class="text-3xl font-bold text-gray-900 mb-6">Target Lulusan</h2>
          <p class="text-gray-600 mb-8 leading-relaxed">
            Kami tidak hanya mengajarkan cara membaca, tetapi membentuk Anda menjadi pengajar Al-Qur'an yang memahami dalil.
          </p>

          <div class="space-y-6">
            <div class="flex gap-4">
              <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-gray-800">Hafal 61 Bait Nazham</h4>
                <p class="text-sm text-gray-500 mt-1">Lulus ujian setoran hafalan matan (Tasmi') di hadapan guru bersanad.</p>
              </div>
            </div>
            <div class="flex gap-4">
              <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-gray-800">Paham Syarah (Penjelasan)</h4>
                <p class="text-sm text-gray-500 mt-1">Mampu menjelaskan kembali hukum tajwid berdasarkan bait matan yang dihafal.</p>
              </div>
            </div>
            <div class="flex gap-4">
              <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-gray-800">Siap ke Level Sanad</h4>
                <p class="text-sm text-gray-500 mt-1">Memiliki bekal yang cukup untuk melanjutkan ke level Matan Al-Jazariyah dan pengambilan sanad bacaan.</p>
              </div>
            </div>
          </div>
        </div>

        {{-- Right Content (CTA Box) --}}
        <div class="w-full md:w-1/2" data-aos="fade-left">
          <div class="bg-gray-900 rounded-3xl p-8 text-center text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-600 rounded-full blur-3xl opacity-20"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-green-500 rounded-full blur-3xl opacity-20"></div>

            <h3 class="text-2xl font-bold mb-4 relative z-10">Ambil Peran Penjaga Al-Qur'an</h3>
            <p class="text-gray-300 mb-8 text-sm relative z-10">
              "Mempelajari teori tajwid hukumnya Fardhu Kifayah, namun membaca Al-Qur'an dengan tajwid hukumnya Fardhu 'Ain."
            </p>

            <div class="flex flex-col gap-3 relative z-10">
              <a href="https://wa.me/6285860913931?text=Halo%20Admin,%20saya%20tertarik%20program%20Pra-Sanad%20(Tuhfatul%20Athfal)" target="_blank" class="w-full py-3 bg-green-500 hover:bg-green-400 text-white font-bold rounded-xl transition duration-300 flex items-center justify-center gap-2">
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

  {{-- 5. PRICING (Standardized) - Pra-Sanad --}}
  <section id="daftar" class="py-16 md:py-24 bg-white border-t border-gray-100">
    <div class="container max-w-6xl mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900">Infaq Program Pra-Sanad</h2>
        <p class="text-gray-500 mt-2">Sistem belajar intensif untuk persiapan pengambilan Sanad.</p>
      </div>

      {{-- Grid diubah menjadi lg:grid-cols-3 agar memuat 3 paket --}}
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        {{-- PAKET 1: ONLINE --}}
        <div class="border border-gray-200 rounded-3xl p-8 hover:border-green-400 transition duration-300 relative overflow-hidden group bg-white shadow-sm" data-aos="fade-up" data-aos-delay="0">
          <div class="absolute top-0 right-0 bg-green-100 text-green-800 text-xs font-bold px-4 py-1.5 rounded-bl-2xl uppercase tracking-wider z-10">
            Online
          </div>

          <h3 class="text-xl font-bold text-gray-800">Kelas Online</h3>
          <p class="text-sm text-gray-500 mt-2">Belajar teori & hafalan matan via Zoom.</p>

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
              Materi PDF & Rekaman
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Setoran Hafalan Matan
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
          <p class="text-sm text-gray-500 mt-2">Talaqqi langsung dengan guru di markaz/rumah.</p>

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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
              Tatap Muka Langsung (Talaqqi)
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Setoran Hafalan Matan
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
          <p class="text-sm text-gray-500 mt-2">Bimbingan intensif 1 Guru 1 Murid secara privat.</p>

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
              Pembahasan Matan Lebih Rinci
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
            class="block w-full py-3 text-center border-2 border-blue-600 text-blue-700 font-bold rounded-xl hover:bg-blue-50 active:bg-blue-100 active:scale-95 transition-all duration-200">
            Konsultasi Sekarang
          </a>
        </div>

      </div>

      {{-- Catatan Kaki --}}
      <div class="mt-12 text-center bg-green-50 p-4 rounded-xl border border-green-100 max-w-3xl mx-auto">
        <p class="text-sm text-gray-600">
          <span class="font-bold text-green-700">Catatan:</span> <br>
          Untuk Home Visit, ketersediaan guru bergantung pada wilayah. Anda bisa mendaftar secara kolektif (grup) agar lebih hemat dan efektif.
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
            Apakah harus lancar membaca Al-Qur'an?
            <span x-text="active === 1 ? '-' : '+'" class="text-xl"></span>
          </button>
          <div x-show="active === 1" class="px-6 pb-4 text-gray-600 text-sm">
            Ya, ini adalah program tingkat menengah. Peserta diharapkan sudah mampu membaca Al-Qur'an dengan lancar, meskipun belum sempurna secara tajwid.
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <button @click="active = (active === 2 ? null : 2)" class="w-full text-left px-6 py-4 font-semibold flex justify-between items-center text-gray-800">
            Apakah wajib menghafal matan?
            <span x-text="active === 2 ? '-' : '+'" class="text-xl"></span>
          </button>
          <div x-show="active === 2" class="px-6 pb-4 text-gray-600 text-sm">
            Sangat disarankan. Menghafal matan adalah kunci untuk mengingat hukum tajwid dengan cepat. Namun jika ada kendala, peserta boleh menyimak penjelasan syarah saja.
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <button @click="active = (active === 3 ? null : 3)" class="w-full text-left px-6 py-4 font-semibold flex justify-between items-center text-gray-800">
            Berapa lama program ini selesai?
            <span x-text="active === 3 ? '-' : '+'" class="text-xl"></span>
          </button>
          <div x-show="active === 3" class="px-6 pb-4 text-gray-600 text-sm">
            Estimasi selesai bedah kitab adalah 3-4 bulan (tergantung frekuensi pertemuan). Setelah itu akan diadakan ujian akhir (Tasmi' & Teori) untuk mendapatkan sertifikat.
          </div>
        </div>
      </div>
    </div>
  </section>
</x-layout>