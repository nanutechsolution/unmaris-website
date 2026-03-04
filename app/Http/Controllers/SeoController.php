<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Generate dynamic sitemap.xml
     */
    public function sitemap(): Response
    {
        // Ambil semua berita yang sudah di-publish
        $news = News::where('is_published', true)
                    ->orderBy('published_at', 'desc')
                    ->get();
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        // 1. Halaman Statis Utama
        $xml .= '<url>';
        $xml .= '<loc>'.route('home').'</loc>';
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>1.0</priority>';
        $xml .= '</url>';

        $xml .= '<url>';
        $xml .= '<loc>'.route('profile').'</loc>';
        $xml .= '<changefreq>monthly</changefreq>';
        $xml .= '<priority>0.8</priority>';
        $xml .= '</url>';

        $xml .= '<url>';
        $xml .= '<loc>'.route('faculties.index').'</loc>';
        $xml .= '<changefreq>monthly</changefreq>';
        $xml .= '<priority>0.8</priority>';
        $xml .= '</url>';

        $xml .= '<url>';
        $xml .= '<loc>'.route('news.index').'</loc>';
        $xml .= '<changefreq>daily</changefreq>';
        $xml .= '<priority>0.9</priority>';
        $xml .= '</url>';

        // 2. Halaman Dinamis (Berita)
        foreach($news as $item) {
            $xml .= '<url>';
            $xml .= '<loc>'.route('news.detail', $item->slug).'</loc>';
            // Menggunakan updated_at untuk lastmod
            $xml .= '<lastmod>'.$item->updated_at->toAtomString().'</lastmod>';
            $xml .= '<changefreq>monthly</changefreq>';
            $xml .= '<priority>0.6</priority>';
            $xml .= '</url>';
        }
        
        $xml .= '</urlset>';

        // Kembalikan response sebagai XML
        return response($xml, 200)->header('Content-Type', 'text/xml');
    }
}