<?php

namespace App\Filament\Teacher\Resources\GuruMutabaahResource\Pages;

use App\Filament\Teacher\Resources\GuruMutabaahResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuruMutabaah extends EditRecord
{
    protected static string $resource = GuruMutabaahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
