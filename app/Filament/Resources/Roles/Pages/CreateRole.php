<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use App\Support\Auditoria;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected function afterCreate(): void
    {
        $role = $this->record->fresh();

        Auditoria::registrar(
            'INSERT',
            'roles',
            $role->id_rol,
            null,
            $role->load('permissions')->toArray()
        );
    }
}
