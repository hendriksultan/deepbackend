<x-layout>

  {{-- SPACER NAVBAR --}}
  <div class="bg-green-700 h-[72px] md:h-20 w-full"></div>

  {{-- ================= HEADER / HERO ================= --}}
  <header class="relative bg-green-50 py-16 md:py-24 overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 -mr-20 -mt-20"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 -ml-20 -mb-20"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center" data-aos="fade-up">
      <span class="inline-block py-1 px-3 rounded-full bg-white text-green-700 text-xs font-bold uppercase tracking-wider mb-4 shadow-sm border border-green-100">
        Karir & Pengabdian
      </span>
      <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-6 leading-tight">
        Bergabunglah Menjadi Bagian dari <br>
        <span class="text-green-600">Kafilah Dakwah Al-Qur'an</span>
      </h1>
      <p class="text-gray-500 text-lg leading-relaxed max-w-2xl mx-auto">
        Kami mencari pengajar yang tidak hanya kompeten secara keilmuan, namun juga memiliki visi dakwah untuk mencetak generasi Qur'ani.
      </p>
    </div>
  </header>

  {{-- ================= PERSYARATAN & BENEFIT ================= --}}
  {{-- [PERBAIKAN]: Menambahkan overflow-x-hidden di section ini --}}
  <section class="py-16 bg-white overflow-x-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

        {{-- Kualifikasi --}}
        <div data-aos="fade-right">
          <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
            <span class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </span>
            Kualifikasi Umum
          </h3>
          <ul class="space-y-4">
            <li class="flex items-start gap-3">
              <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span class="text-gray-600">Muslim/Muslimah, berakhlak mulia & tidak merokok.</span>
            </li>
            <li class="flex items-start gap-3">
              <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span class="text-gray-600">Memiliki hafalan Al-Qur'an (Minimal 3 Juz, 30 Juz diutamakan).</span>
            </li>
            <li class="flex items-start gap-3">
              <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span class="text-gray-600">Memiliki bacaan yang fasih sesuai kaidah tajwid (Bersanad lebih disukai).</span>
            </li>
            <li class="flex items-start gap-3">
              <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span class="text-gray-600">Memahami Bahasa Arab dasar (Pasif/Aktif).</span>
            </li>
            <li class="flex items-start gap-3">
              <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span class="text-gray-600">Siap mengajar secara Offline atau Online sesuai penempatan.</span>
            </li>
          </ul>
        </div>

        {{-- Benefit --}}
        <div data-aos="fade-left">
          <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
            <span class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center text-yellow-600">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </span>
            Benefit Pengajar
          </h3>
          <ul class="space-y-4">
            <li class="flex items-start gap-3">
              <span class="w-2 h-2 bg-yellow-400 rounded-full mt-2"></span>
              <span class="text-gray-600">Mukafaah (Gaji) yang kompetitif & tepat waktu.</span>
            </li>
            <li class="flex items-start gap-3">
              <span class="w-2 h-2 bg-yellow-400 rounded-full mt-2"></span>
              <span class="text-gray-600">Pembinaan rutin & Talaqqi bersanad untuk pengajar.</span>
            </li>
            <li class="flex items-start gap-3">
              <span class="w-2 h-2 bg-yellow-400 rounded-full mt-2"></span>
              <span class="text-gray-600">Lingkungan kerja yang Islami dan mendukung keshalihan.</span>
            </li>
            <li class="flex items-start gap-3">
              <span class="w-2 h-2 bg-yellow-400 rounded-full mt-2"></span>
              <span class="text-gray-600">Jenjang karir (Koordinator, Kepala Cabang, dll).</span>
            </li>
          </ul>
        </div>

      </div>
    </div>
  </section>

  {{-- ================= FORMULIR PENDAFTARAN ================= --}}
  {{-- ================= FORMULIR PENDAFTARAN (FINAL FIX) ================= --}}
  <section class="py-16 bg-gray-50 border-t border-gray-100" id="form-lamaran">
    <div class="max-w-4xl mx-auto px-4">

      <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-green-600 px-8 py-6 text-white text-center">
          <h2 class="text-2xl font-bold">Formulir Biodata Pelamar</h2>
          <p class="text-green-100 text-sm mt-1">Silakan isi data dengan jujur dan lengkap.</p>
        </div>

        <div class="p-8 md:p-10">

          {{-- ALERT SUKSES --}}
          @if(session('success'))
          <div class="mb-8 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl flex items-start gap-3">
            <svg class="w-6 h-6 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
              <strong class="font-bold block">Alhamdulillah!</strong>
              <span>{{ session('success') }}</span>
            </div>
          </div>
          @endif

          {{-- ALERT ERROR UMUM --}}
          @if ($errors->any())
          <div class="mb-8 bg-red-50 border border-red-200 text-red-600 px-6 py-4 rounded-xl text-sm">
            <strong class="font-bold flex items-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Mohon Periksa Kembali:
            </strong>
            <ul class="list-disc pl-5 mt-2 space-y-1">
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <form action="{{ route('career.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-8"
            x-data="{ isLoading: false }"
            @submit="isLoading = true">

            @csrf

            {{-- ========================================================= --}}
            {{-- SECURITY: HONEYPOT (JEBAKAN BOT) --}}
            {{-- ========================================================= --}}
            <div style="display: none; opacity: 0; position: absolute; left: -9999px;">
              <label for="bot_trap">JANGAN DIISI jika Anda manusia</label>
              <input type="text" name="bot_trap" id="bot_trap" tabindex="-1" autocomplete="off">
            </div>

            {{-- BAGIAN 1: DATA PRIBADI --}}
            <div>
              <h3 class="text-lg font-bold text-gray-900 border-b pb-2 mb-4 border-gray-100">1. Data Pribadi</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap (Sesuai KTP)</label>
                  <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                </div>
                <div>
                  <label class="block text-sm font-bold text-gray-700 mb-2">Email Aktif</label>
                  <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                </div>
                <div>
                  <label class="block text-sm font-bold text-gray-700 mb-2">No. WhatsApp</label>
                  <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="08xxxx" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tempat Lahir</label>
                    <input type="text" name="pob" value="{{ old('pob') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 outline-none">
                  </div>
                  <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tgl Lahir</label>
                    <input type="date" name="dob" value="{{ old('dob') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 outline-none">
                  </div>
                </div>
                <div>
                  <label class="block text-sm font-bold text-gray-700 mb-2">Jenis Kelamin</label>
                  <select name="gender" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 outline-none bg-white appearance-none bg-no-repeat bg-[right_1rem_center] bg-[length:16px_auto] pr-10">
                    <option value="">Pilih...</option>
                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                  </select>
                </div>

                <div>
                  <label class="block text-sm font-bold text-gray-700 mb-2">Status Pernikahan</label>
                  <select name="marital_status" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 outline-none bg-white appearance-none bg-no-repeat bg-[right_1rem_center] bg-[length:16px_auto] pr-10">
                    <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Belum Menikah</option>
                    <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Menikah</option>
                  </select>
                </div>
                <div class="md:col-span-2">
                  <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Domisili Saat Ini</label>
                  <textarea name="address" required rows="2" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 outline-none">{{ old('address') }}</textarea>
                </div>
              </div>
            </div>

            {{-- BAGIAN 2: PENDIDIKAN & KOMPETENSI --}}
            <div>
              <h3 class="text-lg font-bold text-gray-900 border-b pb-2 mb-4 border-gray-100">2. Pendidikan & Kompetensi</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-bold text-gray-700 mb-2">Pendidikan Terakhir</label>
                  <select name="last_education" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 outline-none bg-white appearance-none bg-no-repeat bg-[right_1rem_center] bg-[length:16px_auto] pr-10">
                    <option value="SMA/MA" {{ old('last_education') == 'SMA/MA' ? 'selected' : '' }}>SMA / MA / Sederajat</option>
                    <option value="D3" {{ old('last_education') == 'D3' ? 'selected' : '' }}>Diploma (D3)</option>
                    <option value="S1" {{ old('last_education') == 'S1' ? 'selected' : '' }}>Sarjana (S1)</option>
                    <option value="Ma'had" {{ old('last_education') == "Ma'had" ? 'selected' : '' }}>Lulusan Ma'had/Pesantren</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-bold text-gray-700 mb-2">Nama Kampus / Pesantren</label>
                  <input type="text" name="institution" value="{{ old('institution') }}" required placeholder="Contoh: LIPIA Jakarta" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 outline-none">
                </div>
                <div>
                  <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Hafalan (Juz)</label>
                  <input type="text" name="memorization_juz" value="{{ old('memorization_juz') }}" required placeholder="Contoh: 5 Juz / 30 Juz" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 outline-none">
                </div>
                <div>
                  <label class="block text-sm font-bold text-gray-700 mb-2">Kemampuan Bahasa Arab</label>
                  <select name="arabic_skill" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 outline-none bg-white appearance-none bg-no-repeat bg-[right_1rem_center] bg-[length:16px_auto] pr-10">
                    <option value="Pemula" {{ old('arabic_skill') == 'Pemula' ? 'selected' : '' }}>Pemula (Dasar)</option>
                    <option value="Pasif" {{ old('arabic_skill') == 'Pasif' ? 'selected' : '' }}>Pasif (Bisa Baca Kitab)</option>
                    <option value="Aktif" {{ old('arabic_skill') == 'Aktif' ? 'selected' : '' }}>Aktif (Lancar Bicara)</option>
                  </select>
                </div>

                <div class="md:col-span-2 bg-green-50 p-4 rounded-xl border border-green-100">
                  <div class="flex items-center gap-2 mb-3">
                    <input type="checkbox" id="has_sanad" name="has_sanad" class="w-5 h-5 text-green-600 rounded focus:ring-green-500" {{ old('has_sanad') ? 'checked' : '' }}>
                    <label for="has_sanad" class="font-bold text-gray-800">Saya Memiliki Sanad / Ijazah Al-Qur'an</label>
                  </div>
                  <div x-data="{ show: {{ old('has_sanad') ? 'true' : 'false' }} }" x-init="$watch('show', value => show = value)" @change="show = $event.target.checked">
                    <textarea name="sanad_details" placeholder="Jelaskan detail sanad Anda (Riwayat, Guru, Jalur, dll)" rows="2" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 outline-none bg-white placeholder-gray-400">{{ old('sanad_details') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">*Kosongkan jika tidak memiliki sanad</p>
                  </div>
                </div>
              </div>
            </div>

            {{-- BAGIAN 3: UPLOAD BERKAS --}}
            <div>
              <h3 class="text-lg font-bold text-gray-900 border-b pb-2 mb-4 border-gray-100">3. Upload Berkas</h3>
              <div class="space-y-6">

                {{-- 1. Upload CV --}}
                <div x-data="{ fileName: null }">
                  <label class="block text-sm font-bold text-gray-700 mb-2">Curriculum Vitae (CV) <span class="text-red-500">*</span></label>
                  <div class="flex items-center justify-center w-full">
                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-xl cursor-pointer transition"
                      :class="fileName ? 'border-green-500 bg-green-50' : 'border-gray-300 bg-gray-50 hover:bg-gray-100'">

                      {{-- Tampilan Sebelum Upload --}}
                      <div class="flex flex-col items-center justify-center pt-5 pb-6" x-show="!fileName">
                        <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload CV</span> (PDF)</p>
                        <p class="text-xs text-gray-500">Max. 2MB</p>
                      </div>

                      {{-- Tampilan SESUDAH Upload --}}
                      <div class="flex flex-col items-center justify-center pt-5 pb-6" x-show="fileName" x-cloak>
                        <svg class="w-8 h-8 mb-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-bold text-gray-800" x-text="fileName"></p>
                        <p class="text-xs text-green-600 mt-1">Klik lagi untuk mengganti</p>
                      </div>

                      <input type="file" name="cv_file" required accept=".pdf" class="hidden" @change="fileName = $event.target.files[0].name" />
                    </label>
                  </div>
                  {{-- Error Message CV --}}
                  @error('cv_file') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  {{-- 2. Upload Foto --}}
                  <div x-data="{ fileName: null }">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Pas Foto Terbaru <span class="text-red-500">*</span></label>
                    <label class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed rounded-xl cursor-pointer transition"
                      :class="fileName ? 'border-green-500 bg-green-50' : 'border-gray-300 bg-gray-50 hover:bg-gray-100'">
                      <div x-show="!fileName" class="text-center"><span class="text-sm text-gray-500 font-semibold">Pilih Foto (JPG/PNG)</span></div>
                      <div x-show="fileName" class="text-center" x-cloak>
                        <p class="text-sm font-bold text-gray-800 truncate px-2" x-text="fileName"></p>
                      </div>
                      <input type="file" name="photo_file" required accept="image/*" class="hidden" @change="fileName = $event.target.files[0].name">
                    </label>
                    {{-- Error Message Foto --}}
                    @error('photo_file') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                  </div>

                  {{-- 3. Upload Sertifikat --}}
                  <div x-data="{ fileName: null }">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Sertifikat Sanad / Ijazah</label>
                    <label class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed rounded-xl cursor-pointer transition"
                      :class="fileName ? 'border-green-500 bg-green-50' : 'border-gray-300 bg-gray-50 hover:bg-gray-100'">
                      <div x-show="!fileName" class="text-center"><span class="text-sm text-gray-500 font-semibold">Pilih File (PDF/Gambar)</span></div>
                      <div x-show="fileName" class="text-center" x-cloak>
                        <p class="text-sm font-bold text-gray-800 truncate px-2" x-text="fileName"></p>
                      </div>
                      <input type="file" name="certificate_file" accept=".pdf,.jpg,.png" class="hidden" @change="fileName = $event.target.files[0].name">
                    </label>
                    {{-- Error Message Sertifikat --}}
                    @error('certificate_file') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                  </div>
                </div>

              </div>
            </div>

            {{-- SUBMIT BUTTON --}}
            <div class="pt-6 border-t border-gray-100">
              <button type="submit"
                :disabled="isLoading"
                :class="isLoading ? 'bg-green-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700 hover:shadow-green-200 hover:-translate-y-1'"
                class="w-full md:w-auto px-8 py-4 text-white font-bold rounded-xl shadow-lg transition-all duration-300 flex items-center justify-center gap-3">

                {{-- Ikon Normal --}}
                <svg x-show="!isLoading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>

                {{-- Ikon Loading --}}
                <svg x-show="isLoading" x-cloak class="animate-spin w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                {{-- Teks --}}
                <span x-text="isLoading ? 'Sedang Mengirim...' : 'Kirim Lamaran'"></span>
              </button>

              <p class="text-center text-xs text-gray-400 mt-4">
                Data Anda aman dan hanya digunakan untuk proses rekrutmen.
              </p>
            </div>

          </form>
        </div>
      </div>
    </div>
  </section>

</x-layout>