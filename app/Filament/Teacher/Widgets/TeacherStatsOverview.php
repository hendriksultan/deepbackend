<?php

namespace App\Filament\Teacher\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\HtmlString;

// Pastikan import Model yang benar
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\TeacherAttendance; 

class TeacherStatsOverview extends BaseWidget
{
    // Agar widget ini muncul di paling atas
    protected static ?int $sort = 1;

    // Tetapkan 3 kolom untuk layar Desktop (PC/Laptop) agar menjadi 2 baris simetris
    protected function getColumns(): int
    {
        return 3; 
    }

    protected function getStats(): array
    {
        // 1. Ambil Data Guru yang sedang Login
        $user = Auth::user();
        $teacher = $user->teacherProfile;

        // Jaga-jaga jika akun baru dan belum bikin profil guru
        if (!$teacher) {
            return [
                Stat::make('Status Akun', 'Belum Lengkap')
                    ->description('Harap lengkapi data profil guru')
                    ->color('danger')
                    ->columnSpan('full'), 
            ];
        }

        // Variabel untuk filter bulan dan tahun berjalan
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // =========================================================
        // DATA STATISTIK
        // =========================================================
        
        // 1. Total Santri (Keseluruhan yang masih aktif)
        $totalSantri = Booking::where('teacher_profile_id', $teacher->id)
            ->where('status', 'active') 
            ->count();

        // 2. Total Jadwal Kelas BULAN INI
        $totalKelasBulanIni = Schedule::where('teacher_profile_id', $teacher->id)
            ->whereMonth('start', $bulanIni)
            ->whereYear('start', $tahunIni)
            ->select('title', 'start', 'end')
            ->groupBy('title', 'start', 'end')
            ->get()
            ->count();

        // 3. Jadwal HARI INI yang belum selesai
        $jadwalHariIni = Schedule::where('teacher_profile_id', $teacher->id)
            ->whereDate('start', Carbon::today()) 
            ->where('status', '!=', 'completed')  
            ->select('title', 'start', 'end')     
            ->groupBy('title', 'start', 'end')    
            ->get()                               
            ->count();                            

        // 4. Menunggu Laporan (SEMUA WAKTU - agar tunggakan absen bulan lalu tidak hilang)
        $menungguLaporan = Schedule::where('teacher_profile_id', $teacher->id)
            ->where('status', '!=', 'completed')
            ->where('end', '<', Carbon::now()) 
            ->count();

        // 5. Kelas Selesai BULAN INI (Ditambahkan filter bulan & tahun)
        $kelasSelesai = Schedule::where('teacher_profile_id', $teacher->id)
            ->whereMonth('start', $bulanIni)
            ->whereYear('start', $tahunIni)
            ->where('status', 'completed')        
            ->select('title', 'start', 'end')
            ->groupBy('title', 'start', 'end')    
            ->get()
            ->count();

        // =========================================================
        // 6. Kehadiran Guru BULAN INI (Ditambahkan filter bulan & tahun)
        // =========================================================
        $totalAbsensi = TeacherAttendance::where('teacher_profile_id', $teacher->id)
            ->whereMonth('date', $bulanIni)
            ->whereYear('date', $tahunIni)
            ->count();
            
        $totalHadir = TeacherAttendance::where('teacher_profile_id', $teacher->id)
            ->whereMonth('date', $bulanIni)
            ->whereYear('date', $tahunIni)
            ->where('status', 'present')
            ->whereNotNull('clock_out') // Syarat tambahan: Harus ada waktu pulang
            ->count();

        if ($totalAbsensi > 0) {
            $persentase = round(($totalHadir / $totalAbsensi) * 100);
        } else {
            $persentase = 100;
        }

        $performaColor = match (true) {
            $persentase >= 80 => 'success',  
            $persentase >= 50 => 'warning',  
            default => 'danger',             
        };

        // =========================================================
        // INJEKSI CSS DIPERBAIKI: RAPI DAN SIMETRIS DI MOBILE
        // =========================================================
        $titleTotalSantri = new HtmlString('
            <style>
                @media (max-width: 768px) {
                    /* Menyasar Grid Pembungkus Stat (Aman & Tidak Menciutkan Lebar) */
                    .fi-wi-stats-overview-stats-ctn,
                    .fi-wi-stats-overview > div > .grid {
                        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                        gap: 12px !important; 
                    }
                    
                    /* Sedikit mengurangi padding dalam kartu agar terasa lega */
                    .fi-wi-stats-overview-stat {
                        padding: 12px 14px !important;
                    }

                    /* Mengecilkan Teks Judul tanpa merusak strukturnya */
                    .fi-wi-stats-overview-stat-label {
                        font-size: 0.75rem !important;
                        line-height: 1.2 !important;
                    }

                    /* Mengecilkan Angka Utama */
                    .fi-wi-stats-overview-stat-value {
                        font-size: 1.5rem !important;
                    }

                    /* Mengecilkan Deskripsi di bawah angka */
                    .fi-wi-stats-overview-stat-description {
                        font-size: 0.65rem !important;
                    }
                    
                    /* Mengecilkan ikon di sebelah deskripsi */
                    .fi-wi-stats-overview-stat-description svg {
                        width: 14px !important;
                        height: 14px !important;
                    }
                }
            </style>
            Total Santri
        ');

        return [
            // BARIS 1 (Desktop) / KOTAK 1 & 2 (Mobile)
            Stat::make($titleTotalSantri, $totalSantri)
                ->description('Santri aktif Anda')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Total Jadwal', $totalKelasBulanIni)
                ->description(Carbon::now()->translatedFormat('M Y')) 
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'), 

            Stat::make('Jadwal Hari Ini', $jadwalHariIni)
                ->description('Belum Selesai')
                ->descriptionIcon('heroicon-m-clock')
                ->color($jadwalHariIni > 0 ? 'warning' : 'gray'),

            // BARIS 2 (Desktop) / KOTAK 4, 5, 6 (Mobile)
            Stat::make('Menunggu', $menungguLaporan)
                ->description('Peserta Belum absen')
                ->descriptionIcon($menungguLaporan > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($menungguLaporan > 0 ? 'danger' : 'success'), 

            Stat::make('Kelas Selesai', $kelasSelesai)
                ->description('Sesi Bulan Ini') // Label disesuaikan
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('primary'),

            Stat::make('Kehadiran', $persentase . '%')
                ->description("Bulan Ini: $totalHadir dari $totalAbsensi") // Label disesuaikan
                ->descriptionIcon($persentase >= 80 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($performaColor), 
        ];
    }
}