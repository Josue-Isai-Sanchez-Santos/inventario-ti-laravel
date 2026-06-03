<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use App\Support\Auditoria;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected array $antes = [];

    protected function beforeSave(): void
    {
        $this->antes = $this->record->getOriginal();
    }

    protected function afterSave(): void
    {
        $role = $this->record->fresh();

        Auditoria::registrar(
            'UPDATE',
            'roles',
            $role->id_rol,
            $this->antes,
            $role->load('permissions')->toArray()
        );
    }
}
