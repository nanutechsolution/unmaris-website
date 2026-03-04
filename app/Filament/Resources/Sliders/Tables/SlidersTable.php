<?php

namespace App\Filament\Resources\Sliders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class SlidersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Preview')
                    ->rounded()
                    ->disk('public'),
                    
                TextColumn::make('title')
                    ->label('Judul Slider')
                    ->searchable()
                    ->limit(30)
                    ->formatStateUsing(fn (string $state): string => strip_tags($state)),
                    
                TextColumn::make('label')
                    ->label('Label')
                    ->badge()
                    ->color('gray'),
                    
                TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),
                    
                ToggleColumn::make('is_active')
                    ->label('Aktif'),
                    
                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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
