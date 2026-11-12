<?php

namespace App\Filament\Resources\StudyPrograms\Tables;

use App\Models\StudyProgram;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                    
                IconColumn::make('edom_reports_count')
                    ->label('EDOM')
                    ->boolean()
                    ->getStateUsing(fn (StudyProgram $record): bool => ($record->edom_reports_count ?? 0) > 0)
                    ->tooltip(fn (StudyProgram $record): string => ($record->edom_reports_count ?? 0) > 0 ? 'Memiliki laporan EDOM' : 'Belum ada laporan EDOM'),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withCount('edomReports'))
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