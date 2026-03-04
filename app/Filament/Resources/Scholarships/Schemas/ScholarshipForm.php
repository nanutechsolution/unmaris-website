<?php

namespace App\Filament\Resources\Scholarships\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ScholarshipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('title')
                        ->label('Nama Beasiswa')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn($state, $set) => $set('slug', Str::slug($state))),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),

                    TextInput::make('provider')
                        ->label('Penyelenggara / Instansi')
                        ->placeholder('Contoh: Kemdikbudristek, Yayasan Stella Maris')
                        ->required(),

                    TextInput::make('registration_url')
                        ->label('Link Pendaftaran (Opsional)')
                        ->url()
                        ->placeholder('https://...'),
                ]),

                Grid::make(2)->schema([
                    DatePicker::make('start_date')
                        ->label('Tanggal Buka Pendaftaran'),

                    DatePicker::make('end_date')
                        ->label('Tanggal Tutup Pendaftaran'),
                ]),

                Textarea::make('description')
                    ->label('Deskripsi Singkat')
                    ->rows(3)
                    ->required()
                    ->columnSpanFull(),

                RichEditor::make('benefits')
                    ->label('Cakupan / Fasilitas Beasiswa (Gunakan Bullet Points)')
                    ->toolbarButtons(['bulletList', 'orderedList', 'bold'])
                    ->columnSpanFull(),

                RichEditor::make('requirements')
                    ->label('Persyaratan Pendaftar (Gunakan Bullet Points)')
                    ->toolbarButtons(['bulletList', 'orderedList', 'bold'])
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Tampilkan di Website?')
                    ->default(true),
            ]);
    }
}
