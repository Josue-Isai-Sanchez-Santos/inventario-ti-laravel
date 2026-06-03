<?php

namespace App\Filament\Resources\AuditoriaEventos;

use App\Filament\Resources\AuditoriaEventos\Pages\ListAuditoriaEventos;
use App\Filament\Resources\AuditoriaEventos\Tables\AuditoriaEventosTable;
use App\Models\AuditoriaEvento;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AuditoriaEventoResource extends Resource
{
    protected static ?string $model = AuditoriaEvento::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static string|\UnitEnum|null $navigationGroup = 'Control';

    protected static ?string $navigationLabel = 'Auditoría';

    protected static ?string $modelLabel = 'Evento de auditoría';

    protected static ?string $pluralModelLabel = 'Auditoría y trazabilidad';

    public static function table(Table $table): Table
    {
        return AuditoriaEventosTable::configure($table);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasPermission('auditoria.ver') ?? false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAuditoriaEventos::route('/'),
        ];
    }
}
