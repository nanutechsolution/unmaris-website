<?php

namespace App\Filament\Resources\Partners\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PartnersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->extraImgAttributes(['class' => 'object-contain p-1 bg-white rounded-lg border border-gray-200']),

                TextColumn::make('name')
                    ->label('Nama Mitra')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('type')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pendidikan' => 'info',
                        'pemerintah' => 'danger',
                        'kesehatan' => 'success',
                        'perusahaan' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state) => ucfirst($state)),

                TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),

                ToggleColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                SelectFilter::make('type')
                    ->label('Filter Kategori')
                    ->options([
                        'pendidikan' => 'Pendidikan',
                        'pemerintah' => 'Pemerintah',
                        'kesehatan' => 'Kesehatan',
                        'perusahaan' => 'Perusahaan',
                        'lainnya' => 'Lainnya',
                    ]),
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
