<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Faculty;
use App\Models\Announcement;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $news = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->get();

        $faculties = Faculty::all();

        $announcements = Announcement::where('is_active', true)->get();

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $urlset = $dom->createElement('urlset');
        $urlset->setAttribute(
            'xmlns',
            'http://www.sitemaps.org/schemas/sitemap/0.9'
        );

        $dom->appendChild($urlset);

        /*
        |--------------------------------------------------------------------------
        | Halaman Statis
        |--------------------------------------------------------------------------
        */

        $staticPages = [
            ['route' => 'home', 'priority' => '1.0', 'freq' => 'weekly'],
            ['route' => 'profile', 'priority' => '0.8', 'freq' => 'monthly'],
            ['route' => 'faculties.index', 'priority' => '0.8', 'freq' => 'monthly'],
            ['route' => 'facilities.index', 'priority' => '0.7', 'freq' => 'monthly'],
            ['route' => 'news.index', 'priority' => '0.9', 'freq' => 'daily'],
            ['route' => 'announcements.index', 'priority' => '0.8', 'freq' => 'daily'],
            ['route' => 'contact', 'priority' => '0.7', 'freq' => 'monthly'],
            ['route' => 'partnerships.index', 'priority' => '0.7', 'freq' => 'monthly'],
            ['route' => 'scholarships.index', 'priority' => '0.7', 'freq' => 'weekly'],
            ['route' => 'organizations.index', 'priority' => '0.7', 'freq' => 'monthly'],
        ];

        foreach ($staticPages as $page) {

            $url = $dom->createElement('url');

            $loc = $dom->createElement('loc', route($page['route']));
            $url->appendChild($loc);

            $changefreq = $dom->createElement('changefreq', $page['freq']);
            $url->appendChild($changefreq);

            $priority = $dom->createElement('priority', $page['priority']);
            $url->appendChild($priority);

            $urlset->appendChild($url);
        }

        /*
        |--------------------------------------------------------------------------
        | Halaman Fakultas Detail
        |--------------------------------------------------------------------------
        */

        foreach ($faculties as $faculty) {

            $url = $dom->createElement('url');

            $loc = $dom->createElement(
                'loc',
                route('faculties.detail', $faculty->slug)
            );

            $url->appendChild($loc);

            $changefreq = $dom->createElement('changefreq', 'monthly');
            $url->appendChild($changefreq);

            $priority = $dom->createElement('priority', '0.7');
            $url->appendChild($priority);

            $urlset->appendChild($url);
        }

        /*
        |--------------------------------------------------------------------------
        | Halaman Berita
        |--------------------------------------------------------------------------
        */

        foreach ($news as $item) {

            $url = $dom->createElement('url');

            $loc = $dom->createElement(
                'loc',
                route('news.detail', $item->slug)
            );

            $url->appendChild($loc);

            if ($item->updated_at) {
                $lastmod = $dom->createElement(
                    'lastmod',
                    $item->updated_at->toAtomString()
                );
                $url->appendChild($lastmod);
            }

            $changefreq = $dom->createElement('changefreq', 'monthly');
            $url->appendChild($changefreq);

            $priority = $dom->createElement('priority', '0.6');
            $url->appendChild($priority);

            $urlset->appendChild($url);
        }

        /*
        |--------------------------------------------------------------------------
        | Halaman Pengumuman
        |--------------------------------------------------------------------------
        */

        foreach ($announcements as $item) {

            $url = $dom->createElement('url');

            $loc = $dom->createElement(
                'loc',
                route('announcements.detail', $item->slug)
            );

            $url->appendChild($loc);

            if ($item->updated_at) {
                $lastmod = $dom->createElement(
                    'lastmod',
                    $item->updated_at->toAtomString()
                );
                $url->appendChild($lastmod);
            }

            $changefreq = $dom->createElement('changefreq', 'monthly');
            $url->appendChild($changefreq);

            $priority = $dom->createElement('priority', '0.6');
            $url->appendChild($priority);

            $urlset->appendChild($url);
        }

        return response(
            $dom->saveXML(),
            200
        )->header('Content-Type', 'text/xml');
    }
}