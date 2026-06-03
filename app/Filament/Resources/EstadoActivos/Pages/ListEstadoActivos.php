<?php

namespace App\Filament\Resources\EstadoActivos\Pages;

use App\Filament\Resources\EstadoActivos\EstadoActivoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEstadoActivos extends ListRecords
{
    protected static string $resource = EstadoActivoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
