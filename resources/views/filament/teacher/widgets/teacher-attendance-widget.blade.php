<x-filament::widget>
    <x-filament::card>
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">

            {{-- Bagian Kiri: Info --}}
            <div>
                <h2 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white">
                    👋 Ahlan wa Sahlan, {{ auth()->user()->name }}!
                </h2>
               {{-- Tanggal & Jam Live Real-time --}}
                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1.5 flex flex-wrap items-center gap-2"
                     x-data="{ time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) }"
                     x-init="setInterval(() => time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }), 1000)">
                    
                    {{-- Tanggal --}}
                    <span>{{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y') }}</span>
                    
                    {{-- Pemisah --}}
                    <span class="hidden md:inline text-gray-300 dark:text-gray-600">•</span>
                    
                    {{-- Jam Digital yang berdetak --}}
                    <div class="font-mono font-bold text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30 px-2 py-0.5 rounded-md flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span x-text="time"></span> WIB
                    </div>
                </div>

                {{-- Tampilkan Status jika Sakit/Izin --}}
                @if($attendance && $attendance->status !== 'present')
                <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $attendance->status === 'sick' 
                            ? 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300' 
                            : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300' 
                        }}">
                    Status Hari Ini: {{ ucfirst($attendance->status == 'sick' ? 'Sakit' : 'Izin') }}
                </div>
                @endif
            </div>

            {{-- Bagian Kanan: Tombol Aksi --}}
            <div class="flex flex-wrap items-center gap-3">

                {{-- ====================================================== --}}
                {{-- CEK APAKAH ADA JADWAL HARI INI --}}
                {{-- ====================================================== --}}
                @if($hasScheduleToday)

                    {{-- KONDISI 1: Belum ada data absensi hari ini --}}
                    @if(!$attendance)

                        {{-- Tombol Izin & Sakit (Render dari Action PHP) --}}
                        {{ ($this->permitAction)(['class' => '']) }}
                        {{ ($this->sickAction)(['class' => '']) }}

                        {{-- Tombol Hadir (Gunakan Komponen Filament agar Support Dark/Light Mode) --}}
                        <x-filament::button
                            wire:click="clockIn"
                            color="success"
                            icon="heroicon-o-check-circle">
                            Masuk
                        </x-filament::button>

                    {{-- KONDISI 2: Sudah Hadir, tapi belum pulang --}}
                    @elseif($attendance->status === 'present' && !$attendance->clock_out)

                        <div class="text-center mr-2 hidden md:block">
                            <span class="text-xs text-gray-500 dark:text-gray-400">Masuk:</span>
                            <div class="font-mono font-bold text-green-600 dark:text-green-400">
                                {{ \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') }}
                            </div>
                        </div>

                        {{-- Tombol Pulang --}}
                        <x-filament::button
                            wire:click="clockOut"
                            color="danger"
                            icon="heroicon-o-arrow-right-start-on-rectangle">
                            Pulang
                        </x-filament::button>

                    {{-- KONDISI 3: Absensi Selesai (Sudah Pulang / Sakit / Izin) --}}
                    @else
                        <div class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-lg text-sm font-bold border border-gray-200 dark:border-gray-700">
                            ✅ Absensi Selesai
                        </div>
                    @endif

                @else
                    {{-- ====================================================== --}}
                    {{-- TAMPILAN JIKA TIDAK ADA JADWAL (LIBUR) --}}
                    {{-- ====================================================== --}}
                    <div class="px-4 py-2.5 bg-gray-50 dark:bg-gray-800/50 text-gray-500 dark:text-gray-400 rounded-xl text-sm font-bold border border-dashed border-gray-300 dark:border-gray-700 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        Hari Libur (Tidak ada jadwal mengajar)
                    </div>
                @endif

            </div>
        </div>

        {{-- WAJIB ADA: Wadah untuk Popup Modal (Izin/Sakit) --}}
        <x-filament-actions::modals />

    </x-filament::card>
</x-filament::widget>