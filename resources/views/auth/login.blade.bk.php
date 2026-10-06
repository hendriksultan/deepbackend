<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk Akun Santri | AL UMMAH</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    @keyframes shake {

      0%,
      100% {
        transform: translateX(0);
      }

      25% {
        transform: translateX(-4px);
      }

      75% {
        transform: translateX(4px);
      }
    }

    .animate-shake {
      animation: shake 0.4s ease-in-out;
    }
  </style>
</head>

<body class="bg-green-50/50">
  <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5 bg-[url('https://www.transparenttextures.com/patterns/arabesque.png')] pointer-events-none"></div>

    <div class="max-w-md w-full space-y-8 relative z-10">
      <div class="text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-700 rounded-2xl shadow-xl shadow-green-200 mb-6 border-2 border-white transform -rotate-3 hover:rotate-0 transition-transform duration-300">
          <span class="text-white text-4xl font-bold italic">TQ</span>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
          Masuk Akun Santri
        </h2>
        <p class="mt-3 text-sm text-gray-600">
          "Tuntutlah ilmu dari buaian hingga liang lahat."
        </p>
        <div class="mt-4 flex items-center justify-center gap-2">
          <span class="h-px w-8 bg-gray-200"></span>
          <p class="text-[10px] font-bold text-green-700 uppercase tracking-[0.2em]">Al-Ummah Learning</p>
          <span class="h-px w-8 bg-gray-200"></span>
        </div>
      </div>

      <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl shadow-green-900/5 border border-white">
        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6 flex items-start gap-3 animate-shake">
          <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
          <p class="text-xs font-medium leading-tight">{{ $errors->first() }}</p>
        </div>
        @endif

        <form class="space-y-6" action="{{ route('login.process') }}" method="POST">
          @csrf
          <div class="space-y-5">
            <div>
              <label class="block text-[10px] font-bold text-gray-400 mb-2 ml-1 uppercase tracking-widest">Alamat Email</label>
              <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-300 group-focus-within:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                  </svg>
                </div>
                <input name="email" type="email" required placeholder="nama@email.com"
                  class="block w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-green-500/10 focus:border-green-600 transition-all sm:text-sm">
              </div>
            </div>

            <div>
              <label class="block text-[10px] font-bold text-gray-400 mb-2 ml-1 uppercase tracking-widest">Password</label>
              <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-300 group-focus-within:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                  </svg>
                </div>
                <input name="password" type="password" required placeholder="••••••••"
                  class="block w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-green-500/10 focus:border-green-600 transition-all sm:text-sm">
              </div>
            </div>
          </div>

          <div class="flex items-center justify-end">
            <a href="#" class="text-xs font-semibold text-green-700 hover:text-green-600 transition">Lupa Password?</a>
          </div>

          <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent text-sm font-bold rounded-2xl text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-200 transition-all duration-300 shadow-xl shadow-green-900/10">
            Masuk Ke Dashboard
          </button>
        </form>

        <div class="mt-10 text-center space-y-6">
          <p class="text-sm text-gray-500">
            Belum terdaftar?
            <a href="/register" class="font-bold text-green-700 hover:text-green-800 transition">Mulai Bergabung Sekarang</a>
          </p>
          <div class="pt-6 border-t border-gray-50">
            <a href="/" class="text-xs text-gray-400 hover:text-gray-600 transition inline-flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
              </svg>
              Kembali ke Beranda
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>