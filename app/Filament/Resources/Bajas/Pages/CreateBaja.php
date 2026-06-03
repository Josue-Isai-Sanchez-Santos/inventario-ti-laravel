<?php

namespace App\Filament\Resources\Bajas\Pages;

use App\Filament\Resources\Bajas\BajaResource;
use App\Models\Activo;
use App\Models\Baja;
use App\Models\EstadoActivo;
use App\Support\Auditoria;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateBaja extends CreateRecord
{
    protected static string $resource = BajaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['autorizado_por_id'] = auth()->id();

        return $data;
    }

    protected function beforeCreate(): void
    {
        $activoId = $this->data['activo_id'] ?? null;
        $activo = $activoId ? Activo::find($activoId) : null;

        if (! $activo) {
            return;
        }

        if ($activo->estaDadoDeBaja()) {
            Notification::make()
                ->title('Baja no permitida')
                ->body('Este activo ya se encuentra dado de baja.')
                ->danger()
                ->send();

            $this->halt();
        }

        if ($activo->tieneAsignacionVigente()) {
            Notification::make()
                ->title('Baja no permitida')
                ->body('No se puede dar de baja este activo porque tiene una asignación vigente. Primero cierre la asignación registrando la fecha de retorno.')
                ->danger()
                ->send();

            $this->halt();
        }

        $yaExiste = Baja::query()
            ->where('activo_id', $activoId)
            ->exists();

        if ($yaExiste) {
            Notification::make()
                ->title('Baja no permitida')
                ->body('Este activo ya cuenta con una baja registrada.')
                ->danger()
                ->send();

            $this->halt();
        }
    }

    protected function afterCreate(): void
    {
        $baja = $this->record->fresh();
        $activo = $baja->activo;

        if ($activo) {
            $estado = EstadoActivo::query()
                ->where('nombre', 'Dado de baja')
                ->orWhere('nombre', 'Baja')
                ->first();

            if ($estado) {
                $activo->estado_id = $estado->id_estado;
                $activo->updated_at = now();
                $activo->save();
            }
        }

        Auditoria::registrar(
            'BAJA',
            'bajas',
            $baja->id_baja,
            null,
            $baja->toArray()
        );
    }
}
