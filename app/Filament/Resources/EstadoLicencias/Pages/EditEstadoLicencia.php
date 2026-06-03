<?php

namespace App\Filament\Resources\EstadoLicencias\Pages;

use App\Filament\Resources\EstadoLicencias\EstadoLicenciaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEstadoLicencia extends EditRecord
{
    protected static string $resource = EstadoLicenciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
