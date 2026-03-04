<?php

namespace App\Filament\Resources\Scholarships\Tables;

use App\Models\Scholarship;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ScholarshipsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Nama Beasiswa')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('provider')
                    ->label('Penyelenggara')
                    ->searchable(),

                TextColumn::make('end_date')
                    ->label('Batas Akhir')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(function (Scholarship $record) {
                        return $record->is_open ? 'Buka' : 'Tutup';
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Buka' => 'success',
                        'Tutup' => 'danger',
                    }),

                ToggleColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
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
