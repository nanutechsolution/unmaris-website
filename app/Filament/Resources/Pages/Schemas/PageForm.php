<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // --- INFORMASI DASAR ---
            TextInput::make('title')
                ->label('Judul Halaman')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn($state, Set $set) => $set('slug', Str::slug($state))),
                
            TextInput::make('slug')
                ->label('Slug / Tautan URL')
                ->required()
                ->live(), // Trigger reaktivitas
                
            Textarea::make('meta_description')
                ->label('Deskripsi SEO')
                ->placeholder('Muncul di hasil pencarian Google')
                ->columnSpanFull(),

            // --- KELOMPOK FORM PROFIL ---
            RichEditor::make('content.sambutan')
                ->label('Sambutan Rektor')
                ->columnSpanFull()
                ->visible(fn ($get): bool => $get('slug') === 'profil-universitas'),
                
            RichEditor::make('content.visi')
                ->label('Visi Universitas')
                ->columnSpanFull()
                ->visible(fn ($get): bool => $get('slug') === 'profil-universitas'),
                
            RichEditor::make('content.misi')
                ->label('Misi Universitas (Gunakan Bullet Points)')
                ->toolbarButtons(['bulletList', 'orderedList', 'bold', 'italic'])
                ->columnSpanFull()
                ->visible(fn ($get): bool => $get('slug') === 'profil-universitas'),
                
            RichEditor::make('content.sejarah')
                ->label('Sejarah Singkat')
                ->columnSpanFull()
                ->visible(fn ($get): bool => $get('slug') === 'profil-universitas'),

            // --- KELOMPOK FORM KONTAK ---
            TextInput::make('content.email')
                ->label('Email Resmi')
                ->email()
                ->visible(fn ($get): bool => $get('slug') === 'kontak'),
                
            TextInput::make('content.telepon')
                ->label('Nomor Telepon / WhatsApp')
                ->visible(fn ($get): bool => $get('slug') === 'kontak'),
                
            Textarea::make('content.alamat')
                ->label('Alamat Lengkap Kampus')
                ->rows(2)
                ->columnSpanFull()
                ->visible(fn ($get): bool => $get('slug') === 'kontak'),
                
            Textarea::make('content.peta_embed')
                ->label('URL Titik Google Maps')
                ->helperText('Buka Google Maps > Bagikan > Sematkan Peta > Salin isi dari src="..."')
                ->rows(3)
                ->columnSpanFull()
                ->visible(fn ($get): bool => $get('slug') === 'kontak'),

            // --- KELOMPOK FORM UMUM / DEFAULT (BARU) ---
            // Form ini akan muncul untuk SEMUA halaman SELAIN profil dan kontak
            RichEditor::make('content.umum')
                ->label('Konten Halaman')
                ->columnSpanFull()
                ->fileAttachmentsDirectory('pages/umum')
                ->visible(fn ($get): bool => ! in_array($get('slug'), ['profil-universitas', 'kontak'])),
            
        ]);
    }
}