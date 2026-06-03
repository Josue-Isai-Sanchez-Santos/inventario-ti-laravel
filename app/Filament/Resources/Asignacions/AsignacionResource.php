<?php

namespace App\Filament\Resources\Asignacions;

use App\Filament\Resources\Asignacions\Pages\CreateAsignacion;
use App\Filament\Resources\Asignacions\Pages\EditAsignacion;
use App\Filament\Resources\Asignacions\Pages\ListAsignacions;
use App\Filament\Resources\Asignacions\Schemas\AsignacionForm;
use App\Filament\Resources\Asignacions\Tables\AsignacionsTable;
use App\Models\Asignacion;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AsignacionResource extends Resource
{
    protected static ?string $model = Asignacion::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|\UnitEnum|null $navigationGroup = 'Operación';

    protected static ?string $navigationLabel = 'Asignaciones';

    protected static ?string $modelLabel = 'Asignación';

    protected static ?string $pluralModelLabel = 'Asignaciones';

    public static function form(Schema $schema): Schema
    {
        return AsignacionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AsignacionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAsignacions::route('/'),
            'create' => CreateAsignacion::route('/create'),
            'edit' => EditAsignacion::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasPermission('asignaciones.ver') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->hasPermission('asignaciones.crear') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->hasPermission('asignaciones.editar') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->hasPermission('asignaciones.eliminar') ?? false;
    }
}
