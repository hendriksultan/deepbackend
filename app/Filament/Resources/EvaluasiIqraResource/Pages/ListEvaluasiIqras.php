<?php

namespace App\Filament\Resources\EvaluasiIqraResource\Pages;

use App\Filament\Resources\EvaluasiIqraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvaluasiIqras extends ListRecords
{
    protected static string $resource = EvaluasiIqraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
