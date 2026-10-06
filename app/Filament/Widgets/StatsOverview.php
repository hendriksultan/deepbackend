<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\TeacherProfile;
use App\Models\Infaq;
use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    // [PERBAIKAN] Kembalikan ke tipe 'int' dan return 4
    // Ini akan membuat: 
    // - Mobile: 1 Kolom (Default Filament agar rapi)
    // - Tablet: 2 Kolom
    // - Desktop: 4 Kolom (Sejajar satu baris)
    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Santri', User::where('role', 'student')->count())
                ->description('Total Santri')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Guru', TeacherProfile::count())
                ->description('Total Guru')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('primary'),

            // PERBAIKAN DI SINI: Ubah 'paid' menjadi 'verified'
            Stat::make('Infaq', 'Rp ' . number_format(Infaq::where('status', 'verified')->sum('nominal'), 0, ',', '.'))
                ->description('Total Masuk')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Daftar', Booking::where('status', 'pending')->count())
                ->description('Pending')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
