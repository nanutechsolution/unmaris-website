<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LogUploadFailures
{
    /**
     * Catat detail kegagalan upload (misalnya file melebihi batas PHP)
     * supaya penyebabnya bisa diketahui dari storage/logs/laravel.log.
     */
    public function handle(Request $request, Closure $next)
    {
        $this->logFailedUploads($request->files->all());

        return $next($request);
    }

    private function logFailedUploads(array $files): void
    {
        foreach ($files as $file) {
            if (is_array($file)) {
                $this->logFailedUploads($file);
                continue;
            }

            if (! $file instanceof UploadedFile || $file->getError() === UPLOAD_ERR_OK) {
                continue;
            }

            Log::warning('Upload file gagal', [
                'file' => $file->getClientOriginalName(),
                'error_code' => $file->getError(),
                'error' => $this->errorLabel($file->getError()),
                'size_bytes' => $file->getSize() ?: 0,
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
            ]);
        }
    }

    private function errorLabel(int $error): string
    {
        return match ($error) {
            UPLOAD_ERR_INI_SIZE => 'UPLOAD_ERR_INI_SIZE (melebihi upload_max_filesize)',
            UPLOAD_ERR_FORM_SIZE => 'UPLOAD_ERR_FORM_SIZE (melebihi batas form)',
            UPLOAD_ERR_PARTIAL => 'UPLOAD_ERR_PARTIAL (upload terputus)',
            UPLOAD_ERR_NO_FILE => 'UPLOAD_ERR_NO_FILE (tidak ada file)',
            UPLOAD_ERR_NO_TMP_DIR => 'UPLOAD_ERR_NO_TMP_DIR (folder sementara tidak ada)',
            UPLOAD_ERR_CANT_WRITE => 'UPLOAD_ERR_CANT_WRITE (gagal menulis file sementara)',
            UPLOAD_ERR_EXTENSION => 'UPLOAD_ERR_EXTENSION (dihentikan ekstensi PHP)',
            default => 'Kesalahan upload tidak diketahui',
        };
    }
}
