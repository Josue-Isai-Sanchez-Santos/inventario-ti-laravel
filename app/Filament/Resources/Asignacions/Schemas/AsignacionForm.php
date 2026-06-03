<?php

namespace App\Filament\Resources\Asignacions\Schemas;

use App\Models\Activo;
use App\Models\Ubicacion;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AsignacionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos de asignación')
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
                            ->helperText('Cada activo solo puede tener una asignación vigente.'),

                        Select::make('responsable_id')
                            ->label('Responsable')
                            ->options(
                                User::query()
                                    ->where('activo', true)
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('ubicacion_id')
                            ->label('Ubicación')
                            ->options(
                                Ubicacion::query()
                                    ->where('activa', true)
                                    ->orderBy('nombre')
                                    ->pluck('nombre', 'id_ubicacion')
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        DateTimePicker::make('fecha_asignacion')
                            ->label('Fecha de asignación')
                            ->required()
                            ->default(now()),

                        DateTimePicker::make('fecha_retorno')
                            ->label('Fecha de retorno')
                            ->after('fecha_asignacion')
                            ->helperText('Déjalo vacío si la asignación sigue vigente.'),

                        Textarea::make('observaciones')
                            ->label('Observaciones')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Nota')
                    ->schema([
                        Placeholder::make('nota_vigencia')
                            ->label('')
                            ->content('Si un activo ya tiene una asignación vigente, la base de datos impedirá guardar otra mientras fecha_retorno siga en NULL.'),
                    ]),
            ]);
    }
}
