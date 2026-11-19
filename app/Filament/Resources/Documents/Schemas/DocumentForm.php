<?php

namespace App\Filament\Resources\Documents\Schemas;

use App\Models\Document;
use App\Models\StudyProgram;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class DocumentForm
{
    /**
     * Opsi kategori dokumen.
     *
     * @var array<string, string>
     */
    public const CATEGORY_OPTIONS = [
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
    ];

    /**
     * Saran nama lembaga akreditasi untuk datalist.
     *
     * @var list<string>
     */
    public const LEMBAGA_AKREDITASI_SUGGESTIONS = [
        'BAN-PT',
        'LAM INFOKOM',
        'LAM Teknik',
        'LAMEMBA',
        'LAM Sains',
        'LAM Pertanian',
        'LAM Kesehatan',
        'LAM Seni',
    ];

    /**
     * Opsi peringkat akreditasi.
     *
     * @var array<string, string>
     */
    public const PERINGKAT_OPTIONS = [
        'Unggul' => 'Unggul',
        'Baik Sekali' => 'Baik Sekali',
        'Baik' => 'Baik',
        'A' => 'A',
        'B' => 'B',
        'C' => 'C',
    ];

    /**
     * Kolom yang hanya boleh terisi untuk kategori akreditasi.
     *
     * @var list<string>
     */
    public const ACCREDITATION_FIELDS = [
        'institusi',
        'nama_institusi_lama',
        'is_arsip',
        'lembaga_akreditasi',
        'study_program_id',
        'nomor_sk',
        'peringkat',
        'berlaku_mulai',
        'berlaku_sampai',
    ];

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
                    ->options(self::CATEGORY_OPTIONS)
                    ->required()
                    ->default('dokumen_umum')
                    ->live(),

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

                Section::make('Data Akreditasi')
                    ->description('Lengkapi data berikut untuk dokumen kategori akreditasi.')
                    ->columns(2)
                    ->visible(fn (Get $get): bool => $get('category') === 'akreditasi')
                    ->schema([
                        Select::make('institusi')
                            ->label('Institusi Penerbit')
                            ->options(Document::INSTITUSI_OPTIONS)
                            ->default(Document::INSTITUSI_UNIVERSITAS)
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (?string $state, $set): void {
                                if ($state !== Document::INSTITUSI_SEKOLAH_TINGGI) {
                                    $set('is_arsip', false);
                                }
                            })
                            ->helperText('Pilih institusi yang tercantum pada dokumen.'),

                        Toggle::make('is_arsip')
                            ->label('Dokumen Arsip Sekolah Tinggi')
                            ->live()
                            ->afterStateUpdated(function (bool $state, $set): void {
                                if ($state) {
                                    $set('institusi', Document::INSTITUSI_SEKOLAH_TINGGI);
                                }
                            })
                            ->helperText('Aktifkan untuk dokumen era STMIK. Dokumen arsip tetap tampil di tab Arsip walau masa berlakunya sudah lewat.'),

                        TextInput::make('nama_institusi_lama')
                            ->label('Nama Institusi Saat Dokumen Diterbitkan')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->visible(fn (Get $get): bool => $get('institusi') === Document::INSTITUSI_SEKOLAH_TINGGI)
                            ->placeholder('Contoh: Sekolah Tinggi Manajemen Informatika Komputer Stella Maris Sumba')
                            ->helperText('Opsional. Jika dikosongkan, kartu publik memakai nama resmi institusi lama.'),

                        TextInput::make('lembaga_akreditasi')
                            ->label('Lembaga Akreditasi')
                            ->datalist(self::LEMBAGA_AKREDITASI_SUGGESTIONS)
                            ->maxLength(255)
                            ->required()
                            ->placeholder('Contoh: BAN-PT'),

                        Select::make('peringkat')
                            ->label('Peringkat Akreditasi')
                            ->options(self::PERINGKAT_OPTIONS)
                            ->required()
                            ->placeholder('Pilih peringkat akreditasi'),

                        TextInput::make('nomor_sk')
                            ->label('Nomor SK Akreditasi')
                            ->maxLength(255)
                            ->placeholder('Contoh: 1234/SK/BAN-PT/Akred/S/2026'),

                        Select::make('study_program_id')
                            ->label('Program Studi')
                            ->options(fn (): array => StudyProgram::query()
                                ->with('faculty')
                                ->orderBy('name')
                                ->get()
                                ->mapWithKeys(fn (StudyProgram $prodi): array => [
                                    $prodi->id => $prodi->faculty?->name
                                        ? $prodi->name.' — '.$prodi->faculty->name
                                        : $prodi->name,
                                ])
                                ->all())
                            ->searchable()
                            ->placeholder('Kosongkan untuk akreditasi tingkat institusi'),

                        DatePicker::make('berlaku_mulai')
                            ->label('Berlaku Mulai'),

                        DatePicker::make('berlaku_sampai')
                            ->label('Berlaku Sampai')
                            ->required()
                            ->afterOrEqual('berlaku_mulai')
                            ->validationMessages([
                                'after_or_equal' => 'Tanggal berlaku sampai harus sama dengan atau setelah tanggal berlaku mulai.',
                            ]),
                    ]),

                Toggle::make('is_active')
                    ->label('Tampilkan di Website')
                    ->default(true),
            ]);
    }

    /**
     * Merapikan kolom akreditasi sebelum data disimpan.
     *
     * Kolom akreditasi dikosongkan apabila kategori bukan akreditasi. Untuk
     * kategori akreditasi, nilai institusi dan is_arsip dijaga tetap konsisten:
     * arsip selalu berasal dari institusi sekolah tinggi, dan institusi kosong
     * dianggap sebagai universitas.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function normalizeAccreditationData(array $data): array
    {
        if (($data['category'] ?? null) !== 'akreditasi') {
            foreach (self::ACCREDITATION_FIELDS as $field) {
                $data[$field] = null;
            }

            return $data;
        }

        if (blank($data['institusi'] ?? null)) {
            $data['institusi'] = Document::INSTITUSI_UNIVERSITAS;
        }

        if ((bool) ($data['is_arsip'] ?? false)) {
            $data['is_arsip'] = true;
            $data['institusi'] = Document::INSTITUSI_SEKOLAH_TINGGI;
        } else {
            $data['is_arsip'] = false;
        }

        if ($data['institusi'] !== Document::INSTITUSI_SEKOLAH_TINGGI) {
            $data['is_arsip'] = false;
            $data['nama_institusi_lama'] = null;
        } elseif (blank($data['nama_institusi_lama'] ?? null)) {
            $data['nama_institusi_lama'] = null;
        }

        return $data;
    }
}
