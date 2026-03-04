<?php

namespace App\Filament\Widgets;

use App\Models\News;
use App\Models\Message;
use App\Models\Faculty;
use App\Models\Announcement;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Berita', News::count())
                ->description('Artikel yang telah dipublikasikan')
                ->descriptionIcon('heroicon-m-newspaper')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('Pesan Masuk', Message::where('is_read', false)->count())
                ->description('Pesan baru yang butuh respons')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('danger'),

            Stat::make('Fakultas', Faculty::count())
                ->description('Total fakultas aktif')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('primary'),

            Stat::make('Agenda Mendatang', Announcement::where('type', 'agenda')->where('start_date', '>=', now())->count())
                ->description('Kegiatan kampus bulan ini')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('warning'),
        ];
    }
}