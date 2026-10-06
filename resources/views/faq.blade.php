<x-layout>

  {{-- SPACER NAVBAR (Agar tulisan tidak tertutup navbar fixed) --}}
  <div class="bg-green-700 h-[72px] md:h-20 w-full"></div>

  {{-- ================= HERO SECTION ================= --}}
  <header class="relative bg-green-50 py-16 md:py-20 text-center px-4 overflow-hidden">
    {{-- Hiasan Background --}}
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-30 pointer-events-none">
      <div class="absolute -top-24 -left-24 w-96 h-96 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl animate-pulse"></div>
      <div class="absolute top-1/2 right-0 w-64 h-64 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
    </div>

    <div class="relative z-10 max-w-3xl mx-auto" data-aos="fade-up">
      <span class="inline-block py-1 px-3 rounded-full bg-white text-green-700 text-xs font-bold uppercase tracking-wider mb-4 shadow-sm border border-green-100">
        Pusat Bantuan
      </span>
      <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-4">
        Pertanyaan yang Sering <span class="text-green-600">Diajukan</span>
      </h1>
      <p class="text-gray-500 text-lg">
        Cari jawaban cepat seputar pendaftaran, metode belajar, dan biaya di sini.
      </p>
    </div>
  </header>

  {{-- ================= FAQ CONTENT (Professional & Scalable) ================= --}}
  <section class="py-16 bg-white min-h-screen relative"
    x-data="{ 
        activeAccordion: null,
        faqs: [
            {
                category: 'Informasi Umum',
                // Icon: Building / Office
                iconPath: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                items: [
                    { 
                        id: 1, 
                        q: 'Apakah lembaga ini resmi dan bersanad?', 
                        a: 'InsyaAllah resmi. Seluruh pengajar inti kami telah memiliki sanad muttasil (bersambung) hingga Rasulullah SAW, khususnya dalam riwayat Hafs \'an \'Ashim. Kami sangat menjaga kualitas bacaan sesuai kaidah tajwid.' 
                    },
                    { 
                        id: 2, 
                        q: 'Siapa saja yang boleh mendaftar?', 
                        a: 'Kami menerima santri dari segala usia, mulai dari anak-anak (minimal 5 tahun), remaja, dewasa, hingga lansia. Kelas akan dipisah berdasarkan usia dan jenis kelamin (ikhwan/akhwat) untuk menjaga kenyamanan.' 
                    }
                ]
            },
            {
                category: 'Sistem Belajar',
                // Icon: Academic Book
                iconPath: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                items: [
                    { 
                        id: 3, 
                        q: 'Saya belum bisa baca Al-Qur\'an sama sekali, apakah bisa?', 
                        a: '<strong>Sangat bisa!</strong> Kami memiliki program khusus \'Pra-Tahsin\' (Iqra/Nol) untuk pemula. Anda akan dibimbing dari pengenalan huruf hijaiyah hingga lancar membaca dengan sabar dan telaten.' 
                    },
                    { 
                        id: 4, 
                        q: 'Apakah belajarnya Online atau Offline?', 
                        a: 'Kami menyediakan kedua opsi:<ul class=\'list-disc list-inside mt-2 space-y-1\'><li><strong>Online:</strong> Via Zoom/Google Meet (Fleksibel & Hemat Waktu).</li><li><strong>Offline:</strong> Guru datang ke rumah (Private) atau santri datang ke Markaz kami.</li></ul>' 
                    },
                    { 
                        id: 5, 
                        q: 'Berapa lama durasi per pertemuan?', 
                        a: 'Durasi belajar efektif adalah <strong>60-90 menit</strong> per sesi, tergantung jenis program (Private/Reguler). Waktu ini dirasa paling optimal untuk menjaga fokus dan penyerapan materi.' 
                    }
                ]
            },
            {
                category: 'Infaq & Pendaftaran',
                // Icon: Banknotes / Money
                iconPath: 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z',
                items: [
                    { 
                        id: 6, 
                        q: 'Bagaimana sistem pembayaran infaqnya?', 
                        a: 'Pembayaran infaq  setiap awal bulan (Infaq Bulanan) melalui transfer bank. Informasi akan muncul otomatis di Dashboard Santri Anda, dan Anda cukup upload bukti transfer di sana.' 
                    },
                    { 
                        id: 7, 
                        q: 'Apakah ada biaya pendaftaran?', 
                        a: 'Ya, ada biaya pendaftaran satu kali sebesar <strong>Rp 50.000</strong>. Biaya ini digunakan untuk administrasi awal dan pembuatan akun dashboard santri.' 
                    }
                ]
            }
        ]
    }">

    <div class="max-w-4xl mx-auto px-4 sm:px-6">

      {{-- LOOPING KATEGORI --}}
      <template x-for="(group, index) in faqs" :key="index">
        <div class="mb-12" data-aos="fade-up" :data-aos-delay="index * 100">

          {{-- Judul Kategori dengan Ikon SVG --}}
          <div class="flex items-center gap-4 mb-6 border-b border-gray-100 pb-4">
            <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center text-green-600 shadow-sm border border-green-100">
              {{-- Render SVG Path dari Data --}}
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="group.iconPath"></path>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800" x-text="group.category"></h3>
          </div>

          <div class="space-y-4">
            {{-- LOOPING PERTANYAAN (ITEM) --}}
            <template x-for="item in group.items" :key="item.id">
              <div class="border border-gray-200 rounded-2xl overflow-hidden hover:border-green-300 transition duration-300 bg-white shadow-sm group">

                {{-- Header Accordion --}}
                <button @click="activeAccordion = (activeAccordion === item.id ? null : item.id)"
                  class="flex items-center justify-between w-full p-5 text-left bg-white focus:outline-none select-none">
                  <span class="font-bold text-gray-800 group-hover:text-green-700 transition-colors" x-text="item.q"></span>

                  {{-- Ikon Chevron --}}
                  <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center transition-colors group-hover:bg-green-100/50">
                    <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300"
                      :class="activeAccordion === item.id ? 'rotate-180 text-green-600' : ''"
                      fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </div>
                </button>

                {{-- Isi Jawaban --}}
                <div x-show="activeAccordion === item.id" x-collapse>
                  <div class="px-5 pb-5 pt-0 text-gray-600 leading-relaxed text-sm border-t border-dashed border-gray-100 mt-2 pt-4"
                    x-html="item.a">
                  </div>
                </div>

              </div>
            </template>
          </div>

        </div>
      </template>

    </div>
  </section>

  {{-- ================= CONTACT CTA ================= --}}
  <section class="py-16 bg-gray-50 border-t border-gray-100 text-center px-4">
    <div class="max-w-2xl mx-auto" data-aos="zoom-in">
      <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Belum Menemukan Jawaban?</h2>
      <p class="text-gray-500 mb-8">Jangan ragu untuk menghubungi tim admin kami. Kami siap membantu menjelaskan program yang paling cocok untuk Anda.</p>

      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="https://wa.me/6285860913931" target="_blank" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition shadow-lg shadow-green-200">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
          </svg>
          Chat WhatsApp
        </a>
        <a href="mailto:admin@deepquranacademy.id" class="inline-flex items-center justify-center gap-2 px-6 py-3 border border-gray-200 bg-white text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition">
          Kirim Email
        </a>
      </div>
    </div>
  </section>

</x-layout>