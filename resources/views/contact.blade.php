<x-layout>

  {{-- SPACER NAVBAR --}}
  <div class="bg-green-700 h-[72px] md:h-20 w-full"></div>

  {{-- ================= HEADER ================= --}}
  <header class="bg-green-50 py-12 md:py-20 text-center px-4 relative overflow-hidden">
    {{-- Hiasan Background --}}
    <div class="absolute top-0 right-0 w-64 h-64 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse -mr-16 -mt-16"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 -ml-16 -mb-16"></div>

    <div class="relative z-10 max-w-3xl mx-auto" data-aos="fade-up">
      <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-6">
        Hubungi <span class="text-green-600">Kami</span>
      </h1>
      <p class="text-gray-500 text-lg leading-relaxed">
        Punya pertanyaan seputar pendaftaran, program belajar, atau ingin berkunjung ke markaz? Tim kami siap membantu Anda.
      </p>
    </div>
  </header>

  {{-- ================= KONTEN KONTAK ================= --}}
  {{-- [PERBAIKAN]: Tambah overflow-x-hidden di section ini untuk mencegah layout melebar akibat AOS --}}
  <section class="py-16 bg-white min-h-screen relative overflow-x-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">

        {{-- KOLOM KIRI: INFO KONTAK --}}
        <div class="space-y-8">

          {{-- Intro Text --}}
          <div data-aos="fade-right">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Informasi Kontak</h2>
            <p class="text-gray-600 leading-relaxed">
              Kami melayani konsultasi setiap hari Senin - Sabtu pada jam kerja (08.00 - 16.00 WIB). Jangan ragu untuk menghubungi kami melalui saluran di bawah ini.
            </p>
          </div>

          {{-- Card 1: WhatsApp (Primary) --}}
          <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition duration-300 flex items-start gap-4" data-aos="fade-up" data-aos-delay="100">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 flex-shrink-0">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
              </svg>
            </div>
            <div>
              <h3 class="font-bold text-gray-900 mb-1">WhatsApp Admin</h3>
              <p class="text-sm text-gray-500 mb-2">Respon cepat (Fast Response)</p>
              <a href="https://wa.me/6285860913931" target="_blank" class="text-green-600 font-bold hover:underline">
                +62 858-6091-3931
              </a>
            </div>
          </div>

          {{-- Card 2: Email & Lokasi --}}
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" data-aos="fade-up" data-aos-delay="200">
            {{-- Email --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-start gap-3 min-w-0 overflow-hidden">
              <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
              </div>
              <div class="w-full min-w-0">
                <h3 class="font-bold text-gray-900 text-sm">Email</h3>
                {{-- break-all sangat penting agar email tidak keluar kotak di layar kecil --}}
                <a href="mailto:admin@deepquranacademy.id" class="text-sm text-gray-500 hover:text-blue-600 break-all block">admin@deepquranacademy.id</a>
              </div>
            </div>

            {{-- Lokasi --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-start gap-3 min-w-0">
              <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center text-red-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
              </div>
              <div>
                <h3 class="font-bold text-gray-900 text-sm">Markaz Pusat</h3>
                <p class="text-sm text-gray-500">Jl. Gungjaya, Cisaat, Sukabumi, Indonesia</p>
              </div>
            </div>
          </div>

          {{-- Social Media Links --}}
          <div class="pt-4" data-aos="fade-up" data-aos-delay="300">
            <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Ikuti Kami</h4>
            <div class="flex gap-4">
              <a href="#" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-blue-600 hover:text-white transition duration-300">
                <span class="sr-only">Facebook</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                </svg>
              </a>
              <a href="#" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-green-600 hover:text-white transition duration-300">
                <span class="sr-only">Instagram</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468 3.2c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.821-.049.975-.045 1.504-.207 1.857-.344.467-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.049-3.821-.045-.975-.207-1.504-.344-1.857a4.988 4.988 0 00-.748-1.15 4.985 4.985 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                </svg>
              </a>
              <a href="#" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-red-600 hover:text-white transition duration-300">
                <span class="sr-only">YouTube</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 01-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 01-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 011.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418zM15.194 12 10 15V9l5.194 3z" clip-rule="evenodd" />
                </svg>
              </a>
            </div>
          </div>
        </div>

        {{-- KOLOM KANAN: FORM & PETA --}}
        <div class="space-y-8" data-aos="fade-left">

          {{-- Form Kontak Database --}}
          <div class="bg-white p-8 rounded-[20px] shadow-lg border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-green-50 rounded-bl-[4rem] -mr-4 -mt-4"></div>

            <h3 class="text-xl font-bold text-gray-900 mb-6 relative z-10">Kirim Pesan</h3>

            {{-- 1. ALERT SUKSES --}}
            @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative z-10 flex items-center gap-2" role="alert">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <div>
                <strong class="font-bold">Terima Kasih!</strong>
                <span class="block sm:inline text-sm">{{ session('success') }}</span>
              </div>
            </div>
            @endif

            {{-- 2. ALERT ERROR (Wajib ada agar ketahuan jika gagal kirim) --}}
            @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl relative z-10 text-sm">
              <strong class="font-bold flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                Gagal Mengirim:
              </strong>
              <ul class="list-disc pl-5 mt-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif

            <form action="{{ route('contact.store') }}"
              method="POST"
              class="space-y-5 relative z-10"
              x-data="{ isLoading: false }"
              @submit="isLoading = true">

              @csrf

              {{-- SECURITY: HONEYPOT --}}
              <div style="display: none; opacity: 0; position: absolute; left: -9999px;">
                <label for="bot_trap">JANGAN DIISI jika Anda manusia</label>
                <input type="text" name="bot_trap" id="bot_trap" tabindex="-1" autocomplete="off">
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Input Nama --}}
                <div>
                  <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Lengkap</label>
                  <input type="text" name="name" value="{{ old('name') }}" required placeholder="Fulan bin Fulan"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none transition bg-gray-50/50 @error('name') border-red-500 ring-1 ring-red-200 @enderror">
                  @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Input Email/HP --}}
                <div>
                  <label class="block text-sm font-bold text-gray-700 mb-1.5">Email / No. HP</label>
                  <input type="text" name="email" value="{{ old('email') }}" required placeholder="0812... / email@contoh.com"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none transition bg-gray-50/50 @error('email') border-red-500 ring-1 ring-red-200 @enderror">
                  @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
              </div>

              {{-- Input Subjek --}}
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Subjek</label>
                <select name="subject" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none transition bg-gray-50/50 bg-no-repeat bg-[right_1rem_center] bg-[size:16px_auto] pr-10 appearance-none">
                  <option value="Info Pendaftaran" {{ old('subject') == 'Info Pendaftaran' ? 'selected' : '' }}>Informasi Pendaftaran</option>
                  <option value="Kerjasama" {{ old('subject') == 'Kerjasama' ? 'selected' : '' }}>Kerjasama / Donasi</option>
                  <option value="Keluhan" {{ old('subject') == 'Keluhan' ? 'selected' : '' }}>Keluhan / Saran</option>
                  <option value="Lainnya" {{ old('subject') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
              </div>

              {{-- Input Pesan --}}
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Pesan</label>
                <textarea name="message" required rows="4" placeholder="Tulis pesan Anda di sini..."
                  class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none transition bg-gray-50/50 @error('message') border-red-500 ring-1 ring-red-200 @enderror">{{ old('message') }}</textarea>
                @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              </div>

              {{-- TOMBOL SUBMIT --}}
              <button type="submit"
                :disabled="isLoading"
                :class="isLoading ? 'bg-green-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700 hover:shadow-green-200 hover:-translate-y-1'"
                class="w-full py-3.5 text-white font-bold rounded-xl shadow-lg transition-all duration-300 flex items-center justify-center gap-2">

                {{-- Ikon Normal --}}
                <svg x-show="!isLoading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>

                {{-- Ikon Loading Spinner --}}
                <svg x-show="isLoading" x-cloak class="animate-spin w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                {{-- Teks --}}
                <span x-text="isLoading ? 'Mengirim...' : 'Kirim Pesan'"></span>
              </button>

            </form>
          </div>

          {{-- Google Maps Embed (Static Example) --}}
          <div class="rounded-[20px] overflow-hidden shadow-md border border-gray-200 h-64 relative group">
            {{-- Placeholder Map Image (Jika Embed Gagal) --}}
            <div class="absolute inset-0 bg-gray-200 flex items-center justify-center">
              <span class="text-gray-400 font-bold">Memuat Peta...</span>
            </div>

            {{-- IFRAME GOOGLE MAPS (Ganti URL 'src' dengan embed map lokasi asli Anda) --}}
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9582.894253803119!2d106.89712584455556!3d-6.882558120913474!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68370076764241%3A0x81d53cc12829abac!2sKavling%20gunung%20jaya%20jln%20alam%20indah%207%20dlm%20kontrakan%20hijau!5e1!3m2!1sid!2sid!4v1774667713807!5m2!1sid!2sid"
              width="100%"
              height="100%"
              style="border:0;"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              class="relative z-10 w-full h-full grayscale group-hover:grayscale-0 transition duration-500">
            </iframe>
          </div>

        </div>

      </div>
    </div>
  </section>

</x-layout>