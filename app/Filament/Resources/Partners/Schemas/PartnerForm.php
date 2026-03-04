<?php

namespace App\Filament\Resources\Partners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class PartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('name')
                        ->label('Nama Instansi / Mitra')
                        ->required(),

                    Select::make('type')
                        ->label('Kategori Mitra')
                        ->options([
                            'pendidikan' => 'Institusi Pendidikan (Universitas/Sekolah)',
                            'pemerintah' => 'Pemerintah & Instansi Negara',
                            'kesehatan' => 'Fasilitas Kesehatan (RS/Klinik)',
                            'perusahaan' => 'Perusahaan / Industri',
                            'lainnya' => 'Lainnya (NGO/Yayasan/dll)',
                        ])
                        ->required()
                        ->default('lainnya'),
                ]),

                FileUpload::make('logo')
                    ->label('Logo Mitra (Gunakan background transparan/PNG)')
                    ->image()
                    ->disk('public')
                    ->directory('partners')
                    ->imageResizeMode('contain')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('website_url')
                    ->label('Tautan Website Mitra (Opsional)')
                    ->url()
                    ->placeholder('https://...')
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label('Keterangan Kerjasama (Opsional)')
                    ->rows(2)
                    ->columnSpanFull(),

                Grid::make(2)->schema([
                    TextInput::make('order')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->default(0),

                    Toggle::make('is_active')
                        ->label('Tampilkan di Website?')
                        ->default(true),
                ]),
            ]);
    }
}
