<?php

namespace App\Filament\Teacher\Resources\GuruEvaluasiIqraResource\Pages;

use App\Filament\Teacher\Resources\GuruEvaluasiIqraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuruEvaluasiIqra extends EditRecord
{
    protected static string $resource = GuruEvaluasiIqraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
