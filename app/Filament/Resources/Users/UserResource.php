<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|\UnitEnum|null $navigationGroup = 'Administración';

    protected static ?string $navigationLabel = 'Usuarios';

    protected static ?string $modelLabel = 'Usuario';

    protected static ?string $pluralModelLabel = 'Usuarios';

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasPermission('usuarios.ver') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->hasPermission('usuarios.crear') ?? false;
    }

    public static function canEdit($record): bool
    {
        $authUser = auth()->user();

        if (! $authUser) {
            return false;
        }

        if (! $authUser->hasPermission('usuarios.editar')) {
            return false;
        }

        $recordIsAdmin = $record->roles()
            ->where('nombre', 'Administrador')
            ->exists();

        $authUserIsAdmin = $authUser->roles()
            ->where('nombre', 'Administrador')
            ->exists();

        if ($recordIsAdmin && ! $authUserIsAdmin) {
            return false;
        }

        return true;
    }

    public static function canDelete($record): bool
    {
        $authUser = auth()->user();

        if (! $authUser) {
            return false;
        }

        if (! $authUser->hasPermission('usuarios.eliminar')) {
            return false;
        }

        if ((int) $authUser->id === (int) $record->id) {
            return false;
        }

        $recordIsAdmin = $record->roles()
            ->where('nombre', 'Administrador')
            ->exists();

        $authUserIsAdmin = $authUser->roles()
            ->where('nombre', 'Administrador')
            ->exists();

        if ($recordIsAdmin && ! $authUserIsAdmin) {
            return false;
        }

        return true;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
