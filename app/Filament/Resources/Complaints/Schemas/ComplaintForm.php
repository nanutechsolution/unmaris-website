<?php

namespace App\Filament\Resources\Complaints\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ComplaintForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(1)
                    ->schema([
                        Section::make('Informasi Tiket')
                            ->description('Detail identitas pengaduan sistem.')
                            ->columnSpan(1)
                            ->schema([
                                TextInput::make('ticket_number')
                                    ->label('Nomor Tiket')
                                    ->disabled() // Tidak boleh diubah manual
                                    ->placeholder('Otomatis saat simpan')
                                    ->dehydrated(false) // Jangan kirim ke database saat create jika sudah ada di model
                                    ->visibleOn('edit'),

                                Select::make('status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'process' => 'Diproses',
                                        'resolved' => 'Selesai',
                                        'rejected' => 'Ditolak',
                                    ])
                                    ->native(false)
                                    ->required()
                                    ->default('pending'),

                                Select::make('category')
                                    ->label('Kategori')
                                    ->options([
                                        'akademik' => 'Akademik',
                                        'fasilitas' => 'Fasilitas',
                                        'layanan' => 'Layanan',
                                        'keuangan' => 'Keuangan',
                                        'lainnya' => 'Lainnya',
                                    ])
                                    ->native(false)
                                    ->required(),
                            ]),

                        Section::make('Data Pelapor & Isi')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nama Pelapor')
                                            ->required(),
                                        TextInput::make('email')
                                            ->label('Alamat Email')
                                            ->email()
                                            ->required(),
                                        TextInput::make('phone')
                                            ->label('Nomor HP')
                                            ->tel(),
                                        TextInput::make('subject')
                                            ->label('Subjek/Perihal')
                                            ->required(),
                                    ]),

                                Textarea::make('content')
                                    ->label('Isi Pengaduan')
                                    ->rows(5)
                                    ->required(),

                                FileUpload::make('attachment')
                                    ->label('Dokumen Pendukung')
                                    ->directory('complaints/attachments') // Folder storage
                                    ->visibility('public')
                                    ->openable()
                                    ->downloadable(),
                            ]),
                    ]),

                Section::make('Tanggapan Admin')
                    ->description('Berikan jawaban atau instruksi tindak lanjut untuk pelapor.')
                    ->schema([
                        Textarea::make('admin_response')
                            ->label('Balasan Resmi')
                            ->rows(4)
                            ->placeholder('Tulis jawaban atau solusi di sini...')
                            ->helperText('Jawaban ini akan dapat dilihat oleh pelapor saat mengecek status tiket.'),
                    ])
                    ->collapsible(),
            ]);
    }
}
