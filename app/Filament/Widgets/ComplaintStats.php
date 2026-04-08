<?php

namespace App\Filament\Widgets;

use App\Models\Complaint;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ComplaintStats extends StatsOverviewWidget
{
    use HasWidgetShield;
   /**
     * Interval polling untuk memperbarui data secara otomatis (opsional).
     */
    protected  ?string $pollingInterval = '15s';

    /**
     * Mengambil data statistik dari model Complaint.
     */
    protected function getStats(): array
    {
        return [
            // Statistik Total Pengaduan
            Stat::make('Total Pengaduan', Complaint::count())
                ->description('Semua laporan yang masuk')
                ->descriptionIcon('heroicon-m-chat-bubble-bottom-center-text', IconPosition::Before)
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('info'),

            // Statistik Pengaduan Baru (Pending)
            Stat::make('Perlu Diproses', Complaint::where('status', 'pending')->count())
                ->description('Menunggu respon admin')
                ->descriptionIcon('heroicon-m-clock', IconPosition::Before)
                ->color('warning'),

            // Statistik Pengaduan Sedang Diproses
            Stat::make('Sedang Ditindaklanjuti', Complaint::where('status', 'process')->count())
                ->description('Laporan dalam pengerjaan')
                ->descriptionIcon('heroicon-m-arrow-path', IconPosition::Before)
                ->color('primary'),

            // Statistik Pengaduan Selesai
            Stat::make('Selesai', Complaint::where('status', 'resolved')->count())
                ->description('Berhasil diselesaikan')
                ->descriptionIcon('heroicon-m-check-badge', IconPosition::Before)
                ->color('success'),
        ];
    }
}