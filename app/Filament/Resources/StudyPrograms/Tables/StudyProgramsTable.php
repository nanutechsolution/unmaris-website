<?php

namespace App\Filament\Resources\StudyPrograms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StudyProgramsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Menarik relasi nama fakultas, bukan menampilkan UUID mentah
                TextColumn::make('faculty.name')
                    ->label('Fakultas')
                    ->searchable()
                    ->sortable()
                    ->wrap(), // Membungkus teks jika terlalu panjang
                    
                TextColumn::make('name')
                    ->label('Program Studi')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                    
                TextColumn::make('degree')
                    ->label('Jenjang')
                    ->badge() // Membuatnya tampil seperti pil/label warna
                    ->color('info')
                    ->searchable(),
                    
                TextColumn::make('accreditation')
                    ->label('Akreditasi')
                    ->badge()
                    // Mewarnai otomatis berdasarkan nilai akreditasi
                    ->color(fn (string $state): string => match ($state) {
                        'Unggul', 'A' => 'success',
                        'Baik Sekali', 'B' => 'warning',
                        'Baik', 'C' => 'primary',
                        default => 'danger',
                    })
                    ->searchable(),
                    
                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name', 'asc')
            ->filters([
                // Anda bisa menambahkan filter Fakultas di sini nanti jika diperlukan
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