<?php

namespace App\Filament\Resources\EdomReports\Schemas;

use App\Models\StudyProgram;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class EdomReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('study_program_id')
                    ->label('Program Studi')
                    ->options(fn () => StudyProgram::with('faculty')
                        ->orderBy('name')
                        ->get()
                        ->mapWithKeys(fn (StudyProgram $prodi) => [
                            $prodi->id => trim($prodi->name.' — '.($prodi->faculty?->name ?? '')),
                        ]))
                    ->searchable()
                    ->required(),

                TextInput::make('title')
                    ->label('Judul Laporan EDOM')
                    ->placeholder('Contoh: Laporan Evaluasi Dosen oleh Mahasiswa')
                    ->required()
                    ->columnSpanFull(),

                Grid::make(2)->schema([
                    TextInput::make('academic_year')
                        ->label('Tahun Akademik')
                        ->placeholder('Contoh: 2025/2026'),

                    Select::make('semester')
                        ->label('Semester')
                        ->options([
                            'Ganjil' => 'Ganjil',
                            'Genap' => 'Genap',
                        ]),
                ]),

                FileUpload::make('file_path')
                    ->label('File Laporan EDOM (PDF)')
                    ->placeholder('Pilih file PDF (maks. 30 MB)')
                    ->disk('public')
                    ->directory('study-programs/edom')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(30720) // Maksimal 30MB
                    ->validationMessages([
                        'max' => 'Ukuran dokumen terlalu besar. Maksimal 30 MB.',
                        'mimetypes' => 'Dokumen harus berformat PDF.',
                    ])
                    ->visibility('public')
                    ->helperText('Format PDF, maksimal 30 MB. Laporan akan tampil di halaman detail program studi.')
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
