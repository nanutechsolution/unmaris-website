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
            'documents' => $documents
        ])->layout('components.layouts.app', ['title' => 'Pusat Unduhan Akademik - UNMARIS']);
    }
}
