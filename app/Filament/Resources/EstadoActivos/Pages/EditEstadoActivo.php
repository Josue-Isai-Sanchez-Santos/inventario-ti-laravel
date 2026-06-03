<?php

namespace App\Filament\Resources\EstadoActivos\Pages;

use App\Filament\Resources\EstadoActivos\EstadoActivoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEstadoActivo extends EditRecord
{
    protected static string $resource = EstadoActivoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
