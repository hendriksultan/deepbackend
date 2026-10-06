<x-layout>
   <x-slot:title>Donasi: {{ $campaign->title }}</x-slot:title>

    {{-- ========================================== --}}
    {{-- INJECT META SEO & THUMBNAIL KHUSUS DONASI  --}}
    {{-- ========================================== --}}
    <x-slot:meta>
        <meta name="title" content="Donasi: {{ $campaign->title }} - Deep Quran Academy">
        <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($campaign->description), 150) }}">
        
        <!-- Open Graph / Facebook / WhatsApp -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="Donasi: {{ $campaign->title }}">
        <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($campaign->description), 150) }}">
        @if($campaign->image)
            <meta property="og:image" content="{{ asset('storage/' . $campaign->image) }}">
        @else
            <meta property="og:image" content="{{ asset('images/pavicon.png') }}">
        @endif

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="Donasi: {{ $campaign->title }}">
        <meta property="twitter:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($campaign->description), 150) }}">
        @if($campaign->image)
            <meta property="twitter:image" content="{{ asset('storage/' . $campaign->image) }}">
        @else
            <meta property="twitter:image" content="{{ asset('images/pavicon.png') }}">
        @endif
    </x-slot:meta>

    <style>
        html, body { overflow-x: hidden !important; }

        /* ========================================= */
        /* PERBAIKAN UI FORM (Hanya Sisakan Ini Saja)*/
        /* ========================================= */
        .input-dqa { 
            border: 1px solid #d1d5db; 
            padding: 0.875rem 1rem; 
            border-radius: 0.75rem; 
            width: 100%; 
            outline: none; 
            transition: all 0.2s;
            background-color: #f9fafb; 
        }
        .input-dqa:focus { 
            border-color: #16a34a; 
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.1); 
        }
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
        input[type=number] { -moz-appearance: textfield; }
        
        .btn-emas { background-color: #eab308; color: #14532d; font-weight: bold; border-radius: 9999px; padding: 1rem; text-align: center; display: block; width: 100%; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(234, 179, 8, 0.3); }
        .btn-emas:hover { background-color: #facc15; transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(234, 179, 8, 0.4); }
        
        .radio-box input[type="radio"]:checked + div { border-color: #16a34a; background-color: #f0fdf4; box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.2); }
        
        /* ========================================= */
        /* SULAP LINK WHATSAPP JADI TOMBOL OTOMATIS  */
        /* ========================================= */
        .prose-green a[href*="wa.me"], 
        .prose-green a[href*="api.whatsapp.com"] {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            padding: 0.6rem 1.5rem !important;
            background-color: #22c55e !important; /* Warna hijau khas WA */
            color: #ffffff !important;
            font-size: 0.875rem !important;
            font-weight: bold !important;
            border-radius: 9999px !important; /* Bentuk kapsul/pil */
            text-decoration: none !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
            transition: all 0.3s ease !important;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        /* Efek saat mouse diarahkan ke tombol */
        .prose-green a[href*="wa.me"]:hover, 
        .prose-green a[href*="api.whatsapp.com"]:hover {
            background-color: #16a34a !important; 
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(34, 197, 94, 0.3) !important;
        }

        /* Otomatis memunculkan Ikon Logo WhatsApp (Vektor Resmi & Identik) */
        .prose-green a[href*="wa.me"]::before, 
        .prose-green a[href*="api.whatsapp.com"]::before {
            content: "";
            display: inline-block;
            width: 1.35rem; /* Sedikit diperbesar agar presisi */
            height: 1.35rem;
            margin-right: 0.5rem;
            /* SVG WhatsApp Resmi (URL Encoded agar aman di semua browser) */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'%3E%3Cpath fill='%23ffffff' d='M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>

    {{-- Ambil Data Donatur yang Lunas --}}
    @php
        $donations = \App\Models\Donation::where('campaign_id', $campaign->id)
                        ->where('status', 'paid')
                        ->latest()
                        ->get();
    @endphp

    {{-- ========================================================== --}}
    {{-- 1. HERO SECTION (100% IDENTIK DENGAN HALAMAN INDEX) --}}
    {{-- ========================================================== --}}
    <section class="relative pt-32 md:pt-40 bg-gradient-to-br from-green-900 via-green-800 to-green-600 overflow-hidden" style="padding-bottom: 14rem;">
        
        {{-- Background Elements & Pattern --}}
        <div class="absolute inset-0 opacity-20 mix-blend-overlay" style="background-image: url('{{ asset('arabesque.png') }}');"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-green-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>

        <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('donasi.index') }}" class="inline-flex items-center text-green-50 hover:text-white font-medium mb-6 transition-colors" data-aos="fade-down">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Program
            </a>
            
            {{-- Judul Campaign --}}
            <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-2 leading-tight" data-aos="fade-up" data-aos-delay="100">
                {{ $campaign->title }}
            </h1>
            
        </div>
    </section>

    {{-- ========================================================== --}}
    {{-- 2. KONTEN UTAMA (Biarkan kode di bawah ini utuh seperti sebelumnya) --}}
    {{-- ========================================================== --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 relative z-20 -mt-20 md:-mt-28">
        
        @if(session('info'))
        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-4 rounded-xl mb-6 flex items-start gap-3 shadow-sm">
            <svg class="w-6 h-6 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="leading-relaxed">{{ session('info') }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-10">
            
            {{-- BAGIAN KIRI: Info, Gambar, dan Daftar Donatur --}}
            <div class="lg:col-span-2">
                {{-- Card Gambar & Progress --}}
                <div class="bg-white rounded-3xl p-3 md:p-4 shadow-xl border border-gray-100 mb-8" data-aos="fade-up" data-aos-delay="200">
                    @if($campaign->image)
                        <img src="{{ asset('storage/' . $campaign->image) }}" class="w-full h-auto max-h-[400px] rounded-2xl object-cover mb-6">
                    @endif
                    
                    <div class="px-2 md:px-4 pb-4">
                        @php
                            $percentage = $campaign->target_amount > 0 ? min(($campaign->collected_amount / $campaign->target_amount) * 100, 100) : 0;
                        @endphp
                        <div class="text-gray-500 text-sm font-medium mb-1">Dana Terkumpul</div>
                        <div class="text-3xl md:text-4xl font-black text-green-600 mb-4">Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}</div>
                        
                        <div class="w-full bg-gray-100 rounded-full h-3 mb-3 border border-gray-200 overflow-hidden">
                            <div class="bg-green-500 h-full rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        
                        <div class="flex justify-between items-center text-sm">
                            <div class="font-bold text-gray-700">{{ number_format($percentage, 0) }}% Tercapai</div>
                            @if($campaign->target_amount)
                            <div class="text-gray-500">Target: Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Deskripsi Program --}}
                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 border-b border-gray-200 pb-4 mb-6">Deskripsi Program</h3>
                    <div class="prose prose-green max-w-none text-gray-600 leading-relaxed">
                        {!! $campaign->description !!}
                    </div>
                </div>

                {{-- FITUR BARU: Daftar Donatur Ala Kitabisa --}}
                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 border-b border-gray-200 pb-4 mb-6"> 
                        Donasi & Doa Orang Baik ({{ $donations->count() }})
                    </h3>
                    
                    <div class="space-y-6">
                        @forelse($donations as $donatur)
                        <div class="flex gap-4 items-start">
                            {{-- Avatar --}}
                            <div class="w-12 h-12 rounded-full bg-green-50 text-green-600 flex items-center justify-center font-bold text-lg flex-shrink-0 border border-green-100">
                                {{ $donatur->is_anonymous ? 'HA' : strtoupper(substr($donatur->donor_name, 0, 1)) }}
                            </div>
                            
                            {{-- Konten --}}
                            <div class="flex-grow">
                            <!-- 1. Tambahkan gap-x-2 atau gap-x-4 agar selalu ada jarak horizontal -->
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-1 gap-2 sm:gap-4">
                                
                                <!-- 2. Tambahkan flex-1 dan min-w-0 agar nama yang panjang tidak merusak layout -->
                                <div class="flex-1 min-w-0">
                                    <!-- 3. Tambahkan break-words agar nama panjang turun ke bawah (atau pakai 'truncate' jika ingin dipotong dengan ...) -->
                                    <div class="font-bold text-gray-900 text-md break-words">
                                        {{ $donatur->is_anonymous ? 'Hamba Allah' : $donatur->donor_name }}
                                    </div>
                                    <div class="text-sm font-bold text-green-600 mt-0.5">
                                        Berdonasi Rp {{ number_format($donatur->amount, 0, ',', '.') }}
                                    </div>
                                </div>
                                
                                <!-- 4. Tambahkan flex-shrink-0 dan whitespace-nowrap agar teks waktu tidak terhimpit/terlipat -->
                                <div class="text-xs text-gray-400 mt-1 sm:mt-0 flex-shrink-0 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($donatur->created_at)->diffForHumans() }}
                                </div>
                            </div>
                            
                            {{-- Pesan / Doa --}}
                            @if($donatur->message)
                            <div class="mt-3 bg-gray-50 rounded-2xl rounded-tl-none p-4 text-sm text-gray-600 italic border border-gray-100 relative">
                                "{{ $donatur->message }}"
                            </div>
                            @endif
                        </div>
                        </div>
                        
                        @if(!$loop->last)
                            <hr class="border-gray-100">
                        @endif
                        
                        @empty
                        <div class="text-center py-10">
                            <div class="inline-flex w-16 h-16 bg-gray-50 rounded-full items-center justify-center text-gray-300 mb-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <h4 class="font-bold text-gray-900">Belum ada donatur</h4>
                            <p class="text-gray-500 text-sm">Jadilah yang pertama menabur kebaikan di program ini!</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- BAGIAN KANAN: Formulir Pembayaran (Sticky) --}}
            <div class="lg:col-span-1" data-aos="fade-left" data-aos-delay="300">
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-6 md:p-8 sticky top-24">
                   <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-4 md:mb-6 border-b border-gray-200 pb-3 md:pb-4">Isi Data Donasi</h3>
                   
                    <form action="{{ route('donasi.store', $campaign->slug) }}" method="POST">
                        @csrf
                        
                        {{-- 1. Nominal --}}
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nominal (Minimal Rp 10.000)</label>
                            <div class="relative flex items-center">
                                <span class="absolute left-4 font-bold text-gray-500 text-lg">Rp</span>
                                <input type="number" name="amount" min="10000" required class="input-dqa font-bold text-xl text-gray-900" style="padding-left: 3.5rem;" placeholder="10000">
                            </div>
                        </div>

                        {{-- 2. Data Donatur --}}
                        <div class="mb-6 space-y-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="donor_name" required class="input-dqa" placeholder="Fulan bin Fulan">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">No. WhatsApp</label>
                                <input type="tel" name="donor_phone" required class="input-dqa" placeholder="081234567890">
                            </div>
                            <label class="flex items-center gap-3 cursor-pointer bg-gray-50 p-4 rounded-xl border border-gray-200 hover:bg-gray-100 transition-colors">
                                <input type="checkbox" name="is_anonymous" class="w-5 h-5 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                <span class="text-sm font-medium text-gray-700">Sembunyikan nama saya (Hamba Allah)</span>
                            </label>
                        </div>

                       {{-- 3. Metode Pembayaran (Manual: QRIS & Transfer) --}}
                        <div class="mb-6">
                            <label class="block text-xs md:text-sm font-bold text-gray-700 mb-2 md:mb-3">Metode Pembayaran</label>
                            
                            <input type="hidden" name="payment_method" value="manual">
                            
                            <div class="border-2 border-green-500 bg-green-50 rounded-xl p-3 md:p-4 flex items-center gap-3 md:gap-4 shadow-sm">
                                {{-- Ikon QRIS / TF --}}
                                <div class="w-10 h-10 md:w-12 md:h-12 bg-white rounded-lg flex items-center justify-center font-bold text-green-700 text-[9px] md:text-[11px] text-center border border-green-200 leading-tight shadow-sm">
                                    QRIS<br>& TF
                                </div>
                                
                                {{-- Teks Penjelasan --}}
                                <div>
                                    <div class="font-bold text-gray-900 text-sm md:text-base">QRIS & Transfer Bank</div>
                                    <div class="text-[10px] md:text-xs text-green-800 mt-0.5">Gopay, OVO, BSI, BCA, dll (Verifikasi Admin)</div>
                                </div>
                                
                                {{-- Ikon Centang Aktif --}}
                                <div class="ml-auto text-green-600">
                                    <svg class="w-6 h-6 md:w-7 md:h-7" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        {{-- 4. Pesan Doa --}}
                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tulis Doa (Opsional)</label>
                            <textarea name="message" rows="3" class="input-dqa resize-none" placeholder="Tuliskan doa untuk penggalangan dana ini, atau doa untuk diri sendiri agar diaminkan oleh orang lain..."></textarea>
                        </div>

                        <button type="submit" class="btn-emas text-lg uppercase tracking-wider">Lanjutkan Donasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>