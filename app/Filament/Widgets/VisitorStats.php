<?php

namespace App\Filament\Widgets;

use App\Models\Visitor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VisitorStats extends BaseWidget
{
    protected static ?int $sort = 0; // Tampil paling atas

    protected function getStats(): array
    {
        return [
            Stat::make('Pengunjung Hari Ini', Visitor::where('visit_date', now()->toDateString())->count())
                ->description('Jumlah perangkat unik hari ini')
                ->descriptionIcon('heroicon-m-user-group')
                ->chart([2, 4, 6, 8, 10, 12, 14]) // Contoh chart statis
                ->color('info'),

            Stat::make('Total Pengunjung', Visitor::count())
                ->description('Akumulasi sejak website rilis')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('success'),
                
            Stat::make('Trafik Mingguan', Visitor::where('visit_date', '>=', now()->subDays(7))->count())
                ->description('Kunjungan 7 hari terakhir')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),
        ];
    }
}