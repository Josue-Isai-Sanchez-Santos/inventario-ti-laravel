<?php

namespace App\Filament\Resources\EstadoLicencias\Pages;

use App\Filament\Resources\EstadoLicencias\EstadoLicenciaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEstadoLicencias extends ListRecords
{
    protected static string $resource = EstadoLicenciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
