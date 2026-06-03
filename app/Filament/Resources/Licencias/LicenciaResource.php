<?php

namespace App\Filament\Resources\Licencias;

use App\Filament\Resources\Licencias\Pages\CreateLicencia;
use App\Filament\Resources\Licencias\Pages\EditLicencia;
use App\Filament\Resources\Licencias\Pages\ListLicencias;
use App\Filament\Resources\Licencias\Schemas\LicenciaForm;
use App\Filament\Resources\Licencias\Tables\LicenciasTable;
use App\Models\Licencia;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LicenciaResource extends Resource
{
    protected static ?string $model = Licencia::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedKey;

    protected static string|\UnitEnum|null $navigationGroup = 'Operación';

    protected static ?string $navigationLabel = 'Licencias';

    protected static ?string $modelLabel = 'Licencia';

    protected static ?string $pluralModelLabel = 'Licencias';

    public static function form(Schema $schema): Schema
    {
        return LicenciaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LicenciasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasPermission('licencias.ver') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->hasPermission('licencias.crear') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->hasPermission('licencias.editar') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->hasPermission('licencias.eliminar') ?? false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLicencias::route('/'),
            'create' => CreateLicencia::route('/create'),
            'edit' => EditLicencia::route('/{record}/edit'),
        ];
    }
}
