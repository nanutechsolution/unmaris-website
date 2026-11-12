<?php

namespace App\Filament\Resources\StudyPrograms\Schemas;

use App\Models\StudyProgram;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class StudyProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Mengubah TextInput menjadi Select Relasi ke Fakultas
                Select::make('faculty_id')
                    ->relationship('faculty', 'name')
                    ->label('Fakultas Induk')
                    ->required()
                    ->searchable()
                    ->preload(),
                    
                TextInput::make('name')
                    ->label('Nama Program Studi')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                    
                TextInput::make('slug')
                    ->label('Slug / Tautan')
                    ->required()
                    ->unique(StudyProgram::class, 'slug', ignoreRecord: true),
                    
                // Mengubah TextInput menjadi Dropdown Pilihan Pasti
                Select::make('degree')
                    ->label('Jenjang Pendidikan')
                    ->options([
                        'D3' => 'Diploma 3 (D3)',
                        'S1' => 'Sarjana (S1)',
                        'S2' => 'Magister (S2)',
                    ])
                    ->required(),
                    
                // Mengubah TextInput menjadi Dropdown Akreditasi
                Select::make('accreditation')
                    ->label('Akreditasi')
                    ->options([
                        'Unggul' => 'Unggul',
                        'Baik Sekali' => 'Baik Sekali',
                        'Baik' => 'Baik',
                        'A' => 'A',
                        'B' => 'B',
                        'C' => 'C',
                        'Belum Terakreditasi' => 'Belum Terakreditasi',
                    ])
                    ->required(),
                    
                Textarea::make('description')
                    ->label('Deskripsi Singkat')
                    ->rows(3)
                    ->columnSpanFull(),
                    
                RichEditor::make('vision')
                    ->label('Visi Keilmuan Prodi')
                    ->columnSpanFull(),
                    
                RichEditor::make('mission')
                    ->label('Misi Prodi (Gunakan Bullet Points)')
                    ->toolbarButtons(['bulletList', 'orderedList', 'bold', 'italic'])
                    ->columnSpanFull(),

                RichEditor::make('tujuan')
                    ->label('Tujuan Program Studi (Gunakan Bullet Points)')
                    ->toolbarButtons(['bulletList', 'orderedList', 'bold', 'italic'])
                    ->columnSpanFull(),
                    
                RichEditor::make('career_prospects')
                    ->label('Prospek Karir Lulusan (Gunakan Bullet Points)')
                    ->toolbarButtons(['bulletList', 'orderedList', 'bold', 'italic'])
                    ->columnSpanFull(),

                FileUpload::make('edom_path')
                    ->label('Dokumen Evaluasi Dosen oleh Mahasiswa (EDOM)')
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
                    ->helperText('Format PDF, maksimal 30 MB. Dokumen akan tampil di halaman detail program studi.')
                    ->columnSpanFull(),

                TextInput::make('edom_title')
                    ->label('Judul Dokumen EDOM')
                    ->placeholder('Contoh: Laporan Evaluasi Dosen oleh Mahasiswa Semester Ganjil 2025/2026')
                    ->helperText('Kosongkan untuk memakai judul default.')
                    ->columnSpanFull(),

                Textarea::make('edom_description')
                    ->label('Keterangan Dokumen EDOM (Opsional)')
                    ->rows(2)
                    ->columnSpanFull(),
            ]);
    }
}