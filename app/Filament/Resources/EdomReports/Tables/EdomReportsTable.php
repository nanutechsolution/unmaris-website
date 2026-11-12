<?php

namespace App\Filament\Resources\EdomReports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class EdomReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('studyProgram.name')
                    ->label('Program Studi')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('title')
                    ->label('Judul Laporan')
                    ->searchable()
                    ->weight('bold')
                    ->wrap(),

                TextColumn::make('academic_year')
                    ->label('Tahun Akademik')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('semester')
                    ->label('Semester')
                    ->badge()
                    ->color(fn (?string $state): string => $state === 'Genap' ? 'success' : 'info')
                    ->placeholder('-'),

                ToggleColumn::make('is_active')
                    ->label('Aktif'),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('study_program_id')
                    ->label('Program Studi')
                    ->relationship('studyProgram', 'name')
                    ->searchable()
                    ->preload(),

                TernaryFilter::make('is_active')
                    ->label('Status Tampil'),
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
