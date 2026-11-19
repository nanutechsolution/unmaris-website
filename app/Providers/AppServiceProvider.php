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
            'validation.uploaded' => 'File gagal diunggah. Maksimal ukuran file 10 MB, format harus PDF, DOCX, atau XLSX, atau koneksi terputus. Silakan kompres file lalu coba lagi.',
            'validation.max.file' => 'File terlalu besar. Maksimal 10 MB. Silakan kompres file lalu coba lagi.',
            'validation.mimetypes' => 'Format file tidak didukung. Dokumen harus berupa PDF, DOCX, atau XLSX.',
        ], 'id');

        Lang::addLines([
            'validation.uploaded' => 'The file could not be uploaded. The maximum file size is 10 MB, the format must be PDF, DOCX, or XLSX, or the connection was interrupted. Please compress the file and try again.',
            'validation.max.file' => 'The file is too large. Maximum 10 MB. Please compress the file and try again.',
            'validation.mimetypes' => 'The file format is not supported. Documents must be PDF, DOCX, or XLSX.',
        ], 'en');
    }
}

