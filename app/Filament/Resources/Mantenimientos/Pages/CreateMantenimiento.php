<?php

namespace App\Filament\Resources\Mantenimientos\Pages;

use App\Filament\Resources\Mantenimientos\MantenimientoResource;
use App\Models\Activo;
use App\Models\EstadoActivo;
use App\Support\Auditoria;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateMantenimiento extends CreateRecord
{
    protected static string $resource = MantenimientoResource::class;

    protected function beforeCreate(): void
    {
        $activoId = $this->data['activo_id'] ?? null;
        $tecnicoId = $this->data['tecnico_id'] ?? null;
        $tecnicoExterno = $this->data['tecnico_externo'] ?? null;
        $activo = $activoId ? Activo::find($activoId) : null;

        if ($activo && $activo->estaDadoDeBaja()) {
            Notification::make()
                ->title('Mantenimiento no permitido')
                ->body('No se puede registrar mantenimiento a un activo dado de baja.')
                ->danger()
                ->send();

            $this->halt();
        }
        if (empty($tecnicoId) && empty($tecnicoExterno)) {
            Notification::make()
                ->title('Mantenimiento no permitido')
                ->body('Debes registrar un técnico interno o un técnico externo.')
                ->danger()
                ->send();

            $this->halt();
        }
    }

    protected function afterCreate(): void
    {
        $activo = $this->record->activo;
        $mantenimiento = $this->record->fresh();
        $activo = $mantenimiento->activo;

        if ($activo) {
            if ($mantenimiento->fecha_finalizacion === null) {
                $estado = EstadoActivo::query()
                    ->where('nombre', 'En mantenimiento')
                    ->first();

                if ($estado) {
                    $activo->estado_id = $estado->id_estado;
                    $activo->updated_at = now();
                    $activo->save();
                }
            } else {
                $this->restaurarEstadoActivo($activo);
            }
        }

        Auditoria::registrar(
            'MANTENIMIENTO',
            'mantenimientos',
            $mantenimiento->id_mantenimiento,
            null,
            $mantenimiento->toArray()
        );
    }

    protected function restaurarEstadoActivo($activo): void
    {
        $nombreEstado = $activo->tieneAsignacionVigente() ? 'En uso' : 'Disponible';

        $estado = EstadoActivo::query()
            ->where('nombre', $nombreEstado)
            ->first();

        if ($estado) {
            $activo->estado_id = $estado->id_estado;
            $activo->updated_at = now();
            $activo->save();
        }
    }
}
