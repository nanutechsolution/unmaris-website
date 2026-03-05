<?php

use App\Http\Controllers\NewsController;
use App\Models\Announcement;
use App\Models\Facility;
use Illuminate\Support\Facades\Route;
use App\Models\News;
use App\Models\Faculty;
use App\Models\Leader;
use App\Models\Page;
use App\Models\Partner;
use App\Models\PopupPromo;
use App\Models\Scholarship;
use App\Models\Slider;
use App\Models\StudentOrganization;
use App\Models\StudyProgram;
use App\Models\Testimonial;

Route::get('/', function () {
    // Ambil data Slider dan Berita
    $sliders = Slider::where('is_active', true)->orderBy('order', 'asc')->get();
    $latestNews = News::with('category')->where('is_published', true)->latest('published_at')->take(4)->get();

    // Ambil Pop-up Promo yang sedang aktif (paling baru)
    $popupPromo = PopupPromo::where('is_active', true)->latest()->first();

    // Hitung Statistik Langsung dari Database
    $countProdi = StudyProgram::count();
    $countFakultas = Faculty::count();
    $countBerita = News::where('is_published', true)->count();
    $testimonials = Testimonial::where('is_active', true)->orderBy('order', 'asc')->take(6)->get();
    $partner = Partner::where('is_active', true)->orderBy('order', 'asc')->get();

    $faculties = Faculty::with('studyPrograms')->get();
    return view('pages.home', compact('sliders', 'latestNews', 'countProdi', 'countFakultas', 'countBerita', 'popupPromo', 'testimonials', 'partner', 'faculties'));
})->name('home');

Route::get('/fasilitas', function () {
    // Ambil data fasilitas yang aktif dan urutkan
    $facilities = Facility::where('is_active', true)->orderBy('order', 'asc')->get();

    return view('pages.facilities', compact('facilities'));
})->name('facilities.index');
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
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.detail');
Route::post('/berita/{news}/share', [NewsController::class, 'incrementShare'])->name('news.share.increment');

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

Route::post('/news/{id}/share-increment', function ($id) {
    $news = News::findOrFail($id);
    $news->increment('shares');
    return response()->json(['success' => true, 'total_shares' => $news->shares]);
})->name('news.share.increment');

Route::get('/lppm/profil', function () {
    $page = \App\Models\Page::where('slug', 'profil-lppm')->firstOrFail();
    return view('pages.akademik-sistem', compact('page'));
})->name('lppm.profil');

// Rute Direktori Publikasi / Jurnal (Livewire)
Route::get('/lppm/publikasi', \App\Livewire\ResearchIndex::class)->name('lppm.publikasi');


Route::get('/kemitraan', function () {
    // Ambil data aktif dan kelompokkan berdasarkan tipe
    $partnersGrouped = Partner::where('is_active', true)
        ->orderBy('order', 'asc')
        ->get()
        ->groupBy('type');

    return view('pages.partnerships', compact('partnersGrouped'));
})->name('partnerships.index');

Route::get('/kemahasiswaan/beasiswa', function () {
    // Ambil data beasiswa yang aktif, urutkan yang masih buka di atas
    $scholarships = Scholarship::where('is_active', true)
        ->orderByRaw('end_date >= CURDATE() DESC') // Buka di atas
        ->orderBy('end_date', 'asc') // Yang mau tutup duluan di atas
        ->get();

    return view('pages.scholarships', compact('scholarships'));
})->name('scholarships.index');


Route::get('/kemahasiswaan/organisasi', function () {
    // Ambil data yang aktif dan kelompokkan berdasarkan kategori
    $organizationsGrouped = StudentOrganization::where('is_active', true)
        ->orderBy('order', 'asc')
        ->orderBy('name', 'asc')
        ->get()
        ->groupBy('category');

    return view('pages.student-organizations', compact('organizationsGrouped'));
})->name('organizations.index');
