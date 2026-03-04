<?php

namespace App\Filament\Resources\ActivityLogs;

use App\Enums\NavigationGroup;
use App\Filament\Resources\ActivityLogs\Pages\ManageActivityLogs;
use BackedEnum;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $modelLabel = 'Log Aktivitas';
    protected static ?string $pluralModelLabel = 'Log Aktivitas';
    protected static ?string $navigationLabel = 'Log Aktivitas';


    protected static ?string $recordTitleAttribute = 'description';

    protected static string | \UnitEnum | null $navigationGroup = NavigationGroup::Sistem;
    protected static ?int $navigationSort = 2;

    /**
     * ❌ Disable create
     */
    public static function canCreate(): bool
    {
        return false;
    }

    /**
     * ❌ Disable edit
     */
    public static function canEdit($record): bool
    {
        return false;
    }

    /**
     * ❌ Disable delete
     */
    public static function canDelete($record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('causer.name')
                    ->label('Pelaku')
                    ->placeholder('Sistem / Guest')
                    ->disabled(),

                TextInput::make('description')
                    ->label('Aktivitas')
                    ->disabled(),

                TextInput::make('subject_type')
                    ->label('Modul')
                    ->formatStateUsing(fn($state) => str_replace('App\\Models\\', '', $state ?? ''))
                    ->disabled(),

                KeyValue::make('properties')
                    ->label('Detail Perubahan')
                    ->disabled()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('causer.name')
                    ->label('Pelaku')
                    ->placeholder('Sistem / Guest')
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Aktivitas')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),

                TextColumn::make('subject_type')
                    ->label('Modul')
                    ->formatStateUsing(fn($state) => str_replace('App\\Models\\', '', $state ?? ''))
                    ->searchable(),

                TextColumn::make('properties')
                    ->label('Detail')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([]) // 🔥 no edit/delete
            ->bulkActions([]);  // 🔥 no bulk delete
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageActivityLogs::route('/'),
        ];
    }
}
