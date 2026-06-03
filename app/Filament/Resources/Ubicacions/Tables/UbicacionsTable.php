<?php

namespace App\Filament\Resources\Ubicacions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UbicacionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->searchable(),
                TextColumn::make('codigo')
                    ->searchable(),
                IconColumn::make('activa')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),

                DeleteAction::make()
                    ->before(function ($record, $action) {
                        if ($record->asignaciones()->exists()) {
                            Notification::make()
                                ->title('Eliminación no permitida')
                                ->body('No se puede eliminar esta ubicación porque tiene asignaciones relacionadas.')
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
                                if ($record->asignaciones()->exists()) {
                                    Notification::make()
                                        ->title('Eliminación masiva no permitida')
                                        ->body('Una o más ubicaciones seleccionadas tienen asignaciones relacionadas. No se pueden eliminar.')
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
