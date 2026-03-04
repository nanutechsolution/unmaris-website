<?php

namespace App\Filament\Resources\StudentOrganizations\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class StudentOrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('name')
                        ->label('Nama Organisasi/UKM')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn($state, $set) => $set('slug', Str::slug($state))),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),

                    Select::make('category')
                        ->label('Kategori')
                        ->options([
                            'bem_dpm' => 'BEM & DPM (Tingkat Universitas/Fakultas)',
                            'hmps' => 'Himpunan Mahasiswa Program Studi (HMPS)',
                            'ukm' => 'Unit Kegiatan Mahasiswa (UKM)',
                        ])
                        ->required()
                        ->default('ukm'),

                    TextInput::make('leader_name')
                        ->label('Nama Ketua (Opsional)')
                        ->placeholder('Contoh: Yohanes'),
                ]),

                FileUpload::make('logo')
                    ->label('Logo Organisasi (Format PNG transparan disarankan)')
                    ->image()
                    ->disk('public')
                    ->directory('organizations/logos')
                    ->imageResizeMode('contain')
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label('Deskripsi Singkat Profil Organisasi')
                    ->rows(3)
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('social_media_link')
                    ->label('Link Media Sosial (Contoh: Profil Instagram)')
                    ->url()
                    ->placeholder('[https://instagram.com/](https://instagram.com/)...')
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
