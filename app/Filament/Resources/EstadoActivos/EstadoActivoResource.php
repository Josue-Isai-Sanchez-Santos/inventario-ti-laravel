<?php

namespace App\Filament\Resources\EstadoActivos;

use App\Filament\Resources\EstadoActivos\Pages\CreateEstadoActivo;
use App\Filament\Resources\EstadoActivos\Pages\EditEstadoActivo;
use App\Filament\Resources\EstadoActivos\Pages\ListEstadoActivos;
use App\Filament\Resources\EstadoActivos\Schemas\EstadoActivoForm;
use App\Filament\Resources\EstadoActivos\Tables\EstadoActivosTable;
use App\Models\EstadoActivo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EstadoActivoResource extends Resource
{
    protected static ?string $model = EstadoActivo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return EstadoActivoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EstadoActivosTable::configure($table);
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
            'index' => ListEstadoActivos::route('/'),
            'create' => CreateEstadoActivo::route('/create'),
            'edit' => EditEstadoActivo::route('/{record}/edit'),
        ];
    }
}
