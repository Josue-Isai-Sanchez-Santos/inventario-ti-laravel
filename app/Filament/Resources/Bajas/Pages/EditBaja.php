<?php

namespace App\Filament\Resources\Bajas\Pages;

use App\Filament\Resources\Bajas\BajaResource;
use App\Support\Auditoria;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditBaja extends EditRecord
{
    protected static string $resource = BajaResource::class;

    protected array $antes = [];

    protected function beforeSave(): void
    {
        $this->antes = $this->record->getOriginal();

        $originalActivoId = $this->record->getOriginal('activo_id');
        $originalFecha = $this->record->getOriginal('fecha');
        $originalAutorizadoPor = $this->record->getOriginal('autorizado_por_id');

        $nuevoActivoId = $this->data['activo_id'] ?? $originalActivoId;
        $nuevaFecha = $this->data['fecha'] ?? $originalFecha;
        $nuevoAutorizadoPor = $this->data['autorizado_por_id'] ?? $originalAutorizadoPor;

        if ((int) $nuevoActivoId !== (int) $originalActivoId) {
            Notification::make()
                ->title('Edición no permitida')
                ->body('No se puede cambiar el activo asociado a una baja ya registrada.')
                ->danger()
                ->send();

            $this->halt();
        }

        if ((string) $nuevaFecha !== (string) $originalFecha) {
            Notification::make()
                ->title('Edición no permitida')
                ->body('No se puede cambiar la fecha de una baja ya registrada.')
                ->danger()
                ->send();

            $this->halt();
        }

        if ((int) $nuevoAutorizadoPor !== (int) $originalAutorizadoPor) {
            Notification::make()
                ->title('Edición no permitida')
                ->body('No se puede cambiar el usuario que autorizó la baja.')
                ->danger()
                ->send();

            $this->halt();
        }
    }

    protected function afterSave(): void
    {
        $baja = $this->record->fresh();

        Auditoria::registrar(
            'UPDATE',
            'bajas',
            $baja->id_baja,
            $this->antes,
            $baja->toArray()
        );
    }
}
