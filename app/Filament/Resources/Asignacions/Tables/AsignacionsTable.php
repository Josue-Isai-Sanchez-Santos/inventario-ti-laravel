<?php

namespace App\Filament\Resources\Asignacions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AsignacionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_asignacion')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('activo.codigo_inventario')
                    ->label('Código activo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('activo.nombre')
                    ->label('Activo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('responsable.name')
                    ->label('Responsable')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('ubicacion.nombre')
                    ->label('Ubicación')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('fecha_asignacion')
                    ->label('Fecha asignación')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),

                TextColumn::make('fecha_retorno')
                    ->label('Fecha retorno')
                    ->dateTime('Y-m-d H:i')
                    ->placeholder('Vigente')
                    ->sortable(),

                IconColumn::make('vigente')
                    ->label('Vigente')
                    ->getStateUsing(fn ($record) => $record->fecha_retorno === null)
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('activo_id')
                    ->label('Activo')
                    ->relationship('activo', 'nombre'),

                SelectFilter::make('responsable_id')
                    ->label('Responsable')
                    ->relationship('responsable', 'name'),

                SelectFilter::make('ubicacion_id')
                    ->label('Ubicación')
                    ->relationship('ubicacion', 'nombre'),
            ])
            ->recordActions([
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
