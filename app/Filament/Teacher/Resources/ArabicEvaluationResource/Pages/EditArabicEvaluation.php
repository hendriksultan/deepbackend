<?php

namespace App\Filament\Teacher\Resources\ArabicEvaluationResource\Pages;

use App\Filament\Teacher\Resources\ArabicEvaluationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArabicEvaluation extends EditRecord
{
    protected static string $resource = ArabicEvaluationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
