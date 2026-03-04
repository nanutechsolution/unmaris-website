<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitors
{
    /**
     * Menangani permintaan masuk.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jangan catat jika yang mengakses adalah halaman admin Filament
        if (!$request->is('admin*')) {
            // Gunakan firstOrCreate agar satu IP hanya dihitung 1x per hari (Unique Visitor)
            Visitor::firstOrCreate([
                'ip_address' => $request->ip(),
                'visit_date' => now()->toDateString(),
            ], [
                'user_agent' => $request->userAgent(),
            ]);
        }

        return $next($request);
    }
}
