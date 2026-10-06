<x-layout>
    {{-- ========================================================================= --}}
    {{-- ⭐ CENTER POP-UP PROMO (BERANDA SAJA) ⭐ --}}
    {{-- ========================================================================= --}}
   <!-- <div x-data="{
        showPromoModal: false,
        
        init() {
            // Cek apakah user sudah menutup promo di sesi ini
            if (!sessionStorage.getItem('promoClosed')) {
                // Beri jeda 1.5 detik setelah web terbuka baru pop-up muncul
                setTimeout(() => {
                    this.showPromoModal = true;
                }, 1500); 
            }
        },

        closeModal() {
            this.showPromoModal = false;
            // Simpan status bahwa user sudah menutup pop-up agar tidak muncul lagi saat refresh
            sessionStorage.setItem('promoClosed', 'true');
        }
     }"
        x-show="showPromoModal"
        x-cloak
        class="fixed inset-0 z-[120] flex items-center justify-center px-4 sm:px-0">

        {{-- 1. Backdrop Gelap (Klik di luar gambar untuk menutup) --}}
        <div x-show="showPromoModal"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0 bg-slate-900/50"
            @click="closeModal()">
        </div>

        {{-- 2. Kotak Modal Banner Utama --}}
        <div x-show="showPromoModal"
            x-transition:enter="transition ease-out duration-500 transform"
            x-transition:enter-start="opacity-0 scale-75 translate-y-8"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300 transform"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 translate-y-4"
            class="relative w-full max-w-md md:max-w-lg lg:max-w-xl bg-transparent shadow-2xl z-10 flex flex-col items-center justify-center">

            {{-- Tombol Close (X) Melayang di pojok kanan atas --}}
            <button @click="closeModal()"
                class="absolute -top-4 -right-4 md:-top-5 md:-right-5 w-8 h-8 md:w-10 md:h-10 bg-white text-gray-500 hover:text-red-500 hover:bg-gray-100 rounded-full shadow-lg flex items-center justify-center transition-all duration-200 z-20 focus:outline-none">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Konten Banner (Ganti href dan src gambarnya) --}}
            <a href="/login?mode=register" @click="closeModal()" class="block w-full overflow-hidden bg-white group">

                {{-- GANTI URL GAMBAR INI DENGAN POSTER/BANNER ANDA --}}
                {{-- Gunakan gambar rasio kotak (1:1) atau vertikal (4:5) agar menarik --}}
                <img src="/promo.png"
                    alt="Promo Spesial"
                    class="w-full h-auto object-cover transform group-hover:scale-105 transition-transform duration-500">

                {{-- (Opsional) Jika gambar kurang jelas, bisa tambah teks di bawahnya --}}
                {{--
            <div class="p-4 bg-white text-center">
                <h3 class="text-lg font-bold text-gray-800">Pendaftaran Gelombang 2 Dibuka!</h3>
                <p class="text-sm text-gray-500 mt-1">Klik di sini untuk mendaftar sekarang.</p>
            </div> 
            --}}
            </a>

        </div>
    </div>-->
    {{-- 1. HERO SECTION --}}
    <section id="home" class="relative bg-gradient-to-br from-green-900 via-green-800 to-green-600 pt-32 pb-32 md:pt-40 md:pb-56 overflow-hidden">
        {{-- Background Pattern & Blobs --}}
        <div class="absolute inset-0 opacity-20 mix-blend-overlay" style="background-image: url('{{ asset('arabesque.png') }}');"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-yellow-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-green-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>

        <div class="container max-w-7xl mx-auto px-4 md:px-6 relative z-10 flex flex-col-reverse md:flex-row items-center gap-10 md:gap-16">
            {{-- Text Content --}}
            <div class="w-full md:w-1/2 text-white text-center md:text-left" data-aos="fade-right">
                <div class="inline-flex items-center gap-2 px-3 py-1 mb-6 bg-white/10 rounded-full border border-white/20 backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                    <span class="text-[10px] md:text-xs font-semibold capitalize tracking-wider text-green-50">Lembaga Pendidikan Al-Qur'an Profesional</span>
                </div>

                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6 drop-shadow-sm">
                    Mulai Perjalanan <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-500">Hijrah Al-Qur'an</span> Anda
                </h1>

                <p class="text-base md:text-lg text-green-50/90 mb-8 leading-relaxed max-w-lg mx-auto md:mx-0 font-light">
                    Belajar Tahsin & Tahfidz secara privat bersama guru bersanad. Perbaiki bacaan, raih keberkahan, dan wujudkan generasi Qur'ani.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    {{-- TOMBOL 1: Cari Guru Ngaji --}}
                    <a href="#guru"
                        class="px-8 py-3.5 bg-yellow-400 text-green-900 font-bold rounded-full shadow-lg shadow-yellow-400/20 text-center flex items-center justify-center gap-2 transition-all duration-300
              hover:bg-yellow-300 hover:shadow-xl hover:-translate-y-1 
              active:bg-yellow-500 active:shadow-none active:translate-y-0 active:scale-95">
                        <span>Cari Guru Ngaji</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>

                    {{-- TOMBOL 2: Lihat Program --}}
                    <a href="#program"
                        class="px-8 py-3.5 bg-transparent border border-white/30 text-white font-semibold rounded-full text-center backdrop-blur-sm transition-all duration-300
              hover:bg-white/10 hover:border-white 
              active:bg-white/20 active:border-white active:scale-95">
                        Lihat Program
                    </a>
                </div>

                {{-- Mini Trust Proof --}}
                <div class="mt-8 flex items-center justify-center md:justify-start gap-4 opacity-80">
                    <div class="flex -space-x-2">
                        <img class="w-8 h-8 rounded-full border-2 border-green-700" src="https://ui-avatars.com/api/?name=A&background=random" alt="User">
                        <img class="w-8 h-8 rounded-full border-2 border-green-700" src="https://ui-avatars.com/api/?name=B&background=random" alt="User">
                        <img class="w-8 h-8 rounded-full border-2 border-green-700" src="https://ui-avatars.com/api/?name=C&background=random" alt="User">
                        <div class="w-8 h-8 rounded-full border-2 border-green-700 bg-gray-800 text-white text-xs flex items-center justify-center font-bold">+100</div>
                    </div>
                    <div class="text-xs text-green-100">
                        <span class="font-bold text-yellow-400">100+</span> Santri Bergabung
                    </div>
                </div>
            </div>
{{-- Image Content --}}
            <div class="w-full lg:w-3/5 flex justify-center lg:justify-end relative mx-auto" data-aos="fade-left" data-aos-delay="200">
                
                {{-- Container Wrapper: Disamakan ukurannya menggunakan max-w-md dan aspect-square --}}
                <div class="relative w-full max-w-md aspect-square perspective-1000">

                    {{-- Decorative Elements --}}
                    <div class="absolute -top-6 -right-6 md:-top-12 md:-right-12 w-16 h-16 md:w-28 md:h-28 bg-yellow-400 rounded-full opacity-20 blur-xl md:blur-2xl animate-pulse"></div>
                    <div class="absolute -bottom-4 -left-4 md:-bottom-8 md:-left-8 w-20 h-20 md:w-32 md:h-32 bg-green-400 rounded-full opacity-20 blur-xl md:blur-2xl animate-pulse delay-700"></div>

                    {{-- Main Image Card: Menggunakan p-2, w-full, h-full, dan rounded-[2rem] --}}
                    <div class="relative w-full h-full bg-gree p-2 rounded-[2rem] shadow-2xl transform transition-all duration-500 ease-out border border-white/20 backdrop-blur-sm">
                        
                        {{-- Menggunakan h-full agar memenuhi aspect-square --}}
                        <img src="/hero.webp" alt="Belajar Al-Quran" class="rounded-[1.8rem] w-full h-full object-cover shadow-inner">

                        {{-- Floating Badge --}}
                        <div class="absolute -bottom-6 -right-6 bg-white p-4 rounded-xl shadow-xl flex items-center gap-4 animate-bounce-slow border border-gray-50 max-w-xs">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium leading-none mb-1">Metode</p>
                                <p class="font-bold text-gray-800 text-sm leading-tight">Terbukti Efektif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. STATS BANNER (Responsive Border Fix) --}}
    <section class="relative z-20 py-10 bg-gradient-to-b from-green-900 via-green-900 to-green-950 border-y border-green-800/50 shadow-[inset_0_0_30px_rgba(0,0,0,0.3)] overflow-hidden">

        <div class="container max-w-6xl mx-auto px-4 relative">
            {{--
           LOGIKA GRID & BORDER:
           - Mobile (grid-cols-2): Item 1 & 2 punya border bawah. Item 1 & 3 punya border kanan.
           - Desktop (grid-cols-4): Semua border bawah hilang. Item 1, 2, 3 punya border kanan.
        --}}
            <div class="grid grid-cols-2 md:grid-cols-4 text-center">

                {{-- ITEM 1: Guru --}}
                {{-- Mobile: Ada Kanan & Bawah | Desktop: Hanya Kanan, Bawah Hilang --}}
                <div class="p-6 relative group border-r border-b md:border-b-0 border-green-800/50" data-aos="fade-up" data-aos-delay="0">
                    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-green-800 opacity-20 pointer-events-none transition-transform duration-700 group-hover:scale-110">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-3xl md:text-4xl font-extrabold text-yellow-400 flex justify-center items-baseline gap-1">
                            <span class="counter" data-target="50" data-speed="2000">0</span>
                            <span class="text-2xl text-yellow-500/80">+</span>
                        </p>
                        <p class="text-sm text-green-100 font-medium uppercase tracking-wider mt-2">Guru Bersanad</p>
                    </div>
                </div>

                {{-- ITEM 2: Santri --}}
                {{-- Mobile: Hanya Bawah (Kanan tdk ada krn di pinggir) | Desktop: Ada Kanan, Bawah Hilang --}}
                <div class="p-6 relative group border-b md:border-b-0 md:border-r border-green-800/50" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-green-800 opacity-20 pointer-events-none transition-transform duration-700 group-hover:scale-110">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-3xl md:text-4xl font-extrabold text-yellow-400 flex justify-center items-baseline gap-1">
                            <span class="counter" data-target="1.2" data-speed="2000" data-decimals="1">0</span>
                            <span class="text-2xl text-yellow-500/80 lowercase">k</span>
                        </p>
                        <p class="text-sm text-green-100 font-medium uppercase tracking-wider mt-2">Santri Aktif</p>
                    </div>
                </div>

                {{-- ITEM 3: Rating --}}
                {{-- Mobile: Ada Kanan (Bawah tdk ada krn baris terakhir) | Desktop: Ada Kanan --}}
                <div class="p-6 relative group border-r border-green-800/50" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-green-800 opacity-20 pointer-events-none transition-transform duration-700 group-hover:scale-110">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-3xl md:text-4xl font-extrabold text-yellow-400 flex justify-center items-baseline gap-1">
                            <span class="counter" data-target="4.9" data-speed="2000" data-decimals="1">0</span>
                            <svg class="w-6 h-6 text-yellow-500/80 self-center" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </p>
                        <p class="text-sm text-green-100 font-medium uppercase tracking-wider mt-2">Rating Puas</p>
                    </div>
                </div>

                {{-- ITEM 4: Support --}}
                {{-- Mobile: Tidak ada border | Desktop: Tidak ada border --}}
                <div class="p-6 relative group" data-aos="fade-up" data-aos-delay="300">
                    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-green-800 opacity-20 pointer-events-none transition-transform duration-700 group-hover:scale-110">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-7 12h-2v-2h2v2zm0-4h-2V6h2v4z" />
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-3xl md:text-4xl font-extrabold text-yellow-400 flex justify-center items-baseline gap-1">
                            <span class="counter" data-target="24" data-speed="2000">0</span>
                            <span class="text-xl text-green-400/70 mx-0.5">/</span>
                            <span class="text-2xl text-yellow-500/80">7</span>
                        </p>
                        <p class="text-sm text-green-100 font-medium uppercase tracking-wider mt-2">Support Admin</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- 3. FEATURES SECTION (Cards) --}}
    <section class="py-16 md:py-20 bg-gray-50">
        <div class="container max-w-7xl mx-auto px-4 md:px-6">
            <div class="text-center mb-12 md:mb-16">
                <span class="text-green-600 font-bold text-xs md:text-sm uppercase tracking-wider px-3 py-1 bg-green-50 rounded-full inline-block mb-4">Kenapa Memilih Kami?</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Keunggulan Lembaga Kami</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Feature 1 --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-300 group" data-aos="fade-up" data-aos-delay="0">
                    <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 mb-6 group-hover:bg-green-600 group-hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-3">Metode Terstruktur</h3>
                    <p class="text-gray-500 text-sm md:text-base leading-relaxed">Kurikulum disusun sistematis dari level pemula (Iqra) hingga mahir (Tajwid & Tahfidz), memudahkan proses belajar.</p>
                </div>
                {{-- Feature 2 --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-300 group relative overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-yellow-100 rounded-bl-full -mr-10 -mt-10 opacity-50 group-hover:scale-150 transition duration-500"></div>
                    <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center text-yellow-600 mb-6 group-hover:bg-yellow-500 group-hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-3">Guru Bersertifikat</h3>
                    <p class="text-gray-500 text-sm md:text-base leading-relaxed">Seluruh pengajar telah lulus seleksi ketat dan memiliki sanad keilmuan yang bersambung hingga Rasulullah SAW.</p>
                </div>
                {{-- Feature 3 --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-300 group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-3">Waktu Fleksibel</h3>
                    <p class="text-gray-500 text-sm md:text-base leading-relaxed">Bebas tentukan jadwal belajar. Tersedia opsi kelas Online (Zoom/GMeet) atau Offline (Home Visit) sesuai kenyamanan.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. METODE SECTION --}}
    <section id="metode" class="py-16 md:py-24 bg-white scroll-mt-20 relative overflow-hidden">
        {{-- Background Pattern (Optional - agar senada) --}}
        <div class="absolute top-0 left-0 w-full h-full opacity-[0.03] pointer-events-none">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="1" class="text-gray-900"></path>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)"></rect>
            </svg>
        </div>

        <div class="container max-w-7xl mx-auto px-4 md:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">

                {{-- LEFT SIDE: VIDEO --}}
                <div class="w-full lg:w-1/2 relative group" data-aos="zoom-in">
                    {{-- Glow Effect --}}
                    <div class="absolute -inset-4 bg-gradient-to-tr from-green-200 to-blue-200 rounded-[2.5rem] opacity-40 blur-2xl group-hover:opacity-60 transition duration-500"></div>

                    {{-- Video Container --}}
                    <!--<div class="relative rounded-[2rem] overflow-hidden shadow-2xl border border-gray-100 bg-white">
                        <iframe
                            class="w-full aspect-video"
                            src="https://www.youtube.com/embed/dQw4w9WgXcQ?controls=1&rel=0"
                            frameborder="0"
                            allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>-->
                    <div class="relative rounded-[2rem] overflow-hidden shadow-2xl border border-gray-100 bg-white group">

                        {{-- Tag Video HTML5 --}}
                        <video
                            class="w-full aspect-video object-cover"
                            autoplay
                            muted
                            loop
                            playsinline
                            controls
                            poster="{{ asset('images/video-thumbnail.jpg') }}"
                            preload="auto">

                            {{-- Ganti lokasi file --}}
                            <source src="{{ asset('videos/video.mp4') }}" type="video/mp4">

                            Browser Anda tidak mendukung tag video.
                        </video>

                    </div>
                </div>

                {{-- RIGHT SIDE: CONTENT --}}
                <div class="w-full lg:w-1/2" data-aos="fade-left">
                    {{-- Badge --}}
                    <span class="text-green-600 font-bold text-xs md:text-sm uppercase tracking-wider px-4 py-1.5 bg-green-100/50 rounded-full inline-block mb-6">
                        Fleksibilitas Belajar
                    </span>

                    {{-- Heading (Disamakan dengan section Program: text-3xl md:text-5xl font-extrabold) --}}
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6 leading-tight tracking-tight">
                        Metode Hybrid: <span class="text-blue-600">Online</span> & <span class="text-green-600">Offline</span>
                    </h2>

                    {{-- Description (Disamakan dengan section Program: text-lg md:text-xl) --}}
                    <p class="text-gray-600 mb-10 leading-relaxed text-base md:text-lg">
                        Kami memahami kesibukan Anda. Pilih metode belajar tatap muka di markaz atau daring interaktif tanpa mengurangi kualitas bimbingan.
                    </p>

                    <div class="space-y-6">
                        {{-- POIN 1: OFFLINE (Style Card disamakan: rounded-3xl) --}}
                        <div class="flex items-start gap-6 p-6 rounded-3xl bg-green-50/50 hover:bg-green-100/50 transition duration-300 border border-green-100/50 hover:border-green-200 group">
                            <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0 shadow-sm group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                                {{-- Icon: User Group --}}
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-xl text-gray-900 mb-2">Offline (Tatap Muka)</h4>
                                <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                                    Belajar langsung di markaz dengan suasana halaqah yang kondusif. Guru mengoreksi bacaan secara detail (Talaqqi) face-to-face.
                                </p>
                            </div>
                        </div>

                        {{-- POIN 2: ONLINE (Style Card disamakan: rounded-3xl) --}}
                        <div class="flex items-start gap-6 p-6 rounded-3xl bg-blue-50/50 hover:bg-blue-100/50 transition duration-300 border border-blue-100/50 hover:border-blue-200 group">
                            <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                {{-- Icon: Video Camera --}}
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-xl text-gray-900 mb-2">Online (Virtual)</h4>
                                <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                                    Belajar dari mana saja melalui video conference (Zoom/GMeet). Tetap interaktif dengan kualitas audio-visual yang mendukung.
                                </p>
                            </div>
                        </div>
                        {{-- POIN 3: HOME VISIT (PURPLE) --}}
                        <div class="flex items-start gap-6 p-6 rounded-3xl bg-purple-50/50 hover:bg-purple-100/50 transition duration-300 border border-purple-100/50 hover:border-purple-200 group">
                            <div class="w-14 h-14 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600 flex-shrink-0 shadow-sm group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                                {{-- Icon: Home / House --}}
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-xl text-gray-900 mb-2">Home Visit (Privat)</h4>
                                <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                                    Layanan privat eksklusif. Guru hadir langsung ke rumah Anda untuk bimbingan yang lebih fokus, nyaman, dan hemat waktu.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- PROGRAM SECTION --}}
    <section id="program" class="py-16 md:py-24 bg-gray-50 scroll-mt-20">
        <div class="container max-w-7xl mx-auto px-4 md:px-6 text-center">
            {{-- Badge --}}
            <span class="text-green-600 font-bold text-xs md:text-sm uppercase tracking-wider px-3 py-1 bg-green-50 rounded-full inline-block mb-4" data-aos="fade-down">
                Program Kami
            </span>

            {{-- Heading --}}
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight" data-aos="fade-down">
                Pilihan Program Unggulan
            </h2>

            {{-- Subheading --}}
            <p class="text-gray-600 mb-12 max-w-2xl mx-auto text-base md:text-lg" data-aos="fade-up">
                Kurikulum terstruktur yang dirancang untuk berbagai usia dan kebutuhan belajar Al-Qur'an Anda.
            </p>

            {{-- Grid Container (3 Kolom di Desktop) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">

                {{-- 1. KELAS IQRA (TEAL) --}}
                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-300 group cursor-pointer flex flex-col items-center text-center md:items-start md:text-left h-full" data-aos="fade-up" data-aos-delay="0">
                    <div class="w-14 h-14 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-teal-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                        {{-- Icon: Book Open --}}
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-2 group-hover:text-teal-600 transition">Kelas Iqra</h3>
                    <p class="text-sm md:text-base text-gray-500 leading-relaxed">
                        Mulai dari nol. Belajar pengenalan huruf hijaiyah hingga lancar membaca sambung dengan metode Iqra yang teruji.
                    </p>
                </div>

                {{-- 2. TAHSIN DEWASA (GREEN) --}}
                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-300 group cursor-pointer flex flex-col items-center text-center md:items-start md:text-left h-full" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                        {{-- Icon: Microphone/Speaking --}}
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-2 group-hover:text-green-600 transition">Tahsin Dewasa</h3>
                    <p class="text-sm md:text-base text-gray-500 leading-relaxed">
                        Perbaiki kualitas bacaan Anda. Fokus pada makhrajul huruf, tajwid, dan kelancaran membaca agar sesuai kaidah.
                    </p>
                </div>

                {{-- 3. TAHFIDZ DEWASA (ORANGE) --}}
                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-300 group cursor-pointer flex flex-col items-center text-center md:items-start md:text-left h-full" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                        {{-- Icon: Bookmark/Memory --}}
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-2 group-hover:text-orange-600 transition">Tahfidz Dewasa</h3>
                    <p class="text-sm md:text-base text-gray-500 leading-relaxed">
                        Menghafal Al-Qur'an dengan fleksibel. Metode setoran dan murajaah yang disesuaikan dengan kesibukan Anda.
                    </p>
                </div>

                {{-- 4. TAHFIDZ ANAK (YELLOW) --}}
                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-300 group cursor-pointer flex flex-col items-center text-center md:items-start md:text-left h-full" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-yellow-500 group-hover:text-white transition-colors duration-300 shadow-sm">
                        {{-- Icon: Happy Face --}}
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-2 group-hover:text-yellow-600 transition">Tahfidz Anak</h3>
                    <p class="text-sm md:text-base text-gray-500 leading-relaxed">
                        Tanamkan cinta Al-Qur'an sejak dini. Pendekatan yang ceria, interaktif, dan tanpa paksaan untuk si kecil.
                    </p>
                </div>

                {{-- 5. PROGRAM SANAD (BLUE) --}}
                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-300 group cursor-pointer flex flex-col items-center text-center md:items-start md:text-left h-full" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                        {{-- Icon: Badge Check/Certificate --}}
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-2 group-hover:text-blue-600 transition">Program Sanad</h3>
                    <p class="text-sm md:text-base text-gray-500 leading-relaxed">
                        Khusus peserta Mutqin (mahir). Pengambilan sanad bacaan bersambung hingga Rasulullah SAW (Jazariyah/Tuhfatul Athfal).
                    </p>
                </div>

                {{-- 6. BAHASA ARAB (PURPLE) --}}
                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-300 group cursor-pointer flex flex-col items-center text-center md:items-start md:text-left h-full" data-aos="fade-up" data-aos-delay="500">
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                        {{-- Icon: Globe/Language --}}
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-2 group-hover:text-purple-600 transition">Bahasa Arab</h3>
                    <p class="text-sm md:text-base text-gray-500 leading-relaxed">
                        Pahami makna Al-Qur'an lebih dalam. Belajar tata bahasa Arab dasar (Nahwu & Shorof) dengan metode praktis.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- GALLERY SECTION (NEW) --}}
    <section id="galeri" class="py-16 md:py-24 bg-white scroll-mt-20">
        <div class="container max-w-7xl mx-auto px-4 md:px-6">
            <div class="text-center mb-10 md:mb-16" data-aos="fade-down">
                <span class="text-green-600 font-bold text-xs md:text-sm uppercase tracking-wider px-3 py-1 bg-green-50 rounded-full inline-block mb-4">Dokumentasi</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Keseruan Belajar Mengajar</h2>
            </div>

            {{-- Bento Grid Layout --}}
            {{-- Rahasianya: Menggunakan h-auto di mobile dan h-[600px] di desktop --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 h-auto md:h-[600px]">

                {{-- Foto 1 (Utama) - Mobile: Full Width, Desktop: Kotak Besar Kiri --}}
                <div class="col-span-2 row-span-1 md:row-span-2 relative group overflow-hidden rounded-2xl cursor-pointer shadow-sm" data-aos="fade-right">
                    <img src="{{ asset('images/core.png') }}"
                        alt="Suasana Belajar"
                        class="w-full h-64 md:h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent flex items-end p-5">
                        <span class="text-white font-bold text-lg">Halqoh Ikhwan</span>
                    </div>
                </div>

                {{-- Foto 2 (Kecil Kiri) --}}
                <div class="col-span-1 row-span-1 relative group overflow-hidden rounded-2xl cursor-pointer shadow-sm" data-aos="fade-down" data-aos-delay="100">
                    <img src="{{ asset('images/c.webp') }}"
                        alt="Anak Mengaji"
                        class="w-full h-40 md:h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center p-2 text-center">
                        <span class="text-white font-bold text-[10px] md:text-sm bg-green-600/90 px-3 py-1 rounded-full">Kelas Online Akhwat</span>
                    </div>
                </div>

                {{-- Foto 3 (Kecil Kanan) --}}
                <div class="col-span-1 row-span-1 relative group overflow-hidden rounded-2xl cursor-pointer shadow-sm" data-aos="fade-down" data-aos-delay="200">
                    <img src="{{ asset('images/b.webp') }}"
                        alt="Guru Mengajar"
                        class="w-full h-40 md:h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center p-2 text-center">
                        <span class="text-white font-bold text-[10px] md:text-sm bg-green-600/90 px-3 py-1 rounded-full">Kelas Online Ikhwan</span>
                    </div>
                </div>

                {{-- Foto 4 (Lebar Bawah) --}}
                <div class="col-span-2 row-span-1 relative group overflow-hidden rounded-2xl cursor-pointer shadow-sm" data-aos="fade-up" data-aos-delay="300">
                    <img src="{{ asset('images/a.webp') }}"
                        alt="Kegiatan Bersama"
                        class="w-full h-48 md:h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent flex items-end p-5">
                        <span class="text-white font-bold text-sm md:text-base">Halqoh Akhwat</span>
                    </div>
                </div>

            </div>

            {{-- Tombol Lihat Lainnya --}}
            <div class="text-center mt-10">
                <a href="{{ route('galeri.index') }}" class="inline-flex items-center text-green-600 font-semibold hover:text-green-800 transition group">
                    Lihat Galeri Selengkapnya
                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- GOOGLE REVIEWS SLIDER SECTION --}}
    <section class="py-16 md:py-24 bg-white border-t border-gray-100"
        x-data="{ 
        showModal: false,
        slider: null,
        autoplay: null,
        
        init() {
            this.slider = document.getElementById('reviewSlider');
            this.startAutoplay();
        },
        startAutoplay() {
            // Hentikan interval lama jika ada
            if (this.autoplay) clearInterval(this.autoplay);
            
            this.autoplay = setInterval(() => {
                // Cek jika sudah mentok kanan (dengan toleransi 10px)
                if (this.slider.scrollLeft + this.slider.clientWidth >= this.slider.scrollWidth - 10) {
                    // Kembali ke awal
                    this.slider.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    // Scroll ke kanan (320px adalah estimasi lebar card + gap)
                    this.slider.scrollBy({ left: 320, behavior: 'smooth' });
                }
            }, 3000); // Ganti 3000 dengan kecepatan (ms) yang diinginkan
        },
        stopAutoplay() {
            clearInterval(this.autoplay);
        }
    }"
        x-init="init()">

        <div class="container max-w-7xl mx-auto px-4 md:px-6">

            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row items-center md:items-end justify-between mb-8 md:mb-12 gap-6" data-aos="fade-down">
                {{-- Bagian Kiri (Teks & Rating) --}}
                <div class="w-full md:w-auto text-center md:text-left">
                    {{-- Logo Google --}}
                    <div class="flex items-center justify-center md:justify-start gap-2 mb-2">
                        <img src="{{ asset('Google_2015_logo.svg') }}" alt="Google Logo" class="h-6 md:h-8">
                        <span class="text-gray-400 font-light text-xl">Reviews</span>
                    </div>

                    {{-- Judul --}}
                    <h2 class="text-3xl font-bold text-gray-800">Apa Kata Santri Kami?</h2>

                    @php
                    $avgRating = $reviews->avg('rating') ?? 0;
                    $countRating = $reviews->count();
                    @endphp

                    {{-- Rating Stars --}}
                    <div class="flex items-center justify-center md:justify-start gap-2 mt-2">
                        <span class="text-lg font-bold text-gray-800">{{ number_format($avgRating, 1) }}</span>
                        <div class="flex text-yellow-400 text-lg">
                            @for($i=0; $i<5; $i++)
                                {!! $i < round($avgRating) ? '★' : '<span class="text-gray-300">★</span>' !!}
                                @endfor
                                </div>
                                <span class="text-sm text-gray-500">(Berdasarkan {{ $countRating }} ulasan)</span>
                        </div>
                    </div>

                    {{-- Bagian Kanan (Tombol) --}}
                    <div class="flex items-center gap-4">
                    <button @click="showModal = true" class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-full shadow-md flex items-center gap-2 text-sm transition-all duration-200 hover:bg-blue-700 hover:shadow-lg hover:-translate-y-0.5 active:bg-blue-800 active:shadow-none active:translate-y-0 active:scale-95">
                        {{-- Ikon Pencil/Edit Baru --}}
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                            <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                        </svg>
                        Tulis Ulasan
                    </button>
                </div>
                </div>

                {{-- Flash Message --}}
                @if(session('success'))
                <div class="mb-8 p-4 bg-green-100 text-green-700 rounded-xl border border-green-200 flex items-center gap-2 animate-pulse">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
                @endif

                {{-- SLIDER CONTAINER --}}
                {{-- Added @mouseenter and @mouseleave for pause on hover --}}
                <div id="reviewSlider"
                    @mouseenter="stopAutoplay()"
                    @mouseleave="startAutoplay()"
                    class="flex gap-4 md:gap-6 overflow-x-auto pb-8 snap-x snap-mandatory scroll-smooth no-scrollbar"
                    style="scrollbar-width: none; -ms-overflow-style: none;">

                    @forelse($reviews as $review)
                    {{-- CARD ITEM: w-full (Mobile) | w-[350px] (Desktop) --}}
                    <div class="snap-center flex-shrink-0 w-[85vw] md:w-[350px] bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 relative group hover:-translate-y-1 transition duration-300 overflow-hidden">

                        {{-- Google Icon --}}
                        <div class="absolute top-6 right-6 opacity-80">
                            <svg class="w-6 h-6" viewBox="0 0 48 48">
                                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                                <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                            </svg>
                        </div>

                        <div class="flex items-center gap-3 mb-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($review->name) }}&background=random&color=fff" class="w-10 h-10 rounded-full shadow-sm" alt="{{ $review->name }}">
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm line-clamp-1">{{ $review->name }}</h4>
                                <p class="text-xs text-gray-500 line-clamp-1">{{ $review->role ?? 'Pengunjung' }}</p>
                            </div>
                        </div>

                        {{-- x-data="{ expanded: false }" untuk melacak status buka/tutup teks --}}
<div x-data="{ expanded: false }" class="flex flex-col h-full">
    
    <div class="flex items-center justify-between mb-3">
        <div class="flex text-yellow-400 text-sm">
            @for($i=0; $i<$review->rating; $i++) ★ @endfor
        </div>
        <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
    </div>

    {{-- Konten Teks Ulasan --}}
    {{-- Menggunakan :class Alpine untuk menghapus line-clamp jika expanded = true --}}
    <div 
        class="text-gray-600 text-sm leading-relaxed transition-all duration-300 relative cursor-pointer"
        :class="expanded ? '' : 'line-clamp-4 min-h-[5rem]'"
        @click="expanded = !expanded"
    >
        "{{ $review->content }}"
        
        {{-- Bayangan Gradasi di bagian bawah saat teks terpotong (opsional agar terlihat lebih cantik) --}}
        <div 
            x-show="!expanded" 
            class="absolute bottom-0 left-0 w-full h-8 bg-gradient-to-t from-white to-transparent"
        ></div>
    </div>

    {{-- Tombol Toggle "Baca Selengkapnya / Sembunyikan" --}}
    <button 
        @click="expanded = !expanded" 
        class="text-green-600 hover:text-green-700 text-xs font-bold text-left mt-2 focus:outline-none transition-colors w-max"
        x-text="expanded ? 'Sembunyikan' : 'Baca Selengkapnya'"
    ></button>

</div>

                    </div>
                    @empty
                    <div class="w-full text-center py-10 text-gray-500 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        Belum ada ulasan. Jadilah yang pertama memberikan ulasan!
                    </div>
                    @endforelse

                    {{-- Spacer Akhir --}}
                    <div class="w-1 flex-shrink-0"></div>
                </div>
            </div>

            {{-- MODAL FORM (COMPACT VERSION) --}}
            <div x-show="showModal" style="display: none;" class="fixed inset-0 z-[999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">

                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

                    {{-- Background Overlay --}}
                    <div x-show="showModal"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-gray-900/70 transition-opacity backdrop-blur-sm"
                        @click="showModal = false"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    {{-- Panel Modal Utama --}}
                    {{-- Perubahan: max-w-lg jadi max-w-md --}}
                    <div x-show="showModal"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full relative">

                        {{-- Tombol Close --}}
                        <button @click="showModal = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition bg-gray-50 hover:bg-gray-100 rounded-full p-1.5 focus:outline-none z-10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            {{-- Padding konten dikurangi --}}
                            <div class="px-6 pt-6 pb-5">

                                {{-- Header Teks --}}
                                <div class="text-center mb-5">
                                    <h3 class="text-xl font-bold text-gray-800" id="modal-title">Bagikan Pengalaman Anda</h3>
                                    <p class="text-xs text-gray-500 mt-1">Ulasan Anda membantu kami menjadi lebih baik.</p>
                                </div>

                                {{-- INPUT RATING --}}
                                <div class="mb-5 text-center bg-gray-50/50 py-3 rounded-xl border border-dashed border-gray-200">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Beri Bintang</label>
                                    <div class="flex flex-row-reverse justify-center gap-1 group">
                                        @for($i=5; $i>=1; $i--)
                                        <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" class="peer hidden" required />
                                        <label for="star{{$i}}" class="cursor-pointer text-gray-300 transition-all duration-200 
                                        peer-checked:text-yellow-400 
                                        peer-hover:text-yellow-400 
                                        hover:text-yellow-400 hover:scale-110 
                                        active:text-yellow-400 active:scale-125">
                                            {{-- Ukuran bintang dikurangi jadi w-8 h-8 --}}
                                            <svg class="w-8 h-8 drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                            </svg>
                                        </label>
                                        @endfor
                                    </div>
                                </div>

                                {{-- FORM FIELDS --}}
                                <div class="space-y-3">
                                    {{-- Nama --}}
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                        {{-- Padding input dikurangi jadi py-2 --}}
                                        <input type="text" name="name" required placeholder="Nama Anda" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none">
                                    </div>

                                    {{-- Role --}}
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Status <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                        <input type="text" name="role" placeholder="Contoh: Wali Santri" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none">
                                    </div>

                                    {{-- Ulasan --}}
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Detail Ulasan</label>
                                        <textarea name="content" rows="3" required placeholder="Ceritakan pengalaman belajar Anda..." class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none resize-none"></textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- FOOTER BUTTONS --}}
                            <div class="bg-gray-50 px-5 py-3 flex flex-col-reverse sm:flex-row sm:justify-end gap-2 border-t border-gray-100">

                                {{-- TOMBOL BATAL --}}
                                <button type="button" @click="showModal = false"
                                    class="w-full sm:w-auto px-4 py-2 bg-white text-gray-700 font-medium text-sm rounded-lg border border-gray-300 shadow-sm focus:outline-none 
               transition-all duration-200
               hover:bg-gray-100 hover:text-gray-900 
               active:bg-gray-200 active:scale-95">
                                    Batal
                                </button>

                                {{-- TOMBOL KIRIM --}}
                                <button type="submit"
                                    class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white font-bold text-sm rounded-lg shadow-md focus:outline-none flex justify-center items-center gap-2
               transition-all duration-200
               hover:bg-blue-700 hover:shadow-lg hover:-translate-y-0.5 
               active:bg-blue-800 active:shadow-none active:translate-y-0 active:scale-95">
                                    <span>Kirim</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>

    {{-- Custom Style untuk sembunyikan Scrollbar --}}
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    {{-- BANNER PROMO SECTION (NEW) --}}
    <section class="py-20 bg-fixed bg-cover bg-center relative" style="background-image: url('https://images.unsplash.com/photo-1609599006353-e629aaabfeae?q=80&w=2070&auto=format&fit=crop');">
        <div class="absolute inset-0 bg-green-900/80"></div>
        <div class="container max-w-5xl mx-auto px-4 relative z-10 text-center text-white">
            <h2 class="text-3xl md:text-5xl font-bold mb-6 leading-tight" data-aos="zoom-in">"Sebaik-baik kalian adalah yang mempelajari Al-Qur'an dan mengajarkannya."</h2>
            <p class="text-lg md:text-xl text-green-100 italic mb-8" data-aos="fade-up">(HR. Bukhari)</p>
            <div data-aos="fade-up" data-aos-delay="200">
                <a href="/login?mode=register"
                    class="inline-block px-10 py-4 bg-yellow-400 text-green-900 font-bold text-lg rounded-full shadow-lg 
          transition-all duration-200
          hover:bg-yellow-300 hover:shadow-xl hover:-translate-y-1 hover:scale-105
          active:bg-yellow-500 active:shadow-none active:translate-y-0 active:scale-95">
                    Mulai Belajar Sekarang
                </a>
            </div>
        </div>
    </section>

    {{-- 6. GURU SECTION --}}
    <section id="guru" class="py-16 md:py-24 bg-white scroll-mt-20">
        <div class="container max-w-7xl mx-auto px-4 md:px-6">
            <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-4">
                <div data-aos="fade-right">
                    <span class="text-green-600 font-bold text-xs md:text-sm uppercase tracking-wider px-3 py-1 bg-green-50 rounded-full inline-block mb-4">Asatidz Kami</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Pilih Pengajar Favorit</h2>
                </div>
                <div data-aos="fade-left">
                    <a href="/teachers" class="text-green-600 font-semibold hover:text-green-800 flex items-center gap-2">
                        Lihat Semua Guru
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-6 md:gap-8">
                @foreach($teachers as $index => $guru)
                <div class="relative bg-white rounded-2xl shadow-md overflow-hidden flex flex-col group hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-green-200"
                    data-aos="fade-up"
                    data-aos-delay="{{ $index * 100 }}">
                    @php
                    $methodClean = strtolower(trim($guru->method));
                    $methodColor = match(true) {
                    str_contains($methodClean, 'online') => 'bg-cyan-50 text-cyan-700 border-cyan-200 dark:bg-cyan-900/30 dark:text-cyan-400 dark:border-cyan-800',
                    str_contains($methodClean, 'offline') => 'bg-orange-50 text-orange-700 border-orange-200 dark:bg-orange-900/30 dark:text-orange-400 dark:border-orange-800',
                    default => 'bg-gray-100 text-gray-600 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
                    };
                    @endphp
                    <div class="absolute top-2 right-2 md:top-3 md:right-3 z-10">
                        <span class="px-2 py-1 md:px-3 md:py-1 text-[9px] md:text-[10px] rounded-lg font-bold uppercase tracking-wider border shadow-sm {{ $methodColor }}">
                            {{ ucfirst($guru->method) }}
                        </span>
                    </div>
                    <div class="p-4 md:p-6 bg-white flex-grow flex flex-col items-center text-center mt-3 md:mt-0">
                        <div class="w-16 h-16 md:w-24 md:h-24 rounded-full bg-gray-100 p-1 mb-3 md:mb-4 overflow-hidden border-2 border-dashed border-green-300 group-hover:border-solid group-hover:border-green-500 transition-all flex-shrink-0">
                            @if($guru->photo)
                            <img src="{{ asset('storage/' . $guru->photo) }}" alt="{{ $guru->user->name }}" class="w-full h-full rounded-full object-cover">
                            @else
                            <div class="w-full h-full rounded-full bg-green-50 flex items-center justify-center text-green-600 font-bold text-xl md:text-2xl">
                                {{ substr($guru->user->name, 0, 1) }}
                            </div>
                            @endif
                        </div>

                        {{-- Nama & Badge (Ditambahkan min-height agar rata antar card) --}}
                        <div class="mb-2 flex flex-col items-center justify-start min-h-[3.5rem] md:min-h-[4rem] w-full">
                            {{-- Mengubah line-clamp-1 menjadi line-clamp-2 dan text-medium menjadi text-base --}}
                            <h3 class="font-bold text-sm md:text-base text-gray-800 group-hover:text-green-600 transition line-clamp-2 leading-tight px-1">{{ $guru->user->name }}</h3>
                            @if($guru->user->is_verified ?? true)
                            <span class="inline-flex items-center gap-0.5 md:gap-1 bg-green-50 text-green-700 text-[9px] md:text-[10px] px-1.5 md:px-2 py-0.5 rounded-full font-bold capitalize tracking-wide mt-1.5">
                                <svg class="w-2.5 h-2.5 md:w-3 md:h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Terverifikasi
                            </span>
                            @endif
                        </div>
                            {{-- Spesialisasi: Clean & Simple --}}
                            <p class="text-green-600 font-normal text-sm md:text-sm mb-3 line-clamp-2 leading-snug px-1">
                                {{ $guru->specialization }}
                            </p>
                        
                        @if(!empty($guru->teaching_levels))
                        <div class="flex flex-wrap justify-center gap-1 md:gap-1.5 mb-4 md:mb-5 w-full">
                            @php
                            $levelsArray = is_array($guru->teaching_levels) || is_object($guru->teaching_levels)
                            ? (array) $guru->teaching_levels
                            : explode(',', $guru->teaching_levels);

                            $allowedPrograms = ['iqra', 'tahsin', 'tahfidz', 'sanad', 'bahasa'];
                            $validLevels = array_filter($levelsArray, fn($l) => in_array(trim($l), $allowedPrograms));
                            @endphp

                            @if(count($validLevels) > 0)
                            @foreach($validLevels as $rawLvl)
                            @php
                            $level = trim($rawLvl);

                            $levelColor = match($level) {
                            'iqra' => 'bg-emerald-50 text-emerald-600 border-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800',
                            'tahsin' => 'bg-blue-50 text-blue-600 border-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
                            'tahfidz' => 'bg-amber-50 text-amber-600 border-amber-100 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800',
                            'sanad' => 'bg-purple-50 text-purple-600 border-purple-100 dark:bg-purple-900/30 dark:text-purple-400 dark:border-purple-800',
                            'bahasa' => 'bg-indigo-50 text-indigo-600 border-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-400 dark:border-indigo-800',
                            default => 'bg-gray-50 text-gray-600 border-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
                            };

                            $shortLvl = match($level) {
                            'iqra' => 'Iqra',
                            'tahsin' => 'Tahsin',
                            'tahfidz' => 'Tahfidz',
                            'sanad' => 'Sanad',
                            'bahasa' => 'Bahasa',
                            default => ucfirst($level),
                            };
                            @endphp

                            <span class="px-2 md:px-2.5 py-0.5 md:py-1 text-[9px] md:text-[10px] rounded-full font-semibold border {{ $levelColor }}">
                                {{ $shortLvl }}
                            </span>
                            @endforeach
                            @else
                            <span class="px-2 md:px-2.5 py-0.5 md:py-1 text-[9px] md:text-[10px] rounded-full font-semibold border bg-gray-50 text-gray-400 border-gray-200 dark:bg-gray-800 dark:text-gray-500 dark:border-gray-700">Umum</span>
                            @endif

                        </div>
                        @else
                        <div class="mb-4 md:mb-5 h-[18px] md:h-[22px]"></div>
                        @endif

                        <a href="{{ route('booking.create', $guru->id) }}"
                            class="mt-auto w-full py-2 md:py-2.5 text-xs md:text-sm bg-green-600 text-white font-semibold rounded-xl shadow-lg shadow-green-100 flex items-center justify-center
          transition-all duration-200 hover:bg-green-700 hover:shadow-xl hover:-translate-y-0.5 active:bg-green-800 active:shadow-none active:scale-95 active:translate-y-0">
                            Daftar <span class="hidden md:inline">&nbsp;Kelas</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            @if($teachers->isEmpty())
            <div class="bg-gray-50 rounded-2xl p-10 text-center border-2 border-dashed border-gray-200 mt-8">
                <p class="text-gray-500 text-lg">Mohon maaf, belum ada pengajar yang tersedia saat ini.</p>
            </div>
            @endif
        </div>
    </section>

   {{-- PARTNERSHIP SECTION (Bordered Grid Layout with Rounded Corners - FIX) --}}
    <section class="py-16 md:py-24 bg-white border-t border-gray-100">
        <div class="container max-w-7xl mx-auto px-4 md:px-6">

            {{-- Section Title --}}
            <div class="text-center mb-8 flex items-center justify-center gap-2">
                {{-- Icon Sparkle --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/>
                    <path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/>
                </svg>
                <h3 class="text-base md:text-lg font-medium text-gray-800">
                    Didukung & Bekerja Sama Dengan
                </h3>
            </div>

            {{-- [BUNGKUSAN LUAR]: Menangani Rounded Corners --}}
        <div class="border border-gray-200 rounded-2xl overflow-hidden bg-white">
            
            {{-- Logos Grid Container --}}
            <div class="grid grid-cols-2 md:grid-cols-4">
                @php
                    // 1. Siapkan daftar 12 logo (Diduplikat agar pas memenuhi 12 kotak)
                    $logos = [
                        ['src' => 'images/rbq.webp', 'alt' => 'RBQ'],
                        ['src' => 'images/sm.webp', 'alt' => 'Smart IT'],
                        ['src' => 'images/yanibi.png', 'alt' => 'Yanibi'],
                        ['src' => 'images/aldaisi.png', 'alt' => 'Aldaisi'],
                        ['src' => 'images/alhijrah.jpeg', 'alt' => 'Alhijrah'],
                        // --- Duplikasi mulai dari sini ---
                        ['src' => 'images/rbq.webp', 'alt' => 'RBQ'],
                        ['src' => 'images/yanibi.png', 'alt' => 'Yanibi'],
                        ['src' => 'images/aldaisi.png', 'alt' => 'Aldaisi'],
                        ['src' => 'images/rbq.webp', 'alt' => 'RBQ'],
                        ['src' => 'images/alhijrah.jpeg', 'alt' => 'Alhijrah'],
                        ['src' => 'images/yanibi.png', 'alt' => 'Yanibi'],
                        ['src' => 'images/sm.webp', 'alt' => 'Smart IT'],
                    ];

                    // 2. Acak urutannya setiap kali halaman direfresh!
                    shuffle($logos);
                @endphp

                {{-- 3. Looping untuk mencetak logo beserta border yang super presisi --}}
                @foreach($logos as $index => $logo)
                    @php
                        // Logika cerdas untuk mengatur garis (border) agar tidak double/putus di HP & Desktop
                        $borderClasses = '';
                        
                        // Atur Garis Bawah
                        if ($index < 8) {
                            $borderClasses .= ' border-b'; 
                        } elseif ($index < 10) {
                            $borderClasses .= ' border-b md:border-b-0'; 
                        }
                        
                        // Atur Garis Kanan
                        if ($index % 2 == 0) {
                            $borderClasses .= ' border-r'; 
                        } else {
                            if ($index % 4 == 1) {
                                $borderClasses .= ' border-r-0 md:border-r'; 
                            }
                        }
                    @endphp

                    <a href="#" class="flex items-center justify-center p-6 sm:p-8 w-full h-full border-gray-200 hover:bg-gray-50 transition-colors {{ $borderClasses }}">
                        <img src="{{ asset($logo['src']) }}" alt="{{ $logo['alt'] }}"
                             class="h-10 md:h-12 lg:h-14 w-auto object-contain rounded-lg">
                    </a>
                @endforeach
            </div>
        </div> {{-- Akhir bungkusan luar --}}
            
        </div>
    </section>

</x-layout>