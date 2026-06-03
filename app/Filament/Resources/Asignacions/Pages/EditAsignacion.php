<?php

namespace App\Filament\Resources\Asignacions\Pages;

use App\Filament\Resources\Asignacions\AsignacionResource;
use App\Models\Activo;
use App\Models\Asignacion;
use App\Models\EstadoActivo;
use App\Support\Auditoria;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditAsignacion extends EditRecord
{
    protected static string $resource = AsignacionResource::class;

    protected array $antes = [];

    protected function beforeSave(): void
    {
        $this->antes = $this->record->getOriginal();

        $activoId = $this->data['activo_id'] ?? null;
        $fechaRetorno = $this->data['fecha_retorno'] ?? null;
        $recordId = $this->record->id_asignacion ?? null;

        $activo = $activoId ? Activo::find($activoId) : null;

        if (! $activo) {
            return;
        }

        if (empty($fechaRetorno)) {
            if ($activo->estaDadoDeBaja()) {
                Notification::make()
                    ->title('Asignación no permitida')
                    ->body('No se puede dejar vigente una asignación de un activo dado de baja.')
                    ->danger()
                    ->send();

                $this->halt();
            }

            if ($activo->estaEnMantenimiento()) {
                Notification::make()
                    ->title('Asignación no permitida')
                    ->body('No se puede dejar vigente una asignación de un activo en mantenimiento.')
                    ->danger()
                    ->send();

                $this->halt();
            }

            $existeVigente = Asignacion::query()
                ->where('activo_id', $activoId)
                ->whereNull('fecha_retorno')
                ->where('id_asignacion', '!=', $recordId)
                ->exists();

            if ($existeVigente) {
                Notification::make()
                    ->title('Asignación no permitida')
                    ->body('Este activo ya tiene otra asignación vigente. Primero registra la fecha de retorno de la asignación actual.')
                    ->danger()
                    ->send();

                $this->halt();
            }
        }
    }

    protected function afterSave(): void
    {
        $asignacion = $this->record->fresh();
        $activo = $asignacion->activo;

        if (! $activo) {
            return;
        }

        if ($asignacion->fecha_retorno === null) {
            $estadoEnUso = EstadoActivo::query()
                ->where('nombre', 'En uso')
                ->first();

            if ($estadoEnUso) {
                $activo->estado_id = $estadoEnUso->id_estado;
                $activo->updated_at = now();
                $activo->save();
            }
        } else {
            $hayOtraVigente = Asignacion::query()
                ->where('activo_id', $asignacion->activo_id)
                ->whereNull('fecha_retorno')
                ->where('id_asignacion', '!=', $asignacion->id_asignacion)
                ->exists();

            if (! $hayOtraVigente) {
                $estadoDisponible = EstadoActivo::query()
                    ->where('nombre', 'Disponible')
                    ->first();

                if ($estadoDisponible) {
                    $activo->estado_id = $estadoDisponible->id_estado;
                    $activo->updated_at = now();
                    $activo->save();
                }
            }
        }

        Auditoria::registrar(
            'UPDATE',
            'asignaciones',
            $asignacion->id_asignacion,
            $this->antes,
            $asignacion->toArray()
        );
    }
}
