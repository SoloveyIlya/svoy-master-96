<?php

namespace App\Filament\Resources\ImportRunResource\Pages;

use App\Filament\Resources\ImportRunResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewImportRun extends ViewRecord
{
    protected static string $resource = ImportRunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
