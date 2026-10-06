<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Lupa Password | Deep Quran Academy</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
  <link rel="icon" href="{{ asset('images/pavicon.png') }}" type="image/png">
  
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
  
  <style>
    /* Mencegah user melakukan seleksi teks di seluruh halaman untuk konsistensi UI */
    body {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
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
        
        <h1 class="text-3xl lg:text-4xl font-extrabold text-white tracking-tight mb-4">
          Deep Quran Academy
        </h1>
        
        <p class="max-w-md mx-auto leading-relaxed text-sm lg:text-base opacity-90 text-green-50">
          Platform pembelajaran tahsin dan bahasa Arab interaktif. Kembalikan akses akun Anda dengan mudah dan aman.
        </p>
      </div>
    </div>

    {{-- ========================================================== --}}
    {{-- KOLOM KANAN: FORM LUPA PASSWORD (TAMPIL DI SEMUA DEVICE) --}}
    {{-- ========================================================== --}}
    <div class="w-full md:w-1/2 lg:w-5/12 flex flex-col justify-center px-6 py-12 lg:px-16 bg-white relative">
      
      <div class="w-full max-w-sm mx-auto">
        
        {{-- HEADER FORM --}}
        <div class="mb-8 md:mb-10 text-center md:text-left">
          
          {{-- Logo Header Mobile (Teks dihilangkan, sisa logo saja seperti halaman Login) --}}
          <div class="flex justify-center mb-8 md:hidden">
            <img src="{{ asset('images/pavicon.png') }}" alt="Logo Deep Quran" class="h-14 w-auto object-contain drop-shadow-sm">
          </div>

          <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Lupa Password?</h1>
          <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">Masukkan email yang terdaftar. Kami akan mengirimkan tautan untuk mengatur ulang password Anda.</p>
        </div>

        {{-- NOTIFIKASI SUKSES --}}
        @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 text-green-800 text-sm flex items-start gap-3">
          <svg class="w-5 h-5 flex-shrink-0 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <p class="font-bold">{{ session('success') }}</p>
        </div>
        @endif

        {{-- ERROR --}}
        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm flex items-start gap-3">
          <svg class="w-5 h-5 flex-shrink-0 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <p class="font-bold">{{ $errors->first() }}</p>
        </div>
        @endif

        {{-- ================= FORM RESET ================= --}}
        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
          @csrf

          <div class="space-y-1.5">
            <label class="text-sm font-bold text-gray-700">Alamat Email</label>
            <input
              type="email"
              name="email"
              required
              placeholder="nama@email.com"
              value="{{ old('email') }}"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-all text-sm">
          </div>
          
          <button
            type="submit"
            class="w-full py-3.5 mt-2 rounded-xl bg-green-700 text-white text-sm font-bold hover:bg-green-800 transition transform active:scale-95 shadow-lg shadow-green-100">
            Kirim Link Reset
          </button>
        </form>

        <div class="mt-8 text-center">
          <p class="text-sm text-gray-500">
            Ingat password Anda?
            <a href="{{ route('login') }}"
              class="text-green-700 font-bold hover:underline decoration-2 underline-offset-4">
              Kembali Login
            </a>
          </p>
        </div>
        
        <div class="mt-12 text-center border-t border-gray-100 pt-6">
            <p class="text-xs text-gray-400">© {{ date('Y') }} Deep Quran Academy.</p>
        </div>

      </div>
    </div>
  </div>

  {{-- MATIKAN KLIK KANAN & COPY UNTUK KEAMANAN --}}
  <script>
    document.addEventListener('contextmenu', function(e) { e.preventDefault(); });
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && (e.key === 'c' || e.key === 'x' || e.key === 'v' || e.key === 'C' || e.key === 'X' || e.key === 'V')) { e.preventDefault(); }
    });
    document.addEventListener('copy', function(e) { e.preventDefault(); });
  </script>
</body>

</html>