<?php

namespace App\Filament\Resources\Facilities\Schemas;

use App\Models\Facility;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class FacilityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('name')
                        ->label('Nama Fasilitas')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn($state, Set $set) => $set('slug', Str::slug($state))),

                    TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->unique(Facility::class, 'slug', ignoreRecord: true),
                ]),

                Textarea::make('description')
                    ->label('Deskripsi Fasilitas')
                    ->rows(3)
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Foto Fasilitas (Landscape direkomendasikan)')
                    ->image()
                    ->disk('public')
                    ->directory('facilities')
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9') // Memaksa rasio gambar seragam
                    ->required()
                    ->columnSpanFull(),

                Grid::make(2)->schema([
                    TextInput::make('order')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->default(0)
                        ->required(),
                    Toggle::make('is_active')
                        ->label('Tampilkan di Website?')
                        ->default(true),
                ]),
            ]);
    }
}
