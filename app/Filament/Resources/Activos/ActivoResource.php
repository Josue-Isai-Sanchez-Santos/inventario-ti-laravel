<?php

namespace App\Filament\Resources\Activos;

use App\Filament\Resources\Activos\Pages\CreateActivo;
use App\Filament\Resources\Activos\Pages\EditActivo;
use App\Filament\Resources\Activos\Pages\ListActivos;
use App\Filament\Resources\Activos\Schemas\ActivoForm;
use App\Filament\Resources\Activos\Tables\ActivosTable;
use App\Models\Activo;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ActivoResource extends Resource
{
    protected static ?string $model = Activo::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedComputerDesktop;

    protected static string|\UnitEnum|null $navigationGroup = 'Operación';

    protected static ?string $navigationLabel = 'Activos';

    protected static ?string $modelLabel = 'Activo';

    protected static ?string $pluralModelLabel = 'Activos';

    public static function form(Schema $schema): Schema
    {
        return ActivoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ActivosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivos::route('/'),
            'create' => CreateActivo::route('/create'),
            'edit' => EditActivo::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasPermission('activos.ver') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->hasPermission('activos.crear') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->hasPermission('activos.editar') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->hasPermission('activos.eliminar') ?? false;
    }
}
