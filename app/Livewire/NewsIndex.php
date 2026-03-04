<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\News;
use App\Models\Category;

class NewsIndex extends Component
{
    use WithPagination;

    public $selectedCategory = null;
    public $search = '';

    // Sinkronisasi filter dengan URL agar user bisa membagikan link hasil filter
    protected $queryString = [
        'selectedCategory' => ['except' => ''],
        'search' => ['except' => ''],
    ];

    /**
     * Reset halaman ke nomor 1 setiap kali kategori diubah
     */
    public function filterCategory($categoryId = null)
    {
        $this->selectedCategory = $categoryId;
        $this->resetPage();
    }

    /**
     * Reset halaman ke nomor 1 setiap kali input pencarian berubah
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // 1. Ambil Kategori yang memiliki setidaknya satu berita (Clean Filter)
        $categories = Category::has('news')->get();

        // 2. Query Dasar untuk Daftar Berita
        $query = News::with('category')
            ->where('is_published', true)
            ->when($this->selectedCategory, fn($q) => $q->where('category_id', $this->selectedCategory))
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->latest('published_at');

        // 3. Ambil Berita Utama (Hero/Featured)
        // Kita ambil item terbaru secara eksplisit untuk dijadikan Hero
        $featuredNews = null;
        $excludedIds = [];

        // Hero hanya tampil di halaman 1, tanpa pencarian, dan tanpa filter kategori
        if ($this->getPage() === 1 && !$this->search && !$this->selectedCategory) {
            $featuredNews = (clone $query)->first();
            if ($featuredNews) {
                $excludedIds[] = $featuredNews->id;
            }
        }

        // 4. Ambil Berita Trending (Kontekstual berdasarkan kategori yang dipilih)
        $trendingNews = News::where('is_published', true)
            ->where('published_at', '>=', now()->subMonths(6)) // Rentang 6 bulan untuk universitas
            ->when($this->selectedCategory, fn($q) => $q->where('category_id', $this->selectedCategory))
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        // 5. Query Akhir untuk Grid (Mengecualikan Hero agar tidak duplikat)
        $news = $query->whereNotIn('id', $excludedIds)->paginate(9);

        return view('livewire.news-index', [
            'categories' => $categories,
            'featuredNews' => $featuredNews,
            'trendingNews' => $trendingNews,
            'news' => $news
        ])->layout('components.layouts.app', [
            'title' => 'News & Media Center - Universitas Stella Maris Sumba',
            'description' => 'Pusat informasi resmi mengenai riset, inovasi, dan prestasi civitas akademika UNMARIS.'
        ]);
    }
}
