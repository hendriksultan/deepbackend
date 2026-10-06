<?php

namespace App\Filament\Resources\TeacherProfileResource\Pages;

use App\Filament\Resources\TeacherProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTeacherProfile extends ViewRecord
{
    protected static string $resource = TeacherProfileResource::class;

    // 1. Mengubah Judul Halaman
    public function getTitle(): string
    {
        return 'Detail Profil Guru';
    }

    // 2. MEMPERLEBAR UKURAN HALAMAN (Ini kunci agar tampilan bisa Landscape)
    public function getMaxContentWidth(): ?string
    {
        return 'full'; // Menggunakan lebar penuh layar
    }

    // 3. Tombol Aksi
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit Data Guru')
                ->icon('heroicon-o-pencil-square'),
                
            Actions\DeleteAction::make()
                ->label('Hapus Guru')
                ->icon('heroicon-o-trash')
                ->color('danger'),
        ];
    }
}