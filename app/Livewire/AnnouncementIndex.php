<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Announcement;

class AnnouncementIndex extends Component
{
    use WithPagination;

    public $activeTab = 'semua'; // Filter tab aktif

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage(); // Reset pagination saat ganti tab
    }

    public function render()
    {
        $query = Announcement::where('is_active', true);

        if ($this->activeTab !== 'semua') {
            $query->where('type', $this->activeTab);
        }

        $announcements = $query->orderBy('start_date', 'desc')->paginate(10);

        return view('livewire.announcement-index', [
            'announcements' => $announcements
        ])->layout('components.layouts.app', ['title' => 'Pengumuman & Agenda - UNMARIS']);
    }
}
