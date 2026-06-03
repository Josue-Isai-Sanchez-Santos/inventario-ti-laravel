<?php

namespace App\Filament\Resources\EstadoLicencias;

use App\Filament\Resources\EstadoLicencias\Pages\CreateEstadoLicencia;
use App\Filament\Resources\EstadoLicencias\Pages\EditEstadoLicencia;
use App\Filament\Resources\EstadoLicencias\Pages\ListEstadoLicencias;
use App\Filament\Resources\EstadoLicencias\Schemas\EstadoLicenciaForm;
use App\Filament\Resources\EstadoLicencias\Tables\EstadoLicenciasTable;
use App\Models\EstadoLicencia;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EstadoLicenciaResource extends Resource
{
    protected static ?string $model = EstadoLicencia::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return EstadoLicenciaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EstadoLicenciasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEstadoLicencias::route('/'),
            'create' => CreateEstadoLicencia::route('/create'),
            'edit' => EditEstadoLicencia::route('/{record}/edit'),
        ];
    }
}
