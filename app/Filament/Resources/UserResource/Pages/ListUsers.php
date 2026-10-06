<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // =========================================================
    // FITUR TABS: Memisahkan tabel berdasarkan Role agar tidak menumpuk
    // =========================================================
    public function getTabs(): array
    {
        return [
            'semua' => Tab::make('Semua User'),
            
            'admin' => Tab::make('Admin')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'admin'))
                ->badgeColor('danger'),
                
            'teacher' => Tab::make('Guru')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'teacher'))
                ->badgeColor('success'),
                
            'student' => Tab::make('Santri')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'student'))
                ->badgeColor('info'),
                
            'belum_verifikasi' => Tab::make('Belum Verifikasi')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('role', ['student', 'teacher'])->where('is_verified', false))
                ->badgeColor('warning'),
        ];
    }
}