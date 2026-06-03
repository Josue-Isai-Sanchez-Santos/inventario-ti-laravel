<?php

namespace App\Filament\Resources\AuditoriaEventos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AuditoriaEventoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('usuario_id')
                    ->relationship('usuario', 'name'),
                TextInput::make('accion')
                    ->required(),
                TextInput::make('tabla')
                    ->required(),
                TextInput::make('registro_id')
                    ->required()
                    ->numeric(),
                Textarea::make('antes')
                    ->columnSpanFull(),
                Textarea::make('despues')
                    ->columnSpanFull(),
                TextInput::make('ip'),
                Textarea::make('user_agent')
                    ->columnSpanFull(),
            ]);
    }
}
