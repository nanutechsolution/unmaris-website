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
                    ->placeholder('Pilih foto JPG/PNG (maks. 30 MB)')
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png'])
                    ->automaticallyResizeImagesMode('contain')
                    ->automaticallyResizeImagesToWidth('2000')
                    ->maxSize(30720)
                    ->validationMessages([
                        'max' => 'Ukuran foto terlalu besar. Maksimal 30 MB.',
                        'mimetypes' => 'Format foto harus JPG atau PNG.',
                        'image' => 'File harus berupa gambar JPG atau PNG.',
                    ])
                    ->disk('public')
                    ->directory('faculties')
                    ->columnSpanFull(),

                FileUpload::make('struktur_organisasi')
                    ->label('Gambar Bagan Struktur Organisasi Fakultas')
                    ->placeholder('Pilih gambar JPG/PNG (maks. 30 MB)')
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png'])
                    ->automaticallyResizeImagesMode('contain')
                    ->automaticallyResizeImagesToWidth('2500')
                    ->maxSize(30720) // Maksimal 30MB
                    ->validationMessages([
                        'max' => 'Ukuran gambar terlalu besar. Maksimal 30 MB.',
                        'mimetypes' => 'Format gambar harus JPG atau PNG.',
                        'image' => 'File harus berupa gambar JPG atau PNG.',
                    ])
                    ->disk('public')
                    ->directory('faculties/struktur')
                    ->visibility('public')
                    ->helperText('Format JPG/PNG, maksimal 30 MB. Jika lebih dari 30 MB, kompres atau kecilkan resolusi gambar terlebih dahulu.')
                    ->columnSpanFull(),

                FileUpload::make('document_path')
                    ->label('Dokumen Fakultas (PDF)')
                    ->placeholder('Pilih file PDF (maks. 30 MB)')
                    ->disk('public')
                    ->directory('faculties/dokumen')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(30720) // Maksimal 30MB
                    ->validationMessages([
                        'max' => 'Ukuran dokumen terlalu besar. Maksimal 30 MB.',
                        'mimetypes' => 'Dokumen harus berformat PDF.',
                    ])
                    ->visibility('public')
                    ->helperText('Format PDF, maksimal 30 MB. Jika lebih besar, kompres PDF terlebih dahulu.')
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
