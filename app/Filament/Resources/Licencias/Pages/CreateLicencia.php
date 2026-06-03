<?php

namespace App\Filament\Resources\Licencias\Pages;

use App\Filament\Resources\Licencias\LicenciaResource;
use App\Support\Auditoria;
use Filament\Resources\Pages\CreateRecord;

class CreateLicencia extends CreateRecord
{
    protected static string $resource = LicenciaResource::class;

    protected function afterCreate(): void
    {
        Auditoria::registrar(
            'INSERT',
            'licencias',
            $this->record->id_licencia,
            null,
            $this->record->toArray()
        );
    }
}
