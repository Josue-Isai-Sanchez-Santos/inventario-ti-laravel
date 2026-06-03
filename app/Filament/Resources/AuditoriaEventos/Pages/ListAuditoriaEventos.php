<?php

namespace App\Filament\Resources\AuditoriaEventos\Pages;

use App\Filament\Resources\AuditoriaEventos\AuditoriaEventoResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListAuditoriaEventos extends ListRecords
{
    protected static string $resource = AuditoriaEventoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportPdf')
                ->label('Descargar PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->url(route('auditoria.pdf'))
                ->openUrlInNewTab(),
        ];
    }
}
