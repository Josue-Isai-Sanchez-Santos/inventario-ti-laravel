<?php

namespace App\Filament\Resources\Licencias\Pages;

use App\Filament\Resources\Licencias\LicenciaResource;
use App\Support\Auditoria;
use Filament\Resources\Pages\EditRecord;

class EditLicencia extends EditRecord
{
    protected static string $resource = LicenciaResource::class;

    protected array $oldData = [];

    protected function beforeSave(): void
    {
        $this->oldData = $this->record->getOriginal();
    }

    protected function afterSave(): void
    {
        Auditoria::registrar(
            'UPDATE',
            'licencias',
            $this->record->id_licencia,
            $this->oldData,
            $this->record->toArray()
        );
    }
}
