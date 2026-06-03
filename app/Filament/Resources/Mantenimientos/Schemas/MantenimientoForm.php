<?php

namespace App\Filament\Resources\Mantenimientos\Schemas;

use App\Models\Activo;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MantenimientoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos principales')
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
                            ->required(),

                        DateTimePicker::make('fecha')
                            ->label('Fecha y hora')
                            ->required()
                            ->default(now()),

                        DateTimePicker::make('fecha_finalizacion')
                            ->label('Fecha de finalización')
                            ->helperText('Llena este campo cuando el mantenimiento haya concluido.'),

                        Textarea::make('resultado')
                            ->label('Resultado del mantenimiento')
                            ->rows(4)
                            ->columnSpanFull(),

                        Select::make('tipo')
                            ->label('Tipo de mantenimiento')
                            ->options([
                                'Preventivo' => 'Preventivo',
                                'Correctivo' => 'Correctivo',
                            ])
                            ->required(),

                        TextInput::make('proveedor')
                            ->label('Proveedor')
                            ->maxLength(150)
                            ->helperText('Si el mantenimiento es interno, puede dejarse vacío. Si es externo, capture el nombre de la empresa o taller al que pertenece el técnico.'),
                    ])
                    ->columns(2),

                Section::make('Técnico responsable')
                    ->schema([
                        Select::make('tecnico_id')
                            ->label('Técnico interno')
                            ->options(
                                User::query()
                                    ->where('activo', true)
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Selecciona un usuario interno o captura un técnico externo.'),

                        TextInput::make('tecnico_externo')
                            ->label('Técnico externo')
                            ->maxLength(150)
                            ->nullable(),
                    ])
                    ->columns(2),

                Section::make('Detalle y evidencia')
                    ->schema([
                        Textarea::make('descripcion')
                            ->label('Descripción')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),

                        TextInput::make('costo')
                            ->label('Costo')
                            ->numeric()
                            ->prefix('$'),

                        FileUpload::make('comprobante_url')
                            ->label('Comprobante / evidencia')
                            ->disk('public')
                            ->directory('mantenimientos')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
