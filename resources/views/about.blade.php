<x-layout>
  <div class="bg-green-700 h-[72px] md:h-20 w-full"></div>

  {{-- ================= HEADER / HERO SECTION ================= --}}
  <header class="relative bg-green-50 py-16 md:py-24 overflow-hidden">
    {{-- Hiasan Background Abstrak --}}
    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
    <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-64 h-64 bg-green-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 text-center" data-aos="fade-up">
      <span class="inline-block py-1 px-3 rounded-full bg-green-100 text-green-700 text-xs font-bold uppercase tracking-wider mb-4 border border-green-200">
        Profil Lembaga
      </span>
      <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-6 leading-tight">
        Membangun Generasi <br> <span class="text-green-600">Cinta Al-Qur'an</span>
      </h1>
      <p class="text-gray-500 max-w-2xl mx-auto text-lg leading-relaxed" data-aos="fade-up" data-aos-delay="100">
        Kami berkomitmen menyediakan pendidikan Al-Qur'an yang profesional, bersanad, dan mudah diakses oleh siapa saja, di mana saja, untuk meraih keberkahan hidup.
      </p>
    </div>
  </header>

  {{-- ================= VISI & MISI ================= --}}
  {{-- [PERBAIKAN]: Menambahkan overflow-x-hidden di section ini agar AOS fade-left/right tidak melebarkan layar mobile --}}
  <section class="py-16 bg-white relative overflow-x-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        {{-- Gambar Ilustrasi --}}
        <div class="relative group" data-aos="fade-right">
          <div class="absolute inset-0 bg-green-600 rounded-2xl rotate-3 opacity-10 group-hover:rotate-6 transition duration-500"></div>
          <img src="https://images.unsplash.com/photo-1609599006353-e629aaabfeae?q=80&w=1000&auto=format&fit=crop"
            alt="Belajar Quran"
            class="relative rounded-2xl shadow-xl w-full object-cover h-[350px] md:h-[450px] transform group-hover:-translate-y-2 transition duration-500">
        </div>

        {{-- Text Content --}}
        <div data-aos="fade-left">
          <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center gap-3">
            <span class="w-2 h-8 bg-green-500 rounded-full"></span>
            Visi & Misi Kami
          </h2>

          <div class="space-y-8">
            {{-- Visi --}}
            <div class="flex gap-4">
              <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600 flex-shrink-0 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
              </div>
              <div>
                <h3 class="font-bold text-lg text-gray-800 mb-2">Visi</h3>
                <p class="text-gray-600 leading-relaxed text-sm md:text-base">Menjadi lembaga pendidikan Al-Qur'an terdepan yang melahirkan masyarakat yang fasih membaca, menghafal, dan mengamalkan Al-Qur'an dalam kehidupan sehari-hari.</p>
              </div>
            </div>

            {{-- Misi --}}
            <div class="flex gap-4">
              <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600 flex-shrink-0 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
              </div>
              <div>
                <h3 class="font-bold text-lg text-gray-800 mb-2">Misi</h3>
                <ul class="space-y-2 text-gray-600 text-sm md:text-base">
                  <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Menyediakan pengajar bersanad dan profesional.
                  </li>
                  <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Menggunakan metode pembelajaran yang efektif & modern.
                  </li>
                  <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Membangun komunitas Qur'ani yang solid dan bersahabat.
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ================= NILAI KEUNGGULAN ================= --}}
  <section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4">
      <div class="text-center mb-12" data-aos="fade-up">
        <h2 class="text-3xl font-bold text-gray-900">Kenapa Memilih Kami?</h2>
        <p class="text-gray-500 mt-2 max-w-2xl mx-auto">Kualitas pendidikan adalah prioritas utama kami untuk memastikan setiap santri mendapatkan bimbingan terbaik.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Card 1: Guru Bersanad --}}
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition duration-300 group" data-aos="fade-up" data-aos-delay="100">
          <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 mb-6 shadow-sm group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
            {{-- Icon: Academic Cap / Sertifikat --}}
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold mb-3 text-gray-800 group-hover:text-green-600 transition-colors">Guru Bersanad</h3>
          <p class="text-gray-500 text-sm leading-relaxed">Seluruh pengajar kami telah memiliki sanad muttasil hingga Rasulullah SAW, menjamin kemurnian bacaan dan pemahaman.</p>
        </div>

        {{-- Card 2: Sistem Terintegrasi --}}
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition duration-300 group" data-aos="fade-up" data-aos-delay="200">
          <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 mb-6 shadow-sm group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
            {{-- Icon: Dashboard / Device --}}
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold mb-3 text-gray-800 group-hover:text-green-600 transition-colors">Sistem Terintegrasi</h3>
          <p class="text-gray-500 text-sm leading-relaxed">Pantau perkembangan belajar, jadwal, dan setoran hafalan secara realtime melalui dashboard aplikasi yang modern.</p>
        </div>

        {{-- Card 3: Waktu Fleksibel --}}
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition duration-300 group" data-aos="fade-up" data-aos-delay="300">
          <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 mb-6 shadow-sm group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
            {{-- Icon: Clock / Calendar --}}
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold mb-3 text-gray-800 group-hover:text-green-600 transition-colors">Waktu Fleksibel</h3>
          <p class="text-gray-500 text-sm leading-relaxed">Pilihan jadwal belajar yang beragam, mulai dari kelas privat ke rumah, reguler di markaz, hingga online weekend.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- ================= CTA FOOTER ================= --}}
  <section class="py-20 bg-green-600 text-center px-4 relative overflow-hidden">
    <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6" data-aos="zoom-in">
      {{-- Judul: text-2xl di mobile, text-4xl di desktop --}}
      <h2 class="text-2xl md:text-4xl font-bold text-white mb-4 md:mb-6 leading-tight">
        Siap Memulai Perjalanan Hijrah Anda?
      </h2>

      {{-- Deskripsi: text-sm di mobile agar tidak terlalu memenuhi layar --}}
      <p class="text-green-100 text-sm md:text-lg mb-8 max-w-2xl mx-auto opacity-90">
        Bergabunglah dengan ribuan santri lainnya dan rasakan kemudahan belajar Al-Qur'an bersama kami.
      </p>

      {{-- Tombol: justify-center dan lebar penuh di mobile sangat membantu jempol pengguna --}}
      <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center items-center">
        <a href="/login?mode=register"
          class="w-full sm:w-auto px-8 py-3.5 bg-white text-green-700 font-bold rounded-full hover:bg-gray-100 transition shadow-lg transform hover:-translate-y-1 duration-200 text-center">
          Daftar Santri Baru
        </a>

        <a href="https://wa.me/6285860913931?text=Assalamualaikum%20Admin,%20saya%20ingin%20konsultasi%20mengenai%20program%20tahsin%20Al-Qur'an"
          target="_blank"
          class="w-full sm:w-auto px-8 py-3.5 border border-white/50 text-white font-bold rounded-full hover:bg-white/10 transition inline-flex justify-center items-center gap-2 text-center backdrop-blur-sm">
          <span>Konsultasi Dulu</span>
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
          </svg>
        </a>
      </div>
    </div>

    {{-- Pattern Background --}}
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/arabesque.png')]"></div>
  </section>

</x-layout>