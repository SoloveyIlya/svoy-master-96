<?php

namespace App\Filament\Resources\DeviceCaseResource\Pages;

use App\Filament\Resources\DeviceCaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeviceCase extends EditRecord
{
    protected static string $resource = DeviceCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
