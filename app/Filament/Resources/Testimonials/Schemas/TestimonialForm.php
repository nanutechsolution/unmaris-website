<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('name')
                        ->label('Nama Lengkap Alumni')
                        ->required(),

                    TextInput::make('job_title')
                        ->label('Profesi / Jabatan')
                        ->placeholder('Contoh: Software Engineer')
                        ->required(),

                    TextInput::make('company')
                        ->label('Instansi / Perusahaan')
                        ->placeholder('Contoh: PT. Telkom Indonesia'),
                ]),

                Textarea::make('message')
                    ->label('Isi Testimoni')
                    ->rows(4)
                    ->required()
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Foto Alumni (Rasio 1:1 disarankan)')
                    ->image()
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeMode('cover')
                    ->disk('public')
                    ->directory('testimonials')
                    ->columnSpanFull(),

                Grid::make(2)->schema([
                    TextInput::make('order')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->default(0),

                    Toggle::make('is_active')
                        ->label('Tampilkan di Beranda?')
                        ->default(true),
                ]),
            ]);
    }
}
