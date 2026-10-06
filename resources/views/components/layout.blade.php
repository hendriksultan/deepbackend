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
  
  {{-- ========================================== --}}
  {{-- 1. PRIMARY META TAGS (SEO DASAR) --}}
  {{-- ========================================== --}}
  <title>Deep Quran Academy - Platform Belajar Tahsin & Tahfidz Al-Qur'an</title>
  <meta name="title" content="Deep Quran Academy - Platform Belajar Tahsin & Tahfidz Al-Qur'an">
  <meta name="description" content="Tingkatkan kualitas bacaan dan hafalan Al-Qur'an Anda bersama Deep Quran Academy. Platform belajar Tahsin, Tahfidz, dan ilmu tajwid yang terstruktur, interaktif, dan mudah diakses.">
  <meta name="keywords" content="tahsin, tahfidz, belajar alquran, ngaji online, kursus mengaji, tajwid, deep quran academy, lembaga quran, tahsin online">
  <meta name="author" content="Deep Quran Academy">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="{{ url()->current() }}">

  {{-- ========================================== --}}
  {{-- 2. OPEN GRAPH (UNTUK SHARE WHATSAPP, FB, IG) --}}
  {{-- ========================================== --}}
  @if(isset($meta))
      {{-- Jika halaman mengirimkan meta khusus (contoh: dari halaman Artikel), pakai ini: --}}
      {{ $meta }}
  @else
      {{-- Jika ini halaman biasa (Beranda, Kontak, dll), pakai meta default ini: --}}
      <meta property="og:type" content="website">
      <meta property="og:url" content="{{ url()->current() }}">
      <meta property="og:title" content="Deep Quran Academy - Platform Belajar Tahsin & Tahfidz Al-Qur'an">
      <meta property="og:description" content="Tingkatkan kualitas bacaan dan hafalan Al-Qur'an Anda bersama Deep Quran Academy. Platform belajar Tahsin, Tahfidz, dan ilmu tajwid yang terstruktur.">
      <meta property="og:image" content="{{ asset('images/pavicon.png') }}">
  @endif

  {{-- ========================================== --}}
  {{-- 3. TWITTER CARDS (UNTUK SHARE TWITTER/X) --}}
  {{-- ========================================== --}}
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="{{ url()->current() }}">
  <meta property="twitter:title" content="Deep Quran Academy - Platform Belajar Tahsin & Tahfidz Al-Qur'an">
  <meta property="twitter:description" content="Tingkatkan kualitas bacaan dan hafalan Al-Qur'an Anda bersama Deep Quran Academy. Platform belajar Tahsin, Tahfidz, dan ilmu tajwid yang terstruktur.">
  <meta property="twitter:image" content="{{ asset('images/pavicon.png') }}">

  {{-- ========================================== --}}
  {{-- 4. ICONS & ASSETS BAWAAN ANDA --}}
  {{-- ========================================== --}}
  <link rel="icon" href="{{ asset('images/pavicon.png') }}" type="image/x-icon">
  <link rel="icon" href="{{ asset('images/pavicon.png') }}" type="image/png">
  {{-- Tailwind CSS & Filament --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @filamentStyles

  {{-- Alpine Plugins (Collapse) --}}
  <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>

  {{-- Alpine.js (WAJIB) --}}
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  {{-- Fonts & AOS --}}
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  
  {{-- Swiper JS --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <style>
    body {
      font-family: "Inter", sans-serif;
      -webkit-user-select: none; /* Safari */
        -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* IE10+/Edge */
        user-select: none; /* Standard */
    }
    [x-cloak] {
      display: none !important;
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

<body class="bg-white text-gray-800 antialiased flex flex-col min-h-screen"
  x-data="{ 
          mobileMenuOpen: false, 
          isScrolled: false 
      }"
  @scroll.window="isScrolled = (window.pageYOffset > 10)"
  :class="mobileMenuOpen ? 'overflow-hidden' : ''">

 {{-- NAVBAR UTAMA --}}
  <nav class="fixed top-0 w-full z-40 transition-all duration-300 py-2 md:py-3"
    :class="isScrolled 
        ? 'bg-white/90 backdrop-blur-md shadow-md' 
        : 'bg-transparent'">

    <div class="container max-w-7xl mx-auto px-4 md:px-6">
      <div class="flex justify-between items-center h-10 md:h-12">

        {{-- LOGO --}}
        <a href="/" class="flex items-center z-50 relative shrink-0 group">
          <img src="{{ asset('images/d6.png') }}"
            alt="TahsinQur'an Logo"
            class="h-10 md:h-12 w-auto transition-all duration-300 transform 
              hover:scale-105 
              active:scale-95"
            :class="isScrolled ? 'brightness-100' : 'brightness-0 invert'">
        </a>

        {{-- DESKTOP MENU (Tengah) --}}
        <div class="hidden md:flex absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 gap-6 font-medium text-sm tracking-wide items-center">
          <a href="/#home" class="transition-colors" :class="isScrolled ? 'text-gray-600 hover:text-green-600' : 'text-white/90 hover:text-yellow-300'">Beranda</a>
          <a href="/#metode" class="transition-colors" :class="isScrolled ? 'text-gray-600 hover:text-green-600' : 'text-white/90 hover:text-yellow-300'">Metode</a>

          {{-- Dropdown Program --}}
          <div class="relative group py-4">
            <button class="flex items-center gap-1 transition-colors" :class="isScrolled ? 'text-gray-600 hover:text-green-600' : 'text-white/90 hover:text-yellow-300'">
              Program
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            
            {{-- [DIPERBARUI] mt-2 diubah menjadi mt-4 agar turun sedikit lagi --}}
            <div class="absolute top-full left-1/2 -translate-x-1/2 mt-3 w-48 bg-white/90 backdrop-blur-md rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 translate-y-2 border border-gray-100 overflow-hidden">
              <div class="relative z-10">
                <a href="{{ route('program.tahsin-dewasa') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 active:bg-green-50 active:text-green-700">Tahsin Dewasa</a>
                <a href="{{ route('program.tahfidz-dewasa') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 active:bg-green-50 active:text-green-700">Tahfidz Dewasa</a>
                <a href="{{ route('program.kelas-iqra') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 active:bg-green-50 active:text-green-700">Kelas Iqra</a>
                <a href="{{ route('program.tahfidz-anak') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 active:bg-green-50 active:text-green-700">Tahfidz Anak</a>
                <a href="{{ route('program.pra-sanad') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 active:bg-green-50 active:text-green-700">Pra Sanad</a>
                <a href="{{ route('program.bahasa-arab') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 active:bg-green-50 active:text-green-700">Bahasa Arab Pemula</a>
              </div>
            </div>
          </div>

          <a href="/#guru" class="transition-colors" :class="isScrolled ? 'text-gray-600 hover:text-green-600' : 'text-white/90 hover:text-yellow-300'">Cari Guru</a>

          {{-- Dropdown Info --}}
          <div class="relative group py-4">
            <button class="flex items-center gap-1 transition-colors" :class="isScrolled ? 'text-gray-600 hover:text-green-600' : 'text-white/90 hover:text-yellow-300'">
              Info Lainnya
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            
            {{-- [DIPERBARUI] mt-2 diubah menjadi mt-4 --}}
            <div class="absolute top-full left-1/2 -translate-x-1/2 mt-3 w-48 bg-white/90 backdrop-blur-md rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 translate-y-2 border border-gray-100 overflow-hidden">
              <div class="relative z-10">
                <a href="{{ route('blog.index') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 active:bg-green-50 active:text-green-700">Artikel</a>
                <a href="{{ route('about') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 active:bg-green-50 active:text-green-700">Tentang Kami</a>
                <a href="{{ route('donasi.index') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 active:bg-green-50 active:text-green-700">Donasi</a>
                
                {{-- TAMBAHAN MENU SEBARAN LOKASI --}}
                <a href="{{ route('sebaran-lokasi.index') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 active:bg-green-50 active:text-green-700">Sebaran Lokasi</a>
                
                <a href="{{ route('contact') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 active:bg-green-50 active:text-green-700">Kontak</a>
              </div>
            </div>
          </div>
        </div>

        {{-- BUTTON LOGIN DESKTOP --}}
        <div class="hidden md:flex items-center gap-4">
          <a href="/login"
            class="flex items-center gap-2 px-6 py-2.5 text-sm font-semibold rounded-full transition-all shadow-sm border"
            :class="isScrolled 
            ? 'text-green-700 border-green-200 bg-green-50 hover:bg-green-700 hover:text-white hover:border-transparent' 
            : 'text-white border-white bg-white/10 hover:bg-white hover:text-green-700'">
            <span>Login</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
          </a>
        </div>

        {{-- HAMBURGER BUTTON (Mobile) --}}
        <button @click="mobileMenuOpen = true"
          class="md:hidden p-2 -mr-2 rounded-full focus:outline-none transition-all duration-200 transform active:scale-90"
          :class="isScrolled 
        ? 'text-gray-600 hover:bg-gray-100 active:bg-gray-200' 
        : 'text-white hover:bg-white/10 active:bg-white/20'">

          <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
          </svg>
        </button>

      </div>
    </div>
  </nav>

  {{--
        MOBILE MENU (SLIDE DARI KIRI)
    --}}
  <div class="relative z-40 md:hidden"
    role="dialog" aria-modal="true"
    x-show="mobileMenuOpen"
    x-cloak>

    {{-- Backdrop Gelap --}}
    <div x-show="mobileMenuOpen"
      x-transition:enter="transition-opacity ease-linear duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition-opacity ease-linear duration-300"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"
      @click="mobileMenuOpen = false"></div>

    {{-- Drawer Container --}}
    <div class="fixed inset-0 flex z-40 pointer-events-none">

      {{-- DRAWER MENU (SLIDE DARI KIRI) --}}
      <div x-show="mobileMenuOpen"
        x-transition:enter="transition ease-in-out duration-300 transform"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="pointer-events-auto relative w-full max-w-xs bg-white shadow-2xl h-full flex flex-col">

        {{-- Header Menu --}}
        <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-gray-100">
          {{-- Logo Image --}}
          <img src="{{ asset('images/d6.png') }}"
            alt="Deep Quran Academy Logo"
            class="h-14 w-auto object-contain">

          {{-- Tombol Close --}}
          <button type="button"
            class="rounded-md p-2 text-gray-400 transition-all duration-200 focus:outline-none
       hover:text-red-500 hover:bg-gray-100 
       active:text-red-600 active:bg-gray-200 active:scale-95"
            @click=" mobileMenuOpen=false">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        {{-- Daftar Menu --}}
        <div class="flex-1 overflow-y-auto px-6 py-4 space-y-2">

          {{-- Menu: Beranda --}}
          <a href="/#home" @click="mobileMenuOpen = false" class="group flex items-center gap-x-3 py-3 px-3 text-base font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 
       active:bg-green-50 active:text-green-700 rounded-lg transition-colors">
            <svg class="h-6 w-6 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            Beranda
          </a>

          {{-- Menu: Metode Belajar --}}
          <a href="/#metode" @click="mobileMenuOpen = false" class="group flex items-center gap-x-3 py-3 px-3 text-base font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 
       active:bg-green-50 active:text-green-700 rounded-lg transition-colors">
            <svg class="h-6 w-6 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
            </svg>
            Metode Belajar
          </a>

          {{-- DROPDOWN MENU: Pilihan Program --}}
          <div x-data="{ open: false }">
            <button @click="open = !open" class="group flex w-full items-center justify-between rounded-lg py-3 px-3 text-base font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 
       active:bg-green-50 active:text-green-700 transition-colors">
              <div class="flex items-center gap-x-3">
                {{-- Icon Program --}}
                <svg class="h-6 w-6 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
                <span>Pilihan Program</span>
              </div>
              {{-- Chevron --}}
              <svg class="h-5 w-5 transform transition-transform duration-200"
                :class="open ? 'rotate-180 text-green-600' : 'text-gray-400'"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            {{-- Isi Dropdown --}}
            {{-- PERUBAHAN DISINI: ml-9 (geser garis ke kanan) dan pl-4 (kurangi padding dalam) --}}
            <div x-show="open"
              x-collapse
              class="space-y-1 pl-2 pt-1 pb-2 border-l-2 border-green-50 ml-6">

              {{-- Tahsin Dewasa --}}
              <a href="{{ route('program.tahsin-dewasa') }}" class="flex items-center gap-2 rounded-lg py-2 px-3 text-sm font-medium text-gray-500 hover:bg-green-50 hover:text-green-700 
       active:bg-green-50 active:text-green-700">
                <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <span>Tahsin Dewasa</span>
              </a>
              {{-- Tahfidz Dewasa --}}
              <a href="{{ route('program.tahfidz-dewasa') }}" class="flex items-center gap-2 rounded-lg py-2 px-3 text-sm font-medium text-gray-500 hover:bg-green-50 hover:text-green-700 
       active:bg-green-50 active:text-green-700">
                <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <span>Tahfidz Dewasa</span>
              </a>
              {{-- Kelas Iqra --}}
              <a href="{{ route('program.kelas-iqra') }}" class="flex items-center gap-2 rounded-lg py-2 px-3 text-sm font-medium text-gray-500 hover:bg-green-50 hover:text-green-700 
       active:bg-green-50 active:text-green-700">
                <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                </svg>
                <span>Kelas Iqra</span>
              </a>
              {{-- Tahfidz Anak --}}
              <a href="{{ route('program.tahfidz-anak') }}" class="flex items-center gap-2 rounded-lg py-2 px-3 text-sm font-medium text-gray-500 hover:bg-green-50 hover:text-green-700 
       active:bg-green-50 active:text-green-700">
                <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                </svg>
                <span>Tahfidz Anak</span>
              </a>
              {{-- Pra Sanad --}}
              <a href="{{ route('program.pra-sanad') }}" class="flex items-center gap-2 rounded-lg py-2 px-3 text-sm font-medium text-gray-500 hover:bg-green-50 hover:text-green-700 
       active:bg-green-50 active:text-green-700">
                <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                </svg>
                <span>Pra Sanad</span>
              </a>
              {{-- Bahasa Arab --}}
              <a href="{{ route('program.bahasa-arab') }}" class="flex items-center gap-2 rounded-lg py-2 px-3 text-sm font-medium text-gray-500 hover:bg-green-50 hover:text-green-700 
       active:bg-green-50 active:text-green-700">
                <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 01-3.827-5.802" />
                </svg>
                <span>Bahasa Arab Pemula</span>
              </a>
            </div>
          </div>

          {{-- Menu: Cari Guru Ngaji --}}
          <a href="/#guru" @click="mobileMenuOpen = false" class="group flex items-center gap-x-3 py-3 px-3 text-base font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 
       active:bg-green-50 active:text-green-700 rounded-lg transition-colors">
            <svg class="h-6 w-6 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
            Cari Guru Ngaji
          </a>
          {{-- Menu: Ruang Inspirasi (Artikel) --}}
          <a href="{{ route('blog.index') }}" @click="mobileMenuOpen = false"
            class="group flex items-center gap-x-3 py-3 px-3 text-base font-medium 
          {{ request()->routeIs('blog.*') ? 'bg-green-50 text-green-700' : 'text-gray-700' }} 
          hover:bg-green-50 hover:text-green-700 active:bg-green-50 active:text-green-700 
          rounded-lg transition-colors">

            {{-- Ikon: Newspaper / Document Text --}}
            <svg class="h-6 w-6 {{ request()->routeIs('blog.*') ? 'text-green-600' : 'text-gray-400' }} group-hover:text-green-600 transition-colors"
              fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
            </svg>

            Ruang Inspirasi
          </a>
          {{-- Menu: Tentang Kami --}}
          <a href="{{ route('about') }}" @click="mobileMenuOpen = false" class="group flex items-center gap-x-3 py-3 px-3 text-base font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 
       active:bg-green-50 active:text-green-700 rounded-lg transition-colors">
            <svg class="h-6 w-6 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
            </svg>
            Tentang Kami
          </a>

     {{-- Menu: Donasi --}}
          <a href="{{ route('donasi.index') }}" @click="mobileMenuOpen = false" class="group flex items-center gap-x-3 py-3 px-3 text-base font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 active:bg-green-50 active:text-green-700 rounded-lg transition-colors">
            
            {{-- Ikon Hati (Heart) untuk Donasi --}}
            <svg class="h-6 w-6 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
            </svg>
            
            Donasi
          </a>

          {{-- Menu: Sebaran Lokasi --}}
          <a href="{{ route('sebaran-lokasi.index') }}" @click="mobileMenuOpen = false" class="group flex items-center gap-x-3 py-3 px-3 text-base font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 active:bg-green-50 active:text-green-700 rounded-lg transition-colors">
            
            {{-- Ikon Titik Peta (Map Pin) --}}
            <svg class="h-6 w-6 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
            </svg>
            
            Sebaran Lokasi
          </a>

          {{-- Menu: Kontak --}}
          <a href="{{ route('contact') }}" @click="mobileMenuOpen = false" class="group flex items-center gap-x-3 py-3 px-3 text-base font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 
       active:bg-green-50 active:text-green-700 rounded-lg transition-colors">
            <svg class="h-6 w-6 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
            </svg>
            Kontak
          </a>
        </div>

        {{-- Footer Menu --}}
        <div class="border-t border-gray-100 p-6 bg-gray-50">
          <a href="/login"
            class="flex items-center justify-center w-full rounded-xl 
       bg-green-600 text-white font-bold text-sm px-4 py-3.5 
       shadow-lg transition-all duration-200
       hover:bg-green-700 hover:shadow-xl hover:-translate-y-0.5
       active:bg-green-800 active:shadow-none active:scale-95 active:translate-y-0">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            Login
          </a>
          <p class="mt-4 text-center text-xs text-gray-400">&copy; {{ date('Y') }} Deep Quran Academy.</p>
        </div>
      </div>

      {{-- Spacer Transparan (Sisi Kanan) --}}
      <div class="flex-1" @click="mobileMenuOpen = false"></div>
    </div>
  </div>

  {{-- KONTEN UTAMA --}}
  <main class="flex-grow w-full">
    {{ $slot }}
  </main>

  {{-- FOOTER --}}
  <footer class="bg-slate-800 text-gray-300 pt-16 md:pt-24 pb-10 mt-auto w-full relative z-10">
    <div class="container max-w-7xl mx-auto px-4 md:px-6">

      {{-- GRID: Ubah lg:grid-cols-4 menjadi lg:grid-cols-5 --}}
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 md:gap-12 mb-12 md:mb-16">

        {{-- KOLOM 1: BRAND (Tambahkan lg:col-span-2 agar lebih lebar) --}}
        <div class="lg:col-span-2">
          {{-- Ganti path 'images/d6.png' sesuai lokasi file gambar Anda --}}
          <div class="mb-4 md:mb-6">
    <img src="{{ asset('images/d6.png') }}"
      alt="Deepquran Academy Logo"
      class="h-20 md:h-20 lg:h-20 w-auto object-contain brightness-0 invert">
</div>
          {{-- Lebar paragraf dibatasi max-w-md agar tidak terlalu panjang ke kanan --}}
          <p class=" text-sm leading-relaxed mb-6 max-w-md">
            Platform penyedia guru ngaji profesional, amanah, dan bersanad untuk keluarga Indonesia. Belajar Al-Qur'an kini lebih mudah dan terpercaya.
          </p>

          {{-- Sosmed Icons --}}
            <div class="flex gap-4">
              {{-- Instagram --}}
              <a href="https://instagram.com/deepquranacademy.id" target="_blank" rel="noopener noreferrer" class="text-white hover:text-green-600 active:text-green-600 active:opacity-80 transition-colors duration-300">
                <span class="sr-only">Instagram</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468 3.2c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.821-.049.975-.045 1.504-.207 1.857-.344.467-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.049-3.821-.045-.975-.207-1.504-.344-1.857a4.988 4.988 0 00-.748-1.15 4.985 4.985 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                </svg>
              </a>
            
              {{-- Facebook --}}
              <a href="https://facebook.com/username" target="_blank" rel="noopener noreferrer" class="text-white hover:text-green-600 active:text-green-600 active:opacity-80 transition-colors duration-300">
                <span class="sr-only">Facebook</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                </svg>
              </a>
            
              {{-- YouTube --}}
              <a href="https://youtube.com/@channel" target="_blank" rel="noopener noreferrer" class="text-white hover:text-green-600 active:text-green-600 active:opacity-80 transition-colors duration-300">
                <span class="sr-only">YouTube</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 01-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 01-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 011.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418zM15.194 12 10 15V9l5.194 3z" clip-rule="evenodd" />
                </svg>
              </a>
            </div>
        </div>

        {{-- KOLOM 2: NAVIGASI UTAMA --}}
        <div>
          <h4 class="font-bold text-lg mb-4 md:mb-6 text-green-600">Navigasi</h4>
          <ul class="space-y-3 text-sm">
            <li><a href="/" class="inline-block transition-all duration-300 
       hover:text-green-600 hover:translate-x-1 
       active:text-green-600 active:translate-x-1 active:opacity-70">Beranda</a></li>
            <li><a href="/#metode" class="inline-block transition-all duration-300 
       hover:text-green-600 hover:translate-x-1 
       active:text-green-600 active:translate-x-1 active:opacity-70">Metode Belajar</a></li>
            <li><a href="/#program" class="inline-block transition-all duration-300 
       hover:text-green-600 hover:translate-x-1 
       active:text-green-600 active:translate-x-1 active:opacity-70">Pilihan Program</a></li>
            <li><a href="/#guru" class="inline-block transition-all duration-300 
       hover:text-green-600 hover:translate-x-1 
       active:text-green-600 active:translate-x-1 active:opacity-70">Cari Guru Ngaji</a></li>
          </ul>
        </div>

        {{-- KOLOM 3: INFORMASI --}}
        <div>
          <h4 class="font-bold text-lg mb-4 md:mb-6 text-green-600">Informasi</h4>
          <ul class="space-y-3 text-sm">
            <li><a href="{{ route('about') }}" class="inline-block transition-all duration-300 
       hover:text-green-600 hover:translate-x-1 
       active:text-green-600 active:translate-x-1 active:opacity-70">Tentang Kami</a></li>
            <li><a href="{{ route('faq') }}" class="inline-block transition-all duration-300 
       hover:text-green-600 hover:translate-x-1 
       active:text-green-600 active:translate-x-1 active:opacity-70">FAQ / Bantuan</a></li>
            <li><a href="{{ route('terms') }}" class="inline-block transition-all duration-300 
       hover:text-green-600 hover:translate-x-1 
       active:text-green-600 active:translate-x-1 active:opacity-70">Syarat & Ketentuan</a></li>
            <li><a href="{{ route('privacy') }}" class="inline-block transition-all duration-300 
       hover:text-green-600 hover:translate-x-1 
       active:text-green-600 active:translate-x-1 active:opacity-70">Kebijakan Privasi</a></li>
            <li><a href="{{ route('career') }}" class="inline-block transition-all duration-300 
       hover:text-green-600 hover:translate-x-1 
       active:text-green-600 active:translate-x-1 active:opacity-70">Karir Pengajar</a></li>
          </ul>
        </div>

        {{-- KOLOM 4: KONTAK --}}
        <div>
          <h4 class="font-bold text-lg mb-4 md:mb-6 text-green-600">Hubungi Kami</h4>
          <ul class="space-y-4 text-sm text-gray-300"> {{-- Tambahkan text-gray-300 agar teks tidak terlalu kontras/putih polos --}}

            {{-- 1. ALAMAT --}}
            <li class="flex items-start gap-3">
              {{-- Icon Location --}}
              <div class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
              </div>
              <span class="leading-relaxed">Jl. Gungjaya, Cisaat, Sukabumi, Indonesia</span>
            </li>

            {{-- 2. TELEPON --}}
            <li class="flex items-center gap-3">
              {{-- Icon Phone --}}
              <div class="w-5 h-5 text-green-600 flex-shrink-0">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
              </div>
              <span>+62 858-6091-3931</span>
            </li>

            {{-- 3. EMAIL --}}
            <li class="flex items-center gap-3">
              {{-- Icon Email --}}
              <div class="w-5 h-5 text-green-600 flex-shrink-0">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
              </div>
              <a href="mailto:admin@deepquranacademy.id" class="transition-all duration-300 
       hover:text-green-600 hover:translate-x-1 
       active:text-green-600 active:translate-x-1">
                admin@deepquranacademy.id
              </a>
            </li>

          </ul>
        </div>

      </div>

      {{-- COPYRIGHT --}}
      <div class="border-t border-gray-700 pt-8 text-gray-300 text-center text-xs md:text-sm">
        &copy; {{ date('Y') }} Deep Quran Academy. All rights reserved.
      </div>
    </div>
  </footer>
  {{-- ========================================================================= --}}
  {{-- ⭐ BACK TO TOP BUTTON ⭐ --}}
  {{-- ========================================================================= --}}
  <button
    x-data="{ showBackToTop: false }"
    @scroll.window="showBackToTop = (window.pageYOffset > 300)"
    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
    x-show="showBackToTop"
    x-cloak
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="opacity-0 translate-y-8"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200 transform"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-8"
    class="fixed bottom-24 right-4 md:bottom-[110px] md:right-9 z-40 flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-slate-800 text-white rounded-full shadow-lg hover:bg-green-600 hover:shadow-green-500/30 hover:-translate-y-1 transition-all duration-300 focus:outline-none"
    aria-label="Kembali ke atas">

    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 md:w-6 md:h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
    </svg>
  </button>
  {{-- ========================================================================= --}}
  {{-- ⭐ FLOATING WHATSAPP BUTTON (MULTI NOMOR + BALLOON TEXT) ⭐ --}}
  {{-- ========================================================================= --}}
  <div x-data="{ waOpen: false }" class="fixed bottom-6 right-4 md:bottom-8 md:right-8 z-50 flex flex-col items-end">

    {{-- POP-UP MENU (Pilihan Nomor) --}}
    <div x-show="waOpen"
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0 translate-y-4 scale-95"
      x-transition:enter-end="opacity-100 translate-y-0 scale-100"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-start="opacity-100 translate-y-0 scale-100"
      x-transition:leave-end="opacity-0 translate-y-4 scale-95"
      class="mb-3 bg-white rounded-2xl shadow-2xl border border-gray-100 p-2 w-64 overflow-hidden"
      @click.away="waOpen = false" x-cloak>

      <div class="bg-green-50 px-4 py-3 rounded-t-xl mb-2">
        <h4 class="text-sm font-bold text-green-800">Hubungi Kami</h4>
        <p class="text-[11px] text-green-600">Pilih layanan yang Anda butuhkan</p>
      </div>

      <div class="space-y-1">
          {{-- Pilihan 1: Admin Pendaftaran --}}
          <a href="https://wa.me/6289513195947?text=Assalamu%27alaikum%20Admin,%20saya%20ingin%20bertanya%20seputar%20pendaftaran."
            target="_blank"
            class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-xl transition-colors group">
            <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
              </svg>
            </div>
            <div>
              <p class="text-sm font-bold text-gray-800 group-hover:text-green-600">Admin Pendaftaran</p>
              <p class="text-[10px] text-gray-500">Tanya program & biaya</p>
            </div>
          </a>
        
          {{-- Pilihan 2: Pusat Informasi / CS --}}
          <a href="https://wa.me/6285860913931?text=Assalamu%27alaikum%20CS,%20saya%20butuh%20bantuan%20informasi%20umum."
            target="_blank"
            class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-xl transition-colors group">
            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
              </svg>
            </div>
            <div>
              <p class="text-sm font-bold text-gray-800 group-hover:text-blue-600">Pusat Informasi</p>
              <p class="text-[10px] text-gray-500">Bantuan & keluhan umum</p>
            </div>
          </a>
        </div>
    </div>

    {{-- WRAPPER BUTTON & BALLOON TEXT --}}
    <div class="flex items-center gap-3">

      {{-- BALLOON TEXT (Menghilang saat menu dibuka) --}}
      <div x-show="!waOpen"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="waOpen = true"
        class="relative cursor-pointer hidden md:flex items-center px-4 py-2.5 bg-white text-gray-700 text-xs font-bold rounded-2xl shadow-lg border border-gray-100 animate-bounce hover:bg-gray-50 transition-colors">
        Butuh Bantuan?
        {{-- Segitiga panah balon text --}}
        <div class="absolute -right-1.5 top-1/2 -translate-y-1/2 w-3 h-3 bg-white border-r border-t border-gray-100 transform rotate-45"></div>
      </div>

      {{-- TOMBOL UTAMA (Trigger) --}}
      {{-- Ukuran diperkecil ke w-12/h-12 (Mobile) dan w-14/h-14 (Desktop) --}}
      <button @click="waOpen = !waOpen"
        class="relative flex items-center justify-center w-12 h-12 md:w-14 md:h-14 bg-[#25D366] text-white rounded-full shadow-[0_4px_15px_rgba(37,211,102,0.3)] hover:scale-105 hover:shadow-[0_8px_25px_rgba(37,211,102,0.5)] transition-all duration-300 z-50">

        {{-- Efek Ping (Riak Air) --}}
        <span class="absolute inset-0 w-full h-full rounded-full bg-[#25D366] animate-ping opacity-30"></span>

        {{-- Icon WhatsApp / Close berputar secara dinamis --}}
        <div class="relative w-7 h-7 md:w-8 md:h-8 transform transition-transform duration-300" :class="waOpen ? 'rotate-180' : 'rotate-0'">

          {{-- Icon WA (Tampil saat menu tertutup) --}}
          <svg x-show="!waOpen" class="absolute inset-0 w-full h-full" fill="currentColor" viewBox="0 0 16 16">
            <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
          </svg>

          {{-- Icon Close (Tampil saat menu terbuka) --}}
          <svg x-show="waOpen" class="absolute inset-0 w-full h-full text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="display: none;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </div>
      </button>

    </div>
  </div>
  {{-- ========================================================================= --}}
  {{-- Script Animasi (AOS) --}}
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      AOS.init({
        once: false,
        mirror: false,
        duration: 1000,
        offset: 100,
        easing: 'ease-out-quart',
        anchorPlacement: 'top-bottom',
      });
    });

    document.addEventListener("DOMContentLoaded", () => {
      const counters = document.querySelectorAll(".counter");

      const observerOptions = {
        threshold: 0.5, // Animasi jalan saat 50% elemen masuk layar
        rootMargin: "0px"
      };

      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          const counter = entry.target;

          // Ambil setting dari atribut HTML
          const target = parseFloat(counter.getAttribute("data-target"));
          const duration = parseInt(counter.getAttribute("data-duration") || 2000);
          const decimals = parseInt(counter.getAttribute("data-decimals") || 0);

          if (entry.isIntersecting) {
            // === SAAT MASUK LAYAR: JALANKAN ANIMASI ===

            let startTimestamp = null;

            const step = (timestamp) => {
              if (!startTimestamp) startTimestamp = timestamp;
              const progress = Math.min((timestamp - startTimestamp) / duration, 1);

              // Hitung nilai saat ini
              const currentVal = progress * target;
              counter.innerText = currentVal.toFixed(decimals);

              if (progress < 1) {
                // Simpan ID animasi biar bisa di-cancel kalau user scroll cepat
                counter.animationId = window.requestAnimationFrame(step);
              } else {
                // Pastikan angka akhir pas
                counter.innerText = target.toFixed(decimals);
              }
            };

            // Mulai animasi
            counter.animationId = window.requestAnimationFrame(step);

          } else {
            // === SAAT KELUAR LAYAR: RESET KE 0 ===

            // Hentikan animasi jika masih berjalan (biar gak tabrakan)
            if (counter.animationId) {
              window.cancelAnimationFrame(counter.animationId);
            }

            // Kembalikan angka ke 0
            counter.innerText = (0).toFixed(decimals);
          }
        });
      }, observerOptions);

      counters.forEach((counter) => {
        observer.observe(counter);
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      var swiper = new Swiper(".partnerSwiper", {
        slidesPerView: 2, // Tampilkan 2 logo di Mobile
        spaceBetween: 30, // Jarak antar logo
        loop: true, // Infinite Loop (Muter terus)
        speed: 6000, // Kecepatan transisi (semakin besar semakin smooth jalannya)
        autoplay: {
          delay: 0, // 0 delay agar jalan terus seperti running text
          disableOnInteraction: false,
        },
        allowTouchMove: false, // Opsional: set true jika ingin bisa digeser jari
        breakpoints: {
          640: {
            slidesPerView: 3, // Tablet: 3 logo
            spaceBetween: 40,
          },
          768: {
            slidesPerView: 4, // Laptop Kecil: 4 logo
            spaceBetween: 50,
          },
          1024: {
            slidesPerView: 5, // Desktop: 5 logo
            spaceBetween: 60,
          },
        },
      });
    });
  </script>
  {{-- ========================================================================= --}}
  {{-- ⭐ SOCIAL PROOF POPUP (ANIMASI SMOOTH & PREMIUM) ⭐ --}}
  {{-- ========================================================================= --}}
  @php
  $recentStudents = \App\Models\User::where('role', 'student')
  ->where('is_verified', true)
  ->latest()
  ->take(5)
  ->get(['name', 'address', 'created_at']);
  @endphp

  @if($recentStudents->count() > 0)
  <div x-data="{
        students: {{ Js::from($recentStudents) }},
        currentIndex: 0,
        showPopup: false,
        
        init() {
            if(this.students.length === 0) return;
            setTimeout(() => {
                this.showPopup = true;
                this.hideAfterDelay();
            }, 2000); 
        },

        hideAfterDelay() {
            setTimeout(() => {
                this.showPopup = false;
                setTimeout(() => {
                    this.currentIndex = (this.currentIndex + 1) % this.students.length;
                    setTimeout(() => {
                        this.showPopup = true;
                        this.hideAfterDelay();
                    }, 10000); 
                }, 500); 
            }, 5000);
        },
        
        maskName(name) {
            let parts = name.split(' ');
            if (parts.length > 1) {
                let lastName = parts[parts.length - 1];
                parts[parts.length - 1] = lastName.charAt(0) + '***';
                return parts.join(' ');
            }
            return name.substring(0, 3) + '***';
        },
        
        timeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffInSeconds = Math.floor((now - date) / 1000);
            
            if (diffInSeconds < 3600) return 'Baru saja bergabung';
            if (diffInSeconds < 86400) return Math.floor(diffInSeconds / 3600) + ' jam yang lalu';
            return Math.floor(diffInSeconds / 86400) + ' hari yang lalu';
        }
    }"
    x-show="showPopup"

    {{-- PERUBAHAN ANIMASI ADA DI SINI --}}
    x-transition:enter="transition-all duration-700 transform ease-[cubic-bezier(0.34,1.56,0.64,1)]"
    x-transition:enter-start="opacity-0 translate-y-16 scale-90"
    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
    x-transition:leave="transition-all duration-400 transform ease-[cubic-bezier(0.4,0.0,0.2,1)]"
    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
    x-transition:leave-end="opacity-0 translate-y-12 scale-95"

    class="fixed bottom-6 left-4 md:bottom-8 md:left-8 z-[100] max-w-[280px] md:max-w-xs bg-white rounded-2xl shadow-[0_15px_40px_rgba(0,0,0,0.12)] border border-gray-100 p-3 md:p-4 flex items-start gap-3 cursor-pointer hover:bg-gray-50 transition-colors"
    @click="showPopup = false"
    style="display: none;">

    {{-- Ikon Ceklis (Hijau) --}}
    <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-full flex items-center justify-center shrink-0">
      <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </div>

    {{-- Teks Notifikasi --}}
    <div class="flex-1 min-w-0">
      <p class="text-[11px] md:text-xs text-gray-500 font-medium mb-0.5">Siswa baru mendaftar</p>
      <p class="text-sm font-bold text-gray-800 leading-snug line-clamp-2">
        <span x-text="maskName(students[currentIndex].name)"></span>
      </p>
      <div class="flex items-center justify-between gap-2 mt-1 text-[10px] md:text-xs">
        <span class="text-gray-500 truncate max-w-[120px]" x-text="'dari ' + (students[currentIndex].address || 'Indonesia')"></span>
        <span class="text-green-600 font-bold whitespace-nowrap" x-text="timeAgo(students[currentIndex].created_at)"></span>
      </div>
    </div>

    {{-- Tombol Close --}}
    <button @click.stop="showPopup = false" class="absolute top-2 right-2 p-1 text-gray-300 hover:text-gray-500 hover:bg-gray-100 rounded-full transition-colors">
      <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>
  @endif
  
 <script>
    // 1. Matikan Klik Kanan (Context Menu)
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    // 2. Matikan shortcut keyboard untuk Copy, Cut, dan Paste
    document.addEventListener('keydown', function(e) {
        // Matikan Ctrl+C (Copy), Ctrl+X (Cut), Ctrl+V (Paste)
        if (e.ctrlKey && (e.key === 'c' || e.key === 'x' || e.key === 'v' || e.key === 'C' || e.key === 'X' || e.key === 'V')) {
            e.preventDefault();
        }
    });

    // 3. Matikan event 'copy' bawaan browser
    document.addEventListener('copy', function(e) {
        e.preventDefault();
    });

    // 4. (Opsional) Matikan shortcut ke Developer Tools agar lebih sulit di-inspect
    document.onkeydown = function(e) {
        // Blok F12
        if (e.key === "F12") {
            return false;
        }
        // Blok Ctrl+Shift+I (Inspect)
        if (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i')) {
            return false;
        }
        // Blok Ctrl+Shift+C (Inspect Element)
        if (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c')) {
            return false;
        }
        // Blok Ctrl+U (View Source)
        if (e.ctrlKey && (e.key === 'U' || e.key === 'u')) {
            return false;
        }
    };
</script>
</body>

</html>