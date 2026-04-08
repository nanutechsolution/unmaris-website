<?php

namespace App\Filament\Resources\Complaints\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ComplaintInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                  Section::make('Informasi Pengaduan')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('ticket_number')
                                    ->label('Ticket')
                                    ->copyable(),

                                TextEntry::make('status')
                                    ->badge()
                                    ->color(fn ($state) => match ($state) {
                                        'open' => 'warning',
                                        'closed' => 'success',
                                        'pending' => 'gray',
                                        default => 'secondary',
                                    }),
                            ]),

                        TextEntry::make('category')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('subject')
                            ->weight('bold'),

                        TextEntry::make('content')
                            ->columnSpanFull()
                            ->markdown(),
                    ]),

                Section::make('Data Pelapor')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->icon('heroicon-o-user'),

                                TextEntry::make('email')
                                    ->icon('heroicon-o-envelope')
                                    ->copyable(),

                                TextEntry::make('phone')
                                    ->placeholder('-')
                                    ->icon('heroicon-o-phone'),
                            ]),
                    ]),

                Section::make('Lampiran & Respon')
                    ->schema([
                        TextEntry::make('attachment')
                            ->label('Attachment')
                            ->url(fn ($state) => $state ? asset('storage/' . $state) : null)
                            ->openUrlInNewTab()
                            ->placeholder('Tidak ada file'),

                        TextEntry::make('admin_response')
                            ->label('Respon Admin')
                            ->placeholder('Belum ada respon')
                            ->columnSpanFull()
                            ->markdown(),
                    ]),

                Section::make('Metadata')
                    ->collapsed()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->dateTime(),

                                TextEntry::make('updated_at')
                                    ->dateTime(),
                            ]),
                    ]),
            ]);
    }
}
