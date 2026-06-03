<?php

namespace App\Filament\Resources\Ubicacions\Pages;

use App\Filament\Resources\Ubicacions\UbicacionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUbicacion extends EditRecord
{
    protected static string $resource = UbicacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
