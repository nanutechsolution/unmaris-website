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

                FileUpload::make('struktur_organisasi')
                    ->label('Gambar Bagan Struktur Organisasi Fakultas')
                    ->image()
                    ->disk('public')
                    ->directory('faculties/struktur')
                    ->visibility('public')
                    ->helperText('Unggah gambar bagan struktur organisasi fakultas (JPG/PNG).')
                    ->columnSpanFull(),

                FileUpload::make('document_path')
                    ->label('Dokumen Fakultas (PDF)')
                    ->disk('public')
                    ->directory('faculties/dokumen')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(20480) // Maksimal 20MB
                    ->visibility('public')
                    ->helperText('Unggah dokumen PDF fakultas, misalnya SOTK. Maksimal 20 MB.')
                    ->columnSpanFull(),

                TextInput::make('document_title')
                    ->label('Judul Dokumen Fakultas')
                    ->placeholder('Contoh: Dokumen Struktur Organisasi dan Tata Kelola (SOTK) Fakultas Keguruan Tahun 2025')
                    ->helperText('Kosongkan untuk memakai judul default.')
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