<?php

namespace App\Filament\Widgets;

use App\Models\News;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class NewsChart extends ChartWidget
{
    // Menghapus 'static' karena di class induk ChartWidget properti ini bersifat non-statis
    protected ?string $heading = 'Tren Publikasi Berita';
    
    protected static ?int $sort = 2;

    protected string $color = 'info';

    protected function getData(): array
    {
        $data = Trend::model(News::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Berita Terbit',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'fill' => 'start',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}