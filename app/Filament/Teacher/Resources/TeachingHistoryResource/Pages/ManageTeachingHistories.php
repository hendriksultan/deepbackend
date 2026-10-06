<?php

namespace App\Filament\Teacher\Resources\TeachingHistoryResource\Pages;

use App\Filament\Teacher\Resources\TeachingHistoryResource;
use Filament\Resources\Pages\ManageRecords;

class ManageTeachingHistories extends ManageRecords
{
    protected static string $resource = TeachingHistoryResource::class;
    
    // Hilangkan tombol "New" di pojok kanan atas
    protected function getHeaderActions(): array
    {
        return [];
    }
}