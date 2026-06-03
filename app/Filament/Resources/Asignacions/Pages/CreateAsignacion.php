<?php

namespace App\Filament\Resources\Asignacions\Pages;

use App\Filament\Resources\Asignacions\AsignacionResource;
use App\Models\Activo;
use App\Models\Asignacion;
use App\Models\EstadoActivo;
use App\Support\Auditoria;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateAsignacion extends CreateRecord
{
    protected static string $resource = AsignacionResource::class;

    protected function beforeCreate(): void
    {
        $activoId = $this->data['activo_id'] ?? null;
        $fechaRetorno = $this->data['fecha_retorno'] ?? null;

        $activo = $activoId ? Activo::find($activoId) : null;

        if (! $activo) {
            return;
        }

        if (empty($fechaRetorno)) {
            if ($activo->estaDadoDeBaja()) {
                Notification::make()
                    ->title('Asignación no permitida')
                    ->body('No se puede asignar un activo dado de baja.')
                    ->danger()
                    ->send();

                $this->halt();
            }

            if ($activo->estaEnMantenimiento()) {
                Notification::make()
                    ->title('Asignación no permitida')
                    ->body('No se puede asignar un activo que se encuentra en mantenimiento.')
                    ->danger()
                    ->send();

                $this->halt();
            }

            $existeVigente = Asignacion::query()
                ->where('activo_id', $activoId)
                ->whereNull('fecha_retorno')
                ->exists();

            if ($existeVigente) {
                Notification::make()
                    ->title('Asignación no permitida')
                    ->body('Este activo ya tiene una asignación vigente. Primero registra la fecha de retorno de la asignación actual.')
                    ->danger()
                    ->send();

                $this->halt();
            }
        }
    }

    protected function afterCreate(): void
    {
        $activo = $this->record->activo;

        if ($activo && $this->record->fecha_retorno === null) {
            $estado = EstadoActivo::query()
                ->where('nombre', 'En uso')
                ->first();

            if ($estado) {
                $activo->estado_id = $estado->id_estado;
                $activo->updated_at = now();
                $activo->save();
            }
        }

        Auditoria::registrar(
            'ASSIGN',
            'asignaciones',
            $this->record->id_asignacion,
            null,
            $this->record->toArray()
        );
    }
}
