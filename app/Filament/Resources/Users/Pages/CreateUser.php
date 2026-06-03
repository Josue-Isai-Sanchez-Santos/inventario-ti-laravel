<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Support\Auditoria;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        $user = $this->record->fresh();

        Auditoria::registrar(
            'INSERT',
            'users',
            $user->id,
            null,
            $user->makeHidden(['password', 'remember_token'])->toArray()
        );
    }
}
