<?php

namespace App\Providers;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Pesan yang mudah dipahami saat upload gagal (misalnya file terlalu besar).
        Lang::addLines([
            'validation.uploaded' => 'File gagal diunggah. Kemungkinan ukurannya terlalu besar (maksimal 30 MB), formatnya tidak didukung, atau koneksi terputus. Silakan kompres file lalu coba lagi.',
            'validation.max.file' => 'File terlalu besar. Maksimal 30 MB. Silakan kompres file lalu coba lagi.',
        ], 'id');

        Lang::addLines([
            'validation.uploaded' => 'The file could not be uploaded. It may be too large (max 30 MB), in an unsupported format, or the connection was interrupted. Please compress the file and try again.',
            'validation.max.file' => 'The file is too large. Maximum 30 MB. Please compress the file and try again.',
        ], 'en');
    }
}

