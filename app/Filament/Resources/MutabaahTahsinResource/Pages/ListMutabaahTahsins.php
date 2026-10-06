<?php

namespace App\Filament\Resources\MutabaahTahsinResource\Pages;

use App\Filament\Resources\MutabaahTahsinResource;
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
