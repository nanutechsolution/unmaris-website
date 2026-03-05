<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Document;

class DocumentCenter extends Component
{
    use WithPagination;

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
        $query = Document::where('is_active', true);

        if ($this->activeTab !== 'semua') {
            $query->where('category', $this->activeTab);
        }

        if (!empty($this->search)) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        $documents = $query->latest('updated_at')->paginate(12);

        return view('livewire.document-center', [
            'documents' => $documents,
            'categories' => $this->categories,
        ])->layout('components.layouts.app', ['title' => 'Pusat Unduhan Akademik - UNMARIS']);
    }
}
