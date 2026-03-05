<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Nama Dokumen')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required(),

                Select::make('category')
                    ->label('Kategori Dokumen')
                    ->options([
                        'kalender_akademik' => 'Kalender Akademik',
                        'jadwal_kuliah' => 'Jadwal Kuliah',
                        'jadwal_ujian' => 'Jadwal Ujian',
                        'buku_pedoman' => 'Buku Pedoman Akademik',
                        'kurikulum' => 'Kurikulum',
                        'peraturan_akademik' => 'Peraturan Akademik',
                        'formulir_akademik' => 'Formulir Akademik',
                        'panduan_skripsi' => 'Panduan Skripsi / Tugas Akhir',
                        'panduan_kkn' => 'Panduan KKN',
                        'panduan_pkl' => 'Panduan PKL / Magang',
                        'beasiswa' => 'Informasi Beasiswa',
                        'kemahasiswaan' => 'Dokumen Kemahasiswaan',
                        'kerjasama' => 'Dokumen Kerjasama',
                        'akreditasi' => 'Dokumen Akreditasi',
                        'laporan' => 'Laporan Institusi',
                        'pengumuman_resmi' => 'Pengumuman Resmi',
                        'brosur_pmb' => 'Brosur PMB',
                        'dokumen_umum' => 'Dokumen Umum / Lainnya',
                    ])
                    ->required()
                    ->default('dokumen_umum'),

                FileUpload::make('file_path')
                    ->label('Unggah File (PDF, DOCX, XLSX)')
                    ->disk('public')
                    ->directory('academic-documents')
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                    ->maxSize(10240) // Maksimal 10MB
                    ->required()
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label('Keterangan Singkat (Opsional)')
                    ->rows(2)
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Tampilkan di Website')
                    ->default(true),
            ]);
    }
}
