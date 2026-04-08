<?php

namespace App\Filament\Resources\Complaints\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ComplaintsTable
{
    public static function configure(Table $table): Table
    {
        return $table
           ->columns([
                // ID biasanya tidak perlu ditampilkan kecuali untuk debugging, sembunyikan saja
                TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('ticket_number')
                    ->label('No. Tiket')
                    ->searchable()
                    ->copyable() // Memudahkan admin copy-paste nomor tiket
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('name')
                    ->label('Pelapor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->colors([
                        'primary' => 'akademik',
                        'warning' => 'fasilitas',
                        'success' => 'layanan',
                        'danger' => 'keuangan',
                        'gray' => 'lainnya',
                    ]),

                TextColumn::make('subject')
                    ->label('Perihal')
                    ->limit(30) // Agar tidak merusak layout tabel jika subjek panjang
                    ->searchable(),

                // Menggunakan ImageColumn jika attachment adalah foto, atau icon jika dokumen
                TextColumn::make('attachment')
                    ->label('Lampiran')
                    ->formatStateUsing(fn ($state) => $state ? 'Lihat File' : 'Tanpa File')
                    ->color(fn ($state) => $state ? 'primary' : 'gray')
                    ->url(fn ($record) => $record->attachment ? asset('storage/' . $record->attachment) : null)
                    ->openUrlInNewTab(),

                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'pending',
                        'warning' => 'process',
                        'success' => 'resolved',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                TextColumn::make('created_at')
                    ->label('Tgl Masuk')
                    ->dateTime('d M Y H:i') // Format lebih manusiawi
                    ->sortable(),
                
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc') // Tampilkan pengaduan terbaru di atas
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'process' => 'Diproses',
                        'resolved' => 'Selesai',
                        'rejected' => 'Ditolak',
                    ]),
                SelectFilter::make('category')
                    ->options([
                        'akademik' => 'Akademik',
                        'fasilitas' => 'Fasilitas',
                        'layanan' => 'Layanan',
                        'keuangan' => 'Keuangan',
                        'lainnya' => 'Lainnya',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
