<?php

namespace App\Filament\Resources\Documents\Tables;

use App\Filament\Resources\Documents\Schemas\DocumentForm;
use App\Models\Document;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
             ->columns([
                TextColumn::make('title')
                    ->label('Nama Dokumen')
                    ->searchable(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'kalender_akademik' => 'danger',
                        'jadwal_kuliah' => 'info',
                        'buku_pedoman' => 'warning',
                        'dokumen_umum' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state))),

                TextColumn::make('institusi')
                    ->label('Institusi')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        Document::INSTITUSI_SEKOLAH_TINGGI => 'STMIK (arsip)',
                        Document::INSTITUSI_UNIVERSITAS => 'Universitas',
                        default => '-',
                    })
                    ->color(fn (?string $state): string => $state === Document::INSTITUSI_SEKOLAH_TINGGI ? 'warning' : 'success')
                    ->placeholder('-'),

                TextColumn::make('lembaga_akreditasi')
                    ->label('Lembaga')
                    ->placeholder('-')
                    ->wrap(),

                TextColumn::make('peringkat')
                    ->label('Peringkat')
                    ->placeholder('-'),

                TextColumn::make('berlaku_sampai')
                    ->label('Berlaku Sampai')
                    ->dateTime('d M Y')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('status_masa_berlaku')
                    ->label('Status')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'Berlaku' => 'success',
                        'Akan Berakhir' => 'warning',
                        'Kedaluwarsa' => 'danger',
                        default => 'gray',
                    })
                    ->placeholder('-'),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('institusi')
                    ->label('Institusi')
                    ->options(Document::INSTITUSI_OPTIONS),

                TernaryFilter::make('is_arsip')
                    ->label('Dokumen Arsip')
                    ->trueLabel('Hanya arsip')
                    ->falseLabel('Bukan arsip')
                    ->placeholder('Semua dokumen')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->where('is_arsip', true),
                        false: fn (Builder $query): Builder => $query->where(function (Builder $query): void {
                            $query->whereNull('is_arsip')
                                ->orWhere('is_arsip', false);
                        }),
                    ),

                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(DocumentForm::CATEGORY_OPTIONS)
                    ->searchable(),

                SelectFilter::make('status_masa_berlaku')
                    ->label('Status Masa Berlaku')
                    ->options([
                        'berlaku' => 'Berlaku',
                        'akan_berakhir' => 'Akan Berakhir',
                        'kedaluwarsa' => 'Kedaluwarsa',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $status = $data['value'] ?? null;

                        if (blank($status)) {
                            return $query;
                        }

                        $batasPeringatan = today()->addDays(180);

                        return match ($status) {
                            'berlaku' => $query
                                ->where('category', 'akreditasi')
                                ->whereDate('berlaku_sampai', '>', $batasPeringatan),
                            'akan_berakhir' => $query
                                ->where('category', 'akreditasi')
                                ->whereDate('berlaku_sampai', '>=', today())
                                ->whereDate('berlaku_sampai', '<=', $batasPeringatan),
                            'kedaluwarsa' => $query
                                ->where('category', 'akreditasi')
                                ->whereDate('berlaku_sampai', '<', today()),
                            default => $query,
                        };
                    }),

                SelectFilter::make('lembaga_akreditasi')
                    ->label('Lembaga Akreditasi')
                    ->options(fn (): array => Document::query()
                        ->whereNotNull('lembaga_akreditasi')
                        ->where('lembaga_akreditasi', '!=', '')
                        ->distinct()
                        ->orderBy('lembaga_akreditasi')
                        ->pluck('lembaga_akreditasi', 'lembaga_akreditasi')
                        ->all())
                    ->searchable(),
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
