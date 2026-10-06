<x-student-layout>
    {{-- [PERBAIKAN] Ubah py-6 menjadi pt-0 pb-6 agar jarak atas menempel, tapi jarak bawah tetap aman di HP --}}
    <div class="container mx-auto px-3 md:px-4 pt-0 pb-6 md:py-8">
        
        {{-- Header & Tombol Kembali --}}
        {{-- [PERBAIKAN] Margin bawah (mb) di HP juga disusutkan dari mb-4 menjadi mb-3 --}}
        <div class="flex items-center gap-2 md:gap-3 mb-3 md:mb-6">
            <a href="{{ route('student.dashboard') }}" class="p-1.5 md:p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm text-gray-500 hover:text-blue-600 transition border border-gray-100 dark:border-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="text-lg md:text-2xl font-bold text-gray-800 dark:text-white">Riwayat Kehadiran Lengkap</h2>
        </div>

        @if($groupedPresensi->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 md:p-10 text-center shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-50 dark:bg-gray-900 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4 border border-gray-100 dark:border-gray-700">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <h3 class="text-base md:text-lg font-semibold text-gray-700 dark:text-gray-300">Belum ada data kehadiran.</h3>
                <p class="text-gray-500 text-xs md:text-sm mt-1">Data presensi akan muncul setelah Ustadz/Ustadzah mengisi absensi kelas.</p>
            </div>
        @else
            <div class="flex flex-col gap-3 md:gap-4">
                {{-- LOOPING LEVEL 1: BERDASARKAN GURU & KELOMPOK --}}
                @foreach($groupedPresensi as $namaGuru => $dataPerBulan)
                    
                    <div x-data="{ expanded: {{ $loop->first ? 'true' : 'false' }} }" class="bg-white dark:bg-gray-800 rounded-xl md:rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        
                        {{-- Header Guru --}}
                        {{-- [RESPONSIF] Padding disusutkan di HP (p-3 md:p-5) --}}
                        <button @click="expanded = !expanded" class="w-full text-left bg-blue-50/50 hover:bg-blue-100/50 dark:bg-transparent dark:hover:bg-gray-700/50 transition-colors p-3 md:p-5 flex items-center justify-between gap-3 md:gap-4 focus:outline-none" :class="expanded ? 'border-b border-gray-100 dark:border-gray-700' : ''">
                            <div class="flex items-center gap-3 md:gap-4">
                                {{-- [RESPONSIF] Lingkaran ikon mengecil di HP --}}
                                <div class="w-8 h-8 md:w-10 md:h-10 flex-shrink-0 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300">
                                    <svg class="w-4 h-4 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                {{-- [RESPONSIF] Teks nama guru mengecil di HP --}}
                                <h3 class="text-sm md:text-lg font-bold text-gray-800 dark:text-white leading-tight">{{ $namaGuru }}</h3>
                            </div>
                            
                            <div class="flex-shrink-0 text-blue-500 dark:text-blue-400">
                                <svg :class="expanded ? 'rotate-180' : 'rotate-0'" class="w-5 h-5 md:w-6 md:h-6 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>

                        <div x-show="expanded" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="p-3 md:p-5 flex flex-col gap-6 md:gap-8">
                            
                           {{-- LOOPING LEVEL 2: BERDASARKAN BULAN --}}
                            @foreach($dataPerBulan as $bulan => $jadwals)
                                <div>
                                    <h4 class="text-[10px] md:text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-widest mb-2 md:mb-3 flex items-center gap-1.5 md:gap-2">
                                        <span class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-blue-500"></span>
                                        Bulan: {{ $bulan }}
                                    </h4>
                                    
                                    <div class="overflow-hidden rounded-lg md:rounded-xl border border-gray-100 dark:border-gray-700">
                                        <table class="w-full text-left table-fixed">
                                            <colgroup>
                                                {{-- Mengatur porsi kolom: Tanggal sedikit lebih besar di HP agar tidak terlalu terpotong --}}
                                                <col style="width: 35%;">
                                                <col style="width: 40%;">
                                                <col style="width: 25%;">
                                            </colgroup>
                                            
                                            <thead>
                                                <tr class="bg-gray-50/50 dark:bg-transparent text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-100 dark:border-gray-700 text-[8px] md:text-[10px]">
                                                    {{-- [RESPONSIF] Padding tabel di HP sangat dirapatkan (px-2 py-2) --}}
                                                    <th class="px-2 md:px-6 py-2 md:py-3 font-semibold">Tanggal</th>
                                                    <th class="px-2 md:px-6 py-2 md:py-3 font-semibold">Kelas</th>
                                                    <th class="px-2 md:px-6 py-2 md:py-3 font-semibold text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                                                @foreach($jadwals as $j)
                                                    <tr class="hover:bg-blue-50/50 dark:hover:bg-gray-700 transition-colors">
                                                        {{-- [RESPONSIF] Ukuran teks tanggal --}}
                                                        <td class="px-2 md:px-6 py-2.5 md:py-4 font-bold text-gray-800 dark:text-gray-300 text-[10px] md:text-sm">
                                                            {{ \Carbon\Carbon::parse($j->start)->translatedFormat('d M Y') }}
                                                        </td>
                                                        {{-- [RESPONSIF] Ukuran teks topik dibuat sangat kecil di HP agar muat --}}
                                                        <td class="px-2 md:px-6 py-2.5 md:py-4 text-gray-600 dark:text-gray-400 italic text-[9px] md:text-xs truncate">
                                                            "{{ $j->title ?? 'Tidak ada topik' }}"
                                                        </td>
                                                        <td class="px-2 md:px-6 py-2.5 md:py-4 text-center">
                                                            @php
                                                                $status = strtolower($j->student_presence);
                                                                $badgeClass = match($status) {
                                                                    'present' => 'bg-green-100 text-green-700 border-green-200 dark:bg-green-900 dark:text-green-300 dark:border-green-800',
                                                                    'permit'  => 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900 dark:text-blue-300 dark:border-blue-800',
                                                                    'sick'    => 'bg-yellow-100 text-yellow-700 border-yellow-200 dark:bg-yellow-900 dark:text-yellow-300 dark:border-yellow-800',
                                                                    'absent', 'alpa' => 'bg-red-100 text-red-700 border-red-200 dark:bg-red-900 dark:text-red-300 dark:border-red-800',
                                                                    default   => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
                                                                };
                                                                $statusLabel = match($status) {
                                                                    'present' => 'Hadir',
                                                                    'permit'  => 'Izin',
                                                                    'sick'    => 'Sakit',
                                                                    default   => 'Alpa',
                                                                };
                                                            @endphp
                                                            {{-- [RESPONSIF] Lencana diperkecil drastis untuk tampilan mobile --}}
                                                            <span class="inline-block px-1.5 md:px-3 py-0.5 md:py-1 rounded-full text-[8px] md:text-[10px] font-bold border {{ $badgeClass }} uppercase tracking-wider">
                                                                {{ $statusLabel }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-student-layout>