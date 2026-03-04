<?php

namespace App\Filament\Widgets;

use App\Models\Faculty;
use Filament\Widgets\ChartWidget;

class ProdiChart extends ChartWidget
{
    protected  ?string $heading = 'Distribusi Program Studi';
    protected static ?int $sort = 3;
    protected  string $color = 'warning';

    protected function getData(): array
    {
        $faculties = Faculty::withCount('studyPrograms')->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Prodi',
                    'data' => $faculties->pluck('study_programs_count'),
                    'backgroundColor' => [
                        '#1B1464', '#FDE01A', '#10b981', '#ef4444', '#f59e0b'
                    ],
                ],
            ],
            'labels' => $faculties->pluck('name'),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}