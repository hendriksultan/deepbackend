<?php

namespace App\Filament\Teacher\Resources\GuruMutabaahResource\Pages;

use App\Filament\Teacher\Resources\GuruMutabaahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGuruMutabaahs extends ListRecords
{
    protected static string $resource = GuruMutabaahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
