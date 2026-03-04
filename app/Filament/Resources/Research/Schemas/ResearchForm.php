<?php

namespace App\Filament\Resources\Research\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ResearchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('Jenis Publikasi')
                    ->options([
                        'jurnal' => 'Jurnal Ilmiah',
                        'pengabdian' => 'Laporan Pengabdian Masyarakat',
                        'buku' => 'Buku Referensi / Ajar',
                        'hki' => 'Hak Kekayaan Intelektual (HKI)',
                    ])
                    ->required()
                    ->default('jurnal'),

                TextInput::make('title')
                    ->label('Judul Publikasi')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('author')
                    ->label('Penulis / Tim Peneliti')
                    ->placeholder('Contoh: Dr. Budi Santoso, ST., MT.')
                    ->required(),

                DatePicker::make('publication_date')
                    ->label('Tanggal Publikasi')
                    ->required(),

                Textarea::make('abstract')
                    ->label('Abstrak / Ringkasan')
                    ->rows(4)
                    ->columnSpanFull(),

                TextInput::make('link_url')
                    ->label('Tautan Eksternal (Opsional)')
                    ->placeholder('[https://scholar.google.com/](https://scholar.google.com/)...')
                    ->url()
                    ->columnSpanFull(),

                FileUpload::make('file_path')
                    ->label('Unggah File (Jika Tautan Tidak Ada)')
                    ->disk('public')
                    ->directory('lppm/research')
                    ->acceptedFileTypes(['application/pdf'])
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Tampilkan di Website')
                    ->default(true),
            ]);
    }
}
