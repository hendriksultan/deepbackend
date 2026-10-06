<?php

namespace App\Filament\Resources\EvaluasiIqraResource\Pages;

use App\Filament\Resources\EvaluasiIqraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvaluasiIqra extends EditRecord
{
    protected static string $resource = EvaluasiIqraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
