<?php

namespace App\Filament\Resources\MutabaahResource\Pages;

use App\Filament\Resources\MutabaahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMutabaahs extends ListRecords
{
  protected static string $resource = MutabaahResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
