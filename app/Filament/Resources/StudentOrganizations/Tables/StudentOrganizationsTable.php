<?php

namespace App\Filament\Resources\StudentOrganizations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StudentOrganizationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->extraImgAttributes(['class' => 'object-contain p-1 bg-gray-50 rounded-lg']),

                TextColumn::make('name')
                    ->label('Nama Organisasi')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'bem_dpm' => 'danger',
                        'hmps' => 'warning',
                        'ukm' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'bem_dpm' => 'BEM/DPM',
                        'hmps' => 'HMPS',
                        'ukm' => 'UKM',
                        default => $state,
                    }),

                ToggleColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                SelectFilter::make('category')
                    ->options([
                        'bem_dpm' => 'BEM & DPM',
                        'hmps' => 'HMPS',
                        'ukm' => 'UKM',
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
