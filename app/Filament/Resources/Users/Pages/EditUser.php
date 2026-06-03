<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Support\Auditoria;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected array $antes = [];

    protected function beforeSave(): void
    {
        $this->antes = $this->record->getOriginal();
    }

    protected function afterSave(): void
    {
        $user = $this->record->fresh();

        Auditoria::registrar(
            'UPDATE',
            'users',
            $user->id,
            $this->antes,
            $user->makeHidden(['password', 'remember_token'])->toArray()
        );
    }
}
