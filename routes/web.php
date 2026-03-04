<?php

use App\Models\Announcement;
use Illuminate\Support\Facades\Route;
use App\Models\News;
use App\Models\Faculty;
use App\Models\Leader;
use App\Models\Page;

// Home / Landing Page
Route::get('/', function () {
    // Cache queries yang jarang berubah (1 jam)
    $faculties = cache()->remember('home_faculties', 3600, fn() => Faculty::all());
    $latestNews = News::with('category')->where('is_published', true)->latest('published_at')->take(3)->get();
    return view('pages.home', compact('faculties', 'latestNews'));
})->name('home');

// Profil
// Route::view('/profil', 'pages.profile')->name('profile');
Route::get('/profil', function () {
    $page = Page::where('slug', 'profil-universitas')->firstOrFail();

    // Ambil data pimpinan yang aktif, urutkan berdasarkan kolom 'order'
    $leaders = Leader::where('is_active', true)->orderBy('order', 'asc')->get();

    return view('pages.profile', compact('page', 'leaders'));
})->name('profile');
// Fakultas & Prodi
Route::get('/fakultas', function () {
    $faculties = Faculty::with('studyPrograms')->get();
    return view('pages.faculties', compact('faculties'));
})->name('faculties.index');

// Detail Fakultas
Route::get('/fakultas/{slug}', function ($slug) {
    $faculty = Faculty::with('studyPrograms')->where('slug', $slug)->firstOrFail();
    return view('pages.faculty-detail', compact('faculty'));
})->name('faculties.detail');
// Berita (Menggunakan Livewire untuk pagination tanpa reload)
Route::get('/berita', \App\Livewire\NewsIndex::class)->name('news.index');

// Berita Detail
Route::get('/berita/{slug}', function ($slug) {
    $news = News::with('category')->where('slug', $slug)->firstOrFail();
    return view('pages.news-detail', compact('news'));
})->name('news.detail');

// SEO Utilities
Route::get('/sitemap.xml', [\App\Http\Controllers\SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/kontak', function () {
    $page = \App\Models\Page::where('slug', 'kontak')->firstOrFail();
    return view('pages.contact', compact('page'));
})->name('contact');

// Rute List Pengumuman (Livewire)
Route::get('/pengumuman', \App\Livewire\AnnouncementIndex::class)->name('announcements.index');

// Rute Detail Pengumuman
Route::get('/pengumuman/{slug}', function ($slug) {
    $announcement = Announcement::where('slug', $slug)
        ->where('is_active', true)
        ->firstOrFail();
    return view('pages.announcement-detail', compact('announcement'));
})->name('announcements.detail');

Route::get('/akademik/unduhan', \App\Livewire\DocumentCenter::class)->name('akademik.unduhan');

Route::get('/akademik/sistem-pembelajaran', function () {
    $page = \App\Models\Page::where('slug', 'sistem-pembelajaran')->firstOrFail();
    return view('pages.akademik-sistem', compact('page'));
})->name('akademik.sistem');
