<?php

namespace App\Filament\Resources\Sliders\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SliderForm
{
    /**
     * Konfigurasi formulir untuk Slider Resource.
     * Disesuaikan untuk menerima objek Filament\Schemas\Schema guna memperbaiki Type Error.
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // BAGIAN 1: KONTEN VISUAL & TEKS
                Section::make('Konten Visual & Teks')
                    ->description('Atur tampilan utama slider di halaman beranda.')
                    ->schema([
                        TextInput::make('label')
                            ->label('Label Kecil (Top Text)')
                            ->placeholder('Contoh: Admission Open 2025')
                            ->maxLength(255),

                        // Menggunakan RichEditor agar user awam cukup klik tombol "B" (Bold) 
                        // untuk mewarnai teks tanpa perlu mengetik tag HTML manual.
                        RichEditor::make('title')
                            ->label('Judul Utama')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                            ])
                            ->helperText('Gunakan tombol Bold (B) untuk memberi warna kuning pada kata yang dipilih.')
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Deskripsi Singkat')
                            ->rows(3)
                            ->columnSpanFull()
                            ->maxLength(500),

                        FileUpload::make('image')
                            ->label('Gambar Ilustrasi')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('sliders')
                            ->visibility('public')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),

                // BAGIAN 2: NAVIGASI & PENGATURAN
                Section::make('Navigasi & Pengaturan')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                            'lg' => 4,
                        ])
                        ->schema([
                            TextInput::make('button_text')
                                ->label('Teks Tombol')
                                ->placeholder('Lihat Selengkapnya'),

                            TextInput::make('button_url')
                                ->label('Tautan Tombol (URL)')
                                ->url()
                                ->placeholder('https://...'),

                            TextInput::make('order')
                                ->label('Urutan Tampil')
                                ->numeric()
                                ->default(0)
                                ->required(),

                            Toggle::make('is_active')
                                ->label('Status Aktif')
                                ->inline(false)
                                ->default(true)
                                ->required(),
                        ]),
                    ]),
            ]);
    }
}