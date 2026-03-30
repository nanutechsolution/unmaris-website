<?php

namespace App\Filament\Resources\News\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class NewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->disk('public')
                    ->visibility('public')
                    ->square()
                    ->label('Gambar'),
                TextColumn::make('category.name')
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable(),
                IconColumn::make('is_published')
                    ->boolean(),
            ])->defaultSort('published_at', 'desc')
            ->filters([
                // 1. Filter Dropdown Relasi Kategori
                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Kategori')
                    ->searchable()
                    ->preload(),

                // 2. Filter Status Boolean (Terpublikasi/Draf)
                TernaryFilter::make('is_published')
                    ->label('Status Publikasi')
                    ->boolean()
                    ->trueLabel('Sudah Terpublikasi')
                    ->falseLabel('Hanya Draf')
                    ->native(false), // Menggunakan dropdown custom Filament (bukan native HTML)

                // 3. Filter Rentang Tanggal (Date Range)
                Filter::make('published_at')
                    ->form([
                        DatePicker::make('published_from')
                            ->label('Diterbitkan dari'),
                        DatePicker::make('published_until')
                            ->label('Diterbitkan sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
                            );
                    })
                    // (Opsional) Menampilkan indikator filter aktif di atas tabel
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['published_from'] ?? null) {
                            $indicators[] = Indicator::make('Terbit sejak: ' . Carbon::parse($data['published_from'])->format('d M Y'))
                                ->removeField('published_from');
                        }

                        if ($data['published_until'] ?? null) {
                            $indicators[] = Indicator::make('Terbit hingga: ' . Carbon::parse($data['published_until'])->format('d M Y'))
                                ->removeField('published_until');
                        }

                        return $indicators;
                    }),


            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
