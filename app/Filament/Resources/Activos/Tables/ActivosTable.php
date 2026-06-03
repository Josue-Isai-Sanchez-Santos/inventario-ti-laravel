<?php

namespace App\Filament\Resources\Activos\Tables;

use App\Support\QrGenerator;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ActivosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto_url')
                    ->label('Foto')
                    ->disk('public')
                    ->square(),

                TextColumn::make('codigo_inventario')
                    ->label('Código')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('categoria.nombre')
                    ->label('Categoría')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('estado.nombre')
                    ->label('Estado')
                    ->badge()
                    ->sortable(),

                TextColumn::make('marca')
                    ->label('Marca')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('modelo')
                    ->label('Modelo')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('serie')
                    ->label('Serie')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('fecha_compra')
                    ->label('Fecha compra')
                    ->date('Y-m-d')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('costo')
                    ->label('Costo')
                    ->money('MXN')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('qr_generado')
                    ->label('QR')
                    ->getStateUsing(fn ($record) => $record->qrExiste())
                    ->boolean(),

            ])
            ->filters([
                SelectFilter::make('categoria_id')
                    ->label('Categoría')
                    ->relationship('categoria', 'nombre'),

                SelectFilter::make('estado_id')
                    ->label('Estado')
                    ->relationship('estado', 'nombre'),
            ])
            ->recordActions([

                Action::make('descargarQrPdf')
                    ->label('PDF QR')
                    ->icon('heroicon-o-qr-code')
                    ->url(fn ($record) => route('activos.pdf', $record))
                    ->openUrlInNewTab(),

                Action::make('generarQr')
                    ->label('Generar QR')
                    ->icon('heroicon-o-arrow-path')
                    ->visible(fn ($record) => ! $record->qrExiste())
                    ->action(function ($record) {
                        QrGenerator::generarParaActivo($record->qr_token);

                        Notification::make()
                            ->title('QR generado')
                            ->body('El código QR del activo fue generado correctamente.')
                            ->success()
                            ->send();
                    }),

                EditAction::make(),

                DeleteAction::make()
                    ->before(function ($record, $action) {
                        $tieneRelaciones =
                            $record->mantenimientos()->exists() ||
                            $record->asignaciones()->exists() ||
                            $record->baja()->exists();

                        if ($tieneRelaciones) {
                            Notification::make()
                                ->title('Eliminación no permitida')
                                ->body('No se puede eliminar este activo porque ya tiene historial relacionado.')
                                ->danger()
                                ->send();

                            $action->cancel();
                        }
                    }),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
