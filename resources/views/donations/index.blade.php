<x-layout>
    <x-slot:title>Program Kebaikan - Deep Quran Academy</x-slot:title>

    {{-- ========================================================== --}}
    {{-- 1. HERO SECTION (MENGIKUTI DNA HOMEPAGE) --}}
    {{-- ========================================================== --}}
   {{-- KUNCI PERBAIKAN 1: Tambahkan inline style padding-bottom: 14rem (sekitar 224px) agar ruang bawah sangat lega --}}
    <section class="relative pt-32 md:pt-32 bg-gradient-to-br from-green-900 via-green-800 to-green-600 overflow-hidden" style="padding-bottom: 6rem;">
        
        {{-- Background Elements & Pattern --}}
        <div class="absolute inset-0 opacity-20 mix-blend-overlay" style="background-image: url('{{ asset('arabesque.png') }}');"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-green-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>

        <div class="container max-w-7xl mx-auto px-4 md:px-6 relative z-10 flex flex-col items-center text-center">
            
            {{-- Badge (Gaya beranda dengan titik kuning berkedip) --}}
            <div class="inline-flex items-center gap-2 px-3 py-1 mb-6 bg-green-800/50 border border-green-700 rounded-full backdrop-blur-md" data-aos="fade-down">
                <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                <span class="text-xs font-semibold capitalize tracking-wider text-green-100">Infaq & Shadaqah</span>
            </div>

            {{-- Teks Judul (Gradasi kuning emas) --}}
            <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6 text-white" data-aos="fade-up" data-aos-delay="100">
                Program <br class="md:hidden">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-500">Kebaikan</span>
            </h1>
            
            {{-- Teks Deskripsi (Kutipan Ayat) --}}
            <p class="text-sm md:text-lg text-green-100/90 mb-8 leading-relaxed font-light max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                "Perumpamaan orang yang menginfakkan hartanya di jalan Allah seperti sebutir biji yang menumbuhkan tujuh tangkai, pada setiap tangkai ada seratus biji." <br>
                <span class="font-semibold block mt-3 text-yellow-400">(QS. Al-Baqarah: 261)</span>
            </p>
        </div>
    </section>

    {{-- ========================================================== --}}
    {{-- 2. AREA KONTEN (Grid Kartu Donasi) --}}
    {{-- ========================================================== --}}
    {{-- Class -mt-16 md:-mt-24 digunakan untuk efek kartu menumpuk ke atas hero --}}
   {{-- KUNCI PERBAIKAN 2: Kurangi efek tumpuk dari -mt-24 menjadi -mt-12 md:-mt-16 agar tidak terlalu naik --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 md:pb-16 relative z-20 -mt-12 md:-mt-16">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @forelse($campaigns as $campaign)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col group">
                
                {{-- GAMBAR BANNER --}}
                {{-- Mengunci tinggi secara absolut (240px) agar seragam dan tidak bocor di hosting --}}
                <div class="relative overflow-hidden bg-gray-100 dark:bg-gray-700 group" style="height: 240px; width: 100%;">
                    
                    @if($campaign->image)
                        {{-- object-fit: cover memastikan gambar terpotong rapi memenuhi kotak tanpa gepeng --}}
                        {{-- object-position: center top memastikan jika posternya tinggi, bagian atas (judul) yang diprioritaskan tampil --}}
                        <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" 
                             class="group-hover:scale-105 transition-transform duration-700"
                             style="width: 100%; height: 100%; object-fit: cover; object-position: center top;">
                    @else
                        <div class="flex items-center justify-center text-gray-400" style="width: 100%; height: 100%;">
                            <svg style="width: 3rem; height: 3rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    
                    {{-- Badge Status di Gambar --}}
                    <div style="position: absolute; top: 16px; right: 16px; z-index: 10;" class="bg-white/95 px-3 py-1.5 rounded-full text-[10px] font-bold text-green-700 shadow-md uppercase tracking-wider">
                        Sedang Berjalan
                    </div>
                </div>

                <div class="p-6 md:p-8 flex flex-col flex-grow">
                   {{-- JUDUL PROGRAM --}}
                    {{-- Tambahan group-hover:text-green-600 agar warna judul berubah saat kartu di-hover --}}
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 transition-colors group-hover:text-green-600">
                        <a href="{{ route('donasi.show', $campaign->slug) }}" class="focus:outline-none">
                            {{ $campaign->title }}
                        </a>
                    </h3>

                    {{-- PROGRESS BAR & NOMINAL --}}
                    <div class="mt-auto pt-6">
                        @php
                            $percentage = 0;
                            if ($campaign->target_amount > 0) {
                                $percentage = ($campaign->collected_amount / $campaign->target_amount) * 100;
                                if ($percentage > 100) $percentage = 100;
                            }
                        @endphp
                        
                        <div class="flex justify-between items-end mb-2">
                            <div class="text-xs text-gray-500 font-medium">Dana Terkumpul</div>
                            @if($campaign->target_amount)
                            <div class="text-sm font-bold text-green-600">{{ number_format($percentage, 0) }}%</div>
                            @endif
                        </div>
                        
                        {{-- Bar Progress --}}
                        <div class="w-full bg-gray-100 rounded-full h-3 mb-3 overflow-hidden border border-gray-200">
                            <div class="h-full rounded-full relative" style="background-color: #16a34a; width: {{ $percentage }}%"></div>
                        </div>
                        
                        <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
                            <div class="font-black text-gray-900 dark:text-white text-lg">
                                Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}
                            </div>
                            @if($campaign->target_amount)
                            <div class="text-xs text-gray-400 font-medium text-right">
                                Target <br> Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}
                            </div>
                            @endif
                        </div>

                        {{-- TOMBOL DONASI (Identik dengan Beranda) --}}
                        <a href="{{ route('donasi.show', $campaign->slug) }}" 
                           class="block w-full py-4 bg-yellow-500 text-green-900 rounded-full text-sm font-bold uppercase tracking-wide text-center shadow-lg transition-all duration-300 hover:bg-yellow-400 hover:shadow-xl hover:-translate-y-1 active:bg-yellow-600 active:shadow-none active:translate-y-0 active:scale-95">
                            Donasi Sekarang
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-16 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-50 text-green-600 mb-5">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Belum ada program</h3>
                <p class="text-gray-500 mt-2">Nantikan ladang amal kebaikan kami selanjutnya.</p>
            </div>
            @endforelse
        </div>
    </div>
</x-layout>