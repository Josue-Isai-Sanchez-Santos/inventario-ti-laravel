<?php

namespace App\Filament\Resources\Activos\Schemas;

use App\Models\Categoria;
use App\Models\EstadoActivo;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ActivoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información general')
                    ->schema([
                        TextInput::make('codigo_inventario')
                            ->label('Código de inventario')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true),

                        TextInput::make('nombre')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(150),

                        Select::make('categoria_id')
                            ->label('Categoría')
                            ->options(
                                Categoria::query()
                                    ->where('activa', true)
                                    ->orderBy('nombre')
                                    ->pluck('nombre', 'id_categoria')
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('estado_id')
                            ->label('Estado del activo')
                            ->options(
                                EstadoActivo::query()
                                    ->where('activo', true)
                                    ->orderBy('nombre')
                                    ->pluck('nombre', 'id_estado')
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Datos técnicos')
                    ->schema([
                        TextInput::make('marca')
                            ->label('Marca')
                            ->maxLength(100),

                        TextInput::make('modelo')
                            ->label('Modelo')
                            ->maxLength(100),

                        TextInput::make('serie')
                            ->label('Número de serie')
                            ->maxLength(100)
                            ->unique(ignoreRecord: true),

                        DatePicker::make('fecha_compra')
                            ->label('Fecha de compra')
                            ->native(false),

                        TextInput::make('costo')
                            ->label('Costo')
                            ->numeric()
                            ->prefix('$'),

                        TextInput::make('qr_token')
                            ->label('QR Token')
                            ->required()
                            ->maxLength(100)
                            ->default(fn () => (string) Str::uuid())
                            ->unique(ignoreRecord: true),
                    ])
                    ->columns(2),

                Section::make('Descripción y evidencia')
                    ->schema([
                        Textarea::make('descripcion')
                            ->label('Descripción')
                            ->rows(4)
                            ->columnSpanFull(),

                        FileUpload::make('foto_url')
                            ->label('Foto del activo')
                            ->image()
                            ->disk('public')
                            ->directory('activos')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }
}
