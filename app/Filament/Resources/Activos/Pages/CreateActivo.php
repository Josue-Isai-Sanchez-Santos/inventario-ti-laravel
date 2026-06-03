<?php

namespace App\Filament\Resources\Activos\Pages;

use App\Filament\Resources\Activos\ActivoResource;
use App\Support\Auditoria;
use App\Support\QrGenerator;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateActivo extends CreateRecord
{
    protected static string $resource = ActivoResource::class;

    protected function afterCreate(): void
    {
        QrGenerator::generarParaActivo($this->record->qr_token);

        Auditoria::registrar(
            'INSERT',
            'activos',
            $this->record->id_activo,
            null,
            $this->record->toArray()
        );

        Notification::make()
            ->title('Activo creado correctamente')
            ->body('El QR fue generado. Ya puedes descargar el PDF del activo.')
            ->success()
            ->actions([
                Action::make('descargarPdf')
                    ->label('Descargar PDF')
                    ->url(route('activos.pdf', $this->record))
                    ->openUrlInNewTab(),
            ])
            ->send();
    }
}
