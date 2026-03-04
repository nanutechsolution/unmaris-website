<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Alamat Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                DateTimePicker::make('email_verified_at')
                    ->label('Email Diverifikasi Pada'),

                TextInput::make('password')
                    ->label('Kata Sandi')
                    ->password()
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->maxLength(255),

                // Input untuk memilih Role (Admin, Editor, dll)
                // Berfungsi otomatis dengan Spatie Laravel Permission
                Select::make('roles')
                    ->label('Peran / Role')
                    ->relationship('roles', 'name')
                    ->multiple() // User bisa punya banyak role
                    ->preload()
                    ->searchable(),
            ]);
    }
}