<?php

namespace App\Filament\Resources\ServiceScopeResource\Pages;

use App\Filament\Resources\ServiceScopeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceScope extends EditRecord
{
    protected static string $resource = ServiceScopeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
