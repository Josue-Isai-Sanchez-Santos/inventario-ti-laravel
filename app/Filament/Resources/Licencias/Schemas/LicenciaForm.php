<?php

namespace App\Filament\Resources\Licencias\Schemas;

use App\Models\Activo;
use App\Models\EstadoLicencia;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LicenciaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos de la licencia')
                    ->schema([
                        Select::make('activo_id')
                            ->label('Activo asociado')
                            ->options(
                                Activo::query()
                                    ->orderBy('nombre')
                                    ->get()
                                    ->mapWithKeys(fn ($activo) => [
                                        $activo->id_activo => $activo->codigo_inventario . ' - ' . $activo->nombre,
                                    ])
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->helperText('La licencia se asocia a un activo existente. No todos los activos requieren licencia.'),

                        Select::make('estado_lic_id')
                            ->label('Estado de la licencia')
                            ->options(
                                EstadoLicencia::query()
                                    ->where('activo', true)
                                    ->orderBy('nombre')
                                    ->pluck('nombre', 'id_estado_lic')
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('tipo')
                            ->label('Tipo de licencia')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Ej. Software, antivirus, sistema operativo, suite ofimática'),

                        TextInput::make('proveedor')
                            ->label('Proveedor')
                            ->maxLength(150)
                            ->placeholder('Ej. Microsoft, Adobe, Autodesk'),

                        TextInput::make('clave')
                            ->label('Clave o identificador')
                            ->maxLength(150)
                            ->password()
                            ->revealable()
                            ->helperText('Este campo puede almacenar una clave, número de licencia o identificador interno.'),

                        DatePicker::make('fecha_inicio')
                            ->label('Fecha de inicio')
                            ->native(false),

                        DatePicker::make('fecha_fin')
                            ->label('Fecha de vencimiento')
                            ->native(false),
                    ])
                    ->columns(2),

                Section::make('Archivo y observaciones')
                    ->schema([
                        FileUpload::make('archivo_url')
                            ->label('Archivo de licencia')
                            ->disk('public')
                            ->directory('licencias')
                            ->visibility('public')
                            ->downloadable()
                            ->openable()
                            ->helperText('Puede adjuntarse evidencia, comprobante o documento relacionado con la licencia.'),
                    ])
                    ->columns(1),
            ]);
    }
}
