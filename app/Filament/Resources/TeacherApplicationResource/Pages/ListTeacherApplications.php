<?php

namespace App\Filament\Resources\TeacherApplicationResource\Pages;

use App\Filament\Resources\TeacherApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeacherApplications extends ListRecords
{
    protected static string $resource = TeacherApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
