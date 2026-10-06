<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk & Daftar | AL UMMAH</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      overflow-x: hidden;
    }

    .form-container {
      transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .hidden-form {
      opacity: 0;
      pointer-events: none;
      transform: translateX(30px);
    }

    .active-form {
      opacity: 1;
      pointer-events: all;
      transform: translateX(0);
    }

    .loader {
      border: 2px solid #f3f3f3;
      border-top: 2px solid #ffffff;
      border-radius: 50%;
      width: 16px;
      height: 16px;
      animation: spin 1s linear infinite;
      display: inline-block;
      margin-right: 8px;
      vertical-align: middle;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }
  </style>
</head>

<body class="bg-green-50/50">
  <div class="min-h-screen flex items-center justify-center py-12 px-4 relative">
    <div class="absolute inset-0 opacity-5 bg-[url('https://www.transparenttextures.com/patterns/arabesque.png')] pointer-events-none"></div>

    <div class="max-w-md w-full relative z-10">
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-700 rounded-2xl shadow-xl border-2 border-white mb-4 transform -rotate-3 hover:rotate-0 transition-all duration-300">
          <span class="text-white text-4xl font-bold italic">TQ</span>
        </div>
        <div id="header-text">
          <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selamat Datang</h2>
          <p class="mt-2 text-sm text-gray-600">Silakan masuk ke akun Anda</p>
        </div>
      </div>

      <div class="relative min-h-[600px]">
        <div id="login-form" class="form-container active-form absolute inset-0 bg-white p-10 rounded-[2.5rem] shadow-2xl border border-white">
          <form class="space-y-6" action="{{ route('login.process') }}" method="POST">
            @csrf
            <h3 class="text-xl font-bold text-gray-800 mb-6">Masuk Santri</h3>
            <div class="space-y-4">
              <input name="email" type="email" required placeholder="Email" value="{{ old('email') }}" class="block w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:border-green-600 transition-all">
              <input name="password" type="password" required placeholder="Password" class="block w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:border-green-600 transition-all">
            </div>
            <button type="submit" class="w-full py-4 bg-green-700 text-white font-bold rounded-2xl shadow-xl hover:bg-green-800 transition-all transform active:scale-[0.98]">Masuk Sekarang</button>
          </form>
          <div class="mt-8 text-center text-sm text-gray-500">
            Belum punya akun? <button onclick="toggleForm('register')" class="text-green-700 font-bold hover:underline">Daftar di sini</button>
          </div>
        </div>

        <div id="register-form" class="form-container hidden-form absolute inset-0 bg-white p-10 rounded-[2.5rem] shadow-2xl border border-white">
          <form class="space-y-4" action="{{ route('register.process') }}" method="POST">
            @csrf
            <h3 class="text-xl font-bold text-gray-800 mb-6">Daftar Akun</h3>
            <input name="name" type="text" required placeholder="Nama Lengkap" value="{{ old('name') }}" class="block w-full px-5 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:border-green-600 transition-all">
            <input name="email" type="email" required placeholder="Email" value="{{ old('email') }}" class="block w-full px-5 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:border-green-600 transition-all">
            <input name="password" type="password" required placeholder="Password (Min 6 Karakter)" class="block w-full px-5 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:border-green-600 transition-all">
            <input name="password_confirmation" type="password" required placeholder="Ulangi Password" class="block w-full px-5 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:border-green-600 transition-all">

            <button type="submit" class="w-full py-4 bg-green-700 text-white font-bold rounded-2xl shadow-xl hover:bg-green-800 transition-all transform active:scale-[0.98] mt-2">Buat Akun Santri</button>
          </form>
          <div class="mt-8 text-center text-sm text-gray-500">
            Sudah punya akun? <button onclick="toggleForm('login')" class="text-green-700 font-bold hover:underline">Masuk di sini</button>
          </div>
        </div>
      </div>

      <div class="text-center mt-12">
        <a href="/" class="text-xs text-gray-400 hover:text-gray-600 flex items-center justify-center gap-2 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
          </svg>
          Kembali ke Beranda
        </a>
      </div>
    </div>
  </div>

  <script>
    const login = document.getElementById('login-form');
    const register = document.getElementById('register-form');
    const header = document.getElementById('header-text');

    function toggleForm(type) {
      if (type === 'register') {
        login.classList.add('hidden-form');
        login.classList.remove('active-form');
        register.classList.remove('hidden-form');
        register.classList.add('active-form');
        header.innerHTML = '<h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Daftar Baru</h2><p class="mt-2 text-sm text-gray-600">Gabung menjadi bagian dari santri kami</p>';
      } else {
        register.classList.add('hidden-form');
        register.classList.remove('active-form');
        login.classList.remove('hidden-form');
        login.classList.add('active-form');
        header.innerHTML = '<h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selamat Datang</h2><p class="mt-2 text-sm text-gray-600">Silakan masuk ke akun Anda</p>';
      }
    }

    // PERBAIKAN FATAL: Operator -> dirapatkan tanpa spasi
    @if($errors - > has('name') || $errors - > has('email') || $errors - > has('password_confirmation'))
    toggleForm('register');
    @endif

    document.querySelectorAll('form').forEach(form => {
      form.onsubmit = function() {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = `<span class="loader"></span> Memproses...`;
      };
    });
  </script>
</body>

</html>