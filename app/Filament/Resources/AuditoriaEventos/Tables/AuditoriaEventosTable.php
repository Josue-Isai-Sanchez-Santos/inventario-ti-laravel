<?php

namespace App\Filament\Resources\AuditoriaEventos\Tables;

use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AuditoriaEventosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('usuario.name')
                    ->label('Usuario')
                    ->placeholder('Sistema')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('accion')
                    ->label('Acción')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'INSERT' => 'success',
                        'UPDATE' => 'warning',
                        'DELETE' => 'danger',
                        'ASSIGN' => 'info',
                        'BAJA' => 'danger',
                        'MANTENIMIENTO' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('tabla')
                    ->label('Tabla')
                    ->badge()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('registro_id')
                    ->label('Registro ID')
                    ->sortable(),

                TextColumn::make('ip')
                    ->label('IP')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('accion')
                    ->label('Acción')
                    ->options([
                        'INSERT' => 'INSERT',
                        'UPDATE' => 'UPDATE',
                        'DELETE' => 'DELETE',
                        'ASSIGN' => 'ASSIGN',
                        'BAJA' => 'BAJA',
                        'MANTENIMIENTO' => 'MANTENIMIENTO',
                    ]),

                SelectFilter::make('tabla')
                    ->label('Tabla')
                    ->options([
                        'activos' => 'Activos',
                        'asignaciones' => 'Asignaciones',
                        'mantenimientos' => 'Mantenimientos',
                        'bajas' => 'Bajas',
                    ]),
            ])
            ->recordActions([
                Action::make('verDetalle')
                    ->label('Ver detalle')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Detalle del evento de auditoría')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Cerrar')
                    ->modalContent(fn ($record) => view(
                        'filament.modals.auditoria-detalle',
                        ['record' => $record]
                    )),
            ])
            ->toolbarActions([]);
    }
}
