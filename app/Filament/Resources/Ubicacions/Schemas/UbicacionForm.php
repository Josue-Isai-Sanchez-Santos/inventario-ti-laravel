<?php

namespace App\Filament\Resources\Ubicacions\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UbicacionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('codigo'),
                Textarea::make('descripcion')
                    ->columnSpanFull(),
                Toggle::make('activa')
                    ->required(),
            ]);
    }
}
