<?php

namespace App\Filament\Resources\Bajas;

use App\Filament\Resources\Bajas\Pages\CreateBaja;
use App\Filament\Resources\Bajas\Pages\EditBaja;
use App\Filament\Resources\Bajas\Pages\ListBajas;
use App\Filament\Resources\Bajas\Schemas\BajaForm;
use App\Filament\Resources\Bajas\Tables\BajasTable;
use App\Models\Baja;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BajaResource extends Resource
{
    protected static ?string $model = Baja::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBoxXMark;

    protected static string|\UnitEnum|null $navigationGroup = 'Operación';

    protected static ?string $navigationLabel = 'Bajas';

    protected static ?string $modelLabel = 'Baja';

    protected static ?string $pluralModelLabel = 'Bajas';

    public static function form(Schema $schema): Schema
    {
        return BajaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BajasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBajas::route('/'),
            'create' => CreateBaja::route('/create'),
            'edit' => EditBaja::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasPermission('bajas.ver') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->hasPermission('bajas.crear') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->hasPermission('bajas.editar') ?? false;
    }

    public static function canDelete($record): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        if (! $user->hasPermission('bajas.eliminar')) {
            return false;
        }

        return $user->hasRole('Administrador');
    }
}
