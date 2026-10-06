<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
use App\Filament\Resources\ScheduleResource\Widgets\TeacherScheduleWidget; // Import Widget tadi
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class ListSchedules extends ListRecords
{
    protected static string $resource = ScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Jadwal Manual'),
        ];
    }

    // FUNGSI UNTUK MENAMPILKAN WIDGET DI ATAS TABEL
    protected function getHeaderWidgets(): array
    {
        return [
            TeacherScheduleWidget::class,
        ];
    }

    // =========================================================
    // FITUR TABS: Memisahkan tabel Jadwal agar tidak menumpuk
    // =========================================================
    public function getTabs(): array
    {
        return [
            'semua' => Tab::make('Semua Jadwal'),
            
            'hari_ini' => Tab::make('Kelas Hari Ini')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('start', Carbon::today()))
                ->badgeColor('success'),
                
            'akan_datang' => Tab::make('Akan Datang')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('start', '>', Carbon::today())->where('status', 'pending'))
                ->badgeColor('info'),
                
            'selesai' => Tab::make('Selesai / Riwayat')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'completed')->orWhereDate('start', '<', Carbon::today()))
                ->badgeColor('gray'),
        ];
    }
}