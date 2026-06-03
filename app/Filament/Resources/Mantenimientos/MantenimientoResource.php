<?php

namespace App\Filament\Resources\Mantenimientos;

use App\Filament\Resources\Mantenimientos\Pages\CreateMantenimiento;
use App\Filament\Resources\Mantenimientos\Pages\EditMantenimiento;
use App\Filament\Resources\Mantenimientos\Pages\ListMantenimientos;
use App\Filament\Resources\Mantenimientos\Schemas\MantenimientoForm;
use App\Filament\Resources\Mantenimientos\Tables\MantenimientosTable;
use App\Models\Mantenimiento;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MantenimientoResource extends Resource
{
    protected static ?string $model = Mantenimiento::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|\UnitEnum|null $navigationGroup = 'Operación';

    protected static ?string $navigationLabel = 'Mantenimientos';

    protected static ?string $modelLabel = 'Mantenimiento';

    protected static ?string $pluralModelLabel = 'Mantenimientos';

    public static function form(Schema $schema): Schema
    {
        return MantenimientoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MantenimientosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMantenimientos::route('/'),
            'create' => CreateMantenimiento::route('/create'),
            'edit' => EditMantenimiento::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasPermission('mantenimientos.ver') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->hasPermission('mantenimientos.crear') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->hasPermission('mantenimientos.editar') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->hasPermission('mantenimientos.eliminar') ?? false;
    }
}
