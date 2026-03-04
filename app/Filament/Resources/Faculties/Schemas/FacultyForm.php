<?php

namespace App\Filament\Resources\Faculties\Schemas;

use App\Models\Faculty;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class FacultyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Fakultas')
                    ->required()
                    ->live(onBlur: true)
                    // Menghilangkan type-hint Set pada parameter $set untuk kompatibilitas
                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                    
                TextInput::make('slug')
                    ->label('Slug / Tautan')
                    ->required()
                    ->unique(Faculty::class, 'slug', ignoreRecord: true),
                    
                Textarea::make('description')
                    ->label('Deskripsi Singkat')
                    ->rows(3)
                    ->columnSpanFull(),
                    
                RichEditor::make('vision')
                    ->label('Visi Fakultas')
                    ->columnSpanFull(),
                    
                RichEditor::make('mission')
                    ->label('Misi Fakultas (Gunakan Bullet Points)')
                    ->toolbarButtons(['bulletList', 'orderedList', 'bold', 'italic'])
                    ->columnSpanFull(),
                    
                FileUpload::make('image')
                    ->label('Foto Gedung / Logo Fakultas')
                    ->image()
                    ->disk('public')
                    ->directory('faculties')
                    ->columnSpanFull(),
                    
                TextInput::make('email')
                    ->label('Email Resmi Fakultas')
                    ->email(),
                    
                TextInput::make('phone')
                    ->label('Nomor Telepon / WA')
                    ->tel(),
            ]);
    }
}