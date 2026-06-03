<?php

namespace App\Filament\Resources\Bajas\Schemas;

use App\Models\Activo;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BajaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos de la baja')
                    ->schema([
                        Select::make('activo_id')
                            ->label('Activo')
                            ->options(
                                Activo::query()
                                    ->orderBy('nombre')
                                    ->get()
                                    ->mapWithKeys(fn ($activo) => [
                                        $activo->id_activo => $activo->codigo_inventario.' - '.$activo->nombre,
                                    ])
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabledOn('edit')
                            ->dehydrated(true)
                            ->helperText('Cada activo solo puede tener una baja registrada.'),

                        DatePicker::make('fecha')
                            ->label('Fecha de baja')
                            ->required()
                            ->default(now())
                            ->native(false)
                            ->disabledOn('edit')
                            ->dehydrated(true),

                        TextInput::make('motivo')
                            ->label('Motivo')
                            ->required()
                            ->maxLength(150),

                        Placeholder::make('autorizado_por_nombre')
                            ->label('Autorizado por')
                            ->content(fn () => auth()->user()?->name ?? 'Usuario no autenticado'),

                        Hidden::make('autorizado_por_id')
                            ->default(fn () => auth()->id())
                            ->dehydrated(true),
                    ])
                    ->columns(2),

                Section::make('Detalle y evidencia')
                    ->schema([
                        Textarea::make('detalle')
                            ->label('Detalle')
                            ->rows(5)
                            ->columnSpanFull(),

                        FileUpload::make('documento_url')
                            ->label('Documento / evidencia')
                            ->disk('public')
                            ->directory('bajas')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
