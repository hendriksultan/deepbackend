<?php

namespace App\Filament\Widgets;

use App\Models\Infaq;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class InfaqMonthlyChart extends ChartWidget
{
    // Sekalian kita buat judulnya dinamis mengikuti tahun berjalan ya!
    public function getHeading(): string
    {
        return 'Pemasukan Infaq Bulanan (' . Carbon::now()->year . ')';
    }

    protected static ?int $sort = 2; // Urutan tampilan di dashboard
    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        // Logika mengambil data infaq per bulan di tahun ini
        $data = Infaq::selectRaw('MONTH(created_at) as month, SUM(nominal) as total')
            ->whereYear('created_at', date('Y'))
            ->where('status', 'verified')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Siapkan array kosong untuk 12 bulan
        $monthlyCounts = array_fill(1, 12, 0);

        // Isi data dari database
        foreach ($data as $row) {
            $monthlyCounts[$row->month] = $row->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Infaq (Rp)',
                    'data' => array_values($monthlyCounts),
                    
                    // Warna garis utama (Hijau tegas)
                    'borderColor' => '#10b981', 
                    
                    // Warna area bawah garis (Hijau dengan transparansi 20% / 0.2)
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)', 
                    
                    // [KUNCI RAHASIA] Mengaktifkan warna di bawah garis
                    'fill' => true, 
                    
                    // [KUNCI RAHASIA] Membuat garis melengkung (smooth), bukan lurus kaku
                    'tension' => 0.4, 
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        ];
    }

    protected function getType(): string
    {
        // [PERUBAHAN UTAMA] Ubah dari 'bar' menjadi 'line'
        return 'line'; 
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    // Memastikan grafik selalu dimulai dari dasar (0)
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}