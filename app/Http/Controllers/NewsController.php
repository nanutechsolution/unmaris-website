<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Menampilkan detail berita dan mencatat views.
     */
    public function show($slug)
    {
        $news = News::with('category')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment Views (Gunakan session agar 1 user 1 view per sesi)
        if (!session()->has('viewed_news_' . $news->id)) {
            $news->increment('views');
            session()->put('viewed_news_' . $news->id, true);
        }

        // Berita terkait: utamakan kategori yang sama, lalu lengkapi dari berita terbaru lain.
        $relatedNews = News::with(['category', 'tags'])
            ->where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->where('is_published', true)
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($relatedNews->count() < 3) {
            $fallbackNews = News::with(['category', 'tags'])
                ->where('id', '!=', $news->id)
                ->whereNotIn('id', $relatedNews->pluck('id'))
                ->where('is_published', true)
                ->latest('published_at')
                ->take(3 - $relatedNews->count())
                ->get();

            $relatedNews = $relatedNews->concat($fallbackNews);
        }

        // Berita terpopuler untuk sidebar (display-only).
        $popularNews = News::with('category')
            ->where('is_published', true)
            ->where('id', '!=', $news->id)
            ->orderByDesc('views')
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('pages.news-detail', compact('news', 'relatedNews', 'popularNews'));
    }

    /**
     * AJAX: Mencatat jumlah share.
     */
    public function incrementShare(Request $request, News $news)
    {
        $news->increment('shares');
        return response()->json(['success' => true]);
    }
}
