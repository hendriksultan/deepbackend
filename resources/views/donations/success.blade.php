<x-layout>
    <x-slot:title>Instruksi Transfer - Deep Quran Academy</x-slot:title>
    {{-- ======================================================== --}}
    {{-- AREA HEADER BACKGROUND GRADASI & ASSET PATTERN --}}
    {{-- ======================================================== --}}
    <div class="w-full bg-gradient-to-br from-green-900 via-green-800 to-green-600 pt-32 pb-24 relative overflow-hidden">
        
        {{-- Background Elements & Pattern --}}
        <div class="absolute inset-0 opacity-20 mix-blend-overlay" style="background-image: url('{{ asset('arabesque.png') }}');"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-green-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>

        <div class="max-w-3xl mx-auto px-4 text-center relative z-10">
            
            {{-- Ikon Centang --}}
            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg border-4 border-white/20">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-3 tracking-tight">Alhamdulillah, Donasi Dicatat!</h1>
            <p class="text-emerald-100 text-sm md:text-base">
                Terima kasih Kak <strong>{{ $donation->is_anonymous ? 'Hamba Allah' : $donation->donor_name }}</strong>. Satu langkah lagi, silakan selesaikan pembayaran Anda.
            </p>
        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- AREA KARTU QRIS (DITARIK KE ATAS AGAR MENUMPUK HEADER) --}}
    {{-- ======================================================== --}}
    <div class="max-w-3xl mx-auto px-4 pb-20 -mt-12 relative z-20 text-center">
        
        {{-- Kartu Utama --}}
        <div class="bg-white border border-gray-100 rounded-3xl p-6 md:p-10 shadow-[0_10px_40px_rgba(0,0,0,0.08)] text-left mb-8">
            
            {{-- Rincian Transaksi --}}
            <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
                <div>
                    <div class="text-sm text-gray-500">ID Referensi</div>
                    <div class="font-bold text-gray-900">{{ $donation->reference }}</div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Nominal Transfer</div>
                    <div class="text-2xl font-black text-emerald-600">Rp {{ number_format($donation->amount, 0, ',', '.') }}</div>
                </div>
            </div>

            <h3 class="font-bold text-gray-800 mb-4 text-center md:text-left">Pastikan nominal transfer tepat hingga 3 digit terahir:</h3>
            
            {{-- QRIS STATIS UNTUK DONASI --}}
            <div class="bg-gray-50 rounded-xl p-5 mb-4 flex flex-col items-center justify-center border border-gray-200 text-center">
                
                <h4 class="text-sm font-bold text-teal-800 mb-3 uppercase tracking-wider">
                    Scan QRIS untuk Berdonasi
                </h4>
                
                {{-- Bingkai Gambar QRIS --}}
                <div class="bg-white p-3 rounded-2xl border border-gray-200 shadow-sm transition-transform duration-300 hover:scale-105">
                    <img src="{{ asset('images/dqa-qris.png') }}" alt="QRIS Donasi Deep Quran Academy" class="w-48 md:w-56 h-auto object-contain rounded-xl">
                </div>
                
                <p class="text-xs text-gray-500 mt-4 leading-relaxed max-w-xs">
                    Mendukung semua aplikasi e-Wallet (Gopay, OVO, Dana) & Mobile Banking.
                </p>
                
            </div>

            <div class="mt-8 bg-blue-50 text-blue-800 p-4 rounded-xl text-sm leading-relaxed border border-blue-100">
                <strong>Penting:</strong> Jika sudah transfer, mohon konfirmasi ke Admin kami dengan mengirimkan tangkapan layar (screenshot) bukti transfer.
            </div>
        </div>

        {{-- TOMBOL KONFIRMASI WA DINAMIS --}}
        @php
            // Memanggil nomor WA dari .env, jika kosong pakai nomor default
            $wa_number = env('DONASI_ADMIN_WA', '6285860913931');
            $wa_text = "Assalamu'alaikum Admin DQA. Saya telah melakukan donasi dengan ID *{$donation->reference}* sejumlah *Rp " . number_format($donation->amount, 0, ',', '.') . "*. Berikut saya lampirkan bukti transfernya.";
            $wa_link = "https://wa.me/{$wa_number}?text=" . urlencode($wa_text);
        @endphp

        <a href="{{ $wa_link }}" target="_blank" class="inline-flex items-center justify-center px-8 py-4 bg-emerald-600 text-white font-bold rounded-full shadow-lg hover:bg-emerald-700 hover:-translate-y-1 transition-all w-full md:w-auto">
            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
            Konfirmasi via WhatsApp
        </a>

    </div>
</x-layout>