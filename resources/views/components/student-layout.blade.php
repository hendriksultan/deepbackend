<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-18177067963"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'AW-18177067963');
    </script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Santri - Tahsin Qur'an</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
  {{-- Atau jika menggunakan PNG --}}
  <link rel="icon" href="{{ asset('images/pavicon.png') }}" type="image/png">
  {{-- Google Font: Amiri (Untuk tulisan Arab) --}}
  <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">

  {{-- Tailwind CDN --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- Alpine.js --}}
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <!--<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">-->
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">


  <style>
    body {
      font-family: "Inter", sans-serif;
    }

    .hide-scrollbar::-webkit-scrollbar {
      display: none;
    }

    .hide-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    /* Memberikan jarak offset agar ayat tidak tertutup navbar saat auto-scroll */
    [id^="ayat-"] {
      scroll-margin-top: 100px;
    }

    .font-arab {
      font-family: 'Amiri', serif;
      line-height: 2.5;
    }

    [x-cloak] {
      display: none !important;
    }
  </style>
</head>

<body class="bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 transition-colors duration-300"
  x-data="{ 
        darkMode: localStorage.getItem('theme') === 'dark',
        toggleTheme() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    }"
  x-init="$watch('darkMode', val => val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')); if(darkMode) document.documentElement.classList.add('dark');">

  {{-- ========================================================= --}}
  {{-- 1. STICKY HEADER (TOP BAR) --}}
  {{-- ========================================================= --}}
  <header class="sticky top-0 z-50 h-16 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 transition-colors duration-300 shadow-sm border-b border-gray-100 dark:border-gray-800 transition-colors duration-300 shadow-[0_-8px_30px_rgba(0,0,0,0.04)]">

    <div class="max-w-7xl mx-auto px-4 h-full flex items-center justify-between">

      {{-- Brand / Logo --}}
      {{-- Logo Brand (Sekarang bisa diklik ke Home) --}}
      {{-- Brand / Logo --}}
      <a href="{{ route('student.dashboard') }}" class="flex items-center z-50 relative shrink-0">
        
        {{-- [BARU] CSS tambahan untuk memaksa logo putih di Dark Mode --}}
        <style>
          html.dark .logo-header {
            filter: brightness(0) invert(1) !important;
          }
        </style>

        <img src="{{ asset('images/d6.png') }}"
          alt="Deepquran Academy Logo"
          class="logo-header h-12 md:h-14 w-auto transition-all duration-300 transform hover:scale-105"
          :class="isScrolled ? 'brightness-100' : 'brightness-0 invert'">
      </a>


      {{-- Right Icons (Dark Mode, Notif, & Profile Dropdown) --}}
      <div class="flex items-center gap-2 relative">

        {{-- Dark Mode Toggle --}}
        <button @click="toggleTheme()" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 
       active:bg-gray-200 dark:active:bg-gray-700 transition">
          <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
          </svg>
          <svg x-show="darkMode" class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
          </svg>
        </button>

        {{-- Notification Icon (Dinamis dari Database & Popup Modal) --}}
        <div x-data="{ 
            openNotif: false,
            showModal: false,
            activeTitle: '',
            activeBody: '',
            activeTime: '',
            openMessage(title, body, time) {
                this.activeTitle = title;
                this.activeBody = body;
                this.activeTime = time;
                this.showModal = true;
                this.openNotif = false;
            }
        }">
          
          {{-- Tombol Lonceng --}}
          <button @click="openNotif = !openNotif" @click.outside="openNotif = false" 
            class="relative p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 active:bg-gray-200 dark:active:bg-gray-700 transition mr-1 focus:outline-none">
            
            @if(auth()->user()->unreadNotifications->count() > 0)
              <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white bg-red-500 rounded-full border-2 border-white dark:border-gray-900">
                {{ auth()->user()->unreadNotifications->count() }}
              </span>
            @endif

            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
          </button>

         {{-- Dropdown Isi Notifikasi --}}
          <div x-show="openNotif" x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute right-0 mt-4 w-80 max-w-[90vw] bg-white dark:bg-gray-800 rounded-[5px] shadow-xl border border-gray-100 dark:border-gray-700 z-40 origin-top-right overflow-hidden"
            style="display: none;">
            
            {{-- Header Dropdown --}}
            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
              <span class="font-bold text-sm text-gray-800 dark:text-gray-200">Notifikasi</span>
              
              @if(auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route('student.notifications.read') }}" method="POST">
                  @csrf
                  <button type="submit" class="text-[11px] font-bold text-green-600 hover:text-green-700 dark:text-green-400 transition">Tandai semua dibaca</button>
                </form>
              @endif
            </div>

            {{-- List Pesan --}}
            <div class="max-h-[300px] overflow-y-auto hide-scrollbar">
              @forelse(auth()->user()->unreadNotifications as $notification)
                {{-- [PERBAIKAN 1]: Menggunakan nl2br(e(...)) agar "Enter" diubah menjadi tag <br> secara aman --}}
                <div @click="openMessage({{ json_encode($notification->data['title'] ?? 'Pemberitahuan') }}, {{ json_encode(nl2br(e($notification->data['body'] ?? ''))) }}, '{{ $notification->created_at->diffForHumans() }}')"
                     class="px-4 py-3 border-b border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700 transition cursor-pointer group">
                  
                  <p class="text-sm font-bold text-gray-800 dark:text-gray-200 group-hover:text-green-600 dark:group-hover:text-green-400 transition">
                    {{ $notification->data['title'] ?? 'Pemberitahuan' }}
                  </p>
                  
                  <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">
                    {{ $notification->data['body'] ?? '' }}
                  </p>
                  
                  <span class="text-[10px] font-medium text-gray-400 mt-2 block">
                    {{ $notification->created_at->diffForHumans() }}
                  </span>
                </div>
              @empty
                <div class="px-4 py-8 text-center flex flex-col items-center justify-center">
                  <svg class="w-8 h-8 text-gray-300 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                  <p class="text-xs text-gray-500 dark:text-gray-400">Belum ada notifikasi baru</p>
                </div>
              @endforelse
            </div>
          </div>

          {{-- POPUP MODAL UNTUK BACA PESAN PENUH --}}
          <template x-teleport="body">
              <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900/50 backdrop-blur-sm"
                   x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                   x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                  <div class="relative w-full max-w-md p-4 mx-auto"
                       @click.outside="showModal = false"
                       x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                       x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                          
                          {{-- Header Modal --}}
                          <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-700/50">
                              <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                Pengumuman
                              </h3>
                              <button @click="showModal = false" class="text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-full p-1 transition focus:outline-none">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                              </button>
                          </div>
                          
                          {{-- Isi Modal (Pesan Utuh) --}}
                          <div class="px-6 py-5">
                              <h4 class="text-base font-bold text-gray-900 dark:text-white mb-1" x-text="activeTitle"></h4>
                              <p class="text-xs text-green-600 dark:text-green-400 font-semibold mb-4" x-text="activeTime"></p>
                              
                              {{-- [PERBAIKAN 2]: Menggunakan x-html agar tag <br> dirender dengan benar sebagai garis baru --}}
                              <div class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed" x-html="activeBody"></div>
                          </div>
                          
                          {{-- Footer Modal --}}
                          <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex justify-end">
                              <button @click="showModal = false" class="px-6 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm font-bold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition">Tutup Pesan</button>
                          </div>
                      </div>
                  </div>
              </div>
          </template>
        </div>

        {{-- PROFILE DROPDOWN (Alpine.js) --}}
        {{-- [PERBAIKAN]: Class 'relative' DIHAPUS dari sini --}}
        <div x-data="{ open: false }">
          {{-- Avatar Button --}}
          <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2 focus:outline-none">
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 text-white flex items-center justify-center text-sm font-bold shadow-md border-2 border-white dark:border-gray-800 overflow-hidden">

              @if(Auth::user()->profile_photo_path)
              <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Foto Profil" class="w-full h-full object-cover">
              @else
              {{ substr(Auth::user()->name, 0, 1) }}
              @endif

            </div>
          </button>

          {{-- Dropdown Menu --}}
          <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute right-0 mt-4 w-64 bg-white dark:bg-gray-800 rounded-[5px] shadow-xl border border-gray-100 dark:border-gray-700 py-2 z-50 origin-top-right"
            style="display: none;">

            {{-- User Info Section --}}
            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
              <p class="text-sm font-bold text-gray-800 dark:text-white truncate">{{ Auth::user()->name }}</p>
              <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
            </div>

            {{-- Menu Items --}}
            <div class="py-2">
              <a href="{{ route('student.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                My Profile
              </a>
              <a href="{{ route('student.security') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                Account Security
              </a>
              <a href="{{ route('student.settings') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Pengaturan
              </a>
            </div>

            {{-- Logout Button --}}
            <div class="px-2 pb-2 pt-1 border-t border-gray-100 dark:border-gray-700">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 text-sm font-medium text-red-600 rounded-xl transition-all duration-200
       hover:bg-red-50 dark:hover:bg-red-900/20
       active:bg-red-100 dark:active:bg-red-900/40 active:scale-[0.98]">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                  </svg>
                  Log Out
                </button>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </header>

  {{-- ========================================================= --}}
  {{-- 2. MAIN CONTENT --}}
  {{-- ========================================================= --}}

  <main class="pt-16 pb-20 md:pb-8 min-h-screen">
    {{ $slot }}
  </main>

  {{-- ========================================================= --}}
  {{-- 3. FOOTER & NAVIGATION (RESPONSIVE) --}}
  {{-- ========================================================= --}}

  <footer class="hidden md:block bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 mt-4 py-6 text-center transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-center">
      <p class="text-xs text-gray-500 dark:text-gray-400">
        &copy; {{ date('Y') }} <span class="font-bold text-green-600">Deep Quran Academy</span>. All rights reserved.
      </p>
    </div>
  </footer>


  {{-- B. MOBILE BOTTOM NAV (SERAGAM & FIXED) --}}
  <nav x-data="{ currentHash: window.location.hash }"
    @hashchange.window="currentHash = window.location.hash"
    class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md shadow-sm border-t border-gray-200 dark:border-gray-800 pb-safe transition-colors duration-300">

    <div class="max-w-md mx-auto px-6 h-16 flex justify-between items-center">

      {{-- 1. BERANDA --}}
      <a href="{{ route('student.dashboard') }}"
        @click="currentHash = ''"
        class="flex flex-col items-center gap-1 group w-16 focus:outline-none">

        {{-- Ikon --}}
        <div class="relative p-1.5 rounded-xl transition-colors duration-200"
          :class="(currentHash !== '#jadwal-saya' && '{{ request()->routeIs('student.dashboard') }}') 
                    ? 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400' 
                    : 'text-gray-400 group-hover:text-green-600 dark:group-hover:text-green-400 group-active:text-green-600 dark:group-active:text-green-400'">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
          </svg>
        </div>

        {{-- Teks --}}
        <span class="text-[10px] transition-all duration-200"
          :class="(currentHash !== '#jadwal-saya' && '{{ request()->routeIs('student.dashboard') }}') 
                    ? 'text-green-600 dark:text-green-400 font-bold' 
                    : 'text-gray-400 font-medium group-hover:text-green-600 dark:group-hover:text-green-400 group-active:text-green-600 dark:group-active:text-green-400'">
          Beranda
        </span>
      </a>

      {{-- 2. AL-QUR'AN --}}
      <a href="{{ route('quran.index') }}"
        class="flex flex-col items-center gap-1 group w-16 focus:outline-none">

        {{-- Perhatikan penambahan 'group-active:bg-green-50' di bawah --}}
        <div class="relative p-1.5 rounded-xl transition-colors duration-200 
   {{ request()->routeIs('quran.*') 
       ? 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400' 
       : 'text-gray-400 
          group-hover:text-green-600 dark:group-hover:text-green-400 
          group-active:text-green-600 dark:group-active:text-green-400 
          group-active:bg-green-50 dark:group-active:bg-green-900/20' }}">
          {{-- ^^^ Bagian ini yang sebelumnya kurang --}}

          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
            </path>
          </svg>
        </div>

        <span class="text-[10px] transition-all duration-200 
   {{ request()->routeIs('quran.*') 
       ? 'text-green-600 dark:text-green-400 font-bold' 
       : 'text-gray-400 font-medium group-hover:text-green-600 dark:group-hover:text-green-400 group-active:text-green-600 dark:group-active:text-green-400' }}">
          Al-Qur'an
        </span>
      </a>

      {{-- 3. JADWAL (Scroll) --}}
      <a href="{{ route('student.dashboard') }}#jadwal-saya"
        @click="currentHash = '#jadwal-saya'"
        class="flex flex-col items-center gap-1 group w-16 focus:outline-none">

        <div class="relative p-1.5 rounded-xl transition-colors duration-200"
          :class="currentHash === '#jadwal-saya' 
                    ? 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400' 
                    : 'text-gray-400 group-hover:text-green-600 dark:group-hover:text-green-400 group-active:text-green-600 dark:group-active:text-green-400'">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
        </div>

        <span class="text-[10px] transition-all duration-200"
          :class="currentHash === '#jadwal-saya' 
                    ? 'text-green-600 dark:text-green-400 font-bold' 
                    : 'text-gray-400 font-medium group-hover:text-green-600 dark:group-hover:text-green-400 group-active:text-green-600 dark:group-active:text-green-400'">
          Jadwal
        </span>
      </a>

      {{-- 4. KELUAR (Fixed: Menggunakan Button Submit) --}}
      <form method="POST" action="{{ route('logout') }}" class="w-16">
        @csrf
        <button type="submit" class="w-full flex flex-col items-center gap-1 group cursor-pointer focus:outline-none">
          <div class="relative p-1.5 rounded-xl transition-colors duration-200 text-gray-400 
                            group-hover:text-red-500 group-active:text-red-500 group-active:bg-red-50 dark:group-active:bg-red-900/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
          </div>
          <span class="text-[10px] font-medium text-gray-400 transition-all duration-200 
                             group-hover:text-red-500 group-active:text-red-500">
            Keluar
          </span>
        </button>
      </form>

    </div>
  </nav>
  {{-- Script SweetAlert2 (Wajib ada agar popup muncul) --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- [PERBAIKAN] Script Filter Pencarian yang Sangat Akurat --}}
  <script>
    document.getElementById('searchSurat').addEventListener('input', function() {
      let filter = this.value.toLowerCase().trim();
      let items = document.querySelectorAll('.surat-item');

      items.forEach(function(item) {
        // Ambil teks HANYA dari judul, nomor, dan arti (mengabaikan badge tempat/ayat)
        let judul = item.querySelector('.search-judul').textContent.toLowerCase();
        let arti = item.querySelector('.search-arti').textContent.toLowerCase();
        let nomor = item.querySelector('.search-nomor').textContent.toLowerCase().trim();

        // Cek apakah input (filter) cocok dengan salah satu dari ketiganya
        if (judul.includes(filter) || arti.includes(filter) || nomor === filter) {
          item.style.display = "";
        } else {
          item.style.display = "none";
        }
      });
    });

    //Script Ajax Bookmark (Tetap dipertahankan) 

    function toggleBookmark(surat, ayat, btn) {
      let icon = btn.querySelector('svg');
      fetch("{{ route('quran.bookmark') }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
          body: JSON.stringify({
            surat_nomor: surat,
            ayat_nomor: ayat
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'added') {
            icon.classList.remove('text-gray-400', 'hover:text-yellow-500');
            icon.classList.add('text-yellow-500', 'fill-current');
          } else {
            icon.classList.remove('text-yellow-500', 'fill-current');
            icon.classList.add('text-gray-400', 'hover:text-yellow-500');
          }
        })
        .catch(error => alert('Gagal menyimpan markah. Periksa koneksi internet.'));
    }
  </script>
</body>

</html>