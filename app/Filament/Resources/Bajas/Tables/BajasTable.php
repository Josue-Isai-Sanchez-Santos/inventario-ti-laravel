<?php

namespace App\Filament\Resources\Bajas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BajasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_baja')
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

                TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date('Y-m-d')
                    ->sortable(),

                TextColumn::make('motivo')
                    ->label('Motivo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('autorizadoPor.name')
                    ->label('Autorizado por')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Registrado')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('autorizado_por_id')
                    ->label('Autorizado por')
                    ->relationship('autorizadoPor', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->visible(fn () => auth()->user()?->hasRole('Administrador') ?? false)
                    ->before(function ($record, $action) {
                        if (! (auth()->user()?->hasRole('Administrador') ?? false)) {
                            Notification::make()
                                ->title('Eliminación no permitida')
                                ->body('Solo un administrador puede eliminar registros de baja.')
                                ->danger()
                                ->send();

                            $action->cancel();
                        }
                    }),
            ])
            ->toolbarActions([
                                BulkActionGroup::make([
                                    DeleteBulkAction::make()
                                        ->visible(fn () => auth()->user()?->hasRole('Administrador') ?? false)
                                        ->before(function ($records, $action) {
                                            if (! (auth()->user()?->hasRole('Administrador') ?? false)) {
                                                Notification::make()
                                                    ->title('Eliminación masiva no permitida')
                                                    ->body('Solo un administrador puede eliminar registros de baja.')
                                                    ->danger()
                                                    ->send();

                                                $action->cancel();
                                            }
                                        }),
                                ]),
                            ]);
    }
}
