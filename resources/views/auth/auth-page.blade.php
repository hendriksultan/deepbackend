<!DOCTYPE html>

<html lang="id">



<head>

  <meta charset="UTF-8">

  <title>Masuk & Daftar | Deep Quran Academy</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

  <link rel="icon" href="{{ asset('images/pavicon.png') }}" type="image/png">



  {{-- ========================================== --}}

  {{-- TAG UNTUK PWA --}}

  {{-- ========================================== --}}

  <link rel="manifest" href="/manifest.json">

  <meta name="theme-color" content="#15803d">

  <link rel="apple-touch-icon" href="/images/pavicon.png">

  <meta name="apple-mobile-web-app-capable" content="yes">

  <meta name="apple-mobile-web-app-status-bar-style" content="default">

  {{-- ========================================== --}}



  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

  <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>



  <style>

    /* Mencegah user melakukan seleksi teks di seluruh halaman */

    body {

        -webkit-user-select: none;

        -moz-user-select: none;

        -ms-user-select: none;

        user-select: none;

    }

    /* Pengecualian: Izinkan user mengetik di form input & textarea */

    input, textarea {

        -webkit-user-select: text;

        -moz-user-select: text;

        -ms-user-select: text;

        user-select: text;

    }

  </style>

</head>



<body class="min-h-screen bg-white font-sans text-gray-800 relative overflow-x-hidden">



  {{-- CONTAINER UTAMA: SPLIT SCREEN --}}

  <div class="flex min-h-screen w-full">



    {{-- ========================================================== --}}

    {{-- KOLOM KIRI: BANNER BRANDING (HANYA TAMPIL DI DESKTOP/TABLET) --}}

    {{-- ========================================================== --}}

    <div class="hidden md:flex md:w-1/2 lg:w-7/12 flex-col items-center justify-center p-12 text-center relative" style="background: linear-gradient(135deg, #059669 0%, #064e3b 100%);">



      <div class="relative z-10 flex flex-col items-center">

        <div class="bg-white p-4 rounded-full shadow-2xl mb-8">

            <img src="{{ asset('images/pavicon.png') }}" alt="Logo Deep Quran" class="w-20 h-20 lg:w-24 lg:h-24 object-contain">

        </div>



        <h1 class="text-3xl lg:text-4xl font-bold text-white tracking-tight mb-4">

          Deep Quran Academy

        </h1>



        <p class="max-w-md mx-auto leading-relaxed text-sm lg:text-base opacity-90 text-green-50">

          Platform pembelajaran tahsin dan bahasa Arab interaktif. Silakan masuk untuk mengakses jadwal, materi, dan capaian hafalan Anda.

        </p>

      </div>

    </div>



    {{-- ========================================================== --}}

    {{-- KOLOM KANAN: FORM LOGIN/REGISTER (TAMPIL DI SEMUA DEVICE) --}}

    {{-- ========================================================== --}}

    <div class="w-full md:w-1/2 lg:w-5/12 flex flex-col justify-center px-6 py-12 lg:px-16 bg-white relative">



      <div class="w-full max-w-sm mx-auto">



        {{-- HEADER FORM --}}

        <div class="mb-8 md:mb-10 text-center md:text-left">



          {{-- [MODIFIKASI] Logo Header Mobile (Teks dihilangkan, logo sedikit diperbesar) --}}

          <div class="flex justify-center mb-8 md:hidden">

            <img src="{{ asset('images/pavicon.png') }}" alt="Logo Deep Quran" class="h-14 w-auto object-contain drop-shadow-sm">

          </div>



          @if(request('mode') === 'register')

          <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Daftar Akun</h1>

          <p class="text-sm text-gray-500 mt-1.5">Gabung menjadi santri kami</p>

          @else

          <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Selamat Datang</h1>

          <p class="text-sm text-gray-500 mt-1.5">Silakan masuk ke akun Anda</p>

          @endif

        </div>



        {{-- NOTIFIKASI SUKSES --}}

        @if(session('success'))

        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 text-green-800 text-sm flex items-start gap-3">

          <div class="bg-green-100 p-1.5 rounded-full mt-0.5">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">

              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />

            </svg>

          </div>

          <div>

            <p class="font-bold">Berhasil!</p>

            <p class="opacity-90">{{ session('success') }}</p>

          </div>

        </div>

        @endif



        {{-- ERROR --}}

        @if($errors->any())

        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm">

          <div class="flex items-center gap-2 mb-1">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">

              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />

            </svg>

            <span class="font-bold">Terjadi Kesalahan</span>

          </div>

          <ul class="list-disc list-inside ml-1 opacity-90">

            @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

            @endforeach

          </ul>

        </div>

        @endif



        {{-- ================= FORM LOGIN ================= --}}

        @if(request('mode') !== 'register')

        <form method="POST" action="{{ route('login.process') }}" class="space-y-4">

          @csrf



          <div class="space-y-1.5">

            <label class="text-sm font-bold text-gray-700">Email</label>

            <input

              type="email"

              name="email"

              required

              placeholder="nama@email.com"

              value="{{ old('email') }}"

              class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-all text-sm">

          </div>



          <div class="space-y-1.5">

            <div class="flex items-center justify-between">

              <label class="text-sm font-bold text-gray-700">Password</label>

              <a href="{{ route('password.request') }}" tabindex="-1" class="text-xs font-bold text-green-600 hover:text-green-800 transition-colors">

                Lupa password?

              </a>

            </div>

            <input

              type="password"

              name="password"

              required

              placeholder="••••••••"

              class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-all text-sm">

          </div>



          {{-- [MODIFIKASI] Posisi Turnstile dikunci di tengah (Center) agar selalu simetris --}}

          @unless(app()->environment('local'))
          <div class="flex justify-center w-full mt-4 mb-2">

            <div class="cf-turnstile" data-sitekey="{{ env('TURNSTILE_SITE_KEY') }}" data-theme="light"></div>

          </div>
          @endunless



          <button

            type="submit"

            class="w-full py-3.5 mt-2 rounded-xl bg-green-700 text-white text-sm font-bold hover:bg-green-800 transition transform active:scale-[0.98] shadow-lg shadow-green-100">

            Masuk

          </button>

        </form>



        <div class="mt-8 text-center">

          <p class="text-sm text-gray-500">

            Belum punya akun?

            <a href="{{ route('login', ['mode' => 'register']) }}"

              class="text-green-700 font-bold hover:underline decoration-2 underline-offset-4">

              Daftar di sini

            </a>

          </p>

        </div>

        @endif



        {{-- ================= FORM REGISTER ================= --}}

        @if(request('mode') === 'register')

        <form method="POST" action="{{ route('register.process') }}" class="space-y-3.5">

          @csrf



          <div class="space-y-1.5">

            <label class="text-sm font-bold text-gray-700">Nama Lengkap</label>

            <input

              name="name"

              required

              placeholder="Contoh: Ahmad Fauzi"

              value="{{ old('name') }}"

              class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-all text-sm">

          </div>



          <div class="space-y-1.5">

            <label class="text-sm font-bold text-gray-700">Email</label>

            <input

              type="email"

              name="email"

              required

              placeholder="email@baru.com"

              value="{{ old('email') }}"

              class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-all text-sm">

          </div>



          <div class="grid grid-cols-2 gap-4">

            <div class="space-y-1.5">

              <label class="text-sm font-bold text-gray-700">Password</label>

              <input

                type="password"

                name="password"

                required

                placeholder="••••••••"

                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-all text-sm">

            </div>

            <div class="space-y-1.5">

              <label class="text-sm font-bold text-gray-700">Konfirmasi</label>

              <input

                type="password"

                name="password_confirmation"

                required

                placeholder="••••••••"

                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-all text-sm">

            </div>

          </div>



          <div class="flex items-start gap-3 mt-4">

                <div class="flex items-center h-5">

                    {{-- [MODIFIKASI] Menambahkan style="accent-color: #059669;" untuk menimpa warna biru default browser --}}

                    <input

                        id="terms"

                        name="terms"

                        type="checkbox"

                        required

                        class="w-4 h-4 border border-gray-300 rounded bg-white focus:ring-2 focus:ring-green-500 cursor-pointer"

                        style="accent-color: #059669;">

                </div>

                <label for="terms" class="text-[13px] text-gray-500 cursor-pointer select-none leading-snug">

                    Saya menyetujui <a href="{{ route('terms') }}" target="_blank" class="font-bold text-green-600 hover:underline">Syarat & Ketentuan</a> serta <a href="{{ route('privacy') }}" target="_blank" class="font-bold text-green-600 hover:underline">Kebijakan Privasi</a>.

                </label>

            </div>



          {{-- [MODIFIKASI] Posisi Turnstile dikunci di tengah (Center) agar selalu simetris --}}

          <div class="flex justify-center w-full mt-4 mb-2">

            <div class="cf-turnstile" data-sitekey="{{ env('TURNSTILE_SITE_KEY') }}" data-theme="light"></div>

          </div>



          <button

            type="submit"

            class="w-full py-3.5 mt-2 rounded-xl bg-green-700 text-white text-sm font-bold hover:bg-green-800 transition transform active:scale-[0.98] shadow-lg shadow-green-100">

            Daftar

          </button>

        </form>



        <div class="mt-8 text-center">

          <p class="text-sm text-gray-500">

            Sudah punya akun?

            <a href="{{ route('login') }}"

              class="text-green-700 font-bold hover:underline decoration-2 underline-offset-4">

              Masuk di sini

            </a>

          </p>

        </div>

        @endif



        <div class="mt-12 text-center border-t border-gray-100 pt-6">

            <p class="text-xs text-gray-400">© {{ date('Y') }} Deep Quran Academy.</p>

        </div>



      </div>

    </div>

  </div>



  {{-- ========================================== --}}

  {{-- REGISTRASI SERVICE WORKER PWA --}}

  {{-- ========================================== --}}

  <script>

    if ('serviceWorker' in navigator) {

      window.addEventListener('load', () => {

        navigator.serviceWorker.register('/sw.js')

          .then(registration => {

            console.log('PWA ServiceWorker berhasil didaftarkan!');

          })

          .catch(error => {

            console.log('PWA ServiceWorker gagal didaftarkan:', error);

          });

      });

    }

  </script>



  {{-- ========================================== --}}

  {{-- POP-UP CUSTOM INSTALL PWA ANDROID --}}

  {{-- ========================================== --}}

  <div id="pwa-install-prompt" class="fixed bg-white rounded-2xl border border-gray-100 p-5 flex items-start gap-4" 

       style="

            z-index: 99999;

            bottom: 24px;

            left: 24px;

            width: calc(100% - 48px);

            max-width: 380px;

            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.2);

            transform: translateY(150%);

            opacity: 0;

            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);

            visibility: hidden;

       ">

      <div class="shrink-0">

          <img src="{{ asset('images/pavicon.png') }}" alt="App Icon" class="w-12 h-12 rounded-xl shadow-sm object-cover">

      </div>

      <div class="flex-1">

          <h3 class="font-bold text-gray-800 text-sm">Install Aplikasi</h3>

          <p class="text-xs text-gray-500 mt-1">Akses jadwal, materi, dan hafalan lebih cepat langsung dari layar utama HP Anda.</p>

          <div class="flex gap-2 mt-3">

              <button id="pwa-install-btn" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl transition-colors shadow-lg active:scale-95 transform">Install Sekarang</button>

              <button id="pwa-close-btn" class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold py-2.5 px-4 rounded-xl transition-colors active:scale-95 transform">Nanti Saja</button>

          </div>

      </div>

  </div>



  <script>

    let deferredPrompt;

    const installPrompt = document.getElementById('pwa-install-prompt');

    const installBtn = document.getElementById('pwa-install-btn');

    const closeBtn = document.getElementById('pwa-close-btn');



    function showInstallPrompt() {

        installPrompt.style.visibility = 'visible';

        installPrompt.style.transform = 'translateY(0)';

        installPrompt.style.opacity = '1';

    }



    function hideInstallPrompt() {

        installPrompt.style.transform = 'translateY(150%)';

        installPrompt.style.opacity = '0';

        setTimeout(() => {

            installPrompt.style.visibility = 'hidden';

        }, 500); 

    }



    window.addEventListener('beforeinstallprompt', (e) => {

        e.preventDefault();

        deferredPrompt = e;

        setTimeout(showInstallPrompt, 100);

    });



    if (window.location.search.includes('test=1')) {

        setTimeout(showInstallPrompt, 1000);

    }



    installBtn.addEventListener('click', async () => {

        if (deferredPrompt !== null && deferredPrompt !== undefined) {

            hideInstallPrompt();

            deferredPrompt.prompt();

            const { outcome } = await deferredPrompt.userChoice;

            console.log(`User memilih: ${outcome}`);

            deferredPrompt = null;

        } else {

            alert("Ini adalah mode testing. Untuk menginstall, hilangkan ?test=1 dari URL.");

            hideInstallPrompt();

        }

    });



    closeBtn.addEventListener('click', hideInstallPrompt);



    window.addEventListener('appinstalled', () => {

        hideInstallPrompt();

        console.log('PWA berhasil di-install!');

    });



    document.addEventListener('contextmenu', function(e) { e.preventDefault(); });

    document.addEventListener('keydown', function(e) {

        if (e.ctrlKey && (e.key === 'c' || e.key === 'x' || e.key === 'v' || e.key === 'C' || e.key === 'X' || e.key === 'V')) { e.preventDefault(); }

    });

    document.addEventListener('copy', function(e) { e.preventDefault(); });

    document.onkeydown = function(e) {

        if (e.key === "F12") return false;

        if (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i')) return false;

        if (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c')) return false;

        if (e.ctrlKey && (e.key === 'U' || e.key === 'u')) return false;

    };

  </script>



</body>

</html>