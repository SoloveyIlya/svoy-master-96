<?php

namespace App\Filament\Resources\DeviceCaseResource\Pages;

use App\Filament\Resources\DeviceCaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeviceCases extends ListRecords
{
    protected static string $resource = DeviceCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
