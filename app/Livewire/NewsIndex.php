<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\News;

class NewsIndex extends Component
{
    use WithPagination;

    public function render()
    {
        $news = News::with('category')
            ->where('is_published', true)
            ->latest('published_at')
            ->paginate(9);

        return view('livewire.news-index', ['news' => $news])
            ->layout('components.layouts.app', ['title' => 'Berita & Artikel - Universitas Stella Maris Sumba']);
    }
}
