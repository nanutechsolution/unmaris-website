<?php

namespace App\Filament\Resources\Announcements\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class AnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->label('Judul Pengumuman/Agenda')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn($state, $set) => $set('slug', Str::slug($state))),
                
            TextInput::make('slug')
                ->label('Slug')
                ->required(),

            Select::make('type')
                ->label('Tipe Informasi')
                ->options([
                    'pengumuman' => 'Pengumuman Resmi',
                    'agenda' => 'Agenda / Acara',
                ])
                ->default('pengumuman')
                ->required()
                ->live(), // Trigger perubahan UI berdasarkan tipe

            // Lokasi hanya muncul jika tipe = agenda (Menghapus type-hint Get untuk kompatibilitas Filament v5)
            TextInput::make('location')
                ->label('Lokasi Acara')
                ->placeholder('Contoh: Aula Utama UNMARIS')
                ->visible(fn ($get) => $get('type') === 'agenda'),

                DateTimePicker::make('start_date')
                    ->label('Tanggal Mulai / Tanggal Berlaku')
                    ->required()
                    ->default(now()),
                DateTimePicker::make('end_date')
                    ->label('Tanggal Selesai (Opsional)'),

            RichEditor::make('content')
                ->label('Isi Lengkap')
                ->required()
                ->columnSpanFull(),

            FileUpload::make('attachment')
                ->label('File Lampiran (PDF/Docx/Gambar)')
                ->disk('public')
                ->directory('announcements/attachments')
                ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                ->columnSpanFull(),

            Toggle::make('is_active')
                ->label('Tampilkan di Website?')
                ->default(true),
        ]);
    }
}
