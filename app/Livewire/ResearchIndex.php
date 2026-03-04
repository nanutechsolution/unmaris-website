<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Research;

class ResearchIndex extends Component
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
        $query = Research::where('is_active', true);

        if ($this->activeTab !== 'semua') {
            $query->where('type', $this->activeTab);
        }

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('author', 'like', '%' . $this->search . '%');
            });
        }

        $publications = $query->orderBy('publication_date', 'desc')->paginate(10);

        return view('livewire.research-index', [
            'publications' => $publications
        ])->layout('components.layouts.app', ['title' => 'Direktori Publikasi Ilmiah - LPPM UNMARIS']);
    }
}