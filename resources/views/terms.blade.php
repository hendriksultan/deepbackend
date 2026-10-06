<x-layout>

  {{-- SPACER NAVBAR --}}
  <div class="bg-green-700 h-[72px] md:h-20 w-full"></div>

  {{-- ================= HEADER ================= --}}
  <header class="bg-green-50 py-12 md:py-16 border-b border-green-100">
    <div class="max-w-7xl mx-auto px-4 text-center" data-aos="fade-up">
      <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
        Syarat & Ketentuan
      </h1>
      <p class="text-gray-500 max-w-2xl mx-auto">
        Mohon membaca syarat dan ketentuan ini dengan saksama sebelum mendaftar sebagai santri di TahsinQur'an.
      </p>
      <p class="text-xs text-green-600 font-bold mt-4 uppercase tracking-widest">
        Terakhir Diupdate: {{ date('d F Y') }}
      </p>
    </div>
  </header>

  {{-- ================= KONTEN UTAMA ================= --}}
  <section class="py-12 md:py-16 bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

        {{-- SIDEBAR NAVIGASI (Sticky di Desktop) --}}
        <aside class="hidden lg:block lg:col-span-4 xl:col-span-3">
          <div class="sticky top-32 p-6 bg-gray-50 rounded-2xl border border-gray-100 shadow-sm">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
              <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
              </svg>
              Daftar Isi
            </h3>
            <nav class="space-y-1">
              <a href="#umum" class="block px-3 py-2 text-sm font-medium text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition">1. Ketentuan Umum</a>
              <a href="#pendaftaran" class="block px-3 py-2 text-sm font-medium text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition">2. Pendaftaran Santri</a>
              <a href="#biaya" class="block px-3 py-2 text-sm font-medium text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition">3. Biaya & Pembayaran</a>
              <a href="#kbm" class="block px-3 py-2 text-sm font-medium text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition">4. Kegiatan Belajar</a>
              <a href="#etika" class="block px-3 py-2 text-sm font-medium text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition">5. Adab & Etika</a>
              <a href="#pembatalan" class="block px-3 py-2 text-sm font-medium text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition">6. Pembatalan & Refund</a>
            </nav>

            <div class="mt-8 pt-6 border-t border-gray-200">
              <a href="/login?mode=register" class="flex items-center justify-center w-full px-4 py-2.5 bg-green-600 text-white text-sm font-bold rounded-xl shadow hover:bg-green-700 transition">
                Daftar Sekarang
              </a>
            </div>
          </div>
        </aside>

        {{-- ISI KONTEN --}}
        <div class="lg:col-span-8 xl:col-span-9 space-y-12">

          {{-- PASAL 1 --}}
          <div id="umum" class="scroll-mt-32" data-aos="fade-up">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-3">
              <span class="flex items-center justify-center w-8 h-8 bg-green-100 text-green-700 rounded-lg text-sm">1</span>
              Ketentuan Umum
            </h2>
            <div class="prose prose-green text-gray-600 max-w-none text-sm md:text-base leading-relaxed">
              <p>Selamat datang di platform <strong>Deep Quran Academy</strong>. Dengan mengakses website ini dan mendaftar sebagai santri, Anda dianggap telah membaca, memahami, dan menyetujui seluruh syarat dan ketentuan yang berlaku.</p>
              <ul class="list-disc pl-5 space-y-2 mt-2">
                <li>Lembaga ini berlandaskan pada pemahaman Ahlussunnah wal Jamaah.</li>
                <li>Kami berhak mengubah syarat dan ketentuan ini sewaktu-waktu tanpa pemberitahuan sebelumnya, namun akan diinformasikan melalui dashboard.</li>
              </ul>
            </div>
          </div>

          {{-- PASAL 2 --}}
          <div id="pendaftaran" class="scroll-mt-32" data-aos="fade-up">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-3">
              <span class="flex items-center justify-center w-8 h-8 bg-green-100 text-green-700 rounded-lg text-sm">2</span>
              Pendaftaran Santri
            </h2>
            <div class="prose prose-green text-gray-600 max-w-none text-sm md:text-base leading-relaxed">
              <p>Untuk menjadi santri resmi, calon peserta diwajibkan:</p>
              <ul class="list-disc pl-5 space-y-2 mt-2">
                <li>Mengisi formulir pendaftaran dengan data yang <strong>benar dan valid</strong>.</li>
                <li>Memiliki niat yang lurus untuk mempelajari Al-Qur'an.</li>
                <li>Menjaga kerahasiaan akun (username dan password) dashboard masing-masing.</li>
                <li>Satu akun hanya berlaku untuk satu orang santri (kecuali program keluarga yang ditentukan terpisah).</li>
              </ul>
            </div>
          </div>

          {{-- PASAL 3 --}}
          <div id="biaya" class="scroll-mt-32" data-aos="fade-up">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-3">
              <span class="flex items-center justify-center w-8 h-8 bg-green-100 text-green-700 rounded-lg text-sm">3</span>
              Biaya & Pembayaran
            </h2>
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 rounded-r-lg">
              <p class="text-sm text-yellow-800 font-medium">
                "Sebaik-baik kalian adalah yang mempelajari Al-Qur'an dan mengajarkannya." Infaq yang Anda bayarkan digunakan untuk operasional dakwah dan kafalah pengajar.
              </p>
            </div>
            <div class="prose prose-green text-gray-600 max-w-none text-sm md:text-base leading-relaxed">
              <ul class="list-disc pl-5 space-y-2 mt-2">
                <li><strong>Biaya Pendaftaran:</strong> Dibayarkan sekali di awal saat registrasi.</li>
                <li><strong>Infaq Bulanan:</strong> Tagihan akan muncul setiap tanggal 1 dan wajib dibayarkan maksimal tanggal 10 setiap bulannya.</li>
                <li>Pembayaran dianggap sah jika bukti transfer telah diupload dan diverifikasi oleh Admin melalui sistem Dashboard.</li>
                <li>Keterlambatan pembayaran berturut-turut dapat mengakibatkan penangguhan akses belajar sementara.</li>
              </ul>
            </div>
          </div>

          {{-- PASAL 4 --}}
          <div id="kbm" class="scroll-mt-32" data-aos="fade-up">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-3">
              <span class="flex items-center justify-center w-8 h-8 bg-green-100 text-green-700 rounded-lg text-sm">4</span>
              Kegiatan Belajar Mengajar (KBM)
            </h2>
            <div class="prose prose-green text-gray-600 max-w-none text-sm md:text-base leading-relaxed">
              <p>Agar proses belajar berjalan kondusif, santri wajib mematuhi aturan berikut:</p>
              <ul class="list-disc pl-5 space-y-2 mt-2">
                <li><strong>Kehadiran:</strong> Santri wajib hadir tepat waktu sesuai jadwal yang dipilih (Online/Offline).</li>
                <li><strong>Busana:</strong> Wajib menutup aurat dengan sempurna saat KBM berlangsung (termasuk saat via Zoom/Video Call).</li>
                <li><strong>Perubahan Jadwal:</strong> Jika berhalangan hadir, wajib izin kepada Admin/Ustadz minimal <strong>3 jam sebelum</strong> kelas dimulai.</li>
                <li>Jika tidak ada kabar (Alpha) lebih dari 3x dalam sebulan, pihak lembaga berhak mengevaluasi status santri.</li>
              </ul>
            </div>
          </div>

          {{-- PASAL 5 --}}
          <div id="etika" class="scroll-mt-32" data-aos="fade-up">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-3">
              <span class="flex items-center justify-center w-8 h-8 bg-green-100 text-green-700 rounded-lg text-sm">5</span>
              Adab & Etika
            </h2>
            <div class="prose prose-green text-gray-600 max-w-none text-sm md:text-base leading-relaxed">
              <p>Kami menjunjung tinggi adab dalam menuntut ilmu:</p>
              <ul class="list-disc pl-5 space-y-2 mt-2">
                <li>Bersikap sopan dan hormat kepada pengajar serta sesama santri.</li>
                <li>Dilarang keras melakukan ujaran kebencian, SARA, atau tindakan asusila di lingkungan lembaga maupun grup WhatsApp kelas.</li>
                <li>Untuk kelas Online, dilarang merekam atau menyebarkan video pengajar tanpa izin tertulis dari lembaga (terkait privasi & aurat).</li>
                <li>Interaksi antara santri dan pengajar lawan jenis dibatasi hanya seputar materi pelajaran.</li>
              </ul>
            </div>
          </div>

          {{-- PASAL 6 --}}
          <div id="pembatalan" class="scroll-mt-32" data-aos="fade-up">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-3">
              <span class="flex items-center justify-center w-8 h-8 bg-green-100 text-green-700 rounded-lg text-sm">6</span>
              Kebijakan Pembatalan
            </h2>
            <div class="prose prose-green text-gray-600 max-w-none text-sm md:text-base leading-relaxed">
              <ul class="list-disc pl-5 space-y-2 mt-2">
                <li>Biaya pendaftaran yang sudah dibayarkan <strong>tidak dapat dikembalikan</strong> (Non-refundable).</li>
                <li>Jika santri mengundurkan diri di tengah bulan, Infaq bulan berjalan tidak dapat ditarik kembali.</li>
                <li>Lembaga berhak memberhentikan santri secara sepihak jika terbukti melakukan pelanggaran berat terhadap poin-poin di atas.</li>
              </ul>
            </div>
          </div>

        </div>
      </div>

      {{-- FOOTER NOTE --}}
      <div class="mt-16 pt-8 border-t border-gray-200 text-center">
        <p class="text-gray-500 text-sm mb-6">
          Dengan menekan tombol di bawah, Anda menyatakan telah membaca dan menyetujui seluruh Syarat & Ketentuan ini.
        </p>

        {{-- TOMBOL CTA DAFTAR --}}
        <div class="mb-8">
          <a href="/login?mode=register" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-green-600 text-white font-bold rounded-full shadow-lg hover:bg-green-700 hover:shadow-green-200 transform hover:-translate-y-1 transition-all duration-300">
            <span>Saya Setuju & Daftar</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </a>
        </div>


      </div>

    </div>
  </section>

</x-layout>