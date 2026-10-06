<?php

namespace App\Filament\Teacher\Resources\MutabaahTahsinResource\Pages;

use App\Filament\Teacher\Resources\MutabaahTahsinResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMutabaahTahsins extends ListRecords
{
    protected static string $resource = MutabaahTahsinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
