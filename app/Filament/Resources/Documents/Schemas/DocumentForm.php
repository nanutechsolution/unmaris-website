<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Nama Dokumen')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required(),

                Select::make('category')
                    ->label('Kategori Dokumen')
                    ->options([
                        'kalender_akademik' => 'Kalender Akademik',
                        'jadwal_kuliah' => 'Jadwal Kuliah',
                        'buku_pedoman' => 'Buku Pedoman',
                        'dokumen_umum' => 'Dokumen Umum / Lainnya',
                    ])
                    ->required()
                    ->default('dokumen_umum'),

                FileUpload::make('file_path')
                    ->label('Unggah File (PDF, DOCX, XLSX)')
                    ->disk('public')
                    ->directory('academic-documents')
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                    ->maxSize(10240) // Maksimal 10MB
                    ->required()
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label('Keterangan Singkat (Opsional)')
                    ->rows(2)
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Tampilkan di Website')
                    ->default(true),
            ]);
    }
}
