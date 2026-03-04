<?php

namespace App\Filament\Widgets;

use App\Models\Message;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Widgets\TableWidget;

class LatestMessages extends TableWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Pesan Masuk Terbaru (Belum Dibaca)';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Message::query()
                    ->where('is_read', false)
                    ->latest()
            )
            ->columns([
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M H:i')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Pengirim')
                    ->searchable(),

                TextColumn::make('subject')
                    ->label('Perihal')
                    ->limit(50)
                    ->tooltip(fn($record) => $record->subject),
            ])
            ->defaultPaginationPageOption(5);
    }
}
