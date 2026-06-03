<?php

namespace App\Filament\Resources\Mantenimientos\Tables;

use App\Models\EstadoActivo;
use App\Support\Auditoria;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MantenimientosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_mantenimiento')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('estado_mantenimiento')
                    ->label('Estado')
                    ->badge()
                    ->getStateUsing(fn ($record) => $record->fecha_finalizacion ? 'Finalizado' : 'En proceso')
                    ->color(fn (string $state): string => match ($state) {
                        'Finalizado' => 'success',
                        'En proceso' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('fecha_finalizacion')
                    ->label('Finalización')
                    ->dateTime('Y-m-d H:i')
                    ->placeholder('En proceso')
                    ->sortable(),

                TextColumn::make('activo.codigo_inventario')
                    ->label('Código activo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('activo.nombre')
                    ->label('Activo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->sortable(),

                TextColumn::make('tecnico.name')
                    ->label('Técnico interno')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('tecnico_externo')
                    ->label('Técnico externo')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('proveedor')
                    ->label('Proveedor')
                    ->toggleable(),

                TextColumn::make('fecha')
                    ->label('Fecha')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),

                TextColumn::make('costo')
                    ->label('Costo')
                    ->money('MXN')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('tipo')
                    ->label('Tipo')
                    ->options([
                        'Preventivo' => 'Preventivo',
                        'Correctivo' => 'Correctivo',
                    ]),

                SelectFilter::make('activo_id')
                    ->label('Activo')
                    ->relationship('activo', 'nombre'),
            ])
            ->recordActions([
                Action::make('finalizar')
                    ->label('Finalizar')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn ($record) => $record->fecha_finalizacion === null)
                    ->requiresConfirmation()
                    ->modalHeading('Finalizar mantenimiento')
                    ->modalDescription('Al finalizar el mantenimiento, el activo regresará a Disponible o En uso según tenga asignación vigente.')
                    ->action(function ($record) {
                        $record->fecha_finalizacion = now();
                        $record->save();

                        $activo = $record->activo;

                        if ($activo) {
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

                        Auditoria::registrar(
                            'UPDATE',
                            'mantenimientos',
                            $record->id_mantenimiento,
                            null,
                            $record->fresh()->toArray()
                        );

                        Notification::make()
                            ->title('Mantenimiento finalizado')
                            ->body('El estado del activo fue actualizado correctamente.')
                            ->success()
                            ->send();
                    }),

                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
