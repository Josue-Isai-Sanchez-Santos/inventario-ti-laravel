<?php

namespace App\Filament\Resources\Licencias\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LicenciasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_licencia')
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

                TextColumn::make('tipo')
                    ->label('Tipo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('proveedor')
                    ->label('Proveedor')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Sin proveedor'),

                TextColumn::make('estado.nombre')
                    ->label('Estado')
                    ->badge()
                    ->sortable(),

                TextColumn::make('fecha_inicio')
                    ->label('Inicio')
                    ->date('Y-m-d')
                    ->sortable(),

                TextColumn::make('fecha_fin')
                    ->label('Vencimiento')
                    ->date('Y-m-d')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('activo_id')
                    ->label('Activo')
                    ->relationship('activo', 'nombre'),

                SelectFilter::make('estado_lic_id')
                    ->label('Estado')
                    ->relationship('estado', 'nombre'),
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
