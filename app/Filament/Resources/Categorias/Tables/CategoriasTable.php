<?php

namespace App\Filament\Resources\Categorias\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CategoriasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_categoria')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(50)
                    ->wrap(),

                IconColumn::make('activa')
                    ->label('Activa')
                    ->boolean(),
            ])
            ->filters([
                TernaryFilter::make('activa')
                    ->label('Estado'),
            ])
            ->recordActions([
                EditAction::make(),

                DeleteAction::make()
                    ->before(function ($record, $action) {
                        if ($record->activos()->exists()) {
                            Notification::make()
                                ->title('Eliminación no permitida')
                                ->body('No se puede eliminar esta categoría porque tiene activos relacionados.')
                                ->danger()
                                ->send();

                            $action->cancel();
                        }
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->before(function ($records, $action) {
                            foreach ($records as $record) {
                                if ($record->activos()->exists()) {
                                    Notification::make()
                                        ->title('Eliminación masiva no permitida')
                                        ->body('Una o más categorías seleccionadas tienen activos relacionados. No se pueden eliminar.')
                                        ->danger()
                                        ->send();

                                    $action->cancel();

                                    return;
                                }
                            }
                        }),
                ]),
            ]);
    }
}
