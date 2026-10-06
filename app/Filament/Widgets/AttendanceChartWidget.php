<?php

namespace App\Filament\Widgets;

use App\Models\Schedule;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class AttendanceChartWidget extends ChartWidget
{
    public function getHeading(): string
    {
        return 'Kehadiran Santri (' . Carbon::now()->year . ')';
    }
    
    protected static ?int $sort = 2; 

    protected static ?string $maxHeight = '280px';

    public ?string $filter = null;

    public function mount(): void
    {
        parent::mount();
        $this->filter = (string) Carbon::now()->month;
    }

    protected function getFilters(): ?array
    {
        return [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
    }

    protected function getData(): array
    {
        $activeMonth = $this->filter;

        $baseQuery = Schedule::query()
            ->whereMonth('start', $activeMonth)
            ->whereYear('start', Carbon::now()->year);

        $hadir = (clone $baseQuery)->whereIn('student_presence', ['Hadir', 'hadir', 'present'])->count();
        $sakit = (clone $baseQuery)->whereIn('student_presence', ['Sakit', 'sick'])->count();
        $izin = (clone $baseQuery)->whereIn('student_presence', ['Izin', 'permit'])->count();
        $tanpa_keterangan = (clone $baseQuery)->whereIn('student_presence', ['Tanpa Keterangan', 'tanpa keterangan', 'alpha', 'absent'])->count();

        return [
            // Memisahkan 4 dataset agar 4 legenda warna-warni muncul di bawah
            'datasets' => [
                [
                    'label' => 'Hadir',
                    'data' => [$hadir, 0, 0, 0], 
                    'backgroundColor' => '#10b981', // Hijau
                ],
                [
                    'label' => 'Izin',
                    'data' => [0, $izin, 0, 0], 
                    'backgroundColor' => '#3b82f6', // Biru
                ],
                [
                    'label' => 'Sakit',
                    'data' => [0, 0, $sakit, 0], 
                    'backgroundColor' => '#f59e0b', // Kuning
                ],
                [
                    'label' => 'Tanpa Keterangan',
                    'data' => [0, 0, 0, $tanpa_keterangan], 
                    'backgroundColor' => '#ef4444', // Merah
                ],
            ],
            'labels' => ['Hadir', 'Izin', 'Sakit', 'Tanpa Keterangan'],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; 
    }

    // =========================================================
    // KODE AJAIB AGAR BATANG TETAP LEBAR & LEGENDA MUNCUL
    // =========================================================
    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'stacked' => true, // Menggabungkan ruang kolom agar batang tetap gemuk/lebar
                ],
                'y' => [
                    'stacked' => true, // Wajib diaktifkan bersamaan dengan X
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,      // Tampilkan legenda
                    'position' => 'bottom', // Posisikan di bawah
                ],
            ],
        ];
    }
}