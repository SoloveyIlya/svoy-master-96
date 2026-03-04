<?php

namespace App\Filament\Resources\ServiceScopeResource\Pages;

use App\Filament\Resources\ServiceScopeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceScopes extends ListRecords
{
    protected static string $resource = ServiceScopeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
