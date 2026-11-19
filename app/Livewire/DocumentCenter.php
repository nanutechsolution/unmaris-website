<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Document;

class DocumentCenter extends Component
{
    use WithPagination;

    /**
     * Kunci tab arsip dokumen akreditasi yang sudah kedaluwarsa.
     *
     * Tab ini bukan kategori pada kolom documents.category, sehingga
     * penanganannya dilakukan khusus pada query render().
     */
    public const ARSIP_TAB = 'arsip';

    /**
     * Nama resmi institusi sebelum berubah menjadi universitas.
     */
    public const NAMA_INSTITUSI_LAMA = 'Sekolah Tinggi Manajemen Informatika Komputer Stella Maris Sumba';

    /**
     * Sebutan singkat institusi lama untuk label tab dan kartu.
     */
    public const SINGKATAN_INSTITUSI_LAMA = 'STMIK Stella Maris Sumba';

    public $activeTab = 'semua';
    public $search = '';

    public $categories = [
        'semua' => 'Semua Dokumen',
        'kalender_akademik' => 'Kalender Akademik',
        'jadwal_kuliah' => 'Jadwal Kuliah',
        'jadwal_ujian' => 'Jadwal Ujian',
        'buku_pedoman' => 'Buku Pedoman',
        'kurikulum' => 'Kurikulum',
        'peraturan_akademik' => 'Peraturan Akademik',
        'formulir_akademik' => 'Formulir Akademik',
        'panduan_skripsi' => 'Panduan Skripsi',
        'panduan_kkn' => 'Panduan KKN',
        'panduan_pkl' => 'Panduan PKL',
        'beasiswa' => 'Beasiswa',
        'kemahasiswaan' => 'Kemahasiswaan',
        'kerjasama' => 'Kerjasama',
        'akreditasi' => 'Akreditasi',
        self::ARSIP_TAB => 'Arsip STMIK',
        'laporan' => 'Laporan',
        'pengumuman_resmi' => 'Pengumuman Resmi',
        'brosur_pmb' => 'Brosur PMB',
        'dokumen_umum' => 'Dokumen Umum',
    ];
    protected $queryString = [
        'activeTab' => ['except' => 'semua'],
        'search' => ['except' => ''],
    ];

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Document::query()->with('studyProgram');

        if ($this->activeTab === self::ARSIP_TAB) {
            $query->tampilArsipPublik();
        } else {
            $query->tampilPublik();

            if ($this->activeTab !== 'semua') {
                $query->where('category', $this->activeTab);
            }
        }

        if (!empty($this->search)) {
            $term = '%' . $this->search . '%';

            $query->where(function ($query) use ($term) {
                $query->where('title', 'like', $term)
                    ->orWhere('description', 'like', $term)
                    ->orWhere('nomor_sk', 'like', $term)
                    ->orWhere('lembaga_akreditasi', 'like', $term)
                    ->orWhere('peringkat', 'like', $term)
                    ->orWhere('nama_institusi_lama', 'like', $term)
                    ->orWhereHas('studyProgram', function ($prodi) use ($term) {
                        $prodi->where('name', 'like', $term);
                    });
            });
        }

        $documents = $query->latest('updated_at')->paginate(12);

        return view('livewire.document-center', [
            'documents' => $documents,
            'categories' => $this->categories,
            'arsipTab' => self::ARSIP_TAB,
            'namaInstitusiLama' => self::NAMA_INSTITUSI_LAMA,
            'singkatanInstitusiLama' => self::SINGKATAN_INSTITUSI_LAMA,
        ])->layout('components.layouts.app', ['title' => 'Pusat Unduhan Akademik - UNMARIS']);
    }
}
