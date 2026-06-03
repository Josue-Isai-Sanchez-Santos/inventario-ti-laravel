<?php

namespace App\Filament\Resources\AuditoriaEventos\Pages;

use App\Filament\Resources\AuditoriaEventos\AuditoriaEventoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAuditoriaEvento extends EditRecord
{
    protected static string $resource = AuditoriaEventoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
