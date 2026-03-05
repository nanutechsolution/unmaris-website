<?php

namespace App\Filament\Resources\PopupPromos\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class PopupPromoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('title')
                        ->label('Judul Promo')
                        ->required(),
                    TextInput::make('subtitle')
                        ->label('Label Kecil (Contoh: Gelombang 1)'),
                ]),
                FileUpload::make('image')
                    ->label('Gambar/Poster Promo')
                    ->image()
                    ->disk('public')
                    ->directory('popups')
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeMode('cover')
                    ->columnSpanFull(),
                RichEditor::make('description')
                    ->label('Deskripsi Promo')
                    ->toolbarButtons(['bold', 'italic', 'bulletList'])
                    ->columnSpanFull(),
                Grid::make(2)->schema([
                    TextInput::make('button_text')
                        ->label('Teks Tombol (Default: Daftar Sekarang)')
                        ->placeholder('Daftar Sekarang'),
                    TextInput::make('button_url')
                        ->label('Link/Tautan Tombol')
                        ->url()
                        ->placeholder('https://...'),
                ]),
                Toggle::make('is_active')
                    ->label('Aktifkan Pop-up ini?')
                    ->helperText('Hanya pop-up terbaru yang aktif yang akan ditampilkan.')
                    ->default(true),
            ]);
    }
}
