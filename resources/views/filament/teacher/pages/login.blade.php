<x-filament-panels::page.simple>

    {{-- ========================================================== --}}
    {{-- BANNER KIRI (MENGGUNAKAN HTML/CSS MURNI ANTI GAGAL) --}}
    {{-- ========================================================== --}}
    <div id="left-banner" style="
        display: none; /* Default sembunyi di HP */
        position: fixed; 
        top: 0; 
        left: 0; 
        width: 50%; 
        height: 100vh; 
        background: linear-gradient(135deg, #059669 0%, #064e3b 100%); 
        z-index: 50; 
        flex-direction: column; 
        align-items: center; 
        justify-content: center; 
        text-align: center; 
        padding: 3rem; 
        color: white;
    ">
        {{-- Logo dipaksa ukuran 90px dengan Inline CSS --}}
        <div style="background: white; padding: 1rem; border-radius: 50%; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); margin-bottom: 2rem;">
            <img src="{{ asset('images/pavicon.png') }}" alt="Logo Deep Quran" style="width: 90px; height: 90px; object-fit: contain;">
        </div>
        
        <h1 style="font-size: 2.25rem; font-weight: 800; margin-bottom: 1rem; line-height: 1.2;">
            Deep Quran Academy
        </h1>
        
        <p style="max-width: 24rem; font-size: 0.95rem; opacity: 0.9; line-height: 1.6; color: #ecfdf5;">
            Portal Manajemen Pengajar.<br>
            Kelola jadwal kelas, presensi santri, dan evaluasi laporan hafalan dengan mudah.
        </p>
    </div>

    {{-- ========================================================== --}}
    {{-- CSS MURNI UNTUK MEROMBAK TAMPILAN BAWAAN FILAMENT --}}
    {{-- ========================================================== --}}
    <style>
        /* 1. Putihkan seluruh background halaman utama Filament */
        html, body, .fi-simple-layout {
            background-color: #ffffff !important;
        }

        /* 2. MODE DESKTOP: TRIK PEMBELAH LAYAR MUTLAK */
        @media (min-width: 768px) {
            #left-banner {
                display: flex !important; /* Munculkan banner kiri */
            }
            
            /* Fondasi utama didorong 50% dari kiri, agar konten di dalamnya terpaksa pindah ke kanan */
            .fi-simple-layout {
                padding-left: 50% !important;
            }
            
            /* Sembunyikan Logo atas bawaan Filament (karena sudah ada di banner kiri) */
            .fi-logo {
                display: none !important;
            }
        }

        /* 3. Menyesuaikan lebar form agar manis dan proporsional */
        .fi-simple-main {
            width: 100% !important;
            max-width: 400px !important;
            margin: 0 auto !important; /* Otomatis rata tengah di area yang tersisa */
        }

        /* 4. PEMBASMI KOTAK & GARIS BAYANGAN (CARDLESS ABSOLUT) */
        /* Menargetkan semua lapisan pembungkus bawaan Filament v3 */
        .fi-simple-main,
        .fi-simple-main > div,
        .fi-simple-main section,
        .fi-panel {
            box-shadow: none !important;
            background: transparent !important;
            background-color: transparent !important;
            border: none !important;
            outline: none !important;
            
            /* Matikan ring shadow khas Tailwind secara brutal di semua lapisan */
            --tw-ring-color: transparent !important;
            --tw-ring-shadow: 0 0 transparent !important;
            --tw-ring-offset-shadow: 0 0 transparent !important;
            --tw-shadow: 0 0 transparent !important;
            --tw-shadow-colored: 0 0 transparent !important;
        }
        
        /* Tambahan: Mematikan border pemisah jika Filament membuatnya dengan border murni */
        .fi-simple-main, .fi-panel {
            border-width: 0px !important;
        }
    </style>

    {{-- ========================================================== --}}
    {{-- FORM LOGIN FILAMENT (LOGIKA MESIN TETAP AMAN) --}}
    {{-- ========================================================== --}}
    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

</x-filament-panels::page.simple>