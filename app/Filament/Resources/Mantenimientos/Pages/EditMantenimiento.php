<?php

namespace App\Filament\Resources\Mantenimientos\Pages;

use App\Filament\Resources\Mantenimientos\MantenimientoResource;
use App\Models\Activo;
use App\Models\EstadoActivo;
use App\Support\Auditoria;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditMantenimiento extends EditRecord
{
    protected static string $resource = MantenimientoResource::class;

    protected array $antes = [];

    protected function beforeSave(): void
    {
        $activoId = $this->data['activo_id'] ?? null;
        $this->antes = $this->record->getOriginal();
        $tecnicoId = $this->data['tecnico_id'] ?? null;
        $activo = $activoId ? Activo::find($activoId) : null;

        if ($activo && $activo->estaDadoDeBaja()) {
            Notification::make()
                ->title('Mantenimiento no permitido')
                ->body('No se puede registrar mantenimiento a un activo dado de baja.')
                ->danger()
                ->send();

            $this->halt();
        }

        $tecnicoExterno = $this->data['tecnico_externo'] ?? null;

        if (empty($tecnicoId) && empty($tecnicoExterno)) {
            Notification::make()
                ->title('Mantenimiento no permitido')
                ->body('Debes registrar un técnico interno o un técnico externo.')
                ->danger()
                ->send();

            $this->halt();
        }
    }

    protected function afterSave(): void
    {
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
            'UPDATE',
            'mantenimientos',
            $mantenimiento->id_mantenimiento,
            $this->antes,
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
