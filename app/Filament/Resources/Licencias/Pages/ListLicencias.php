<?php

namespace App\Filament\Resources\Licencias\Pages;

use App\Filament\Resources\Licencias\LicenciaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLicencias extends ListRecords
{
    protected static string $resource = LicenciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
