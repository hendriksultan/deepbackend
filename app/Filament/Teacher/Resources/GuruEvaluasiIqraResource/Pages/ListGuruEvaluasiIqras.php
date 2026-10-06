<?php

namespace App\Filament\Teacher\Resources\GuruEvaluasiIqraResource\Pages;

use App\Filament\Teacher\Resources\GuruEvaluasiIqraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGuruEvaluasiIqras extends ListRecords
{
    protected static string $resource = GuruEvaluasiIqraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
