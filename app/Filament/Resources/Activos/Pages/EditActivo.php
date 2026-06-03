<?php

namespace App\Filament\Resources\Activos\Pages;

use App\Filament\Resources\Activos\ActivoResource;
use App\Support\Auditoria;
use Filament\Resources\Pages\EditRecord;

class EditActivo extends EditRecord
{
    protected static string $resource = ActivoResource::class;

    protected array $antes = [];

    protected function beforeSave(): void
    {
        $this->antes = $this->record->getOriginal();
    }

    protected function afterSave(): void
    {
        $activo = $this->record->fresh();

        Auditoria::registrar(
            'UPDATE',
            'activos',
            $this->record->id_activo,
            $this->antes,
            $this->record->fresh()->toArray()
        );
    }
}
